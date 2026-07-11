<?php

namespace App\Livewire;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Payment;
use App\Models\Watchlist;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class BidderDashboard extends Component
{
    use WithPagination;

    public $sort = 'newest';

    protected $queryString = ['sort'];

    public function setSort($sort)
    {
        $this->sort = $sort;
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();
        $userId = $user->id;

        // Stats
        $activeBidsCount = Bid::where('user_id', $userId)
            ->whereHas('auction', function ($query) {
                $query->where('status', '!=', 'closed')
                    ->where('end_time', '>', now());
            })
            ->distinct('auction_id')
            ->count('auction_id');

        $wonUnpaidCount = 0;
        $wonAuctions = Auction::whereHas('bids', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->where(function ($query) {
            $query->where('status', 'closed')
                ->orWhere('end_time', '<=', now());
        })
        ->with(['bids' => function ($query) {
            $query->orderBy('amount', 'desc');
        }])
        ->get();

        foreach ($wonAuctions as $auction) {
            $highestBid = $auction->bids->first();
            if ($highestBid && $highestBid->user_id === $userId) {
                $payment = Payment::where('auction_id', $auction->id)
                    ->where('user_id', $userId)
                    ->first();
                if (!$payment || $payment->status !== 'completed') {
                    $wonUnpaidCount++;
                }
            }
        }

        $stats = [
            'active_bids_count' => $activeBidsCount,
            'won_unpaid_count' => $wonUnpaidCount,
            'watchlist_count' => Watchlist::where('user_id', $userId)->count(),
            'total_spent' => Payment::where('user_id', $userId)
                ->where('status', 'completed')
                ->sum('amount'),
        ];

        // Build merged collection
        $allItems = collect();

        // Active Bids
        $biddedAuctionIds = Bid::where('user_id', $userId)
            ->pluck('auction_id')
            ->unique();

        $activeAuctions = Auction::whereIn('id', $biddedAuctionIds)
            ->where('status', '!=', 'closed')
            ->where('end_time', '>', now())
            ->with(['images', 'bids' => function ($query) {
                $query->orderBy('amount', 'desc');
            }])
            ->get();

        foreach ($activeAuctions as $auction) {
            $highestBid = $auction->bids->first();
            $userBid = $auction->bids->where('user_id', $userId)->first();

            if ($userBid) {
                $allItems->push([
                    'type' => 'active_bid',
                    'auction' => $auction,
                    'user_bid' => $userBid->amount,
                    'is_highest' => $highestBid && $highestBid->user_id === $userId,
                    'sort_date' => $auction->end_time,
                    'sort_price' => $userBid->amount,
                ]);
            }
        }

        // Won Auctions
        foreach ($wonAuctions as $auction) {
            $highestBid = $auction->bids->first();
            if ($highestBid && $highestBid->user_id === $userId) {
                $payment = Payment::where('auction_id', $auction->id)
                    ->where('user_id', $userId)
                    ->first();

                $allItems->push([
                    'type' => 'won',
                    'auction' => $auction,
                    'user_bid' => $highestBid->amount,
                    'is_highest' => true,
                    'payment' => $payment,
                    'needs_payment' => !$payment || $payment->status !== 'completed',
                    'sort_date' => $payment ? $payment->updated_at : $auction->end_time,
                    'sort_price' => $highestBid->amount,
                ]);
            }
        }

        // Watchlist
        $watchlistItems = Watchlist::where('user_id', $userId)
            ->with('auction.images')
            ->get();

        foreach ($watchlistItems as $wl) {
            $allItems->push([
                'type' => 'watchlist',
                'auction' => $wl->auction,
                'user_bid' => null,
                'is_highest' => false,
                'sort_date' => $wl->auction->end_time,
                'sort_price' => $wl->auction->current_price ?: $wl->auction->starting_price,
            ]);
        }

        // Sort
        $allItems = match ($this->sort) {
            'oldest' => $allItems->sortBy('sort_date'),
            'price_high' => $allItems->sortByDesc('sort_price'),
            'price_low' => $allItems->sortBy('sort_price'),
            default => $allItems->sortByDesc('sort_date'), // newest
        };

        // Paginate (15 per page)
        $page = request()->get('page', 1);
        $perPage = 15;
        $paginatedItems = new \Illuminate\Pagination\LengthAwarePaginator(
            $allItems->forPage($page, $perPage)->values(),
            $allItems->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Payment history (unchanged)
        $paymentHistory = Payment::where('user_id', $userId)
            ->with('auction')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.bidder-dashboard', [
            'stats' => $stats,
            'all_items' => $paginatedItems,
            'payment_history' => $paymentHistory,
        ]);
    }
}

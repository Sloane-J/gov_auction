<?php

namespace App\Livewire;

use App\Models\Auction;
use Livewire\Component;

class HomepageAuctions extends Component
{
    public function render()
    {
        $auctions = Auction::where('status', 'active')
            ->where('start_time', '<=', now())
            ->where('end_time', '>', now())
            ->with(['images', 'categories', 'bids'])
            ->get()
            ->groupBy(function ($auction) {
                return $auction->categories->first()->name ?? 'Uncategorized';
            });

        return view('livewire.homepage-auctions', [
            'auctionsByCategory' => $auctions,
        ]);
    }
}

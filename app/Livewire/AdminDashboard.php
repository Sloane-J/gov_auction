<?php

namespace App\Livewire;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Category;
use App\Models\Payment;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AdminDashboard extends Component
{
    use WithPagination;

    public $activeTab = 'overview';

    public $newCategoryName = '';

    // Overview Stats
    public $stats = [];

    public $categories = [];

    public $suspendingAuctionId = null;
    public $suspensionReason = '';

    public function mount()
    {
        $this->loadStats();
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = Category::withCount('auctions')->get();
    }

    public function createCategory()
    {
        $this->validate(['newCategoryName' => 'required|string|max:255|unique:categories,name']);
        Category::create(['name' => $this->newCategoryName]);
        $this->newCategoryName = '';
        $this->loadCategories();
        session()->flash('message', 'Category created successfully.');
    }

    public function deleteCategory($id)
    {
        Category::findOrFail($id)->delete();
        $this->loadCategories();
        session()->flash('message', 'Category deleted.');
    }

    public function loadStats()
    {
        $this->stats = [
            'total_users' => User::count(),
            'total_auctions' => Auction::count(),
            'active_auctions' => Auction::where('status', 'active')->count(),
            'total_bids' => Bid::count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
        ];
    }

    // User Management
    public function suspendUser($id)
    {
        if (auth()->id() === (int) $id) {
            session()->flash('message', 'You cannot suspend your own account.');
            return;
        }

        $user = User::findOrFail($id);

        // Updates status if column exists, otherwise soft deletes or adjusts based on your schema
        if (\Schema::hasColumn('users', 'status')) {
            $user->update(['status' => 'suspended']);
        } elseif (\Schema::hasColumn('users', 'is_suspended')) {
            $user->update(['is_suspended' => true]);
        } else {
            $user->delete();
        }

        $this->loadStats();
        session()->flash('message', "User {$user->name} suspended successfully.");
    }

    public function changeRole($id, $newRole)
    {
        $user = User::findOrFail($id);
        $user->update(['role' => $newRole]);
        session()->flash('message', 'User role updated.');
    }

    // Auction Moderation
    public function updateAuctionStatus($id, $status)
    {
        if ($status === 'suspended') {
            $this->suspendingAuctionId = $id;
            return;
        }

        $auction = Auction::findOrFail($id);
        $auction->update(['status' => $status, 'suspension_reason' => null]);
        $this->loadStats();
        session()->flash('message', "Auction status updated to {$status}.");
    }

    public function confirmSuspend()
    {
        $auction = Auction::findOrFail($this->suspendingAuctionId);
        $auction->update([
            'status' => 'suspended',
            'suspension_reason' => $this->suspensionReason ?: null,
        ]);
        $this->loadStats();
        $this->suspendingAuctionId = null;
        $this->suspensionReason = '';
        session()->flash('message', 'Auction suspended.');
    }

    public function cancelSuspend()
    {
        $this->suspendingAuctionId = null;
        $this->suspensionReason = '';
    }

    public function render()
    {
        return view('livewire.admin-dashboard', [
            'users' => User::latest()->paginate(10, ['*'], 'usersPage'),
            'auctions' => Auction::with('creator')->latest()->paginate(10, ['*'], 'auctionsPage'),
        ])->layout('layouts.app');
    }
}

<?php

use App\Livewire\Admin\BidMonitoring;
use App\Livewire\Admin\PaymentCheckout;
use App\Livewire\Admin\PaymentsOverview;
use App\Livewire\AdminDashboard;
use App\Livewire\AuctionDetails;
use App\Livewire\AuctionList;
use App\Livewire\BidderDashboard;
use App\Livewire\MyBids;
use App\Livewire\Notifications;
use App\Livewire\OfficerAnalytics;
use App\Livewire\OfficerAuctionManager;
use App\Livewire\PaymentHistory;
use App\Livewire\WatchlistManager;
use App\Models\Payment;
use Illuminate\Support\Facades\Route;

// Public routes
Route::view('/', 'welcome')->name('home');

Route::get('/auctions', AuctionList::class)->name('auctions.index');
Route::get('/auctions/{auction}', AuctionDetails::class)->name('auctions.show');

// Authenticated & verified user routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Dynamic dashboard based on user role
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'officer' => redirect()->route('officer.auctions'),
            default => app()->call(BidderDashboard::class),
        };
    })->name('dashboard');

    // Bidder-specific routes
    Route::get('/watchlist', WatchlistManager::class)->name('watchlist');
    Route::get('/my-bids', MyBids::class)->name('my-bids');
    Route::get('/payment/{auction}', PaymentCheckout::class)->name('payment.checkout');
    Route::get('/notifications', Notifications::class)->name('notifications');
    Route::get('/payment-history', PaymentHistory::class)->name('payment-history');

    // Payment receipt (with authorization check)
    Route::get('/receipt/{payment}', function (Payment $payment) {
        abort_if($payment->user_id !== auth()->id(), 403, 'Unauthorized access to receipt.');

        return view('receipt', compact('payment'));
    })->name('receipt.show');
});

// Admin-only routes
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', AdminDashboard::class)->name('dashboard');
        Route::get('/bids', BidMonitoring::class)->name('bids');
        Route::get('/payments', PaymentsOverview::class)->name('payments');
    });

// Officer-only routes
Route::middleware(['auth', 'verified', 'role:officer'])
    ->prefix('officer')
    ->name('officer.')
    ->group(function () {
        Route::get('/auctions', OfficerAuctionManager::class)->name('auctions');
        Route::get('/analytics', OfficerAnalytics::class)->name('analytics');
    });

require __DIR__ . '/settings.php';

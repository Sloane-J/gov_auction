<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    use WithPagination;

    public $perPage = 5;

    public function mount()
    {
        // No auto-mark as read on mount
    }

    public function loadMoreNotifications()
    {
        $this->perPage += 5;
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->where('id', $notificationId)->first();

        if ($notification && !$notification->read_at) {
            $notification->update(['read_at' => now()]);
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
    }

    public function render()
    {
        $user = Auth::user();

        return view('livewire.notifications', [
            'notifications' => $user->notifications()->latest()->take($this->perPage)->get(),
            'unreadCount' => $user->unreadNotifications()->count(),
        ]);
    }
}

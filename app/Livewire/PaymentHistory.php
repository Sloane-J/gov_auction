<?php

namespace App\Livewire;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentHistory extends Component
{
    use WithPagination;

    public function render()
    {
        $payments = Payment::where('user_id', Auth::id())
            ->with('auction')
            ->latest()
            ->paginate(15);

        return view('livewire.payment-history', [
            'payments' => $payments,
        ])->layout('layouts.app');
    }
}

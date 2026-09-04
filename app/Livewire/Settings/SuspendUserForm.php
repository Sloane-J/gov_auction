<?php

namespace App\Livewire\Settings;

use App\Concerns\PasswordValidationRules;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SuspendUserForm extends Component
{
    use PasswordValidationRules;

    public string $password = '';

    /**
     * Suspend the currently authenticated user account.
     */
    public function suspendUser(Logout $logout): void
    {
        $this->validate([
            'password' => $this->currentPasswordRules(),
        ]);

        $user = Auth::user();

        // Mark account as suspended
        $user->update([
            'suspended_at' => now(),
        ]);

        // Invalidate active session & logout
        $logout();

        $this->redirect('/login', navigate: true);
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.settings.suspend-user-form');
    }
}

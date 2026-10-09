<?php

namespace App\Livewire;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Login extends Component
{
    public string $username = '';

    public string $password = '';

    public function authenticate(): ?RedirectResponse
    {
        $this->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $this->username, 'password' => $this->password])) {
            session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        $this->addError('auth', 'The provided credentials do not match our records.');

        return null;
    }

    #[Url(as: 'f')]
    public ?string $formNanoid = null;

    public function render(): View
    {
        return view('livewire.login', [
            'formNanoid' => $this->formNanoid,
        ]);
    }
}

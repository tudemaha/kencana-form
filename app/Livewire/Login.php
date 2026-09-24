<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $username = '';

    public string $password = '';

    public function authenticate()
    {
        $this->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $this->username, 'password' => $this->password])) {
            session()->regenerate();

            return redirect()->intended('/');
        }

        $this->addError('auth', 'The provided credentials do not match our records.');
    }

    public function render()
    {
        return view('livewire.login')->layout('components.layouts.app');
    }
}

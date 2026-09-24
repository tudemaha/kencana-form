<?php

namespace App\Livewire;

use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public string $name = '';

    public string $username = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $school_id = '';

    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'school_id' => 'required|exists:schools,id',
        ]);

        $user = User::create([
            'name' => $this->name,
            'username' => $this->username,
            'password' => Hash::make($this->password),
            'role' => 'student',
            'school_id' => $this->school_id,
        ]);

        Auth::login($user);

        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.register', [
            'schools' => School::orderBy('name')->get(),
        ])->layout('components.layouts.app');
    }
}

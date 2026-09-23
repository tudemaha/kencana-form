<?php

namespace App\Livewire\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->autofocus(),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(),
            ])
            ->statePath('data');
    }

    public function authenticate()
    {
        $data = $this->form->getState();

        if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
            session()->regenerate();

            return redirect()->intended('/');
        }

        $this->addError('data.username', 'The provided credentials do not match our records.');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.app');
    }
}

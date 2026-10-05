<?php

namespace App\Livewire;

use App\Models\School;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Register extends Component
{
    public string $name = '';

    public string $username = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $school_id = '';

    public function register(): RedirectResponse
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $form = \App\Models\Form::where('school_id', $this->school_id)
                        ->where('is_active', true)
                        ->latest()
                        ->first();

                    if ($form) {
                        $partnerQuestion = $form->questions()->where('type', 'room_partner')->first();
                        
                        if ($partnerQuestion) {
                            $choices = (array) $partnerQuestion->choices;
                            
                            $isValidName = collect($choices)->contains(function ($choice) use ($value) {
                                // Expected format: <class> | <full name> | <L/P>
                                $parts = explode('|', $choice);
                                $nameInList = isset($parts[1]) ? trim($parts[1]) : trim($choice);
                                
                                return strtolower($nameInList) === strtolower(trim($value));
                            });

                            if (! $isValidName) {
                                $fail('Your name is not registered to the system. Ensure you use the full name registered with the school.');
                            }
                        }
                    }
                },
            ],
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

        session()->flash('success', 'Registration successful! Please ask your school admin for your specific form link.');

        return redirect()->intended(route('dashboard'));
    }

    public function render(): View
    {
        return view('livewire.register', [
            'schools' => School::where('is_active', true)
                ->whereDoesntHave('users', function ($query) {
                    $query->where('role', 'admin');
                })->orderBy('name')->get(),
        ]);
    }
}

<?php

namespace App\Livewire;

use App\Enums\Gender;
use App\Models\Form;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Register extends Component
{
    public string $name = '';

    public ?Gender $gender = null;

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
                    $form = Form::where('school_id', $this->school_id)
                        ->where('is_active', true)
                        ->latest()
                        ->first();

                    if ($form) {
                        $partnerQuestion = $form->questions()->where('type', 'room_partner')->first();

                        if ($partnerQuestion) {
                            $choices = (array) $partnerQuestion->choices;

                            $matchedChoice = collect($choices)->first(function ($choice) use ($value) {
                                // Expected format: <class> | <full name> | <L/P>
                                $parts = explode('|', $choice);
                                $nameInList = isset($parts[1]) ? trim($parts[1]) : trim($choice);

                                return strtolower($nameInList) === strtolower(trim($value));
                            });

                            if (! $matchedChoice) {
                                $fail('Your name is not registered to the system. Ensure you use the full name registered with the school.');
                            } else {
                                $parts = explode('|', $matchedChoice);
                                $genderInList = isset($parts[2]) ? trim($parts[2]) : null;

                                if ($genderInList && strtoupper($genderInList) !== $this->gender?->value) {
                                    $fail('The selected gender does not match the school\'s passenger list data.');
                                }
                            }
                        }
                    }
                },
            ],
            'gender' => ['required', Rule::enum(Gender::class)],
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'school_id' => 'required|exists:schools,id',
        ]);

        $user = User::create([
            'name' => $this->name,
            'gender' => $this->gender,
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

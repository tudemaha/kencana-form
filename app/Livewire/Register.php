<?php

namespace App\Livewire;

use App\Enums\Gender;
use App\Models\Form;
use App\Models\FormAnswer;
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

                            $matchedChoices = collect($choices)->filter(function ($choice) use ($value) {
                                // Expected format: <class> | <full name> | <L/P>
                                $parts = explode('|', $choice);
                                $nameInList = isset($parts[1]) ? trim($parts[1]) : trim($choice);

                                return strtolower($nameInList) === strtolower(trim($value));
                            });

                            if ($matchedChoices->isEmpty()) {
                                $fail('Your name is not registered to the system. Ensure you use the full name registered with the school.');
                            } else {
                                $validAndAvailable = $matchedChoices->first(function ($choice) use ($partnerQuestion, $choices) {
                                    $parts = explode('|', $choice);
                                    $genderInList = isset($parts[2]) ? trim($parts[2]) : null;

                                    if ($genderInList && strtoupper($genderInList) !== $this->gender?->value) {
                                        return false;
                                    }

                                    $pickedCount = FormAnswer::where('question_id', $partnerQuestion->id)
                                        ->pluck('answer')
                                        ->flatten()
                                        ->filter(fn ($ans) => $ans === $choice)
                                        ->count();

                                    $totalInChoices = collect($choices)
                                        ->filter(fn ($c) => $c === $choice)
                                        ->count();

                                    return $pickedCount < $totalInChoices;
                                });

                                if (! $validAndAvailable) {
                                    $hasRightGender = $matchedChoices->contains(function ($choice) {
                                        $parts = explode('|', $choice);
                                        $genderInList = isset($parts[2]) ? trim($parts[2]) : null;

                                        return ! $genderInList || strtoupper($genderInList) === $this->gender?->value;
                                    });

                                    if (! $hasRightGender) {
                                        $fail('The selected gender does not match the school\'s passenger list data.');
                                    } else {
                                        $roommates = [];

                                        $answers = FormAnswer::where('question_id', $partnerQuestion->id)->get();

                                        foreach ($matchedChoices as $matchedChoice) {
                                            $matchingAnswers = $answers->filter(function ($ans) use ($matchedChoice) {
                                                return in_array($matchedChoice, (array) $ans->answer);
                                            });

                                            foreach ($matchingAnswers as $ans) {
                                                $others = array_diff((array) $ans->answer, [$matchedChoice]);
                                                foreach ($others as $other) {
                                                    $parts = explode('|', $other);
                                                    $roommates[] = isset($parts[1]) ? trim($parts[1]) : trim($other);
                                                }
                                            }
                                        }

                                        if (! empty($roommates)) {
                                            $namesStr = implode(', ', array_unique($roommates));
                                            $fail("Your name has already been selected. You are grouped with: {$namesStr}. You do not need to register.");
                                        } else {
                                            $fail('Your name has already been selected. You do not need to register.');
                                        }
                                    }
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

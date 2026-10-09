<?php

namespace App\Livewire;

use App\Models\Form as KencanaForm;
use App\Models\FormAnswer;
use App\Models\FormQuestion;
use App\Models\FormSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class FormShow extends Component
{
    public string $nanoid = '';

    public ?KencanaForm $formRecord = null;

    /** @var array<string, mixed> */
    public array $data = [];

    public ?string $submissionId = null;

    public bool $isForbidden = false;

    public function mount(string $nanoid): void
    {
        $this->nanoid = $nanoid;
        $this->formRecord = KencanaForm::where('nanoid', $nanoid)
            ->with(['questions' => fn ($q) => $q->orderBy('order')])
            ->firstOrFail();

        if (! $this->formRecord->is_active) {
            abort(404, 'Form is no longer active.');
        }

        $existingSubmission = null;
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin' && Auth::user()->school_id !== $this->formRecord->school_id) {
                $this->isForbidden = true;

                return;
            }

            $existingSubmission = FormSubmission::where('user_id', Auth::id())
                ->where('form_id', $this->formRecord->id)
                ->with('answers')
                ->first();

            if ($existingSubmission) {
                $this->submissionId = $existingSubmission->id;
            }
        }

        // Initialize answers array for data binding
        $initialData = [];
        foreach ($this->formRecord->questions as $question) {
            if ($existingSubmission) {
                $answerRecord = $existingSubmission->answers->firstWhere('question_id', $question->id);
                /** @var mixed $val */
                $val = $answerRecord ? $answerRecord->answer : null;

                if (in_array($question->type, ['checkbox', 'room_partner'])) {
                    $initialData[$question->id] = is_array($val) ? $val : [];
                } else {
                    $initialData[$question->id] = is_array($val) ? ($val[0] ?? '') : ($val ?? '');
                }
            } else {
                $initialData[$question->id] = in_array($question->type, ['checkbox', 'room_partner']) ? [] : '';
            }
        }

        $this->data = $initialData;
    }

    public function save(): void
    {
        if (! Auth::check()) {
            $this->addError('general', 'You must be logged in to submit this form.');

            return;
        }

        // Validation
        $rules = [];
        foreach ($this->formRecord->questions as $question) {
            if ($question->type === 'room_partner') {
                $rules['data.'.$question->id] = 'required|array|min:1|max:4';
            } elseif ($question->type === 'checkbox') {
                $rules['data.'.$question->id] = 'required|array|min:1';
            } else {
                $rules['data.'.$question->id] = 'required';
            }
        }

        $messages = [
            'required' => 'This field is required.',
            'min' => 'You must select at least one option.',
            'max' => 'You can only select up to :max partners.',
        ];

        $this->validate($rules, $messages);

        DB::transaction(function () {
            $submission = FormSubmission::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'form_id' => $this->formRecord->id,
                ],
                [
                    'submitted_at' => now(),
                ]
            );

            $this->submissionId = $submission->id;

            foreach ($this->formRecord->questions as $question) {
                $answerValue = $this->data[$question->id] ?? null;

                // Ensure arrays for JSON column
                if (! is_array($answerValue)) {
                    $answerValue = [$answerValue];
                }

                FormAnswer::updateOrCreate(
                    [
                        'submission_id' => $submission->id,
                        'question_id' => $question->id,
                    ],
                    [
                        'answer' => $answerValue,
                    ]
                );
            }
        });

        session()->flash('message', 'Your form has been successfully saved!');
    }

    /** @return array<int|string, mixed> */
    public function getAvailablePartners(FormQuestion $question): array
    {
        $choices = (array) $question->choices;

        $query = FormAnswer::where('question_id', $question->id);

        // Exclude current user's pick so they can see their own partner in the list!
        if ($this->submissionId) {
            $query->where('submission_id', '!=', $this->submissionId);
        }

        $pickedNames = $query
            ->pluck('answer')
            ->flatten()
            ->toArray();

        $available = [];
        foreach ($choices as $choice) {
            $pickedIndex = array_search($choice, $pickedNames);
            if ($pickedIndex !== false) {
                unset($pickedNames[$pickedIndex]);

                continue;
            }

            $userGender = Auth::user()?->gender;

            if ($userGender) {
                $parts = explode('|', $choice);
                if (isset($parts[2])) {
                    $choiceGender = trim($parts[2]);
                    if (strtoupper($choiceGender) !== strtoupper($userGender->value)) {
                        continue;
                    }
                }
            }

            $available[] = $choice;
        }

        return $available;
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }

    public function redirectToLogin(): RedirectResponse
    {
        return redirect()->route('login', ['f' => $this->formRecord->nanoid]);
    }

    public function render(): View
    {
        return view('livewire.form-show');
    }
}

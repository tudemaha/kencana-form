<?php

namespace App\Livewire;

use App\Models\Form as KencanaForm;
use App\Models\FormAnswer;
use App\Models\FormSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FormShow extends Component
{
    public string $nanoid = '';

    public ?KencanaForm $formRecord = null;

    public array $data = [];

    public ?string $submissionId = null;

    public function mount($nanoid)
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
                $val = $answerRecord ? $answerRecord->answer : null;

                if ($question->type === 'checkbox') {
                    $initialData[$question->id] = is_array($val) ? $val : [];
                } else {
                    $initialData[$question->id] = is_array($val) ? ($val[0] ?? '') : ($val ?? '');
                }
            } else {
                $initialData[$question->id] = $question->type === 'checkbox' ? [] : '';
            }
        }

        $this->data = $initialData;
    }

    public function save()
    {
        if (! Auth::check()) {
            $this->addError('general', 'You must be logged in to submit this form.');

            return;
        }

        // Validation
        $rules = [];
        foreach ($this->formRecord->questions as $question) {
            $rules['data.'.$question->id] = 'required';
            if ($question->type === 'checkbox') {
                $rules['data.'.$question->id] = 'required|array|min:1';
            }
        }

        $messages = [
            'required' => 'This field is required.',
            'min' => 'You must select at least one option.',
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

    public function getAvailablePartners($question)
    {
        $choices = is_array($question->choices) ? $question->choices : [];

        $query = FormAnswer::where('question_id', $question->id);

        // Exclude current user's pick so they can see their own partner in the list!
        if ($this->submissionId) {
            $query->where('submission_id', '!=', $this->submissionId);
        }

        $pickedNames = $query->get()
            ->pluck('answer')
            ->flatten()
            ->unique()
            ->toArray();

        return array_filter($choices, function ($choice) use ($pickedNames) {
            return ! in_array($choice, $pickedNames);
        });
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }

    public function redirectToLogin()
    {
        session()->put('url.intended', route('forms.show', $this->formRecord->nanoid));
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.form-show')->layout('components.layouts.app');
    }
}

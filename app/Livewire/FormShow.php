<?php

namespace App\Livewire;

use App\Models\Form;
use App\Models\FormAnswer;
use App\Models\FormSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FormShow extends Component
{
    public string $nanoid = '';

    public ?Form $form = null;

    public array $answers = [];

    public ?string $submissionId = null;

    public function mount($nanoid)
    {
        $this->nanoid = $nanoid;
        $this->form = Form::where('nanoid', $nanoid)
            ->with(['questions' => fn ($q) => $q->orderBy('order')])
            ->firstOrFail();

        if (! $this->form->is_active) {
            abort(404, 'Form is no longer active.');
        }

        $existingSubmission = null;
        if (Auth::check()) {
            $existingSubmission = FormSubmission::where('user_id', Auth::id())
                ->where('form_id', $this->form->id)
                ->with('answers')
                ->first();

            if ($existingSubmission) {
                $this->submissionId = $existingSubmission->id;
            }
        }

        // Initialize answers array for data binding
        foreach ($this->form->questions as $question) {
            if ($existingSubmission) {
                $answerRecord = $existingSubmission->answers->firstWhere('question_id', $question->id);
                $val = $answerRecord ? $answerRecord->answer : null;

                // If it's a single value (not an array) but stored as array JSON, extract it
                if ($question->type === 'checkbox') {
                    $this->answers[$question->id] = is_array($val) ? $val : [];
                } else {
                    $this->answers[$question->id] = is_array($val) ? ($val[0] ?? '') : ($val ?? '');
                }
            } else {
                $this->answers[$question->id] = $question->type === 'checkbox' ? [] : '';
            }
        }
    }

    public function submit()
    {
        if (! Auth::check()) {
            $this->addError('general', 'You must be logged in to submit this form.');

            return;
        }

        $rules = [];
        $messages = [];
        foreach ($this->form->questions as $question) {
            $rules["answers.{$question->id}"] = 'required';
            $messages["answers.{$question->id}.required"] = 'This field is required.';
        }

        $this->validate($rules, $messages);

        DB::transaction(function () {
            $submission = FormSubmission::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'form_id' => $this->form->id,
                ],
                [
                    'submitted_at' => now(),
                ]
            );

            $this->submissionId = $submission->id;

            foreach ($this->form->questions as $question) {
                $answerValue = $this->answers[$question->id];

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

    public function render()
    {
        return view('livewire.form-show')->layout('components.layouts.app');
    }
}

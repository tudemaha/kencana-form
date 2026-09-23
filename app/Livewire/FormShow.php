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

    public bool $alreadySubmitted = false;

    public function mount($nanoid)
    {
        $this->nanoid = $nanoid;
        $this->form = Form::where('nanoid', $nanoid)
            ->with(['questions' => fn ($q) => $q->orderBy('order')])
            ->firstOrFail();

        if (! $this->form->is_active) {
            abort(404, 'Form is no longer active.');
        }

        // If user is logged in, check if they already submitted
        if (Auth::check()) {
            $this->alreadySubmitted = FormSubmission::where('user_id', Auth::id())
                ->where('form_id', $this->form->id)
                ->exists();
        }

        // Initialize answers array for data binding
        foreach ($this->form->questions as $question) {
            $this->answers[$question->id] = $question->type === 'checkbox' ? [] : '';
        }
    }

    public function submit()
    {
        if (! Auth::check()) {
            $this->addError('general', 'You must be logged in to submit this form.');

            return;
        }

        if ($this->alreadySubmitted) {
            $this->addError('general', 'You have already submitted this form.');

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
            $submission = FormSubmission::create([
                'user_id' => Auth::id(),
                'form_id' => $this->form->id,
                'submitted_at' => now(),
            ]);

            foreach ($this->form->questions as $question) {
                $answerValue = $this->answers[$question->id];

                // Ensure arrays for JSON column
                if (! is_array($answerValue)) {
                    $answerValue = [$answerValue];
                }

                FormAnswer::create([
                    'submission_id' => $submission->id,
                    'question_id' => $question->id,
                    'answer' => $answerValue,
                ]);
            }
        });

        $this->alreadySubmitted = true;
        session()->flash('message', 'Your form has been successfully submitted!');
    }

    public function getAvailablePartners($question)
    {
        $choices = is_array($question->choices) ? $question->choices : [];

        $pickedNames = FormAnswer::where('question_id', $question->id)
            ->get()
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

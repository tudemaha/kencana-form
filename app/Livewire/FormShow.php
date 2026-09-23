<?php

namespace App\Livewire;

use App\Models\Form as KencanaForm;
use App\Models\FormAnswer;
use App\Models\FormSubmission;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FormShow extends Component implements HasForms
{
    use InteractsWithForms;

    public string $nanoid = '';

    public ?KencanaForm $formRecord = null;

    public ?array $data = [];

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

                // If it's a single value (not an array) but stored as array JSON, extract it
                if ($question->type === 'checkbox') {
                    $initialData[$question->id] = is_array($val) ? $val : [];
                } else {
                    $initialData[$question->id] = is_array($val) ? ($val[0] ?? '') : ($val ?? '');
                }
            } else {
                $initialData[$question->id] = $question->type === 'checkbox' ? [] : '';
            }
        }

        $this->form->fill($initialData);
    }

    public function form(Schema $schema): Schema
    {
        $components = [];

        if ($this->formRecord) {
            foreach ($this->formRecord->questions as $question) {
                switch ($question->type) {
                    case 'text':
                        $components[] = TextInput::make($question->id)
                            ->label($question->question)
                            ->required();
                        break;

                    case 'textarea':
                        $components[] = Textarea::make($question->id)
                            ->label($question->question)
                            ->rows(3)
                            ->required();
                        break;

                    case 'dropdown':
                        $components[] = Select::make($question->id)
                            ->label($question->question)
                            ->options(
                                is_array($question->choices)
                                    ? array_combine($question->choices, $question->choices)
                                    : []
                            )
                            ->searchable()
                            ->required();
                        break;

                    case 'room_partner':
                        $available = $this->getAvailablePartners($question);
                        $components[] = Select::make($question->id)
                            ->label($question->question)
                            ->options(array_combine($available, $available))
                            ->searchable()
                            ->required()
                            ->helperText(empty($available) ? 'All partners have been picked.' : null);
                        break;

                    case 'radio':
                        $components[] = Radio::make($question->id)
                            ->label($question->question)
                            ->options(
                                is_array($question->choices)
                                    ? array_combine($question->choices, $question->choices)
                                    : []
                            )
                            ->required();
                        break;

                    case 'checkbox':
                        $components[] = CheckboxList::make($question->id)
                            ->label($question->question)
                            ->options(
                                is_array($question->choices)
                                    ? array_combine($question->choices, $question->choices)
                                    : []
                            )
                            ->required();
                        break;
                }
            }
        }

        return $schema
            ->schema($components)
            ->statePath('data');
    }

    public function save()
    {
        if (! Auth::check()) {
            $this->addError('general', 'You must be logged in to submit this form.');

            return;
        }

        $state = $this->form->getState();

        DB::transaction(function () use ($state) {
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
                $answerValue = $state[$question->id] ?? null;

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

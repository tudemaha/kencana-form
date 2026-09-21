<?php

namespace App\Filament\Resources\Forms\RelationManagers;

use App\Models\Form;
use App\Models\FormSubmission;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'submissions';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('Student'),
                TextEntry::make('submitted_at')
                    ->label('Submitted At')
                    ->dateTime(),
                RepeatableEntry::make('answers')
                    ->label('Answers')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('question.question')
                            ->label('Question'),
                        TextEntry::make('answer')
                            ->label('Answer')
                            ->formatStateUsing(fn ($state) => is_array($state)
                                ? implode(', ', array_map(
                                    fn ($item) => is_array($item) ? ($item['name'] ?? json_encode($item)) : $item,
                                    $state
                                ))
                                : $state),
                    ])
                    ->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user_id')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('answers_count')
                    ->label('Answers')
                    ->counts('answers')
                    ->sortable(),
                TextColumn::make('submitted_at')
                    ->label('Submitted At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->headerActions([
                Action::make('exportAll')
                    ->label('Export All as PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        /** @var Form $form */
                        $form = $this->getOwnerRecord();
                        $submissions = $form->submissions()
                            ->with(['user', 'answers.question'])
                            ->get();
                        $questions = $form->questions()->orderBy('order')->get();

                        $pdf = Pdf::loadView('pdf.submissions-all', compact('form', 'submissions', 'questions'))
                            ->setPaper('a4', 'landscape');

                        return response()->streamDownload(
                            fn () => print ($pdf->output()),
                            "{$form->nanoid}-submissions.pdf"
                        );
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('exportPdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('gray')
                    ->action(function (FormSubmission $record) {
                        $form = $this->getOwnerRecord();
                        $submission = $record->load(['user', 'answers.question']);

                        $pdf = Pdf::loadView('pdf.submission-detail', compact('form', 'submission'))
                            ->setPaper('a4');

                        return response()->streamDownload(
                            fn () => print ($pdf->output()),
                            "{$form->nanoid}-{$submission->user->username}.pdf"
                        );
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

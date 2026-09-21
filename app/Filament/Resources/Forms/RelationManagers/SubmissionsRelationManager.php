<?php

namespace App\Filament\Resources\Forms\RelationManagers;

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
            ->filters([
                //
            ])
            ->headerActions([])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

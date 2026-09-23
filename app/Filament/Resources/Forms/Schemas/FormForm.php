<?php

namespace App\Filament\Resources\Forms\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FormForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('is_active')
                    ->label('Active')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('title')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->columnSpanFull(),
                DatePicker::make('tour_date'),
                Select::make('school_id')
                    ->relationship('school', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Repeater::make('questions')
                    ->relationship('questions')
                    ->label('Questions')
                    ->columnSpanFull()
                    ->reorderable()
                    ->reorderableWithDragAndDrop()
                    ->orderColumn('order')
                    ->addActionLabel('Add Question')
                    ->collapsible()
                    ->schema([
                        TextInput::make('question')
                            ->label('Question')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('type')
                            ->label('Type')
                            ->options([
                                'text' => 'Short Text',
                                'textarea' => 'Long Text',
                                'radio' => 'Multiple Choice (Single)',
                                'checkbox' => 'Multiple Choice (Multi)',
                                'dropdown' => 'Dropdown',
                                'room_partner' => 'Room Partner (Unique)',
                            ])
                            ->required()
                            ->live(),
                        Textarea::make('choices')
                            ->label('Choices (one per line)')
                            ->helperText(
                                'For dropdown/room partner: each line is an option. '
                            )
                            ->visible(fn ($get) => in_array($get('type'), ['radio', 'checkbox', 'dropdown', 'room_partner']))
                            ->afterStateHydrated(function ($component, $state) {
                                if (is_array($state)) {
                                    $component->state(implode("\n", $state));
                                }
                            })
                            ->dehydrateStateUsing(function ($state) {
                                if (blank($state)) {
                                    return null;
                                }

                                return array_filter(
                                    array_map('trim', explode("\n", $state))
                                );
                            })
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}

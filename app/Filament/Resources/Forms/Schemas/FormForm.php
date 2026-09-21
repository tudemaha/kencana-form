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
                Toggle::make('is_active')
                    ->label('Active')
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
                                'room_partner' => 'Room Partner',
                            ])
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($set) => $set('choices', null)),

                        // For standard choice-based types: one option per line
                        Textarea::make('choices')
                            ->label('Choices (one per line)')
                            ->helperText('Enter each option on a new line.')
                            ->visible(fn ($get) => in_array($get('type'), ['radio', 'checkbox', 'dropdown']))
                            ->afterStateHydrated(function ($component, $state) {
                                if (is_array($state)) {
                                    // Simple string array (e.g. dropdown options)
                                    $isSimple = array_values($state) === $state && ! isset($state[0]['name']);
                                    if ($isSimple) {
                                        $component->state(implode("\n", $state));
                                    }
                                }
                            })
                            ->dehydrateStateUsing(function ($state) {
                                if (blank($state)) {
                                    return null;
                                }

                                return array_values(array_filter(
                                    array_map('trim', explode("\n", $state))
                                ));
                            })
                            ->columnSpanFull(),

                        // For room_partner type: admin defines the student list with name + picked status
                        Repeater::make('choices')
                            ->label('Room Partner List')
                            ->helperText('Add each student who can be selected as a room partner. "Picked" means they are already paired.')
                            ->visible(fn ($get) => $get('type') === 'room_partner')
                            ->columnSpanFull()
                            ->addActionLabel('Add Student')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Student Name')
                                    ->required(),
                                Toggle::make('picked')
                                    ->label('Picked')
                                    ->default(false)
                                    ->helperText('Mark as picked if already paired.'),
                            ])
                            ->columns(2)
                            ->defaultItems(0),
                    ])
                    ->columns(2),
            ]);
    }
}

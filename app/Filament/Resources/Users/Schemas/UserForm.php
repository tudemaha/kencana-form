<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\Gender;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('username')
                    ->required(),
                Select::make('gender')
                    ->options(Gender::class)
                    ->nullable(),
                TextInput::make('password')
                    ->password()
                    ->required(),
                Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'student' => 'Student',
                    ])
                    ->required()
                    ->default('student'),
                Select::make('school_id')
                    ->relationship('school', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}

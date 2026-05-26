<?php

namespace App\Filament\Resources\Education\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class EducationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('institution_name')
                        ->required()
                        ->maxLength(200)
                        ->columnSpanFull(),

                    TextInput::make('degree')
                        ->required()
                        ->maxLength(200),

                    TextInput::make('field_of_study')
                        ->maxLength(200),

                    TextInput::make('start_year')
                        ->numeric()
                        ->minValue(1900)
                        ->maxValue(2100),

                    TextInput::make('end_year')
                        ->numeric()
                        ->minValue(1900)
                        ->maxValue(2100),

                    TextInput::make('display_order')
                        ->numeric()
                        ->default(0),

                    Textarea::make('description')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
            ]);
    }
}

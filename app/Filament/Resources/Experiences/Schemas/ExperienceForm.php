<?php

namespace App\Filament\Resources\Experiences\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('company_name')
                        ->required()
                        ->maxLength(200),

                    TextInput::make('role')
                        ->required()
                        ->maxLength(200),

                    DatePicker::make('start_date')
                        ->required(),

                    DatePicker::make('end_date')
                        ->hidden(fn ($get) => $get('is_current')),

                    Toggle::make('is_current')
                        ->label('Currently working here')
                        ->live()
                        ->columnSpanFull(),

                    TextInput::make('display_order')
                        ->numeric()
                        ->default(0),

                    FileUpload::make('company_logo')
                        ->image()
                        ->disk('portfolio')
                        ->visibility('public')
                        ->directory('experience/logos'),

                    Textarea::make('description')
                        ->rows(4)
                        ->columnSpanFull(),
                ]),
            ]);
    }
}

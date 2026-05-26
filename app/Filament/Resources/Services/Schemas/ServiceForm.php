<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(200)
                        ->columnSpanFull(),

                    TextInput::make('icon')
                        ->label('Icon (emoji)')
                        ->maxLength(10),

                    TextInput::make('display_order')
                        ->numeric()
                        ->default(0),

                    Textarea::make('description')
                        ->required()
                        ->rows(3)
                        ->columnSpanFull(),

                    Toggle::make('is_featured')
                        ->label('Featured on homepage'),
                ]),
            ]);
    }
}

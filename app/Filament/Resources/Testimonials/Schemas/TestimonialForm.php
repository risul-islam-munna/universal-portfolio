<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('client_name')
                        ->required()
                        ->maxLength(150),

                    TextInput::make('designation')
                        ->maxLength(150),

                    TextInput::make('company')
                        ->maxLength(150),

                    Select::make('rating')
                        ->required()
                        ->options([
                            1 => '★ 1',
                            2 => '★★ 2',
                            3 => '★★★ 3',
                            4 => '★★★★ 4',
                            5 => '★★★★★ 5',
                        ])
                        ->default(5),

                    FileUpload::make('avatar')
                        ->image()
                        ->disk('public')
                        ->visibility('public')
                        ->directory('testimonials/avatars'),

                    TextInput::make('display_order')
                        ->numeric()
                        ->default(0),

                    Textarea::make('message')
                        ->required()
                        ->rows(4)
                        ->columnSpanFull(),

                    Toggle::make('is_active')
                        ->label('Show on site')
                        ->default(true),
                ]),
            ]);
    }
}

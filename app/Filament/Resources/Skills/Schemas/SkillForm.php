<?php

namespace App\Filament\Resources\Skills\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class SkillForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(100),

                    Select::make('category')
                        ->required()
                        ->options([
                            'Backend' => 'Backend',
                            'Frontend' => 'Frontend',
                            'Mobile' => 'Mobile',
                            'DevOps' => 'DevOps',
                            'Cloud' => 'Cloud',
                            'Database' => 'Database',
                            'AI' => 'AI',
                            'Other' => 'Other',
                        ]),

                    TextInput::make('icon')
                        ->label('Icon (emoji or class)')
                        ->maxLength(50),

                    TextInput::make('proficiency')
                        ->label('Proficiency (%)')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->suffix('%')
                        ->default(80),

                    TextInput::make('display_order')
                        ->label('Display Order')
                        ->numeric()
                        ->default(0),
                ]),
            ]);
    }
}

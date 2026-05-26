<?php

namespace App\Filament\Resources\Themes\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ThemeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Theme Info')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(100)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state ?? ''))),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(100),

                        Toggle::make('is_active')
                            ->label('Active theme'),
                    ]),
                ]),

                Section::make('Colors')->schema([
                    Grid::make(2)->schema([
                        ColorPicker::make('config.primary')
                            ->label('Primary Color'),

                        ColorPicker::make('config.secondary')
                            ->label('Secondary Color'),

                        ColorPicker::make('config.accent')
                            ->label('Accent Color'),

                        ColorPicker::make('config.bg')
                            ->label('Background Color'),

                        ColorPicker::make('config.surface')
                            ->label('Surface Color'),

                        ColorPicker::make('config.text')
                            ->label('Text Color'),

                        ColorPicker::make('config.muted')
                            ->label('Muted Text Color'),

                        ColorPicker::make('config.border')
                            ->label('Border Color'),
                    ]),
                ]),
            ]);
    }
}

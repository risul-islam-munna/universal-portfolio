<?php

namespace App\Filament\Resources\Themes\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ThemeForm
{
    /**
     * Theme packages available in the frontend registry.
     * Add new entries here as theme packages are installed.
     *
     * @return array<string, string>
     */
    public static function availableComponents(): array
    {
        return [
            'default' => 'Default (Developer Portfolio)',
            // 'photographer' => 'Photographer Portfolio',
        ];
    }

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

                        Select::make('component')
                            ->label('Theme Package')
                            ->helperText('Which frontend design package this theme uses.')
                            ->options(static::availableComponents())
                            ->default('default')
                            ->required()
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Active theme')
                            ->columnSpanFull(),
                    ]),
                ]),

                Section::make('Colour Overrides')
                    ->description('Override the theme package\'s default colours. Leave blank to use the package defaults.')
                    ->schema([
                        Grid::make(2)->schema([
                            ColorPicker::make('config.primary')
                                ->label('Primary'),

                            ColorPicker::make('config.secondary')
                                ->label('Secondary'),

                            ColorPicker::make('config.accent')
                                ->label('Accent'),

                            ColorPicker::make('config.bg')
                                ->label('Background'),

                            ColorPicker::make('config.surface')
                                ->label('Surface'),

                            ColorPicker::make('config.text')
                                ->label('Text'),

                            ColorPicker::make('config.muted')
                                ->label('Muted Text'),

                            ColorPicker::make('config.border')
                                ->label('Border'),
                        ]),
                    ]),
            ]);
    }
}

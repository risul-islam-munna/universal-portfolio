<?php

namespace App\Filament\Resources\BusinessHighlights;

use App\Filament\Resources\BusinessHighlights\Pages\ManageBusinessHighlights;
use App\Models\BusinessHighlight;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BusinessHighlightResource extends Resource
{
    protected static ?string $model = BusinessHighlight::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;

    protected static ?string $navigationLabel = 'Business Highlight';

    protected static string|\UnitEnum|null $navigationGroup = 'Portfolio Content';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Business Info')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(200),

                        TextInput::make('tagline')
                            ->maxLength(300),

                        TextInput::make('website_url')
                            ->label('Website URL')
                            ->url()
                            ->maxLength(500),

                        TextInput::make('app_store_link')
                            ->label('App Store Link')
                            ->url()
                            ->maxLength(500),

                        TextInput::make('play_store_link')
                            ->label('Play Store Link')
                            ->url()
                            ->maxLength(500),

                        Textarea::make('description')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
                ]),

                Section::make('Features')->schema([
                    Repeater::make('features')
                        ->schema([
                            TextInput::make('title')
                                ->required()
                                ->maxLength(200),
                            TextInput::make('description')
                                ->required()
                                ->maxLength(500),
                        ])
                        ->columns(2)
                        ->reorderable()
                        ->collapsible(),
                ]),

                Section::make('Screenshots')->schema([
                    FileUpload::make('screenshots')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->disk('portfolio')
                        ->visibility('public')
                        ->directory('business/screenshots'),

                    FileUpload::make('logo')
                        ->label('Business Logo')
                        ->image()
                        ->disk('portfolio')
                        ->visibility('public')
                        ->directory('business'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('tagline')->limit(60),
                TextColumn::make('website_url')->label('Website'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageBusinessHighlights::route('/'),
        ];
    }
}

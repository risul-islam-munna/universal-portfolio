<?php

namespace App\Filament\Resources\AboutSections;

use App\Filament\Resources\AboutSections\Pages\ManageAboutSections;
use App\Models\AboutSection;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AboutSectionResource extends Resource
{
    protected static ?string $model = AboutSection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    protected static ?string $navigationLabel = 'About Section';

    protected static string|\UnitEnum|null $navigationGroup = 'Portfolio Content';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Bio')->schema([
                    Textarea::make('bio')
                        ->required()
                        ->rows(5)
                        ->columnSpanFull(),
                ]),

                Section::make('Statistics')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('years_experience')
                            ->label('Years of Experience')
                            ->numeric()
                            ->minValue(0),

                        TextInput::make('projects_completed')
                            ->numeric()
                            ->minValue(0),

                        TextInput::make('clients_served')
                            ->numeric()
                            ->minValue(0),

                        TextInput::make('technologies_used')
                            ->numeric()
                            ->minValue(0),
                    ]),
                ]),

                Section::make('Media')->schema([
                    FileUpload::make('profile_photo')
                        ->image()
                        ->disk('public')
                        ->visibility('public')
                        ->directory('about'),

                    FileUpload::make('cv_file')
                        ->label('CV / Resume (PDF)')
                        ->acceptedFileTypes(['application/pdf'])
                        ->disk('public')
                        ->visibility('public')
                        ->directory('about'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('years_experience')->label('Years Exp.'),
                TextColumn::make('projects_completed')->label('Projects'),
                TextColumn::make('clients_served')->label('Clients'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAboutSections::route('/'),
        ];
    }
}

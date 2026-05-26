<?php

namespace App\Filament\Resources\HeroSections;

use App\Filament\Resources\HeroSections\Pages\ManageHeroSections;
use App\Models\HeroSection;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HeroSectionResource extends Resource
{
    protected static ?string $model = HeroSection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $navigationLabel = 'Hero Section';

    protected static string|\UnitEnum|null $navigationGroup = 'Portfolio Content';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identity')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(200),

                        TextInput::make('designation')
                            ->required()
                            ->maxLength(200),

                        Textarea::make('bio')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        TagsInput::make('typing_roles')
                            ->label('Typing Animation Roles')
                            ->placeholder('e.g. Laravel Developer')
                            ->columnSpanFull(),
                    ]),
                ]),

                Section::make('Call to Action')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('cta_label')
                            ->label('CTA Button Text')
                            ->maxLength(100),

                        TextInput::make('cta_link')
                            ->label('CTA Link / Anchor')
                            ->maxLength(200),
                    ]),
                ]),

                Section::make('Media')->schema([
                    FileUpload::make('profile_photo')
                        ->image()
                        ->disk('public')
                        ->visibility('public')
                        ->directory('hero'),

                    FileUpload::make('resume_file')
                        ->label('Resume / CV (PDF)')
                        ->acceptedFileTypes(['application/pdf'])
                        ->disk('public')
                        ->visibility('public')
                        ->directory('hero'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('designation'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageHeroSections::route('/'),
        ];
    }
}

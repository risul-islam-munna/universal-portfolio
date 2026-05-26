<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Info')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(200)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state ?? '')))
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(200),

                        TextInput::make('category')
                            ->maxLength(100),

                        TextInput::make('display_order')
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_featured')
                            ->label('Featured project'),

                        Textarea::make('description')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
                ]),

                Section::make('Tech & Links')->schema([
                    Grid::make(2)->schema([
                        TagsInput::make('tech_stack')
                            ->label('Technologies')
                            ->placeholder('Add technology...')
                            ->columnSpanFull(),

                        TextInput::make('project_url')
                            ->label('Live URL')
                            ->url()
                            ->maxLength(500),

                        TextInput::make('github_url')
                            ->label('GitHub URL')
                            ->url()
                            ->maxLength(500),
                    ]),
                ]),

                Section::make('Media')->schema([
                    FileUpload::make('thumbnail')
                        ->image()
                        ->disk('public')
                        ->visibility('public')
                        ->directory('projects/thumbnails'),

                    FileUpload::make('gallery')
                        ->label('Gallery Images')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->disk('public')
                        ->visibility('public')
                        ->directory('projects/gallery'),
                ]),
            ]);
    }
}

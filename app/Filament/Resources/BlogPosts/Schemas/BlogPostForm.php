<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Post Details')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(300)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state ?? '')))
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(300),

                        DateTimePicker::make('published_at')
                            ->label('Publish Date'),

                        TagsInput::make('tags')
                            ->placeholder('Add tag...')
                            ->columnSpanFull(),

                        Toggle::make('is_published')
                            ->label('Published'),
                    ]),
                ]),

                Section::make('Cover Image')->schema([
                    FileUpload::make('cover_image')
                        ->image()
                        ->disk('public')
                        ->visibility('public')
                        ->directory('blog/covers'),
                ]),

                Section::make('Content')->schema([
                    MarkdownEditor::make('content')
                        ->required()
                        ->fileAttachmentsDirectory('blog/attachments')
                        ->columnSpanFull(),
                ]),
            ]);
    }
}

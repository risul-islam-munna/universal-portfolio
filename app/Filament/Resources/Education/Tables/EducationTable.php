<?php

namespace App\Filament\Resources\Education\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EducationTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('institution_name')
                    ->label('Institution')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('degree')
                    ->searchable(),

                TextColumn::make('field_of_study')
                    ->label('Field')
                    ->toggleable(),

                TextColumn::make('start_year')
                    ->label('From')
                    ->sortable(),

                TextColumn::make('end_year')
                    ->label('To'),

                TextColumn::make('display_order')
                    ->label('Order')
                    ->sortable(),
            ])
            ->defaultSort('display_order')
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

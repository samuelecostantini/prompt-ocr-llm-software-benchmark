<?php

namespace App\Filament\Resources\DocumentResource\RelationManagers;

use App\Models\Prompt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RunsRelationManager extends RelationManager
{
    protected static string $relationship = 'runs';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('prompt_id')
                    ->options(fn (): array => Prompt::all()->pluck('title', 'id')->toArray()),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Run ID'),
                Tables\Columns\TextColumn::make('prompt.title'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

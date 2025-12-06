<?php

namespace App\Filament\Resources\DocumentResource\RelationManagers;

use App\Models\DocumentDetail;
use App\Models\GroundTruth;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroundTruthsRelationManager extends RelationManager
{
    protected static string $relationship = 'groundTruths';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(GroundTruth::query())
            ->columns([
                Tables\Columns\TextColumn::make('documentDetail.name'),
                Tables\Columns\TextColumn::make('value')
                    ->placeholder('Insert correct label'),
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

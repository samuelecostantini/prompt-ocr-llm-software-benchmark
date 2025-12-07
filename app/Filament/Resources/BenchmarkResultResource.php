<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BenchmarkResultResource\Pages;
use App\Models\BenchmarkResult;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BenchmarkResultResource extends Resource
{
    protected static ?string $model = BenchmarkResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('run_id')->label('run ID'),
                Tables\Columns\TextColumn::make('extracted_value')->label('valore estratto'),
                Tables\Columns\TextColumn::make('expected_value')->label('valore atteso'),
                Tables\Columns\TextColumn::make('score')->label('score'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBenchmarkResults::route('/'),
            'create' => Pages\CreateBenchmarkResult::route('/create'),
            'edit' => Pages\EditBenchmarkResult::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\DocumentResource\RelationManagers;

use App\Models\ExtractedField;
use App\Models\Prompt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DocumentDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'extractedFields';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('document_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('documentDetail.name')
                    ->label('Detail Name'),
                Tables\Columns\TextColumn::make('value')
                    ->label('Value'),
                Tables\Columns\TextColumn::make('documentDetail.groundTruth.value')
                    ->getStateUsing(fn (ExtractedField $record) => $record->document->groundTruths()->where('document_detail_id', $record->document_detail_id)->first()?->value ?: 'N/A')
                    ->label('Ground Truth'),
                Tables\Columns\TextColumn::make('run.prompt.title')
                    ->label('Prompt'),

            ])
            ->filters([
                Filter::make('prompt')
                    ->form([
                        Forms\Components\Select::make('prompt_id')
                            ->label('Prompt')
                            ->options(Prompt::all()->pluck('title', 'id'))
                            ->searchable(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['prompt_id'],
                            fn (Builder $query, $promptId): Builder => $query->whereHas('run', fn (Builder $query) => $query->where('prompt_id', $promptId)),
                        );
                    }),
                Filter::make('document_detail')
                    ->form([
                        Forms\Components\Select::make('document_detail_id')
                            ->label('Document Detail')
                            ->options(function (RelationManager $livewire) {
                                return $livewire->ownerRecord->detailSet->documentDetails->pluck('name', 'id');
                            })
                            ->searchable(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['document_detail_id'],
                            fn (Builder $query, $detailId): Builder => $query->where('document_detail_id', $detailId),
                        );
                    }),
            ], layout: FiltersLayout::AboveContent)
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

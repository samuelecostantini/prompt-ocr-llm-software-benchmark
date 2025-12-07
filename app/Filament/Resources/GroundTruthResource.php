<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroundTruthResource\Pages;
use App\Models\GroundTruth;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GroundTruthResource extends Resource
{
    protected static ?string $model = GroundTruth::class;

    protected static ?string $slug = 'ground-truths';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('document_id')
                    ->relationship('document', 'title')
                    ->searchable()
                    ->required(),

                Select::make('document_detail_id')
                    ->relationship('documentDetail', 'name')
                    ->searchable()
                    ->required(),

                TextInput::make('value')
                    ->required(),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn (?GroundTruth $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn (?GroundTruth $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('document.title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('documentDetail.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('value'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroundTruths::route('/'),
            'create' => Pages\CreateGroundTruth::route('/create'),
            'edit' => Pages\EditGroundTruth::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['document', 'documentDetail']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['document.title', 'documentDetail.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->document) {
            $details['Document'] = $record->document->title;
        }

        if ($record->documentDetail) {
            $details['DocumentDetail'] = $record->documentDetail->name;
        }

        return $details;
    }
}

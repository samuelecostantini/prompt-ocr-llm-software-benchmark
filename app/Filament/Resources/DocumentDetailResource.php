<?php

namespace App\Filament\Resources;

use App\Enums\DetailType;
use App\Filament\Imports\DocumentDetailImporter;
use App\Filament\Resources\DocumentDetailResource\Pages;
use App\Models\DetailSet;
use App\Models\DocumentDetail;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DocumentDetailResource extends Resource
{
    protected static ?string $model = DocumentDetail::class;

    protected static ?string $slug = 'document-details';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass';

    public static function form(Form $form): Form
    {
        $record = $form->model();
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, $state): void {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255),

                Select::make('type')
                    ->options(DetailType::class),

                Select::make('detail_set_id')
                    ->options(DetailSet::all()->pluck('title', 'id')),

                TextInput::make('user_id')
                    ->readonly()
                    ->default(auth()->user()->id),

                Textarea::make('additional_info_for_prompt')
                    ->columnSpanFull(),

                Checkbox::make('nullable'),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->hidden()
                    ->content(fn(?DocumentDetail $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->hidden()
                    ->content(fn(?DocumentDetail $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type'),

                TextColumn::make('nullable'),

                TextColumn::make('detailSet.title'),

                TextColumn::make('additional_info_for_prompt'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->headerActions([
                \Filament\Tables\Actions\ImportAction::make()
                    ->importer(DocumentDetailImporter::class)
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
            'index' => Pages\ListDocumentDetails::route('/'),
            'create' => Pages\CreateDocumentDetail::route('/create'),
            'edit' => Pages\EditDocumentDetail::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['user']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug', 'user.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->user) {
            $details['User'] = $record->user->name;
        }

        return $details;
    }
}

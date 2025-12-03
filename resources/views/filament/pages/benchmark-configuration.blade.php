<x-filament-panels::page>
    <x-filament::card>
        <div>Title: {{ $document->title }}</div>
        <div>Detail set: {{ $document->detailSet->title }}</div>
        <div> Qui metto l'anteprima dell'immagine o il link per il pdf </div>
    </x-filament::card>

    <x-filament::section :collapsible='true' :collapsed='true' heading="Ground Truth">
        @livewire(\App\Filament\Resources\DocumentResource\RelationManagers\GroundTruthsRelationManager::class, [
            'ownerRecord' => $this->document,
            'pageClass'   => static::class,
        ])
    </x-filament::section>
    <x-filament::section heading="Runs configuration" :collapsible='true'>
        @livewire(\App\Filament\Resources\DocumentResource\RelationManagers\RunsRelationManager::class, [
            'ownerRecord' => $this->document,
            'pageClass'   => static::class,
        ])
    </x-filament::section>
</x-filament-panels::page>

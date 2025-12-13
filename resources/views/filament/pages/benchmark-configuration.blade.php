<x-filament-panels::page>
    <x-filament::card>
        <div>
            <b>Title:</b>
             {{ $document->title }}
        </div>
        <div>
            <b>Detail set:</b> 
            {{ $document->detailSet->title }}
        </div>
        <div>
            <b>File url:</b>
            <a href="{{ $document->getFirstMedia('document')->getUrl() }}"> 
                {{ $document->getFirstMedia('document')->getUrl() }} 
            </a>
        </div>
        @if($document->getFirstMedia('document')->mime_type !== 'application/pdf')
            <div>
                <img src="{{ $document->getFirstMedia('document')->getPath() }}" alt="document"/>
            </div>
        @endif
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

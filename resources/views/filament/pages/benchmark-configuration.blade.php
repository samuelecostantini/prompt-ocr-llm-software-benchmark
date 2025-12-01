<x-filament-panels::page>
    <x-filament::card>
        <div>Title: {{ $document->title }}</div>
        <div>Detail set: {{ $document->detailSet->title }}</div>
    </x-filament::card>
    {{-- tocca crea il ground truth quando viene salvato il documento aggiungendo dei label vuoiti in base al set --}}
    <x-filament::section heading="Ground truth">
    <div>
        <x-filament-panels::form action="saveGroundTruth">
            <h1 class="font-semibold">Labeling</h1>
            <div>
            @foreach($document->detailSet->documentDetails as $detail )
                <div class="my-2">
                    <span class="">
                        {{$detail->name}}
                    </span>
                    <span class="p-3">
                        <input
                            name="groundTruth-{{$detail->id}}"
                            type="text"
                            class="rounded-lg h-8 w-40 border dark:bg-white/5 dark:border-white/10 dark:text-white focus:border-primary-600 dark:focus:border-primary-500 focus:ring-1 focus:ring-primary-600 dark:focus:ring-primary-500">
                    </span>
                </div>
            @endforeach
                <x-filament::button>
                    Save labels
                </x-filament::button>
        </x-filament-panels::form>
        </div>
    </div>
    </x-filament::section>
    <x-filament::section heading="Runs configuration">

    </x-filament::section>
</x-filament-panels::page>

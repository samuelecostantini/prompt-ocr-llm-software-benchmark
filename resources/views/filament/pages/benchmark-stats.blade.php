
<x-filament-panels::page>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div>
        <div class="flex justify-between items-center mb-4">
            <div>
                <x-filament::button wire:click='resetBenchData'>
                    Reset Benchmark Data
                </x-filament::button>
                <x-filament::button wire:click='reRunBenchmark'>
                    Run Benchmark
                </x-filament::button>
                <x-filament::button wire:click='runBulkExtraction' color="danger">
                    Run Bulk Extraction
                </x-filament::button>
            </div>
            
            <div class="flex items-center space-x-2">
                <label for="sortColumn" class="text-sm font-medium text-gray-700 dark:text-gray-200">Sort by:</label>
                <select wire:model.live='sortColumn' id="sortColumn" class="text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="tag">Tag</option>
                    @foreach ($prompts as $prompt)
                        <option value="{{ $prompt->id }}">{{ $prompt->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    {{-- Average Score by Type Table --}}
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Average Score by Detail Type</h3>
        <div class="ring-1 ring-gray-950/5 dark:ring-white/10 overflow-x-auto rounded-xl shadow-sm bg-white dark:bg-gray-900">
            <table class="w-full table-auto divide-y divide-gray-200 dark:divide-white/5 text-left">
                <thead class="bg-gray-50 dark:bg-white/5">
                    <tr>
                        <th class="px-4 py-3.5 sm:px-6 text-sm font-semibold text-gray-900 dark:text-white border-r border-gray-200 dark:border-white/10">
                            Type / Prompt
                        </th>
                        @foreach ($prompts as $prompt)
                            <th class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900 dark:text-white max-w-[120px] overflow-hidden">
                                {{ $prompt->title }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                    @foreach ($avgByType as $type => $promptScores)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                            <td class="px-4 py-3 sm:px-6 text-sm font-bold text-gray-700 dark:text-gray-200 bg-gray-50/50 dark:bg-white/5 border-r border-gray-200 dark:border-white/10 w-[200px]">
                                {{ $type ?? 'N/A' }}
                            </td>
                            @foreach ($prompts as $prompt)
                                @php
                                    $data = $promptScores[$prompt->id] ?? null;
                                    $avgScore = $data['avg_score'] ?? null;

                                    $colorClasses = 'text-gray-400 dark:text-gray-400';
                                    if ($avgScore !== null) {
                                        if ($avgScore >= 0.90) {
                                            $colorClasses = 'bg-green-500 dark:bg-green-500 dark:text-green-400';
                                        } elseif ($avgScore >= 0.75) {
                                            $colorClasses = 'bg-yellow-500 dark:bg-yellow-500 dark:text-yellow-400';
                                        } elseif ($avgScore >= 0.50) {
                                            $colorClasses = 'bg-orange-500 dark:bg-red-500 dark:text-red-400';
                                        }
                                    }
                                @endphp
                                <td class="px-4 py-3 text-center text-sm font-medium border {{ $colorClasses }}">
                                    @if($avgScore !== null)
                                        {{ number_format($avgScore, 4) }}
                                    @else
                                        <span class="opacity-30">-</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="ring-1 ring-gray-950/5 dark:ring-white/10 overflow-x-auto rounded-xl shadow-sm bg-white dark:bg-gray-900">
        <table class="w-full table-auto divide-y divide-gray-200 dark:divide-white/5 text-left">
            <thead class="bg-gray-50 dark:bg-white/5">
                <tr>
                    <th class="px-4 py-3.5 sm:px-6 text-sm font-semibold text-gray-900 dark:text-white border-r border-gray-200 dark:border-white/10">
                        Tag / Prompt
                    </th>
                    
                    @foreach ($prompts as $prompt)
                        <th class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900 dark:text-white max-w-[120px] overflow-hidden">
                            {{ $prompt->title }}
                            <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mt-1">
                                Avg: {{ number_format($accuracies[$prompt->id]['overall'], 4) }}
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            
            <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                @foreach ($tags as $tag)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                        <td class="px-4 py-3 sm:px-6 text-sm font-bold text-gray-700 dark:text-gray-200 bg-gray-50/50 dark:bg-white/5 border-r border-gray-200 dark:border-white/10 w-[200px] overflow-hidden">
                            {{ $tag }}
                        </td>

                        @foreach ($prompts as $prompt)
                            @php
                                $avgAccuracy = $accuracies[$prompt->id]['by_tag'][$tag] ?? null;
                                
                                $colorClasses = 'text-gray-400 dark:text-gray-400'; // Default vuoto
                                if ($avgAccuracy !== null) {
                                    if ($avgAccuracy >= 0.90) {
                                        $colorClasses = 'bg-green-500 dark:bg-green-500 dark:text-green-400';
                                    } elseif ($avgAccuracy >= 0.75) {
                                        $colorClasses = 'bg-yellow-500 dark:bg-yellow-500 dark:text-yellow-400';
                                    } elseif ($avgAccuracy >= 0.50) {
                                        $colorClasses = 'bg-orange-500 dark:bg-red-500 dark:text-red-400';
                                    }
                                } 
                            @endphp

                            <td class="px-4 py-3 text-center text-sm font-medium border {{ $colorClasses }}">
                                @if($avgAccuracy !== null)
                                    {{ number_format($avgAccuracy, 4) }}
                                @else
                                    <span class="opacity-30">-</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                    <td class="px-4 py-3 sm:px-6 text-sm font-bold text-gray-700 dark:text-gray-200 bg-gray-50/50 dark:bg-white/5 border-r border-gray-200 dark:border-white/10 w-[200px] overflow-hidden">
                        Average accuracy
                    </td>
                    @foreach ( $prompts as $prompt)
                        <th class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900 dark:text-white max-w-[120px] overflow-hidden">
                            <div class="text-sm font-medium text-black dark:text-white uppercase tracking-wider mt-1">
                                {{ number_format($accuracies[$prompt->id]['overall'], 4) }}
                            </div>
                        </th>
                    @endforeach
                    
                </tr>
                <tr>
                <td class="px-4 py-3 sm:px-6 text-sm font-bold text-gray-700 dark:text-gray-200 bg-gray-50/50 dark:bg-white/5 border-r border-gray-200 dark:border-white/10 w-[200px] overflow-hidden">
                        Average weighted accuracy
                    </td>
                    @foreach ( $prompts as $prompt)
                        <th class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900 dark:text-white max-w-[120px] overflow-hidden">
                            <div class="text-sm font-medium text-black dark:text-white uppercase tracking-wider mt-1">
                                {{ number_format($accuracies[$prompt->id]['weighted'], 4) }}
                            </div>
                        </th>
                    @endforeach
                </tr>
            </tbody>
        </table>

    </div>
</div>
<div>Dati grezzi benchmark</div>
<div class="flex">
    <div>Order by: </div>
    <select wire:model.live="sortRawBy" 
            class="mb-4 mr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full max-w-md">
        <option value="created_at">Default</option>
        <option value="prompt">Prompt</option>
        <option value="document">Document</option>
        <option value="detail_name">Detail name</option>
        <option value="extracted_value">Extracted value</option>
        <option value="expected_value">Ground truth value</option>
        <option value="score">Score</option>
    </select>
    <select wire:model.live="order" 
            class="mb-4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full max-w-md">
        <option value="asc">Asc</option>
        <option value="desc">Desc</option>
</select>
</div>
    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
    <table class="w-full border-collapse text-md">
        <thead>
            <tr
                class="bg-gray-100 text-gray-700
                       dark:bg-gray-800 dark:text-gray-200"
            >
                <th class="px-4 py-3 text-left font-semibold">
                    Prompt
                </th>
                <th class="px-4 py-3 text-left font-semibold">
                    Document
                </th>
                <th class="px-4 py-3 text-left font-semibold">
                    Detail name
                </th>
                <th class="px-4 py-3 text-left font-semibold">
                    Extracted value
                </th>
                <th class="px-4 py-3 text-left font-semibold">
                    Ground truth value
                </th>
                <th class="px-4 py-3 text-left font-semibold">
                    Score
                </th>
                <th class="px-4 py-3 text-left font-semibold">
                    Value Type
                </th>
            </tr>
        </thead>

        <tbody
            class="divide-y-gray bg-white dark:bg-gray-900"
        >
            @foreach ($this->benchmarkResults as $result)
                <tr class="odd:bg-gray-500/25">
                    <td class="px-4 py-3 text-gray-800 dark:text-white">
                        {{ $result->prompt?->title }}
                    </td>
                    <td class="px-4 py-3 text-gray-800 dark:text-white">
                        {{ $result->document?->title }}
                    </td>
                    <td class="px-4 py-3 text-gray-800 dark:text-white">
                        {{ $result->extractedField?->documentDetail?->name }}
                    </td>

                    <td class="px-4 py-3 text-gray-700 dark:text-white">
                        {{ $result->extracted_value }}
                    </td>

                    <td class="px-4 py-3 text-gray-700 dark:text-white">
                        {{ $result->expected_value? : 'Unknown' }}
                    </td>

                    <td class="px-4 py-3 font-semibold">
                        <span
                            class="
                                @if ($result->score >= 0.5)
                                    text-green-600 dark:text-green-400
                                @elseif ($result->score >= 0.25)
                                    text-yellow-600 dark:text-yellow-400
                                @else
                                    text-red-600 dark:text-red-400
                                @endif
                            "
                        >
                            {{ $result->score }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        {{ $result->extractedField?->documentDetail?->type }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-filament-panels::page>

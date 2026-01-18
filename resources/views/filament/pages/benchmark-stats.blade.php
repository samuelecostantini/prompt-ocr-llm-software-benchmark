
<x-filament-panels::page>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div>
    <div class="ring-1 ring-gray-950/5 dark:ring-white/10 overflow-x-auto rounded-xl shadow-sm bg-white dark:bg-gray-900">
        <table class="w-full table-auto divide-y divide-gray-200 dark:divide-white/5 text-left">
            <thead class="bg-gray-50 dark:bg-white/5">
                <tr>
                    <th class="px-4 py-3.5 sm:px-6 text-sm font-semibold text-gray-900 dark:text-white border-r border-gray-200 dark:border-white/10">
                        Tag / Prompt
                    </th>
                    
                    @foreach ( \App\Models\Prompt::all() as $prompt)
                        <th class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900 dark:text-white max-w-[120px] overflow-hidden">
                            {{ $prompt->title }}
                            <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mt-1">
                                Avg: {{ number_format($prompt->getAccuracy(), 4) }}
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            
            <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                @foreach (\App\Models\Prompt::all()->flatMap(fn($p) => array_keys($p->getAccuracyByTag()))->unique()->sort() as $tag)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                        <td class="px-4 py-3 sm:px-6 text-sm font-bold text-gray-700 dark:text-gray-200 bg-gray-50/50 dark:bg-white/5 border-r border-gray-200 dark:border-white/10 w-[200px] overflow-hidden">
                            {{ $tag }}
                        </td>

                        @foreach (\App\Models\Prompt::all() as $prompt)
                            @php
                                $accuracies = $prompt->getAccuracyByTag();
                                $avgAccuracy = $accuracies[$tag] ?? null;
                                
                                // Definizione dei colori in base alla logica originale
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
                    @foreach ( \App\Models\Prompt::all() as $prompt)
                        <th class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900 dark:text-white max-w-[120px] overflow-hidden">
                            <div class="text-sm font-medium text-black dark:text-white uppercase tracking-wider mt-1">
                                {{ number_format($prompt->getAccuracy(), 4) }}
                            </div>
                        </th>
                    @endforeach
                </tr>
            </tbody>
        </table>

    </div>
</div>
<div>Dati grezzi benchmark</div>
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
            </tr>
        </thead>

        <tbody
            class="divide-y-gray
                   bg-white dark:bg-gray-900"
        >
            @foreach (\App\Models\BenchmarkResult::all()->sortByDesc('document_id') as $result)
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
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-filament-panels::page>

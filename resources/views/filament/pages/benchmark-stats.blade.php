
<x-filament-panels::page>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div>
        <div
            class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-3 gap-6 w-full
                   rounded-xl
                   bg-gray-50 dark:bg-gray-900 p-4"
        >
            @foreach (\App\Models\Prompt::all() as $prompt)
                <div
                    class="rounded-xl w-full p-5 shadow-sm border
                           bg-white dark:bg-gray-800
                           border-gray-200 dark:border-gray-700"
                >

                    {{-- Prompt name --}}
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            {{ $prompt->title }}
                        </h3>
                    </div>

                    {{-- Accuracy --}}
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Accuracy
                            </span>

                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ number_format($prompt->getAccuracy() * 100, 2) }}%
                            </span>
                        </div>

                        {{-- Progress bar --}}
                        <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                            <div
                                class="h-full rounded-full transition-all
                                    @if ($prompt->getAccuracy() >= 0.5)
                                        bg-green-500 dark:bg-green-400
                                    @elseif ($prompt->getAccuracy() >= 0.35)
                                        bg-yellow-500 dark:bg-yellow-400
                                    @else
                                        bg-red-500 dark:bg-red-400
                                    @endif"
                                style="width: {{ $prompt->getAccuracy() * 100 }}%"
                            ></div>
                        </div>
                    </div>
                    <div class="w-full space-y-2 mt-4">
                        @foreach ($prompt->getAccuracyByTag() as $tag => $avgAccuracy)
                            <div class="flex justify-between">
                                <span>
                                    <b>{{ $tag }}</b>:</span>
                                    <span> {{ number_format($avgAccuracy*100, 2) }}%</span>
                                </div>
                            <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                            <div
                                class="h-full rounded-full transition-all
                                    @if ( $avgAccuracy >= 0.50)
                                        bg-green-500 dark:bg-green-400
                                    @elseif ( $avgAccuracy >= 0.35)
                                        bg-yellow-500 dark:bg-yellow-400
                                    @else
                                        bg-red-500 dark:bg-red-400
                                    @endif"
                                style="width: {{ $avgAccuracy*100 }}%"
                            ></div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div>
        <div>Dati grezzi statiche</div>
    </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
    <table class="w-full border-collapse text-md">
        <thead>
            <tr
                class="bg-gray-100 text-gray-700
                       dark:bg-gray-800 dark:text-gray-200"
            >
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
            @foreach (\App\Models\BenchmarkResult::all() as $result)
                <tr>
                    <td class="px-4 py-3 text-gray-800 dark:text-white">
                        {{ $result->extractedField?->documentDetail?->name }}
                    </td>

                    <td class="px-4 py-3 text-gray-700 dark:text-white">
                        {{ $result->extracted_value }}
                    </td>

                    <td class="px-4 py-3 text-gray-700 dark:text-white">
                        {{ $result->expected_value }}
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

<div>
    {{-- Header --}}
    <div>
        <h2 class="text-xl font-bold text-gray-200">
            Benchmark accuracy
        </h2>
        <p class="text-sm text-gray-500">
            Confronto delle performance dei prompt sui dataset di valutazione
        </p>
    </div>

    {{-- Grid --}}
    <div class="grid grid-cols-3 gap-6 rounded-lg w-full">
        @foreach (\App\Models\Prompt::all() as $prompt)
            <div class="rounded-2xl w-full border border-gray-200 bg-none p-5 shadow-sm">
                
                {{-- Prompt name --}}
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">
                        {{ $prompt->name }}
                    </h3>

                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-600">
                        Prompt
                    </span>
                </div>

                {{-- Accuracy --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Accuracy</span>
                        <span class="text-sm font-semibold text-gray-900">
                            {{ number_format($prompt->accuracy * 100, 2) }}%
                        </span>
                    </div>

                    {{-- Progress bar --}}
                    <div class="h-2 w-full overflow-hidden rounded-full bg-gray-100">
                        <div
                            class="h-full rounded-full
                                @if ($prompt->accuracy >= 0.9) bg-green-500
                                @elseif ($prompt->accuracy >= 0.75) bg-yellow-500
                                @else bg-red-500
                                @endif"
                            style="width: {{ $prompt->accuracy * 100 }}%"
                        ></div>
                    </div>
                </div>

                {{-- Extra stats --}}
                <div class="mt-5 grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Samples</p>
                        <p class="font-semibold text-gray-800">
                            {{ $prompt->samples }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Errors</p>
                        <p class="font-semibold text-gray-800">
                            {{ $prompt->errors }}
                        </p>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

@vite(['resources/css/app.css', 'resources/js/app.js'])

</div>

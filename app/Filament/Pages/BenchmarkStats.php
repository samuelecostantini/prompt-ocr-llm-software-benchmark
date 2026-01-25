<?php

namespace App\Filament\Pages;

use App\Models\BenchmarkResult;
use App\Models\Prompt;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;

class BenchmarkStats extends Page
{
    public string $sortRawBy = 'created_at';

    public $prompts;

    public $tags;

    public $accuracies;

    public $sortColumn = 'tag';

    public $order = 'asc';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.benchmark-stats';

    public function mount(): void
    {
        $this->loadData();
    }

    public function loadData(): void
    {
        // Caching might be a good idea here as this is heavy
        $data = Cache::remember('benchmark-stats', now()->addMinutes(10), function () {
            $prompts = Prompt::all();
            $benchmarkResults = BenchmarkResult::with('document.tags', 'extractedField.documentDetail')->get();

            $accuracies = [];
            $allTags = collect();

            foreach ($prompts as $prompt) {
                $promptResults = $benchmarkResults->where('prompt_id', $prompt->id);
                $totalScore = $promptResults->sum('score');
                $totalCount = $promptResults->count();

                // Weighted accuracy
                $weightedSum = $promptResults->sum(function ($result) {
                    return $result->score * ($result->extractedField?->documentDetail?->weight ?? 1);
                });
                $weightSum = $promptResults->sum(function ($result) {
                    return $result->extractedField?->documentDetail?->weight ?? 1;
                });
                $weightedAccuracy = $weightSum > 0 ? $weightedSum / $weightSum : 0;

                $tagStats = [];
                foreach ($promptResults as $result) {
                    if ($result->document?->tags) {
                        foreach ($result->document->tags as $tag) {
                            if (! isset($tagStats[$tag->title])) {
                                $tagStats[$tag->title] = ['totalScore' => 0, 'count' => 0];
                            }
                            $tagStats[$tag->title]['totalScore'] += $result->score;
                            $tagStats[$tag->title]['count']++;
                        }
                    }
                }

                $accuracyByTag = [];
                foreach ($tagStats as $tagName => $stats) {
                    $accuracyByTag[$tagName] = $stats['count'] > 0 ? $stats['totalScore'] / $stats['count'] : 0;
                }

                $accuracies[$prompt->id] = [
                    'overall' => $totalCount > 0 ? $totalScore / $totalCount : 0,
                    'weighted' => $weightedAccuracy,
                    'by_tag' => $accuracyByTag,
                ];

                $allTags = $allTags->merge(array_keys($accuracyByTag));
            }

            return [
                'prompts' => $prompts,
                'tags' => $allTags->unique()->sort()->values()->all(),
                'accuracies' => $accuracies,
            ];
        });

        $this->prompts = $data['prompts'];
        $this->tags = $data['tags'];
        $this->accuracies = $data['accuracies'];

        $this->sortTags();
    }

    public function getBenchmarkResultsProperty()
    {
        $query = BenchmarkResult::query()->with('prompt', 'document', 'extractedField.documentDetail');

        switch ($this->sortRawBy) {
            case 'prompt':
                $query->select('benchmark_results.*')
                    ->join('prompts', 'prompts.id', '=', 'benchmark_results.prompt_id')
                    ->orderBy('prompts.title', direction: $this->order);
                break;
            case 'document':
                $query->select('benchmark_results.*')
                    ->join('documents', 'documents.id', '=', 'benchmark_results.document_id')
                    ->orderBy('documents.title', $this->order);
                break;
            case 'detail_name':
                $query->select('benchmark_results.*')
                    ->join('extracted_fields', 'extracted_fields.id', '=', 'benchmark_results.extracted_field_id')
                    ->join('document_details', 'document_details.id', '=', 'extracted_fields.document_detail_id')
                    ->orderBy('document_details.name', $this->order);
                break;
            case 'extracted_value':
                $query->orderBy('benchmark_results.extracted_value', $this->order);
                break;
            case 'expected_value':
                $query->orderBy('benchmark_results.expected_value', $this->order);
                break;
            case 'score':
                $query->orderBy('benchmark_results.score', $this->order);
                break;
            case 'created_at':
            default:
                $query->orderBy('benchmark_results.created_at', $this->order);
        }

        return $query->get();
    }

    public function updatedSortColumn()
    {
        $this->sortTags();
    }

    public function sortTags()
    {
        if ($this->sortColumn === 'tag' || ! $this->sortColumn) {
            $this->tags = collect($this->tags)->sort()->values()->all();
        } else {
            $promptId = $this->sortColumn;
            $this->tags = collect($this->tags)->sortByDesc(function ($tag) use ($promptId) {
                return $this->accuracies[$promptId]['by_tag'][$tag] ?? -1;
            })->values()->all();
        }
    }

    public function resetBenchData(): void
    {
        BenchmarkResult::query()->delete();
        Cache::forget('benchmark-stats');
        $this->loadData();
    }

    public function runBulkExtraction(): void
    {
        \App\Jobs\BulkRunJob::dispatch(new \App\Models\Run);
    }

    public function reRunBenchmark(): void
    {
        \App\Actions\RunBenchmarkAction::handle();
        Cache::forget('benchmark-stats');
        $this->loadData();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prompt extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function runs(): HasMany
    {
        return $this->hasMany(Run::class);
    }

    public function extractedFields()
    {
        return $this->hasManyThrough(ExtractedField::class, Run::class, 'prompt_id', 'run_id', 'id', 'id');
    }
    public function getAccuracy()
    {
        $totalAccuracy = 0;
        $totalResults = 0;
        $benchmarkResults = BenchmarkResult::where('prompt_id', $this->id);
        $totalResults = $benchmarkResults->count();
            foreach ($benchmarkResults->get() as $result) {
                $totalAccuracy += $result->score;
            }
        return $totalResults != 0 ? $totalAccuracy / $totalResults : 0;
    }

    public function getAccuracyByTag(): array
    {
        $tagStats = [];

        foreach ($this->runs as $run) {
            $document = $run->document;

            foreach ($document?->tags? : [] as $tag) {
                if (! isset($tagStats[$tag->title])) {
                    $tagStats[$tag?->title? : 'null'] = [
                        'totalAccuracy' => 0,
                        'totalResults' => 0,
                    ];
                }

                $benchmarkResults = BenchmarkResult::where('run_id', $run->id);
                $tagStats[$tag->title]['totalResults'] += $benchmarkResults->count();

                foreach ($benchmarkResults->get() as $result) {
                    $tagStats[$tag->title]['totalAccuracy'] += $result->score;
                }
            }
        }

        $accuracy = [];
        foreach ($tagStats as $tagName => $stats) {
            $accuracy[$tagName] = $stats['totalResults'] != 0
                ? $stats['totalAccuracy'] / $stats['totalResults']
                : 0;
        }

        return $accuracy;
    }
}

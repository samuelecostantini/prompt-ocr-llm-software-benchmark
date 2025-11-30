<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\Prompt;
use App\Models\Run;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RunFactory extends Factory
{
    protected $model = Run::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'document_id' => Document::factory(),
            'prompt_id' => Prompt::factory(),
        ];
    }
}

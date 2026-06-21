<?php

namespace Database\Factories;

use App\Models\BenchmarkResult;
use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\ExtractedField;
use App\Models\Prompt;
use App\Models\Run;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BenchmarkResultFactory extends Factory
{
    protected $model = BenchmarkResult::class;

    public function definition(): array
    {
        return [
            'expected_value' => $this->faker->word(),
            'extracted_value' => $this->faker->word(),
            'score' => $this->faker->randomFloat(4, 0, 1),
            'detail_name' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'run_id' => Run::factory(),
            'extracted_field_id' => ExtractedField::factory(),
            'prompt_id' => Prompt::factory(),
            'document_id' => Document::factory(),
            'detail_id' => DocumentDetail::factory(),
        ];
    }
}

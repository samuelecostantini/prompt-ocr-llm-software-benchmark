<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\GroundTruth;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GroundTruthFactory extends Factory
{
    protected $model = GroundTruth::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'document_id' => Document::factory(),
            'document_detail_id' => DocumentDetail::factory(),
        ];
    }
}

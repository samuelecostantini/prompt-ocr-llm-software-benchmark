<?php

namespace Database\Factories;

use App\Models\DetailSet;
use App\Models\DocumentDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DocumentDetailFactory extends Factory
{
    protected $model = DocumentDetail::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'type' => $this->faker->word(),
            'nullable' => $this->faker->word(),
            'additional_info_for_prompt' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            // detail_set_id is NOT NULL in the schema; weight defaults to 1.
            'detail_set_id' => DetailSet::factory(),
        ];
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('benchmark_results', function (Blueprint $table) {
            $table->unique('extracted_field_id', 'benchmark_results_extracted_field_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('benchmark_results', function (Blueprint $table) {
            $table->dropUnique('benchmark_results_extracted_field_id_unique');
        });
    }
};

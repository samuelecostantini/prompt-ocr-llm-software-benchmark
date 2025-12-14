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
            $table->unsignedBigInteger('prompt_id')->after('run_id');
            $table->unsignedBigInteger('detail_id')->after('extracted_field_id');
            $table->string('detail_name')->after('extracted_field_id');
            $table->unsignedBigInteger('document_id')->after('run_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('benchmark_results', function (Blueprint $table) {
            //
        });
    }
};

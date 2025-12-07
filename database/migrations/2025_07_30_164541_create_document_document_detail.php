<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('extracted_fields', function (Blueprint $table) {
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('document_detail_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extracted_fields');
    }
};

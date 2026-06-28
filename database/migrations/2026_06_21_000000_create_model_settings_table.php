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
        Schema::create('model_settings', function (Blueprint $table) {
            $table->id();
            $table->string('provider')->unique();
            // JSON payload: plaintext endpoint/region/organization/bucket +
            // encrypted api_key/secret, plus a key_hash (sha256) for "is set" checks
            // without decryption. See ModelSettingsService.
            $table->json('settings')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_settings');
    }
};
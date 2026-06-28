<?php

namespace App\Providers;

use App\Services\ModelSettingsService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Laravel\Pennant\Feature;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        // Pennant feature flags for optional providers. The value is resolved
        // from config (models.features.*) every request via the array store, so
        // it is only ever set from the config file — no DB or UI toggle.
        Feature::define('anthropic_api_key_setting', fn () => (bool) config('models.features.anthropic', false));
        Feature::define('ollama_api_key_setting', fn () => (bool) config('models.features.ollama', false));

        // Push dashboard-set provider keys/endpoints into the existing config
        // keys so OpenAIService (Prism) and AwsTextractService pick them up.
        // Absent rows leave .env defaults in place (backward compatible).
        // Disabled providers (flag false) are skipped so their stored keys
        // aren't applied while the feature is off.
        app(ModelSettingsService::class)->loadIntoConfig();
    }
}

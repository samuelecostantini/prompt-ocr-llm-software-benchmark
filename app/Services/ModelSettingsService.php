<?php

namespace App\Services;

use App\Models\ModelSetting;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;
use Laravel\Pennant\Feature;

/**
 * Stores and resolves provider API keys/endpoints set from the dashboard.
 *
 * Secrets (api_key, aws secret) are encrypted at rest with Laravel's Crypt
 * (keyed off APP_KEY) — encryption, not hashing, because the keys must be
 * recoverable to send to the provider at request time. A key_hash (sha256)
 * is kept so the UI can show "key is set" without decrypting.
 *
 * Non-secret fields (endpoint, region, organization, bucket) are stored
 * plaintext so the form can display them.
 *
 * loadIntoConfig() writes decrypted values back into the existing config keys
 * (prism.providers.*, awstextract.*), so OpenAIService (via Prism) and
 * AwsTextractService pick up dashboard-set values without being modified.
 * When a DB row is absent, no override happens and .env defaults apply.
 */
class ModelSettingsService
{
    /**
     * Per-provider field definitions: which keys are secrets (encrypted)
     * and which are plaintext. Drives set()/getDecrypted().
     */
    protected const PROVIDERS = [
        'openai' => [
            'secrets' => ['api_key'],
            'plain' => ['endpoint', 'organization'],
        ],
        'aws' => [
            'secrets' => ['key', 'secret'],
            'plain' => ['region', 'bucket'],
        ],
        'anthropic' => [
            'secrets' => ['api_key'],
            'plain' => ['endpoint'],
        ],
        'ollama' => [
            'secrets' => ['api_key'],
            'plain' => ['endpoint'],
        ],
    ];

    /**
     * Config keys that loadIntoConfig() writes for each provider, mapped as
     * settings_field => config_key. Null means the field isn't pushed to config
     * (e.g. aws bucket is stored for reference but not needed by Textract).
     */
    protected const CONFIG_MAP = [
        'openai' => [
            'api_key' => 'prism.providers.openai.api_key',
            'endpoint' => 'prism.providers.openai.url',
            'organization' => 'prism.providers.openai.organization',
        ],
        'aws' => [
            'key' => 'awstextract.key',
            'secret' => 'awstextract.secret',
            'region' => 'awstextract.region',
        ],
        'anthropic' => [
            'api_key' => 'prism.providers.anthropic.api_key',
        ],
        'ollama' => [
            'endpoint' => 'prism.providers.ollama.url',
        ],
    ];

    /**
     * Optional providers gated behind a Pennant feature flag (set from config
     * only). Providers not listed here are always enabled. Maps provider =>
     * feature name.
     */
    protected const FEATURE_FLAGS = [
        'anthropic' => 'anthropic_api_key_setting',
        'ollama' => 'ollama_api_key_setting',
    ];

    /** Decrypted settings cache, keyed by provider, per process. */
    protected static array $cache = [];

    public static function providers(): array
    {
        return array_keys(self::PROVIDERS);
    }

    /**
     * Pennant feature name gating the provider, or null if the provider is
     * always enabled (openai, aws).
     */
    public static function featureFor(string $provider): ?string
    {
        return self::FEATURE_FLAGS[$provider] ?? null;
    }

    /**
     * Whether the provider's setting is enabled (i.e. its feature flag, if
     * any, is active). Non-gated providers are always enabled.
     */
    public function isEnabled(string $provider): bool
    {
        $feature = self::featureFor($provider);

        return $feature === null || Feature::active($feature);
    }

    /**
     * True once the model_settings table exists. Lets the service no-op safely
     * before the migration has run (e.g. fresh install, migrate --pretend).
     */
    protected function tableExists(): bool
    {
        return Schema::hasTable('model_settings');
    }

    public static function fieldsFor(string $provider): array
    {
        return self::PROVIDERS[$provider] ?? ['secrets' => [], 'plain' => []];
    }

    /**
     * Persist settings for a provider. Secret fields left blank are kept from
     * the existing stored value (so the UI password field can stay empty).
     */
    public function set(string $provider, array $data): void
    {
        if (! isset(self::PROVIDERS[$provider])) {
            return;
        }

        $existing = $this->tableExists() ? $this->getDecrypted($provider) : [];
        $spec = self::PROVIDERS[$provider];
        $payload = [];

        foreach ($spec['secrets'] as $field) {
            $value = $data[$field] ?? '';
            $value = is_string($value) ? trim($value) : '';
            // Blank means "keep current" — preserve the existing secret if any.
            if ($value === '') {
                $value = $existing[$field] ?? '';
            }
            $payload[$field] = $value === '' ? null : Crypt::encryptString($value);
            $payload["{$field}_hash"] = $value === '' ? null : hash('sha256', $value);
        }

        foreach ($spec['plain'] as $field) {
            $payload[$field] = $data[$field] ?? null;
        }

        ModelSetting::updateOrCreate(
            ['provider' => $provider],
            ['settings' => $payload],
        );

        unset(self::$cache[$provider]);

        $this->loadIntoConfig();
    }

    /**
     * Decrypt and return all settings for a provider (secrets + plaintext).
     * Memoized per process. Returns [] when no row exists.
     */
    public function getDecrypted(string $provider): array
    {
        if (isset(self::$cache[$provider])) {
            return self::$cache[$provider];
        }

        if (! $this->tableExists()) {
            return self::$cache[$provider] = [];
        }

        $row = ModelSetting::where('provider', $provider)->first();
        if (! $row || ! is_array($row->settings)) {
            return self::$cache[$provider] = [];
        }

        $spec = self::PROVIDERS[$provider];
        $out = [];

        foreach ($spec['secrets'] as $field) {
            $cipher = $row->settings[$field] ?? null;
            $out[$field] = $cipher ? Crypt::decryptString($cipher) : null;
        }

        foreach ($spec['plain'] as $field) {
            $out[$field] = $row->settings[$field] ?? null;
        }

        return self::$cache[$provider] = $out;
    }

    /**
     * Whether a usable secret is configured for the provider. Uses the stored
     * hash so this never needs to decrypt — cheap enough to call per render.
     */
    public function isSet(string $provider): bool
    {
        $spec = self::PROVIDERS[$provider] ?? null;
        if (! $spec || ! $this->tableExists()) {
            return false;
        }

        $row = ModelSetting::where('provider', $provider)->first();
        if (! $row || ! is_array($row->settings)) {
            return false;
        }

        foreach ($spec['secrets'] as $field) {
            // A provider is "set" if any of its secrets has a stored hash.
            if (! empty($row->settings["{$field}_hash"])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Push decrypted dashboard values into the existing config keys so the
     * existing services pick them up. Only overrides keys that have a value;
     * absent rows leave .env defaults in place.
     */
    public function loadIntoConfig(): void
    {
        foreach (self::CONFIG_MAP as $provider => $map) {
            // Skip providers whose feature flag is off — a stored key must not
            // be applied while the provider feature is disabled.
            if (! $this->isEnabled($provider)) {
                continue;
            }

            $settings = $this->getDecrypted($provider);
            if (! $settings) {
                continue;
            }

            foreach ($map as $field => $configKey) {
                $value = $settings[$field] ?? null;
                if ($value !== null && $value !== '') {
                    config([$configKey => $value]);
                }
            }
        }
    }
}
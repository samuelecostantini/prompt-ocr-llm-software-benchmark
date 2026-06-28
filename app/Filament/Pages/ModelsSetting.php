<?php

namespace App\Filament\Pages;

use App\Services\ModelSettingsService;
use Filament\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\HtmlString;

class ModelsSetting extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Models setting';

    protected static ?int $navigationSort = 10;

    protected static string $view = 'filament.pages.models-setting';

    public ?array $data = [];

    /**
     * Per-provider UI metadata: label, icon, and human labels for each field.
     */
    protected const PROVIDER_META = [
        'openai' => [
            'label' => 'OpenAI',
            'icon' => 'heroicon-o-sparkles',
            'fieldLabels' => [
                'api_key' => 'API key',
                'endpoint' => 'Endpoint / URL',
                'organization' => 'Organization (optional)',
            ],
            'secretPlaceholder' => 'e.g. sk-...',
        ],
        'aws' => [
            'label' => 'AWS Textract',
            'icon' => 'heroicon-o-cloud',
            'fieldLabels' => [
                'key' => 'Access key ID',
                'secret' => 'Secret access key',
                'region' => 'Region',
                'bucket' => 'S3 bucket (optional)',
            ],
            'secretPlaceholder' => '',
        ],
        'anthropic' => [
            'label' => 'Anthropic',
            'icon' => 'heroicon-o-chat-bubble-left-right',
            'fieldLabels' => [
                'api_key' => 'API key',
                'endpoint' => 'Endpoint / URL (optional)',
            ],
            'secretPlaceholder' => 'e.g. sk-ant-...',
        ],
        'ollama' => [
            'label' => 'Ollama',
            'icon' => 'heroicon-o-cpu-chip',
            'fieldLabels' => [
                'api_key' => 'API key (optional, only for proxied Ollama)',
                'endpoint' => 'Endpoint / URL',
            ],
            'secretPlaceholder' => '',
        ],
    ];

    public function mount(): void
    {
        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $service = app(ModelSettingsService::class);
        $data = [];

        foreach (ModelSettingsService::providers() as $provider) {
            $decrypted = $service->getDecrypted($provider);
            // Only non-secret fields are pre-filled; secrets stay blank so the
            // user isn't forced to retype them (keep-blank-to-keep-current).
            foreach (ModelSettingsService::fieldsFor($provider)['plain'] as $field) {
                $data[$provider][$field] = $decrypted[$field] ?? '';
            }
        }

        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->buildSchema())
            ->statePath('data');
    }

    protected function buildSchema(): array
    {
        $service = app(ModelSettingsService::class);
        $sections = [];

        foreach (ModelSettingsService::providers() as $provider) {
            $meta = self::PROVIDER_META[$provider];
            $spec = ModelSettingsService::fieldsFor($provider);
            $set = $service->isSet($provider);
            $enabled = $service->isEnabled($provider);
            $status = $set ? 'API key: set' : 'API key: not set';

            $description = $status . ' — values here override the .env defaults.';
            $fields = [];

            if (! $enabled) {
                $feature = ModelSettingsService::featureFor($provider);
                $description = "Disabled — enable via the config flag `{$feature}` (config/models.php).";

                $fields[] = Placeholder::make("{$provider}_coming_soon")
                    ->label('')
                    ->content(new HtmlString(
                        '<span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-200/50 dark:bg-amber-400/10 dark:text-amber-400 dark:ring-amber-400/20">Coming soon</span>'
                    ));
            }

            foreach ($spec['secrets'] as $field) {
                $fields[] = TextInput::make("{$provider}.{$field}")
                    ->label($meta['fieldLabels'][$field] ?? ucfirst($field))
                    ->password()
                    ->revealable()
                    ->placeholder($set ? 'Leave blank to keep current key' : ($meta['secretPlaceholder'] ?: 'Enter key'))
                    ->autocomplete(false)
                    ->disabled(! $enabled);
            }

            foreach ($spec['plain'] as $field) {
                $fields[] = TextInput::make("{$provider}.{$field}")
                    ->label($meta['fieldLabels'][$field] ?? ucfirst($field))
                    ->maxLength(255)
                    ->disabled(! $enabled);
            }

            $sections[] = Section::make($meta['label'])
                ->icon($meta['icon'])
                ->description($description)
                ->schema($fields)
                ->columns(2);
        }

        return $sections;
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $service = app(ModelSettingsService::class);

        foreach (ModelSettingsService::providers() as $provider) {
            // Disabled providers (feature flag off) are read-only — never persist.
            if (! $service->isEnabled($provider)) {
                continue;
            }
            $service->set($provider, $data[$provider] ?? []);
        }

        Notification::make()
            ->title('Provider settings saved')
            ->success()
            ->send();

        $this->fillForm();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save')
                ->submit('save'),
        ];
    }
}
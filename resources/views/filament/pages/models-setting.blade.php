@vite(['resources/css/app.css', 'resources/js/app.js'])
<x-filament-panels::page>
    <div class="space-y-4">
        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-3xl">
            Set provider API keys and endpoints here. Keys are encrypted at rest and
            override the values in your <code>.env</code>. Leave a key field blank to
            keep the currently stored one. When a provider has no key set here, the
            <code>.env</code> defaults continue to apply.
        </p>

        <form wire:submit="save">
            {{ $this->form }}

            <div class="mt-4">
                <x-filament-actions::actions :actions="$this->getFormActions()" />
            </div>
        </form>
    </div>
</x-filament-panels::page>
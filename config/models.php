<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Provider Feature Flags
    |--------------------------------------------------------------------------
    |
    | These flags gate whether a given provider's API key setting is enabled
    | in the dashboard. They are read by the Pennant feature resolvers and are
    | the ONLY way to toggle a flag — there is no database or UI toggle.
    |
    | Set them here or via the matching env variable. Defaults to false, so
    | optional providers stay off until explicitly enabled.
    |
    */

    'features' => [
        'anthropic' => env('MODELS_FEATURE_ANTHROPIC', false),
        'ollama' => env('MODELS_FEATURE_OLLAMA', false),
    ],

];
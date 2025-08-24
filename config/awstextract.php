<?php

return [
    /*
       |--------------------------------------------------------------------------
       | AWS Textract Client
       |--------------------------------------------------------------------------
       |
       | This file is for storing the credentials for AWS Textract Client.
       | This file provides the de facto
       | location for this type of information, allowing packages to have
       | a conventional file to locate the various service credentials.
       |
       */
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
    'url' => env('AWS_URL'),
    'endpoint' => env('AWS_ENDPOINT'),
    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
    'throw' => false,
    'report' => false,
];

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'n8n' => [
        'webhook_url' => env('N8N_WEBHOOK_URL'),
    ],

    /*
    |--------------------------------------------------------------------------
    | AiCheck Service
    |--------------------------------------------------------------------------
    |
    | External AI-based test bank quality assessment service. Laravel proxies
    | uploaded .doc/.docx files to this HTTP API and receives structured
    | assessment JSON plus base64-encoded PDFs.
    |
    */
    'aicheck' => [
        // Base URL of FastAPI service, e.g. http://localhost:41791 or https://aicheck.your-domain.com
        'url' => env('AICHECK_API_URL'),

        // Optional shared secret; if set, will be sent as X-API-Key or Bearer token.
        'api_key' => env('AICHECK_API_KEY'),
    ],


];

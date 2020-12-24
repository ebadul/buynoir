<?php

return [
    [
        'key'  => 'customer.social_login',
        'name' => 'saas::app.admin.system.social-login',
        'sort' => 4,
    ], [
        'key'    => 'customer.social_login.facebook',
        'name'   => 'saas::app.admin.system.facebook',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'FACEBOOK_CLIENT_ID',
                'title'         => 'saas::app.admin.system.facebook-client-id',
                'type'          => 'text',
                'channel_based' => true,
            ], [
                'name'          => 'FACEBOOK_CLIENT_SECRET',
                'title'         => 'saas::app.admin.system.facebook-client-secret',
                'type'          => 'text',
                'channel_based' => true,
            ], [
                'name'          => 'FACEBOOK_CALLBACK_URL',
                'title'         => 'saas::app.admin.system.facebook-callback-url',
                'type'          => 'text',
                'channel_based' => true,
            ],
        ],
    ], [
        'key'    => 'customer.social_login.twitter',
        'name'   => 'saas::app.admin.system.twitter',
        'sort'   => 2,
        'fields' => [
            [
                'name'          => 'TWITTER_CLIENT_ID',
                'title'         => 'saas::app.admin.system.twitter-client-id',
                'type'          => 'text',
                'channel_based' => true,
            ], [
                'name'          => 'TWITTER_CLIENT_SECRET',
                'title'         => 'saas::app.admin.system.twitter-client-secret',
                'type'          => 'text',
                'channel_based' => true,
            ], [
                'name'          => 'TWITTER_CALLBACK_URL',
                'title'         => 'saas::app.admin.system.twitter-callback-url',
                'type'          => 'text',
                'channel_based' => true,
            ],
        ],
    ], [
        'key'    => 'customer.social_login.google',
        'name'   => 'saas::app.admin.system.google',
        'sort'   => 3,
        'fields' => [
            [
                'name'          => 'GOOGLE_CLIENT_ID',
                'title'         => 'saas::app.admin.system.google-client-id',
                'type'          => 'text',
                'channel_based' => true,
            ], [
                'name'          => 'GOOGLE_CLIENT_SECRET',
                'title'         => 'saas::app.admin.system.google-client-secret',
                'type'          => 'text',
                'channel_based' => true,
            ], [
                'name'          => 'GOOGLE_CALLBACK_URL',
                'title'         => 'saas::app.admin.system.google-callback-url',
                'type'          => 'text',
                'channel_based' => true,
            ],
        ],
    ], [
        'key'    => 'customer.social_login.linkedin',
        'name'   => 'saas::app.admin.system.linkedin',
        'sort'   => 4,
        'fields' => [
            [
                'name'          => 'LINKEDIN_CLIENT_ID',
                'title'         => 'saas::app.admin.system.linkedin-client-id',
                'type'          => 'text',
                'channel_based' => true,
            ], [
                'name'          => 'LINKEDIN_CLIENT_SECRET',
                'title'         => 'saas::app.admin.system.linkedin-client-secret',
                'type'          => 'text',
                'channel_based' => true,
            ], [
                'name'          => 'LINKEDIN_CALLBACK_URL',
                'title'         => 'saas::app.admin.system.linkedin-callback-url',
                'type'          => 'text',
                'channel_based' => true,
            ],
        ],
    ], [
        'key'    => 'customer.social_login.github',
        'name'   => 'saas::app.admin.system.github',
        'sort'   => 5,
        'fields' => [
            [
                'name'          => 'GITHUB_CLIENT_ID',
                'title'         => 'saas::app.admin.system.github-client-id',
                'type'          => 'text',
                'channel_based' => true,
            ], [
                'name'          => 'GITHUB_CLIENT_SECRET',
                'title'         => 'saas::app.admin.system.github-client-secret',
                'type'          => 'text',
                'channel_based' => true,
            ], [
                'name'          => 'GITHUB_CALLBACK_URL',
                'title'         => 'saas::app.admin.system.github-callback-url',
                'type'          => 'text',
                'channel_based' => true,
            ],
        ],        
    ]
];
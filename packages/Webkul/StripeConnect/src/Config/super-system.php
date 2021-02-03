<?php

return [
    [
        'key' => 'sales.paymentmethods',
        'name' => 'stripe_saas::app.super.config.system.stripe',
        'sort' => 2,
    ], [
        'key'       => 'sales.paymentmethods.stripe',
        'name'      => 'stripe_saas::app.super.config.system.stripe',
        'sort'      => 1,
        'fields'    => [
            [
                'name'      => 'active',
                'title'     => 'stripe_saas::app.super.config.system.status',
                'type'      => 'select',
                'options'   => [
                    [
                        'title' => 'stripe_saas::app.super.config.system.active',
                        'value' => true
                    ], [
                        'title' => 'stripe_saas::app.super.config.system.in-active',
                        'value' => false
                    ]
                ],
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => false
            ], [
                'name'          => 'title',
                'title'         => 'stripe_saas::app.super.config.system.title',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => true
            ], [
                'name'          => 'description',
                'title'         => 'stripe_saas::app.super.config.system.description',
                'type'          => 'textarea',
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => true
            ], [
                'name'      => 'mode',
                'title'     => 'stripe_saas::app.super.config.system.mode',
                'type'      => 'select',
                'options'   => [
                    [
                        'title' => 'stripe_saas::app.super.config.system.sandbox',
                        'value' => 0
                    ], [
                        'title' => 'stripe_saas::app.super.config.system.production',
                        'value' => 1
                    ]
                ],
                'channel_based' => true,
                'locale_based'  => false
            ], [
                'name'          => 'client_id',
                'title'         => 'stripe_saas::app.super.config.system.client-id',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true
            ], [
                'name'          => 'test_publishable_key',
                'title'         => 'stripe_saas::app.super.config.system.test-publishable-key',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => false
            ], [
                'name'          => 'test_secret_key',
                'title'         => 'stripe_saas::app.super.config.system.test-secret-key',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => false
            ], [
                'name'          => 'live_publishable_key',
                'title'         => 'stripe_saas::app.super.config.system.live-publishable-key',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => false
            ], [
                'name'          => 'live_secret_key',
                'title'         => 'stripe_saas::app.super.config.system.live-secret-key',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => false
            ],
        ]
    ]
];
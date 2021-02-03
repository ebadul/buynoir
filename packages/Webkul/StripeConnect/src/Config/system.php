<?php

return [
    [
        'key'       => 'sales.paymentmethods.stripe',
        'name'      => 'stripe_saas::app.admin.config.system.stripe',
        'sort'      => 4,
        'fields'    => [
            [
                'name'          => 'fees',
                'title'         => 'stripe_saas::app.admin.config.system.stripe-fee',
                'type'          => 'select',
                'options'       => [
                    [
                        'title'     => 'stripe_saas::app.admin.config.system.seller',
                        'value'     => 'seller'
                    ], [
                        'title'     => 'stripe_saas::app.admin.config.system.customer',
                        'value'     => 'customer'
                    ]
                ],
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => false
            ], [
                'name'          => 'statement_descriptor',
                'title'         => 'stripe_saas::app.admin.config.system.statement-descriptor',
                'type'          => 'text',
                'validation'    => 'max:22',
                'channel_based' => true,
                'locale_based'  => true
            ],  [
                'name'    => 'sort',
                'title'   => 'stripe_saas::app.admin.config.system.sort-order',
                'type'    => 'select',
                'options' => [
                    [
                        'title' => '1',
                        'value' => 1
                    ], [
                        'title' => '2',
                        'value' => 2
                    ], [
                        'title' => '3',
                        'value' => 3
                    ], [
                        'title' => '4',
                        'value' => 4,
                    ], [
                        'title' => '5',
                        'value' => 5,
                    ]
                ],
            ]
        ]
    ]
];
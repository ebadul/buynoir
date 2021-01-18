<?php

return [
    [
        'key' => 'subscription',
        'name' => 'saassubscription::app.super-user.config.system.subscription',
        'sort' => 2,
    ], [
        'key' => 'subscription.payment',
        'name' => 'saassubscription::app.super-user.config.system.payment',
        'sort' => 1,
    ], [
        'key' => 'subscription.payment.general',
        'name' => 'saassubscription::app.super-user.config.system.general',
        'sort' => 1,
        'fields' => [
            [
                'name' => 'allow_trial',
                'title' => 'saassubscription::app.super-user.config.system.allow-trial',
                'type' => 'boolean',
            ], [
                'name' => 'trial_days',
                'title' => 'saassubscription::app.super-user.config.system.trial-days',
                'type' => 'text',
                'validation' => 'numeric',
            ], [
                'name' => 'trial_plan',
                'title' => 'saassubscription::app.super-user.config.system.trial-plan',
                'type' => 'select',
                'repository' => 'Webkul\SAASSubscription\Repositories\PlanRepository@getPlans',
            ]
        ]
    ], [
        'key' => 'subscription.payment.paypal',
        'name' => 'saassubscription::app.super-user.config.system.paypal',
        'sort' => 2,
        'fields' => [
            [
                'name' => 'sandbox_mode',
                'title' => 'saassubscription::app.super-user.config.system.sandbox-mode',
                'type' => 'boolean',
            ], [
                'name' => 'merchant_paypal_id',
                'title' => 'saassubscription::app.super-user.config.system.merchant-paypal-id',
                'type' => 'text',
                'validation' => 'required',
            ], [
                'name' => 'user_name',
                'title' => 'saassubscription::app.super-user.config.system.user-name',
                'type' => 'text',
                'validation' => 'required',
            ], [
                'name' => 'password',
                'title' => 'saassubscription::app.super-user.config.system.password',
                'type' => 'text',
                'validation' => 'required',
            ], [
                'name' => 'signature',
                'title' => 'saassubscription::app.super-user.config.system.signature',
                'type' => 'text',
                'validation' => 'required',
            ]
        ]
    ]
];
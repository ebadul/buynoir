<?php

return [
    [
        'key' => 'subscription',
        'name' => 'saassubscription::app.super-user.layouts.left-menu.subscription',
        'route' => 'super.subscription.plan.index',
        'sort' => 5,
        'icon-class' => 'company-icon',
    ], [
        'key' => 'subscription.plans',
        'name' => 'saassubscription::app.super-user.layouts.left-menu.plans',
        'route' => 'super.subscription.plan.index',
        'sort' => 1,
        'icon-class' => '',
    ], [
        'key' => 'subscription.recurring_profiles',
        'name' => 'saassubscription::app.super-user.layouts.left-menu.purchased-plans',
        'route' => 'super.subscription.recurring_profile.index',
        'sort' => 2,
        'icon-class' => '',
    ], [
        'key' => 'subscription.invoices',
        'name' => 'saassubscription::app.super-user.layouts.left-menu.invoices',
        'route' => 'super.subscription.invoice.index',
        'sort' => 3,
        'icon-class' => '',
    ]
];
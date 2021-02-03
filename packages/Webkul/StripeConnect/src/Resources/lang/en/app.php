<?php

return  [
    'super'    => [
        'config'    => [
            'system'    => [
                'stripe'        => 'Stripe Connect Payment',
                'status'        => 'Status',
                'active'        => 'Active',
                'in-active'     => 'In-Active',
                'title'         => 'Title',
                'description'   => 'Description',
                'mode'          => 'Mode',
                'sandbox'       => 'Sandbox',
                'production'    => 'Production',
                'client-id'     => 'Client Id',
                'test-publishable-key'  => 'Test Publishable Key',
                'test-secret-key'       => 'Test Secret Key',
                'live-publishable-key'  => 'Live Publishable Key',
                'live-secret-key'       => 'Live Secret Key',
            ],
        ],
    ],

    'admin' => [
        'config'    => [
            'system'    => [
                'stripe'                => 'Stripe Connect Payment',
                'connect-account'       => 'Connect Account',
                'stripe-fee'            => 'Stripe Fee to be paid by Customer/Seller',
                'seller'                => 'Seller',
                'customer'              => 'Customer',
                'statement-descriptor'  => 'Statement Descriptor',
                'sort-order'            => 'Sort Order',
            ],
        ],
        'stripe'    => [
            'title'             => 'Connect Your Stripe Account',
            'client-id-missing' => 'The Client-Id has not been setup by Super Admin for the platform.',
            'click-here'        => 'Click Here',
            'revoke-access'     => 'Revoke Your Stripe Account Access',
            'connect-stripe'    => 'Connect Stripe',
            'account-connected' => 'Success: Your Stripe account is integrated with the platform successfully',
            'problem-connecting'=> 'Warning: There was some problem in onboarding your account.',
            'stripe-revoked'    => 'Success: Your stripe account has been revoked from the platform successfully.',
        ]
    ],

    'shop'  => [
        'checkout'  => [
            'total' => [
                'transaction-fee'       => 'Stripe Txn Fee',
                'more-info'             => ' (After Successful Order)',
                'pay-now'               => 'Pay Now',
                'pay-with-saved-card'   => 'Pay with saved card',
                'delete'                => 'Delete',
                'pay-with-new-card'     => 'Pay with new card',
                'provide-api-key'       => 'Warning: Payment denied, API key is missing.',
                'payment-failed'        => 'Payment can not be done through Stripe',
                'something-went-wrong'  => 'Warning: Something went wrong, please try again later.',
            ]
        ]
    ],

    'configuration-added'   => 'Configuration Successfully Added',
    'save'                  => 'Save',
    'general'               => 'General',
    'stripe'                => 'Stripe',
    'configuration'         => 'Configuration',
    'nameoncard'            => 'Name on Card',
    'not-ready'             => 'This seller ain\'t Stripe ready',
    'stripe-unavailable'    => 'Stripe unavailable for this seller',
    'expirymonth'           => 'Expiration Month',
    'expiryyear'            => 'Expiration Year',
    'cvc'                   => 'CVC',
    'cardno'                => 'Card Number',
    'paynow'                => 'Pay Now',
    'errors-in-fields'      => 'Please correct the errors and try
    again',
    'add-card'              => 'Pay With New Card',
    'remember-card'         => 'Remember Card',
    'pay'                   => 'Pay',
    'payment-success'       => 'Success! Payment Done',
    'click-continue'        => 'Click continue to proceed further',
    'some-error'            => 'Some error occurred',
    'continue'              => 'Please click on continue to complete your transaction',
];


<?php

return [

    'custom_ship_one' => [
        'code'         => 'custom_ship_one',
        'title'        => 'Custom Shipping One',
        'description'  => 'Custom Shipping Description',
        'active'       => true,
        'default_rate' => '0',
        'type'         => 'per_order',
        'class'        => 'Custom\CustomShipping\Carriers\CustomShipOne',
    ],


    'custom_ship_two' => [
        'code'         => 'custom_ship_two',
        'title'        => 'Custom Shipping Two',
        'description'  => 'Custom Shipping Description',
        'active'       => true,
        'default_rate' => '0',
        'type'         => 'per_order',
        'class'        => 'Custom\CustomShipping\Carriers\CustomShipTwo',
    ],

];
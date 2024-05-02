<?php

return [
    'outletpickup' => [
        'code'         => 'outletpickup',
        'title'        => 'Pickup from Outlet',
        'description'  => 'Pickup from Outlet',
        'active'       => true,
        'default_rate' => '10',
        'type'         => 'per_unit',
        'class'        => 'Cyntrek\OutletPickup\Carriers\OutletPickup',
    ],
];

<?php

return [
    [
        'key'    => 'sales.payment_methods.marx',
        'name'   => 'Marx',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'title',
                'title'         => 'Title',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name'          => 'description',
                'title'         => 'Description',
                'type'          => 'textarea',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name'          => 'active',
                'title'         => 'Status',
                'type'          => 'boolean',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ],
        ],
    ],
];

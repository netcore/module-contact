<?php

return [

    // Items cache key
    'items_cache_key' => 'contact_items',

    // Notification email
    'notify'          => [
        'enabled'        => true,
        'email_template' => null,
        'email_subject'  => 'New contact message'
    ],

    // some projects don't have text-block, that's why we can disable it
    'text-block'      => true,

    // some projects don't have map in contacts page, that's why we can disable it
    'map'             => true,
    'maps_api_key'    => '',

    // some projects don't have information block, that's why we can disable it
    'information'     => [
        'enabled'       => true, // this variable is responsible whether to use this block or not.

        // variables below are responsible for what information you want show in information block
        'phone'         => true,
        'email'         => true,
        'workdays'      => true,
        'location'      => true,
        'contact-email' => true,
        'contact-form'  => true
    ],

    'form-data' => [
        [
            'key'          => 'name',
            'type'         => 'text',
            'meta'         => [
                'attributes' => ['required'],
                'options'    => [],
                'validation' => ['required'],
            ],
            'translations' => [
                'en' => [
                    'label' => 'Name'
                ]
            ]
        ],
        [
            'key'          => 'email',
            'type'         => 'text',
            'meta'         => [
                'attributes' => ['required'],
                'options'    => [],
                'validation' => ['required', 'email'],
            ],
            'translations' => [
                'en' => [
                    'label' => 'Email'
                ]
            ]
        ],
        [
            'key'          => 'ad_id',
            'type'         => 'text',
            'meta'         => [
                'attributes' => ['required'],
                'options'    => [],
                'validation' => ['required'],
            ],
            'translations' => [
                'en' => [
                    'label' => 'AD ID'
                ]
            ]
        ],
        [
            'key'          => 'phone',
            'type'         => 'text',
            'meta'         => [
                'attributes' => ['required'],
                'options'    => [],
                'validation' => ['required'],
            ],
            'translations' => [
                'en' => [
                    'label' => 'Phone'
                ]
            ]
        ],
        [
            'key'          => 'message',
            'type'         => 'textarea',
            'meta'         => [
                'attributes' => ['required'],
                'options'    => [],
                'validation' => ['required'],
            ],
            'translations' => [
                'en' => [
                    'label' => 'Message'
                ]
            ]
        ]
    ],

    'location-data' => [
        'en' => [
            'lat'           => '56.5130713',
            'lng'           => '27.3348303',
            'address_full'  => 'Atbrīvošanas aleja, Rēzekne',
            'address_short' => 'Atbrīvošanas aleja',
            'country'       => 'Latvia',
            'city'          => 'Rēzekne',
            'zip_code'      => 'LV4601',
        ]
    ]
];

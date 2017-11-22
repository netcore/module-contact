<?php

return [
    // some projects don't have text-block, that's why we can disable it
    'text-block'  => true,

    // some projects don't have map in contacts page, that's why we can disable it
    'map'         => true,

    // some projects don't have information block, that's why we can disable it
    'information' => [
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
    ]
];

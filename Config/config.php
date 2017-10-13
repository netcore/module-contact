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
        'contact-email' => true,
        'contact-form'  => true
    ]
];


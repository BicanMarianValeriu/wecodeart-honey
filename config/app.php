<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Skin General
    |--------------------------------------------------------------------------
    |
    | Milascenous options.
    |
    */
    'tickets'   => false, // Not yet developed
    'reports'   => false, // Not yet developed
    'documents' => [
        'per_page'  => get_option( 'posts_per_page' ),
    ],
    'remove_post'   => true,
    'logo'      => [
        'width'     => 50,
        'height'    => 50
    ],
    'scripts'   => [
        'footer' => true, // Load jQuery in Footer
    ],
];
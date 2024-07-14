<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Delivery Provider
    |--------------------------------------------------------------------------
    |
    | This option controls the default delivery provider that will be used by
    | the framework.
    |
    */

    'default' => env('DELIVERY_PROVIDER', 'novaposhta'),

    /*
    |--------------------------------------------------------------------------
    | Delivery Providers
    |--------------------------------------------------------------------------
    |
    |
    */

    'providers' => [
        'novaposhta' => [
            'driver' => 'novaposhta',
            'address' => "429 Keely Walk Suite 179\n Kaylahland, WV 80901-4910",
//            'connection' => env('DELIVERY_NOVAPOSHTA_CONNECTION'),
//            'key' => env('DELIVERY_NOVAPOSHTA_KEY'),
        ],
    ],

];

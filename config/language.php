<?php

return [
    'available_languages' => [
        'ua' => ['locale' => 'ua', 'prefix' => 'ua'],
        'ru' => ['locale' => 'ru', 'prefix' => 'ru'],
        'en' => ['locale' => 'en', 'prefix' => 'en']
    ],
    'enabled_languages' => explode(',', env('ENABLED_LANGUAGES', 'ua,ru,en'))
];

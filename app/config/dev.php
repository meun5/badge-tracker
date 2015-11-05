<?php

return [
    'app'   => [
        'url'       => 'http://localhost/',
        'name'      => 'Merit-Tracker',
        'version'   => '0.1.4.4',
        'author'    => 'Alex Young',
        'hash' => [
            'algo'  => PASSWORD_BCRYPT,
            'cost'  => 10,
        ],
        'webmaster' => 'webmaster@example.org',
        'timezone'  => ini_get('date.timezone') ? ini_get('date.timezone') : 'America/Chicago', /* See http://php.net/manual/en/timezones.php for the setting that corresponds to where you server is operating. */
    ],

    'db'    => [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'name'      => 'database-name',
        'username'  => 'username',
        'password'  => 'password',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ],

    'auth'  => [
        'session'   => 'user_id',
        'remember'  => 'user_rem',
    ],

    'mail'  => [
        'smtp_auth'     => true,
        'smtp_secure'   => 'tls',
        'host'          => 'smtp.example.org',
        'username'      => 'username@example.org',
        'password'      => 'password',
        'port'          => 587,
        'html'          => true,
        'debug'         => 2,
    ],
    
    'twig'  => [
        'debug'     => true,
    ],
    
    'csrf'  => [
        'key'   => 'csrf_token',
    ],

    "excel" => [
        "cache_session" => 'excel_cache',
    ],
];

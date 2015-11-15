<?php

return [
    'app'   => [
        'url'       => 'http://example.org',
        'name'      => 'Merit-Tracker',
        'version'   => '0.1.4.4',
        'author'    => 'Alex Young',
        'hash'  => [
            'algo'  => PASSWORD_BCRYPT,
            'cost'  => 25,
        ],
        'webmaster' => 'webmaster@example.org',
        'timezone'  => ini_get('date.timezone') ? ini_get('date.timezone') : 'America/Chicago', /* See http://php.net/manual/en/timezones.php for the setting that corresponds to where you server is operating. */
    ],

    'db'    => [
        'driver'    => 'mysql',
        'host'      => 'sql.example.org',
        'name'      => 'database-name',
        'username'  => 'user',
        'password'  => 'password',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => 'tr_',
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
        'debug'         => 0,
    ],

    'twig'  => [
        'debug'     => false,
    ],
    
    'csrf'  => [
        'key'   => 'csrf_token',
    ],

    "excel" => [
        "cache_session" => 'excel_cache',
    ],
];

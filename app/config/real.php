<?php

return [
    'app'   => [
        'url'   => 'https://frozen-river-2797.herokuapp.com',
        'name'   => 'Merit-Tracker',
        'version'   => '0.1.4.4',
        'author'   => 'Alex Young',
        'hash'  => [
            'algo'  => PASSWORD_BCRYPT,
            'cost'  => 30,
        ],
        "webmaster" => "webmaster@example.org",
        "timezone"  => "America/Chicago",
    ],
    'db'    => [
        'driver'    => 'mysql',
        'host'      => 'us-cdbr-iron-east-03.cleardb.net',
        'name'      => 'heroku_eea11ce40e9179c',
        'username'  => 'bf1fdc5408ddd7',
        'password'  => 'b2b82c0c',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => 'tr_',
    ],
    "auth"  => [
        "session"   => "user_id",
        "remember"  => "user_rem",
    ],
    'mail'  => [
        'smtp_auth'     => true,
        'smtp_secure'   => 'tls',
        'host'          => 'smtp-mail.outlook.com',
        'username'      => 'clamy4@msn.com',
        'password'      => 'duffer6',
        'port'          => 587,
        'html'          => true,
        'debug'         => 0,
    ],

    "twig"  => [
        "debug"     => false,
    ],

    'csrf'  => [
        'key'   => 'csrf_token',
    ],

    "excel" => [
        "cache_session" => "excel_cache",
    ],
];

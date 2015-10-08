<?php

return [
    'app'   => [
        'url'       => 'http://localhost/scout-merit/public',
        'name'      => 'Merit-Tracker',
        'version'   => '0.1.3.2',
        'author'    => 'Alex Young',
        'hash'  => [
            'algo'  => PASSWORD_BCRYPT,
            'cost'  => 15,
        ],
        'webmaster' => 'clamy4@msn.com',
    ],

    'db'    => [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'name'      => 'testing',
        'username'  => 'testinguser',
        'password'  => 'Z7LBVnKjaK',
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
    ],

    'twig'  => [
        'debug'     => true,
    ],

    'csrf'  => [
        'key'   => 'csrf_token',
    ],

    'checkout' => [
        'session' => 'checkout_session',
    ],
];

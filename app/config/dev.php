<?php

return [
    'app'   => [
        'url'   => 'http://localhost/scout/',
        'name'   => 'Merit-Tracker',
        'version'   => '0.0.1.0',
        'author'   => 'Alex Young',
        'hash'  => [
            'algo'  => PASSWORD_BCRYPT,
            'cost'  => 10
        ],

        'webmaster' => 'clamy4@msn.com',
    ],

    'db'    => [
        'driver'    => 'mysql',
        'host'      => 'sql.example.org',
        'name'      => 'data-name',
        'username'  => 'user',
        'password'  => 'password',
        'charset'   => 'utf8',
        'collation'     => 'utf8_unicode_ci',
        'prefix'    => '',
    ],

    'auth'  => [
        'session'   => 'usr_id',
        'remember'  => 'usr_rem',
    ],

    'mail'  => [
        'smtp_auth'     => true,
        'smtp_secure'   => 'tls',
        'host'          => 'smtp.troop43.org',
        'username'      => 'username@troop43.prg',
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
];

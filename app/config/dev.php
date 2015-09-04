<?php

return [
    'app'   => [
        'url'   => 'http://localhost/scouts/',
        'name'   => 'Merit-Tracker',
        'version'   => '0.0.0.1',
        'author'   => 'Alex Young',
        'hash'  => [
            'algo'  => PASSWORD_BCRYPT,
            'cost'  => 10
        ],

        'webmaster' => 'clamy4@msn.com',
    ],

    'db'    => [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'name'      => 'data-name',
        'username'  => 'meun5',
        'password'  => 'password',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
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

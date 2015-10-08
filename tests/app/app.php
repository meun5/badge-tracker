<?php

use Slim\Views\Twig;
use Slim\Views\TwigExtension;

use RandomLib\Factory as RandomLib;

use app\Helpers\Hash;
use app\Validation\Validator;

use app\User\User;
use app\Scouts\Scouts;
use app\Metadata\Metadata;
use app\Gear\Gear;

use app\MiddleWare\BeforeMiddleWare;
use app\MiddleWare\CsrfMiddleWare;

$app->add(new BeforeMiddleWare);
$app->add(new CsrfMiddleWare);

require '/../require/database.php';
require INC_ROOT . '/app/filters.php';
require INC_ROOT . '/app/routes.php';


$app->container->set('user', function () {
    return new User;
});

$app->container->set('scouts', function () {
    return new Scouts;
});

$app->container->set('metadata', function () {
    return new Metadata;
});

$app->container->set('gear', function () {
    return new Gear;
});

$app->container->singleton('hash', function () use ($app) {
    return new Hash($app->config);
});

$app->container->singleton('validation', function () use ($app) {
    return new Validator($app->user, $app->hash, $app->auth);
});

$app->container->singleton('mail', function () use ($app) {
    $mailer = new PHPMailer;

    $mailer->isSMTP();
    $mailer->Host = $app->config->get('mail.host');
    $mailer->SMTPAuth = $app->config->get('mail.smtp_auth');
    $mailer->SMTPSecure = $app->config->get('mail.smtp_secure');
    $mailer->Port = $app->config->get('mail.port');
    $mailer->Username = $app->config->get('mail.username');
    $mailer->Password = $app->config->get('mail.password');
    $mailer->SMTPDebug = 2;

    $mailer->isHTML($app->config->get('mail.html'));

    return new Mailer($app->view, $mailer);
});

$app->container->singleton('randomlib', function () {
    $factory = new RandomLib;
    return $factory->getMediumStrengthGenerator();
});

$view = $app->view();

$view->parserOptions = [
    'debug' => $app->config->get('twig.debug')
];

$view->parserExtensions = [
    new TwigExtension,
    new Twig_Extension_Debug,
];

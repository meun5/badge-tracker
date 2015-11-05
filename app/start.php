<?php

use Slim\Slim;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

use Noodlehaus\Config;

use RandomLib\Factory as RandomLib;

use app\Helpers\Hash;
use app\Helpers\Excel;
use app\Validation\Validator;

use app\User\User;
use app\Scouts\Scouts;
use app\Metadata\Metadata;
use app\Gear\Gear;
use app\Mail\Mailer;

use app\MiddleWare\BeforeMiddleWare;
use app\MiddleWare\CsrfMiddleWare;

session_cache_limiter(false);
session_start();

define('INC_ROOT', dirname(__DIR__));

require INC_ROOT . '/vendor/autoload.php';

$app = new Slim([
    'mode' => implode('', file(INC_ROOT . '/mode.php', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)),
    'view' => new Twig(),
    'templates.path' => INC_ROOT . '/app/views'
]);

$app->add(new BeforeMiddleWare);
$app->add(new CsrfMiddleWare);

$app->configureMode($app->config('mode'), function () use ($app) {
    $app->config = Config::load(INC_ROOT . "/app/config/{$app->mode}.php");
});

date_default_timezone_set($app->config->get("app.timezone"));

require 'database.php';
require 'filters.php';
require 'routes.php';


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

$app->container->singleton('excel', function () use ($app) {
    return new Excel($app);
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
    $mailer->setFrom($app->config->get('app.webmaster'), $_SERVER["SERVER_SOFTWARE"]);
    $mailer->Username = $app->config->get('mail.username');
    $mailer->Password = $app->config->get('mail.password');
    $mailer->SMTPDebug = $app->config->get('mail.debug');

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

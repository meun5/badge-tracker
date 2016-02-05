<?php

session_start();

require_once("../vendor/autoload.php");

$configuration = [
    "settings" => [
        "displayErrorDetails" => true,
        "determineRouteBeforeAppMiddleware" => true,
    ],
];

$container = new \Slim\Container($configuration);

require_once("container.php");

$app = new \Slim\App($container);

$monolog = $app->getContainer()["monolog"];

$monolog->addInfo("Slim MicroFramework " . $app::VERSION . " starting up.");

require_once("postContainer.php");

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("../resources/routes"));
foreach ($iterator as $file) {
    $fname = $file->getFilename();
    if (preg_match("%\.php$%", $fname)) {
        require_once($file->getPathname());
    }
}

require_once("database.php");

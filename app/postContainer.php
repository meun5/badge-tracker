<?php

$app->add($app->getContainer()["csrf"]);

$app->add($app->getContainer()["auth"]);

$app->add(new \app\Middleware\Before($app->getContainer()["view"], $app->getContainer()["router"], $app->getContainer()["monolog"]));

$app->add(new \app\Middleware\CSRF($app->getContainer()["csrf"], $app->getContainer()["view"]));

<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$container = $app->getContainer();
$config = $container->get("config");

$capsule = new Capsule;

$driver = $config->get("db.driver");

$capsule->addConnection([
    "driver"    => $driver,
    "host"      => $config->get("db.$driver.host"),
    "database"  => $config->get("db.$driver.dbname"),
    "username"  => $config->get("db.$driver.username"),
    "password"  => $config->get("db.$driver.password"),
    "prefix"    => $config->get("db.$driver.prefix"),
    "charset"    => $config->get("db.$driver.charset"),
    "collation"    => $config->get("db.$driver.collation"),
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();

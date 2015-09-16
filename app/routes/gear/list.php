<?php

$app->get('/gear/list', function () use ($app) {
    $gear = $app->gear;

    var_dump($gear->getAll());
})->name("gear.list");

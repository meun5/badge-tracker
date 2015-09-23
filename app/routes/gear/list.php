<?php

$app->get('/gear/list', function () use ($app) {
    $gear = $app->gear;
    $allgear = $gear->getAll();
    var_dump($gear->getAll());
})->name("gear.list");

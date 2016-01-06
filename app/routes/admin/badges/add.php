<?php

$app->get("/admin/badges/add", $admin(), function () use ($app) {
    $app->render("/admin/badges/add.twig");
})->name("admin.badges.add");

$app->post("/admin/badges/add", $admin(), function () use ($app) {
    return var_dump($app->request->post());
})->name("admin.badges.add.post");

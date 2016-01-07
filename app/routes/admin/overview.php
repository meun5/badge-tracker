<?php

$app->get("/admin", $admin(), function () use ($app) {
    $app->render("/admin/scouts.twig");
})->name("admin.home");

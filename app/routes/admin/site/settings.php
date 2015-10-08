<?php

$app->get('/admin/settings', $admin(), function () use ($app) {
    $config = $app->config;
    $settings = [
        "app" => [
            "url" => $config->get('app.url'),
            "name" => $config->get('app.name'),
            "webmaster" => $config->get('app.webmaster'),
        ],
        "database" => [
            "host" => $config->get('db.host'),
            "table" => $config->get('db.name'),
            "driver" => $config->get('db.driver'),
        ],
        "mail" => [
            "host" => $config->get('mail.host'),
            "username" => $config->get('mail.username'),
        ],
    ];


    $app->render('admin/site/settings.twig', [
        'settings' => $settings,
    ]);
})->name("admin.site.settings");

$app->get('/admin/settings/edit', $admin(), function () use ($app) {
    $config = $app->config;
    $settings = [
        "app" => [
            "url" => $config->get('app.url'),
            "name" => $config->get('app.name'),
            "webmaster" => $config->get('app.webmaster'),
        ],
        "database" => [
            "host" => $config->get('db.host'),
            "table" => $config->get('db.name'),
            "driver" => $config->get('db.driver'),
        ],
        "mail" => [
            "host" => $config->get('mail.host'),
            "username" => $config->get('mail.username'),
        ],
    ];


    $app->render('admin/site/edit.twig', [
        'settings' => $settings,
    ]);
})->name("admin.site.settings.edit");

$app->post("/admin/settings/edit", $admin(), function () use ($app) {
    $app->response->headers->set("Content-Type", "application/json");
    echo json_encode($app->request->post());
    return;
})->name("admin.site.settings.edit.post");

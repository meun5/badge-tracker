<?php

$app->get('/admin/gear/add', $admin(), function () use ($app) {
    $app->render('admin/gear/add.twig');
})->name("admin.gear.add");

$app->post('/admin/gear/add', $admin(), function () use ($app) {
    $gear = $app->gear;
    $post = $app->request->post();

    $v = $app->validation;

    $v->validate([

    ]);
})->name("admin.gear.add.post");

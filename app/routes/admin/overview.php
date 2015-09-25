<?php

$app->get('/admin', $admin(), function () use ($app) {
    $scouts = $app->scouts->where('active', true)->get();

    $app->render('/admin/scouts.twig', [
        'scouts' => $scouts,
    ]);
})->name("admin.home");

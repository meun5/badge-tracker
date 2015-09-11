<?php

use app\User\UserPermission;

$app->get('/admin', $admin(), function () use ($app) {
    $scouts = $app->scouts->where('active', true)->get();

    //$scouts = json_decode(base64_decode($scouts->metadata));

    $app->render('/admin/scouts.twig', [
        'scouts' => $scouts,
    ]);
})->name("admin.home");
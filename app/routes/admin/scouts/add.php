<?php

$app->get('/admin/scouts/add', $admin(), function () use ($app) {
    $badges = $app->metadata->listBadges();
    $app->render('/admin/scouts/add.twig', [
        'badges' => $badges,
    ]);
})->name('admin.scouts.add');

$app->post('/admin/scouts/add', $admin(), function () use ($app) {
    var_dump($app->request->post());
    return;
})->name('admin.scouts.add.post');

$app->post('/admin/scouts/add/badges', $admin(), function () use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');
    echo json_encode($app->request->post());
    return;
})->name('admin.badges.add.getBadges');

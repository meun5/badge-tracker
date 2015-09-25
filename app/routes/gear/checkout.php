<?php
$app->get('/gear/checkout', function () use ($app) {
    if (isset($_SESSION[$app->config->get("checkout.session")])) {
        $gear = $app->gear->where('id', $_SESSION[$app->config->get("checkout.session")])->first();
    } else {
        return $app->response->redirect($app->urlFor("gear.list"));
    }

    $app->render('/gear/checkout.twig', [
        'gear' => $gear,
    ]);
})->name("gear.checkout");

$app->post('/gear/checkout', function () use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');
    echo json_encode($app->request->post());
    return;
})->name("gear.checkout.post");

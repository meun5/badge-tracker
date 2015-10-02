<?php

$app->get('/gear/list', function () use ($app) {
    $allgear = $app->gear->getAll();

    $x = 0;
    foreach ($allgear as $history) {
        $allgear[$x]["checkout_history"] = json_decode($allgear[$x]->checkout_history);
        $x++;
    }

    $app->render('/gear/list.twig', [
        'gear' => json_decode($allgear),
    ]);
})->name("gear.list");

$app->post('/gear/list', function () use ($app) {
    if(isset($_SESSION[$app->config->get("checkout.session")])) { unset($_SESSION[$app->config->get("checkout.session")]); }

    $post = $app->request->post();

    $v = $app->validation;

    $v->validate([
        "id" => [$post["id"], 'required|int|min(2)']
    ]);
    if ($v->passes()) {
        $_SESSION[$app->config->get("checkout.session")] = $post["id"];
    }
    $app->response->headers->set('Content-Type', 'application/json');

    echo $v->constructArray(
        isset($_SESSION[$app->config->get("checkout.session")]) ? true : false,
        ! is_null($v->errors()) ? $v->errors : null,
        isset($_SESSION[$app->config->get("checkout.session")]) ? $app->urlFor("gear.checkout") : $app->urlFor("gear.list"),
        true);

    return;
})->name("gear.list.post");

<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->get("/", function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    $this->view->render($response, "home.twig");
})->setName("app.main");

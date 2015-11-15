<?php

use app\User\UserPermission;

$app->get('/register', $guest(), function () use ($app) {
    $app->render('auth/register.twig');
})->name('auth.register');

$app->post('/register', $guest(), function () use ($app) {
    $request = $app->request;

    $email = $request->post('inputEmail');
    $username = $request->post('inputUsername');
    $password = $request->post('inputPassword');
    $lastName = $request->post('inputLastName');
    $firstName = $request->post('inputFirstName');

    $v = $app->validation;

    $v->validate([
        'email'             => [$email, 'required|email|uniqueEmail'],
        'username'          => [$username, 'required|alnumDash|max(20)|uniqueUsername'],
        'password'          => [$password, 'required|min(6)'],
        'lastName'          => [$lastName, 'min(1)|alnumDash'],
        'firstName'          => [$firstName, 'min(1)|alnumDash'],
    ]);

    if ($v->passes()) {

        $user = $app->user->create([
            'email' => $email,
            'username' => $username,
            'password' => $app->hash->password($password),
            'active' => true,
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]);

        $user->permissions()->create(UserPermission::$defaults);

        if ($app->request->isAjax()) {
            echo $v->constructArray(true, null, null, $app->urlFor("home"), true);
            return;
        }

        return $app->response->redirect($app->urlFor('home'));
    } else {
        if ($app->request->isAjax()) {
            echo $v->constructArray(false, $v->errors(), null, $app->urlFor("auth.register"), true);
            return;
        }

        return $app->response->redirect($app->urlFor('auth.register'));
    }

    $app->render('auth/register.twig', [
        'errors'    => $v->errors(),
        'request'   => $request,
    ]);
})->name('auth.register.post');

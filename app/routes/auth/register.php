<?php

use app\User\UserPermission;

$app->get('/register', $guest(), function () use ($app) {
    $app->render('auth/register.twig');
})->name('auth.register');

$app->post('/register', $guest(), function () use ($app) {
    $request = $app->request;

    $email = $request->post('inputEmail');
    $username = $request->post('inputUser');
    $password = $request->post('inputPassword');

    $v = $app->validation;

    $v->validate([
        'email'             => [$email, 'required|email|uniqueEmail'],
        'username'          => [$username, 'required|alnumDash|max(20)|uniqueUsername'],
        'password'          => [$password, 'required|min(6)'],
    ]);

    if ($v->passes()) {
        $identifier = $app->randomlib->generateString(128);

        $user = $app->user->create([
            'email' => $email,
            'username' => $username,
            'password' => $app->hash->password($password),
            'active' => false,
            'active_hash' => $app->hash->hash($identifier)
        ]);

        $user->permissions()->create(UserPermission::$defaults);

        /*$app->mail->send('email/auth/registered.twig', ['user' => $user, 'identifier' => $identifier],
            function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Thank you for registering.');
            }
        );*/

        $app->flash('global', 'You have been successfully registered. Check your email for an link to activate your account.');
        return $app->response->redirect($app->urlFor('home'));
    }

    $app->render('auth/register.twig', [
        'errors'    => $v->errors(),
        'request'   => $request,
    ]);
})->name('auth.register.post');

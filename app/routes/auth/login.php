<?php

use Carbon\Carbon;

$app->get('/login', $guest(), function () use ($app) {
    $app->render('auth/login.twig');
})->name('auth.login');

$app->post('/login', $guest(), function () use ($app) {
    $request = $app->request;

    $user = $request->post('inputUser');
    $password = $request->post('inputPassword');
    $remember = $request->post('inputRemember');

    $v = $app->validation;

    $v->validate([
        'inputUser' => [$user, 'required'],
        'inputPassword' => [$password, 'required'],
    ]);

    if ($v->passes()) {
        $user = $app->user
            ->where('active', true)
            ->where( function ($query) use ($user) {
                    return $query->where('email', $user)
                                 ->orWhere('username', $user);
                })
            ->first();

        if ($user && $app->hash->passwordCheck($password, $user->password)) {
            $_SESSION[$app->config->get('auth.session')] = $user->id;

            if ($remember === 'on') {
                $rememberIdentifier = $app->randomlib->generateString(128);
                $rememberToken = $app->randomlib->generateString(128);
        
                $user->updateRememberCredentials(
                    $rememberIdentifier,
                    $app->hash->hash($rememberToken)
                );

                $app->setCookie(
                    $app->config->get('auth.remember'),
                    "{$rememberIdentifier}___{$rememberToken}",
                    Carbon::parse('+1 month')->timestamp
                );
            }

            if ($app->request->isAjax()) {
                echo json_encode([
                    'success' => true,
                    'url' => $app->urlFor('home'),
                ]);
                return;
            }
            return $app->response->redirect($app->urlFor('home'));

        } else {
            if ($app->request->isAjax()) {

                echo json_encode([
                    'success'   => false,
                    'errors'    => $v->errors(),
                    'url'       => $app->urlFor('auth.login'),
                ]);
                return;
            }
            return $app->response->redirect($app->urlFor('auth.login'));
        }
    }

    $app->render('auth/login.twig', [
        'errors' => $v->errors(),
        'request' => $request,
    ]);
})->name('auth.login.post');

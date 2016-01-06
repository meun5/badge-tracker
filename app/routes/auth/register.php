<?php

/**
 * FRC Scouting Application (Written for FRC Team 4646 ASAP )
 *
 * @author      Alexander Young <meun5@team4646.org>
 * @copyright   2015 Alexander Young
 * @link        https://github.com/meun5/asap-scouting
 * @license     https://github.com/meun5/asap-scouting/blob/master/LICENSE
 * @version     0.1.0
 */

use app\User\UserPermission;

$app->get("/register", $guest(), function () use ($app) {
    $app->render("auth/register.twig");
})->name("auth.register");

$app->post("/register", $guest(), function () use ($app) {
    $request = $app->request;

    $email = $request->post("email");
    $username = $request->post("user");
    $password = $request->post("password");
    $passwordMatch = $request->post("passwordMatch");
    $lastName = $request->post("LastName");
    $firstName = $request->post("FirstName");

    $v = $app->validation;

    $v->validate([
        "email"             => [$email, "required|email|uniqueEmail"],
        "username"          => [$username, "required|alnumDash|max(20)|uniqueUsername"],
        "password"          => [$password, "required|min(6)"],
        "passwordMatch"     => [$passwordMatch, "required|matchs(password)"],
        "lastName"          => [$lastName, "min(1)|alnumDash"],
        "firstName"         => [$firstName, "min(1)|alnumDash"],
    ]);

    if ($v->passes()) {

        $user = $app->user->create([
            "email" => $email,
            "username" => $username,
            "password" => $app->hash->password($password),
            "active" => true,
            "first_name" => $firstName,
            "last_name" => $lastName,
        ]);

        $user->permissions()->create(UserPermission::$defaults);

        $app->mail->send("email/auth/registered.twig.html", ["user" => $user, "identifier" => $identifier],
            function ($message) use ($user) {
                $message->to($user->email);
                $message->subject("Registration Successful");
            }
        );

        if ($app->request->isAjax()) {
            echo $v->constructArray(true, null, null, $app->urlFor("home"), true);
            return;
        }

        return $app->response->redirect($app->urlFor("home"));
    } else {
        if ($app->request->isAjax()) {
            echo $v->constructArray(false, $v->errors(), null, $app->urlFor("auth.register"), true);
            return;
        }

        return $app->response->redirect($app->urlFor("auth.register"));
    }

    $app->render("auth/register.twig", [
        "errors"    => $v->errors(),
        "request"   => $request,
    ]);
})->name("auth.register.post");

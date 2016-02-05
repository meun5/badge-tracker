<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->get("/login", function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    return $this->view->render($response, "auth/login.twig");
})->setName("auth.login.get");

$app->post("/login", function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    $params = $request->getParams();

    $user = $params["user"];
    $password = $params["password"];

    $v = $this->validation;

    $v->validate([
        "user" => [$user, "required|username"],
        "password" => [$password, "required|alnumDash|min(1)"],
    ]);

    if ($v->passes()) {
        $user = $this->user
            ->where("active", true)
            ->where(function ($query) use ($user) {
                    return $query->where("email", $user)
                                 ->orWhere("username", $user);
            })
            ->first();

        if ($user && $this->hash->passwordCheck($password, $user->password)) {
            $_SESSION[$this->config->get("services.authentication.session")] = $user->id;
            $response->write(json_encode(["success" => true]));
            $this->monolog->addInfo("User " . $user->username . " authenticated successfully!");
            $response = $response->withRedirect($this->router->pathFor("app.main"));
        }
    } else {
        $this->monolog->addInfo("Failed authentication attempt on user " . ($user) ? $user->username : "null");
        $response->write(var_dump($user));
        $response->write(var_dump($v->errors()));
    }
    
    return $response;
})->setName("auth.login.post");

$app->get("/logout", function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    unset($_SESSION[$this->config->get("services.authentication.session")]);
    $this->monolog->addInfo("User " . $this->auth->getRaw()["username"] . " logged out successfully!");
    return $response->withRedirect($this->router->pathFor("app.main"));
})->setName("auth.logout")->add(new \app\Authentication\Roles\Authenticated($app));

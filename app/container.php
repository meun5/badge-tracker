<?php

$container["config"] = function ($c) {
    return new \Noodlehaus\Config($configPath);
};

$container["view"] = function ($c) {
    $view = new \Slim\Views\Twig("../resources/views");
    
    $view->addExtension(new \Slim\Views\TwigExtension(
        $c["router"],
        $c["config"]->get("url")
    ));
    
    $view->addExtension(new Twig_Extension_Debug());
    
    $view->parserOptions = [
        "debug" => true
    ];
    
    return $view;
};

$container["user"] = function ($c) {
    return new \app\User\User;
};

$container["equipment"] = function ($c) {
    return new \app\Tent\Tent;
};

$container["monolog"] = function ($c) {
    $log = new \Monolog\Logger("application");
    $handler = new \Monolog\Handler\StreamHandler("../logs/" . date("Y-m-d") . ".log", \Monolog\Logger::DEBUG);
    $dateFormat = "Y n j, g:i a";
    $output = "%datetime% > %level_name% > %message% %context% %extra%\n";
    $formatter = new \Monolog\Formatter\LineFormatter($output, $dateFormat);
    $handler->setFormatter($formatter);
    $handler->setFormatter(new \Bramus\Monolog\Formatter\ColoredLineFormatter());
    $log->pushHandler($handler);

    return $log;
};

$container["mail"] = function ($c) {
    $mailer = new \PHPMailer\PHPMailer;

    $mailer->isSMTP();
    $mailer->Host = $c["config"]->get("services.mail.host");
    $mailer->SMTPAuth = $c["config"]->get("services.mail.smtp_auth");
    $mailer->SMTPSecure = $c["config"]->get("services.mail.smtp_secure");
    $mailer->Port = $c["config"]->get("services.mail.port");
    $mailer->Username = $c["config"]->get("services.mail.username");
    $mailer->Password = $c["config"]->get("services.mail.password");
    $mailer->SMTPDebug = $c["config"]->get("services.mail.debug");
    $mailer->isHTML = $c["config"]->get("services.mail.html");

    $mailer->setFrom($c["config"]->get("services.mail.fromEmail"));

    return new \app\Mail\Mailer($c["view"], $mailer);
};

$container["csrf"] = function ($c) {
    return new \Slim\Csrf\Guard;
};

$container["hash"] = function ($c) {
    return new \app\Hash\Hash($c["config"]);
};

$container["auth"] = function ($c) {
    return new \app\Authentication\Auth($c);
};

$container["validation"] = function ($c) {
    return new \app\Validation\Violin($c["user"], $c["hash"], $c["auth"]);
};

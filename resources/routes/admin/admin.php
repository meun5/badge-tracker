<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->group("/admin", function () {
    $this->get("/getPatrols", function (ServerRequestInterface $request, ResponseInterface $response, $args) {
        $patrols = $this->equipment->get();
        $out = [];

        foreach ($patrols as $patrol) {
            $out[] = $patrol->owner;
        }

        return $response->write(json_encode($out));
    })->setName("admin.");

    $this->get("/", function (ServerRequestInterface $request, ResponseInterface $response, $args) {
        $tents = $this->equipment->get();
        $this->view->render($response, "admin/overview.twig", [
            "tents" => $tents,
        ]);
    })->setName("admin.overview");

    $this->get("/tents", function (ServerRequestInterface $request, ResponseInterface $response, $args) {
        $this->view->render($response, "admin/new.twig");
    })->setName("admin.new.tent");

    $this->post("/tents", function (ServerRequestInterface $request, ResponseInterface $response, $args) {
        $params = $request->getParams();

        $this->validation->validate([
            "owner" => [$params["owner"], "required|alnumDash|min(1)"],
            "checkedout" => [$params["checkedout"], "required|max(2)|alnumDash"],
            "condition" => [$params["condition"], "alnumDash|min(1)"]
        ]);

        if ($this->validation->passes()) {
            $tent = $this->equipment->create([
                "owner" => $params["owner"],
                "checkedout" => $params["checkedout"],
                "condition" => $params["condition"],
            ]);

            return $response->write(json_encode(["item" => $tent, "success" => true]))/*->withRedirect($this->router->pathFor("admin.new.tent"))*/;
        }

        return $response->withStatus(500)->write(json_encode([$this->validation->errors(), "success" => false]));
    })->setName("admin.add.tent");
})->add(new \app\Authentication\Roles\Admin($app));

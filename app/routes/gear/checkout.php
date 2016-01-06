<?php
$app->get("/gear/checkout", function () use ($app) {
    if (isset($_SESSION[$app->config->get("checkout.session")])) {
        $gear = $app->gear->where("id", $_SESSION[$app->config->get("checkout.session")])->first();
    } else {
        return $app->response->redirect($app->urlFor("gear.list"));
    }

    $json = json_decode($gear["checkout_history"]);

    $gear["checkout_history"] = $json;

    $app->render("/gear/checkout.twig", [
        "gear" => $gear,
    ]);
})->name("gear.checkout");

$app->post("/gear/checkout", function () use ($app) {
    $gear = $app->gear->where("id", $_SESSION[$app->config->get("checkout.session")])->first();
    $post = $app->request->post();

    if ($app->request->isAjax()) {
        $app->response->headers->set("Content-Type", "application/json");
    }

    $json = json_decode($gear["checkout_history"]);

    $v = $app->validation;

    if (isset($post["inputDate"]) && isset($post["inputCheckOutName"])) {
        $mode = "out";

        $v->validate([
            "inputDate" => [$post["inputDate"], "required|date|not_null"],
            "inputCheckOutName" => [$post["inputCheckOutName"], "required|not_null"],
        ]);
    } elseif (isset($post["inputDateIn"]) && isset($post["inputCheckInName"])) {
        $mode = "in";

        $v->validate([
            "inputDateIn" => [$post["inputDateIn"], "required|date|not_null"],
            "inputCheckInName" => [$post["inputCheckInName"], "required|not_null"],
            "id" => [$post["inputCheckInName"], "required|not_null"]
        ]);
    }

    if ($v->passes()) {
        if ($mode == "in") {
            $json[$post["id"]] = [
                "name" => $json[$post["id"]]->name,
                "dateOut" => $json[$post["id"]]->dateOut,
                "dateIn" => $post["inputDateIn"],
            ];

            $update = $gear->updateCheckOut(json_encode($json));

            if ($update) {
                echo $v->constructArray(true, null, null, $app->urlFor("gear.checkout"), true);
                return;
            }
            echo $v->constructArray(false, null, "Process Error", $app->urlFor("gear.checkout"), true);
            return;
        } elseif ($mode == "out") {
            $json[] = [
                "name" => $post["inputCheckOutName"],
                "dateOut" => $post["inputDate"],
                "dateIn" => "",
            ];

            $update = $gear->updateCheckOut(json_encode($json));

            if ($update) {
                echo $v->constructArray(true, null, null, $app->urlFor("gear.checkout"), true);
                return;
            }
            echo $v->constructArray(false, null, "Process Error", $app->urlFor("gear.checkout"), true);
            return;
        }
        return;
    } elseif ($v->errors()) {
        echo $v->constructArray(false, $v->errors(), null, $app->urlFor("gear.checkout"), true);
        return;
    }
    return;
})->name("gear.checkout.post");

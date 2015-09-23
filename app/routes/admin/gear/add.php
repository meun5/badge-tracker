<?php

$app->get('/admin/gear/add', $admin(), function () use ($app) {
    $app->render('admin/gear/add.twig');
})->name("admin.gear.add");

$app->post('/admin/gear/add', $admin(), function () use ($app) {
    $gear = $app->gear;
    $post = $app->request->post();

    if ($app->request->isAjax()) {
        $app->response->headers->set('Content-Type', 'application/json');
    }

    $v = $app->validation;

    $v->validate([
        "inputName" => [$post["inputName"], 'required|alnumDashSpc|not_null'],
        "inputAmount" => [$post["inputAmount"], 'required|int|not_null'],
        "inputBrand" => [$post["inputBrand"], 'required|alnumDashSpc|not_null'],
        "inputSerial" => [$post["inputSerial"], 'alnumDash|not_null'],
    ]);

    if ($v->passes()) {
        if (isset($post["inputCheckOut"])) {
            if ($post["inputCheckOut"] === "on") {
                $v->validate([
                    "inputDate" => [$post["inputDate"], 'required|date|not_null'],
                    "inputCheckOutName" => [$post["inputCheckoutName"], 'required|not_null'],
                ]);
                
                if ($v->passes()) {
                    $json = [];

                    $json[] = [
                        "name" => $post["inputCheckoutName"],
                        "date" => $post["inputDate"],
                    ];

                    $json = json_encode($json);
                }
            }
        }
        
        $create = $gear->create([
            "name" => $post["inputName"],
            "brand" => $post["inputBrand"],
            "amount" => $post["inputAmount"],
            "enabled" => true,
            "check" => (isset($post["inputCheck"])) ? true : false,
            "checkout_history" => (isset($json)) ? $json : null,
        ]);

        if ($app->request->isAjax() && isset($create)) {
            echo $v->constructArray(true, $app->urlFor("admin.gear.add"), true);
            return;
        } elseif (isset($create)) {
            $app->render('admin/gear/add.twig', [
                "success" => true,
            ]);
            return;
        }
    }
    
    if ($app->request->isAjax()) {
        echo $v->constructArray(false, $v->errors(), $app->urlFor("admin.gear.add"), true);
        return;
    }

    $app->render('admin/gear/add.twig', [
        "success" => false,
        "errors" => $v->errors(),
    ]);

})->name("admin.gear.add.post");

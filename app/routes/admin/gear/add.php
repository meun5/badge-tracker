<?php

$app->get('/admin/gear/add', $admin(), function () use ($app) {
    $app->render('admin/gear/add.twig');
})->name("admin.gear.add");

$app->post('/admin/gear/add', $admin(), function () use ($app) {
    $gear = $app->gear;
    $post = $app->request->post();

    //return var_dump($post);

    $v = $app->validation;

    $v->validate([
        "inputName" => [$post["inputName"], 'required|alnumDash'],
        "inputAmount" => [$post["inputAmount"], 'required|int'],
        "inputBrand" => [$post["inputBrand"], 'required|alnumDash'],
        "inputSerial" => [$post["inputSerial"], 'alnumDash'],
    ]);
    $app->response->headers->set('Content-Type', 'application/json');
    //echo json_encode($v);
    return var_dump($v);
    if ($v->passes()) {
        if (isset($post["inputCheckOut"])) {
            if ($post["inputCheckOut"] === "on") {
                $v->validate([
                    "inputDate" => [$post["inputDate"], 'required|date'],
                    "inputCheckOutName" => [$post["inputCheckoutName"], 'required'],
                ]);

                if ($v->errors()) {
                    echo json_encode($v-errors());
                }
                
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
            echo json_encode([
                "success" => true,
                "url" => $app->urlFor("admin.gear.add"),
            ]);
            return;
        }

        $app->render('admin/gear/add.twig', [
            "success" => true,
        ]);
        
        if ($app->request->isAjax() && isset($create)) {
            echo json_encode([
                "success" => true,
                "url" => $app->urlFor("admin.gear.add"),
            ]);
            return;
        } elseif (isset($create)) {
            $app->render('admin/gear/add.twig', [
                "success" => true,
            ]);   
        }
    }
    
    if ($app->request->isAjax()) {
        echo json_encode([
            "success" => false,
            "errors" => $v->errors(),
            "url" => $app->urlFor("admin.gear.add"),
        ]);
        return;
    }
    return var_dump($v);
    $app->render('admin/gear/add.twig', [
        "success" => false,
    ]);

})->name("admin.gear.add.post");

/*array(10) { ["inputName"]=> string(4) "Name" ["inputAmount"]=> string(1) "4" ["inputBrand"]=> string(4) "Clap" ["inputSerial"]=> string(2) "56" ["inputCheckOut"]=> string(2) "on" ["inputDate"]=> string(10) "09/08/2015" ["inputCheckOutName"]=> string(7) "Chalres" ["inputStatus"]=> string(5) "other" ["inputStatusOther"]=> string(3) "Isf" ["csrf_token"]=> string(64) "79419e1bd205dcb520d047afffd6423296eff5e3591ebf508bfe54cb3fb0d310" } */

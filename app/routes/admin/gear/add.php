<?php

$app->get('/admin/gear/add', $admin(), function () use ($app) {
    $app->render('admin/gear/add.twig');
})->name("admin.gear.add");

$app->post('/admin/gear/add', $admin(), function () use ($app) {
    $gear = $app->gear;
    $post = $app->request->post();

    return var_dump($post);



    $v = $app->validation;

    $validate = [
        "inputName" => [$post["inputName"], 'required|alnumDash'],
        "inputAmount" => [$post["inputAmount"], 'required|int'],
        "inputBrand" => [$post["inputBrand"], 'required|alnumDash'],
        "inputSerial" => [$post["inputSerial"], 'alnumDash'],
    ];

    $v->validate($validate);

    if ($v->passes()) {
        if () {

        }
    }
})->name("admin.gear.add.post");

/*array(10) { ["inputName"]=> string(4) "Name" ["inputAmount"]=> string(1) "4" ["inputBrand"]=> string(4) "Clap" ["inputSerial"]=> string(2) "56" ["inputCheckOut"]=> string(2) "on" ["inputDate"]=> string(10) "09/08/2015" ["inputCheckOutName"]=> string(7) "Chalres" ["inputStatus"]=> string(5) "other" ["inputStatusOther"]=> string(3) "Isf" ["csrf_token"]=> string(64) "79419e1bd205dcb520d047afffd6423296eff5e3591ebf508bfe54cb3fb0d310" } */

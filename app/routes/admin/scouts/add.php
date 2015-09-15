<?php

$app->get('/admin/scouts/add', $admin(), function () use ($app) {
    $badges = $app->metadata->listBadges();
    $app->render('/admin/scouts/add.twig', [
        'badges' => $badges,
    ]);
})->name('admin.scouts.add');

$app->post('/admin/scouts/add', $admin(), function () use ($app) {
    var_dump($app->request->post());
    return;
})->name('admin.scouts.add.post');

$app->get('/admin/badges/chown', $admin(), function () use ($app) {

    $array["camping"] = [
        'requirements' => [
            '1' => [
                'amount' => "Do the following:",
                [
                    'a' => "Show that you know first aid for and how to prevent injuries or illnesses that could occur while camping, including hypothermia, frostbite, heat reactions, dehydration, altitude sickness, insect stings, tick bites, snakebite, blisters, and hyperventilation.",
                ],
                'notes' => "http://get.co.ca/gist/down.git",
            ],
            '2' => [
                'amount' => "Do the following:",
                [
                    'a' => "Learn the Leave No Trace principles and the Outdoor Code and explain what they mean. Write a personal plan for implementing these principles on your next outing..",
                ],
            ],
            '3' => [
                'amount' => "Do the following:",
                [
                    'a' => 'Make a written plan for an overnight trek and show how to get to your camping spot using a topographical map and compass OR a topographical map and a GPS receiver.',
                ],
            ],
            '4' => [
                'amount' => "Do the following:",
                [
                    "a" => 'Make a duty roster showing how your patrol is organized for an actual overnight campout. List assignments for each member.',
                    'b' => "Help a Scout patrol or a Webelos Scout unit in your area prepare for an actual campout, including creating the duty roster, menu planning, equipment needs, general planning, and setting up camp."
                ],
            ],
            '5' => [
                'amount' => "Do the following:",
                'a' => ""
            ],
        ],
    ];

    /*$data = $app->metadata->create([
        'name' => 'camping1',
        "metadata" => json_encode($array),
        'type' => "badge",
    ]);*/

    //if ($data) {
        $app->response->headers->set('Content-Type', 'application/json');
        #echo "OK!";
        #echo "<br />";
        echo json_encode($array);
        #echo "<br />";
        #return var_dump($array);
    //}
});
$app->post('/admin/scouts/add/badges', $admin(), function () use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');
    echo json_encode($app->request->post());
    return;
})->name('admin.badges.add.getBadges');
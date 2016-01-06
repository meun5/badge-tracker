<?php

$app->get("/admin/export", $admin(), function () use ($app) {
    $gear = $app->gear->where("enabled", true)->get();

    $app->render("admin/gear/export.twig", [
        "gear" => $gear,
    ]);
})->name("admin.gear.export");

$app->post("/admin/export", $admin, function () use ($app) {
    $post = $app->request->post();

    $v = $app->validation;

    $validate_data = [
        "download" => [$post["download"], "required|not_null|alpha"],
        "id" => [$post["id"], "required|not_null|int"],
    ];

    if (isset($post["email"]) && $post["download"] == "email") {
        $validate_data["email"] = [$post["email"], "email|not_null|required"];
    }

    $v->validate($validate_data);

    if ($v->passes()) {
        $gear = $app->gear->where("id", $post["id"])->first();
        if ($post["download"] === "email") {
            $app->excel->sendGearReport($gear, $post["email"]);
            echo json_encode([
                "success" => true,
                "errors" => [],
                "callback" => "",
                "url" => $app->urlFor("admin.gear.export"),
            ]);
            return;
        } elseif ($post["download"] === "file") {
            $excel = $app->excel->sendGearReport($gear, false);
        }
    } else {
        echo $v->constructArray(false, $v->errors(), null, $app->urlFor("admin.gear.export"), true);
        return;
    }

    if (isset($excel)) {
        $_SESSION[$app->config->get("excel.cache_session")] = serialize($excel);
        echo json_encode([
            "success" => true,
            "errors" => [],
            "callback" => $app->urlFor("admin.gear.export.get"),
        ]);
        return;
    }

    return;
})->name("admin.gear.export.post");

$app->get("/admin/download/report", $admin(), function () use ($app) {
    $excel = unserialize($_SESSION[$app->config->get("excel.cache_session")]);
    $app->response->headers->set("Set-Cookie", "fileDownload=true; path=/");
    $app->response->headers->set("Content-Type", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    $app->response->headers->set("Content-Disposition", "attachment;filename="Report.xlsx"");
    $app->response->headers->set("Cache-Control", "max-age=0");

    $objWriter = PHPExcel_IOFactory::createWriter($excel, "Excel2007");
    $objWriter->save("php://output");

    unset($_SESSION[$app->config->get("excel.cache_session")]);
    return;
})->name("admin.gear.export.get");

<?php

namespace app\Metadata;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Metadata extends Eloquent
{
    protected $table = "metadata";

    protected $fillable = [
        "name",
        "metadata",
    ];

    protected $data = [];

    public function listBadges() {

        $data = $this->where("type", "badge")->get();

        $data = json_decode($data);

        return $data;
    }

}

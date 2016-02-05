<?php

namespace app\Tent;

class Tent extends \Illuminate\Database\Eloquent\Model
{
    protected $table = "equip";

    protected $fillable = [
        "owner",
        "condition",
        "checkedout",
    ];
}

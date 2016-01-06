<?php

namespace app\Events;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Event extends Eloquent
{
    protected $table = "events";

    protected $fillable = [
        "name",
        "desc",
        "users",
        "metadata",
    ];
}

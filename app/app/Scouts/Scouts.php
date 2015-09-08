<?php

namespace app\Scouts;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Scouts extends Eloquent
{
    protected $table = 'tr_scouts';

    protected $fillable = [
        'name',
        'active',
        'merit_badge',
        'partial_badge',
        'bsid',
        'rank',
        'metadata',
    ];

}
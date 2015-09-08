<?php

namespace app\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserPermission extends Eloquent
{
    protected $table = 'tr_permissions';

    protected $fillable = [
        'is_admin',
    ];

    public static $defaults = [
        'is_admin' => false,
    ];
}

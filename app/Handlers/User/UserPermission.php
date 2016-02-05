<?php

namespace app\User;

class UserPermission extends \Illuminate\Database\Eloquent\Model
{
    protected $table = "permissions";

    protected $fillable = [
        "is_admin",
    ];

    public static $defaults = [
        "is_admin" => false,
    ];
}

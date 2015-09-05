<?php

namespace app\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserPermission extends Eloquent
{
    protected $table = 'tr_permissions';

    protected $fillable = [
        'user_id',
        'is_admin',
    ];
}

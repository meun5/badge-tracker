<?php

namespace app\Authentication\Roles;

use app\Authentication\Filter;

class Admin extends Filter
{
    public function __construct($app)
    {
        parent::__construct($app);
    }
    
    protected function isAuthorized($user)
    {
        if (!is_null($user)) {
            return (bool) $user->hasPermission("is_admin");
        }
        return false;
    }
}

<?php

namespace app\Authentication\Roles;

use app\Authentication\Filter;

class Authenticated extends Filter
{
    protected $app;
    
    public function __construct($app)
    {
        parent::__construct($app);
        
        $this->app = $app;
    }
    
    protected function isAuthorized($user)
    {
        return ! (bool) empty($this->app->getContainer()["auth"]);
    }
}

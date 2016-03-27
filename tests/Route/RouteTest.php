<?php

namespace App\Tests\Route;

class RouteTest extends \PHPUnit_Framework_TestCase
{
    protected $app;

    protected $response;

    public function setUp()
    {
        $this->app = new \App\Tests\TestSetUp(true, true);

        $this->response = $this->app->response;
    }

    public function testRoutes()
    {
        $v = $this->app->get("/");
        //die(var_dump($v));
        $this->assertEquals(200, $v->getStatusCode());
    }
}

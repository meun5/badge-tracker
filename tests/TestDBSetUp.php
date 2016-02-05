<?php

namespace App\Tests;

use Illuminate\Database\Eloquent\Model;

class TestDBSetUp extends \PHPUnit_Extensions_Database_TestCase
{
	public function __construct()
	{
		$pdo = Model::getConnectionResolver()->connection()->getPdo();
        return $this->createDefaultDBConnection($pdo, ':memory:');
	}
}
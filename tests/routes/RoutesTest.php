<?php

use app\User\UserPermission;

class RoutesTest extends LocalWebTestCase
{

    /**
     * Calls the database and tests that it succeded.
     *
     * @return void
     */
    public function testSetup()
    {
        if ($this->setUpDatabase()) { $this->assertTrue(true); } else { $this->assertFalse(true); }
    }

    /**
     * Clean out the databases.
     *
     * @return void
     */
    protected function clearDatabase()
    {
        $this->app->user->truncate();
        $this->app->gear->truncate();
        $this->app->metadata->truncate();
        $this->app->scouts->truncate();
        UserPermission::truncate();
    }

    /**
     * Prep the databases with dummy data.
     *
     * @return void
     */
    public function setUpDatabase()
    {
        $this->clearDatabase();

        $user = $this->app->user->create([
            "username" => "johnny",
            "first_name" => "John",
            "last_name" => "Smith",
            "email" => "smith.john@jenkins.markdown.com",
            "password" => $this->app->hash->password($this->app->randomlib->generateString(256)),
            "active" => true,
        ]);

        $gear = $this->app->gear->create([
            "username" => "johnny",
            "first_name" => "John",
            "last_name" => "Smith",
            "email" => "smith.john@jenkins.markdown.com",
            "password" => $this->app->hash->password($this->app->randomlib->generateString(256)),
            "active" => true,
        ]);

        if (!is_null($user) && !is_null($gear)) {echo  "Database Setup Complete."; return true;} else {echo "Database Setup Failed."; return false;}
    }
}

/* End of file RoutesTest.php */

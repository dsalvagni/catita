<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TestCase extends Laravel\Lumen\Testing\TestCase
{

    use DatabaseTransactions;

    private $user;
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    protected function createUser() {
        if(!$this->user)
            $this->user = App\User::find(rand(1,2));
    }


    protected function getUser() {
        return $this->user;
    }

}

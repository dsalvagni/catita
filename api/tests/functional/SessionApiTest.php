<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class SessionApiTest extends TestCase
{

    protected $login = ['email'=>'danielsalvagni@gmail.com','password'=>'123secret'];

    public function test_create()
    {
        $this->json('POST', '/v1/session',$this->login)
            ->seeJson([
                'name' => 'Daniel Salvagni'
            ]);
    }

    public function test_delete()
    {
        $this->actingAs($this->getUser())->json('DELETE', '/v1/session/')
            ->assertResponseStatus(204);
    }
}


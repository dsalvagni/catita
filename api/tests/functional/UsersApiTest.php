<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UsersApiTest extends TestCase
{


    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create()
    {
        $this->json('POST', '/v1/register', [
            'name' => 'Daniel Salvagni',
            'email' => 'danielsalvagni2@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ])
            ->seeJson([
                'name' => 'Daniel Salvagni',
                'email' => 'danielsalvagni2@gmail.com'
            ]);
    }

    public function test_update()
    {
        $this->actingAs($this->getUser())->json('PUT', '/v1/me', ['name' => 'João da Silva'])
            ->seeJson([
                'name' => 'João da Silva',
            ]);
    }

    public function test_delete()
    {
        $this->actingAs($this->getUser())->json('DELETE', '/v1/me')
            ->assertResponseStatus(204);
    }
}


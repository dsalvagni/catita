<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TagApiTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');
        $this->createUser();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $this->actingAs($this->getUser())->json('POST', '/v1/tags',['description'=>'Tag criado pelo teste.'])
            ->seeJson([
                'description' => 'Tag criado pelo teste.'
            ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAll()
    {
        $this->actingAs($this->getUser())->json('GET', '/v1/tags')
            ->seeJson([
                'user_id' => $this->getUser()->id,
            ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdate()
    {
        $model = $this->getUser()->tags()->first();
        $this->actingAs($this->getUser())->json('PUT', '/v1/tags/'.$model->id,['description'=>'Atualizado pelo teste.'])
            ->seeJson([
                'description' => 'Atualizado pelo teste.',
            ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDelete()
    {
        $model = $this->getUser()->tags()->first();
        $this->actingAs($this->getUser())->json('DELETE', '/v1/tags/'.$model->id)
            ->assertResponseStatus(204);
    }
}


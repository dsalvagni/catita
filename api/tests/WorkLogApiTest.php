<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class WorkLogApiTest extends TestCase
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
        $this->actingAs($this->getUser())->json('POST', '/v1/worklogs',['description'=>'Criado pelo teste.'])
            ->seeJson([
                'description' => 'Criado pelo teste.'
            ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAll()
    {
        $this->actingAs($this->getUser())->json('GET', '/v1/worklogs')
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
        $model = $this->getUser()->workLogs()->first();
        $this->actingAs($this->getUser())->json('PUT', '/v1/worklogs/'.$model->id,['description'=>'Atualizado pelo teste.'])
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
        $model = $this->getUser()->workLogs()->first();
        $this->actingAs($this->getUser())->json('DELETE', '/v1/worklogs/'.$model->id)
            ->assertResponseStatus(204);
    }
}


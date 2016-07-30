<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class WorkLogApiTest extends TestCase
{

    public function test_create()
    {
        $this->actingAs($this->getUser())->json('POST', '/v1/worklogs',['description'=>'Criado pelo teste.'])
            ->seeJson([
                'description' => 'Criado pelo teste.'
            ]);
    }

    public function test_get_all()
    {
        $this->actingAs($this->getUser())->json('GET', '/v1/worklogs')
            ->seeJson([
                'user_id' => $this->getUser()->id,
            ]);
    }


    public function test_update()
    {
        $model = $this->getUser()->workLogs()->first();
        $this->actingAs($this->getUser())->json('PUT', '/v1/worklogs/'.$model->id,['description'=>'Atualizado pelo teste.'])
            ->seeJson([
                'description' => 'Atualizado pelo teste.',
            ]);
    }


    public function test_delete()
    {
        $model = $this->getUser()->workLogs()->first();
        $this->actingAs($this->getUser())->json('DELETE', '/v1/worklogs/'.$model->id)
            ->assertResponseStatus(204);
    }
}


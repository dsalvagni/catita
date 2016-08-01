<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class SessionApiTest extends TestCase
{

    protected $data = ['email'=>'danielsalvagni@gmail.com'];

    public function test_create()
    {
        $this->json('POST', '/v1/password/request',$this->data)
            ->assertResponseStatus(201);
    }

    public function test_create_token_didnt_expired()
    {
        $User = App\Models\User::find($data);
        $User->update(['reset_token'=>123,'updated_at'=>(new \DateTime())->format('Y-m-d H:i:s')]);
        $this->json('POST', '/v1/password/request',$this->data)
            ->assertResponseStatus(409);
    }

    public function test_create_token_bad_request()
    {
        
        $this->json('POST', '/v1/password/request',['email'=>'emaildonotexist@neitherdomain.com'])
            ->assertResponseStatus(400);
    }

    public function test_update()
    {
        $User = App\Models\User::find($data);
        $User->update(['reset_token'=>123]);
        $this->json('UPDATE', '/v1/password/reset',['token'=>123,'password'=>'123secret2','password_confirmation'=>'123secret2'])
            ->assertResponseStatus(204);
    }

    public function test_update_token_expired()
    {
        $User = App\Models\User::find($data);
        $User->update(['reset_token'=>123,'updated_at'=>(new \DateTime())->sub('2 days')->format('Y-m-d H:i:s')]);
        $this->json('UPDATE', '/v1/password/reset',['token'=>123,'password'=>'123secret2','password_confirmation'=>'123secret2'])
            ->assertResponseStatus(410);
    }

    public function test_update_token_didnt_exists()
    {
        $this->json('UPDATE', '/v1/password/reset',['token'=>123456,'password'=>'123secret2','password_confirmation'=>'123secret2'])
            ->assertResponseStatus(410);
    }

    public function test_update_missing_password_field()
    {
        $this->json('UPDATE', '/v1/password/reset',['token'=>123456])
            ->assertResponseStatus(401);
    }

    public function test_update_missing_password_confirmation_field()
    {
        $this->json('UPDATE', '/v1/password/reset',['token'=>123456,'password'=>'123secret2'])
            ->assertResponseStatus(401);
    }

    public function test_update_missing_password_and_password_confirmation_dont_match()
    {
        $this->json('UPDATE', '/v1/password/reset',['token'=>123456,'password'=>'123secret2','password_confirmation'=>'123secret3'])
            ->assertResponseStatus(401);
    }
}


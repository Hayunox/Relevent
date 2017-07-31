<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserConnectionControllerTest extends TestCase
{
    public function testUserLoginWithoutCredentials()
    {
        $response = $this->json('POST', '/api/user/login', []);
        $response
            ->assertStatus(400)
            ->assertJson(['USER_LOGIN_FAILED']);
    }

    public function testUserLoginWithInvalidCredentials()
    {
        $response = $this->json('POST', '/api/user/login', ['nickname' => 'zzzzzzzz', 'password' => 'zzzzzzzz']);
        $response
            ->assertStatus(400)
            ->assertJson(['USER_LOGIN_FAILED']);
    }

    public function testUserLoginWithValidCredentials()
    {
        $response = $this->json('POST', '/api/user/login', ['nickname' => 'test', 'password' => 'testPwd']);
        $response
            ->assertStatus(200)
            ->assertJson([
                'nickname'=> 'test',
                'name'    => '',
                'surname' => '',
                'mail'    => 'test', ]);
    }
}

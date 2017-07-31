<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserConnectionController extends TestCase
{
    /**
     *
     */
    public function testUserLoginWithoutCredentials()
    {
        $response = $this->json('POST', '/user/login', []);
        $response
            ->assertStatus(400)
            ->assertJson([]);
    }

    /**
     *
     */
    public function testUserLoginWithInvalidCredentials()
    {
        $response = $this->json('POST', '/user/login', ['nickname' => 'zzzzzzzz', 'password' => 'zzzzzzzz']);
        $response
            ->assertStatus(400)
            ->assertJson(['USER_LOGIN_FAILED']);
    }

    /**
     *
     */
    public function testUserLoginWithValidCredentials()
    {
        $response = $this->json('POST', '/user/login', ['nickname' => 'test', 'password' => 'test']);
        $response
            ->assertStatus(200)
            ->assertJson([]);
    }
}

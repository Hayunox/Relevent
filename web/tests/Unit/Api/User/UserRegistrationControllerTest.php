<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRegistrationControllerTest extends TestCase
{
    /**
     *
     */
    public function testUserRegisterWithoutCredentials()
    {
        $response = $this->json('POST', '/api/user/register', []);
        $response
            ->assertStatus(400)
            ->assertJson(['USER_REGISTRATION_FAILED']);
    }

    /**
     *
     */
    public function testUserRegisterWithValidCredentials()
    {
        $response = $this->json('POST', '/api/user/register', ['nickname' => 'test', 'mail' => 'test@mail.fr', 'password' => 'testPwd']);
        $response
            ->assertStatus(200)
            ->assertJson(['USER_CREATED_SUCCESSFULLY']);
    }

    /**
     *
     */
    public function testUserRegisterWithInvalidMail()
    {
        $response = $this->json('POST', '/api/user/register', ['nickname' => 'zzzzzz', 'mail' => 'test@mail.fr', 'password' => 'zzzzzzzz']);
        $response
            ->assertStatus(400)
            ->assertJson(['USER_MAIL_EXISTS']);
    }

    /**
     *
     */
    public function testUserRegisterWithInvalidNickname()
    {
        $response = $this->json('POST', '/api/user/register', ['nickname' => 'test', 'mail' => 'zzzzzzz', 'password' => 'zzzzzzzz']);
        $response
            ->assertStatus(400)
            ->assertJson(['USER_NICKNAME_EXISTS']);
    }
}

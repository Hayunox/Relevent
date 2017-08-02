<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserContactDataControllerTest extends TestCase
{
    public function testUserContactByIdValidParams()
    {
        $response = $this->json('GET', '/api/user/contact/getContact', ['id' => 1], ['HTTP_Authorization' => 1]);
        $response
            ->assertStatus(200)
            ->assertJson(['description']);
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserContactDataControllerTest extends TestCase
{
    public function testUserContactByIdValidParams()
    {
        $this->transformHeadersToServerVars(['Authorization' => 1]);
        $response = $this->json('GET', '/api/user/contact/getContact', ['id' => 1]);
        $response
            ->assertStatus(200)
            ->assertJson(['description']);
    }
}

<?php

namespace Tests\Unit;

use App\Database\UserContactAcceptation;
use Tests\TestCase;

class UserContactUpdateControllerTest extends TestCase
{
    public function testUserContactUpdateAcceptWithValidParams()
    {
        $response = $this->json('POST', '/api/user/contact/update', ['contact_id' => 1, 'status' => UserContactAcceptation::Accepted]);
        $response
            ->assertStatus(200)
            ->assertJson(['USER_CONTACT_CHANGED_SUCCESSFULLY']);
    }

    public function testUserContactUpdateRefuseWithValidParams()
    {
        $response = $this->json('POST', '/api/user/contact/update', ['contact_id' => 1, 'status' => UserContactAcceptation::Refused]);
        $response
            ->assertStatus(200)
            ->assertJson(['USER_CONTACT_CHANGED_SUCCESSFULLY']);
    }
}

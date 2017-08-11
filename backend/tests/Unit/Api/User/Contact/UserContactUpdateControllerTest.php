<?php

namespace Tests\Unit;

use App\Database\UserContactAcceptation;
use Tests\TestCase;

class UserContactUpdateControllerTest extends TestCase
{
    public function testUserContactUpdateAcceptWithValidParams()
    {
        $this->transformHeadersToServerVars([ 'Authorization' => 1]);
        $response = $this->json('POST', '/api/user/contact/update', ['contact_id' => 1, 'status' => UserContactAcceptation::ACCEPTED]);
        $response
            ->assertStatus(200)
            ->assertJson(['USER_CONTACT_CHANGED_SUCCESSFULLY']);
    }

    public function testUserContactUpdateRefuseWithValidParams()
    {
        $this->transformHeadersToServerVars([ 'Authorization' => 1]);
        $response = $this->json('POST', '/api/user/contact/update', ['contact_id' => 1, 'status' => UserContactAcceptation::REFUSED]);
        $response
            ->assertStatus(200)
            ->assertJson(['USER_CONTACT_CHANGED_SUCCESSFULLY']);
    }
}

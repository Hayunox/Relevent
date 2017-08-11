<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserContactCreationControllerTest extends TestCase
{
    public function testUserContactCreationWithoutParams()
    {
        $this->transformHeadersToServerVars([ 'Authorization' => 1]);
        $response = $this->json('POST', '/api/user/contact/create', []);
        $response
            ->assertStatus(400)
            ->assertJson(['']);
    }

    public function testUserContactCreationWithValidParams()
    {
        $this->transformHeadersToServerVars([ 'Authorization' => 1]);
        $response = $this->json('POST', '/api/user/contact/create', ['new_contact_user_id' => 10]);
        $response
            ->assertStatus(200)
            ->assertJson(['USER_CONTACT_CREATED_SUCCESSFULLY']);
    }

    public function testUserContactCreationWithInvalidNewContactId()
    {
        $this->transformHeadersToServerVars([ 'Authorization' => 1]);
        $response = $this->json('POST', '/api/user/contact/create', ['new_contact_user_id' => 10]);
        $response
            ->assertStatus(400)
            ->assertJson(['USER_CONTACT_EXISTS']);
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserContactCreationControllerTest extends TestCase
{
    public function testUserContactCreationWithoutParams()
    {
        $response = $this->json('POST', '/api/user/contact/create', []);
        $response
            ->assertStatus(400)
            ->assertJson(['']);
    }

    public function testUserContactCreationWithValidParams()
    {
        $response = $this->json('POST', '/api/user/contact/create', ['new_contact_user_id' => 10]);
        $response
            ->assertStatus(200)
            ->assertJson(['USER_CONTACT_CREATED_SUCCESSFULLY']);
    }

    public function testUserContactCreationWithInvalidNewContactId()
    {
        $response = $this->json('POST', '/api/user/contact/create', ['new_contact_user_id' => 10]);
        $response
            ->assertStatus(400)
            ->assertJson(['USER_CONTACT_EXISTS']);
    }
}

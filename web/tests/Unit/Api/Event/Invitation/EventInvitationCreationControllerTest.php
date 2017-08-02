<?php

namespace Tests\Unit;

use Tests\TestCase;

class EventInvitationCreationControllerTest extends TestCase
{
    public function testEventInvitationCreationWithoutParams()
    {
        $response = $this->json('POST', '/api/event/invit/create', [], ['HTTP_Authorization' => 1]);
        $response
            ->assertStatus(400)
            ->assertJson(['']);
    }

    public function testEventInvitationCreationWithValidParams()
    {
        $response = $this->json('POST', '/api/event/invit/create', ['new_guest_user_id' => 2, 'event_id' => 1], ['HTTP_Authorization' => 1]);
        $response
            ->assertStatus(200)
            ->assertJson(['EVENT_INVIT_USER_CREATED_SUCCESSFULLY']);
    }

    public function testEventInvitationCreationWithInvalidNewGuestId()
    {
        $response = $this->json('POST', '/api/event/invit/create', ['new_guest_user_id' => 2, 'event_id' => 1], ['HTTP_Authorization' => 1]);
        $response
            ->assertStatus(400)
            ->assertJson(['EVENT_INVIT_USER_EXISTS']);
    }
}

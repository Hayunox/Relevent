<?php

namespace Tests\Unit;

use App\Database\EventInvitationAcceptation;
use Tests\TestCase;

class EventInvitationUpdateControllerTest extends TestCase
{
    public function testUserContactUpdateAcceptWithValidParams()
    {
        $response = $this->json('POST', '/api/event/invit/update', ['event_id' => 1, 'status' => EventInvitationAcceptation::Accepted], ['HTTP_Authorization' => 1]);
        $response
            ->assertStatus(200)
            ->assertJson(['EVENT_INVIT_USER_CHANGED_SUCCESSFULLY']);
    }

    public function testUserContactUpdateRefuseWithValidParams()
    {
        $response = $this->json('POST', '/api/event/invit/update', ['event_id' => 1, 'status' => EventInvitationAcceptation::Refused], ['HTTP_Authorization' => 1]);
        $response
            ->assertStatus(200)
            ->assertJson(['EVENT_INVIT_USER_CHANGED_SUCCESSFULLY']);
    }
}

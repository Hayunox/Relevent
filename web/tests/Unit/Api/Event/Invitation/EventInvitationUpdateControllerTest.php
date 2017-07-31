<?php

namespace Tests\Unit;

use App\Database\EventInvitationAcceptation;
use Tests\TestCase;

class EventInvitationUpdateControllerTest extends TestCase
{
    /**
     *
     */
    public function testUserContactUpdateAcceptWithValidParams()
    {
        $response = $this->json('POST', '/api/event/invit/update', ['event_id' => 1, 'status' => EventInvitationAcceptation::Accepted]);
        $response
            ->assertStatus(200)
            ->assertJson(['EVENT_INVIT_USER_CHANGED_SUCCESSFULLY']);
    }

    /**
     *
     */
    public function testUserContactUpdateRefuseWithValidParams()
    {
        $response = $this->json('POST', '/api/event/invit/update', ['event_id' => 1, 'status' => EventInvitationAcceptation::Refused]);
        $response
            ->assertStatus(200)
            ->assertJson(['EVENT_INVIT_USER_CHANGED_SUCCESSFULLY']);
    }
}

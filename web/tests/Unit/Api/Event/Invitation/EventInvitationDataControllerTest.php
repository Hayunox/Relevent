<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventInvitationDataControllerTest extends TestCase
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
            ->assertStatus(400)
            ->assertJson(['EVENT_INVIT_USER_CHANGED_SUCCESSFULLY']);
    }
}

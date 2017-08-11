<?php

namespace Tests\Unit;

use Tests\TestCase;

class EventInvitationDataControllerTest extends TestCase
{
    public function testEventInvitationByIdValidParams()
    {
        $response = $this->json('GET', '/api/event/getInvit', ['id' => 1], ['HTTP_Authorization' => 1]);
        $response
            ->assertStatus(200)
            ->assertJson(['description']);
    }
}

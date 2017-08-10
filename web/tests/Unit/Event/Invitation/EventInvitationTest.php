<?php

namespace Tests\Unit;

use App\Database\EventInvitation;
use App\Database\EventInvitationAcceptation;
use Tests\TestCase;

class EventInvitationTest extends TestCase
{
    private $test_sender_user_id;
    private $test_guest_user_id;
    private $test_invit_id;
    private $test_invit_result;
    private $invit_id;
    private $eventInvitation;

    public function testEventInvitation()
    {
        $this->test_guest_user_id = 1;
        $this->test_sender_user_id = 2;
        $this->test_invit_id = 1;

        $this->eventInvitation = new EventInvitation($this->test_sender_user_id, $this->test_invit_id);


        // test invited not exists
        $this->test_invit_result = $this->eventInvitation->isInvited($this->test_guest_user_id);
        $this->assertInternalType("bool", $this->test_invit_result);
        $this->assertEquals(false, $this->test_invit_result);

        // contact creation
        $this->invit_id = $this->eventInvitation->createInvitation($this->test_guest_user_id);
        $this->assertInternalType("boolean", $this->invit_id);
        $this->assertEquals(true, $this->invit_id);

        // test invited exists
        $this->test_invit_result = $this->eventInvitation->isInvited($this->test_guest_user_id);
        $this->assertInternalType("int", $this->test_invit_result);
        $this->assertEquals(EventInvitationAcceptation::Pending, $this->test_invit_result);

        // set invitation accepted
        $this->eventInvitation->setInvitationAcceptation(EventInvitationAcceptation::Accepted);

        // test contact status
        $this->test_invit_result = $this->eventInvitation->isInvited($this->test_guest_user_id);
        $this->assertInternalType("int", $this->test_invit_result);
        $this->assertEquals(EventInvitationAcceptation::Accepted, $this->test_invit_result);

        // get user invitations
        $this->test_invit_result = $this->eventInvitation->getUserInvited();
        $this->assertInternalType("array", $this->test_invit_result);

        // set invitation refused
        $this->eventInvitation->setInvitationAcceptation(EventInvitationAcceptation::Refused);

        // test invited status
        $this->test_invit_result = $this->eventInvitation->isInvited($this->test_guest_user_id);
        $this->assertInternalType("int", $this->test_invit_result);
        $this->assertEquals(EventInvitationAcceptation::Refused, $this->test_invit_result);
    }
}

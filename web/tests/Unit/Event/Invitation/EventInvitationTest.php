<?php

namespace Tests\Unit;

use App\Database\EventInvitationAcceptation;
use Tests\TestCase;

class EventInvitationTest extends TestCase
{
    private $test_sender_user_id;
    private $test_guest_user_id;
    private $test_invit_id;
    private $test_invit_result;
    private $invit_id;

    public function testEventInvitation()
    {
        $this->test_guest_user_id = 1;
        $this->test_sender_user_id = 2;
        $this->test_invit_id = 1;

        // creation of a new instance of the tested class
        $this
            ->given($this->newTestedInstance($this->test_sender_user_id, $this->test_invit_id))

            // test invited not exists
            ->given($this->test_invit_result = $this->testedInstance->isInvited($this->test_guest_user_id))
            ->boolean((bool) $this->test_invit_result)
            ->isFalse()

            // contact creation
            ->given($this->invit_id = $this->testedInstance->createInvitation($this->test_guest_user_id))
            ->integer((int) $this->invit_id)
            ->isGreaterThan(-1)

            // test invited exists
            ->given($this->test_invit_result = $this->testedInstance->isInvited($this->test_guest_user_id))
            ->integer((int) $this->test_invit_result)
            ->isEqualTo(EventInvitationAcceptation::Pending)

            // set invitation accepted
            ->given($this->testedInstance->setInvitationAcceptation(EventInvitationAcceptation::Accepted))

            // test contact status
            ->given($this->test_invit_result = $this->testedInstance->isInvited($this->test_guest_user_id))
            ->integer((int) $this->test_invit_result)
            ->isEqualTo(EventInvitationAcceptation::Accepted)

            // get user invitations
            ->array($this->testedInstance->getUserInvited($this->test_connection))
            ->hasSize(0)

            // set invitation refused
            ->given($this->testedInstance->setInvitationAcceptation(EventInvitationAcceptation::Refused))

            // test invited status
            ->given($this->test_invit_result = $this->testedInstance->isInvited($this->test_guest_user_id))
            ->integer((int) $this->test_invit_result)
            ->isEqualTo(EventInvitationAcceptation::Refused);
    }
}

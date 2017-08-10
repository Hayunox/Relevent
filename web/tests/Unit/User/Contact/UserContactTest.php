<?php

namespace Tests\Unit;

use App\Database\UserContact;
use App\Database\UserContactAcceptation;
use Tests\TestCase;

class UserContactTest extends TestCase
{
    private $test_contact_user_id;
    private $test_new_contact_user_id;
    private $test_contact_id;
    private $test_contact_result;
    private $contact;

    public function testContactCreation()
    {
        $this->test_contact_user_id = 1;
        $this->test_new_contact_user_id = 2;

        // creation of a new instance of the tested class
        $this->contact = new UserContact($this->test_contact_user_id);

        // test contact not exists
        $this->test_contact_result = $this->contact->isContact($this->test_new_contact_user_id);
        $this->assertInternalType("bool", $this->test_contact_result);
        $this->assertEquals(false, $this->test_contact_result);

        // contact creation
        $this->test_contact_id = $this->contact->createContact($this->test_new_contact_user_id);
        $this->assertInternalType("int", $this->test_contact_id);
        $this->assertGreaterThan(-1, $this->test_contact_id);

        // test contact exists
        $this->test_contact_result = $this->contact->isContact($this->test_new_contact_user_id);
        $this->assertInternalType("int", $this->test_contact_result);
        $this->assertEquals(UserContactAcceptation::Pending, $this->test_contact_result);

        // set invitation accepted
        $this->contact->setContactAcceptation($this->test_new_contact_user_id, UserContactAcceptation::Accepted);

        // test contact status
        $this->test_contact_result = $this->contact->isContact($this->test_new_contact_user_id);
        $this->assertInternalType("int", $this->test_contact_result);
        $this->assertEquals(UserContactAcceptation::Accepted, $this->test_contact_result);

        // get user contacts
        $this->test_contact_result = $this->contact->getUserContacts();
        $this->assertInternalType("array", $this->test_contact_result);
        $this->assertArrayHasKey("0", $this->test_contact_result);

        // set invitation refused
        $this->test_new_contact_user_id =  $this->contact->setContactAcceptation($this->test_new_contact_user_id, UserContactAcceptation::Refused);

        // test contact status
        $this->test_contact_result = $this->contact->isContact($this->test_new_contact_user_id);
        $this->assertInternalType("int", $this->test_contact_result);
        $this->assertEquals(UserContactAcceptation::Refused, $this->test_contact_result);
    }
}

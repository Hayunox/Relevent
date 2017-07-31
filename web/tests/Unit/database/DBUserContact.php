<?php

namespace web\tests\Unit\Database;

require_once __DIR__.'/../UnitTestRestServerUtil.php';
require_once __DIR__.'/../../../database/DBConnection.php';
require_once __DIR__.'/../../../database/UserContact.php';

use server\database\DBConnection as ConnectionToDatabase;
use server\database\UserContactAcceptation;
use server\tests\units\UnitTestRestServerSlimTest;

class DBUserContact extends UnitTestRestServerSlimTest
{
    private $test_contact_user_id;
    private $test_new_contact_user_id;
    private $test_contact_id;
    private $test_contact_result;

    private $test_connection;

    public function testContactCreation()
    {
        $this->test_contact_user_id = 1;
        $this->test_new_contact_user_id = 2;

        $this->test_connection = new ConnectionToDatabase();

        // creation of a new instance of the tested class
        $this
            ->given($this->newTestedInstance($this->test_contact_user_id))

            // test contact not exists
            ->given($this->test_contact_result = $this->testedInstance->isContact($this->test_connection, $this->test_new_contact_user_id))
                ->boolean((bool) $this->test_contact_result)
                ->isFalse()

            // contact creation
            ->given($this->test_contact_id = $this->testedInstance->createContact($this->test_connection, $this->test_new_contact_user_id))
            ->integer((int) $this->test_contact_id)
            ->isGreaterThan(-1)

            // test contact exists
            ->given($this->test_contact_result = $this->testedInstance->isContact($this->test_connection, $this->test_new_contact_user_id))
                ->integer((int) $this->test_contact_result)
                ->isEqualTo(UserContactAcceptation::Pending)

            // set invitation accepted
            ->given($this->testedInstance->setContactAcceptation($this->test_connection, $this->test_new_contact_user_id, UserContactAcceptation::Accepted))

            // test contact status
            ->given($this->test_contact_result = $this->testedInstance->isContact($this->test_connection, $this->test_new_contact_user_id))
                ->integer((int) $this->test_contact_result)
                ->isEqualTo(UserContactAcceptation::Accepted)

            // get user contacts
            ->array($this->testedInstance->getUserContacts($this->test_connection))
                ->hasSize(1)
                ->hasKey(0)

            // set invitation refused
            ->given($this->testedInstance->setContactAcceptation($this->test_connection, $this->test_new_contact_user_id, UserContactAcceptation::Refused))

            // test contact status
            ->given($this->test_contact_result = $this->testedInstance->isContact($this->test_connection, $this->test_new_contact_user_id))
                ->integer((int) $this->test_contact_result)
                ->isEqualTo(UserContactAcceptation::Refused);
    }
}

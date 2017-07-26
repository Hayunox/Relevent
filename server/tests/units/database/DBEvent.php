<?php
/*
 * Created by PhpStorm.
 * event: Paul
 * Date: 14/07/2017
 * Time: 16:51
 */

namespace server\tests\units\database;

require_once __DIR__.'/../../../database/DBConnection.php';
require_once __DIR__.'/../../../database/DBEvent.php';

use mageekguy\atoum\test;
use server\database\DBConnection as ConnectionToDatabase;

/*
 * Test class for DBEvent
 */

class DBEvent extends test
{
    private $test_event_name = 'test event';
    private $test_event_date = 1457896211;
    private $test_event_description = 'description test';
    private $test_event_address = '3 trybol';

    private $test_event_id;
    private $test_event_data;
    private $test_connection;

    public function testEventCreation()
    {
        $this->test_connection = new ConnectionToDatabase();

        // creation of a new instance of the tested class
        $this
            ->given($this->newTestedInstance(null))

            // event creation
            ->given($test_event_id = $this->testedInstance->eventCreate($this->test_connection, [
                'event_user_id'         => 0,
                'event_name'            => $this->test_event_name,
                'event_address'         => $this->test_event_address,
                'event_description'     => $this->test_event_description,
                'event_date'            => $this->test_event_date,
                'event_theme'           => '',
                'event_secret'          => 0,
            ]))
            ->integer((int) $test_event_id)
                ->isGreaterThan(-1)

            // event data
            ->integer((int) $this->testedInstance->getEventData($this->test_connection))
            ->isZero()
            ->given($this->testedInstance->event_id = $test_event_id)
            ->given($this->test_event_data = $this->testedInstance->getEventData($this->test_connection))
            ->array($this->test_event_data)
                ->hasKey('address')
                ->hasKey('name')
                ->hasKey('user_id')
                ->contains($this->test_event_date)
                ->contains($this->test_event_description)
            ->array($this->testedInstance->getEventData($this->test_connection))
                ->hasKey('address')
                ->hasKey('name')
                ->hasKey('user_id')
                ->hasSize(1)
                ->contains($this->test_event_date)
                ->contains($this->test_event_description);
    }

    public function getAutoloaderFile()
    {
    }
}

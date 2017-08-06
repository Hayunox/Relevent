<?php

namespace Tests\Unit;

use Tests\TestCase;

class EventTest extends TestCase
{
    private $test_event_name = 'test event';
    private $test_event_date = 1457896211;
    private $test_event_description = 'description test';
    private $test_event_address = '3 trybol';

    private $test_event_id;
    private $test_event_data;

    public function testEventCreation()
    {
        // creation of a new instance of the tested class
        $this
            ->given($this->newTestedInstance(null))

            // event creation
            ->given($test_event_id = $this->testedInstance->eventCreate([
                'event_user_id'         => 1,
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
            ->integer((int) $this->testedInstance->getEventData())
            ->isZero()
            ->given($this->testedInstance->event_id = $test_event_id)
            ->given($this->test_event_data = $this->testedInstance->getEventData())
            ->array($this->test_event_data)
            ->hasKey('address')
            ->hasKey('name')
            ->hasKey('user_id')
            ->contains($this->test_event_date)
            ->contains($this->test_event_description)
            ->array($this->testedInstance->eventUserList(1))
            ->hasSize(1)
            ->hasKey(0);
    }
}

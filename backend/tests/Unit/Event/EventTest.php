<?php

namespace Tests\Unit;

use App\Database\Event;
use Tests\TestCase;

class EventTest extends TestCase
{
    private $test_event_name = 'test event';
    private $test_event_date = 1457896211;
    private $test_event_description = 'description test';
    private $test_event_address = '3 trybol';
    private $test_event_result;
    private $test_event_id;
    private $test_event_data;
    private $event;

    public function testEventCreation()
    {
        $this->event = new Event(null);

        // event creation
        $this->event->event_id = 1;
        $this->event->eventCreate([
            'event_user_id'         => 1,
            'event_name'            => $this->test_event_name,
            'event_address'         => $this->test_event_address,
            'event_description'     => $this->test_event_description,
            'event_date'            => $this->test_event_date,
            'event_theme'           => '',
            'event_secret'          => 0,
        ]);

        // event data
        $this->test_event_data = $this->event->getEventData();
        $this->assertInternalType('array', $this->test_event_data);
        $this->assertArrayHasKey('address', $this->test_event_data);
        $this->assertArrayHasKey('name', $this->test_event_data);
        $this->assertArrayHasKey('user_id', $this->test_event_data);
        $this->assertContains($this->test_event_date, $this->test_event_data);
        $this->assertContains($this->test_event_description, $this->test_event_data);

        $this->test_event_result = $this->event->eventUserList(1);
        $this->assertInternalType('array', $this->test_event_data);
    }
}

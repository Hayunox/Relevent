<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventListControllerTest extends TestCase
{
    /**
     *
     */
    public function testEventListOwnValidParams()
    {
        $response = $this->json('GET', '/api/event/listOwn', ['id' => 1]);
        $response
            ->assertStatus(200)
            ->assertJson(['description']);
    }
}

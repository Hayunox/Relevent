<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventCreationControllerTest extends TestCase
{
    /**
     *
     */
    public function testEventCreationWithoutParams()
    {
        $response = $this->json('POST', '/api/event/create', []);
        $response
            ->assertStatus(400)
            ->assertJson(['USER_CREATION_FAILED']);
    }

    /**
     *
     */
    public function testEventCreationWithValidParams()
    {
        $response = $this->json('POST', '/api/event/create', [
            'name' => 'event test name',
            'date' => 1555555,
            'description' => 'test description',
            'address' => 'test address',
            'theme' => 'test theme']);
        $response
            ->assertStatus(200)
            ->assertJson(['EVENT_CREATED_SUCCESSFULLY']);
    }
}

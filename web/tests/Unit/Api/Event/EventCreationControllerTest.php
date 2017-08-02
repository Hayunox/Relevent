<?php

namespace Tests\Unit;

use Tests\TestCase;

class EventCreationControllerTest extends TestCase
{
    public function testEventCreationWithoutParams()
    {
        $response = $this->json('POST', '/api/event/create', [], ['HTTP_Authorization' => '$2y$10$sgUKGd6c/U8FKrYXI4sNDukK71ChZYDHi0Y.tAJLSi/9u2lYjY2ya']);
        $response
            ->assertStatus(400)
            ->assertJson(['USER_CREATION_FAILED']);
    }

    public function testEventCreationWithValidParams()
    {
        $response = $this->json('POST', '/api/event/create', [
            'name'        => 'event test name',
            'date'        => 1555555,
            'description' => 'test description',
            'address'     => 'test address',
            'theme'       => 'test theme', ], ['HTTP_Authorization' => '$2y$10$sgUKGd6c/U8FKrYXI4sNDukK71ChZYDHi0Y.tAJLSi/9u2lYjY2ya']);
        $response
            ->assertStatus(200)
            ->assertJson(['EVENT_CREATED_SUCCESSFULLY']);
    }
}

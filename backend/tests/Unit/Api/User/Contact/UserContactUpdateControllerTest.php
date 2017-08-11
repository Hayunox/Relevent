<?php

namespace Tests\Unit;

use App\Database\UserContactAcceptation;
use Tests\TestCase;

class UserContactUpdateControllerTest extends TestCase
{
    public function testUserContactUpdateAcceptWithValidParams()
    {
<<<<<<< HEAD
        $this->transformHeadersToServerVars([ 'Authorization' => 1]);
        $response = $this->json('POST', '/api/user/contact/update', ['contact_id' => 1, 'status' => UserContactAcceptation::ACCEPTED]);
=======
        $this->transformHeadersToServerVars(['Authorization' => 1]);
        $response = $this->json('POST', '/api/user/contact/update', ['contact_id' => 1, 'status' => UserContactAcceptation::Accepted]);
>>>>>>> 0c269d8efe387ad7f884cc24d2edd36440158610
        $response
            ->assertStatus(200)
            ->assertJson(['USER_CONTACT_CHANGED_SUCCESSFULLY']);
    }

    public function testUserContactUpdateRefuseWithValidParams()
    {
<<<<<<< HEAD
        $this->transformHeadersToServerVars([ 'Authorization' => 1]);
        $response = $this->json('POST', '/api/user/contact/update', ['contact_id' => 1, 'status' => UserContactAcceptation::REFUSED]);
=======
        $this->transformHeadersToServerVars(['Authorization' => 1]);
        $response = $this->json('POST', '/api/user/contact/update', ['contact_id' => 1, 'status' => UserContactAcceptation::Refused]);
>>>>>>> 0c269d8efe387ad7f884cc24d2edd36440158610
        $response
            ->assertStatus(200)
            ->assertJson(['USER_CONTACT_CHANGED_SUCCESSFULLY']);
    }
}

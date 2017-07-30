<?php

namespace server\tests\units\rest;

require_once __DIR__.'/../UnitTestRestServerUtil.php';
require_once __DIR__.'/../../../rest/EventInvitationController.php';

use server\database\EventInvitationAcceptation;
use server\database\UserContactAcceptation;
use server\tests\units\UnitTestRestServerSlimTest;
use server\tests\units\UnitTestRestServerUtil;
use Slim\Http\Environment;
use Slim\Http\Response;

class RestEventInvitationCreation extends UnitTestRestServerSlimTest
{
    public function testEventInvitationCreationWithoutParams()
    {
        UnitTestRestServerUtil::basicPostTestWithoutParams($this->newTestedInstance(), '/projetX/index.php/event/invit/create', $this);
    }

    public function testEventInvitationCreationWithValidParams()
    {
        $app = $this->newTestedInstance();

        // valid params
        $_REQUEST['new_guest_user_id'] = json_encode(2);
        $_REQUEST['event_id'] = json_encode(1);

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/event/invit/create',
            'REQUEST_METHOD' => 'POST',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, 'POST', 1);
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app->__invoke($req, $res))
            ->integer($resOut->getStatusCode())
            ->isIdenticalTo(200)
            ->string((string) $resOut->getBody())
            ->contains('EVENT_INVIT_USER_CREATED_SUCCESSFULLY');
    }

    public function testEventInvitationCreationWithInvalidNewContactId()
    {
        $app = $this->newTestedInstance();

        // valid params
        $_REQUEST['new_guest_user_id'] = json_encode(2);
        $_REQUEST['event_id'] = json_encode(1);

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/event/invit/create',
            'REQUEST_METHOD' => 'POST',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, 'POST', 1);
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app->__invoke($req, $res))
            ->integer($resOut->getStatusCode())
            ->isIdenticalTo(400)
            ->string((string) $resOut->getBody())
            ->contains('EVENT_INVIT_USER_EXISTS');
    }
}

class RestEventInvitationChange extends UnitTestRestServerSlimTest
{
    public function testEventInvitationChangeWithoutParams()
    {
        UnitTestRestServerUtil::basicPostTestWithoutParams($this->newTestedInstance(), '/projetX/index.php/event/invit/change', $this);
    }

    public function testEventInvitationChangeAcceptWithValidParams()
    {
        $app = $this->newTestedInstance();

        // valid params
        $_REQUEST['event_id'] = json_encode(1);
        $_REQUEST['status'] = json_encode(EventInvitationAcceptation::Accepted);

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/event/invit/change',
            'REQUEST_METHOD' => 'POST',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, 'POST', 1);
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app->__invoke($req, $res))
            ->integer($resOut->getStatusCode())
            ->isIdenticalTo(200)
            ->string((string) $resOut->getBody())
            ->contains('EVENT_INVIT_USER_CHANGED_SUCCESSFULLY');
    }

    public function testEventInvitationChangeRefuseWithValidParams()
    {
        $app = $this->newTestedInstance();

        // valid params
        $_REQUEST['event_id'] = json_encode(1);
        $_REQUEST['status'] = json_encode(UserContactAcceptation::Refused);

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/event/invit/change',
            'REQUEST_METHOD' => 'POST',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, 'POST', 1);
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app->__invoke($req, $res))
            ->integer($resOut->getStatusCode())
            ->isIdenticalTo(200)
            ->string((string) $resOut->getBody())
            ->contains('EVENT_INVIT_USER_CHANGED_SUCCESSFULLY');
    }
}

/*
 * Class RestEventUserGetInvitation.
 */
/*class RestEventUserGetInvitation extends UnitTestRestServerSlimTest
{
    public function testEventInvitationByIdValidParams()
    {
        $app = $this->newTestedInstance();

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/event/getInvit',
            'REQUEST_METHOD' => 'GET',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, 'GET', 1);
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app->__invoke($req, $res))
            ->integer($resOut->getStatusCode())
            ->isIdenticalTo(200)
            ->array($resOut->getBody())
            ->hasSize(2);
    }
}*/

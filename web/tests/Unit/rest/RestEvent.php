<?php

namespace server\tests\units\rest;

require_once __DIR__.'/../UnitTestRestServerUtil.php';
require_once __DIR__.'/../../../rest/EventController.php';

use server\tests\units\UnitTestRestServerSlimTest;
use server\tests\units\UnitTestRestServerUtil;
use Slim\Http\Environment;
use Slim\Http\Response;

/**
 * Class RestEventCreation.
 */
class RestEventCreation extends UnitTestRestServerSlimTest
{
    public function testEventCreationWithoutParams()
    {
        UnitTestRestServerUtil::basicPostTestWithoutParams($this->newTestedInstance(), '/projetX/index.php/event/create', $this);
    }

    public function testEventCreationWithValidParams()
    {
        $app = $this->newTestedInstance();

        // valid params
        $_REQUEST['name'] = json_encode('event test name');
        $_REQUEST['date'] = json_encode(1555555);
        $_REQUEST['description'] = json_encode('test description');
        $_REQUEST['address'] = json_encode('test address');
        $_REQUEST['theme'] = json_encode('test theme');

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/event/create',
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
            ->contains('EVENT_CREATED_SUCCESSFULLY');
    }
}

/**
 * Class RestEventUserListOwn.
 */
class RestEventUserListOwn extends UnitTestRestServerSlimTest
{
    public function testEventListOwnValidParams()
    {
        $app = $this->newTestedInstance();

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/event/listOwn',
            'REQUEST_METHOD' => 'GET',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, 'GET', 1);
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app->__invoke($req, $res))
            ->integer($resOut->getStatusCode())
            ->isIdenticalTo(200)
            ->string((string) $resOut->getBody())
            ->contains('name')
            ->contains('description');
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 27/07/2017
 * Time: 21:13.
 */

namespace server\tests\units\rest;

require_once __DIR__.'/../UnitTestRestServerUtil.php';
require_once __DIR__.'/../../../rest/RestUserContact.php';

use server\database\UserContactAcceptation;
use server\tests\units\UnitTestRestServerSlimTest;
use server\tests\units\UnitTestRestServerUtil;
use Slim\Http\Environment;
use Slim\Http\Response;

class RestUserContactCreation extends UnitTestRestServerSlimTest
{
    public function testUserContactCreationWithoutParams()
    {
        UnitTestRestServerUtil::basicPostTestWithoutParams($this->newTestedInstance(), '/projetX/index.php/user/contact/create', $this);
    }

    public function testUserContactCreationWithValidParams()
    {
        $app = $this->newTestedInstance();

        // valid params
        $_REQUEST['new_contact_user_id'] = json_encode(10);

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/contact/create',
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
            ->contains('USER_CONTACT_CREATED_SUCCESSFULLY');
    }

    public function testUserContactCreationWithInvalidNewContactId()
    {
        $app = $this->newTestedInstance();

        // valid params
        $_REQUEST['new_contact_user_id'] = json_encode(10);

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/contact/create',
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
            ->contains('USER_CONTACT_EXISTS');
    }
}

class RestUserContactChange extends UnitTestRestServerSlimTest
{
    public function testUserContactChangeWithoutParams()
    {
        UnitTestRestServerUtil::basicPostTestWithoutParams($this->newTestedInstance(), '/projetX/index.php/user/contact/change', $this);
    }

    public function testUserContactChangeAcceptWithValidParams()
    {
        $app = $this->newTestedInstance();

        // valid params
        $_REQUEST['contact_id'] = json_encode(1);
        $_REQUEST['status'] = json_encode(UserContactAcceptation::Accepted);

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/contact/change',
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
            ->contains('USER_CONTACT_CHANGED_SUCCESSFULLY');
    }

    public function testUserContactChangeRefuseWithValidParams()
    {
        $app = $this->newTestedInstance();

        // valid params
        $_REQUEST['contact_id'] = json_encode(1);
        $_REQUEST['status'] = json_encode(UserContactAcceptation::Refused);

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/contact/change',
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
            ->contains('USER_CONTACT_CHANGED_SUCCESSFULLY');
    }
}

/*
 * Class RestEventUserListOwn.
 */
/*class RestUserGetContacts extends UnitTestRestServerSlimTest
{
    public function testUserContactByIdValidParams()
    {
        $app = $this->newTestedInstance();

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/getContact',
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

<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 15/07/2017
 * Time: 10:52.
 */

namespace server\tests\units\rest;

require_once __DIR__.'/../UnitTestRestServerUtil.php';
require_once __DIR__.'/../../../rest/RestServer.php';

use server\tests\units\UnitTestRestServerSlimTest;
use server\tests\units\UnitTestRestServerUtil;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

class RestServer extends UnitTestRestServerSlimTest
{
    public function testGetRequiredParamsNoPresence()
    {
        $app = new testCallable();
        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/login',
            'REQUEST_METHOD' => 'POST',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, 'POST');
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app($req, $res))
            ->array($this->newTestedInstance->getRequiredParams($resOut, ['nickname']))
            ->hasKey('status')
            ->hasKey('response')
            ->contains(false);
    }

    public function testGetRequiredParamsPresent()
    {
        $app = new testCallable();
        // Prepare request and response objects
        $_REQUEST['test'] = json_encode('test');
        $_REQUEST['nickname'] = json_encode('test2');
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/login',
            'REQUEST_METHOD' => 'POST',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, 'POST');
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app($req, $res))
            ->array($this->newTestedInstance->getRequiredParams($resOut, ['nickname', 'test']))
            ->hasKey('status')
            ->hasKey('response')
            ->contains(true)
            ->contains('test')
            ->contains('test2');
    }

    public function testGetSecureParam()
    {
        $this
            ->given($this->newTestedInstance())
            ->string($this->testedInstance->getSecureParam('test{"&et'))
            ->isEqualTo('testet');
    }

    public function testAuthenticatePresent()
    {
        $app = new testCallable();
        // Prepare request and response
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/data',
            'REQUEST_METHOD' => 'GET',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, 'GET', 1);
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app($req, $res))
            ->integer($this->newTestedInstance->authenticate($resOut))
            ->isGreaterThan('-1');
        /* COMPLETE TEST*/
    }

    public function testAuthenticateWithout()
    {
        $app = new testCallable();
        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/data',
            'REQUEST_METHOD' => 'GET',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, 'GET');
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app($req, $res))
            ->string($this->newTestedInstance->authenticate($resOut))
            ->contains('USER_KEY_NOT_FOUND');
    }

    public function testAuthenticateInvadlid()
    {
        $app = new testCallable();
        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/data',
            'REQUEST_METHOD' => 'GET',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, 'GET');
        $_SERVER['HTTP_AUTHORIZATION'] = 'azeczankzadazaz';
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app($req, $res))
            ->string($this->newTestedInstance->authenticate($resOut))
            ->contains('API_KEY_ACCESS_DENIED');
    }

    public function testCreateJSONResponseArray()
    {
        $data = [
            'test'  => 'test2',
            'test5' => 'test5',
        ];

        $this
            ->string((string) $this->newTestedInstance->createJSONResponse(new Response(), 200, $data)->getBody())
            ->contains('test2')
            ->contains('test5');
    }

    public function testCreateJSONResponseRaw()
    {
        $data = 'FAILED';

        $this
            ->string((string) $this->newTestedInstance->createJSONResponse(new Response(), 200, $data)->getBody())
            ->contains($data);
    }
}

class testCallable
{
    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $args = [])
    {
        return $response;
    }
}

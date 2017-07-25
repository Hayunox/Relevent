<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 15/07/2017
 * Time: 10:52.
 */

namespace server\tests\units\rest;

require_once __DIR__.'/../../../rest/RestServer.php';

use mageekguy\atoum\test;
use server\database\DBConnection;
use server\database\DBUser;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;
use Slim\Http\Uri;

class RestServer extends test
{
    public function testGetRequiredParamsNoPresence()
    {
        $app = new testCallable();
        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/login',
            'REQUEST_METHOD' => 'POST',
        ]);

        $req = self::createEnvironment($env);
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app($req, $res))
            ->array($this->newTestedInstance->getRequiredParams($resOut, ['nickname']))
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

        $req = self::createEnvironment($env);
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app($req, $res))
            ->array($this->newTestedInstance->getRequiredParams($resOut, ['nickname', 'test']))
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

        /* Get real key */
        $user = new DBUser(1);
        $connection = new DBConnection();
        $user_key = $user->getUserData($connection)['key'];

        $_SERVER['HTTP_AUTHORIZATION'] = $user_key;
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/data',
            'REQUEST_METHOD' => 'GET',
        ]);

        $req = self::createEnvironment($env);
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
        $_SERVER['HTTP_AUTHORIZATION'] = null;
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/data',
            'REQUEST_METHOD' => 'GET',
        ]);

        $req = self::createEnvironment($env);
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
        $_SERVER['HTTP_AUTHORIZATION'] = 'azeczankzadazaz';
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/data',
            'REQUEST_METHOD' => 'GET',
        ]);

        $req = self::createEnvironment($env);
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

    public static function createEnvironment($env){
        $uri = Uri::createFromEnvironment($env);
        $headers = Headers::createFromEnvironment($env);
        $cookies = [];
        $serverParams = $env->all();
        $body = new RequestBody();
        return new Request('POST', $uri, $headers, $cookies, $serverParams, $body);
    }

    public function getAutoloaderFile()
    {
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

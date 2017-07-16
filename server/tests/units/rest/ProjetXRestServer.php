<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 15/07/2017
 * Time: 10:52.
 */

namespace server\tests\units\rest;

require_once __DIR__.'/../../../rest/ProjetXRestServer.php';

use mageekguy\atoum\test;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;
use Slim\Http\Uri;

class ProjetXRestServer extends test
{
    public function testGetRequiredParamsNoPresence()
    {
        $app = new testCallable();
        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/login',
            'REQUEST_METHOD' => 'POST',
        ]);
        $uri = Uri::createFromEnvironment($env);
        $headers = Headers::createFromEnvironment($env);
        $cookies = [];
        $serverParams = $env->all();
        $body = new RequestBody();
        $req = new Request('POST', $uri, $headers, $cookies, $serverParams, $body);
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
        $uri = Uri::createFromEnvironment($env);
        $headers = Headers::createFromEnvironment($env);
        $cookies = [];
        $serverParams = $env->all();
        $body = new RequestBody();
        $req = new Request('POST', $uri, $headers, $cookies, $serverParams, $body);
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

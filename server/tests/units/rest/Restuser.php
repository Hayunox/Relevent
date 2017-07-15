<?php

/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 15/07/2017
 * Time: 10:52
 */

namespace server\tests\units\rest;

require_once __DIR__.'/../../../rest/Restuser.php';

use mageekguy\atoum\test;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;
use Slim\Http\Uri;
use Slim\App;

class Restuser extends test
{

    public function testUserRegistration(){
        $app = new App();
        $app->getContainer();
        // Prepare request and response objects
        $env = Environment::mock([
            'SCRIPT_NAME' => '/index.php',
            'REQUEST_URI' => '/user/register',
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
            ->integer($resOut->getStatusCode())
                ->isIdenticalTo(404)
            ->string((string)$resOut->getBody())
                ->contains('Not Found');
    }

    public function testUserLogin(){

    }

    public function getAutoloaderFile(){}
}
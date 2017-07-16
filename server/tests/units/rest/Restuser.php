<?php

/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 15/07/2017
 * Time: 10:52
 * 'QUERY_STRING'=>'nickname=ezr&password=ezr',
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

class RestUserRegister extends test
{

    public function testUserRegisterWithoutCredentials()
    {
        $app = $this->newTestedInstance();
        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI' => '/projetX/index.php/user/register',
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
            ->isIdenticalTo(400)
            ->string((string)$resOut->getBody())
            ->contains('is missing or empty');
    }
    public function testUserRegisterWithIncorrectCredentials()
    {
        $app = $this->newTestedInstance();
        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI' => '/projetX/index.php/user/register',
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
            ->isIdenticalTo(400)
            ->string((string)$resOut->getBody())
            ->contains('is missing or empty');
    }
    public function getAutoloaderFile(){}
}

class RestUserLogin extends test
{
    public function testUserLoginWithoutCredentials()
    {
        $app = $this->newTestedInstance();
        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI' => '/projetX/index.php/user/login',
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
            ->isIdenticalTo(400)
            ->string((string)$resOut->getBody())
            ->contains('is missing or empty');
    }

    public function testUserLoginWithIncorrectCredentials()
    {
        $app = $this->newTestedInstance();
        // Prepare request and response objects
        $post = array(
            'nickname'  => 'zaeaezd',
            'password'  => 'zaecezfezddqs',
        );
        $env = Environment::mock([
            'REQUEST_URI' => '/projetX/index.php/user/login',
            'REQUEST_METHOD' => 'POST',
        ]);
        $uri = Uri::createFromEnvironment($env);
        $headers = Headers::createFromEnvironment($env);
        $headers->set('nickname', 'zaeaezd');
        $headers->set('password', 'zaecezfezddqs');
        $cookies = [];
        $serverParams = $env->all();
        $body = new RequestBody($post);
        $req = new Request('POST', $uri, $headers, $cookies, $serverParams, $body);
        $res = new Response();
        $req->registerMediaTypeParser('application/x-www-form-urlencoded', function ($input) {
            parse_str($input, $body);
            return $body; // <-- Array
        });


        // Invoke app
        $this
            ->given($resOut = $app($req, $res))
            ->integer($resOut->getStatusCode())
            ->isIdenticalTo(400)
            ->string((string)$resOut->getBody())
            ->contains('is missing or empty');
    }

    public function getAutoloaderFile(){}
}
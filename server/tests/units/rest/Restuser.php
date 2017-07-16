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
    
    public function testUserRegisterWithValidCredentials()
    {
        $app = $this->newTestedInstance();

        // valid credentials
        $_REQUEST['nickname'] = 'test';
        $_REQUEST['mail'] = 'test@test.fr';
        $_REQUEST['password'] = 'zaecezfezddqs';

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

    public function testUserRegisterWithInvalidMail()
    {
        $app = $this->newTestedInstance();

        // invalid mail
        $_REQUEST['nickname'] = 'zaeacrrztheqczzdz';
        $_REQUEST['mail'] = 'test@test.fr';
        $_REQUEST['password'] = 'zaecezfezddqs';

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

    public function testUserRegisterWithInvalidNickname()
    {
        $app = $this->newTestedInstance();

        // invalid nickname
        $_REQUEST['nickname'] = 'test';
        $_REQUEST['mail'] = 'zaeceddqs@fr.fr';
        $_REQUEST['password'] = 'zaecezfezddqs';

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

        // Incorrect credentials
        $_REQUEST['nickname'] = 'zaeaezd';
        $_REQUEST['password'] = 'zaecezfezddqs';

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
            ->isIdenticalTo(200)
            ->string((string)$resOut->getBody())
            ->contains('is missing or empty');
        error_log($resOut);
        unset($_REQUEST);
    }

    public function testUserLoginWithValidCredentials()
    {
        $app = $this->newTestedInstance();

        // Incorrect credentials
        $_REQUEST['nickname'] = 'test';
        $_REQUEST['password'] = 'test';

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
            ->isIdenticalTo(200)
            ->string((string)$resOut->getBody())
            ->contains('is missing or empty');
        error_log($resOut);
        unset($_REQUEST);
    }

    public function getAutoloaderFile(){}
}
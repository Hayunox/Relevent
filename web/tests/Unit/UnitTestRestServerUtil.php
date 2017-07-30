<?php

namespace server\tests\units;

use atoum\test;
use server\database\DBConnection;
use server\database\DBUser;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;
use Slim\Http\Uri;

class UnitTestRestServerUtil
{
    /**
     * @param Environment $env
     * @param string      $method
     * @param null        $user_id
     *
     * @return Request
     */
    public static function createTestEnvironment(Environment $env, String $method, $user_id = null)
    {
        /* Get real key */
        if ($user_id != null) {
            $user = new DBUser($user_id);
            $connection = new DBConnection();
            $user_key = $user->getUserData($connection)['key'];

            $_SERVER['HTTP_AUTHORIZATION'] = $user_key;
        } else {
            $_SERVER['HTTP_AUTHORIZATION'] = null;
        }

        $uri = Uri::createFromEnvironment($env);
        $headers = Headers::createFromEnvironment($env);
        $cookies = [];
        $serverParams = $env->all();
        $body = new RequestBody();

        return new Request($method, $uri, $headers, $cookies, $serverParams, $body);
    }

    /**
     * @param $app
     * @param $url
     * @param UnitTestRestServerSlimTest $test
     */
    public static function basicPostTestWithoutParams($app, $url, UnitTestRestServerSlimTest $test)
    {
        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => $url,
            'REQUEST_METHOD' => 'POST',
        ]);
        $req = self::createTestEnvironment($env, 'POST', 1);
        $res = new Response();

        $test
            ->given($resOut = $app->__invoke($req, $res))
            ->integer($resOut->getStatusCode())
            ->isIdenticalTo(400)
            ->string((string) $resOut->getBody())
            ->contains('is missing or empty');
    }
}
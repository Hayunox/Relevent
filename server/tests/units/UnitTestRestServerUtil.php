<?php

namespace server\tests\units;

use atoum\test;
use server\database\DBConnection;
use server\database\DBUser;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
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
}

class UnitTestRestServerSlimTest extends test
{
    public function getAutoloaderFile()
    {
    }
}

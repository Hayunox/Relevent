<?php
use Slim\Http\Body;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Uri;
use Slim\Route;

/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 15/07/2017
 * Time: 10:52
 */
class Restuser
{

    public function testUserRegistration(){
       /* $scheme = 'http';
        $user = 'test';
        $password = '';
        $host = 'localhost';
        $path = '/foo/bar';
        $port = 443;
        $query = 'abc=123';
        $fragment = 'section3';
        $uri = new Uri($scheme, $host, $port, $path, $query, $fragment, $user, $password);
        $this->assertEquals('josh@example.com', $uri->getAuthority());

        $callable = function ($req, $res, $args) {
            return $res->write('foo');
        };
        $route = new Route(['GET'], '/', $callable);
        $env = Environment::mock();
        $uri = Uri::createFromString('https://example.com:80');

        $this
            ->given($this->newTestedInstance(null))*/
    }

    public function testUserLogin(){

    }

}
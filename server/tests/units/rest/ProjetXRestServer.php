<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 15/07/2017
 * Time: 10:52
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
use Slim\App;

class ProjetXRestServer extends test{

    public function testRunProjetXRestServer(){
        $this
            ->object(new ProjetXRestServer())
            ->hasSize(1);
    }

    public function getAutoloaderFile(){}
}
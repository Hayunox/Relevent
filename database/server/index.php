<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 11/07/2017
 * Time: 17:22
 */

//require 'lib/Slim3/App.php';

//\Slim\Slim::registerAutoloader();

/*$app = new Slim\App();

$app->get('/hello/{name}', function ($request, $response, $args) {
    return $response->write("Hello, " . $args['name']);
});

$app->run();*/
require 'DBConnection.php';

$db = new DBConnection();
$connection = $db->connect();
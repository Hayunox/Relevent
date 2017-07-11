<?php
/**
 * Created by PhpStorm.
 * UserDb: Paul
 * Date: 11/07/2017
 * Time: 17:22
 */

require 'vendor/autoload.php';

use Slim\Route;
use Slim\Slim;

$app = new Slim\App();


/**
 * Adding Middle Layer to authenticate every request
 * Checking if the request has valid api key in the 'Authorization' header
 */
function authenticate(Route $route) {
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = Slim::getInstance();

    // Verifying Authorization Header
    if (isset($headers['Authorization'])) {
        $db = new DBConnection();
        $db->connect();

        $user = new UserDb(null);

        // get the user key
        $api_key = $headers['Authorization'];

        // validating user key
        $keyExists = $user->userKeyExists($db, $api_key);
        if ($keyExists) {
            global $user_id;
            $user_id = $keyExists;
        } else {
            // user key is not present in users table
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            responseApp(401, $response);
            $app->stop();
        }
    } else {
        // user key is missing in header
        $response["error"] = true;
        $response["message"] = "user key is misssing";
        responseApp(400, $response);
        $app->stop();
    }
}

/**
 * Verifying required params posted or not
 * @param $required_fields
 */
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        responseApp(400, $response);
        $app->stop();
    }
}

/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function responseApp($status_code, $response) {
    $app = Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

$app->run();
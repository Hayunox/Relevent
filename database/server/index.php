<?php
/**
 * Created by PhpStorm.
 * UserDb: Paul
 * Date: 11/07/2017
 * Time: 17:22
 */

require 'vendor/autoload.php';

use Slim\App;
use Slim\Route;
use Slim\Slim;

// Start Server
$srv = new ProjetXServer();

class ProjetXServer
{
    private $app;

    /**
     * ProjetXServer constructor.
     */
    function __construct()
    {
        $this->app = new App();

        /**
         * ----------- METHODS WITHOUT AUTHENTICATION ---------------------------------
         */
        /**
         * User Registration
         * url - /register
         * method - POST
         * params - name, email, password
         */
        $this->app->post('/register', function() {
            // check for required params
            verifyRequiredParams(array('nickname', 'mail', 'password'));

            $response = array();

            // reading post params
            $name       = $this->app->request->post('nickname');
            $email      = $this->app->request->post('mail');
            $password   = $this->app->request->post('password');

            $db = new DBConnection();
            $db->connect();

            // User validation
            $user = new UserDb();

            // validating email address
            if(!$user->userMailExists($email)){
                $response["error"] = true;
                $response["message"] = "Sorry, this mail already existed";

                // validating nickname
            }elseif (!$user->userNickNameExists($name)) {
                $response["error"] = true;
                $response["message"] = "Sorry, this nickname already existed";

                // User validated
            }else{
                $res = $user->userCreate($db, array(
                    'user_nickname'     => $name,
                    'user_mail'         => $email,
                    'user_password'     => $password
                ));

                if ($res > -1) {
                    $response["error"] = false;
                    $response["message"] = "You are successfully registered";
                } else if ($res == UserCreation::USER_CREATE_FAILED) {
                    $response["error"] = true;
                    $response["message"] = "Oops! An error occurred while registereing";
                }
            }

            // echo json response
            echoRespnse(201, $response);
        });

        /**
         * ----------- METHODS WITH AUTHENTICATION ---------------------------------
         */

        $this->app->run();
    }

    /**
     * Adding Middle Layer to authenticate every request
     * Checking if the request has valid api key in the 'Authorization' header
     */
    function authenticate(Route $route) {
        // Getting request headers
        $headers = apache_request_headers();
        $response = array();

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
                $this->app->stop();
            }
        } else {
            // user key is missing in header
            $response["error"] = true;
            $response["message"] = "user key is misssing";
            responseApp(400, $response);
            $this->app->stop();
        }
    }



    /**
     * Verifying required params posted or not
     * @param $required_fields
     */
    private function verifyRequiredParams($required_fields) {
        $error = false;
        $error_fields = "";
        $request_params = $_REQUEST;
        // Handling PUT request params
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            parse_str($this->app->request()->getBody(), $request_params);
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
            $response["error"] = true;
            $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
            responseApp(400, $response);
            $this->app->stop();
        }
    }

    /**
     * Echoing json response to client
     * @param String $status_code Http response code
     * @param Int $response Json response
     */
    private function responseApp($status_code, $response) {
        // Http response code
        $this->app->status($status_code);

        // setting response content type to json
        $this->app->contentType('application/json');

        echo json_encode($response);
    }
}
<?php
/**
 * Created by PhpStorm.
 * UserDb: Paul
 * Date: 11/07/2017
 * Time: 17:22
 */

require 'vendor/autoload.php';

require 'DBConnection.php';
require 'SQL/UserDB.php';

use Slim\App;
use Slim\Slim;
use Slim\Http\Request;
use Slim\Http\Response;

// Start Server
$srv = new ProjetXServer();

class ProjetXServer
{
    private $app;
    private $container;

    /**
     * ProjetXServer constructor.
     */
    function __construct()
    {
        $this->app = new App();

        $this->container =  $this->app->getContainer();

        /**
         *
         */
        $this->methodsWithoutAuthentification();


        /**
         *
         */
        $this->methodsWithAuthentification();

        $this->app->run();
    }

    /**
     *
     */
    private function methodsWithoutAuthentification(){
        $this->userRegistration();
    }

    /**
     *
     */
    private function methodsWithAuthentification(){

    }

    /**
     *
     */
    private function userRegistration(){
        /**
         * User Registration
         * url - /register
         * method - POST
         * params - name, email, password
         */
        $this->app->post('/register', function(Request $request, Response $response) {
            // check for required params
            ProjetXServer::verifyRequiredParams($request, $response, array('nickname', 'mail', 'password'));

            // reading post params
            $name       = $request->getParam('nickname');
            $email      = $request->getParam('mail');
            $password   = $request->getParam('password');

            $db = new DBConnection();
            $connection = $db->connect();

            // User validation
            $user = new UserDb(null);

            // validating email address
            if($user->userMailExists($connection, $email)){
                $message = UserCreation::USER_MAIL_EXISTED;

                // validating nickname
            }elseif ($user->userNickNameExists($connection, $name)) {
                $message = UserCreation::USER_NICKNAME_EXISTED;

                // User validated
            }else{
                $res = $user->userCreate($connection, array(
                    'user_nickname'     => $name,
                    'user_mail'         => $email,
                    'user_password'     => $password
                ));

                if ($res > -1) {
                    $message = UserCreation::USER_CREATED_SUCCESSFULLY;
                } else{
                    $message = UserCreation::USER_CREATE_FAILED;
                }
            }

            // echo json response
            $response
                ->withStatus(200)
                ->withHeader('Content-type', 'application/json')
                ->write($message);
        });
    }

    /**
     * Adding Middle Layer to authenticate every request
     * Checking if the request has valid api key in the 'Authorization' header
     * @param $app
     * @param $response
     * @internal param Route $route
     */
    public static function authenticate(App $app, Response $response)
    {
        // Getting request headers
        $headers = apache_request_headers();

        // Verifying Authorization Header
        if (isset($headers['Authorization'])) {
            $db = new DBConnection();
            $connection = $db->connect();

            $user = new UserDb(null);

            // get the user key
            $api_key = $headers['Authorization'];

            // validating user key
            $keyExists = $user->userKeyExists($connection, $api_key);
            if ($keyExists) {
                global $user_id;
                $user_id = $keyExists;
            } else {
                // user key is not present in users table
                $message = APIKey::API_KEY_ACESS_DENIED;
                $response
                    ->withStatus(401)
                    ->withHeader('Content-type', 'application/json')
                    ->write($message);
            }
        } else {
            // user key is missing in header
            $message = APIKey::USER_KEY_NOT_FOUND;
            $response
                ->withStatus(400)
                ->withHeader('Content-type', 'application/json')
                ->write($message);
        }
    }


    /**
     * Verifying required params posted or not
     * @param $app
     * @param $required_fields
     * @param $response
     */
    public static function verifyRequiredParams(Request $app, Response $response, $required_fields)
    {
        $error = false;
        $error_fields = "";
        $request_params = $_REQUEST;
        // Handling PUT request params
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            parse_str($response->getBody(), $request_params);
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
            $message = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
            $response
                ->withStatus(400)
                ->withHeader('Content-type', 'application/json')
                ->write($message);
        }
    }
}
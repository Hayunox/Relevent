<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 14/07/2017
 * Time: 20:12.
 */

namespace server\rest;

require_once __DIR__.'/Restuser.php';

use server\database\DBconnection;
use server\database\DBuser;
use Slim\App;
use Slim\Http\Response;

class ProjetXRestServer
{
    private $app;
    private $container;

    /**
     * ProjetXServer constructor.
     */
    public function __construct()
    {
        $this->app = new App();

        $this->container = $this->app->getContainer();

        /*
         * Method without authentification
         */
        /*
         * User Registration
         * url - /register
         * method - POST
         * params - name, email, password
         */
        $this->app->post('/user/register', new RestUserCreation());

        /*
         * User Registration
         * url - /register
         * method - POST
         * params - name, email, password
         */
        $this->app->post('/user/login', new RestUserLogin());

        /*
         * Method with authentificatio
         */

        $this->app->run();
    }

    /**
     * Adding Middle Layer to authenticate every request
     * Checking if the request has valid api key in the 'Authorization' header.
     *
     * @param $response
     *
     * @internal param Route $route
     */
    public static function authenticate(Response $response)
    {
        // Getting request headers
        $headers = apache_request_headers();

        // Verifying Authorization Header
        if (isset($headers['Authorization'])) {
            $db = new DBConnection();
            $connection = $db->connect();

            $user = new DBuser(null);

            // get the user key
            $api_key = $headers['Authorization'];

            // validating user key
            $keyExists = $user->userKeyExists($connection, $api_key);
            if ($keyExists) {
                global $user_id;
                $user_id = $keyExists;
            } else {
                // user key is not present in users table
                $message = 'API_KEY_ACCESS_DENIED';
                $response
                    ->withStatus(401)
                    ->withHeader('Content-type', 'application/json')
                    ->withJson(json_encode($message));
            }
        } else {
            // user key is missing in header
            $message = 'USER_KEY_NOT_FOUND';
            $response
                ->withStatus(400)
                ->withHeader('Content-type', 'application/json')
                ->withJson(json_encode($message));
        }
    }

    /**
     * Verifying required params posted or not.
     *
     * @param Response $response
     * @param $required_fields
     *
     * @return array
     */
    public static function getRequiredParams(Response $response, $required_fields)
    {
        $error = false;
        $error_fields = '';
        $request_params = $_REQUEST;
        $params = [];

        // Handling PUT request params
        if (array_key_exists('REQUEST_METHOD', $_SERVER) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
            parse_str($response->getBody(), $request_params);
        }
        foreach ($required_fields as $field) {
            if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
                $error = true;
                $error_fields .= $field.', ';
            } else {
                $params[$field] = $request_params[$field];
            }
        }

        if ($error) {
            // Required field(s) are missing or empty
            // echo error json and stop the app
            $message = 'Required field(s) '.substr($error_fields, 0, -2).' is missing or empty';

            return [
                'status'    => false,
                'response'  => $message,
            ];
        }

        return [
            'status'    => true,
            'response'  => $params,
        ];
    }

    /**
     * @param $param
     *
     * @return string
     */
    public static function getSecureParam($param)
    {
        return preg_replace('/[^A-Za-z0-9\-@\.\-]/', '', $param);
    }

    /*
     * @param $param
     * @return mixed
     */
    /*public static function getSecureXSSParam($param){

    }*/
}

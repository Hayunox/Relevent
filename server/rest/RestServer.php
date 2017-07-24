<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 14/07/2017
 * Time: 20:12.
 */

namespace server\rest;

require_once __DIR__.'/Restuser.php';
require_once __DIR__.'/Restevent.php';

use server\database\DBconnection;
use server\database\DBuser;
use Slim\App;
use Slim\Http\Response;

class RestServer
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
         * Method with authentification
         */
        /**
         * EVENT
         */
        $this->app->post('/event/create', new RestEventCreation());
        $this->app->get('/event/listOwn', new RestEventUserListOwn());

        // Run server app
        $this->app->run();
    }

    /**
     * @return string|integer
     */
    public static function authenticate()
    {
        // Getting request headers
        $authorization = $_SERVER['HTTP_AUTHORIZATION'];

        // Verifying Authorization Header
        if (isset($authorization)) {
            $connection = new DBConnection();

            $user = new DBuser(null);

            // get the user key
            $api_key = $authorization;

            // validating user key
            $keyExists = $user->userKeyExists($connection, $api_key);
            if ($keyExists) {
                // user_id
                return $keyExists;
            } else {
                // user key is not present in users table
                return 'API_KEY_ACCESS_DENIED';
            }
        } else {
            // user key is missing in header
            return'USER_KEY_NOT_FOUND';
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

        /*// Handling PUT request params
        if (array_key_exists('REQUEST_METHOD', $_SERVER) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
            parse_str($response->getBody(), $request_params);
        }*/
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

    /**
     * @param Response $response
     * @param $status
     * @param $data
     *
     * @return Response
     */
    public static function createJSONResponse(Response $response, $status, $data)
    {
        $data = json_encode($data);

        return $response
            ->withStatus($status)
            ->withHeader('Content-type', 'application/json')
            ->write($data);
    }
}

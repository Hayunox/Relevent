<?php

namespace server\rest;

require_once __DIR__.'/RestUser.php';
require_once __DIR__.'/RestUserContact.php';
require_once __DIR__.'/RestEvent.php';
require_once __DIR__.'/RestEventInvitation.php';

use server\database\DBConnection;
use server\database\DBUser;
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

        /**
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

        /**
         * Methods with authentification
         */
        /**
         * Event
         */
        $this->app->post('/event/create', new RestEventCreation());
        $this->app->get('/event/listOwn', new RestEventUserListOwn());

        /**
         * Event Invitation
         */
        $this->app->post('/event/invit/create', new RestEventInvitationCreation());
        $this->app->post('/event/invit/change', new RestUserContactChange());
        $this->app->get('/event/getInvit/{id}', new RestUserGetContacts());

        /**
         * User
         */
        $this->app->get('/user/getDataById/{id}', new RestUserGetDataById());

        /**
         * User Contact
         */
        $this->app->post('/user/contact/create', new RestUserContactCreation());
        $this->app->post('/user/contact/change', new RestUserContactChange());
        $this->app->get('/user/getContact/{id}', new RestUserGetContacts());

        // Run server app
        $this->app->run();
    }

    /**
     * @return string|int
     */
    public static function authenticate()
    {
        // Getting request headers
        $authorization = $_SERVER['HTTP_AUTHORIZATION'];

        // Verifying Authorization Header
        if (isset($authorization)) {
            $connection = new DBConnection();

            $user = new DBUser(null);

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
        if (array_key_exists('REQUEST_METHOD', $_SERVER) && $_SERVER['REQUEST_METHOD'] == 'PUT') {*/
        //    parse_str($response->getBody(), $request_params);
        //}
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

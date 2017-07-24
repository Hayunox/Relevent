<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 14/07/2017
 * Time: 19:51.
 */

namespace server\rest;

require_once __DIR__.'/../vendor/autoload.php';

require_once __DIR__.'/../database/DBconnection.php';
require_once __DIR__.'/../database/DBuser.php';
require_once __DIR__.'/RestServer.php';

use mageekguy\atoum\asserters\error;
use server\database\DBconnection;
use server\database\DBuser;
use Slim\Http\Request;
use Slim\Http\Response;

class RestUserCreation
{
    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $args = [])
    {
        $verification = RestServer::getRequiredParams($response, ['nickname', 'mail', 'password']);

        if ($verification['status']) {
            return $this->userRegister($verification['response'], $response);
        }

        return RestServer::createJSONResponse($response, 400, $verification['response']);
    }

    /**
     * @param $data
     * @param Response $response
     *
     * @return Response
     */
    public function userRegister($data, Response $response)
    {
        // reading post params
        $name = RestServer::getSecureParam($data['nickname']);
        $email = RestServer::getSecureParam($data['mail']);
        $password = RestServer::getSecureParam($data['password']);

        $connection = new DBConnection();

        // User validation
        $user = new DBuser(null);

        // validating email address
        if ($user->userMailExists($connection, $email)) {
            $response = RestServer::createJSONResponse($response, 400, 'USER_MAIL_EXISTS');

            // validating nickname
        } elseif ($user->userNickNameExists($connection, $name)) {
            $response = RestServer::createJSONResponse($response, 400, 'USER_NICKNAME_EXISTS');

            // User validated
        } else {
            $res = $user->userCreate($connection, [
                'user_nickname'     => $name,
                'user_mail'         => $email,
                'user_password'     => $password,
            ]);

            if ($res > -1) {
                $response = RestServer::createJSONResponse($response, 200, 'USER_CREATED_SUCCESSFULLY');
            } else {
                $response = RestServer::createJSONResponse($response, 400, 'USER_CREATE_FAILED');
            }
        }

        return $response;
    }
}

class RestUserLogin
{
    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return RestUserLogin|Response
     */
    public function __invoke(Request $request, Response $response, $args = [])
    {
        $verification = RestServer::getRequiredParams($response, ['nickname', 'password']);

        if ($verification['status']) {
            return $this->userLogin($verification['response'], $response);
        }

        return RestServer::createJSONResponse($response, 400, $verification['response']);
    }

    /**
     * @param $data
     * @param Response $response
     *
     * @return Response
     */
    public function userLogin($data, Response $response)
    {
        // reading post params
        $name = RestServer::getSecureParam($data['nickname']);
        $password = RestServer::getSecureParam($data['password']);

        $connection = new DBConnection();

        // User validation
        $user = new DBuser(null);

        // validating email address
        if (is_array($user_data = $user->tryLogin($connection, $name, $password))) {
            $response = RestServer::createJSONResponse($response, 200, $user_data);

        // Connection failed
        } else {
            $response = RestServer::createJSONResponse($response, 400, 'USER_LOGIN_FAILED');
        }

        return $response;
    }
}


class RestUserGetDataById
{
    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $args = [])
    {
        $authentication = RestServer::authenticate();

        // Authentication success
        if(is_int($authentication)){
            return $this->userDataById($response, $request);
        }

        return RestServer::createJSONResponse($response, 400, $authentication);
    }

    /**
     * @param Response $response
     * @param Request $request
     * @return Response
     */
    public function userDataById(Response $response, Request $request)
    {
        $connection = new DBConnection();

        $route = $request->getAttribute('route');
        $user_id = RestServer::getSecureParam($route->getArgument('id'));

        // User validation
        $user = new DBuser($user_id);

        return RestServer::createJSONResponse($response, 200, $user->getUserData($connection));
    }
}


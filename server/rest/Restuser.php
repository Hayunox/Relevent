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
require_once __DIR__.'/ProjetXRestServer.php';

use server\database\DBconnection;
use server\database\DBuser;
use Slim\Http\Request;
use Slim\Http\Response;

class RestUserRegister {

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $args = [])
    {
        $verification = ProjetXRestServer::verifyRequiredParams($response, ['nickname', 'mail', 'password']);

        if ($verification["status"]) {
            return $this->userRegister($request, $response);
        }

        return $response
            ->withStatus(400)
            ->withHeader('Content-type', 'application/json')
            ->withJson($verification["response"]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function userRegister(Request $request, Response $response){
        // reading post params
        $name = $request->getParam('nickname');
        $email = $request->getParam('mail');
        $password = $request->getParam('password');

        $db = new DBConnection();
        $connection = $db->connect();

        // User validation
        $user = new DBuser(null);
        error_log("inscr");
        // validating email address
        if ($user->userMailExists($connection, $email)) {
            $message = 'USER_MAIL_EXISTED';

            // validating nickname
        } elseif ($user->userNickNameExists($connection, $name)) {
            $message = 'USER_NICKNAME_EXISTED';

            // User validated
        } else {
            $res = $user->userCreate($connection, [
                'user_nickname'     => $name,
                'user_mail'         => $email,
                'user_password'     => $password,
            ]);

            if ($res > -1) {
                $message = 'USER_CREATED_SUCCESSFULLY';
            } else {
                $message = 'USER_CREATE_FAILED';
            }
        }

        return $response
            ->withStatus(200)
            ->withHeader('Content-type', 'application/json')
            ->withJson($message);
    }
}


class RestUserLogin {

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return RestUserLogin|Response
     */
    public function __invoke(Request $request, Response $response, $args = [])
    {
        $verification = ProjetXRestServer::verifyRequiredParams($response, ['nickname', 'password']);

        if ($verification["status"]) {
            return $this->userLogin($request, $response);
        }

        return $response
            ->withStatus(400)
            ->withHeader('Content-type', 'application/json')
            ->withJson($verification["response"]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function userLogin(Request $request, Response $response){
        // reading post params
        $name = $request->getParam('nickname');
        $password = $request->getParam('password');

        $db = new DBConnection();
        $connection = $db->connect();

        // User validation
        $user = new DBuser(null);

        // validating email address
        if ($user->tryLogin($connection, $name, $password)) {
            $message = 'USER_LOGIN_SUCCESSFULLY';

            // Connection failed
        } else {
            $message = 'USER_LOGIN_FAILED';
        }

        return $response
            ->withStatus(200)
            ->withHeader('Content-type', 'application/json')
            ->withJson($message);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 14/07/2017
 * Time: 19:51.
 */

namespace server\rest;

require_once __DIR__.'/../vendor/autoload.php';

use server\database\DBconnection;
use server\database\DBuser;
use server\ProjetXServer;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

class Restuser
{
    public static function userRegistration(App $app)
    {
        /*
         * User Registration
         * url - /register
         * method - POST
         * params - name, email, password
         */
        $app->post('/register', function (Request $request, Response $response) {
            // check for required params
            ProjetXServer::verifyRequiredParams($request, $response, ['nickname', 'mail', 'password']);

            // reading post params
            $name = $request->getParam('nickname');
            $email = $request->getParam('mail');
            $password = $request->getParam('password');

            $db = new DBConnection();
            $connection = $db->connect();

            // User validation
            $user = new DBuser(null);

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

            // echo json response
            $response
                ->withStatus(200)
                ->withHeader('Content-type', 'application/json')
                ->write($message);
        });
    }
}

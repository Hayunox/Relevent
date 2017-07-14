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

use server\database\DBconnection;
use server\database\DBuser;

class Restuser
{
    /**
     * @param $name
     * @param $email
     * @param $password
     *
     * @return string
     */
    public static function userRegistration($name, $email, $password)
    {
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
        return $message;
    }
}

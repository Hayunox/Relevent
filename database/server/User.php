<?php

/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 11/07/2017
 * Time: 17:04
 */
class User
{
    private $user_id;
    private $user_nickname;
    private $user_name;
    private $user_surname;
    private $user_password;
    private $user_mail;
    private $user_key;

    /**
     * User constructor.
     * @param $userData
     */
    function __construct($userData) {
        $user_id        = $userData['id'];
        $user_nickname  = $userData['nickname'];
        $user_name      = $userData['name'];
        $user_surname   = $userData['surname'];
        $user_password  = $userData['password'];
        $user_mail      = $userData['mail'];
        $user_key       = $userData['hashkey'];
    }

    public function userPasswordEncrypt(){

    }

    public static function userNickNameExists(){

    }

    public static function userMailExists(){

    }

    /**
     * Generating random Unique MD5 String for user key
     */
    private function generateUserKey() {
        return md5(uniqid(rand(), true));
    }

    public function userRegister(){

    }
}
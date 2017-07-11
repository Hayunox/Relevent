<?php

/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 11/07/2017
 * Time: 18:54
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

    private $userDb;

    /**
     * User constructor.
     * @param $userData
     */
    function __construct($user_id) {
        $this->userDb        = new UserDb($user_id);
        /*$this->user_id      = $userData[$this->table_row['user_id']];
        $this->user_nickname  = $userData[$this->table_row['user_nickname']];
        $this->user_name      = $userData[$this->table_row['user_name']];
        $this->user_surname   = $userData[$this->table_row['user_surname']];
        $this->user_password  = $userData[$this->table_row['user_password']];
        $this->user_mail      = $userData[$this->table_row['user_mail']];
        $this->user_key       = $userData[$this->table_row['user_key']];*/
    }

    /**
     *
     */
    public function userRegister(){
        $this->user_key     = $this->userDb->generateUserKey();
        // TODO : registration time
    }

    /**
     * @return array
     */
    public function userToArray(){
        return array(
            'user_id'               => $this->user_id,
            'user_nickname'         => $this->user_nickname,
            'user_name'             => $this->user_name,
            'user_surname'          => $this->user_surname,
            'user_password'         => $this->user_password,
            'user_mail'             => $this->user_mail,
            'user_key'              => $this->user_key,
        );
    }
}
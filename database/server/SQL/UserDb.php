<?php

/**
 * Created by PhpStorm.
 * UserDb: Paul
 * Date: 11/07/2017
 * Time: 17:04
 */
class UserDb
{
    private $user_id;
    private $user_nickname;
    private $user_name;
    private $user_surname;
    private $user_password;
    private $user_mail;
    private $user_key;

    private $user_table = "user";

    private $table_row = array(
        'user_id'               => 'id',
        'user_nickname'         => 'nickname',
        'user_name'             => 'name',
        'user_surname'          => 'surname',
        'user_password'         => 'password',
        'user_mail'             => 'mail',
        'user_key'              => 'hashkey',
    );

    /**
     * UserDb constructor.
     * @param $user_id
     */
    function __construct($user_id) {
        $this->user_id      = $user_id;
    }

    /**
     * @param $user_id
     */
    public function setUserId($user_id){
        $this->user_id = $user_id;
    }

    /**
     * @param $db
     * @return array
     */
    public function getUserData($db){
        $query                  = $db->table($this->user_table)->where($this->table_row['user_id'], '=', $this->user_id);
        $user_data              = $query->get();
        $this->user_nickname    = $user_data->$this->table_row['user_nickname'];
        $this->user_name        = $user_data->$this->table_row['user_name'];
        $this->user_surname     = $user_data->$this->table_row['user_surname'];
        $this->user_password    = $user_data->$this->table_row['user_password'];
        $this->user_mail        = $user_data->$this->table_row['user_mail'];
        $this->user_key         = $user_data->$this->table_row['user_key'];
        return $this->userDbToArray();
    }

    /**
     * @param $db
     * @param $nickname
     * @return bool
     */
    public function userNickNameExists($db, $nickname){
        $query = $db->table($this->user_table)->where($this->table_row['user_nickname'], '=', $nickname);
        return ($query->first() == null) ? false : true;
    }

    /**
     * @param $db
     * @param $mail
     * @return bool
     */
    public function userMailExists($db, $mail){
        $query = $db->table($this->user_table)->where($this->table_row['user_mail'], '=', $mail);
        return ($query->first() == null) ? false : true;
    }

    /**
     * @param $db
     * @param $key
     * @return bool
     */
    public function userKeyExists($db, $key){
        $query      = $db->table($this->user_table)->where($this->table_row['user_key'], '=', $key);
        $result     = $query->first();
        return ($result == null) ? false : $result->$this->table_row['user_id'];
    }

    /**
     * Generating random Unique MD5 String for user key
     */
    public function generateUserKey() {
        return md5(uniqid(rand(), true));
    }

    /**
     * @param $db
     * @param $userArray
     * @return int user_id
     */
    public function userCreate($db, $userArray){
        $data = array(
            $this->table_row['user_key']            => $userArray['user_key'],
            $this->table_row['user_nickname']       => $userArray['user_nickname'],
            $this->table_row['user_name']           => $userArray['user_name'],
            $this->table_row['user_surname']        => $userArray['user_surname'],
            $this->table_row['user_password']       => $userArray['user_password'],
            $this->table_row['user_mail']           => $userArray['user_mail']
        );

        // return new user_id
        return $db->table('my_table')->insert($data);
    }

    public function userPasswordEncrypt(){

    }

    /**
     * @return array
     */
    public function userDbToArray(){
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
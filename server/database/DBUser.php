<?php

/**
 * Created by PhpStorm.
 * DBUser: Paul
 * Date: 11/07/2017
 * Time: 17:04.
 */

namespace server\database;

class DBUser
{
    public $user_id;
    private $user_nickname;
    private $user_name;
    private $user_surname;
    private $user_password;
    private $user_mail;
    private $user_key;

    private $user_table = 'user';

    private $table_row = [
        'user_id'               => 'id',
        'user_nickname'         => 'nickname',
        'user_name'             => 'name',
        'user_surname'          => 'surname',
        'user_password'         => 'password',
        'user_mail'             => 'mail',
        'user_key'              => 'hashkey',
        'user_regitration_time' => 'regitration_time',
    ];

    /**
     * DBUser constructor.
     *
     * @param $user_id
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param DBConnection $db
     * @param null $user_data
     * @return array
     */
    public function getUserData(DBConnection $db, $user_data = null)
    {
        if ($user_data == null) {
            $query = $db->getQueryBuilderHandler()->table($this->user_table)->where($this->table_row['user_id'], $this->user_id);
            $user_data = $query->first();
        }

        if ($user_data != null) {
            $this->user_nickname = $user_data->{$this->table_row['user_nickname']};
            $this->user_name = $user_data->{$this->table_row['user_name']};
            $this->user_surname = $user_data->{$this->table_row['user_surname']};
            $this->user_password = $user_data->{$this->table_row['user_password']};
            $this->user_mail = $user_data->{$this->table_row['user_mail']};
            $this->user_key = $user_data->{$this->table_row['user_key']};

            return $this->userDbToArray();
        }
    }

    /**
     * @param $db
     * @param $nickname
     *
     * @return bool
     */
    public function userNickNameExists(DBConnection $db, $nickname)
    {
        $query = $db->getQueryBuilderHandler()->table($this->user_table)->where($this->table_row['user_nickname'], $nickname);

        return ($query->first() == null) ? false : true;
    }

    /**
     * @param $db
     * @param $mail
     *
     * @return bool
     */
    public function userMailExists(DBConnection $db, $mail)
    {
        $query = $db->getQueryBuilderHandler()->table($this->user_table)->where($this->table_row['user_mail'], $mail);

        return ($query->first() == null) ? false : true;
    }

    /**
     * @param $db
     * @param $key
     *
     * @return bool|integer
     */
    public function userKeyExists(DBConnection $db, $key)
    {
        $query = $db->getQueryBuilderHandler()->table($this->user_table)->where($this->table_row['user_key'], $key);
        $result = $query->first();

        return ($result == null) ? false : $result->{$this->table_row['user_id']};
    }

    /**
     * Generating random Unique MD5 String for user key.
     */
    public function generateUserKey()
    {
        return md5(uniqid(rand(), true));
    }

    /**
     * @param $db
     * @param $userArray
     *
     * @return int user_id
     */
    public function userCreate(DBConnection $db, $userArray)
    {
        $data = [
            $this->table_row['user_key']                => $this->generateUserKey(),
            $this->table_row['user_nickname']           => $db->securizeParam($userArray['user_nickname']),
            $this->table_row['user_name']               => '',
            $this->table_row['user_surname']            => '',
            $this->table_row['user_password']           => $db->securizeParam($this->userPasswordEncrypt($userArray['user_password'])),
            $this->table_row['user_mail']               => $userArray['user_mail'],
            $this->table_row['user_regitration_time']   => time(),
        ];

        // return new user_id
        return $db->getQueryBuilderHandler()->table($this->user_table)->insert($data);
    }

    /**
     * @param DBConnection $db
     * @param $nickname
     * @param $password
     *
     * @return array|bool
     */
    public function tryLogin(DBConnection $db, $nickname, $password)
    {
        $query = $db->getQueryBuilderHandler()->table($this->user_table)
            ->where($this->table_row['user_password'], $this->userPasswordEncrypt($db->securizeParam($password)))
            ->where($this->table_row['user_nickname'], $db->securizeParam($nickname));

        $data = $query->first();

        return ($data == null) ? false : $this->getUserData($db, $data);
    }

    /**
     * @param $password
     *
     * @return string
     */
    public function userPasswordEncrypt($password)
    {
        return md5($password);
    }

    /**
     * @return array
     */
    public function userDbToArray()
    {
        return [
            'nickname'         => $this->user_nickname,
            'name'             => $this->user_name,
            'surname'          => $this->user_surname,
            'mail'             => $this->user_mail,
            'key'              => $this->user_key,
        ];
    }
}

<?php
/*
 * Created by PhpStorm.
 * User: Paul
 * Date: 14/07/2017
 * Time: 16:51
 */

namespace server\tests\units\database;

require_once __DIR__.'/../../../database/DBconnection.php';

use mageekguy\atoum\test;

/*
 * Test class for UserDataBase
 */

/**
 * @property  test_user_data
 */
class DBUser extends test
{
    private $test_user_id;
    private $test_user_nickname = "test_nick";
    private $test_user_name;
    private $test_user_surname;
    private $test_user_password = "test_pwd";
    private $test_user_mail = "test_mail@us.fr";
    private $test_user_data;

    private $connection;

    public function test__construct()
    {
        $db = new DBConnection();
        $this->connection = $db->connect();

        // creation of a new instance of the tested class
        $this->given($this->newTestedInstance);
    }

    public function testUserCreate()
    {
        $this->test_user_id = $this
            ->newTestedInstance->userCreate($this->connection, [
                'user_nickname'     => $this->test_user_nickname,
                'user_mail'         => $this->test_user_mail,
                'user_password'     => $this->test_user_password,
            ])
            ->isGreaterThan(-1);
    }

    public function testGetUserData(){
        $this
            ->newTestedInstance->user_id = $this->test_user_id;

        $this->test_user_data = $this
            ->newTestedInstance->getUserData($this->connection)
            ->hasKey('user_id')
            ->hasKey('user_key')
            ->hasKey('user_surname')
            ->contains($this->test_user_nickname)
            ->contains($this->test_user_mail)
            ->contains($this->test_user_password);
    }

    public function testUserKeyExists()
    {
        $this
            ->newTestedInstance->userKeyExists($this->test_user_data['user_key'])
            ->isTrue();
        $this
            ->newTestedInstance->userKeyExists("zaeazeazeazddzeczvrevevevfdjn")
            ->isFalse();
    }

    public function testUserMailExists()
    {
        $this
            ->newTestedInstance->userNickNameExists($this->test_user_mail)
            ->isTrue();

        $this
            ->newTestedInstance->userNickNameExists("zadavert@ezrzer.com")
            ->isFalse();
    }

    public function testUserNickNameExists()
    {
        $this
            ->newTestedInstance->userNickNameExists($this->test_user_nickname)
            ->isTrue();

        $this
            ->newTestedInstance->userNickNameExists("zadaverthrtjeynse")
            ->isFalse();
    }

    public function getAutoloaderFile(){}
}
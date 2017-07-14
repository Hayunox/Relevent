<?php
/*
 * Created by PhpStorm.
 * User: Paul
 * Date: 14/07/2017
 * Time: 16:51
 */

namespace server\tests\units\database;

require_once __DIR__.'/../../../database/DBconnection.php';
require_once __DIR__.'/../../../database/DBuser.php';

use mageekguy\atoum\test;
use server\database\DBconnection as ConnectionToDatabase;

/*
 * Test class for BDuser
 */

class DBuser extends test
{
    private $test_user_nickname = 'test_nick';
    private $test_user_password = 'test_pwd';
    private $test_user_mail = 'test_mail@us.fr';

    private $test_user_id;
    private $test_user_data;
    private $test_connection;

    public function test__construct()
    {
    }

    public function testUserCreation()
    {
        $this->test_connection = (new ConnectionToDatabase())->connect();

        // creation of a new instance of the tested class
        $this
            ->given($this->newTestedInstance(null))
            ->given($test_user_id = $this->testedInstance->userCreate($this->test_connection, [
                'user_nickname'     => $this->test_user_nickname,
                'user_mail'         => $this->test_user_mail,
                'user_password'     => $this->test_user_password,
            ]))
            ->integer((int) $test_user_id)
                ->isGreaterThan(-1)
            ->given($this->testedInstance->user_id = $test_user_id)
            ->given($this->test_user_data = $this->testedInstance->getUserData($this->test_connection))
            ->array($this->test_user_data)
                ->hasKey('user_id')
                ->hasKey('user_key')
                ->hasKey('user_surname')
                ->contains($this->test_user_nickname)
                ->contains($this->test_user_mail)
                ->contains($this->testedInstance->userPasswordEncrypt($this->test_user_password))

            ->integer((int) $this->testedInstance->userKeyExists($this->test_connection, $this->test_user_data['user_key']))->isGreaterThan(-1)
            ->boolean($this->testedInstance->userKeyExists($this->test_connection, 'zaeazeazeazddzeczvrevevevfdjn'))->isFalse()
            ->boolean($this->testedInstance->userMailExists($this->test_connection, $this->test_user_mail))->isTrue()
            ->boolean($this->testedInstance->userMailExists($this->test_connection, 'zadavert@ezrzer.com'))->isFalse()
            ->boolean($this->testedInstance->userNickNameExists($this->test_connection, $this->test_user_nickname))->isTrue()
            ->boolean($this->testedInstance->userNickNameExists($this->test_connection, 'zadaverthrtjeynse'))->isFalse();
    }

    public function getAutoloaderFile()
    {
    }
}

<?php

namespace web\tests\Unit\Database;

require_once __DIR__.'/../UnitTestRestServerUtil.php';
require_once __DIR__.'/../../../database/DBConnection.php';
require_once __DIR__.'/../../../database/Userhp';

use server\database\DBConnection as ConnectionToDatabase;
use server\tests\units\UnitTestRestServerSlimTest;

/*
 * Test class for BDuser
 */

class DBUser extends UnitTestRestServerSlimTest
{
    private $test_user_nickname = 'test_nick';
    private $test_user_password = 'test_pwd';
    private $test_user_mail = 'test_mail@us.fr';

    private $test_user_id;
    private $test_user_data;
    private $test_connection;

    public function testUserCreationLogin()
    {
        $this->test_connection = new ConnectionToDatabase();

        // creation of a new instance of the tested class
        $this
            ->given($this->newTestedInstance(null))

            // User creation
            ->given($test_user_id = $this->testedInstance->userCreate($this->test_connection, [
                'user_nickname'     => $this->test_user_nickname,
                'user_mail'         => $this->test_user_mail,
                'user_password'     => $this->test_user_password,
            ]))
            ->integer((int) $test_user_id)
                ->isGreaterThan(-1)

            // User data
            ->integer((int) $this->testedInstance->getUserData($this->test_connection))
            ->isZero()
            ->given($this->testedInstance->user_id = $test_user_id)
            ->given($this->test_user_data = $this->testedInstance->getUserData($this->test_connection))
            ->array($this->test_user_data)
                ->hasKey('mail')
                ->hasKey('key')
                ->hasKey('surname')
                ->contains($this->test_user_nickname)
                ->contains($this->test_user_mail)

            // Exists functions
            ->integer((int) $this->testedInstance->userKeyExists($this->test_connection, $this->test_user_data['key']))->isGreaterThan(-1)
            ->boolean($this->testedInstance->userKeyExists($this->test_connection, 'zaeazeazeazddzeczvrevevevfdjn'))->isFalse()
            ->boolean($this->testedInstance->userMailExists($this->test_connection, $this->test_user_mail))->isTrue()
            ->boolean($this->testedInstance->userMailExists($this->test_connection, 'zadavert@ezrzer.com'))->isFalse()
            ->boolean($this->testedInstance->userNickNameExists($this->test_connection, $this->test_user_nickname))->isTrue()
            ->boolean($this->testedInstance->userNickNameExists($this->test_connection, 'zadaverthrtjeynse'))->isFalse()

            // Login function
            ->array($this->testedInstance->tryLogin($this->test_connection, $this->test_user_nickname, $this->test_user_password))
                ->hasKey('mail')
                ->contains($this->test_user_nickname)
            ->boolean($this->testedInstance->tryLogin($this->test_connection, $this->test_user_nickname, 'zaeazeazeazddzeczvrevevevfdjn'))->isFalse()
            ->boolean($this->testedInstance->tryLogin($this->test_connection, 'zadaverthrtjeynse', $this->test_user_password))->isFalse();
    }

    public function getAutoloaderFile()
    {
    }
}

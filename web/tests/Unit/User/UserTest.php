<?php

namespace Tests\Unit;

use App\Database\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    private $test_user_nickname = 'test_nick';
    private $test_user_password = 'test_pwd';
    private $test_user_mail = 'test_mail@us.fr';

    private $test_user_key;
    private $test_user_id;
    private $user;

    public function testUserCreationLogin()
    {
        $this->user = new User(null);

        // User creation
        $this->test_user_key = $this->user->userCreate([
            'nickname'     => $this->test_user_nickname,
            'mail'         => $this->test_user_mail,
            'password'     => $this->test_user_password,
        ]);

        $this->assertInternalType("string", $this->test_user_key);

        /**
         * User Key
         */
        $this->test_user_id = (int)$this->user->userKeyExists($this->test_user_key);
        $this->assertInternalType("int", $this->test_user_id);
        $this->assertGreaterThan(-1, $this->test_user_id);

        $userKeyExists = $this->user->userKeyExists('zaeazeazeazddzeczvrevevevfdjn');
        $this->assertInternalType("bool", $userKeyExists);
        $this->assertEquals(false, $userKeyExists);

        /**
         * Get User data
         */
        // fail
        $test_user_data = $this->user->getUserData();
        $this->assertEquals(null, $test_user_data);

        // success
        $this->user->user_id = $this->test_user_id;
        $test_user_data = $this->user->getUserData();
        $this->assertInternalType("array", $test_user_data);
        $this->assertArrayHasKey("mail", $test_user_data);
        $this->assertArrayHasKey("key", $test_user_data);
        $this->assertArrayHasKey("surname", $test_user_data);
        $this->assertContains($this->test_user_nickname, $test_user_data);
        $this->assertContains($this->test_user_mail, $test_user_data);

        /**
         * Exists functions
         */
        $userMailExists = $this->user->userMailExists($this->test_user_mail);
        $this->assertInternalType("bool", $userMailExists);
        $this->assertEquals(true, $userMailExists);

        $userMailExists = $this->user->userMailExists('zadavert@ezrzer.com');
        $this->assertInternalType("bool", $userMailExists);
        $this->assertEquals(false, $userMailExists);

        $userNickNameExists = $this->user->userNickNameExists($this->test_user_nickname);
        $this->assertInternalType("bool", $userNickNameExists);
        $this->assertEquals(true, $userNickNameExists);

        $userNickNameExists = $this->user->userNickNameExists('zadaverthrtjeynse');
        $this->assertInternalType("bool", $userNickNameExists);
        $this->assertEquals(false, $userNickNameExists);

        /**
         * Login functions
         */
        $tryLogin = $this->user->tryLogin($this->test_user_nickname, $this->test_user_password);
        $this->assertInternalType("array", $tryLogin);
        $this->assertArrayHasKey("mail", $tryLogin);
        $this->assertContains($this->test_user_nickname, $tryLogin);

        $tryLogin = $this->user->tryLogin($this->test_user_nickname, 'zaeazeazeazddzeczvrevevevfdjn');
        $this->assertInternalType("bool", $tryLogin);
        $this->assertEquals(false, $tryLogin);

        $tryLogin = $this->user->tryLogin('zadaverthrtjeynse', $this->test_user_password);
        $this->assertInternalType("bool", $tryLogin);
        $this->assertEquals(false, $tryLogin);
    }
}

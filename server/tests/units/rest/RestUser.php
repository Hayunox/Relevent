<?php
namespace server\tests\units\rest;

require_once __DIR__.'/../UnitTestRestServerUtil.php';
require_once __DIR__.'/../../../rest/RestUser.php';

use server\tests\units\UnitTestRestServerSlimTest;
use server\tests\units\UnitTestRestServerUtil;
use Slim\Http\Environment;
use Slim\Http\Response;
use Slim\Route;
use Slim\Router;

/**
 * Class RestUserRegister.
 */
class RestUserCreation extends UnitTestRestServerSlimTest
{
    public function testUserRegisterWithoutCredentials()
    {
        $app = $this->newTestedInstance();

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/register',
            'REQUEST_METHOD' => 'POST',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, "POST");
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app->__invoke($req, $res))
            ->integer($resOut->getStatusCode())
            ->isIdenticalTo(400)
            ->string((string) $resOut->getBody())
            ->contains('is missing or empty');
    }

    public function testUserRegisterWithValidCredentials()
    {
        $app = $this->newTestedInstance();

        // valid credentials
        $_REQUEST['nickname'] = json_encode('test');
        $_REQUEST['mail'] = json_encode('test@test.fr');
        $_REQUEST['password'] = json_encode('testpwd');

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/register',
            'REQUEST_METHOD' => 'POST',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, "POST");
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app->__invoke($req, $res))
            ->integer($resOut->getStatusCode())
            ->isIdenticalTo(200)
            ->string((string) $resOut->getBody())
            ->contains('USER_CREATED_SUCCESSFULLY');
    }

    public function testUserRegisterWithInvalidMail()
    {
        $app = $this->newTestedInstance();

        // invalid mail
        $_REQUEST['nickname'] = json_encode('zaeacrrztheqczzdz');
        $_REQUEST['mail'] = json_encode('test@test.fr');
        $_REQUEST['password'] = json_encode('zaecezfezddqs');

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/register',
            'REQUEST_METHOD' => 'POST',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, "POST");
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app->__invoke($req, $res))
            ->integer($resOut->getStatusCode())
            ->isIdenticalTo(400)
            ->string((string) $resOut->getBody())
            ->contains('USER_MAIL_EXISTS');
    }

    public function testUserRegisterWithInvalidNickname()
    {
        $app = $this->newTestedInstance();

        // invalid nickname
        $_REQUEST['nickname'] = json_encode('test');
        $_REQUEST['mail'] = json_encode('zaeceddqs@test.fr');
        $_REQUEST['password'] = json_encode('zaecezfezddqs');

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/register',
            'REQUEST_METHOD' => 'POST',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, "POST");
        $res = new Response();

        // Invoke app
        /*            ->integer($resOut->getStatusCode())
            ->isIdenticalTo(400)*/
        $this
            ->given($resOut = $app->__invoke($req, $res))
            ->string((string) $resOut->getBody())
            ->contains('USER_NICKNAME_EXISTS');
    }
}

/**
 * Class RestUserLogin.
 */
class RestUserLogin extends UnitTestRestServerSlimTest
{
    public function testUserLoginWithoutCredentials()
    {
        $app = $this->newTestedInstance();
        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/login',
            'REQUEST_METHOD' => 'POST',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, "POST");
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app->__invoke($req, $res))
            ->integer($resOut->getStatusCode())
            ->isIdenticalTo(400)
            ->string((string) $resOut->getBody())
            ->contains('is missing or empty');
    }

    public function testUserLoginWithInvalidCredentials()
    {
        $app = $this->newTestedInstance();

        // Incorrect credentials
        $_REQUEST['nickname'] = json_encode('eéeazdnuhuijnezczecn');
        $_REQUEST['password'] = json_encode('zaecezfezddqs');

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/login',
            'REQUEST_METHOD' => 'POST',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, "POST");
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app->__invoke($req, $res))
            ->integer($resOut->getStatusCode())
            ->isIdenticalTo(400)
            ->string((string) $resOut->getBody())
            ->contains('USER_LOGIN_FAILED');
    }

    public function testUserLoginWithValidCredentials()
    {
        $app = $this->newTestedInstance();

        // Valid credentials
        $_REQUEST['nickname'] = json_encode('test');
        $_REQUEST['password'] = json_encode('testpwd');

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/login',
            'REQUEST_METHOD' => 'POST',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, "POST");
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app->__invoke($req, $res))
            ->integer($resOut->getStatusCode())
            ->isIdenticalTo(200)
            ->string((string) $resOut->getBody())
            ->contains('nickname')
            ->contains('test');
    }
}

/**
 * Class RestEventUserListOwn.
 */
/*class RestUserGetDataById extends UnitTestRestServerSlimTest
{

    public function testUserGetDataByIdValidParams()
    {
        $app = $this->newTestedInstance();

        // Prepare request and response objects
        $env = Environment::mock([
            'REQUEST_URI'    => '/projetX/index.php/user/getDataById/1',
            'REQUEST_METHOD' => 'GET',
        ]);

        $req = UnitTestRestServerUtil::createTestEnvironment($env, "GET", 1);
        $res = new Response();

        // Invoke app
        $this
            ->given($resOut = $app->__invoke($req, $res))
            ->integer($resOut->getStatusCode())
            ->isIdenticalTo(200)
            ->string((string) $resOut->getBody())
            ->contains('nickname')
            ->contains('test');
    }
}*/

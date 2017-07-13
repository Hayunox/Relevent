<?php
/*
 * Created by PhpStorm.
 * User: Paul
 * Date: 12/07/2017
 * Time: 18:14
 */

namespace server\tests\units\database;

require_once __DIR__.'/../../../database/DBconnection.php';

use mageekguy\atoum\test;

/*
 * Test class for DatabaseConnection
 */
class DBconnection extends test
{
    public function testConnection()
    {
        $this
            // creation of a new instance of the tested class
            ->given($this->newTestedInstance)
            ->newTestedInstance->connect();
    }

    public function getAutoloaderFile(){}
}

<?php
/*
 * Created by PhpStorm.
 * User: Paul
 * Date: 12/07/2017
 * Time: 18:14
 */

namespace server\tests\units\database;

require_once __DIR__ . '/../../../database/DBConnection.php';

use mageekguy\atoum\test;

/*
 * Test class for DatabaseConnection
 */
class DBConnection extends test
{
    public function testConnection()
    {
        $this
            // creation of a new instance of the tested class
            ->given($this->newTestedInstance)
            ->object($this->newTestedInstance->getQueryBuilderHandler())
            ->hasSize(1)
            ->String($this->newTestedInstance->securizeParam('azeazdaccz'))
            ->isNotEmpty();
    }

    public function getAutoloaderFile()
    {
    }
}

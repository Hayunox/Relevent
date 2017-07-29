<?php

namespace server\tests\units\database;

require_once __DIR__.'/../UnitTestRestServerUtil.php';
require_once __DIR__.'/../../../database/DBConnection.php';

use server\tests\units\UnitTestRestServerSlimTest;

/*
 * Test class for DatabaseConnection
 */
class DBConnection extends UnitTestRestServerSlimTest
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

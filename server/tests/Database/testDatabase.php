<?php
/*
 * Created by PhpStorm.
 * User: Paul
 * Date: 12/07/2017
 * Time: 18:14
 */

require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/../atoum.phar';
require_once __DIR__.'/../../DBConnection.php';

/*
 * Test class for DatabaseConnection
 */
class testDatabase extends atoum\test
{
    public function testConnection()
    {
        $this
            // creation of a new instance of the tested class
            ->given($db = new DBConnection())
            ->if($db->connect());
    }
}

<?php
/*
 * Created by PhpStorm.
 * User: Paul
 * Date: 12/07/2017
 * Time: 18:14
 */

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

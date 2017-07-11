<?php
/**
 * Created by PhpStorm.
 * UserDb: Paul
 * Date: 11/07/2017
 * Time: 17:10
 */
require 'vendor/autoload.php';

use Pixie\Connection;

class DBConnection {

    private $connection;

    private $config = array(
        'driver'    => 'mysql', // Db driver
        'host'      => 'localhost',
        'database'  => 'projetx',
        'username'  => 'root',
        'password'  => '',
        'charset'   => 'utf8', // Optional
        'collation' => 'utf8_unicode_ci', // Op"tional
        'prefix'    => '', // Table prefix, optional
        'options'   => array( // PDO constructor options, optional
            PDO::ATTR_TIMEOUT => 5,
            PDO::ATTR_EMULATE_PREPARES => false,
        ),
    );

    function __construct() {}

    /**
     * Establishing database connection
     * @return database connection handler
     */
    function connect() {
        include_once dirname(__FILE__) . './Config.php';

        $this->connection = new Connection('mysql', $this->config, 'PX');

        return new \Pixie\QueryBuilder\QueryBuilderHandler($this->connection);
    }

}

?>
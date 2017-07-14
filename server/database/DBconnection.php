<?php
/**
 * Created by PhpStorm.
 * DBuser: Paul
 * Date: 11/07/2017
 * Time: 17:10.
 */

namespace server\database;

require_once __DIR__.'/../vendor/autoload.php';

use PDO;
use Pixie\Connection;
use Pixie\QueryBuilder\QueryBuilderHandler;

class DBconnection
{
    private $connection;

    private $config = [
        'driver'    => 'mysql', // Db driver
        'host'      => 'localhost',
        'database'  => 'projetx',
        'username'  => 'root',
        'password'  => '',
        'charset'   => 'utf8', // Optional
        'collation' => 'utf8_unicode_ci', // Op"tional
        'prefix'    => '', // Table prefix, optional
        'options'   => [ // PDO constructor options, optional
            PDO::ATTR_TIMEOUT          => 5,
            PDO::ATTR_EMULATE_PREPARES => false,
        ],
    ];

    public function __construct()
    {
    }

    /**
     * Establishing database connection.
     *
     * @return QueryBuilderHandler
     */
    public function connect()
    {
        $this->connection = new Connection('mysql', $this->config, 'PX');

        return new QueryBuilderHandler($this->connection);
    }
}

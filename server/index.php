<?php
/**
 * Created by PhpStorm.
 * DBuser: Paul
 * Date: 11/07/2017
 * Time: 17:22.
 */

namespace server;

use server\rest\XRestServer;

require_once __DIR__ . '/rest/XRestServer.php';

// Start Server
new XRestServer();

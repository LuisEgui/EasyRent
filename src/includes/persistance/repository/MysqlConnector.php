<?php

namespace easyrent\includes\persistance\repository;

use Closure;
use mysqli;

# Database parameters
# Change 'localhost' to 'vm03.db.swarm.test' when uploading this projecto to the VPS
define('BD_HOST', 'localhost');
define('BD_NAME', 'easyrent_db');
define('BD_USER', 'user');
define('BD_PASS', '1234');
define('BD_PORT', '3305');

class MysqlConnector implements DatabaseConnection {

    private static $instance;
    private $mysqli;

    private function __construct()
    {
        $this->mysqli = null;
    }

    public static function getInstance()
    {
        if (self::$instance === null)
            self::$instance = new self;
        return self::$instance;
    }

    public function getConnection()
    {
        if ($this->mysqli == null) {
            $mysqli = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME, BD_PORT);

            if ($mysqli->connect_errno)
                error_log("Error when connecting to the database: ({$mysqli->errno}) {$mysqli->error}");

            if (!$mysqli->set_charset("utf8mb4"))
                error_log("Error when connecting to the database: ({$mysqli->errno}) {$mysqli->error}");

            $this->mysqli = $mysqli;

            // It'll call closeConnection() before finishing the script execution:
            register_shutdown_function(Closure::fromCallable([$this, 'closeConnection']));
        }

        return $this->mysqli;
    }

    public function closeConnection() {
        if ($this->mysqli != null && !$this->mysqli->connect_errno)
            $this->mysqli->close();
    }

    public function query($sql) {
        return $this->getConnection()->query($sql);
    }

    public function prepare($sql) {
        return self::getInstance()->getConnection()->prepare($sql);
    }

    public function beginTransaction() : bool
    {
        return $this->getConnection()->begin_transaction();
    }

    public function commit() : bool
    {
        return $this->getConnection()->commit();
    }

    public function rollback() : bool
    {
        return $this->getConnection()->rollback();
    }
}

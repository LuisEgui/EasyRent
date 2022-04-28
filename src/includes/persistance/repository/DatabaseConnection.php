<?php

namespace easyrent\includes\persistance\repository;

use mysqli_result;
use mysqli_stmt;

/**
 * Database connection interface.
 *
 * Defines some basic database actions.
 */
interface DatabaseConnection {

    /**
     * Gets the database connection or creates it instead.
     * @return mixed Connection
     */
    public function getConnection();

    /**
     * Closes the database connection.
     * @return void
     */
    public function closeConnection();

    /**
     * Executes a database query.
     * @param string $sql Data inside the query should be properly escaped.
     * @return mysqli_result|bool For successful SELECT, SHOW, DESCRIBE or EXPLAIN
     * queries mysqli_query will return a mysqli_result object.
     * For other successful queries mysqli_query will return true and false on failure.
     */
    public function query($sql);

    /**
     * Prepares a database query.
     * @param string $sql The query, as a string.
     * @link https://php.net/manual/en/mysqli.prepare.php
     * @return mysqli_stmt|false mysqli_prepare returns a statement object or
     * false if an error occurred.
     */
    public function prepare($sql);

    /**
     * Begins a transaction.
     * @link https://www.php.net/manual/en/mysqli.begin-transaction.php
     * @return true|false on success or failure.
     */
    public function beginTransaction(): bool;

    /**
     * Commits the current transaction for the database connection.
     * @link https://www.php.net/manual/en/mysqli.commit
     * @return true|false on success or failure.
     */
    public function commit(): bool;

    /**
     * Rollbacks the current transaction for the database.
     * @link https://www.php.net/manual/en/mysqli.rollback
     * @return true|false on success or failure.
     */
    public function rollback(): bool;

}

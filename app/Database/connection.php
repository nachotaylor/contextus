<?php

namespace App\Database;

use mysqli;

require_once 'config.php';

class DBConnection
{
    private static $instance;
    private $mysqli;

    /**
     * Singleton pattern to database connection
     * @return mixed
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    protected function __construct()
    {
        $this->mysqli = new mysqli(DB_CONFIG['hostname'], DB_CONFIG['username'], DB_CONFIG['password'], DB_CONFIG['db_name']);
        $this->mysqli->set_charset(DB_CONFIG['charset']);
    }

    /**
     * Execute the query
     * @param $sql
     * @return bool|\mysqli_result
     */
    public function query($sql)
    {
        return $this->mysqli->query($sql);
    }

    /**
     * Escape special chars, to prevent sql injections
     * @param $data
     * @return string
     */
    public function escape($data)
    {
        return $this->mysqli->real_escape_string($data);
    }
}

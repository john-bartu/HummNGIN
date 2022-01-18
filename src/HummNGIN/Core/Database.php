<?php

namespace HummNGIN\Core;

use Exception;
use PDO;
use PDOException;
use PDOStatement;


// TODO: Create database factory

class Database
{
    private $username;
    private $password;
    private $host;
    private $database;
    private PDOStatement $stmt;

    private PDO $connection;

    public function __construct()
    {
        set_time_limit(10);
        $this->username = $_ENV['USERNAME'];
        $this->password = $_ENV['PASSWORD'];
        $this->host = $_ENV['HOST'];
        $this->database = $_ENV['DATABASE'];
    }

    public function connect(): PDO
    {
        try {
            $this->connection = new PDO(
                "mysql:host=$this->host;port=3306;dbname=$this->database;charset=utf8;",
                $this->username,
                $this->password,
                ["sslmode" => "prefer"]
            );

            // turn on errors
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection;
        } catch (PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage(), 500);
        }
    }

    public function prepare(string $query, array $options)
    {
        $this->stmt = $this->connection->prepare($query, $options);
    }

    public function bindParam($value_name, $value)
    {
        $this->stmt->bindParam($value_name, $value, PDO::PARAM_STR);
    }

    public function bindParams(array $key_value)
    {
        foreach ($key_value as $key)
            if(isset($key_value[$key]))
                $this->stmt->bindParam($key, $key_value[$key], PDO::PARAM_STR);
    }

    public function execute($params = null)
    {
        $this->stmt->execute($params);
    }

    public function fetch()
    {
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }


}
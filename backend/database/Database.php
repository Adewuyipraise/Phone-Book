<?php

class Database {
    private $host;
    private $user;
    private $password;
    private $database;

    public function __construct() {
        require_once(__DIR__ . '/../config/config.php');

        $this->host = $config['host'];
        $this->user = $config['user'];
        $this->password = $config['password'];
        $this->database = $config['database'];
    }

    public function getConnection() {
        try {
            $credentials = "mysql:host=$this->host;dbname=$this->database";

            $connection = new PDO($credentials, $this->user, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $connection;
        } catch(PDOException $e) {
            throw new Exception("Failed to connect to MySQL: " . $e->getMessage());
        }
    }

    public function __destruct() {
        $connection = null;
    }
}
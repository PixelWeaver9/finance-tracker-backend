<?php
// config/database.php

require_once __DIR__ . '/env.php';
loadEnv(__DIR__ . '/../.env'); // load .env lokal

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

class Database {

    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;

    public $conn;

    public function __construct() {

        // --- MODE PRODUCTION: Railway memberikan ENV ---
        if (getenv('MYSQLHOST')) {

            $this->host     = getenv('MYSQLHOST');
            $this->port     = getenv('MYSQLPORT');
            $this->username = getenv('MYSQLUSER');
            $this->password = getenv('MYSQLPASSWORD');
            $this->db_name  = getenv('MYSQLDATABASE');

        } else {

            // --- MODE DEVELOPMENT: pakai .env ---
            $this->host     = getenv('DB_HOST');
            $this->port     = getenv('DB_PORT');
            $this->username = getenv('DB_USER');
            $this->password = getenv('DB_PASS');
            $this->db_name  = getenv('DB_NAME');
        }
    }

    public function getConnection() {
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8mb4";

            $this->conn = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            return $this->conn;

        } catch(PDOException $e) {

            echo json_encode([
                "success" => false,
                "error" => $e->getMessage(),
                "host" => $this->host,
                "port" => $this->port,
                "user" => $this->username
            ]);
            exit;
        }
    }
}

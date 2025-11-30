<?php
// config/database.php
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
    public $conn;

    public function __construct() {
        // Check if running on Railway (production)
        if (getenv('MYSQL_HOST')) {
            // Production - Railway environment variables
            $this->host = getenv('MYSQL_HOST');
            $this->db_name = getenv('MYSQL_DATABASE');
            $this->username = getenv('MYSQL_USER');
            $this->password = getenv('MYSQL_PASSWORD');
        } else {
            // Development - localhost
            $this->host = "localhost";
            $this->db_name = "finance_tracker";
            $this->username = "root";
            $this->password = "";
        }
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8mb4");
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Connection Error: " . $e->getMessage()
            ]);
            exit();
        }

        return $this->conn;
    }
}
?>

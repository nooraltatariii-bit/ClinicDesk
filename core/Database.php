<?php

class Database
{
    private static $instance = null;

    private $conn;

    private function __construct()
    {
        require_once __DIR__ . "/../config/database.php";

        $this->conn = new mysqli(
            DB_HOST,
            DB_USER,
            DB_PASS,
            DB_NAME
        );

        if ($this->conn->connect_error) {
            throw new RuntimeException(
                "Database connection failed."
            );
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function query(
        string $sql,
        string $types = "",
        array $params = []
    ) {

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $success = $stmt->execute();

        if (!$success) {
            return false;
        }

        $result = $stmt->get_result();

        return $result ?: true;
    }

    public function lastInsertId()
    {
        return $this->conn->insert_id;
    }
}
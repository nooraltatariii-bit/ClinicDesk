<?php

require_once __DIR__
. "/../core/Database.php";

class LogModel
{
    private $db;

    public function __construct()
    {
        $this->db =
        Database::getInstance()
        ->getConnection();
    }

    public function create(
        $userId,
        $action
    ) {

        $stmt =
        $this->db->prepare(

            "INSERT INTO logs
            (
                user_id,
                action
            )
            VALUES (?, ?)"
        );

        return $stmt->execute([

            $userId,

            $action
        ]);
    }

    public function getAll()
    {
        $sql = "

        SELECT

        logs.*,

        users.name

        FROM logs 

        JOIN users
        ON logs.user_id = users.id

        ORDER BY logs.id DESC
        ";

        return $this->db
        ->query($sql)
        ->fetch_all(MYSQLI_ASSOC);
    }
}
<?php

require_once __DIR__ . "/BaseModel.php";

class UserModel extends BaseModel
{

    public function findByEmail(
        string $email
    ) {

        $sql = "
            SELECT *
            FROM users
            WHERE email = ?
            LIMIT 1
        ";

        $result = $this->execute(
            $sql,
            "s",
            [$email]
        );

        return $result->fetch_assoc()
        ?? null;
    }

    public function create(array $data)
    {
        $sql = "
            INSERT INTO users
            (
                name,
                email,
                password,
                role,
                phone
            )
            VALUES
            (?, ?, ?, ?, ?)
        ";

        $this->execute(
            $sql,
            "sssss",
            [
                $data["name"],
                $data["email"],
                $data["password"],
                $data["role"],
                $data["phone"]
            ]
        );

        return $this->db
        ->lastInsertId();
    }


    public function updatePassword(
        int $id,
        string $newHash
    ) {

        $sql = "
            UPDATE users
            SET password = ?
            WHERE id = ?
        ";

        return $this->execute(
            $sql,
            "si",
            [
                $newHash,
                $id
            ]
        );
    }

    public function toggleActive(
        int $id
    ) {

        $sql = "
            UPDATE users
            SET is_active =
            IF(is_active = 1, 0, 1)
            WHERE id = ?
        ";

        return $this->execute(
            $sql,
            "i",
            [$id]
        );
    }

    public function countAll(
        string $role = "",
        string $search = ""
    ) {

        $sql = "
            SELECT COUNT(*) AS total
            FROM users
            WHERE 1
        ";

        $types = "";

        $params = [];

        if (!empty($role)) {

            $sql .= " AND role = ?";

            $types .= "s";

            $params[] = $role;
        }

        if (!empty($search)) {

            $sql .= "
                AND (
                    name LIKE ?
                    OR email LIKE ?
                )
            ";

            $types .= "ss";

            $searchTerm =
            "%$search%";

            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        $result = $this->execute(
            $sql,
            $types,
            $params
        );

        return $result
        ->fetch_assoc()["total"];
    }

    public function getAll(
        $page = 1,
        $search = ""
    ) {
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $like = "%$search%";

        $sql = "
            SELECT *
            FROM users
            WHERE name LIKE ? OR email LIKE ?
            ORDER BY id DESC
            LIMIT ? OFFSET ?
        ";

        $result = $this->execute($sql, "ssii", [$like, $like,$limit,$offset]);
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countUsers()
    {
        $sql = "
        SELECT COUNT(*) as total
        FROM users
        ";

        return $this->db
        ->query($sql)
        ->fetch_assoc()["total"];
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
        
        $result = $this->execute($sql, "i", [$id]);

        return $result ? $result->fetch_assoc() : null;
    }


    // تصحيح دالة update البرمجية
    public function update($id, $data) 
    {
        $sql = "
            UPDATE users
            SET name = ?, email = ?, role = ?, phone = ?
            WHERE id = ?
        ";

        return $this->execute(
            $sql, 
            "ssssi", 
            [$data["name"], $data["email"], $data["role"], $data["phone"], $id]
        );
    }
}
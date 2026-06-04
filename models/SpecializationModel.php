<?php

require_once __DIR__
. "/BaseModel.php";

class SpecializationModel
extends BaseModel
{
    public function getAll()
    {
        $sql = "
            SELECT *
            FROM specializations
            ORDER BY name ASC
        ";

        $result =
        $this->execute($sql);

        return $result
        ->fetch_all(MYSQLI_ASSOC);
    }

    public function create(
        string $name
    ) {

        $sql = "
            INSERT INTO specializations
            (name)
            VALUES (?)
        ";

        return $this->execute(
            $sql,
            "s",
            [$name]
        );
    }

    public function delete(
        int $id
    ) {

        $sql = "
            DELETE FROM specializations
            WHERE id = ?
        ";

        return $this->execute(
            $sql,
            "i",
            [$id]
        );
    }

    public function isSafeToDelete(
        int $id
    ) {

        $sql = "
            SELECT COUNT(*) AS total
            FROM doctors
            WHERE specialization_id = ?
        ";

        $result =
        $this->execute(
            $sql,
            "i",
            [$id]
        );

        $row =
        $result->fetch_assoc();

        return $row["total"] == 0;
    }
}
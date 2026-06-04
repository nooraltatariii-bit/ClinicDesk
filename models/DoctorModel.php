<?php

require_once __DIR__ . "/BaseModel.php";

class DoctorModel extends BaseModel
{
    public function getAll()
    {
        $sql = "
            SELECT
                doctors.*,
                users.name,
                users.email,
                specializations.name AS specialization_name
            FROM doctors
            JOIN users ON doctors.user_id = users.id
            JOIN specializations ON doctors.specialization_id = specializations.id
            ORDER BY users.name ASC
        ";

        $result = $this->execute($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create(array $data) 
    {
        // تم إضافة حقل photo وعلامة الاستفهام الخاصة به
        $sql = "
            INSERT INTO doctors
            (
                user_id,
                specialization_id,
                bio,
                consultation_fee,
                available_days,
                photo
            )
            VALUES
            (?, ?, ?, ?, ?, ?)
        ";

        // تم تمرير أنواع البيانات "iissss" وإضافة متغير الصورة في المصفوفة
        return $this->execute(
            $sql,
            "iissss",
            [
                $data["user_id"],
                $data["specialization_id"],
                $data["bio"],
                $data["consultation_fee"],
                $data["available_days"],
                $data["photo"]
            ]
        );
    }

    public function findByUserId(int $userId) 
    {
        $sql = "
            SELECT
                doctors.*,
                users.name,
                users.email,
                users.phone,
                specializations.name AS specialization_name
            FROM doctors
            JOIN users ON doctors.user_id = users.id
            JOIN specializations ON doctors.specialization_id = specializations.id
            WHERE doctors.user_id = ?
            LIMIT 1
        ";

        $result = $this->execute($sql, "i", [$userId]);
        return $result->fetch_assoc() ?? null;
    }

    public function getAvailableDays(int $doctorId) 
    {
        $sql = "
            SELECT available_days
            FROM doctors
            WHERE id = ?
        ";

        $result = $this->execute($sql, "i", [$doctorId]);
        $doctor = $result->fetch_assoc();

        return explode(",", $doctor["available_days"]);
    }
}
<?php

require_once __DIR__ . "/BaseModel.php";

class AppointmentModel extends BaseModel
{
    public function hasConflict(
        int $doctorId,
        string $date,
        string $time
    ) {
        $sql = "
            SELECT id
            FROM appointments
            WHERE doctor_id = ?
            AND appt_date = ?
            AND appt_time = ?
            LIMIT 1
        ";

        $result = $this->execute(
            $sql,
            "iss",
            [
                $doctorId,
                $date,
                $time
            ]
        );

        return $result->num_rows > 0;
    }

    public function book(
        array $data
    ) {
        $sql = "
            INSERT INTO appointments
            (
                patient_id,
                doctor_id,
                appt_date,
                appt_time,
                reason
            )
            VALUES
            (?, ?, ?, ?, ?)
        ";

        return $this->execute(
            $sql,
            "iisss",
            [
                $data["patient_id"],
                $data["doctor_id"],
                $data["appt_date"],
                $data["appt_time"],
                $data["reason"]
            ]
        );
    }

    public function getByPatient(
        int $patientId,
        int $page,
        array $filters = []
    ) {
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $sql = "
            SELECT
                appointments.*,
                users.name AS doctor_name,
                specializations.name AS specialization_name
            FROM appointments
            JOIN doctors ON appointments.doctor_id = doctors.id
            JOIN users ON doctors.user_id = users.id
            JOIN specializations ON doctors.specialization_id = specializations.id
            WHERE appointments.patient_id = ?
        ";

        $types = "i";
        $params = [$patientId];

        if (!empty($filters["status"])) {
            $sql .= " AND appointments.status = ? ";
            $types .= "s";
            $params[] = $filters["status"];
        }

        if (!empty($filters["start_date"])) {
            $sql .= " AND appointments.appt_date >= ? ";
            $types .= "s";
            $params[] = $filters["start_date"];
        }

        if (!empty($filters["end_date"])) {
            $sql .= " AND appointments.appt_date <= ? ";
            $types .= "s";
            $params[] = $filters["end_date"];
        }

        $sql .= "
            ORDER BY
            appointments.appt_date DESC,
            appointments.appt_time DESC
            LIMIT ?
            OFFSET ?
        ";

        $types .= "ii";
        $params[] = $limit;
        $params[] = $offset;

        $result = $this->execute(
            $sql,
            $types,
            $params
        );

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateStatus(
        int $id,
        string $status,
        string $notes = ""
    ) {
        $sql = "
            UPDATE appointments
            SET
                status = ?,
                doctor_notes = ?
            WHERE id = ?
        ";

        return $this->execute(
            $sql,
            "ssi",
            [
                $status,
                $notes,
                $id
            ]
        );
    }

    public function findById(
        int $id
    ) {
        $sql = "
            SELECT
                appointments.*,
                patient.name AS patient_name,
                doctor_user.name AS doctor_name
            FROM appointments
            JOIN users patient ON appointments.patient_id = patient.id
            JOIN doctors ON appointments.doctor_id = doctors.id
            JOIN users doctor_user ON doctors.user_id = doctor_user.id
            WHERE appointments.id = ?
            LIMIT 1
        ";

        $result = $this->execute(
            $sql,
            "i",
            [$id]
        );

        return $result->fetch_assoc() ?? null;
    }

    public function getAll(
        $page = 1,
        $filters = []
    ) {
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $sql = "
            SELECT
                appointments.*,
                patients.name AS patient_name,
                doctors_user.name AS doctor_name
            FROM appointments
            JOIN users patients ON appointments.patient_id = patients.id
            JOIN doctors ON appointments.doctor_id = doctors.id
            JOIN users doctors_user ON doctors.user_id = doctors_user.id
            ORDER BY appointments.id DESC
            LIMIT ? OFFSET ?
        ";

        $result = $this->execute($sql, "ii", [$limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByDoctor(
        $doctorUserId,
        $page = 1,
        $filters = []
    ) {
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $sql = "
            SELECT
                appointments.*,
                patients.name AS patient_name,
                doctors_user.name AS doctor_name
            FROM appointments
            JOIN users patients ON appointments.patient_id = patients.id
            JOIN doctors ON appointments.doctor_id = doctors.id
            JOIN users doctors_user ON doctors.user_id = doctors_user.id
            WHERE doctors.user_id = ?
            ORDER BY appointments.id DESC
            LIMIT ? OFFSET ?
        ";

        $result = $this->execute($sql, "iii", [$doctorUserId, $limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
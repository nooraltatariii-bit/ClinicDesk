<?php

require_once __DIR__
. "/BaseModel.php";

class PrescriptionModel
extends BaseModel
{
    public function create(
        array $data
    ) {

        $sql = "
            INSERT INTO prescriptions
            (
                appointment_id,
                diagnosis,
                medications,
                notes,
                file_path
            )
            VALUES
            (?, ?, ?, ?, ?)
        ";

        return $this->execute(
            $sql,
            "issss",
            [
                $data["appointment_id"],
                $data["diagnosis"],
                $data["medications"],
                $data["notes"],
                $data["file_path"]
            ]
        );
    }

    public function findByAppointment(
        int $appointmentId
    ) {

        $sql = "
            SELECT *
            FROM prescriptions
            WHERE appointment_id = ?
            LIMIT 1
        ";

        $result =
        $this->execute(
            $sql,
            "i",
            [$appointmentId]
        );

        return $result
        ->fetch_assoc()
        ?? null;
    }

    public function getPatientPrescriptions(
        int $patientId
    ) {

        $sql = "
            SELECT
                prescriptions.*,

                appointments.appt_date,

                doctor_user.name
                AS doctor_name

            FROM prescriptions

            JOIN appointments
            ON prescriptions.appointment_id
            = appointments.id

            JOIN doctors
            ON appointments.doctor_id
            = doctors.id

            JOIN users doctor_user
            ON doctors.user_id
            = doctor_user.id

            WHERE appointments.patient_id = ?

            ORDER BY
            prescriptions.created_at DESC
        ";

        $result =
        $this->execute(
            $sql,
            "i",
            [$patientId]
        );

        return $result
        ->fetch_all(MYSQLI_ASSOC);
    }

    public function userCanAccess(
        int $prescriptionId,
        int $userId,
        string $role
    ) {

        $sql = "
            SELECT prescriptions.id

            FROM prescriptions

            JOIN appointments
            ON prescriptions.appointment_id
            = appointments.id

            JOIN doctors
            ON appointments.doctor_id
            = doctors.id

            WHERE prescriptions.id = ?
        ";

        $types = "i";

        $params = [$prescriptionId];

        if ($role === "patient") {

            $sql .= "
                AND appointments.patient_id = ?
            ";

            $types .= "i";

            $params[] = $userId;

        } elseif ($role === "doctor") {

            $sql .= "
                AND doctors.user_id = ?
            ";

            $types .= "i";

            $params[] = $userId;
        }

        $sql .= " LIMIT 1";

        $result =
        $this->execute(
            $sql,
            $types,
            $params
        );

        return $result->num_rows > 0;
    }

    public function findById(
        int $id
    ) {

        $sql = "
            SELECT *
            FROM prescriptions
            WHERE id = ?
            LIMIT 1
        ";

        $result =
        $this->execute(
            $sql,
            "i",
            [$id]
        );

        return $result
        ->fetch_assoc()
        ?? null;
    }
    public function getAll()
{
    $sql = "

    SELECT

    prescriptions.*,

    users.name AS patient_name

    FROM prescriptions

    JOIN appointments
    ON prescriptions.appointment_id = appointments.id

    JOIN users
    ON appointments.patient_id = users.id

    ORDER BY prescriptions.id DESC
    ";

    $result = $this->execute($sql, "", []);
    return $result->fetch_all(MYSQLI_ASSOC);
}
}
<?php

require_once __DIR__
. "/../core/Database.php";

class ReportModel
{
    private $db;

    public function __construct()
    {
        $this->db =
        Database::getInstance()
        ->getConnection();
    }

public function getStats()
    {
        return [
            "users" => $this->db
                ->query("SELECT COUNT(*) FROM users")
                ->fetch_row()[0],

            "doctors" => $this->db
                ->query("SELECT COUNT(*) FROM doctors")
                ->fetch_row()[0],

            "appointments" => $this->db
                ->query("SELECT COUNT(*) FROM appointments")
                ->fetch_row()[0],

            "prescriptions" => $this->db
                ->query("SELECT COUNT(*) FROM prescriptions")
                ->fetch_row()[0]
        ];
    }


    public function exportAppointments()
    {
        $sql = "

        SELECT

        appointments.id,

        patients.name
        AS patient_name,

        doctors_user.name
        AS doctor_name,

        appointments.appt_date,

        appointments.appt_time,

        appointments.status

        FROM appointments

        JOIN users patients
        ON appointments.patient_id = patients.id

        JOIN doctors
        ON appointments.doctor_id = doctors.id

        JOIN users doctors_user
        ON doctors.user_id = doctors_user.id

        ORDER BY appointments.id DESC
        ";

        return $this->db
        ->query($sql)
        ->fetch_all(MYSQLI_ASSOC);
    }
}
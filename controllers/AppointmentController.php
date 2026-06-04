<?php

require_once __DIR__ . "/../models/LogModel.php";
require_once __DIR__ . "/../core/Auth.php";
require_once __DIR__ . "/../core/CSRF.php";
require_once __DIR__ . "/../models/AppointmentModel.php";
require_once __DIR__ . "/../models/DoctorModel.php";

class AppointmentController
{
    private $appointmentModel;
    private $doctorModel;

    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->doctorModel = new DoctorModel();
    }

    public function index()
    {
        Auth::requireAnyRole([
            "patient",
            "doctor",
            "admin"
        ]);

        $page = (int) ($_GET["p"] ?? 1);

        $filters = [
            "status" => $_GET["status"] ?? "",
            "start_date" => $_GET["start_date"] ?? "",
            "end_date" => $_GET["end_date"] ?? ""
        ];

        $role = Auth::role();

        if ($role === "patient") {
            $appointments = $this->appointmentModel->getByPatient(
                Auth::currentUser()["id"],
                $page,
                $filters
            );

            require_once __DIR__ . '/../views/appointments/patient.php';
        } elseif ($role === "doctor") {
            $appointments = $this->appointmentModel->getByDoctor(
                Auth::currentUser()["id"],
                $page,
                $filters
            );

            require_once __DIR__ . '/../views/appointments/admin.php';
        } elseif ($role === "admin") {
            $appointments = $this->appointmentModel->getAll(
                $page,
                $filters
            );

            require_once __DIR__ . '/../views/appointments/admin.php';
        }
    }

    public function create()
    {
        Auth::requireRole("patient");

        $doctors = $this->doctorModel->getAll();

        require_once __DIR__ . "/../views/appointments/create.php";
    }

    public function store()
    {
        Auth::requireRole("patient");

        if (
            !CSRF::validateToken(
                $_POST["csrf_token"] ?? ""
            )
        ) {
            flash(
                "danger",
                "Invalid CSRF token"
            );

            redirect(
                "index.php?page=appointments"
            );
        }

        $doctorId = (int) $_POST["doctor_id"];
        $date = $_POST["appt_date"];
        $time = $_POST["appt_time"];

        if (
            strtotime($date) < strtotime(date("Y-m-d"))
        ) {
            flash(
                "danger",
                "Date cannot be in past"
            );

            redirect(
                "index.php?page=appointments&action=create"
            );
        }

        if (
            $this->appointmentModel->hasConflict(
                $doctorId,
                $date,
                $time
            )
        ) {
            flash(
                "danger",
                "Time slot already booked"
            );

            redirect(
                "index.php?page=appointments&action=create"
            );
        }

        $data = [
            "patient_id" => Auth::currentUser()["id"],
            "doctor_id" => $doctorId,
            "appt_date" => $date,
            "appt_time" => $time,
            "reason" => trim($_POST["reason"])
        ];

        $this->appointmentModel->book($data);

        $log = new LogModel();
        $log->create(
            Auth::currentUser()["id"],
            "Booked appointment"
        );

        flash(
            "success",
            "Appointment booked"
        );

        redirect(
            "index.php?page=appointments"
        );
    }

    public function updateStatus()
    {
        Auth::requireAnyRole([
            "doctor",
            "admin"
        ]);

        // if (
        //     !CSRF::validateToken(
        //         $_POST["csrf_token"] ?? ""
        //     )
        // ) {
        //     flash(
        //         "danger",
        //         "Invalid CSRF token"
        //     );

        //     redirect(
        //         "index.php?page=appointments"
        //     );
        // }

        $id = (int) $_POST["id"];
        $status = $_POST["status"];
        $notes = trim($_POST["doctor_notes"] ?? "");

        $this->appointmentModel->updateStatus(
            $id,
            $status,
            $notes
        );

        flash(
            "success",
            "Appointment updated"
        );

        redirect(
            "index.php?page=appointments"
        );
    }
}

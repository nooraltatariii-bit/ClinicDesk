<?php

require_once __DIR__ . "/../models/LogModel.php";
require_once __DIR__ . "/../core/Auth.php";
require_once __DIR__ . "/../core/CSRF.php";
require_once __DIR__ . "/../models/PrescriptionModel.php";

class PrescriptionController
{
    private $prescriptionModel;

    public function __construct()
    {
        $this->prescriptionModel = new PrescriptionModel();
    }

    public function create()
    {
        Auth::requireRole("doctor", "admin");

        $appointmentId = (int) ($_GET["appointment_id"] ?? 0);

        require_once __DIR__ . "/../views/prescriptions/create.php";
    }

    public function store()
    {
        Auth::requireRole("doctor", "admin");

        if (!CSRF::validateToken($_POST["csrf_token"] ?? "")) {
            flash("danger", "Invalid CSRF token");
            redirect("index.php?page=appointments");
        }

        $filePath = null;

        if (isset($_FILES["pdf"]) && $_FILES["pdf"]["error"] === 0) {
            if ($_FILES["pdf"]["size"] > 5242880) {
                flash("danger", "PDF too large");
                redirect("index.php?page=appointments");
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES["pdf"]["tmp_name"]);
            finfo_close($finfo);

            if ($mime !== "application/pdf") {
                flash("danger", "Only PDF allowed");
                redirect("index.php?page=appointments");
            }

            if (!is_dir("uploads/prescriptions")) {
                mkdir("uploads/prescriptions", 0777, true);
            }

            $filename = uniqid() . ".pdf";
            $target = "uploads/prescriptions/" . $filename;

            move_uploaded_file($_FILES["pdf"]["tmp_name"], $target);
            $filePath = $target;
        }

        $data = [
            "appointment_id" => $_POST["appointment_id"],
            "diagnosis" => trim($_POST["diagnosis"]),
            "medications" => trim($_POST["medications"]),
            "notes" => trim($_POST["notes"]),
            "file_path" => $filePath
        ];

        // 1. حفظ الوصفة الطبية أولاً
        $this->prescriptionModel->create($data);

        // 2. الكود الجديد: تسجيل العملية في الـ Logs مباشرة بعد الإضافة الناجحة
        $log = new LogModel();
        $log->create(
            Auth::currentUser()["id"],
            "Added prescription"
        );

        flash("success", "Prescription added");
        redirect("index.php?page=appointments");
    }

    public function myPrescriptions()
    {
        Auth::requireRole("patient", "doctor", "admin");
        $role = Auth::role();

        if ($role === "patient") {
            $prescriptions = $this->prescriptionModel->getPatientPrescriptions(Auth::currentUser()["id"]);
            require_once __DIR__ . "/../views/prescriptions/patient.php";
        } elseif ($role === "doctor") {
            $prescriptions = $this->prescriptionModel->getAll();
            require_once __DIR__ . "/../views/prescriptions/doctor.php";
        } elseif ($role === "admin") {
            $prescriptions = $this->prescriptionModel->getAll();
            require_once __DIR__ . "/../views/prescriptions/admin.php";
        }
    }

    public function download()
    {
        Auth::requireRole("patient", "doctor", "admin");

        $id = (int) ($_GET["id"] ?? 0);
        $allowed = $this->prescriptionModel->userCanAccess($id, Auth::currentUser()["id"], Auth::role());

        if (!$allowed) {
            http_response_code(403);
            exit("Forbidden");
        }

        $prescription = $this->prescriptionModel->findById($id);

        if (!$prescription || !$prescription["file_path"]) {
            http_response_code(404);
            exit("File not found");
        }

        $path = $prescription["file_path"];

        if (!file_exists($path)) {
            http_response_code(404);
            exit("Missing file");
        }

        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=prescription.pdf");
        readfile($path);
        exit;
    }
}
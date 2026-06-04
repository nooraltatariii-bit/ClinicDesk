<?php

require_once __DIR__ . "/../core/Auth.php";
require_once __DIR__ . "/../core/CSRF.php";
require_once __DIR__ . "/../models/UserModel.php";
require_once __DIR__ . "/../models/DoctorModel.php";
require_once __DIR__ . "/../models/SpecializationModel.php";

class DoctorController
{
    private $doctorModel;
    private $specializationModel;
    private $userModel;

    public function __construct()
    {
        $this->doctorModel = new DoctorModel();
        $this->specializationModel = new SpecializationModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        Auth::requireRole("admin");

        $doctors = $this->doctorModel->getAll();

        require_once __DIR__ . "/../views/doctors/index.php";
    }

    public function create()
    {
        Auth::requireRole("admin");

        $specializations = $this->specializationModel->getAll();

        require_once __DIR__ . "/../views/doctors/create.php";
    }

    public function store()
    {
        Auth::requireRole("admin");

        if (!CSRF::validateToken($_POST["csrf_token"] ?? "")) {
            flash("danger", "Invalid CSRF token");
            redirect("index.php?page=doctors");
        }

        // --- 1. كود التحقق من الصورة ورفعها بأمان ---
        $imagePath = null;

        if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === 0) {
            
            // تحديد الصيغ المسموحة بناءً على الـ MIME Type
            $allowed = [
                "image/jpeg",
                "image/png"
            ];

            // التحقق من نوع الملف الحقيقي
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES["photo"]["tmp_name"]);
            finfo_close($finfo);

            if (!in_array($mime, $allowed)) {
                flash("danger", "Only JPG and PNG allowed");
                redirect("index.php?page=doctors");
            }

            // التحقق من حجم الصورة (أقصى حجم 2 ميجابايت)
            if ($_FILES["photo"]["size"] > 2 * 1024 * 1024) {
                flash("danger", "Image too large");
                redirect("index.php?page=doctors");
            }

            // التأكد من وجود مجلد الحفظ أو إنشائه تلقائياً
            $targetDir = "public/uploads/doctor_photos";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // توليد اسم فريد وعشوائي للملف لحمايته من التكرار
            $extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
            $filename = uniqid() . "." . $extension;
            $target = $targetDir . "/" . $filename;

            // نقل الصورة للمجلد النهائي
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target)) {
                $imagePath = $target;
            }
        }

        // --- 2. إنشاء بيانات حساب المستخدم (User) ---
        $userData = [
            "name" => trim($_POST["name"]),
            "email" => trim($_POST["email"]),
            "password" => password_hash($_POST["password"], PASSWORD_BCRYPT),
            "role" => "doctor",
            "phone" => trim($_POST["phone"])
        ];

        $userId = $this->userModel->create($userData);

        // تحويل الأيام المتاحة المرفوعة كـ Array إلى نص مفصول بفاصلة لـ حفظها في قاعدة البيانات
        $availableDays = implode(",", $_POST["available_days"] ?? []);

        // --- 3. مصفوفة بيانات الطبيب المُعدلة (doctorData$) ---
        $doctorData = [
            "user_id"           => $userId,
            "specialization_id" => $_POST["specialization_id"],
            "bio"               => trim($_POST["bio"]),
            "consultation_fee"  => $_POST["consultation_fee"],
            "available_days"    => $availableDays,
            "photo"             => $imagePath // هنا تم تمرير متغير مسار الصورة بعد رفعه
        ];

        // حفظ بيانات الطبيب في قاعدة البيانات
        $this->doctorModel->create($doctorData);

        flash("success", "Doctor created successfully");
        redirect("index.php?page=doctors");
    }
}
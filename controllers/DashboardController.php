<?php

require_once __DIR__ . "/../core/Auth.php";
require_once __DIR__ . "/../models/ReportModel.php";

class DashboardController
{
    public function index()
    {
        Auth::requireRole(
            "admin",
            "doctor",
            "patient"
        );

        $role = Auth::role();

        if ($role === "admin") {
            
            $reportModel = new ReportModel();
            $stats = $reportModel->getStats();
         
            require_once __DIR__ . "/../views/dashboard/admin.php"; 

        } elseif (
            $role === "doctor"
        ) {

            require_once __DIR__ . "/../views/dashboard/doctor.php";

        } else {

            require_once __DIR__ . "/../views/dashboard/patient.php";
        }
    }
}
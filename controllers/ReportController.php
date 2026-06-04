<?php

require_once __DIR__
. "/../core/Auth.php";

require_once __DIR__
. "/../models/ReportModel.php";


class ReportController
{
    private $reportModel;


    public function __construct()
    {
        $this->reportModel =
        new ReportModel();
    }


    public function dashboard()
    {
        Auth::requireRole("admin");

        $stats =
        $this->reportModel
        ->getStats();

        require_once __DIR__
        . "/../views/reports/index.php";
    }


    public function exportCSV()
    {
        Auth::requireRole("admin");

        $appointments =
        $this->reportModel
        ->exportAppointments();

        header(
            "Content-Type: text/csv"
        );

        header(
            "Content-Disposition: attachment; filename=appointments_report.csv"
        );

        $output =
        fopen(
            "php://output",
            "w"
        );

        fputcsv(
            $output,
            [
                "ID",
                "Patient",
                "Doctor",
                "Date",
                "Time",
                "Status"
            ]
        );

        foreach (
            $appointments
            as $row
        ) {

            fputcsv(
                $output,
                $row
            );
        }

        fclose($output);

        exit;
    }
}
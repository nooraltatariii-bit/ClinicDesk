<?php

require_once __DIR__
. "/../core/Auth.php";

require_once __DIR__
. "/../models/LogModel.php";

class LogController
{
    private $logModel;

    public function __construct()
    {
        $this->logModel =
        new LogModel();
    }

    public function index()
    {
        Auth::requireRole("admin");

        $logs =
        $this->logModel
        ->getAll();

        require_once __DIR__
        . "/../views/logs/index.php";
    }
}
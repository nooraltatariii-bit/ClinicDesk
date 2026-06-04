<?php

error_reporting(E_ALL);

ini_set(
    "display_errors",
    0
);

ini_set(
    "session.cookie_httponly",
    1
);

ini_set(
    "session.use_only_cookies",
    1
);

if (
    isset($_SERVER["HTTPS"])
) {

    ini_set(
        "session.cookie_secure",
        1
    );
}

session_start();

require_once __DIR__
. "/core/helpers.php";


$page =
$_GET["page"] ?? "login";

$action =
$_GET["action"] ?? "index";


switch ($page) {

    case "login":

        require_once __DIR__
        . "/controllers/AuthController.php";

        $controller =
        new AuthController();

        if ($action === "login") {

            $controller->login();

        } elseif ($action === "logout") {

            $controller->logout();

        } else {

            $controller->showLogin();
        }

    break;


    case "dashboard":

        require_once __DIR__
        . "/controllers/DashboardController.php";

        $controller =
        new DashboardController();

        $controller->index();

    break;


    case "users":

        require_once __DIR__
        . "/controllers/UserController.php";

        $controller =
        new UserController();

        if ($action === "create") {

            $controller->create();

        } elseif ($action === "store") {

            $controller->store();

        } elseif ($action === "edit") {

            $controller->edit();

        } elseif ($action === "update") {

            $controller->update();

        } elseif ($action === "toggle") {

            $controller->toggle();

        } else {

            $controller->index();
        }

    break;


    case "doctors":

        require_once __DIR__
        . "/controllers/DoctorController.php";

        $controller =
        new DoctorController();

        if ($action === "create") {

            $controller->create();

        } elseif ($action === "store") {

            $controller->store();

        } else {

            $controller->index();
        }

    break;


    case "appointments":

        require_once __DIR__
        . "/controllers/AppointmentController.php";

        $controller =
        new AppointmentController();

        if ($action === "create") {

            $controller->create();

        } elseif ($action === "store") {

            $controller->store();

        } elseif ($action === "updateStatus") {

            $controller->updateStatus();

        } else {

            $controller->index();
        }

    break;


    case "prescriptions":

        require_once __DIR__
        . "/controllers/PrescriptionController.php";

        $controller =
        new PrescriptionController();

        if ($action === "create") {

            $controller->create();

        } elseif ($action === "store") {

            $controller->store();

        }elseif ($action === "edit") {

            $controller->edit();

        }elseif ($action === "update") {

            $controller->update();
        } elseif ($action === "download") {

            $controller->download();

        } elseif ($action === "mine") {

            $controller->myPrescriptions();

        } else {

            $controller->myPrescriptions();
        }

    break;


    case "reports":

        require_once __DIR__
        . "/controllers/ReportController.php";

        $controller =
        new ReportController();

        if ($action === "export") {

            $controller->exportCSV();

        } else {

            $controller->dashboard();
        }

    break;


case "profile":

require_once __DIR__
. "/controllers/ProfileController.php";

$controller =
new ProfileController();

$controller->index();

break;


    case "logout":

        session_destroy();

        redirect(
            "index.php?page=login"
        );

    break;

    case "logs":

require_once __DIR__
. "/controllers/LogController.php";

$controller =
new LogController();

$controller->index();

break;

    default:

        require_once __DIR__
        . "/views/errors/404.php";

    break;
}
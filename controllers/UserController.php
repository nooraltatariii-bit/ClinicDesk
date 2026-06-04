<?php

require_once __DIR__ . "/../models/LogModel.php";
require_once __DIR__ . "/../core/Auth.php";
require_once __DIR__ . "/../core/CSRF.php";
require_once __DIR__ . "/../models/UserModel.php";
require_once __DIR__ . "/../core/Paginator.php";

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        Auth::requireRole("admin");

        $page = (int) ($_GET["p"] ?? 1);
        $search = $_GET["search"] ?? "";

        $users = $this->userModel->getAll($page, $search);
        $totalUsers = $this->userModel->countUsers();
        $totalPages = ceil($totalUsers / 10);

        require_once __DIR__ . "/../views/users/index.php";
    }

    public function create()
    {
        Auth::requireRole("admin");

        require_once __DIR__ . "/../views/users/create.php";
    }

    public function store()
    {
        Auth::requireRole("admin");

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
                "index.php?page=users"
            );
        }

        $data = [
            "name" => trim($_POST["name"]),
            "email" => trim($_POST["email"]),
            "password" => password_hash(
                $_POST["password"],
                PASSWORD_BCRYPT
            ),
            "role" => $_POST["role"],
            "phone" => trim($_POST["phone"])
        ];

        if ($this->userModel->create($data)) {
            $userId = Auth::currentUser()["id"] ?? $_SESSION['user_id'] ?? null;
            
            if ($userId) {
                $log = new LogModel();
                $log->create($userId, "Added new user: " . $data['name']);
            }

            flash(
                "success",
                "User created successfully"
            );
        } else {
            flash("danger", "Failed to create user");
        }

        redirect(
            "index.php?page=users"
        );
    }

    public function toggle()
    {
        Auth::requireRole("admin");

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
                "index.php?page=users"
            );
        }

        $id = (int) $_POST["id"];

        if (
            Auth::currentUser()["id"] == $id
        ) {
            flash(
                "danger",
                "You cannot deactivate yourself"
            );

            redirect(
                "index.php?page=users"
            );
        }

        if ($this->userModel->toggleActive($id)) {
            $userId = Auth::currentUser()["id"] ?? $_SESSION['user_id'] ?? null;
            if ($userId) {
                $log = new LogModel();
                $log->create($userId, "Toggled status for User ID: " . $id);
            }

            flash(
                "success",
                "User updated"
            );
        }

        redirect(
            "index.php?page=users"
        );
    }

    public function edit()
    {
        Auth::requireRole("admin");

        $id = (int) $_GET["id"];
        $user = $this->userModel->findById($id);

        require_once __DIR__ . "/../views/users/edit.php";
    }

    public function update()
    {
        Auth::requireRole("admin");

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
                "index.php?page=users"
            );
        }

        $id = (int) $_POST["id"];

        $data = [
            "name" => trim($_POST["name"]),
            "email" => trim($_POST["email"]),
            "role" => $_POST["role"],
            "phone" => trim($_POST["phone"])
        ];

        if ($this->userModel->update($id, $data)) {
            $userId = Auth::currentUser()["id"] ?? $_SESSION['user_id'] ?? null;
            if ($userId) {
                $log = new LogModel();
                $log->create($userId, "Updated info for User: " . $data['name']);
            }

            flash(
                "success",
                "User updated"
            );
        }

        redirect(
            "index.php?page=users"
        );
    }
}
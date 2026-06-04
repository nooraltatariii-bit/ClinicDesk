<?php

require_once __DIR__
. "/../models/UserModel.php";

require_once __DIR__
. "/../core/Auth.php";

require_once __DIR__
. "/../core/CSRF.php";

class AuthController
{
    public function showLogin()
    {
        if (Auth::check()) {
            redirect(
                "index.php?page=dashboard"
            );
        }

        require_once __DIR__
        . "/../views/auth/login.php";
    }

    public function login()
    {
        if (
            !CSRF::validateToken(
                $_POST["csrf_token"] ?? ""
            )
        ) {

            flash(
                "danger",
                "Invalid CSRF token"
            );

            redirect("index.php");
        }

        $email = filter_var(
            $_POST["email"],
            FILTER_SANITIZE_EMAIL
        );

        $password =
        $_POST["password"];

        $userModel = new UserModel();

        $user = $userModel
        ->findByEmail($email);

        if (!$user) {

            flash(
                "danger",
                "Invalid credentials"
            );

            redirect("index.php");
        }

        if (
            !$user["is_active"]
        ) {

            flash(
                "danger",
                "Account suspended"
            );

            redirect("index.php");
        }

        if (
            !password_verify(
                $password,
                $user["password"]
            )
        ) {

            flash(
                "danger",
                "Invalid credentials"
            );

            redirect("index.php");
        }

        Auth::login($user);

        redirect(
            "index.php?page=dashboard"
        );
    }
   public function logout()
   {
    if (
        !CSRF::validateToken(
            $_POST["csrf_token"] ?? ""
        )
    ) {

        flash(
            "danger",
            "Invalid CSRF token"
        );

        redirect("index.php");
    }

    Auth::logout();
  }
}
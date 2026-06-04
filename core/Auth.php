<?php

class Auth
{
    public static function login(array $user)
    {
        session_regenerate_id(true);

        $_SESSION["user"] = [

            "id" => $user["id"],

            "name" => $user["name"],

            "role" => $user["role"]
        ];
    }


    public static function logout()
    {
        session_unset();

        session_destroy();

        header("Location: index.php");

        exit;
    }


    public static function check()
    {
        return isset($_SESSION["user"]);
    }


    public static function currentUser()
    {
        return $_SESSION["user"] ?? null;
    }


    public static function role()
    {
        return $_SESSION["user"]["role"] ?? "";
    }


    public static function requireRole(...$roles)
    {
        if (!self::check()) {

            header("Location: index.php");

            exit;
        }

        if (
            !in_array(
                self::role(),
                $roles
            )
        ) {

            require_once __DIR__
            . "/../views/errors/403.php";

            exit;
        }
    }


    public static function requireAnyRole(
        array $roles
    ) {

        if (!self::check()) {

            header(
                "Location: index.php?page=login"
            );

            exit;
        }

        if (
            !in_array(
                self::role(),
                $roles
            )
        ) {

            http_response_code(403);

            require_once __DIR__
            . "/../views/errors/403.php";

            exit;
        }
    }
}
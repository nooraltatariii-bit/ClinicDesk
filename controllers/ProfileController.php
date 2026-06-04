<?php

require_once __DIR__
. "/../core/Auth.php";

class ProfileController
{
    public function index()
    {
        Auth::requireRole(
            "admin",
            "doctor",
            "patient"
        );

        $user =
        Auth::currentUser();

        require_once __DIR__
        . "/../views/profile/index.php";
    }
}
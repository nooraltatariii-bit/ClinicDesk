<?php

function redirect($url)
{
    header("Location: $url");
    exit;
}

function sanitize($value)
{
    return htmlspecialchars(
        $value,
        ENT_QUOTES,
        "UTF-8"
    );
}

function formatDate($date)
{
    return date(
        "d M Y",
        strtotime($date)
    );
}

function formatTime($time)
{
    return date(
        "h:i A",
        strtotime($time)
    );
}

function flash($type, $message)
{
    $_SESSION["flash"] = [
        "type" => $type,
        "message" => $message
    ];
}


function isValidEmail($email)
{
    return filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    );
}

function isStrongPassword(
    string $password
)
{
    return preg_match(
        "/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}$/",
        $password
    );
}
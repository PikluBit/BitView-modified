<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/_includes/init.php";

header("Content-Type: application/json", true);

$name = trim((string) ($_POST['name'] ?? ''));
if ($name === '') {
    die(json_encode(["response" => "error", "message" => "no_name"]));
}

// Basic validation: only allow alphanumeric usernames (same as signup)
if (!ctype_alnum($name)) {
    die(json_encode(["response" => "invalid", "message" => "invalid_chars"]));
}

// Check length
if (mb_strlen($name) > 20) {
    die(json_encode(["response" => "invalid", "message" => "too_long"]));
}

$DB->execute("SELECT username FROM users WHERE username = :USERNAME", true, [":USERNAME" => $name]);

if ($DB->Row_Num === 0) {
    die(json_encode(["response" => "success"]));
} else {
    die(json_encode(["response" => "taken"]));
}

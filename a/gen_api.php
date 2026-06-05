<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/_includes/init.php";

require $_SERVER['DOCUMENT_ROOT']."/404.php";
exit();

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}

// Function to generate a random API key
function generateApiKey() {
    $length = 32;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $apiKey = '';

    for ($i = 0; $i < $length; $i++) {
        $apiKey .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return $apiKey;
}

// Check if the user is already in the database
$result = $DB->execute("SELECT * FROM api_keys WHERE username = :USERNAME", true, [":USERNAME" => $_USER->Username]);

if ($DB->Row_Num > 0) {
    // User already has an API key in the database
    $apiKey2 = $result['api_key'];
    echo "API key already exists, click <a href='https://dev.bitview.net/gen_api.php?key=$apiKey2'>here to get it</a>";
} else {
    // Generate a new API key and insert it into the database
    $apiKey = generateApiKey();

    // Prepare and execute a MySQL query to insert the API key into the database
    $DB->modify("INSERT INTO api_keys (username, api_key) VALUES (:USERNAME, :APIKEY)",[":USERNAME" => $_USER->Username, ":APIKEY" => $apiKey]);
    header("location: https://dev.bitview.net/gen_api.php?key=$apiKey");
}
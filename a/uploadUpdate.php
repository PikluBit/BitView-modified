<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

require $_SERVER['DOCUMENT_ROOT']."/404.php";
exit();

if (!$_USER->LoggedIn) { http_response_code(400); die(); }

$_VIDEO = new video($_DB, $_POST["vid"]);

if (!$_VIDEO->profileCanEditVideo($_PROFILE)) { http_response_code(400); die(); }

$_VIDEO->updateData([
    "title"         => $_POST["title"] ?? null,
    "description"   => $_POST["description"] ?? null,
    "keywords"      => $_POST["keywords"] ?? null,
    "category"      => $_POST["category"] ?? null,
    "publicity"     => $_POST["publicity"] ?? null,
    "schedule"      => $_POST["schedule"] ?? null
]);
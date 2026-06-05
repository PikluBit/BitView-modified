<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) { header("location: /login"); exit(); }

$_PAGINATION = new Pagination(20, 9999);

$Subscriptions = new Videos($DB, $_USER);
$Subscriptions->WHERE_C = "AND subscriptions.subscriber = :USERNAME";
$Subscriptions->JOIN    = "INNER JOIN subscriptions ON subscriptions.subscription = videos.uploaded_by";
$Subscriptions->ORDER_BY = "videos.uploaded_on DESC";
$Subscriptions->Execute = [":USERNAME" => $_USER->Username];
$Subscriptions->LIMIT = $_PAGINATION;
$Subscriptions->get();
if ($Subscriptions::$Videos) {
    $Subscriptions = $Subscriptions->fix_values(true, true);
} else {
    $Subscriptions = false;
}

if ($Subscriptions) {
    $Amount = new Videos($DB, $_USER);
    $Amount->WHERE_C = "AND subscriptions.subscriber = :USERNAME";
    $Amount->JOIN = "INNER JOIN subscriptions ON subscriptions.subscription = videos.uploaded_by";
    $Amount->ORDER_BY = "videos.uploaded_on DESC";
    $Amount->Execute = [":USERNAME" => $_USER->Username];
    $Amount->LIMIT = 300;
    $Amount->get();

    $_PAGINATION->total($Amount::$Amount);
}

if (isset($_GET['channel'])) {
    $Subscriptions = new Videos($DB,$_USER);
    $Subscriptions->WHERE_P    = ["videos.uploaded_by" => $_GET['channel']];
    $Subscriptions->ORDER_BY   = "videos.uploaded_on DESC";
    $Subscriptions->LIMIT          = $_PAGINATION;
    $Subscriptions->get();
    if ($Subscriptions::$Videos) {
    $Subscriptions = $Subscriptions->fix_values(true, true);
    } 
    else {
    $Subscriptions = false;
    }
}

$Subscriptions_List = $DB->execute("SELECT username FROM users INNER JOIN subscriptions ON subscriptions.subscriber = :USERNAME WHERE subscriptions.subscription = users.username AND is_banned = 0 ORDER BY subscriptions.subscription ASC", false, [":USERNAME" => $_USER->Username]);

$_PAGE = [
    "Page"          => "my_subscriptions",
    "Page_Type"     => "my_subscriptions"
];
require "_templates/_structures/main.php";
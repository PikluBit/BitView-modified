<?php

require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

require $_SERVER['DOCUMENT_ROOT']."/404.php";
exit();

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) {
    header("location: /login");
    exit();
}

$Friends = $_USER->get_friends(1000,true);

if ($Friends) {
    $Bulletin_Users = "'$_USER->Username',";
    foreach ($Friends as $Friend) {
        $Friend_Name = $Friend["username"];
        $Bulletin_Users .= "'$Friend_Name',";
    }
    $Bulletin_Users = substr($Bulletin_Users,0,strlen($Bulletin_Users) - 1);
} else {
    $Bulletin_Users = "'$_USER->Username'";
}

$Bulletin_Amount = $DB->execute("SELECT count(*) as amount FROM bulletins WHERE by_user IN ($Bulletin_Users) ORDER BY submit_date DESC")[0]['amount'];

$_PAGINATION = new Pagination(20,10000);
$_PAGINATION->total($Bulletin_Amount);

$Bulletins_Pagination = $DB->execute("SELECT * FROM bulletins WHERE by_user IN ($Bulletin_Users) ORDER BY submit_date DESC LIMIT $_PAGINATION->From, $_PAGINATION->To");

if (isset($_GET['b'])) {
$Bulletin_Content = $DB->execute("SELECT * FROM bulletins WHERE id = ?",true,[$_GET['b']]);
$Bulletin_Comments = $DB->execute("SELECT * FROM bulletins_comments WHERE bulletin_id = ? ORDER BY submit_date DESC",false,[$_GET['b']]);
}

$_PAGE = [
    "Page"          => "bulletin_archive",
    "Page_Type"     => "index"
];
require "_templates/_structures/main.php";

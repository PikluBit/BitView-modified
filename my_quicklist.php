<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (isset($_GET["clear"]) && $_GET["clear"] == 1) {
    $_SESSION["quicklist"] = [];
    $_USER->QuickList      = [];

    notification($LANGS['quicklistcleared'], "/my_quicklist", "cfeeb2"); exit();
    exit();
}

$_PAGINATION = new Pagination(20, 999);
$_PAGINATION->total(count($_USER->QuickList));


$Videos_Array = sql_IN_fix($_USER->QuickList);

if (!isset($_GET['sf']) || isset($_GET['sf']) && $_GET['sf'] == "added") {
    $ORDER = "field(videos.url,$Videos_Array) DESC";
    $SortBy = $LANGS['sortnewest'];
}
if (isset($_GET['sf']) && $_GET['sf'] == "added-old") {
    $ORDER = "field(videos.url,$Videos_Array) ASC";
    $SortBy = $LANGS['sortoldest'];
}
if (isset($_GET['sf']) && $_GET['sf'] == "viewcount") {
    $ORDER = "videos.views DESC";
    $SortBy = $LANGS['sortmostviewed'];
}
if (isset($_GET['sf']) && $_GET['sf'] == "duration-l") {
    $ORDER = "videos.length DESC";
    $SortBy = $LANGS['sortlongest'];
}
if (isset($_GET['sf']) && $_GET['sf'] == "duration-s") {
    $ORDER = "videos.length ASC";
    $SortBy = $LANGS['sortshortest'];
}
if (isset($_GET['sf']) && $_GET['sf'] == "title-az") {
    $ORDER = "videos.title ASC";
    $SortBy = $LANGS['sortaz'];
}
if (isset($_GET['sf']) && $_GET['sf'] == "title-za") {
    $ORDER = "videos.title DESC";
    $SortBy = $LANGS['sortza'];
}

if ($Videos_Array) {
$Videos = new Videos($DB, $_USER);
$Videos->WHERE_C = "AND videos.url IN ($Videos_Array)";
$Videos->ORDER_BY = $ORDER;
$Videos->Private_Videos = true;
$Videos->STATUS         = 3;
$Videos->LIMIT = $_PAGINATION;
$Videos->get();
if ($Videos::$Videos) {
    $Videos = $Videos->fix_values(true, true);
} else {
    $Videos = false;
}
}

$_PAGE = [
    "Page"          => "my_quicklist",
    "Page_Type"     => "browsing",
    "Title"         => $LANGS['quicklist']
];
require "_templates/_structures/main.php";
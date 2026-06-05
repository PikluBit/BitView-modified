<?php

require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

$_PAGINATION    = new Pagination(30, 100);

$Channel_Types = [0 => $LANGS['type0'], 1 => $LANGS['type1p'], 2 => $LANGS['type2p'], 3 => $LANGS['type3p'], 4 => $LANGS['type4p'], 5 => $LANGS['type5p'], 6 => $LANGS['type6p']];

$Video_Category = [1 => $LANGS['cat1'], 2 => $LANGS['cat2'], 3 => $LANGS['cat3'], 4 => $LANGS['cat4'], 5 => $LANGS['cat5'], 6 => $LANGS['cat6'], 7 => $LANGS['cat7'], 8 => $LANGS['cat8'], 9 => $LANGS['cat9'], 10 => $LANGS['cat10'], 11 => $LANGS['cat11'], 12 => $LANGS['cat12'], 13 => $LANGS['cat13'], 14 => $LANGS['cat14'], 15 => $LANGS['cat15'], 16 => $LANGS['cat16'], 17 => $LANGS['cat17'], 18 => $LANGS['cat18'], 19 => $LANGS['cat19'], 20 => $LANGS['cat20'], 21 => $LANGS['cat21']];

if (!isset($_GET["date"])) {
    $DATE = "_month";
} elseif($_GET["date"] == "d") {
    $DATE = "_day";
} elseif($_GET["date"] == "w") {
    $DATE = "_week";
} elseif($_GET["date"] == "m") {
    $DATE = "_month";
} else {
    $DATE = "";
}

$TYPE_CONTENT = "WHERE is_banned = 0"; //none selected, so don't search
if (!isset($_GET["type"]) || $_GET["type"] == 0) {
    $_GET["type"] = 0;
} elseif($_GET["type"] == 1) {
    $TYPE_CONTENT = "WHERE type = 1 AND is_banned = 0"; //members
} elseif($_GET["type"] == 2) {
    $TYPE_CONTENT = "WHERE type = 2 AND is_banned = 0"; //animators
} elseif($_GET["type"] == 3) {
    $TYPE_CONTENT = "WHERE type = 3 AND is_banned = 0"; //comedians
} elseif($_GET["type"] == 4) {
    $TYPE_CONTENT = "WHERE type = 4 AND is_banned = 0"; //directors
} elseif($_GET["type"] == 5) {
    $TYPE_CONTENT = "WHERE type = 5 AND is_banned = 0"; //gamers
} elseif($_GET["type"] == 6) {
    $TYPE_CONTENT = "WHERE type = 6 AND is_banned = 0"; //gurus
} elseif($_GET["type"] == 7) {
    $TYPE_CONTENT == "WHERE type = 7 AND is_banned = 0"; //musicians
} elseif($_GET["type"] == 8) {
    $TYPE_CONTENT == "WHERE type = 8 AND is_banned = 0"; //reporters
}

if (!isset($_GET["order"])) {
    $ORDER_BY = "video_views".$DATE." DESC";
    $WHERE = "AND users.video_views".$DATE." > 0";
} elseif ($_GET["order"] == "subscribers") {
    $ORDER_BY = "subscribers".$DATE." DESC";
    $WHERE = "AND users.subscribers".$DATE." > 0";
} else {
    header("location: /channels");
    exit();
}

if (isset($_GET["gl"])) {
    $GL = "AND users.i_country = ?";
} else {
    $GL = "";
}

if (isset($_GET["order"])) {
    $Order = "order=".$_GET['order'];
}
else {
    $Order = "";
}

if (isset($_GET["order"])) {
    if (isset($_GET["type"])) {
        $ChType = "&type=".$_GET['type'];
    }
    else {
        $ChType = "";
    }
}
else {
    $ChType = "type=".$_GET['type'];
}
if (isset($_GET["order"]) || isset($_GET["type"])) {
    if (isset($_GET["date"])) {
        $Date = "&date=".$_GET['date'];
    }
    else {
        $Date = "";
    }
}
else {
    $Date = "date=".$_GET['date'];
}

$Amount = 3000;
$_PAGINATION->total($Amount);

if ($GL) {
    $Users = $DB->execute("SELECT * FROM users $TYPE_CONTENT $WHERE $GL ORDER BY $ORDER_BY LIMIT $_PAGINATION->From, $_PAGINATION->To",false,[$_GET["gl"]]);
    $Users_Count = $DB->execute("SELECT count(*) FROM users $TYPE_CONTENT $WHERE $GL ORDER BY $ORDER_BY",false,[$_GET["gl"]])[0]["count(*)"];
}
else {
    $Users = $DB->execute("SELECT * FROM users $TYPE_CONTENT $WHERE ORDER BY $ORDER_BY LIMIT $_PAGINATION->From, $_PAGINATION->To");
    $Users_Count = $DB->execute("SELECT count(*) FROM users $TYPE_CONTENT $WHERE ORDER BY $ORDER_BY")[0]["count(*)"];
}
$_PAGINATION->total($Users_Count);

$_PAGE = [
    "Page"       => "channels",
    "Page_Type"  => "channels",
    "Show_Search" => true,
    "new"         => true
];
require "_templates/_structures/main.php";

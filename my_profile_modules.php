<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) { header("location: /login"); exit(); }

$_USER->get_info();

if (isset($_POST["save_profile"])) {
    if (isset($_POST["subscriptions"])) { $Subscriptions = 1; } else { $Subscriptions = 0; }
    if (isset($_POST["recommended"])) { $Recommended = 1; } else { $Recommended = 0; }
    if (isset($_POST["activity"])) { $Activity = 1; } else { $Activity = 0; }
    if (isset($_POST["beingwatched"])) { $BeingWatched = 1; } else { $BeingWatched = 0; }
    if (isset($_POST["featured"])) { $Featured = 1; } else { $Featured = 0; }
    if (isset($_POST["mostpop"])) { $MostPop = 1; } else { $MostPop = 0; }
    if (isset($_POST["feed"])) { $Feed = 1; } else { $Feed = 0; }
    $DB->modify("UPDATE users SET h_subscriptions = :SUBSCRIPTIONS, h_recommended = :RECOMMENDED, h_activity = :ACTIVITY, h_beingwatched = :BEINGWATCHED,h_featured = :FEATURED, h_mostpop = :MOSTPOP, h_feed = :FEED WHERE username = :USERNAME",[":SUBSCRIPTIONS" => $Subscriptions,":RECOMMENDED" => $Recommended,":ACTIVITY" => $Activity,":BEINGWATCHED" => $BeingWatched,":MOSTPOP" => $MostPop,":FEATURED" => $Featured, ":FEED" => $Feed,":USERNAME" => $_USER->Username]);
        notification($LANGS['changessaved'],"/my_profile_modules","cfeeb2"); exit();
}    

$_PAGE = [
    "Page"          => "my_profile_modules",
    "Page_Type"     => "my_profile_modules"
];
require "_templates/_structures/main.php";

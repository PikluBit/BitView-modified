<?php
header('Content-Type: application/json');
echo json_encode(["r" => "fail", "code" => 3, "message" => "API is disabled"]);
exit;
/*
//Really primitive API but I wanted to have something like this long time ago. I will public API documentation soon. -vista
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
ini_set("short_open_tag", 0);
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$ty = $_GET["ty"]; //type of call
$ta = $_GET["ta"]; //target


if(isset($ty)) {
    //SITE STATS
    if($ty == "stats") {
        $Views_Stats = $DB->execute("SELECT SUM(views) as views, submit_date FROM views_day GROUP BY DATE(submit_date)");
        $Users_Stats = $DB->execute("SELECT count(username) as amount, registration_date FROM users WHERE is_banned=0 GROUP BY DATE(registration_date)");
        $Stats = $DB->execute("SELECT count(url) as all_videos, sum(views) as all_views, sum(favorites) as all_favorites, sum(comments) as all_comments FROM videos", true);
        $Friends = $DB->execute("SELECT SUM(friends) as amount FROM users", true)["amount"];
        $Subscriptions = $DB->execute("SELECT SUM(subscriptions) as amount FROM users", true)["amount"];
        $Ratings       = $DB->execute("SELECT count(rating) as amount FROM videos_ratings", true)["amount"];
        $Bulletins     = $DB->execute("SELECT count(id) as amount FROM bulletins", true)["amount"];
        $Stats2 = $DB->execute("SELECT count(username) as all_users FROM users", true);
        $Stats3 = $DB->execute("SELECT count(username) as banned_users FROM users WHERE is_banned = 1", true);

        $siteStats->r = "success";
        $siteStats->users = $Stats2["all_users"];
        $siteStats->banned_users = $Stats3["banned_users"];
        $siteStats->videos = $Stats["all_videos"];
        $siteStats->total_views = $Stats["all_views"];
        $siteStats->total_comments = $Stats["all_comments"];
        $siteStats->total_favorites = $Stats["all_favorites"];
        $siteStats->total_ratings = $Ratings;
        $siteStats->total_subs = $Subscriptions;
        $siteStats->total_bulletins = $Bulletins;

        $statsJSON = json_encode($siteStats);
        echo $statsJSON;

    }

    //USER INFO
    if($ty == "user" && isset($ta)) {
        $_PROFILE = new User($_GET["ta"], $DB);

        if ($_PROFILE->get_info() !== false && !$_PROFILE->is_banned()) {
            $userType->r = "success";
            $userType->username = $_PROFILE->Username;
            $userType->registered = $_PROFILE->Info["registration_date"];
            $userType->last_login = $_PROFILE->Info["last_login"];
            $userType->videos_watched = $_PROFILE->Info["videos_watched"];
            $userType->channel_views = $_PROFILE->Info["profile_views"];
            $userType->videos = $_PROFILE->Info["videos"];
            $userType->subscribers = $_PROFILE->Info["subscribers"];
            $userType->subscriptions = $_PROFILE->Info["subscriptions"];
            $userType->friends = $_PROFILE->Info["friends"];
            $userType->channel_comments = $_PROFILE->Info["channel_comments"];
            if(!isset($_PROFILE->Info["i_name"])) {
                $userType->title = false;
            } else {
                $userType->title = "".$_PROFILE->Info["i_name"]."";
            }
            if(!isset($_PROFILE->Info["i_about"])) {
                $userType->description = false;
            } else {
                $userType->description = "".$_PROFILE->Info["i_about"]."";
            }
            if($_PROFILE->Info["is_moderator"] == "0" && $_PROFILE->Info["is_admin"] == "0") {
                $userType->is_moderator = false;
            } elseif($_PROFILE->Info["is_moderator"] == "1" || $_PROFILE->Info["is_admin"] == "1") {
                $userType->is_moderator = true;
            }
            if(!isset($_PROFILE->Info["i_country"])) {
                $userType->country = false;
            } else {
                $userType->country = "".$_PROFILE->Info["i_country"]."";
            }
            $userType->avatar = "".avatar($_PROFILE->Username);
            "";


            $userJSON = json_encode($userType);
            echo $userJSON;
        } else {

            $notype->r = "fail";
            if ($_PROFILE->is_banned()) {
                $notype->code = 1;
            } else {
                $notype->code = 0;
            }

            $notypeJSON = json_encode($notype);
            echo $notypeJSON;
        }
    }

    //VIDEO INFO
    if($ty == "video" && isset($ta)) {
        $_VIDEO = new Video($_GET["ta"], $DB);

        if ($_VIDEO->exists()) {
            $_VIDEO->get_info();
            $_VIDEO->check_info();
            $Total_Ratings = $_VIDEO->Info["1stars"] + $_VIDEO->Info["2stars"] + $_VIDEO->Info["3stars"] + $_VIDEO->Info["4stars"] + $_VIDEO->Info["5stars"];

            $videoType->r = "success";
            $videoType->url = $_VIDEO->Info["url"];
            $videoType->title = $_VIDEO->Info["title"];
            $videoType->description = $_VIDEO->Info["description"];
            $videoType->category = $_CONFIG::$Categories[$_VIDEO->Info["category"]];
            $videoType->tags = $_VIDEO->Info["tags"];
            $videoType->upload_date = $_VIDEO->Info["uploaded_on"];
            $videoType->upload_by = $_VIDEO->Info["uploaded_by"];
            $videoType->duration = $_VIDEO->Info["length"];
            $videoType->ranking_views = $Total_Ratings;
            $videoType->rankings = array(
                0 => $_VIDEO->Info["1stars"],
                1 => $_VIDEO->Info["2stars"],
                2 => $_VIDEO->Info["3stars"],
                3 => $_VIDEO->Info["4stars"],
                4 => $_VIDEO->Info["5stars"]
            );
            $videoType->display_views = $_VIDEO->Info["views"];
            $videoType->comment_num = $_VIDEO->Info["comments"];
            $videoType->is_featured = $_VIDEO->Info["featured"];


            $videoJSON = json_encode($videoType);
            echo $videoJSON;
        } else {
            $notype->r = "fail";

            $notypeJSON = json_encode($notype);
            echo $notypeJSON;
        }
    }

} else {
    $notype->r = "fail";

    $notypeJSON = json_encode($notype);
    echo $notypeJSON;
}
*/

<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

require $_SERVER['DOCUMENT_ROOT']."/404.php";
exit();

if (!$argv[1]) { header("location: /"); exit(); }
$action = $argv[1];


$Emailer = new Email();
if ($action == "c") {
    if (!isset($argv[2])) { header("location: /"); exit(); }

    $Comment_ID = (int)$argv[2];

    $Comment_Info = $DB->execute("SELECT videos_comments.by_user, videos_comments.content, videos.title, videos.url, users.e_comments, users.email, users.username FROM videos_comments INNER JOIN videos ON videos_comments.url = videos.url INNER JOIN users ON users.username = videos.uploaded_by WHERE videos_comments.id = :ID", true, [":ID" => $Comment_ID]);


    if ($Comment_Info["e_comments"] == 1 && $Comment_Info["username"] != $Comment_Info["by_user"]) {
        $Emailer->To = $Comment_Info["email"];
        $Emailer->To_Name = $Comment_Info["username"];
        $Emailer->Subject = $Comment_Info["by_user"]." commented on your video";
        $Video_URL        = $Comment_Info["url"];
        $By_User          = $Comment_Info["by_user"];
        $Video_Title      = $Comment_Info["title"];
        $Emailer->send_email("<a href='https://www.bitview.net/user/$By_User'>$By_User</a> has commented on your video: <a href='https://www.bitview.net/watch?v=$Video_URL'>$Video_Title</a>");
    }
} elseif ($action == "m") {
    if (!isset($argv[2])) { header("location: /"); exit(); }

    $Message_ID = (int)$argv[2];

    $Message_Info = $DB->execute("SELECT users_messages.id, users_messages.by_user, users_messages.for_user, users.e_messages, users.email FROM users_messages INNER JOIN users ON users.username = users_messages.for_user WHERE users_messages.id = :ID", true, [":ID" => $Message_ID]);

    if ($Message_Info["by_user"] != $Message_Info["for_user"] && $Message_Info["e_messages"] == 1) {
        $Emailer->To      = $Message_Info["email"];
        $Emailer->To_Name = $Message_Info["for_user"];
        $Emailer->Subject = $Message_Info["by_user"]." has sent you a private message";
        $ID               = $Message_Info["id"];
        $By_User          = $Message_Info["by_user"];
        $Emailer->send_email("<a href='https://www.bitview.net/user/$By_User'>$By_User</a> has sent you a private message on BitView: <a href='https://www.bitview.net/show_message?id=$ID'>Read it</a>.");
    }
} elseif ($action == "s") {
    if (!isset($argv[2])) { header("location: /"); exit(); }

    $Username = $argv[2];


    $Subscriptions = new Videos($DB, $_USER);
    $Subscriptions->WHERE_C = "AND subscriptions.subscriber = :USERNAME AND DATEDIFF(NOW(), videos.uploaded_on) < 7";
    $Subscriptions->JOIN    = "INNER JOIN subscriptions ON subscriptions.subscription = videos.uploaded_by";
    $Subscriptions->ORDER_BY = "videos.views DESC";
    $Subscriptions->Execute = [":USERNAME" => $Username];
    $Subscriptions->LIMIT = 10;
    $Subscriptions->get();
    if ($Subscriptions::$Videos) {

        $Subscriptions = $Subscriptions->fix_values(true, false);

        $Video_String = "";
        $Count = 1;
        foreach ($Subscriptions as $Subscription) {
            $Video_URL = $Subscription["url"];
            $Video_Title = $Subscription["title"];
            $Views       = $Subscription["views"];

            $Video_String .= "<div style='margin-bottom:4px'>#$Count <a href='https://www.bitview.net/watch?v=$Video_URL'>$Video_Title</a><div style='font-size:12px;color:#696969'>$Views views</div></div>";
            $Count++;
        }
        $Email = $DB->execute("SELECT email FROM users WHERE username = :USERNAME", true, [":USERNAME" => $Username])["email"];

        $Emailer->To      = $Email;
        $Emailer->To_Name = $Username;
        $Emailer->Subject = "Your weekly subscription highlights";

        $Emailer->send_email("<div style='margin-bottom:6px'>Your subscriptions have been making a bunch of awesome videos lately. Here are the highlights:</div>$Video_String");

    }
}
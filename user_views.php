<?php

require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";


$Users_Video = $DB->execute("SELECT username, video_views, video_views_day, video_views_week, video_views_month FROM users WHERE is_banned = 0 AND videos > 0", false);
$Users_Subs = $DB->execute("SELECT username, subscribers_day, subscribers_week, subscribers_month FROM users WHERE is_banned = 0 AND subscribers > 0", false);

foreach ($Users_Video as $User) {
    $Username = $User["username"];
    $Video_Views  = $DB->execute("SELECT sum(views) as amount FROM videos WHERE uploaded_by = :USERNAME and privacy = 1", true, [":USERNAME" => $Username])["amount"];
    $Video_Views_Day  = (int)$DB->execute("SELECT sum(views_day.views) as amount FROM views_day INNER JOIN videos ON videos.url = views_day.url WHERE videos.uploaded_by = :USERNAME and privacy = 1 AND views_day.submit_date > DATE_SUB(NOW(), INTERVAL 24 HOUR)", true, [":USERNAME" => $Username])["amount"];
    if ($Video_Views_Day != $User["video_views_day"]) {
        $Video_Views_Week  = (int)$DB->execute("SELECT sum(views_day.views) as amount FROM views_day INNER JOIN videos ON videos.url = views_day.url WHERE videos.uploaded_by = :USERNAME and privacy = 1 AND views_day.submit_date > DATE_SUB(NOW(), INTERVAL 1 WEEK)", true, [":USERNAME" => $Username])["amount"];
        $Video_Views_Month  = (int)$DB->execute("SELECT sum(views_day.views) as amount FROM views_day INNER JOIN videos ON videos.url = views_day.url WHERE videos.uploaded_by = :USERNAME and privacy = 1 AND views_day.submit_date > DATE_SUB(NOW(), INTERVAL 1 MONTH)", true, [":USERNAME" => $Username])["amount"];
    }
    if (empty($Video_Views)) { $Video_Views = 0; }
    if (empty($Video_Views_Day) || $Video_Views_Day < 0) { $Video_Views_Day = 0; }
    if ($Video_Views_Day != $User["video_views_day"]) {
        if (empty($Video_Views_Week) || $Video_Views_Week < 0) { $Video_Views_Week = 0; }
        if (empty($Video_Views_Month) || $Video_Views_Month < 0) { $Video_Views_Month = 0; }
    }
    if ($Video_Views != $User["video_views"]) { $DB->modify("UPDATE users SET video_views = :VIEWS WHERE username = :USERNAME",[":VIEWS" => $Video_Views, ":USERNAME" => $Username]); }
    if ($Video_Views_Day != $User["video_views_day"]) { $DB->modify("UPDATE users SET video_views_day = :VIEWS WHERE username = :USERNAME",[":VIEWS" => $Video_Views_Day, ":USERNAME" => $Username]); }
    if ($Video_Views_Day != $User["video_views_day"]) {
        if ($Video_Views_Week != $User["video_views_week"]) { $DB->modify("UPDATE users SET video_views_week = :VIEWS WHERE username = :USERNAME",[":VIEWS" => $Video_Views_Week, ":USERNAME" => $Username]); }
        if ($Video_Views_Month != $User["video_views_month"]) { $DB->modify("UPDATE users SET video_views_month = :VIEWS WHERE username = :USERNAME",[":VIEWS" => $Video_Views_Month, ":USERNAME" => $Username]); }
    }
}
foreach ($Users_Subs as $User) {
    $Username = $User["username"];
    $Subscribers_Day  = (int)$DB->execute("SELECT count(*) as amount FROM subscriptions WHERE subscriptions.subscription = :USERNAME AND subscriptions.submit_date > DATE_SUB(NOW(), INTERVAL 24 HOUR)", true, [":USERNAME" => $Username])["amount"];
    if ($Subscribers_Day != $User["subscribers_day"]) {
        $Subscribers_Week  = (int)$DB->execute("SELECT count(*) as amount FROM subscriptions WHERE subscriptions.subscription = :USERNAME AND subscriptions.submit_date > DATE_SUB(NOW(), INTERVAL 1 WEEK)", true, [":USERNAME" => $Username])["amount"];
        $Subscribers_Month  = (int)$DB->execute("SELECT count(*) as amount FROM subscriptions WHERE subscriptions.subscription = :USERNAME AND subscriptions.submit_date > DATE_SUB(NOW(), INTERVAL 1 MONTH)", true, [":USERNAME" => $Username])["amount"];
    }
    if ($Subscribers_Day != $User["subscribers_day"]) { $DB->modify("UPDATE users SET subscribers_day = :SUBSCRIBERS WHERE username = :USERNAME",[":SUBSCRIBERS" => $Subscribers_Day, ":USERNAME" => $Username]); }
    if ($Subscribers_Day != $User["subscribers_day"]) {
        if ($Subscribers_Week != $User["subscribers_week"]) { $DB->modify("UPDATE users SET subscribers_week = :SUBSCRIBERS WHERE username = :USERNAME",[":SUBSCRIBERS" => $Subscribers_Week, ":USERNAME" => $Username]); }
        if ($Subscribers_Month != $User["subscribers_month"]) { $DB->modify("UPDATE users SET subscribers_month = :SUBSCRIBERS WHERE username = :USERNAME",[":SUBSCRIBERS" => $Subscribers_Month, ":USERNAME" => $Username]); }
    }
}
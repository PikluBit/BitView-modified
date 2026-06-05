<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
use function PHP81_BC\strftime;
header("Content-Type: application/json", true);

//REQUIREMENTS / PERMISSIONS
//- Requires ($_POST["id"])
if (!isset($_POST["id"])) { exit(); }

$URL = $_POST['id'];
$Get_Info = $DB->execute("SELECT videos.*, videos.views as views, videos.uploaded_by as uploader FROM videos WHERE videos.url = :URL LIMIT 1", true, [":URL" => $_POST["id"]]);

if ($DB->Row_Num == 1) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$URL.'.jpg')) {
        $Get_Info['thumb'] = "/u/thmp/".$URL.".jpg";
    }
    else {
        $Get_Info['thumb'] = "/img/nothump.png";
    }
    setlocale(LC_TIME, $LANGS['languagecode']);
    if (isset($_COOKIE['time_machine'])) { 
        $Get_Info['uploaded_on'] = strftime($LANGS['longtimeformat'], time_machine(strtotime((string) $Get_Info['uploaded_on']))); }
    else { 
        $Get_Info['uploaded_on'] = strftime($LANGS['longtimeformat'], strtotime((string) $Get_Info['uploaded_on']));
    }
    if ($LANGS['numberformat'] == 1) {
        $Get_Info['views'] = number_format($Get_Info['views'])." ".$LANGS['videoviews'];
    }
    else {
        $Get_Info['views'] = $Get_Info['views']." ".$LANGS['videoviews'];
    }
    $Get_Info['displayname'] = displayname($Get_Info['uploaded_by']);
    $Get_Info['description'] = short_title(nl2br((string) $Get_Info['description']), 100);
    $Get_Info['ratings'] = number_format($Get_Info['1stars'] + $Get_Info['2stars'] + $Get_Info['3stars'] + $Get_Info['4stars'] + $Get_Info['5stars']);

    if ($Get_Info['ratings'] == 1) {
        $Get_Info['ratings'] = $Get_Info['ratings']." ".$LANGS['rating'];
    } 
    else { 
        $Get_Info['ratings'] = $Get_Info['ratings']." ".$LANGS['ratings']; 
    }
    $Get_Info['rating'] = avg_ratings($Get_Info);
    if ($_USER->Logged_In and $Get_Info['e_ratings'] == 1) {
        $Get_Info['logged_in'] = 1;
    }
    else {
        $Get_Info['logged_in'] = 0;
    }

    echo json_encode($Get_Info);
} else {
    header('HTTP/1.0 404 Not Found');
    exit();
}
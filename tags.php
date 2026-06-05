<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";


//GET ALL TAGS
$Video_Tags = $DB->execute("SELECT tags FROM videos WHERE tags <> '' AND privacy = 1 AND status = 2 AND is_deleted IS NULL AND uploaded_by_banned = 0 ORDER BY uploaded_on DESC LIMIT 32");

$All_Tags = "";
foreach ($Video_Tags as $Tags) {
    $All_Tags .= $Tags["tags"].",";
}
$All_Tags = array_slice(array_count_values(array_filter(explode(",",mb_substr($All_Tags,0,mb_strlen($All_Tags) - 1)))),-100);


//GET POPULAR TAGS
$Popular_Video_Tags = $DB->execute("SELECT tags FROM videos WHERE tags <> '' AND privacy = 1 AND status = 2 AND is_deleted IS NULL AND uploaded_by_banned = 0 ORDER BY uploaded_on DESC LIMIT 1000");

$Popular_All_Tags = "";
foreach ($Popular_Video_Tags as $Tags) {
    $Popular_All_Tags .= $Tags["tags"].",";
}
$Popular_All_Tags = array_count_values(array_filter(explode(",",mb_substr($Popular_All_Tags,0,mb_strlen($Popular_All_Tags) - 1))));
unset($Popular_All_Tags["bitview"]);
asort($Popular_All_Tags);
$Popular_All_Tags = array_reverse(array_splice($Popular_All_Tags,-64));


$_PAGE = [
    "Page"       => "tags",
    "Page_Type"  => "home"
];
require "_templates/_structures/main.php";
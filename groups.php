<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

$_PAGINATION = new Pagination(10,15);

if (!isset($_GET["b"])) {
    if (!isset($_GET["c"]) || !isset($_CONFIG::$Categories[$_GET["c"]])) {
        $Groups = $DB->execute("SELECT groups.* FROM groups INNER JOIN users ON groups.created_by = users.username WHERE users.is_banned = 0 ORDER BY groups.creation_date DESC LIMIT $_PAGINATION->From, $_PAGINATION->To");
        $DB->execute("SELECT id FROM groups");
        $Amount = 150;
    } else {
        $Groups = $DB->execute("SELECT groups.* FROM groups INNER JOIN users ON groups.created_by = users.username WHERE users.is_banned = 0 AND groups.categories = :CATEGORIES ORDER BY groups.creation_date DESC LIMIT $_PAGINATION->From, $_PAGINATION->To",false,[":CATEGORIES" => $_GET["c"]]);
        $DB->execute("SELECT id FROM groups INNER JOIN users ON groups.created_by = users.username WHERE users.is_banned = 0 AND categories = :CATEGORIES",false,[":CATEGORIES" => $_GET["c"]]);
        $Amount = 150;
    }
} else {
    if ($_GET["b"] == "members") {
        $Groups = $DB->execute("SELECT groups.*, count(groups_members.member) as amount FROM groups INNER JOIN users ON groups.created_by = users.username LEFT JOIN groups_members ON groups.id = groups_members.group_id WHERE users.is_banned = 0 GROUP BY groups_members.group_id, groups.id ORDER BY amount DESC, groups.creation_date DESC LIMIT $_PAGINATION->From, $_PAGINATION->To");
            $Amount = 150;
    } elseif ($_GET["b"] == "videos") {
        $Groups = $DB->execute("SELECT groups.*, count(groups_videos.video) as amount FROM groups INNER JOIN users ON groups.created_by = users.username LEFT JOIN groups_videos ON groups.id = groups_videos.group_id WHERE users.is_banned = 0 GROUP BY groups_videos.group_id, groups.id ORDER BY amount DESC, groups.creation_date DESC LIMIT $_PAGINATION->From, $_PAGINATION->To");
            $Amount = 150;
    } elseif ($_GET["b"] == "topics") {
        $Groups = $DB->execute("SELECT groups.*, count(groups_topics.id) as amount FROM groups INNER JOIN users ON groups.created_by = users.username LEFT JOIN groups_topics ON groups.id = groups_topics.group_id WHERE users.is_banned = 0 GROUP BY groups_topics.group_id, groups.id ORDER BY amount DESC, groups.creation_date DESC LIMIT $_PAGINATION->From, $_PAGINATION->To");
        $Amount = 150;
    } else {
        header("location: /"); exit();
    }
    $DB->execute("SELECT id FROM groups");
}
$_PAGINATION->total($Amount);


$_PAGE = [
    "Page"      => "groups",
    "Page_Type" => "groups",
    "Show_Search" => false,
    "new"         => true
];
require "_templates/_structures/main.php";

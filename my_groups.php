<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!$_USER->Logged_In) { header("location: /login"); exit(); }

$_PAGINATION = new Pagination(10,10);

$DB->execute("SELECT groups.id FROM groups INNER JOIN groups_members ON groups.id = groups_members.group_id WHERE groups_members.member = :USERNAME", false, [":USERNAME" => $_USER->Username]);
$_PAGINATION->total($DB->Row_Num);


$Groups = $DB->execute("SELECT groups.* FROM groups INNER JOIN groups_members ON groups.id = groups_members.group_id WHERE groups_members.member = :USERNAME ORDER BY groups.creation_date DESC LIMIT $_PAGINATION->From, $_PAGINATION->To", false, [":USERNAME" => $_USER->Username]);


$_PAGE = [
    "Page"      => "my_groups",
    "Page_Type" => "my_groups",
    "Show_Search" => false,
    "new"         => true
];
require "_templates/_structures/main.php";

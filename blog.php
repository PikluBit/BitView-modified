<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

$Blog_Posts = $DB->execute("SELECT * FROM blog_posts ORDER BY submit_on DESC");
$Blog_Amount = is_array($Blog_Posts) ? count($Blog_Posts) : ($Blog_Posts ? 1 : 0);

$_PAGE = [
    "Page"      => "blog",
    "Page_Type" => "home",
    "Title"     => "BitView - Blog",
    "Show_Search" => true,
    "new"         => true
];
require "_templates/_structures/main.php";

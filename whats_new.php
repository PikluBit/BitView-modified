<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";


$Blog_Posts     = $DB->execute("SELECT * FROM blog_posts ORDER BY submit_on DESC");
$Blog_Amount    = $DB->Row_Num;


$_PAGE = [
    "Page"          => "blog",
    "Page_Type"     => "home"
];
require "_templates/_structures/main.php";
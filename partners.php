<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

    $TYPE_CONTENT = "WHERE is_partner = 1 AND is_banned = 0"; //directors
    $ORDER_BY = "subscribers DESC";

$Users = $DB->execute("SELECT * FROM users $TYPE_CONTENT ORDER BY $ORDER_BY LIMIT 6");

$_PAGE = [
    "Page"       => "partners",
    "Page_Type"  => "home",
    "Title"      => $LANGS['partnerprogram']
];
require "_templates/_structures/main.php";
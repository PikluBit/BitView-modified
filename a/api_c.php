<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

require $_SERVER['DOCUMENT_ROOT']."/404.php";
exit();

$Stats2 = $DB->execute("SELECT count(username) as all_users FROM users",true);
echo number_format($Stats2["all_users"]);
?>

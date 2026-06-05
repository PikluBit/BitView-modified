<script type="text/javascript">window.close();</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

require $_SERVER['DOCUMENT_ROOT']."/404.php";
exit();

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE MESSAGE ID
if (!$_USER->Logged_In)      { header("location: /"); exit(); }

$DB->modify("UPDATE users_messages SET seen = 1 WHERE for_user = :user_name", [":user_name" => $_USER->Username]);
?>
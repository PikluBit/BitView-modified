<script type="text/javascript">window.close();</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE MESSAGE ID
if (!$_USER->Logged_In)      { header("location: /"); exit(); }
if (!isset($_GET["id"]))      { header("location: /"); exit(); }

$DB->modify("UPDATE users_messages SET seen = 1 WHERE id = :ID AND for_user = :user_name", [":ID" => $_GET["id"], ":user_name" => $_USER->Username]);
?>
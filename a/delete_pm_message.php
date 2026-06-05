<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////USER MUST BE ADMIN OR MOD
////REQUIRE $_GET["id"]
if (!$_USER->Logged_In) { header("location: /login"); exit(); }
if (!isset($_GET["id"])) { header("location: /"); exit(); }
$ID = $_GET["id"];
$user_name = $_USER->Username;

$DB->modify("DELETE FROM users_messages WHERE id = :ID AND for_user = :USER",[':ID' => $ID, ':USER' => $user_name]);
notification($LANGS['messagedeleted'], $_SERVER["HTTP_REFERER"]); exit();

?>
<script type="text/javascript">history.back();</script>
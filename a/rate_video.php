<script type="text/javascript">window.close();</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["stars"]
////REQUIRE $_GET["v"]
if (!$_USER->Logged_In)      { header("location: /"); exit(); }
if (!isset($_GET["stars"]))  { header("location: /"); exit(); }
if (!isset($_GET["v"]))      { header("location: /"); exit(); }

$_VIDEO = new Video($_GET["v"],$DB);

if (!$_VIDEO->exists()) { header("location: /"); exit(); }

$_USER->rate_video($_VIDEO,$_GET["stars"]);
?>
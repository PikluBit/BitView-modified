 <script type="text/javascript">window.close();</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE LAYOUT
if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}
if (!isset($_GET['layout'])) {
    header("location: /");
    exit();
}

$_USER->get_info();

$Layout = $_GET['layout'];

$DB->modify("UPDATE users SET channel_new = :LAYOUT WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":LAYOUT" => $Layout]);
notification("Layout Changed!", '/user/'.$_USER->Username, "cfeeb2");
exit();
?>
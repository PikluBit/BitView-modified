<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////USER MUST BE ADMIN OR MOD
////REQUIRE $_GET["id"]
if (!$_USER->Logged_In) {
    header("location: /login");
    exit();
}
if (!isset($_GET["id"]) || mb_strlen((string) $_GET["id"]) > 11) {
    header("location: /");
    exit();
}

$Bulletin = $DB->execute("SELECT id,by_user FROM bulletins_new WHERE id = :ID", true, [":ID" => $_GET["id"]]);

if ($DB->Row_Num == 1) {
    $ID = $Bulletin["id"];
    $By = $Bulletin["by_user"];
    if ($By === $_USER->Username || $_USER->Is_Admin || $_USER->Is_Moderator) {
        $DB->modify("DELETE FROM bulletins_new WHERE id = :ID",[":ID" => $ID]);
    }
}
?>
<script type="text/javascript">window.close();</script>

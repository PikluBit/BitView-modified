<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////USER MUST BE ADMIN OR MOD
////REQUIRE $_GET["id"]
if (!$_USER->Logged_In)                                 { header("location: /login"); exit(); }
if (!isset($_GET["id"]) || mb_strlen((string) $_GET["id"]) > 11) { header("location: /"); exit();          }


$Comment = $DB->execute("SELECT bulletins_comments.id,bulletins_comments.by_user,bulletins.by_user as bulletin_owner FROM bulletins_comments INNER JOIN bulletins ON bulletins_comments.bulletin_id = bulletins.id WHERE bulletins_comments.id = :ID",true,[":ID" => $_GET["id"]]);

if ($DB->Row_Num == 1) {
    $ID = $Comment["id"];
    $By = $Comment["by_user"];
    $On = $Comment["bulletin_owner"];

    if ($By === $_USER->Username || $On === $_USER->Username || $_USER->Is_Admin || $_USER->Is_Moderator) {
        $DB->modify("DELETE FROM bulletins_comments WHERE id = :ID",[":ID" => $ID]);
    }
}
?>
<script type="text/javascript">window.close();</script>

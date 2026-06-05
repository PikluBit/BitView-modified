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


$Comment = $DB->execute("SELECT videos_comments.id, videos_comments.url, videos_comments.by_user, videos.uploaded_by FROM videos_comments INNER JOIN videos ON videos_comments.url = videos.url WHERE videos_comments.id = :ID", true, [":ID" => $_GET["id"]]);

if ($DB->Row_Num == 1) {
    $URL = $Comment["url"];
    $ID  = $Comment["id"];
    $By  = $Comment["uploaded_by"];
    $By_User  = $Comment["by_user"];

    if ($By === $_USER->Username || $By_User === $_USER->Username || $_USER->Is_Admin || $_USER->Is_Moderator) {
        $DB->modify("DELETE FROM videos_comments WHERE id = :ID",[":ID" => $ID]);
        $DB->modify("UPDATE videos SET comments = comments - 1 WHERE url = :URL",[":URL" => $URL]);
    }
}
?>
<script type="text/javascript">window.close();</script>

<script type="text/javascript">window.close();</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["id"]
////REQUIRE $_GET["like"]
if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}
if (!isset($_GET["id"])) {
    header("location: /");
    exit();
}
if (!isset($_GET["like"])) {
    header("location: /");
    exit();
}

$ID = $_GET['id'];
$Rating = $_GET['like'];
$User_Has_Voted = $DB->execute("SELECT rating FROM comment_votes WHERE id = :ID and by_user = :USERNAME", true, [":ID" => $ID, ":USERNAME" => $_USER->Username]);
if (!isset($User_Has_Voted['rating'])) {
    $User_Has_Voted['rating'] = 2;
}
if ($Rating == 0) {
    if ($User_Has_Voted['rating'] == 2) {
    $DB->modify("UPDATE videos_comments SET dislikes = dislikes + 1 WHERE id = :ID", [":ID" => $ID]);
    $DB->modify("INSERT IGNORE INTO comment_votes(id,by_user,rating) VALUES(:ID,:USERNAME,:RATING)", [":ID" => $ID, ":USERNAME" => $_USER->Username, ":RATING" => $Rating]);
    }
    elseif ($User_Has_Voted['rating'] != 0) {
    $DB->modify("UPDATE videos_comments SET dislikes = dislikes + 2 WHERE id = :ID", [":ID" => $ID]);
    $DB->modify("UPDATE comment_votes SET rating = :RATING WHERE id = :ID and by_user = :USERNAME", [":ID" => $ID, ":USERNAME" => $_USER->Username, ":RATING" => $Rating]);
    }
}
else {
    if ($User_Has_Voted['rating'] == 2) {
    $DB->modify("UPDATE videos_comments SET likes = likes + 1 WHERE id = :ID", [":ID" => $ID]);
    $DB->modify("INSERT IGNORE INTO comment_votes(id,by_user,rating) VALUES(:ID,:USERNAME,:RATING)", [":ID" => $ID, ":USERNAME" => $_USER->Username, ":RATING" => $Rating]);
    }
    elseif ($User_Has_Voted['rating'] != 1) {
    $DB->modify("UPDATE videos_comments SET likes = likes + 2 WHERE id = :ID", [":ID" => $ID]);
    $DB->modify("UPDATE comment_votes SET rating = :RATING WHERE id = :ID and by_user = :USERNAME", [":ID" => $ID, ":USERNAME" => $_USER->Username, ":RATING" => $Rating]);
    }
}

if ($User_Has_Voted['rating'] == $Rating) {
    if ($Rating == 0) {
    $DB->modify("UPDATE videos_comments SET dislikes = dislikes - 1 WHERE id = :ID", [":ID" => $ID]);
    $DB->modify("DELETE FROM comment_votes WHERE id = :ID AND by_user = :USERNAME", [":ID" => $ID, ":USERNAME" => $_USER->Username]);
    }
    else if ($Rating == 1) {
    $DB->modify("UPDATE videos_comments SET likes = likes - 1 WHERE id = :ID", [":ID" => $ID]);
    $DB->modify("DELETE FROM comment_votes WHERE id = :ID AND by_user = :USERNAME", [":ID" => $ID, ":USERNAME" => $_USER->Username]);
    }
}
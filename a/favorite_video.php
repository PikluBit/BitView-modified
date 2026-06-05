<?php if (isset($_GET["close"])) : ?><script type="text/javascript">window.close();</script><?php endif ?>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["v"]
if (!$_USER->Logged_In)                               { header("location: /login"); exit(); }
if (!isset($_GET["v"]) || mb_strlen((string) $_GET["v"]) > 11) { header("location: /"); exit();          }

$_VIDEO = new Video($_GET["v"],$DB);

if ($_USER->favorite_video($_VIDEO)) {
    if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
        if (strpos((string) $_SERVER['HTTP_REFERER'],"my_favorites")) { $Link = "/my_favorites"; }
        else                                                       { $Link = "/watch?v=".$_GET["v"]; }
    } else {
        $Link = "/watch?v=" . $_GET["v"];
    }
    if (!isset($_GET["close"])) {
        header("location: $Link");
        exit();
    }
}
?>

<?php if (isset($_GET["close"])) : ?><script type="text/javascript">window.close();</script><?php endif ?>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["user"]
if (!$_USER->Logged_In)                               { header("location: /login"); exit(); }
if (!isset($_GET["user"]))                            { header("location: /"); exit();          }

$_SUB = new User($_GET["user"],$DB);

$DB->execute("SELECT blocker FROM users_block WHERE (blocker = :USERNAME AND blocked = :OTHER) OR (blocker = :OTHER AND blocked = :USERNAME)", false,
                        [
                            ":USERNAME" => $_USER->Username,
                            ":OTHER"    => $_SUB->Username
                        ]);

if ($DB->Row_Num > 0) {
    notification("You can't subscribe to this channel because you are blocked!","/"); exit();
}

if ($_SUB->Username != $_USER->Username && $_SUB->exists() && strtoupper((string) $_SUB->Username) != strtoupper((string) $_USER->Username)) {
    $_USER->subscribe($_SUB);
}
if (!isset($_GET["close"])) {
    header("location: " . $_SERVER["HTTP_REFERER"]);
}
<script type="text/javascript">window.close();</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["key"]

if (!isset($_GET["key"])) {
    header("location: /");
    exit();
}
if ($_USER->get_info() && $_USER->Info['is_verified'] == 1) {
    header("location: /");
    exit();
}

$Banned_Accounts = $DB->execute("SELECT count(*) as amount FROM users WHERE ip_address = :IP AND is_banned = 1",true,
            [":IP" => $_USER->Info['ip_address']])["amount"];
        if ($Banned_Accounts >= 2) { $_USER->ban(); }

$CHECK = $DB->execute("SELECT * FROM email_verification WHERE username = :USERNAME", true, [":USERNAME" => $_USER->Username]);
if ($CHECK['vkey'] == $_GET['key']) {
    $DB->modify("DELETE FROM email_verification WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
    $DB->modify("UPDATE users SET is_verified = 1 WHERE username = :USERNAME;", [":USERNAME" => $_USER->Username]);
    notification("Email successfully verified!","/", "green"); exit();
}
else {
    notification("Email confirm link not valid!","/email_confirm"); exit();
}
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}

if ($_USER->get_info() && $_USER->Info['is_verified'] == 1) {
    header("location: /");
    exit();
}

function random_string($Characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", $Length = null){
    $charactersLength   = mb_strlen((string) $Characters);
    $randomString       = '';
    for ($i = 0; $i < $Length; $i++) {
        $randomString .= $Characters[mt_rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$Banned_Accounts = $DB->execute("SELECT count(*) as amount FROM users WHERE ip_address = :IP AND is_banned = 1",true,
            [":IP" => $_USER->Info['ip_address']])["amount"];
        if ($Banned_Accounts >= 2) { $_USER->ban(); }

if (isset($_GET['resend']) && $_GET['resend'] == 1) {
    $CHECK = $DB->execute("SELECT vdate FROM email_verification WHERE username = :USERNAME", true, [":USERNAME" => $_USER->Username])['vdate'];
    if(strtotime((string) $CHECK) > strtotime("-5 minutes")) {
        notification("Please wait 5 minutes to resend the verification email!","/email_confirm"); exit();
    }

    $VKEY = random_string("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_", 20);

    $DB->modify("DELETE FROM email_verification WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);

    $DB->modify("INSERT INTO email_verification(username,vkey,vdate) VALUES(:USERNAME,:VKEY,NOW())", [":USERNAME" => $_USER->Username, ":VKEY" => $VKEY]);

   /* $Emailer = new Email();
    $Emailer->To      = $_USER->Info['email'];
    $Emailer->To_Name = $_USER->Username;
    $Emailer->Subject = "Welcome to BitView";
    $Emailer->send_email('<h1><strong><a href="https://bitview.net/a/verify_email?key='.$VKEY.'">Confirm your email address</a> to start participating in the BitView community!</strong></h1><br><h1><strong>Thank You For Signing Up, '.$_USER->Username.'!</strong></h1><br><p>You&#39;ve taken the next step in becoming part of the BitView community. Now that you&#39;re a member, you can rate videos, post comments or upload your own videos to the site, you&#39;ll first need to <a href="https://bitview.net/a/verify_email?key='.$VKEY.'">confirm your email address</a>. If that link doesn&#39;t appear enter the following link into your browser:</p><p><a href="https://bitview.net/a/verify_email?key='.$VKEY.'">https://bitview.net/a/verify_email?key='.$VKEY.'</a></p>');

    notification("Confirmation email has been successfully resent!","/email_confirm", "green"); exit(); */
    notification("We currently disabled email verification. Please contact Bittoco support for more information.","/email_confirm", "red");
}

$_PAGE = [
    "Page"          => "email_confirm",
    "Page_Type"     => "browse"
];
require "_templates/_structures/main.php";

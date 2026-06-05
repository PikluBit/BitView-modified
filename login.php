<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST NOT BE LOGGED IN
////LOGIN MUST BE ENABLED
if ($_USER->Logged_In)          { header("location: /"); exit(); }
if (!$_CONFIG->Config["login"]) { header("location: /"); exit(); }

$Failed_Attempts = $DB->execute("SELECT count(*) as amount FROM failed_login_attempts WHERE ip_address = :IP AND date >= NOW() - INTERVAL 10 MINUTE",true, [":IP" => $_SESSION['ip']])["amount"];

if ($Failed_Attempts >= 3) {
    $captcha = $OG_POST["h-captcha-response"];
    $secretKey = "0x4AEC6A2B9b460aB43248ffB92e3D16ca9c456Ad0";

    $response = file_get_contents("https://api.hcaptcha.com/siteverify?secret=$secretKey&response=$captcha");
    $responseKeys = json_decode($response,true);

    if($responseKeys["success"]==true) {
       $captcha_solved = 1;
    } else {
       $captcha_solved = 0;
       //$captcha_solved = 1;
    }
}

if ($Failed_Attempts >= 5) {
    notification("You have made too many incorrect login attempts, please wait to try again.","/"); exit();
}

if (isset($_POST["log_in"])) {
    $_GUMP->validation_rules([
        "username"          => "required",
        "password"          => "required|max_len,20"
    ]);

    $_GUMP->filter_rules([
        "username"      => "trim",
        "password"      => "trim"
    ]);

    $Validation     = $_GUMP->run($OG_POST);

    if ($Validation && ($Failed_Attempts <= 3 || $captcha_solved == 1)) {
        $Username = $Validation["username"];
        $Password = $Validation["password"];
        $IP         = getenv('HTTP_CLIENT_IP')?: getenv('HTTP_X_FORWARDED_FOR')?: getenv('HTTP_X_FORWARDED')?: getenv('HTTP_FORWARDED_FOR')?: getenv('HTTP_FORWARDED')?: getenv('REMOTE_ADDR');

        $Banned_Accounts = $DB->execute("SELECT count(*) as amount FROM users WHERE ip_address = :IP AND is_banned = 1",true,
                                        [":IP" => $IP])["amount"];
        if ($Banned_Accounts >= 3) { notification($LANGS['notallowed'],"/watch?v=zB_AIBLdXsy"); exit(); }


        $User_Info = $DB->execute("SELECT username, password,failed_login_attempt,ip_address FROM users WHERE username = :USERNAME OR email = :USERNAME",
                                  true,
                                  [":USERNAME" => $Username]);

        if ($DB->Row_Num === 1) {
            $User_Username = $User_Info["username"];
            $Password_Hash = $User_Info["password"];
            $Attempt_Ago   = time() - strtotime((string) $User_Info["failed_login_attempt"]);
            if ($Attempt_Ago >= 3 && password_verify((string) $Password,(string) $Password_Hash) && $_USER->log_in($User_Username)) {
                if (isset($_POST["remember_me"]) && $_POST["remember_me"] == "on") {
                $rememberKey = bin2hex(random_bytes(32));
                $DB->modify("INSERT INTO remember_me(userid, userkey, createDate) VALUES (:USERID, :KEY, NOW())", [":USERID" => $_SESSION["username"], ":KEY" => $rememberKey]);
                setcookie("remember", $rememberKey, ['expires' => time() + 86400 * 30, 'path' => "/"]); // Set the cookie to expire in 7 days
                }
                    if (isset($_GET["next"])) { header("Location: ".$_GET['next']); }
                    else { header("Location: /"); }
                    exit();
            } else {
                $Update = $DB->modify("UPDATE users SET failed_login_attempt = NOW() WHERE username = :USERNAME",
                                      [":USERNAME" => $User_Username]);
                if ($IP != $User_Info['ip_address']) {
                    $DB->modify("UPDATE users SET failed_login_ip = :IP WHERE username = :USERNAME", [":IP" => $IP, ":USERNAME" => $User_Username]);
                }
                $DB->modify("INSERT IGNORE INTO failed_login_attempts (ip_address,attempted_username,date) VALUES (:IP,:USERNAME,NOW())",[":IP" => $_SESSION["ip"],":USERNAME" => $User_Username]);
                notification($LANGS['wrongpassword'],"/login");
            }
        }
    }
}

$_PAGE = [
    "Page"          => "login",
    "Page_Type"     => "home",
    "Header"        => 2,
    "Title"    => $LANGS['signintitle']
];

require "_templates/_structures/main.php";
?>
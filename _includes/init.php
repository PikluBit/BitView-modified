<?php
    error_reporting(0);

// Load composer packages
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

// Custom GUMP validators & filters
GUMP::add_validator('NoHTML', function($field, $input, $param = NULL) {
    if (!mb_strpos((string) $input[$field],"<") and !mb_strpos((string) $input[$field],">")) {
        return true;
    } else {
        return false;
    }
}, 'The {field} must not contain any HTML elements.');
GUMP::add_filter('NoHTML', fn($value, $params = NULL) => str_replace("<","&lt;",str_replace(">","&gt;",$value)));

//if (!isset($_COOKIE["maintenance"])) { require_once $_SERVER['DOCUMENT_ROOT']."/_templates/_errors/maintenance.php"; die(); }

/* ========================================================================
	SANITIZE ALL USER INPUT, NO EXCEPTIONS!!!! (ALI's UGLY PATCH START)
==========================================================================*/

// Sanitize GET requests
$OG_GET = $_GET;
if (isset($_GET)) {
	foreach($_GET as $k => $v) {
		$_GET[$k] = htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
	}
}

// Sanitize POST requests
$OG_POST = $_POST;
if (isset($_POST)) {
	foreach($_POST as $k => $v) {
		$_POST[$k] = htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
	}
}

// Prevent requests unless they come from CloudFlare
if (!isset($_SERVER['TERM'])) {
	if (!isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
		die();
	}
}


/* ========================================================================
	SANITIZE ALL USER INPUT, NO EXCEPTIONS!!!! (ALI's UGLY PATCH END)
==========================================================================*/

//LOAD LANGUAGE FILES
if (isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE["lang"].".lang.php")) {
  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE["lang"] . ".lang.php";
  $LangCode = $_COOKIE["lang"];
}
elseif (!isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5) . ".lang.php")) {
  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5) . ".lang.php";
  $LangCode = substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);
}
elseif (!isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) . ".lang.php")) {
  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2).".lang.php";
  $LangCode = substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
}
else {
  include $_SERVER['DOCUMENT_ROOT'] . "/lang/en-US.lang.php";
  $LangCode = 'en-US';
}

//AUTOLOAD CLASSES
spl_autoload_register(function ($class): void {
    include '_classes/' . str_replace("\\", '/', $class) . '.class.php'; 
});

require_once $_SERVER['DOCUMENT_ROOT']."/_includes/functions.php";

$DB = new DB(true);
if (!$DB) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 503 Service Unavailable', true, 503);
    die("Database Error");
}

session_start([
    "cookie_lifetime" => 0,
    "gc_maxlifetime"  => 172800
]);

$_GUMP      = new GUMP();

$_SESSION['ip'] = getenv('HTTP_CLIENT_IP') ?: getenv('HTTP_X_FORWARDED_FOR') ?: getenv('HTTP_X_FORWARDED') ?: getenv('HTTP_FORWARDED_FOR') ?: getenv('HTTP_FORWARDED') ?: getenv('REMOTE_ADDR');

if (isset($_COOKIE["remember"]) && !isset($_SESSION["username"])) {
    $rememberKey = $_COOKIE["remember"];
    $rememberMeRow = $DB->execute("SELECT * FROM remember_me WHERE userkey = :CURRENTKEY AND createDate > NOW() - INTERVAL 30 DAY",true,[":CURRENTKEY" => $rememberKey]);
	
    if ($rememberMeRow) {
        $_SESSION["username"] = $rememberMeRow["userid"];
        $DB->modify("UPDATE users SET ip_address = :IP, last_login = NOW() WHERE username = :USERNAME", [":IP" => $_SESSION["ip"], ":USERNAME" => $_SESSION["username"]]);
    }
}

if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
    $USERNAME = $_SESSION["username"];
} else {
    $USERNAME = "";
}

$_USER = new User($USERNAME, $DB, true);
if ($USERNAME) { $isVerfied = $DB->execute("SELECT is_verified FROM users WHERE username = :USERNAME",true,[":USERNAME" => $USERNAME])['is_verified']; } else { $isVerfied = 1; }
unset($USERNAME);

$_CONFIG = new Config();
if ($isVerfied != 1 && !str_starts_with((string) $_SERVER['REQUEST_URI'], '/email_confirm') && !str_starts_with((string) $_SERVER['REQUEST_URI'], '/a/verify_email')) { header('location: /email_confirm'); }

date_default_timezone_set('Europe/Berlin');

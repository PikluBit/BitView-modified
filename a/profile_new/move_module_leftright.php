<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["module"] AND $_GET["direction"]
if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}
if (!isset($_GET["module"])) {
    header("location: /");
    exit();
}
if (!isset($_GET["direction"])) {
    header("location: /");
    exit();
}

function array_swap(&$array,$swap_a,$swap_b){
   [$array[$swap_a], $array[$swap_b]] = [$array[$swap_b],$array[$swap_a]];
}

function make_links_clickable($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Z?-??-?()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', (string) $text);
}

$_USER->get_info();
$_PROFILE = new User($_GET["channel"],$DB);
$_PROFILE->get_info();

$Moved_Module = $_GET['module'];
$Direction = $_GET['direction'];

if ($Moved_Module == "comments") {
$Comments = $DB->execute("SELECT * FROM channel_comments WHERE on_channel = :USERNAME ORDER BY submit_date DESC LIMIT 10", false, [":USERNAME" => $_PROFILE->Username]);
$Page_Amount = $_PROFILE->Info["channel_comments"] / 10;
if (is_float($Page_Amount)) { $Page_Amount = (int)$Page_Amount + 1; }
}

if ($Moved_Module == "recent_activity") {
//BULLETINS
$SELECT = "SELECT 'bulletin' as type_name, id, content, url as rating, submit_date as date, content as title FROM bulletins_new WHERE by_user = :OWNER";
//COMMENTS
$SELECT .= " UNION ALL SELECT 'comment' as type_name, videos.url, videos_comments.content, '' as rating, videos_comments.submit_on as date, videos.title as title FROM videos_comments INNER JOIN videos ON videos_comments.url = videos.url WHERE by_user = :OWNER AND videos.status = 2 AND videos.privacy = 1";
//RATINGS
$SELECT .= " UNION ALL SELECT 'rating' as type_name, videos.url, videos.description as comment, rating as rating, videos_ratings.submit_date as date, videos.title as title FROM videos_ratings INNER JOIN videos on videos_ratings.url = videos.url WHERE username = :OWNER AND videos.status = 2 AND videos.privacy = 1";
//FAVORITES
$SELECT .= " UNION ALL SELECT 'favorite' as type_name, videos.url, videos.description as comment, '' as rating, videos_favorites.submit_on as date, videos.title as title FROM videos_favorites INNER JOIN videos ON videos_favorites.url = videos.url WHERE username = :OWNER AND videos.status = 2 AND videos.privacy = 1";
//UPLOADS
$SELECT .= " UNION ALL SELECT 'uploaded' as type_name, url, description as comment, '' as rating, uploaded_on as date, title as title FROM videos WHERE uploaded_by = :OWNER AND videos.status = 2 AND videos.privacy = 1";
//SUBSCRIPTIONS
$SELECT .= " UNION ALL SELECT 'subscription' as type_name, subscriber, subscription, '' as rating, submit_date as date, '' as title FROM subscriptions WHERE subscriber = :OWNER";
//FRIENDS
$SELECT .= " UNION ALL SELECT 'friend' as type_name, friend_1, friend_2, '' as rating, submit_on as date, '' as title FROM users_friends WHERE (friend_1 = :OWNER OR friend_2 = :OWNER) AND status = 1";

$Recent_Activity = $DB->execute("$SELECT ORDER BY date DESC LIMIT 5", false, [":OWNER" => $_PROFILE->Username]);

}

if ($_GET['module'] == "hubber_links") {
    $Moved_Module = "otherchannels";
}
if ($_GET['module'] == "branding") {
    $Moved_Module = "custombox";
}
if ($_GET['module'] == "recent_activity") {
    $Moved_Module = "recentactivity";
}

if ($_GET['direction'] == "left") {
    $Modules = explode(",", (string) $_USER->Info['c_modules_r']);
    $Modules_2 = explode(",", (string) $_USER->Info['c_modules_l']);
}
else {
    $Modules = explode(",", (string) $_USER->Info['c_modules_l']);  
    $Modules_2 = explode(",", (string) $_USER->Info['c_modules_r']);
}

$Position = array_search($Moved_Module, $Modules);
array_splice($Modules, $Position, 1);
array_unshift($Modules_2, $Moved_Module);
$Modules = array_filter($Modules);
$Modules_2 = array_filter($Modules_2);
$Modules_Final = implode(",", $Modules);
$Modules_2_Final = implode(",", $Modules_2);

$Modules_L = explode(",", (string) $_PROFILE->Info['c_modules_l']);
$Modules_R = explode(",", (string) $_PROFILE->Info['c_modules_r']);

if ($_GET['direction'] == "left" && !in_array($Moved_Module, $Modules_L)) {
    $DB->modify("UPDATE users SET c_modules_l = :MODULES WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":MODULES" => $Modules_2_Final]);
    $DB->modify("UPDATE users SET c_modules_r = :MODULES WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":MODULES" => $Modules_Final]);
}
elseif ($_GET['direction'] == "right" && !in_array($Moved_Module, $Modules_R)) {
    $DB->modify("UPDATE users SET c_modules_l = :MODULES WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":MODULES" => $Modules_Final]);
    $DB->modify("UPDATE users SET c_modules_r = :MODULES WHERE username = :USERNAME", [":USERNAME" => $_USER->Username, ":MODULES" => $Modules_2_Final]);
}

if ($Direction == "left") {
$Moved_Module .= "_l";
}
if ($Direction == "right") {
$Moved_Module .= "_r";
}

$Modules_L = explode(",", (string) $_PROFILE->Info['c_modules_l']);
$Modules_R = explode(",", (string) $_PROFILE->Info['c_modules_r']);

?>

<?php if ($Moved_Module == "comments_l" || $Moved_Module == "comments_r" || $Moved_Module == "custombox_l" || $Moved_Module == "custombox_r" || $Moved_Module == "friends_l" || $Moved_Module == "friends_r" || $Moved_Module == "otherchannels_l" || $Moved_Module == "otherchannels_r" || $Moved_Module == "recentactivity_l" || $Moved_Module == "recentactivity_r" || $Moved_Module == "subscribers_l" || $Moved_Module == "subscribers_r" || $Moved_Module == "subscriptions_l" || $Moved_Module == "subscriptions_r" || $Moved_Module == "blips_l" || $Moved_Module == "blips_r"):?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/_templates/_profile/profile_modules/".$Moved_Module.".php" ?>
<?php endif ?>
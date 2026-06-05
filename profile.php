<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////"$_GET["user"]" MUST NOT BE LOGGED
////"_GET["page"]" MUST EITHER BE EMPTY OR ONE OF THOSE VALUES
if (!isset($_GET["user"])) { header("location: /"); exit(); }
if (!$_CONFIG->Config["profiles"])    { notification($LANGS['profilesdisabled'],"/"); exit(); }

$_PROFILE = new User($_GET["user"],$DB);
$_INBOX = new Inbox($_USER,$DB);

if ($_USER->Logged_In) { $Flagged = $_USER->has_flagged_user($_PROFILE->Username); }
else                   { $Flagged = false; }

function make_links_clickable($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Z?-??-?()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', (string) $text);
}
if ($_PROFILE->get_info() !== false && (!$_PROFILE->is_banned() || $_USER->Is_Admin || $_USER->Is_Moderator)) {
if ($_PROFILE->is_banned()) { notification($LANGS['channelsuspended'], false); }
if (isset($_GET["page"]) && $_GET["page"] !== "friends" && $_GET["page"] !== "subscriptions" && $_GET["page"] !== "subscribers") { 
    header("location: /"); 
    exit(); 
}

if(!empty($_PROFILE->Info['moved_to'])) {
    header("Location: /user/".$_PROFILE->Info['moved_to']);
    die($_PROFILE->Info['moved_to']);
}
if ($_USER->Logged_In && $_USER->Username !== $_PROFILE->Username) {
    $Friend_Status = $_USER->is_friends_with($_PROFILE);

    if ($Friend_Status !== false) {
        $Friend_ID = $Friend_Status["id"];
        $Friend_1  = $Friend_Status["friend_1"];
        $Friend_Status = $Friend_Status["status"];
    }
}

$Modules_L = explode(",", (string) $_PROFILE->Info['c_modules_l']);
$Modules_R = explode(",", (string) $_PROFILE->Info['c_modules_r']);

$Channel_Type = [0 => $LANGS['type0'], 1 => $LANGS['type1'], 2 => $LANGS['type2'], 3 => $LANGS['type3'], 4 => $LANGS['type4'], 5 => $LANGS['type5'], 6 => $LANGS['type6']];
$Honor_Type = [0 => $LANGS['type0'], 1 => $LANGS['type1p'], 2 => $LANGS['type2p'], 3 => $LANGS['type3p'], 4 => $LANGS['type4p'], 5 => $LANGS['type5p'], 6 => $LANGS['type6p']];
$Channel_Country  = ['AF' => $LANGS['cat_AF'], 'AX' => $LANGS['cat_AX'], 'AL' => $LANGS['cat_AL'], 'DZ' => $LANGS['cat_DZ'], 'AS' => $LANGS['cat_AS'], 'AD' => $LANGS['cat_AD'], 'AO' => $LANGS['cat_AO'], 'AI' => $LANGS['cat_AI'], 'AQ' => $LANGS['cat_AQ'], 'AG' => $LANGS['cat_AG'], 'AR' => $LANGS['cat_AR'], 'AM' => $LANGS['cat_AM'], 'AW' => $LANGS['cat_AW'], 'AU' => $LANGS['cat_AU'], 'AT' => $LANGS['cat_AT'], 'AZ' => $LANGS['cat_AZ'], 'BS' => $LANGS['cat_BS'], 'BH' => $LANGS['cat_BH'], 'BD' => $LANGS['cat_BD'], 'BB' => $LANGS['cat_BB'], 'BY' => $LANGS['cat_BY'], 'BE' => $LANGS['cat_BE'], 'BZ' => $LANGS['cat_BZ'], 'BJ' => $LANGS['cat_BJ'], 'BM' => $LANGS['cat_BM'], 'BT' => $LANGS['cat_BT'], 'BO' => $LANGS['cat_BO'], 'BQ' => $LANGS['cat_BQ'], 'BA' => $LANGS['cat_BA'], 'BW' => $LANGS['cat_BW'], 'BV' => $LANGS['cat_BV'], 'BR' => $LANGS['cat_BR'], 'IO' => $LANGS['cat_IO'], 'VG' => $LANGS['cat_VG'], 'BN' => $LANGS['cat_BN'], 'BG' => $LANGS['cat_BG'], 'BF' => $LANGS['cat_BF'], 'BI' => $LANGS['cat_BI'], 'KH' => $LANGS['cat_KH'], 'CM' => $LANGS['cat_CM'], 'CA' => $LANGS['cat_CA'], 'CV' => $LANGS['cat_CV'], 'KY' => $LANGS['cat_KY'], 'CF' => $LANGS['cat_CF'], 'TD' => $LANGS['cat_TD'], 'CL' => $LANGS['cat_CL'],'CN'=> $LANGS['cat_CN'], 'CX' => $LANGS['cat_CX'], 'CC' => $LANGS['cat_CC'], 'CO' => $LANGS['cat_CO'], 'KM' => $LANGS['cat_KM'], 'CK' => $LANGS['cat_CK'], 'CR' => $LANGS['cat_CR'], 'HR' => $LANGS['cat_HR'], 'CU' => $LANGS['cat_CU'], 'CW' => $LANGS['cat_CW'], 'CY' => $LANGS['cat_CY'], 'CZ' => $LANGS['cat_CZ'], 'CD' => $LANGS['cat_CD'], 'DK' => $LANGS['cat_DK'], 'DJ' => $LANGS['cat_DJ'], 'DM' => $LANGS['cat_DM'], 'DO' => $LANGS['cat_DO'], 'TL' => $LANGS['cat_TL'], 'EC' => $LANGS['cat_EC'], 'EG' => $LANGS['cat_EG'], 'SV' => $LANGS['cat_SV'], 'GQ' => $LANGS['cat_GQ'], 'ER' => $LANGS['cat_ER'], 'EE' => $LANGS['cat_EE'], 'ET' => $LANGS['cat_ET'], 'FK' => $LANGS['cat_FK'], 'FO' => $LANGS['cat_DO'], 'FJ' => $LANGS['cat_FJ'], 'FI' => $LANGS['cat_FI'], 'FR' => $LANGS['cat_FR'], 'GF' => $LANGS['cat_GF'], 'PF' => $LANGS['cat_PF'], 'TF' => $LANGS['cat_TF'], 'GA' => $LANGS['cat_GA'], 'GM' => $LANGS['cat_GM'], 'GE' => $LANGS['cat_GE'], 'DE' => $LANGS['cat_DE'], 'GH' => $LANGS['cat_GH'], 'GI' => $LANGS['cat_GI'], 'GR' => $LANGS['cat_GR'], 'GL' => $LANGS['cat_GL'], 'GD' => $LANGS['cat_GD'], 'GP' => $LANGS['cat_GP'], 'GU' => $LANGS['cat_GU'], 'GT' => $LANGS['cat_GT'], 'GG' => $LANGS['cat_GG'], 'GN' => $LANGS['cat_GN'], 'GW' => $LANGS['cat_GW'], 'GY' => $LANGS['cat_GY'], 'HT' => $LANGS['cat_HT'], 'HM' => $LANGS['cat_HM'], 'HN' => $LANGS['cat_HN'], 'HK' => $LANGS['cat_HK'], 'HU' => $LANGS['cat_HU'], 'IS' => $LANGS['cat_IS'], 'IN' => $LANGS['cat_IN'], 'ID' => $LANGS['cat_ID'], 'IR' => $LANGS['cat_IR'], 'IQ' => $LANGS['cat_IQ'], 'IE' => $LANGS['cat_IE'], 'IM' => $LANGS['cat_IM'], 'IL' => $LANGS['cat_IL'], 'IT' => $LANGS['cat_IT'], 'CI' => $LANGS['cat_CI'], 'JM' => $LANGS['cat_JM'], 'JP' => $LANGS['cat_JP'], 'JE' => $LANGS['cat_JE'], 'JO' => $LANGS['cat_JO'], 'KZ' => $LANGS['cat_KZ'], 'KE' => $LANGS['cat_KE'], 'KI' => $LANGS['cat_KI'], 'XK' => $LANGS['cat_XK'], 'KW' => $LANGS['cat_KW'], 'KG' => $LANGS['cat_KG'], 'LA' => $LANGS['cat_LA'], 'LV' => $LANGS['cat_LV'], 'LB' => $LANGS['cat_LB'], 'LS' => $LANGS['cat_LS'], 'LR' => $LANGS['cat_LR'], 'LY' => $LANGS['cat_LY'], 'LI' => $LANGS['cat_LI'], 'LT' => $LANGS['cat_LT'], 'LU' => $LANGS['cat_LU'], 'MO' => $LANGS['cat_MO'], 'MK' => $LANGS['cat_MK'], 'MG' => $LANGS['cat_MG'], 'MW' => $LANGS['cat_MW'], 'MY' => $LANGS['cat_MY'], 'MV' => $LANGS['cat_MV'], 'ML' => $LANGS['cat_ML'], 'MT' => $LANGS['cat_MT'], 'MH' => $LANGS['cat_MH'], 'MQ' => $LANGS['cat_MQ'], 'MR' => $LANGS['cat_MR'], 'MU' => $LANGS['cat_MU'], 'YT' => $LANGS['cat_YT'], 'MX' => $LANGS['cat_MX'], 'FM' => $LANGS['cat_FM'], 'MD' => $LANGS['cat_MD'], 'MC' => $LANGS['cat_MC'], 'MN' => $LANGS['cat_MN'], 'ME' => $LANGS['cat_ME'], 'MS' => $LANGS['cat_MS'], 'MA' => $LANGS['cat_MA'], 'MZ' => $LANGS['cat_MZ'], 'MM' => $LANGS['cat_MM'], 'NA' => $LANGS['cat_NA'], 'NR' => $LANGS['cat_NR'], 'NP' => $LANGS['cat_NP'], 'NL' => $LANGS['cat_NL'], 'NC' => $LANGS['cat_NC'], 'NZ' => $LANGS['cat_NZ'], 'NI' => $LANGS['cat_NI'], 'NE' => $LANGS['cat_NE'], 'NG' => $LANGS['cat_NG'], 'NU' => $LANGS['cat_NU'], 'NF' => $LANGS['cat_NF'], 'KP' => $LANGS['cat_KP'], 'MP' => $LANGS['cat_MP'], 'NO' => $LANGS['cat_NO'], 'OM' => $LANGS['cat_OM'], 'PK' => $LANGS['cat_PK'], 'PW' => $LANGS['cat_PW'], 'PS' => $LANGS['cat_PS'], 'PA' => $LANGS['cat_PA'], 'PG' => $LANGS['cat_PG'], 'PY' => $LANGS['cat_PY'], 'PE' => $LANGS['cat_PE'], 'PH' => $LANGS['cat_PH'], 'PN' => $LANGS['cat_PN'], 'PL' => $LANGS['cat_PL'], 'PT' => $LANGS['cat_PT'], 'PR' => $LANGS['cat_PR'], 'QA' => $LANGS['cat_QA'], 'CG' => $LANGS['cat_CG'], 'RE' => $LANGS['cat_RE'], 'RO' => $LANGS['cat_RO'], 'RU' => $LANGS['cat_RU'], 'RW' => $LANGS['cat_RW'], 'BL' => $LANGS['cat_BL'], 'SH' => $LANGS['cat_SH'], 'KN' => $LANGS['cat_KN'], 'LC' => $LANGS['cat_LC'], 'MF' => $LANGS['cat_MF'], 'PM' => $LANGS['cat_PM'], 'VC' => $LANGS['cat_VC'], 'WS' => $LANGS['cat_WS'], 'SM' => $LANGS['cat_SM'], 'ST' => $LANGS['cat_ST'], 'SA' => $LANGS['cat_SA'], 'SN' => $LANGS['cat_SN'], 'RS' => $LANGS['cat_RS'], 'SC' => $LANGS['cat_SC'], 'SL' => $LANGS['cat_SL'], 'SG' => $LANGS['cat_SG'], 'SX' => $LANGS['cat_SX'], 'SK' => $LANGS['cat_SK'], 'SI' => $LANGS['cat_SI'], 'SB' => $LANGS['cat_SB'], 'SO' => $LANGS['cat_SO'], 'ZA' => $LANGS['cat_ZA'], 'GS' => $LANGS['cat_GS'], 'KR' => $LANGS['cat_KR'], 'SS' => $LANGS['cat_SS'], 'ES' => $LANGS['cat_ES'], 'LK' => $LANGS['cat_LK'], 'SD' => $LANGS['cat_SD'], 'SR' => $LANGS['cat_SR'], 'SJ' => $LANGS['cat_SJ'], 'SZ' => $LANGS['cat_SZ'], 'SE' => $LANGS['cat_SE'], 'CH' => $LANGS['cat_CH'], 'SY' => $LANGS['cat_SY'], 'TW' => $LANGS['cat_TW'], 'TJ' => $LANGS['cat_TJ'], 'TZ' => $LANGS['cat_TZ'], 'TH' => $LANGS['cat_TH'], 'TG' => $LANGS['cat_TG'], 'TK' => $LANGS['cat_TK'], 'TO' => $LANGS['cat_TO'], 'TT' => $LANGS['cat_TT'], 'TN' => $LANGS['cat_TN'], 'TR' => $LANGS['cat_TR'], 'TM' => $LANGS['cat_TM'], 'TC' => $LANGS['cat_TC'], 'TV' => $LANGS['cat_TV'], 'VI' => $LANGS['cat_VI'], 'UG' => $LANGS['cat_UG'], 'UA' => $LANGS['cat_UA'], 'AE' => $LANGS['cat_AE'], 'GB' => $LANGS['cat_GB'], 'US' => $LANGS['cat_US'], 'UY' => $LANGS['cat_UY'], 'UZ' => $LANGS['cat_UZ'], 'VU' => $LANGS['cat_VU'], 'VA' => $LANGS['cat_VA'], 'VE' => $LANGS['cat_VE'], 'VN' => $LANGS['cat_VN'], 'WF' => $LANGS['cat_WF'], 'EH' => $LANGS['cat_EH'], 'YE' => $LANGS['cat_YE'], 'ZM' => $LANGS['cat_ZM'], 'ZW' => $LANGS['cat_ZW']];

$Country = $_PROFILE->Info["i_country"];

$Honor_Count = 0;

$honor_type[0] = "subscribers";             $honor_type['lang'][0] = " - ". $LANGS['mostsub'];
$honor_type[1] = "video_views";             $honor_type['lang'][1] = " - ".$LANGS['mostviewed'];

$honor_date[0] = "";                        $honor_date['lang'][0] = " (". $LANGS['alltime'] .")";
$honor_date[1] = "_day";                    $honor_date['lang'][1] = " (". $LANGS['timetoday'] .")";
$honor_date[2] = "_week";                   $honor_date['lang'][2] = " (". $LANGS['timeweek'] .")";
$honor_date[3] = "_month";                  $honor_date['lang'][3] = " (". $LANGS['timemonth'] .")";

$honor_variable[0] = "";                    $honor_variable['lang'][0] = "";
$honor_variable[1] = "_country";            $honor_variable['lang'][1] = " - ". $Channel_Country[$_PROFILE->Info["i_country"]];
$honor_variable[2] = "_category";           $honor_variable['lang'][2] = " - ". $Honor_Type[$_PROFILE->Info["type"]];
$honor_variable[3] = "_country_category";   $honor_variable['lang'][3] = " - ". $Honor_Type[$_PROFILE->Info["type"]] . " - ". $Channel_Country[$_PROFILE->Info["i_country"]];
$honor_variable[4] = "_partner";            $honor_variable['lang'][4] = " - Partners";
$honor_variable[5] = "_country_partner";    $honor_variable['lang'][5] = " - Partners - ". $Channel_Country[$_PROFILE->Info["i_country"]];

for ($i = 0; $i < 2; $i++) {
    for ($j = 0; $j < 4; $j++) {
        for ($k = 0; $k < 6; $k++) {
            if ($k == 0) {
                $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] = $DB->execute("SELECT 1 + (SELECT count( * ) FROM users a WHERE a.". $honor_type[$i].$honor_date[$j] ." > b.". $honor_type[$i].$honor_date[$j] ." AND is_banned = 0) AS rank FROM users b WHERE username = :USERNAME AND is_banned = 0 ORDER BY rank LIMIT 1 ;",true,[":USERNAME" => $_PROFILE->Username])["rank"];
                if ($Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] <= 50) { $Honor_Count++; }
                if ($Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] == '') { $Honor_Count -= 1; $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] = 100; }
            }
            elseif ($k == 1) {
                $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] = $DB->execute("SELECT 1 + (SELECT count( * ) FROM users a WHERE a.". $honor_type[$i].$honor_date[$j] ." > b.". $honor_type[$i].$honor_date[$j] ." AND is_banned = 0 AND a.i_country = b.i_country) AS rank FROM users b WHERE username = :USERNAME AND i_country = :COUNTRY AND i_country <> '' AND is_banned = 0 ORDER BY rank LIMIT 1 ;",true,[":USERNAME" => $_PROFILE->Username, ":COUNTRY" => $Country])["rank"];
                if ($Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] <= 50) { $Honor_Count++; }
                if ($Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] == '') { $Honor_Count -= 1; $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] = 100; }
            }
            elseif ($k == 2) {
                $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] = $DB->execute("SELECT 1 + (SELECT count( * ) FROM users a WHERE a.". $honor_type[$i].$honor_date[$j] ." > b.". $honor_type[$i].$honor_date[$j] ." AND is_banned = 0 AND a.type = b.type) AS rank FROM users b WHERE username = :USERNAME AND i_country = :COUNTRY AND i_country <> '' AND is_banned = 0 ORDER BY rank LIMIT 1 ;",true,[":USERNAME" => $_PROFILE->Username, ":COUNTRY" => $Country])["rank"];
                if ($Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] <= 50) { $Honor_Count++; }
                if ($Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] == '') { $Honor_Count -= 1; $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] = 100; }
            }
            elseif ($k == 3) {
                $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] = $DB->execute("SELECT 1 + (SELECT count( * ) FROM users a WHERE a.". $honor_type[$i].$honor_date[$j] ." > b.". $honor_type[$i].$honor_date[$j] ." AND is_banned = 0 AND a.i_country = b.i_country AND a.type = b.type) AS rank FROM users b WHERE username = :USERNAME AND i_country = :COUNTRY AND i_country <> '' AND is_banned = 0 ORDER BY rank LIMIT 1 ;",true,[":USERNAME" => $_PROFILE->Username, ":COUNTRY" => $Country])["rank"];
                if ($Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] <= 50) { $Honor_Count++; }
                if ($Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] == '') { $Honor_Count -= 1; $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] = 100; }
            }
            elseif ($k == 4) {
                $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] = $DB->execute("SELECT 1 + (SELECT count( * ) FROM users a WHERE a.". $honor_type[$i].$honor_date[$j] ." > b.". $honor_type[$i].$honor_date[$j] ." AND is_banned = 0 AND is_partner = 1) AS rank FROM users b WHERE username = :USERNAME AND is_partner = 1 AND is_banned = 0 ORDER BY rank LIMIT 1 ;",true,[":USERNAME" => $_PROFILE->Username])["rank"] ?? '';
                if ($_PROFILE->Info["is_partner"] and $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] <= 50) { $Honor_Count++; }
                if ($Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] == '') { $Honor_Count -= 1; $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] = 100; }
            }
            else {
                $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] = $DB->execute("SELECT 1 + (SELECT count( * ) FROM users a WHERE a.". $honor_type[$i].$honor_date[$j] ." > b.". $honor_type[$i].$honor_date[$j] ." AND is_banned = 0 AND is_partner = 1) AS rank FROM users b WHERE username = :USERNAME AND is_partner = 1 AND is_banned = 0 ORDER BY rank LIMIT 1 ;",true,[":USERNAME" => $_PROFILE->Username])["rank"] ?? '';
                if ($_PROFILE->Info["is_partner"] and $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] <= 50) { $Honor_Count++; }
                if ($Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] == '') { $Honor_Count -= 1; $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['rank'] = 100; }
            }

            $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['text'] = $honor_type['lang'][$i].$honor_date['lang'][$j].$honor_variable['lang'][$k];

            $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['href'] = "/channels?";
            if ($i == 0) { $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['href'] .= "order=subscribers"; }

            if ($j == 0) { $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['href'] .= "&date=d"; }
            if ($j == 1) { $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['href'] .= "&date=w"; }
            if ($j == 2) { $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['href'] .= "&date=m"; }
            if ($j == 3) { $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['href'] .= "&date=a"; }

            if ($k == 1 || $k == 5) { $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['href'] .= "&gl=". $_PROFILE->Info["i_country"]; }
            if ($k == 2) { $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['href'] .= "&type=". $_PROFILE->Info["type"]; }
            if ($k == 3) { $Ranking[$honor_type[$i].$honor_date[$j].$honor_variable[$k]]['href'] .= "&type=". $_PROFILE->Info["type"] . "&gl=". $_PROFILE->Info["i_country"]; }
        }
    }
}

$Profile_Info = explode(",", (string) $_PROFILE->Info['i_info']);

$Can_Watch_Private = false;
if (!isset($_GET["page"])) {

    $Videos = new Videos($DB,$_PROFILE);
    $Videos->WHERE_P      = ["videos.uploaded_by" => $_PROFILE->Username];
    $Videos->ORDER_BY     = "videos.uploaded_on DESC";
    $Videos->LIMIT        = 3;
    $Videos->Banned_Users = true;
    $Videos->get();

    //GET USERS PLAYLISTS
    $Playlists = $DB->execute("SELECT * FROM playlists WHERE by_user = :USERNAME ORDER BY title ASC LIMIT 3",false,[":USERNAME" => $_PROFILE->Username],false);
    $Playlists_Amount = $DB->execute("SELECT count(*) as amount FROM playlists WHERE by_user = :USERNAME",true,[":USERNAME" => $_PROFILE->Username],false)['amount'];

    //GET USERS FAVORITES FOR HOMEPAGE
    $FavVideos = $DB->execute("SELECT * FROM videos RIGHT JOIN videos_favorites ON videos_favorites.url = videos.url WHERE videos_favorites.username = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL ORDER BY videos_favorites.submit_on DESC LIMIT 3",false,[":USERNAME" => $_PROFILE->Username],false);
    
    //GET PAGE AMOUNT
    $Videos_Page_Amount = $_PROFILE->Info["videos"] / 10;
    
    //ALSO GET ONE LATEST VIDEO
    if (!empty($_PROFILE->Info['c_featured_video'])) {
        $LatVideoURL = $_PROFILE->Info['c_featured_video'];
        $LatVideo = $DB->execute("SELECT * FROM videos WHERE url = :URL AND is_deleted IS NULL ORDER BY videos.uploaded_on DESC LIMIT 1",false,[":URL" => $LatVideoURL],false);
    }
    if (!isset($LatVideo) && $_PROFILE->Info['videos'] >= 1) {
        $LatVideo = $DB->execute("SELECT * FROM videos WHERE uploaded_by = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL ORDER BY videos.uploaded_on DESC LIMIT 1",false,[":USERNAME" => $_PROFILE->Username],false);
    }
    elseif ($_PROFILE->Info['favorites'] >= 1) {
        $LatVideo = $DB->execute("SELECT * FROM videos RIGHT JOIN videos_favorites ON videos_favorites.url = videos.url WHERE videos_favorites.username = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL ORDER BY videos_favorites.submit_on DESC LIMIT 1",false,[":USERNAME" => $_PROFILE->Username],false);
    }
    
    if($_USER->Logged_In) { //i have no idea how to prevent channel bots so i just gonna do this for now. reminder to myself: fix the profile views system asap!! -vista
        $DB->modify("UPDATE users SET profile_views = profile_views + 1 WHERE username = :USERNAME", [":USERNAME" => $_PROFILE->Username],false);
    }

    if ($_USER->Logged_In) {
        $Is_Subscribed = $_USER->is_subscribed($_PROFILE);
    } else {
        $Is_Subscribed = false;
    }

    if ($_PROFILE->Info["channel_comments"] > 0) {
        $Comments = $DB->execute("SELECT * FROM channel_comments WHERE on_channel = :USERNAME ORDER BY submit_date DESC LIMIT 10", false, [":USERNAME" => $_PROFILE->Username],false);
        $Page_Amount = $_PROFILE->Info["channel_comments"] / 10;
        if (is_float($Page_Amount)) { $Page_Amount = (int)$Page_Amount + 1; }
    } else {
        $Comments = false;
    }

}
elseif ($_GET["page"] == "friends") {
    $_PAGINATION = new Pagination(40, 1000);
    $_PAGINATION->total($_PROFILE->Info["friends"]);
    $Friends = $_PROFILE->get_friends($_PAGINATION,true);
} elseif ($_GET["page"] == "subscribers") {
    $_PAGINATION = new Pagination(40, 1000);
    $_PAGINATION->total($_PROFILE->Info["subscribers"]);
    $Users_Subscribers = $DB->execute("SELECT * FROM users INNER JOIN subscriptions ON subscriptions.subscription = :USERNAME WHERE subscriptions.subscriber = users.username AND is_banned = 0 ORDER BY subscriptions.submit_date DESC LIMIT $_PAGINATION->From, $_PAGINATION->To",false,[":USERNAME" => $_PROFILE->Username],false);
} elseif ($_GET["page"] == "subscriptions") {
    $_PAGINATION = new Pagination(40, 1000);
    $_PAGINATION->total($_PROFILE->Info["subscriptions"]);
    $Users_Subscriptions3 = $DB->execute("SELECT * FROM users INNER JOIN subscriptions ON subscriptions.subscriber = :USERNAME WHERE subscriptions.subscription = users.username AND is_banned = 0 ORDER BY subscriptions.submit_date DESC LIMIT $_PAGINATION->From, $_PAGINATION->To",false,[":USERNAME" => $_PROFILE->Username],false);
}

if (isset($Videos) && $Videos::$Videos)             { $Videos = $Videos->fix_values(true,true); }
else                                                { $Videos = false; }

if ($_PROFILE->Info['videos'] == 0 && $_PROFILE->Info['favorites'] == 0 && empty($Playlists) or ($_PROFILE->Info['c_all'] == 0 && $_PROFILE->Info['c_videos_box'] == 0 && $_PROFILE->Info['c_favorites_box'] == 0 && $_PROFILE->Info['c_playlists_box'] == 0)) {
    $Profile_Empty = 1;
}
else {
    $Profile_Empty = 0;
}

//RECENT ACTIVITY
//BULLETINS
if ($_PROFILE->Info['c_ratings_box'] == 1) {
$SELECT = "SELECT 'bulletin' as type_name, id, content, url as rating, submit_date as date, content as title FROM bulletins_new WHERE by_user = :OWNER";
//COMMENTS
$SELECT .= " UNION ALL SELECT 'comment' as type_name, videos.url, videos_comments.content, '' as rating, videos_comments.submit_on as date, videos.title as title FROM videos_comments INNER JOIN videos ON videos_comments.url = videos.url WHERE by_user = :OWNER AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL";
//RATINGS
$SELECT .= " UNION ALL SELECT 'rating' as type_name, videos.url, videos.description as comment, rating as rating, videos_ratings.submit_date as date, videos.title as title FROM videos_ratings INNER JOIN videos on videos_ratings.url = videos.url WHERE username = :OWNER AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL AND rating >= 3";
//FAVORITES
$SELECT .= " UNION ALL SELECT 'favorite' as type_name, videos.url, videos.description as comment, '' as rating, videos_favorites.submit_on as date, videos.title as title FROM videos_favorites INNER JOIN videos ON videos_favorites.url = videos.url WHERE username = :OWNER AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL";
//UPLOADS
$SELECT .= " UNION ALL SELECT 'uploaded' as type_name, url, description as comment, '' as rating, uploaded_on as date, title as title FROM videos WHERE uploaded_by = :OWNER AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL";
//SUBSCRIPTIONS
$SELECT .= " UNION ALL SELECT 'subscription' as type_name, subscriber, subscription, '' as rating, submit_date as date, '' as title FROM subscriptions WHERE subscriber = :OWNER";
//FRIENDS
$SELECT .= " UNION ALL SELECT 'friend' as type_name, friend_1, friend_2, '' as rating, submit_on as date, '' as title FROM users_friends WHERE (friend_1 = :OWNER OR friend_2 = :OWNER) AND status = 1";

$Recent_Activity = $DB->execute("$SELECT ORDER BY date DESC LIMIT 5", false, [":OWNER" => $_PROFILE->Username],false);
}

if (isset($_POST["save_box_settings_user_play"]) && $_USER->Logged_In) {
    if (isset($_POST["box_uploads"])) { $box_uploads = 1; } else { $box_uploads = 0; }
    if (isset($_POST["box_favorites"])) { $box_favorites = 1; } else { $box_favorites = 0; }
    if (isset($_POST["box_playlists"])) { $box_playlists = 1; } else { $box_playlists = 0; }
    if (isset($_POST["box_all"])) { $box_all = 1; } else { $box_all = 0; }
    if (isset($_POST["box_featured_video_id"])) { if (strval($_POST["box_featured_video_id"]) != "00000000000") {$box_featured_video_id = $_POST["box_featured_video_id"];} else {$box_featured_video_id = "";} }
    if (isset($_POST["box_autoplay"])) { $box_autoplay = 1; } else { $box_autoplay = 0; }
    $DB->modify("UPDATE users SET c_videos_box = :VIDEOS, c_favorites_box = :FAVORITES, c_playlists_box = :PLAYLISTS, c_all = :ALL, c_featured_video = :FEATURED_VIDEO, c_autoplay = :AUTOPLAY WHERE username = :USERNAME",[":VIDEOS" => $box_uploads,":FAVORITES" => $box_favorites,":PLAYLISTS" => $box_playlists,":ALL" => $box_all,":FEATURED_VIDEO" => $box_featured_video_id,":AUTOPLAY" => $box_autoplay,":USERNAME" => $_USER->Username]);
    notification($LANGS['changessaved'],"/user/$_PROFILE->Username","cfeeb2"); exit();
}
if (isset($_POST["save_settings_user_play"]) && $_USER->Logged_In) {
    if (isset($_POST["uploads"])) { $box_uploads = 1; } else { $box_uploads = 0; }
    if (isset($_POST["favorites"])) { $box_favorites = 1; } else { $box_favorites = 0; }
    if (isset($_POST["playlists"])) { $box_playlists = 1; } else { $box_playlists = 0; }
    if (isset($_POST["all"])) { $box_all = 1; } else { $box_all = 0; }
    if (isset($_POST["featured_video_id"])) { if (strval($_POST["featured_video_id"]) != "00000000000") {$box_featured_video_id = $_POST["featured_video_id"];} else {$box_featured_video_id = "";} }
    if (isset($_POST["autoplay"])) { $box_autoplay = 1; } else { $box_autoplay = 0; }
    $DB->modify("UPDATE users SET c_videos_box = :VIDEOS, c_favorites_box = :FAVORITES, c_playlists_box = :PLAYLISTS, c_all = :ALL, c_featured_video = :FEATURED_VIDEO, c_autoplay = :AUTOPLAY WHERE username = :USERNAME",[":VIDEOS" => $box_uploads,":FAVORITES" => $box_favorites,":PLAYLISTS" => $box_playlists,":ALL" => $box_all,":FEATURED_VIDEO" => $box_featured_video_id,":AUTOPLAY" => $box_autoplay,":USERNAME" => $_USER->Username]);
    notification($LANGS['changessaved'],"/user/$_PROFILE->Username","cfeeb2"); exit();
}

if (isset($_POST["channel_settings_save"]) && $_USER->Logged_In) {
    $_GUMP->validation_rules([
            "title"       => "max_len,50",
            "keywords"       => "max_len,256"
        ]);

        $_GUMP->filter_rules([
            "title"       => "trim|NoHTML",
            "channel_type"       => "trim|NoHTML",
            "keywords"       => "trim|NoHTML"
        ]);

        $Validation     = $_GUMP->run($_POST);

        if ($Validation) { 
            $DB->modify("UPDATE users SET i_title = :TITLE, type = :TYPE, i_tags = :KEYWORDS WHERE username = :USERNAME",[":TITLE" => $Validation['title'],":TYPE" => $Validation['channel_type'],":KEYWORDS" => $Validation['keywords'],":USERNAME" => $_USER->Username]);
            notification($LANGS['changessaved'],"/user/$_PROFILE->Username","cfeeb2"); exit();
        }
}

if (isset($_POST["save_modules"]) && $_USER->Logged_In) {
    if (isset($_POST["user_comments"])) { $user_comments = 1; } else { $user_comments = 0; }
    if (isset($_POST["user_recent_activity"])) { $user_recent_activity = 1; } else { $user_recent_activity = 0; }
    if (isset($_POST["user_friends"])) { $user_friends = 1; } else { $user_friends = 0; }
    if (isset($_POST["user_subscribers"])) { $user_subscribers = 1; } else { $user_subscribers = 0; }
    if (isset($_POST["user_subscriptions"])) { $user_subscriptions = 1; } else { $user_subscriptions = 0; }
    if (isset($_POST["user_hubber_links"])) { $user_hubber_links = 1; } else { $user_hubber_links = 0; }
    $DB->modify("UPDATE users SET c_comments_box = :COMMENTS, c_ratings_box = :RECENT, c_friends_box = :FRIENDS, c_subscribers_box = :SUBSCRIBERS, c_subscriptions_box = :SUBSCRIPTIONS, c_bulletins_box = :OTHERCHANNELS WHERE username = :USERNAME",[":COMMENTS" => $user_comments,":RECENT" => $user_recent_activity,":FRIENDS" => $user_friends,":SUBSCRIBERS" => $user_subscribers,":SUBSCRIPTIONS" => $user_subscriptions,":OTHERCHANNELS" => $user_hubber_links,":USERNAME" => $_USER->Username]);
    notification($LANGS['changessaved'],"/user/$_PROFILE->Username","cfeeb2"); exit();
}

if (!isset($_GET["page"])) {
    if (!$_USER->Logged_In || $_USER->Username !== $_PROFILE->Info["username"]) {
        $Page_Type = "channels";
    } else {
        $Page_Type = "my_profile";
    }
    $Page = "main";
} elseif($_GET["page"] == "videos" || $_GET["page"] == "pvideos") {
    if (!$_USER->Logged_In || $_USER->Username !== $_PROFILE->Info["username"]) {
        $Page_Type = "browse";
    } else {
        $Page_Type = "my_videos";
    }
    $Page = "videos";
} elseif ($_GET["page"] == "friends") {
    if (!$_USER->Logged_In || $_USER->Username !== $_PROFILE->Username) {
        $Page_Type = "channels";
    } else {
        $Page_Type = "friends";
    }
    $Page = "friends";
} elseif ($_GET["page"] == "subscriptions") {
    $Page_Type = "channels";
    $Page = "subscriptions";
} elseif ($_GET["page"] == "subscribers") {
    $Page_Type = "channels";
    $Page = "subscribers";
}

if (isset($_GET["hl"])) {
    setcookie("lang", $_GET["hl"], ['expires' => time() + (86400 * 30), 'path' => "/"]);
    header("location: /user/".$_GET["user"]); exit();
}

if (!empty($_PROFILE->Info["username"])) {$ChannelTitle = displayname($_PROFILE->Info["username"]);}
else {$ChannelTitle = "This account is suspended";}

$ChannelTitle2 = $LANGS['channeltitle'];
$PageTitle = str_replace("{n}", $ChannelTitle, $ChannelTitle2);

$_PAGE = [
    "Page"          => $Page,
    "Page_Type"     => $Page_Type,
    "ChannelTitle"  => $PageTitle
];
require "_templates/_structures/profile_new.php";
} else {
    if ($_PROFILE->Info['has_terminated']) { notification($LANGS['accountnotfound'],"/"); exit(); }
    else if ($_PROFILE->is_banned()) { notification($LANGS['channelsuspended'],"/"); exit(); }
    else                        { notification($LANGS['accountnotfound'],"/"); exit(); }
}
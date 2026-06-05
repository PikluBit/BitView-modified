<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
use function PHP81_BC\strftime;

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
if (!isset($_GET["side"])) {
    header("location: /");
    exit();
}

function make_links_clickable($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Z?-??-?()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', (string) $text);
}

$_USER->get_info();
$_PROFILE = new User($_GET["channel"],$DB);
$_PROFILE->get_info();

if ($_GET['module'] == "hubber_links") {
    $Module = "otherchannels";
}
else if ($_GET['module'] == "branding") {
    $Module = "custombox";
}
else if ($_GET['module'] == "recent_activity") {
    $Module = "recentactivity";
}
else {
    $Module = $_GET['module'];
}

if ($Module == "profile") {
$Honor_Count = 0;
$Sub_Ranking = $DB->execute("SELECT 1 + (SELECT count( * ) FROM users a WHERE a.subscribers > b.subscribers AND is_banned = 0) AS rank FROM users b WHERE username = :USERNAME AND is_banned = 0 ORDER BY rank LIMIT 1 ;",true,[":USERNAME" => $_PROFILE->Username])["rank"];
if ($Sub_Ranking <= 50) { $Honor_Count++; }

$Sub_Category_Ranking     = $DB->execute("SELECT 1 + (SELECT count( * ) FROM users a WHERE a.subscribers > b.subscribers AND a.type = b.type AND is_banned = 0) AS rank FROM users b WHERE username = :USERNAME AND is_banned = 0 ORDER BY rank LIMIT 1 ;",true,[":USERNAME" => $_PROFILE->Username])["rank"];
if ($Sub_Category_Ranking <= 50) { $Honor_Count++; }

$Sub_Partner_Ranking     = $DB->execute("SELECT 1 + (SELECT count( * ) FROM users a WHERE a.subscribers > b.subscribers AND is_partner = 1 AND is_banned = 0) AS rank FROM users b WHERE username = :USERNAME AND is_partner = 1 AND is_banned = 0 ORDER BY rank LIMIT 1 ;",true,[":USERNAME" => $_PROFILE->Username])["rank"] ?? '';
if ($_PROFILE->Info["is_partner"] and $Sub_Partner_Ranking <= 50) { $Honor_Count++; }

$Views_Ranking     = $DB->execute("SELECT 1 + (SELECT count( * ) FROM users a WHERE a.video_views > b.video_views AND is_banned = 0) AS rank FROM users b WHERE username = :USERNAME AND is_banned = 0 ORDER BY rank LIMIT 1 ;",true,[":USERNAME" => $_PROFILE->Username])["rank"];
if ($Views_Ranking <= 50) { $Honor_Count++; }

$Views_Category_Ranking     = $DB->execute("SELECT 1 + (SELECT count( * ) FROM users a WHERE a.video_views > b.video_views AND a.type = b.type AND is_banned = 0) AS rank FROM users b WHERE username = :USERNAME AND is_banned = 0 ORDER BY rank LIMIT 1 ;",true,[":USERNAME" => $_PROFILE->Username])["rank"];
if ($Views_Category_Ranking <= 50) { $Honor_Count++; }

$Views_Partner_Ranking     = $DB->execute("SELECT 1 + (SELECT count( * ) FROM users a WHERE a.video_views > b.video_views AND is_partner = 1 AND is_banned = 0) AS rank FROM users b WHERE username = :USERNAME AND is_partner = 1 AND is_banned = 0 ORDER BY rank LIMIT 1 ;",true,[":USERNAME" => $_PROFILE->Username])["rank"] ?? '';
if ($_PROFILE->Info["is_partner"] and $Views_Partner_Ranking <= 50) { $Honor_Count++; }

$Channel_Type = [0 => $LANGS['type0'], 1 => $LANGS['type1'], 2 => $LANGS['type2'], 3 => $LANGS['type3'], 4 => $LANGS['type4'], 5 => $LANGS['type5'], 6 => $LANGS['type6']];
$Honor_Type = [0 => $LANGS['type0'], 1 => $LANGS['type1p'], 2 => $LANGS['type2p'], 3 => $LANGS['type3p'], 4 => $LANGS['type4p'], 5 => $LANGS['type5p'], 6 => $LANGS['type6p']];
    $Channel_Country  = ['AF' => $LANGS['cat_AF'], 'AX' => $LANGS['cat_AX'], 'AL' => $LANGS['cat_AL'], 'DZ' => $LANGS['cat_DZ'], 'AS' => $LANGS['cat_AS'], 'AD' => $LANGS['cat_AD'], 'AO' => $LANGS['cat_AO'], 'AI' => $LANGS['cat_AI'], 'AQ' => $LANGS['cat_AQ'], 'AG' => $LANGS['cat_AG'], 'AR' => $LANGS['cat_AR'], 'AM' => $LANGS['cat_AM'], 'AW' => $LANGS['cat_AW'], 'AU' => $LANGS['cat_AU'], 'AT' => $LANGS['cat_AT'], 'AZ' => $LANGS['cat_AZ'], 'BS' => $LANGS['cat_BS'], 'BH' => $LANGS['cat_BH'], 'BD' => $LANGS['cat_BD'], 'BB' => $LANGS['cat_BB'], 'BY' => $LANGS['cat_BY'], 'BE' => $LANGS['cat_BE'], 'BZ' => $LANGS['cat_BZ'], 'BJ' => $LANGS['cat_BJ'], 'BM' => $LANGS['cat_BM'], 'BT' => $LANGS['cat_BT'], 'BO' => $LANGS['cat_BO'], 'BQ' => $LANGS['cat_BQ'], 'BA' => $LANGS['cat_BA'], 'BW' => $LANGS['cat_BW'], 'BV' => $LANGS['cat_BV'], 'BR' => $LANGS['cat_BR'], 'IO' => $LANGS['cat_IO'], 'VG' => $LANGS['cat_VG'], 'BN' => $LANGS['cat_BN'], 'BG' => $LANGS['cat_BG'], 'BF' => $LANGS['cat_BF'], 'BI' => $LANGS['cat_BI'], 'KH' => $LANGS['cat_KH'], 'CM' => $LANGS['cat_CM'], 'CA' => $LANGS['cat_CA'], 'CV' => $LANGS['cat_CV'], 'KY' => $LANGS['cat_KY'], 'CF' => $LANGS['cat_CF'], 'TD' => $LANGS['cat_TD'], 'CL' => $LANGS['cat_CL'],'CN'=> $LANGS['cat_CN'], 'CX' => $LANGS['cat_CX'], 'CC' => $LANGS['cat_CC'], 'CO' => $LANGS['cat_CO'], 'KM' => $LANGS['cat_KM'], 'CK' => $LANGS['cat_CK'], 'CR' => $LANGS['cat_CR'], 'HR' => $LANGS['cat_HR'], 'CU' => $LANGS['cat_CU'], 'CW' => $LANGS['cat_CW'], 'CY' => $LANGS['cat_CY'], 'CZ' => $LANGS['cat_CZ'], 'CD' => $LANGS['cat_CD'], 'DK' => $LANGS['cat_DK'], 'DJ' => $LANGS['cat_DJ'], 'DM' => $LANGS['cat_DM'], 'DO' => $LANGS['cat_DO'], 'TL' => $LANGS['cat_TL'], 'EC' => $LANGS['cat_EC'], 'EG' => $LANGS['cat_EG'], 'SV' => $LANGS['cat_SV'], 'GQ' => $LANGS['cat_GQ'], 'ER' => $LANGS['cat_ER'], 'EE' => $LANGS['cat_EE'], 'ET' => $LANGS['cat_ET'], 'FK' => $LANGS['cat_FK'], 'FO' => $LANGS['cat_DO'], 'FJ' => $LANGS['cat_FJ'], 'FI' => $LANGS['cat_FI'], 'FR' => $LANGS['cat_FR'], 'GF' => $LANGS['cat_GF'], 'PF' => $LANGS['cat_PF'], 'TF' => $LANGS['cat_TF'], 'GA' => $LANGS['cat_GA'], 'GM' => $LANGS['cat_GM'], 'GE' => $LANGS['cat_GE'], 'DE' => $LANGS['cat_DE'], 'GH' => $LANGS['cat_GH'], 'GI' => $LANGS['cat_GI'], 'GR' => $LANGS['cat_GR'], 'GL' => $LANGS['cat_GL'], 'GD' => $LANGS['cat_GD'], 'GP' => $LANGS['cat_GP'], 'GU' => $LANGS['cat_GU'], 'GT' => $LANGS['cat_GT'], 'GG' => $LANGS['cat_GG'], 'GN' => $LANGS['cat_GN'], 'GW' => $LANGS['cat_GW'], 'GY' => $LANGS['cat_GY'], 'HT' => $LANGS['cat_HT'], 'HM' => $LANGS['cat_HM'], 'HN' => $LANGS['cat_HN'], 'HK' => $LANGS['cat_HK'], 'HU' => $LANGS['cat_HU'], 'IS' => $LANGS['cat_IS'], 'IN' => $LANGS['cat_IN'], 'ID' => $LANGS['cat_ID'], 'IR' => $LANGS['cat_IR'], 'IQ' => $LANGS['cat_IQ'], 'IE' => $LANGS['cat_IE'], 'IM' => $LANGS['cat_IM'], 'IL' => $LANGS['cat_IL'], 'IT' => $LANGS['cat_IT'], 'CI' => $LANGS['cat_CI'], 'JM' => $LANGS['cat_JM'], 'JP' => $LANGS['cat_JP'], 'JE' => $LANGS['cat_JE'], 'JO' => $LANGS['cat_JO'], 'KZ' => $LANGS['cat_KZ'], 'KE' => $LANGS['cat_KE'], 'KI' => $LANGS['cat_KI'], 'XK' => $LANGS['cat_XK'], 'KW' => $LANGS['cat_KW'], 'KG' => $LANGS['cat_KG'], 'LA' => $LANGS['cat_LA'], 'LV' => $LANGS['cat_LV'], 'LB' => $LANGS['cat_LB'], 'LS' => $LANGS['cat_LS'], 'LR' => $LANGS['cat_LR'], 'LY' => $LANGS['cat_LY'], 'LI' => $LANGS['cat_LI'], 'LT' => $LANGS['cat_LI'], 'LU' => $LANGS['cat_LU'], 'MO' => $LANGS['cat_MO'], 'MK' => $LANGS['cat_MK'], 'MG' => $LANGS['cat_MG'], 'MW' => $LANGS['cat_MW'], 'MY' => $LANGS['cat_MY'], 'MV' => $LANGS['cat_MV'], 'ML' => $LANGS['cat_ML'], 'MT' => $LANGS['cat_MT'], 'MH' => $LANGS['cat_MH'], 'MQ' => $LANGS['cat_MQ'], 'MR' => $LANGS['cat_MR'], 'MU' => $LANGS['cat_MU'], 'YT' => $LANGS['cat_YT'], 'MX' => $LANGS['cat_MX'], 'FM' => $LANGS['cat_FM'], 'MD' => $LANGS['cat_MD'], 'MC' => $LANGS['cat_MC'], 'MN' => $LANGS['cat_MN'], 'ME' => $LANGS['cat_ME'], 'MS' => $LANGS['cat_MS'], 'MA' => $LANGS['cat_MA'], 'MZ' => $LANGS['cat_MZ'], 'MM' => $LANGS['cat_MM'], 'NA' => $LANGS['cat_NA'], 'NR' => $LANGS['cat_NR'], 'NP' => $LANGS['cat_NP'], 'NL' => $LANGS['cat_NL'], 'NC' => $LANGS['cat_NC'], 'NZ' => $LANGS['cat_NZ'], 'NI' => $LANGS['cat_NI'], 'NE' => $LANGS['cat_NE'], 'NG' => $LANGS['cat_NG'], 'NU' => $LANGS['cat_NU'], 'NF' => $LANGS['cat_NF'], 'KP' => $LANGS['cat_KP'], 'MP' => $LANGS['cat_MP'], 'NO' => $LANGS['cat_NO'], 'OM' => $LANGS['cat_OM'], 'PK' => $LANGS['cat_PK'], 'PW' => $LANGS['cat_PW'], 'PS' => $LANGS['cat_PS'], 'PA' => $LANGS['cat_PA'], 'PG' => $LANGS['cat_PG'], 'PY' => $LANGS['cat_PY'], 'PE' => $LANGS['cat_PE'], 'PH' => $LANGS['cat_PH'], 'PN' => $LANGS['cat_PN'], 'PL' => $LANGS['cat_PL'], 'PT' => $LANGS['cat_PT'], 'PR' => $LANGS['cat_PR'], 'QA' => $LANGS['cat_QA'], 'CG' => $LANGS['cat_CG'], 'RE' => $LANGS['cat_RE'], 'RO' => $LANGS['cat_RO'], 'RU' => $LANGS['cat_RU'], 'RW' => $LANGS['cat_RW'], 'BL' => $LANGS['cat_BL'], 'SH' => $LANGS['cat_SH'], 'KN' => $LANGS['cat_KN'], 'LC' => $LANGS['cat_LC'], 'MF' => $LANGS['cat_MF'], 'PM' => $LANGS['cat_PM'], 'VC' => $LANGS['cat_VC'], 'WS' => $LANGS['cat_WS'], 'SM' => $LANGS['cat_SM'], 'ST' => $LANGS['cat_ST'], 'SA' => $LANGS['cat_SA'], 'SN' => $LANGS['cat_SN'], 'RS' => $LANGS['cat_RS'], 'SC' => $LANGS['cat_SC'], 'SL' => $LANGS['cat_SL'], 'SG' => $LANGS['cat_SG'], 'SX' => $LANGS['cat_SX'], 'SK' => $LANGS['cat_SK'], 'SI' => $LANGS['cat_SI'], 'SB' => $LANGS['cat_SB'], 'SO' => $LANGS['cat_SO'], 'ZA' => $LANGS['cat_ZA'], 'GS' => $LANGS['cat_GS'], 'KR' => $LANGS['cat_KR'], 'SS' => $LANGS['cat_SS'], 'ES' => $LANGS['cat_ES'], 'LK' => $LANGS['cat_LK'], 'SD' => $LANGS['cat_SD'], 'SR' => $LANGS['cat_SR'], 'SJ' => $LANGS['cat_SJ'], 'SZ' => $LANGS['cat_SZ'], 'SE' => $LANGS['cat_SE'], 'CH' => $LANGS['cat_CH'], 'SY' => $LANGS['cat_SY'], 'TW' => $LANGS['cat_TW'], 'TJ' => $LANGS['cat_TJ'], 'TZ' => $LANGS['cat_TZ'], 'TH' => $LANGS['cat_TH'], 'TG' => $LANGS['cat_TG'], 'TK' => $LANGS['cat_TK'], 'TO' => $LANGS['cat_TO'], 'TT' => $LANGS['cat_TT'], 'TN' => $LANGS['cat_TN'], 'TR' => $LANGS['cat_TR'], 'TM' => $LANGS['cat_TM'], 'TC' => $LANGS['cat_TC'], 'TV' => $LANGS['cat_TV'], 'VI' => $LANGS['cat_VI'], 'UG' => $LANGS['cat_UG'], 'UA' => $LANGS['cat_UA'], 'AE' => $LANGS['cat_AE'], 'GB' => $LANGS['cat_GB'], 'US' => $LANGS['cat_US'], 'UY' => $LANGS['cat_UY'], 'UZ' => $LANGS['cat_UZ'], 'VU' => $LANGS['cat_VU'], 'VA' => $LANGS['cat_VA'], 'VE' => $LANGS['cat_VE'], 'VN' => $LANGS['cat_VN'], 'WF' => $LANGS['cat_WF'], 'EH' => $LANGS['cat_EH'], 'YE' => $LANGS['cat_YE'], 'ZM' => $LANGS['cat_ZM'], 'ZW' => $LANGS['cat_ZW']];

$Profile_Info = explode(",", (string) $_PROFILE->Info['i_info']);
}

if ($Module == "recentactivity") {
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

$Module = $Module."_".$_GET['side'];

$Modules_L = explode(",", (string) $_PROFILE->Info['c_modules_l']);
$Modules_R = explode(",", (string) $_PROFILE->Info['c_modules_r']);
?>

<?php if ($Module == "profile_l"):?>
    <div class="inner-box" id="user_profile">
        
        <div style="float:left;" class="box-title title-text-color">
<?= $LANGS['profile'] ?>
        </div>

        <div style="float:right;;_display:inline;white-space:nowrap">
                <div style="float:right;padding:0 4px;position:relative">
                    <?php if ($_PROFILE->Username == $_USER->Username): ?>
                    <a class="channel-cmd" href="#" onclick="document.getElementById('user_profile').classList.add('edit_mode');document.getElementById('user_profile-body').style.display = 'none';return false;" id="user_profile_edit_link"><?= mb_strtolower((string) $LANGS['edit'])  ?></a>
                <?php endif ?>
                </div>
        </div>
        <div class="cb"></div>
        <?php if ($_PROFILE->Username == $_USER->Username): ?>

        <img src="/img/pixel.gif" class="edit-widget" style="right: 9px;">
<div class="edit_info">
    <form action="/user/Herotrap" method="POST">
    <div class="edit_top_box" style="padding: 5px;">
        <div class="user_profile_save_cancel" style="position:relative;line-height: 27px;">
        <button type="button" onclick="save_profile_info();" class=" yt-uix-button yt-uix-button-primary" name="save_settings_user_profile"><span class="yt-uix-button-content"><?= $LANGS['editsavechanges'] ?></span></button>
<?= $LANGS['or'] ?>
        <a href="#" onclick="document.getElementById('user_profile').classList.remove('edit_mode');document.getElementById('user_profile-body').style.display = 'block';return false;"><?= $LANGS['editcancel'] ?></a>
        <div class="save_overlay" style="padding:0.4em;padding-left:3em;width:60%">
            <img src="/img/icn_loading_animated.gif">
        </div>
    </div>
    <div class="edit_profile_separator spacer">&nbsp;</div>
    <div class="spacer">&nbsp;</div>
    <div class="edit_info">
        <div style="float:left"><input name="i_name_chk" id="first_name" type="checkbox" <?php if ($Profile_Info[0] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('first_name');"></div>
        <div id="edit_info_first_name" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[0] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['name'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_name" id="profile_edit_first_name" maxlength="30" value="<?= $_PROFILE->Info['i_name'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_channelviews_chk" id="channel_views" onclick="update_hidden_field('channel_views');" type="checkbox" <?php if ($Profile_Info[1] == 1): ?><?php if ($Profile_Info[1] == 1): ?>checked=""<?php endif ?><?php endif ?> style="vertical-align:text-bottom"></div>
        <div id="edit_info_channel_views" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[1] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['channelviews'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["profile_views"]) ?><?php else: ?><?= ($_PROFILE->Info["profile_views"]) ?><?php endif ?>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_videoviews_chk" id="video_views" type="checkbox" <?php if ($Profile_Info[2] == 1): ?>checked=""<?php endif ?> onclick="update_hidden_field('video_views');" style="vertical-align:text-bottom"></div>
        <div id="edit_info_video_views" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[2] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['totaluploadviews'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["video_views"]) ?><?php else: ?><?= ($_PROFILE->Info["video_views"]) ?><?php endif ?>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_videoswatched_chk" id="videos_watched" type="checkbox" <?php if ($Profile_Info[3] == 1): ?>checked=""<?php endif ?> onclick="update_hidden_field('videos_watched');" style="vertical-align:text-bottom"></div>
        <div id="edit_info_videos_watched" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[3] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['videoswatched'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["videos_watched"]) ?><?php else: ?><?= ($_PROFILE->Info["videos_watched"]) ?><?php endif ?>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_age_chk" id="age" onclick="update_hidden_field('age');" type="checkbox" <?php if ($Profile_Info[4] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom"></div>
        <div id="edit_info_age" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[4] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['age'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <?= ageCalculator($_PROFILE->Info["i_age"]) ?>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_last_login_chk" id="last_login" onclick="update_hidden_field('last_login');" type="checkbox" <?php if ($Profile_Info[5] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom"></div>
        <div id="edit_info_last_login" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[5] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['lastlogin'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <?= get_time_ago($_PROFILE->Info["last_login"]) ?>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_subscribers_chk" id="subscribers" onclick="update_hidden_field('subscribers');" type="checkbox" <?php if ($Profile_Info[6] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom"></div>
        <div id="edit_info_subscribers" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[6] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['channelsubscribers'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["subscribers"]) ?><?php else: ?><?= ($_PROFILE->Info["subscribers"]) ?><?php endif ?>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_website_chk" id="website" type="checkbox" <?php if ($Profile_Info[7] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('website');"></div>
        <div id="edit_info_website" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[7] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['website'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_website" id="profile_edit_website" maxlength="128" value="<?= $_PROFILE->Info['i_website'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_description_chk" id="description" type="checkbox" <?php if ($Profile_Info[8] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('description');"></div>
        <div id="edit_info_description" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[8] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['channeldesc'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <textarea maxlength="5000" type="text" name="i_desc" id="profile_edit_description" class="edit_text" style="width: 235px; height: 45px; border: 1px solid #ccc; resize: vertical;"><?= $_PROFILE->Info['i_desc'] ?></textarea>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_about_chk" id="about_me" type="checkbox" <?php if ($Profile_Info[9] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('about_me');"></div>
        <div id="edit_info_about_me" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[9] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['aboutme'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <textarea maxlength="2048" type="text" name="i_about" id="profile_edit_about_me" class="edit_text" style="width: 235px; height: 45px; border: 1px solid #ccc; resize: vertical;"><?= $_PROFILE->Info['i_about'] ?></textarea>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_hometown_chk" id="hometown" type="checkbox" <?php if ($Profile_Info[10] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('hometown');"></div>
        <div id="edit_info_hometown" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[10] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['hometown'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_hometown" id="profile_edit_hometown" maxlength="128" value="<?= $_PROFILE->Info['i_hometown'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_country_chk" id="country" type="checkbox" <?php if ($Profile_Info[11] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('country');"></div>
        <div id="edit_info_country" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[11] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['country'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <select name="i_country" id="profile_edit_country" style="width: 150px;">
                    <?php foreach($Channel_Country as $value => $item) : ?>
                        <option value="<?= $value ?>"<?php if ($_PROFILE->Info["i_country"] == $value) : ?> selected<?php endif ?>><?= $item ?></option>
                    <?php endforeach ?>
                </select>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_occupation_chk" id="occupation" type="checkbox" <?php if ($Profile_Info[12] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('occupation');"></div>
        <div id="edit_info_occupation" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[12] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['occupation'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_occupation" id="profile_edit_occupation" maxlength="128" value="<?= $_PROFILE->Info['i_occupation'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_companies_chk" id="companies" type="checkbox" <?php if ($Profile_Info[13] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('companies');"></div>
        <div id="edit_info_companies" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[13] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['companies'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_companies" id="profile_edit_companies" maxlength="128" value="<?= $_PROFILE->Info['i_companies'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_schools_chk" id="schools" type="checkbox" <?php if ($Profile_Info[14] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('schools');"></div>
        <div id="edit_info_schools" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[14] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['schools'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_schools" id="profile_edit_schools" maxlength="128" value="<?= $_PROFILE->Info['i_schools'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_hobbies_chk" id="hobbies" type="checkbox" <?php if ($Profile_Info[15] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('hobbies');"></div>
        <div id="edit_info_hobbies" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[15] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['interests'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_hobbies" id="profile_edit_hobbies" maxlength="128" value="<?= $_PROFILE->Info['i_hobbies'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_movies_chk" id="movies" type="checkbox" <?php if ($Profile_Info[16] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('movies');"></div>
        <div id="edit_info_movies" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[16] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['movies'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_movies" id="profile_edit_movies" maxlength="128" value="<?= $_PROFILE->Info['i_movies'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_music_chk" id="music" type="checkbox" <?php if ($Profile_Info[17] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('music');"></div>
        <div id="edit_info_music" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[17] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['music'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_music" id="profile_edit_music" maxlength="128" value="<?= $_PROFILE->Info['i_music'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_books_chk" id="books" type="checkbox" <?php if ($Profile_Info[18] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('books');"></div>
        <div id="edit_info_books" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[18] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['books'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_books" id="profile_edit_books" maxlength="128" value="<?= $_PROFILE->Info['i_books'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="user_profile_save_cancel" style="position:relative;line-height: 27px;">
        <button type="button" onclick="save_profile_info();" class=" yt-uix-button yt-uix-button-primary" name="save_settings_user_profile"><span class="yt-uix-button-content"><?= $LANGS['editsavechanges'] ?></span></button>
<?= $LANGS['or'] ?>
        <a href="#" onclick="document.getElementById('user_profile').classList.remove('edit_mode');document.getElementById('user_profile-body').style.display = 'block';return false;"><?= $LANGS['editcancel'] ?></a>
        <div class="save_overlay" style="padding:0.4em;padding-left:3em;width:60%">
            <img src="/img/icn_loading_animated.gif">
        </div>
    </div>
    </div>
    </form>
        </div>
    <?php endif ?>
    <div id="user_profile_success" style="display: block;width: 90%;margin: 0 auto;margin-top: 4px;height: 36px;line-height: 36px;text-align: center;background: #dfd;color: black;">
<?= $LANGS['profilechangessaved'] ?>
    </div>
    <div id="user_profile-body">
            <div class="edit_info spacer">&nbsp;</div>
    <div class="profile_info">
        <?php if ($_PROFILE->Info["i_name"] && $Profile_Info[0] == 1): ?>
                <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['name'] ?>:</div>
        <div style="float:right;" id="profile_show_first_name"><?= $_PROFILE->Info["i_name"] ?></div>
        <div class="cb"></div>
    </div>
<?php endif ?>

<?php if ($Profile_Info[1] == 1): ?>
        <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['channelviews'] ?>:</div>
        <div style="float:right;" id="profile_show_viewed_count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["profile_views"]) ?><?php else: ?><?= ($_PROFILE->Info["profile_views"]) ?><?php endif ?></div>
        <div class="cb"></div>
    </div>
<?php endif ?>
<?php if ($Profile_Info[2] == 1): ?>
        <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['totaluploadviews'] ?>:</div>
        <div style="float:right;" id="profile_show_viewed_count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["video_views"]) ?><?php else: ?><?= ($_PROFILE->Info["video_views"]) ?><?php endif ?></div>
        <div class="cb"></div>
    </div>
<?php endif ?>
<?php if ($Profile_Info[3] == 1): ?>
        <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['videoswatched'] ?>:</div>
        <div style="float:right;" id="profile_show_viewed_count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["videos_watched"]) ?><?php else: ?><?= ($_PROFILE->Info["videos_watched"]) ?><?php endif ?></div>
        <div class="cb"></div>
    </div>
<?php endif ?>
<?php if ($Profile_Info[4] == 1) : ?>
                    <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['age'] ?>:</div>
        <div style="float:right;" id="profile_show_age"><?= ageCalculator($_PROFILE->Info["i_age"]) ?></div>
        <div class="cb"></div>
    </div>
<?php endif ?>


        <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['joined'] ?>:</div>
        <div style="float:right;" id="profile_show_member_since"><?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['longtimeformat'], time_machine(strtotime((string) $_PROFILE->Info["registration_date"]))); }
                    else {echo strftime($LANGS['longtimeformat'], strtotime((string) $_PROFILE->Info["registration_date"])); }  ?></div>
        <div class="cb"></div>
    </div>
<?php if ($Profile_Info[5] == 1) : ?>
                <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['lastlogin'] ?>:</div>
        <div style="float:right;" id="profile_show_last_login"><?= get_time_ago($_PROFILE->Info["last_login"]) ?></div>
        <div class="cb"></div>
    </div>
<?php endif ?>

<?php if ($Profile_Info[6] == 1) : ?>
                <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['channelsubscribers'] ?>:</div>
        <div style="float:right;" id="profile_show_subscriber_count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["subscribers"]) ?><?php else: ?><?= ($_PROFILE->Info["subscribers"]) ?><?php endif ?></div>
        <div class="cb"></div>
    </div>
<?php endif ?>

        <?php if (!empty($_PROFILE->Info["i_website"]) && $Profile_Info[7] == 1) : ?>
            <div class="show_info outer-box-bg-as-border">
            <div style="float:left;font-weight:bold"><?= $LANGS['website'] ?>:</div>
            <div style="float:right"><a href="<?= $_PROFILE->Info["i_website"] ?>" name="" rel="nofollow"><?= short_title($_PROFILE->Info["i_website"],30) ?></a></div>
            <div class="cb"></div>
        </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_desc"]) && $Profile_Info[8] == 1) : ?>
        <div class="show_info outer-box-bg-as-border" style="border-bottom-width:1px;margin-bottom:4px;line-height:140%;overflow: hidden;">

            <?= make_links_clickable(nl2br((string) $_PROFILE->Info["i_desc"])) ?>

            <div class="cb"></div>
        </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_about"]) && $Profile_Info[9] == 1) : ?>
        <div class="show_info outer-box-bg-as-border" style="border-bottom-width:1px;margin-bottom:4px;line-height:140%;overflow: hidden;">
            <div style="float:left"><b><?= $LANGS['aboutme'] ?>:</b></div>
            <div class="spacer">&nbsp;</div>

            <?= make_links_clickable(nl2br((string) $_PROFILE->Info["i_about"])) ?>

            <div class="cb"></div>
        </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_hometown"]) && $Profile_Info[10] == 1) : ?>
        <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['hometown'] ?>:</div>
        <div style="float:right;" id="profile_show_hometown"><?= $_PROFILE->Info["i_hometown"] ?></div>
        <div class="cb"></div>
    </div>
    <?php endif ?>

    <?php if ($_PROFILE->Info["i_country"] != null && $Profile_Info[11] == 1) : ?>
            <div class="show_info outer-box-bg-as-border">
            <div style="float:left;font-weight:bold"><?= $LANGS['country'] ?>:</div>
            <div style="float:right"><?= $Channel_Country[$_PROFILE->Info["i_country"]] ?></div>
            <div class="cb"></div>
        </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_occupation"]) && $Profile_Info[12] == 1) : ?>
        <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['occupation'] ?>:</div>
        <div style="float:right;" id="profile_show_occupation"><?= $_PROFILE->Info["i_occupation"] ?></div>
        <div class="cb"></div>
    </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_companies"]) && $Profile_Info[13] == 1) : ?>
        <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['companies'] ?>:</div>
        <div style="float:right;" id="profile_show_companies"><?= $_PROFILE->Info["i_companies"] ?></div>
        <div class="cb"></div>
    </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_schools"]) && $Profile_Info[14] == 1) : ?>
        <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['schools'] ?>:</div>
        <div style="float:right;" id="profile_show_schools"><?= $_PROFILE->Info["i_schools"] ?></div>
        <div class="cb"></div>
    </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_hobbies"]) && $Profile_Info[15] == 1) : ?>
            <div class="show_info outer-box-bg-as-border">
            <div style="float:left;font-weight:bold"><?= $LANGS['interests'] ?>:</div>
            <div style="float:right"><?= $_PROFILE->Info["i_hobbies"] ?></div>
            <div class="cb"></div>
        </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_movies"]) && $Profile_Info[16] == 1) : ?>
    <div class="show_info outer-box-bg-as-border">
            <div style="float:left;font-weight:bold"><?= $LANGS['movies'] ?>:</div>
            <div style="float:right"><?= $_PROFILE->Info["i_movies"] ?></div>
            <div class="cb"></div>
        </div>
    <?php endif ?>


    <?php if (!empty($_PROFILE->Info["i_music"]) && $Profile_Info[17] == 1) : ?>
    <div class="show_info outer-box-bg-as-border">
            <div style="float:left;font-weight:bold"><?= $LANGS['music'] ?>:</div>
            <div style="float:right"><?= $_PROFILE->Info["i_music"] ?></div>
            <div class="cb"></div>
        </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_books"]) && $Profile_Info[18] == 1) : ?>
    <div class="show_info outer-box-bg-as-border">
            <div style="float:left;font-weight:bold"><?= $LANGS['books'] ?>:</div>
            <div style="float:right"><?= $_PROFILE->Info["i_books"] ?></div>
            <div class="cb"></div>
        </div>
    <?php endif ?>
    <?php if ($Honor_Count > 1): ?>
    <div class="show_info" style="padding-top: 8px;border:0">
    <span style="display:none"><?= $Honor_Count ?></span>
    <div class="padT10">
                <table cellspacing="0" cellpadding="0"><tbody><tr>
                    <td width="20" valign="top"><img src="/img/icn_award_17x24-vfl10931.gif" border="0"></td>
                    <td valign="top">
    <span id="BeginvidDeschonors" style="display:block">
                <?php $Count = 0 ?>
                <?php if ($Sub_Ranking <= 50): ?><a href="/channels">#<?= $Sub_Ranking ?> - <?= $LANGS['mostsub'] ?> (<?= $LANGS['alltime'] ?>)</a><br><?php $Count ++; ?><?php endif ?>

                <?php if ($Sub_Category_Ranking <= 50): ?><a href="/channels?type=<?= $_PROFILE->Info["type"] ?>">#<?= $Sub_Category_Ranking ?> - <?= $LANGS['mostsub'] ?> (<?= $LANGS['alltime'] ?>) - <?= $Honor_Type[$_PROFILE->Info["type"]] ?></a><br><?php $Count ++; ?><?php endif ?>

                <?php if ($_PROFILE->Info["is_partner"] and $Sub_Partner_Ranking <= 50): ?>
                <a href="/channels">#<?= $Sub_Partner_Ranking ?> - <?= $LANGS['mostsub'] ?> (<?= $LANGS['alltime'] ?>) - Partners</a><br><?php $Count ++; ?>
                <?php endif ?>

                <?php if ($Views_Ranking <= 50 and $Count < 3): ?><a href="/channels?order=views">#<?= $Views_Ranking ?> - <?= $LANGS['mostviewed'] ?> (<?= $LANGS['alltime'] ?>)</a><br><?php $Count ++; ?><?php endif ?>

                <?php if ($Views_Category_Ranking <= 50 and $Count < 3): ?><a href="/channels?order=views&type=<?= $_PROFILE->Info["type"] ?>">#<?= $Views_Category_Ranking ?> - <?= $LANGS['mostviewed'] ?> (<?= $LANGS['alltime'] ?>) - <?= $Honor_Type[$_PROFILE->Info["type"]] ?></a><br><?php $Count ++; ?><?php endif ?>

                <?php if ($_PROFILE->Info["is_partner"] and $Views_Partner_Ranking <= 50 and $Count < 3): ?>
                <a href="/channels?order=views">#<?= $Views_Partner_Ranking ?> - <?= $LANGS['mostviewed'] ?> (<?= $LANGS['alltime'] ?>) - Partners</a><br><?php $Count ++; ?>
                <?php endif ?>
    </span>
    <span id="RemainvidDeschonors" style="display:none">
                <?php if ($Sub_Ranking <= 50): ?><a href="/channels">#<?= $Sub_Ranking ?> - <?= $LANGS['mostsub'] ?> (<?= $LANGS['alltime'] ?>)</a><br><?php endif ?>

                <?php if ($Sub_Category_Ranking <= 50): ?><a href="/channels?type=<?= $_PROFILE->Info["type"] ?>">#<?= $Sub_Category_Ranking ?> - <?= $LANGS['mostsub'] ?> (<?= $LANGS['alltime'] ?>) - <?= $Honor_Type[$_PROFILE->Info["type"]] ?></a><br><?php endif ?>

                <?php if ($_PROFILE->Info["is_partner"] and $Sub_Partner_Ranking <= 50): ?>
                <a href="/channels">#<?= $Sub_Partner_Ranking ?> - <?= $LANGS['mostsub'] ?> (<?= $LANGS['alltime'] ?>) - Partners</a><br>
                <?php endif ?>

                <?php if ($Views_Ranking <= 50): ?><a href="/channels?order=views">#<?= $Views_Ranking ?> - <?= $LANGS['mostviewed'] ?> (<?= $LANGS['alltime'] ?>)</a><br><?php endif ?>

                <?php if ($Views_Category_Ranking <= 50): ?><a href="/channels?order=views&type=<?= $_PROFILE->Info["type"] ?>">#<?= $Views_Category_Ranking ?> - <?= $LANGS['mostviewed'] ?> (<?= $LANGS['alltime'] ?>) - <?= $Honor_Type[$_PROFILE->Info["type"]] ?></a><br><?php endif ?>

                <?php if ($_PROFILE->Info["is_partner"] and $Views_Partner_Ranking <= 50): ?>
                <a href="/channels?order=views">#<?= $Views_Partner_Ranking ?> - <?= $LANGS['mostviewed'] ?> (<?= $LANGS['alltime'] ?>) - Partners</a><br>
                <?php endif ?>
    </span>
    <?php if ($Honor_Count > 3): ?>
    <span id="MorevidDeschonors" style="display: block;font-size:11px;">(<a href="#" class="eLink" style="border-bottom: 1px dotted;text-decoration: none;" onclick="showhidehonors(); return false;"><?= $LANGS['dropdownmore'] ?></a>)</span>
    <span id="LessvidDeschonors" class="smallText" style="display: none;font-size: 11px;">(<a href="#" class="eLink" style="border-bottom: 1px dotted;text-decoration: none;" onclick="showhidehonors(); return false;"><?= $LANGS['honorless'] ?></a>)</span>
<?php endif ?>
</td>
                </tr></tbody></table>
            </div>
        </div>
<?php endif ?>
    </div>
    </div>
    <div class="cb"></div>
    </div>
<?php endif ?>
<?php if ($Module == "comments_l" || $Module == "comments_r" || $Module == "custombox_l" || $Module == "custombox_r" || $Module == "friends_l" || $Module == "friends_r" || $Module == "otherchannels_l" || $Module == "otherchannels_r" || $Module == "recentactivity_l" || $Module == "recentactivity_r" || $Module == "subscribers_l" || $Module == "subscribers_r" || $Module == "subscriptions_l" || $Module == "subscriptions_r" || $Module == "blips_l" || $Module == "blips_r"):?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/_templates/_profile/profile_modules/".$Module.".php" ?>
<?php endif ?>
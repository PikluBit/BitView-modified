<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
use function PHP81_BC\strftime;

$_USER->get_info();

if (isset($_USER->Info) && (isset($_GET['page']) && ($_GET['page'] == "partner" && $_USER->Info['is_partner'] == 0))) {
    header("location: /my_profile_load"); 
    exit(); 
}
$Months   = [$LANGS['january'] => 1,$LANGS['february'] => 2,$LANGS['march'] => 3,$LANGS['april'] => 4,$LANGS['may'] => 5,$LANGS['june'] => 6,$LANGS['july'] => 7,$LANGS['august'] => 8,$LANGS['september'] => 9,$LANGS['october'] => 10,$LANGS['november'] => 11,$LANGS['december'] => 12];
$Countries  = ['AF' => $LANGS['cat_AF'], 'AX' => $LANGS['cat_AX'], 'AL' => $LANGS['cat_AL'], 'DZ' => $LANGS['cat_DZ'], 'AS' => $LANGS['cat_AS'], 'AD' => $LANGS['cat_AD'], 'AO' => $LANGS['cat_AO'], 'AI' => $LANGS['cat_AI'], 'AQ' => $LANGS['cat_AQ'], 'AG' => $LANGS['cat_AG'], 'AR' => $LANGS['cat_AR'], 'AM' => $LANGS['cat_AM'], 'AW' => $LANGS['cat_AW'], 'AU' => $LANGS['cat_AU'], 'AT' => $LANGS['cat_AT'], 'AZ' => $LANGS['cat_AZ'], 'BS' => $LANGS['cat_BS'], 'BH' => $LANGS['cat_BH'], 'BD' => $LANGS['cat_BD'], 'BB' => $LANGS['cat_BB'], 'BY' => $LANGS['cat_BY'], 'BE' => $LANGS['cat_BE'], 'BZ' => $LANGS['cat_BZ'], 'BJ' => $LANGS['cat_BJ'], 'BM' => $LANGS['cat_BM'], 'BT' => $LANGS['cat_BT'], 'BO' => $LANGS['cat_BO'], 'BQ' => $LANGS['cat_BQ'], 'BA' => $LANGS['cat_BA'], 'BW' => $LANGS['cat_BW'], 'BV' => $LANGS['cat_BV'], 'BR' => $LANGS['cat_BR'], 'IO' => $LANGS['cat_IO'], 'VG' => $LANGS['cat_VG'], 'BN' => $LANGS['cat_BN'], 'BG' => $LANGS['cat_BG'], 'BF' => $LANGS['cat_BF'], 'BI' => $LANGS['cat_BI'], 'KH' => $LANGS['cat_KH'], 'CM' => $LANGS['cat_CM'], 'CA' => $LANGS['cat_CA'], 'CV' => $LANGS['cat_CV'], 'KY' => $LANGS['cat_KY'], 'CF' => $LANGS['cat_CF'], 'TD' => $LANGS['cat_TD'], 'CL' => $LANGS['cat_CL'],'CN'=> $LANGS['cat_CN'], 'CX' => $LANGS['cat_CX'], 'CC' => $LANGS['cat_CC'], 'CO' => $LANGS['cat_CO'], 'KM' => $LANGS['cat_KM'], 'CK' => $LANGS['cat_CK'], 'CR' => $LANGS['cat_CR'], 'HR' => $LANGS['cat_HR'], 'CU' => $LANGS['cat_CU'], 'CW' => $LANGS['cat_CW'], 'CY' => $LANGS['cat_CY'], 'CZ' => $LANGS['cat_CZ'], 'CD' => $LANGS['cat_CD'], 'DK' => $LANGS['cat_DK'], 'DJ' => $LANGS['cat_DJ'], 'DM' => $LANGS['cat_DM'], 'DO' => $LANGS['cat_DO'], 'TL' => $LANGS['cat_TL'], 'EC' => $LANGS['cat_EC'], 'EG' => $LANGS['cat_EG'], 'SV' => $LANGS['cat_SV'], 'GQ' => $LANGS['cat_GQ'], 'ER' => $LANGS['cat_ER'], 'EE' => $LANGS['cat_EE'], 'ET' => $LANGS['cat_ET'], 'FK' => $LANGS['cat_FK'], 'FO' => $LANGS['cat_DO'], 'FJ' => $LANGS['cat_FJ'], 'FI' => $LANGS['cat_FI'], 'FR' => $LANGS['cat_FR'], 'GF' => $LANGS['cat_GF'], 'PF' => $LANGS['cat_PF'], 'TF' => $LANGS['cat_TF'], 'GA' => $LANGS['cat_GA'], 'GM' => $LANGS['cat_GM'], 'GE' => $LANGS['cat_GE'], 'DE' => $LANGS['cat_DE'], 'GH' => $LANGS['cat_GH'], 'GI' => $LANGS['cat_GI'], 'GR' => $LANGS['cat_GR'], 'GL' => $LANGS['cat_GL'], 'GD' => $LANGS['cat_GD'], 'GP' => $LANGS['cat_GP'], 'GU' => $LANGS['cat_GU'], 'GT' => $LANGS['cat_GT'], 'GG' => $LANGS['cat_GG'], 'GN' => $LANGS['cat_GN'], 'GW' => $LANGS['cat_GW'], 'GY' => $LANGS['cat_GY'], 'HT' => $LANGS['cat_HT'], 'HM' => $LANGS['cat_HM'], 'HN' => $LANGS['cat_HN'], 'HK' => $LANGS['cat_HK'], 'HU' => $LANGS['cat_HU'], 'IS' => $LANGS['cat_IS'], 'IN' => $LANGS['cat_IN'], 'ID' => $LANGS['cat_ID'], 'IR' => $LANGS['cat_IR'], 'IQ' => $LANGS['cat_IQ'], 'IE' => $LANGS['cat_IE'], 'IM' => $LANGS['cat_IM'], 'IL' => $LANGS['cat_IL'], 'IT' => $LANGS['cat_IT'], 'CI' => $LANGS['cat_CI'], 'JM' => $LANGS['cat_JM'], 'JP' => $LANGS['cat_JP'], 'JE' => $LANGS['cat_JE'], 'JO' => $LANGS['cat_JO'], 'KZ' => $LANGS['cat_KZ'], 'KE' => $LANGS['cat_KE'], 'KI' => $LANGS['cat_KI'], 'XK' => $LANGS['cat_XK'], 'KW' => $LANGS['cat_KW'], 'KG' => $LANGS['cat_KG'], 'LA' => $LANGS['cat_LA'], 'LV' => $LANGS['cat_LV'], 'LB' => $LANGS['cat_LB'], 'LS' => $LANGS['cat_LS'], 'LR' => $LANGS['cat_LR'], 'LY' => $LANGS['cat_LY'], 'LI' => $LANGS['cat_LI'], 'LT' => $LANGS['cat_LI'], 'LU' => $LANGS['cat_LU'], 'MO' => $LANGS['cat_MO'], 'MK' => $LANGS['cat_MK'], 'MG' => $LANGS['cat_MG'], 'MW' => $LANGS['cat_MW'], 'MY' => $LANGS['cat_MY'], 'MV' => $LANGS['cat_MV'], 'ML' => $LANGS['cat_ML'], 'MT' => $LANGS['cat_MT'], 'MH' => $LANGS['cat_MH'], 'MQ' => $LANGS['cat_MQ'], 'MR' => $LANGS['cat_MR'], 'MU' => $LANGS['cat_MU'], 'YT' => $LANGS['cat_YT'], 'MX' => $LANGS['cat_MX'], 'FM' => $LANGS['cat_FM'], 'MD' => $LANGS['cat_MD'], 'MC' => $LANGS['cat_MC'], 'MN' => $LANGS['cat_MN'], 'ME' => $LANGS['cat_ME'], 'MS' => $LANGS['cat_MS'], 'MA' => $LANGS['cat_MA'], 'MZ' => $LANGS['cat_MZ'], 'MM' => $LANGS['cat_MM'], 'NA' => $LANGS['cat_NA'], 'NR' => $LANGS['cat_NR'], 'NP' => $LANGS['cat_NP'], 'NL' => $LANGS['cat_NL'], 'NC' => $LANGS['cat_NC'], 'NZ' => $LANGS['cat_NZ'], 'NI' => $LANGS['cat_NI'], 'NE' => $LANGS['cat_NE'], 'NG' => $LANGS['cat_NG'], 'NU' => $LANGS['cat_NU'], 'NF' => $LANGS['cat_NF'], 'KP' => $LANGS['cat_KP'], 'MP' => $LANGS['cat_MP'], 'NO' => $LANGS['cat_NO'], 'OM' => $LANGS['cat_OM'], 'PK' => $LANGS['cat_PK'], 'PW' => $LANGS['cat_PW'], 'PS' => $LANGS['cat_PS'], 'PA' => $LANGS['cat_PA'], 'PG' => $LANGS['cat_PG'], 'PY' => $LANGS['cat_PY'], 'PE' => $LANGS['cat_PE'], 'PH' => $LANGS['cat_PH'], 'PN' => $LANGS['cat_PN'], 'PL' => $LANGS['cat_PL'], 'PT' => $LANGS['cat_PT'], 'PR' => $LANGS['cat_PR'], 'QA' => $LANGS['cat_QA'], 'CG' => $LANGS['cat_CG'], 'RE' => $LANGS['cat_RE'], 'RO' => $LANGS['cat_RO'], 'RU' => $LANGS['cat_RU'], 'RW' => $LANGS['cat_RW'], 'BL' => $LANGS['cat_BL'], 'SH' => $LANGS['cat_SH'], 'KN' => $LANGS['cat_KN'], 'LC' => $LANGS['cat_LC'], 'MF' => $LANGS['cat_MF'], 'PM' => $LANGS['cat_PM'], 'VC' => $LANGS['cat_VC'], 'WS' => $LANGS['cat_WS'], 'SM' => $LANGS['cat_SM'], 'ST' => $LANGS['cat_ST'], 'SA' => $LANGS['cat_SA'], 'SN' => $LANGS['cat_SN'], 'RS' => $LANGS['cat_RS'], 'SC' => $LANGS['cat_SC'], 'SL' => $LANGS['cat_SL'], 'SG' => $LANGS['cat_SG'], 'SX' => $LANGS['cat_SX'], 'SK' => $LANGS['cat_SK'], 'SI' => $LANGS['cat_SI'], 'SB' => $LANGS['cat_SB'], 'SO' => $LANGS['cat_SO'], 'ZA' => $LANGS['cat_ZA'], 'GS' => $LANGS['cat_GS'], 'KR' => $LANGS['cat_KR'], 'SS' => $LANGS['cat_SS'], 'ES' => $LANGS['cat_ES'], 'LK' => $LANGS['cat_LK'], 'SD' => $LANGS['cat_SD'], 'SR' => $LANGS['cat_SR'], 'SJ' => $LANGS['cat_SJ'], 'SZ' => $LANGS['cat_SZ'], 'SE' => $LANGS['cat_SE'], 'CH' => $LANGS['cat_CH'], 'SY' => $LANGS['cat_SY'], 'TW' => $LANGS['cat_TW'], 'TJ' => $LANGS['cat_TJ'], 'TZ' => $LANGS['cat_TZ'], 'TH' => $LANGS['cat_TH'], 'TG' => $LANGS['cat_TG'], 'TK' => $LANGS['cat_TK'], 'TO' => $LANGS['cat_TO'], 'TT' => $LANGS['cat_TT'], 'TN' => $LANGS['cat_TN'], 'TR' => $LANGS['cat_TR'], 'TM' => $LANGS['cat_TM'], 'TC' => $LANGS['cat_TC'], 'TV' => $LANGS['cat_TV'], 'VI' => $LANGS['cat_VI'], 'UG' => $LANGS['cat_UG'], 'UA' => $LANGS['cat_UA'], 'AE' => $LANGS['cat_AE'], 'GB' => $LANGS['cat_GB'], 'US' => $LANGS['cat_US'], 'UY' => $LANGS['cat_UY'], 'UZ' => $LANGS['cat_UZ'], 'VU' => $LANGS['cat_VU'], 'VA' => $LANGS['cat_VA'], 'VE' => $LANGS['cat_VE'], 'VN' => $LANGS['cat_VN'], 'WF' => $LANGS['cat_WF'], 'EH' => $LANGS['cat_EH'], 'YE' => $LANGS['cat_YE'], 'ZM' => $LANGS['cat_ZM'], 'ZW' => $LANGS['cat_ZW']];
$Channel_Type = [0 => $LANGS['type0'], 1 => $LANGS['type1'], 2 => $LANGS['type2'], 3 => $LANGS['type3'], 4 => $LANGS['type4'], 5 => $LANGS['type5'], 6 => $LANGS['type6']];

$Birth_Year = date("Y",strtotime((string) $_USER->Info["i_age"]));
$Birth_Month = ltrim(date("m",strtotime((string) $_USER->Info["i_age"])),0);
$Birth_Day = ltrim(date("d",strtotime((string) $_USER->Info["i_age"])),0);
$CheckCountry = $_USER->Info["i_country"];

if ($_USER->Info["videos"] > 0) {
    $Total_Views = (int)$DB->execute("SELECT sum(views) as total FROM videos WHERE uploaded_by = :USERNAME", true, [":USERNAME" => $_USER->Username])["total"];
} else {
    $Total_Views = 0;
}
?>        
    <?php if (!isset($_GET['page']) || isset($_GET['page']) && $_GET['page'] == 'overview'): ?>
        <div class="overview-top">
            <div class="picture"><div class="user-thumb-jumbo"><a href="/user/<?= $_USER->Username ?>"><img src="<?= avatar($_USER->Username) ?>" width="120" height="90" <?php if ($_USER->Info["is_avatar_video"] == 1) : ?>class="avatarvideo"<?php endif ?> style="width: 94px;margin: 0;"></a></div><center style="margin-top:2px"><a href="#" onclick="openDropdown(); return false;"><?= $LANGS['change'] ?></a></center>
            </div>
            <div class="channel-info">
                <div class="info-column">
                    <div class="username"><a href="/user/<?= $_USER->Username ?>"><?= displayname($_USER->Username) ?></a></div>
                    <div class="info"><span class="grayText"><?= $LANGS['videoswatched'] ?>: </span><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_USER->Info["videos_watched"]) ?><?php else: ?><?= ($_USER->Info["videos_watched"]) ?><?php endif ?></div>
                    <div class="info"><span class="grayText"><?= $LANGS['uploadedvideos'] ?>: </span><?= $_USER->Info['videos'] ?></div>
                    <div class="info"><span class="grayText"><?= $LANGS['chvideoviews'] ?>: </span><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Total_Views) ?><?php else: ?><?= $Total_Views ?><?php endif ?></div>
                    <div class="info"><span class="grayText"><?= $LANGS['favorites'] ?>: </span><?= $_USER->Info['favorites'] ?></div>
                </div>
                <div class="info-column">
                    <div style="height: 20px;"></div>
                    <div class="info"><span class="grayText"><?= $LANGS['channeltype'] ?>: </span><?= $Channel_Type[$_USER->Info["type"]] ?></div>
                    <div class="info"><span class="grayText"><?= $LANGS['channelviews'] ?>: </span><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_USER->Info["profile_views"]) ?><?php else: ?><?= ($_USER->Info["profile_views"]) ?><?php endif ?></div>
                    <div class="info"><span class="grayText"><?= $LANGS['channelsubscribers'] ?>: </span><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_USER->Info["subscribers"]) ?><?php else: ?><?= ($_USER->Info["subscribers"]) ?><?php endif ?></div>
                </div>
                <div class="info-column">
                    <div style="height: 20px;"></div>
                    <div class="info"><strong><a href="/insight"><img src="/img/icon_insight.gif"> <span><?= $LANGS['insight'] ?></span></a></strong></div>
                    <div class="info"><strong><a href="/my_account#about"><img src="/img/icon_edit.png"> <span><?= $LANGS['editchannel'] ?></span></a></strong></div>
                </div>
        </div>
    </div>
    <div class="overview-bottom">
            <div class="options-box">
                <div class="options-box-column">
                <?= $LANGS['myvideos'] ?><br>
                <a href="/my_videos"><?= $LANGS['uploadedvideos'] ?></a><br>
                <a href="/my_favorites"><?= $LANGS['favorites'] ?></a><br>
                <a href="/my_playlists"><?= $LANGS['playlists'] ?></a><br>
                <a href="/my_subscriptions"><?= $LANGS['subscriptions'] ?></a><br>
                <a href="/my_quicklist">QuickList</a><br>
                <a href="/viewing_history"><?= $LANGS['history'] ?></a><br>
                </div>
                <div class="options-box-column">
                <?= $LANGS['mynetwork'] ?><br>
                <a href="/inbox"><?= $LANGS['inbox'] ?></a><br>
                <a href="/address_book"><?= $LANGS['addressbook'] ?></a><br>
                <a href="/user/<?= $_USER->Username ?>&page=subscribers"><?= $LANGS['channelsubscribers'] ?></a><br>
                <a href="/inbox?notification=1"><?= $LANGS['chvideocomments'] ?></a><br>
                </div>
                <div class="options-box-column">
                <?= $LANGS['chmore'] ?><br>
                <a href="/my_groups"><?= $LANGS['groups'] ?></a><br>
                <a href="/my_account#about"><?= $LANGS['editchannel'] ?></a><br>
                <a href="/my_account#playback"><?= $LANGS['playbacksetup'] ?></a><br>
                </div>
            </div>
    </div>
<?php elseif ($_GET['page'] == 'about') :?>
<form action="/my_account#about" method="post" enctype="multipart/form-data">
    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
    <div style="border-bottom: 1px solid #ccc;padding-bottom: 6px;margin-bottom: 6px;"><input type="submit" class="yt-uix-button yt-uix-button-primary" style="height: 25px;font-size: 12px;" name="save_profile_info" value="<?= $LANGS['editsavechanges'] ?>"></div>
    <div class="dropdown-block">
    <div class="dropdown-title open" id="about-me" onclick="openTab('about-me');"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['aboutme'] ?></strong></div>
    <div class="content" id="about-me-content" style="display:block;">
    <div style="margin-bottom:16px;">
    <table><tbody>
    <td>
    <span class="user-thumb-large">
    <a href="/user/<?= $_USER->Username ?>"><img src="<?= avatar($_USER->Username) ?>" <?php if ($_USER->Info["is_avatar_video"] == 1) : ?>class="avatarvideo"<?php endif ?> alt="<?= $_USER->Username ?>"></a>
    </span></td><td style="vertical-align: bottom;padding-left: 8px;">
    <input type="submit" class="yt-button" style="height: 25px;font-size: 12px;" name="change_avatar_image" value="<?= $LANGS['changepicture'] ?>" onclick="openDropdown();return false;">
</td></tbody></table></div>
    <div style="margin-bottom: 16px;"><?= $LANGS['describeyourself'] ?>:<br><textarea name="profile_about" maxlength="2048" style="width:400px;resize:vertical;height: 100px;margin-top: 4px;font-family: Arial, sans-serif;font-size: 12px;"><?= $_USER->Info["i_about"] ?></textarea></div>
    <div style="margin-bottom: 16px;"><?= $LANGS['website'] ?> (URL):<br><input type="text" name="profile_website" value="<?= $_USER->Info["i_website"] ?>" style="margin-top: 4px; width: 400px;" maxlength="64" /></div>
    </div>
</div>
<div class="dropdown-block">
    <div class="dropdown-title closed" id="personal-details" onclick="openTab('personal-details');"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['personaldetails'] ?></strong></div>
    <div class="content" id="personal-details-content" style="display:none;">
    <div style="margin-bottom: 16px;"><?= $LANGS['name'] ?>:<br><input type="text" name="profile_name" value="<?= $_USER->Info["i_name"] ?>" style="margin-top: 4px; width: 400px;" maxlength="64" /></div>
    <div style="margin-bottom: 16px;"><?= $LANGS['gender'] ?>:<br><select name="profile_gender">
    <option value="0"<?php if ($_USER->Info["i_gender"] == 0) : ?> selected<?php endif ?>><?= $LANGS['genderrelationprivate'] ?></option>
    <option value="1"<?php if ($_USER->Info["i_gender"] == 1) : ?> selected<?php endif ?>><?= $LANGS['male'] ?></option>
    <option value="2"<?php if ($_USER->Info["i_gender"] == 2) : ?> selected<?php endif ?>><?= $LANGS['female'] ?></option>
</select></div>
<div style="margin-bottom: 16px;"><?= $LANGS['relationship'] ?>:<br><select name="profile_relationship">
<option value="0"<?php if ($_USER->Info["i_relationship"] == 0) : ?> selected<?php endif ?>><?= $LANGS['genderrelationprivate'] ?></option>
<option value="1"<?php if ($_USER->Info["i_relationship"] == 1) : ?> selected<?php endif ?>><?= $LANGS['single_m'] ?></option>
<option value="2"<?php if ($_USER->Info["i_relationship"] == 2) : ?> selected<?php endif ?>><?= $LANGS['taken_m'] ?></option>
<option value="3"<?php if ($_USER->Info["i_relationship"] == 3) : ?> selected<?php endif ?>><?= $LANGS['married_m'] ?></option>
</select></div>
<div style="margin-bottom: 16px;"><?= $LANGS['birthday'] ?>:<br>
<select name="month">
    <?php foreach($Months as $item => $value) : ?>
        <option value="<?= $value ?>"<?php if ($Birth_Month == $value) : ?> selected<?php endif ?>><?= $item ?></option>
    <?php endforeach ?>
</select>
<select name="day">
    <?php for ($x = 1; $x <= 31; $x++) : ?>
        <option value="<?= $x ?>"<?php if ($Birth_Day == $x) : ?> selected<?php endif ?>><?= $x ?></option>
    <?php endfor ?>
</select>
<select name="year">
    <?php for($x = date("Y");$x >= 1910;$x--) : ?>
        <option value="<?= $x ?>"<?php if ($Birth_Year == $x) : ?> selected<?php endif ?>><?= $x ?></option>
    <?php endfor ?>
</select></div>
    </div>
</div>
<div class="dropdown-block">
    <div class="dropdown-title closed" id="hometown" onclick="openTab('hometown');"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['hometown'] ?> / <?= $LANGS['location'] ?></strong></div>
    <div class="content" id="hometown-content" style="display:none;">
    <div style="margin-bottom: 16px;"><?= $LANGS['hometown'] ?>:<br><input type="text" name="profile_hometown" value="<?= $_USER->Info["i_hometown"] ?>" style="margin-top: 4px; width: 400px;" maxlength="64" /></div>
    <div style="margin-bottom: 16px;"><?= $LANGS['country'] ?>:<br><select name="profile_country">
        <option value=""<?php if (!$CheckCountry) : ?> selected<?php endif ?>>------</option>
    <?php foreach($Countries as $value => $item) : ?>
        <option value="<?= $value ?>"<?php if ($CheckCountry == $value) : ?> selected<?php endif ?>><?= $item ?></option>
    <?php endforeach ?>
</select></div>
    </div>
</div>
<div class="dropdown-block">
    <div class="dropdown-title closed" id="jobs" onclick="openTab('jobs');"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['jobscareer'] ?></strong></div>
    <div class="content" id="jobs-content" style="display:none;">
    <div style="margin-bottom: 16px;"><?= $LANGS['occupation'] ?>:<br><input type="text" name="profile_occupation" value="<?= $_USER->Info["i_occupation"] ?>" style="margin-top: 4px; width: 400px;" maxlength="64" /></div>
    <div style="margin-bottom: 16px;"><?= $LANGS['companies'] ?>:<br><input type="text" name="profile_companies" value="<?= $_USER->Info["i_companies"] ?>" style="margin-top: 4px; width: 400px;" maxlength="64" /></div>
    </div>
</div>
<div class="dropdown-block">
    <div class="dropdown-title closed" id="education" onclick="openTab('education');"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['education'] ?></strong></div>
    <div class="content" id="education-content" style="display:none;">
    <div style="margin-bottom: 16px;"><?= $LANGS['schools'] ?>:<br><input type="text" name="profile_schools" value="<?= $_USER->Info["i_schools"] ?>" style="margin-top: 4px; width: 400px;" maxlength="64" /></div>
    </div>
</div>
<div class="dropdown-block" style="border-bottom: 0;">
    <div class="dropdown-title closed" id="interests" onclick="openTab('interests');"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['interests'] ?></strong></div>
    <div class="content" id="interests-content" style="display:none;">
    <div style="margin-bottom: 16px;"><?= $LANGS['hobbies'] ?>:<br><input type="text" name="profile_hobbies" value="<?= $_USER->Info["i_hobbies"] ?>" style="margin-top: 4px; width: 400px;" maxlength="64" /></div>
    <div style="margin-bottom: 16px;"><?= $LANGS['movies'] ?>:<br><input type="text" name="profile_movies" value="<?= $_USER->Info["i_movies"] ?>" style="margin-top: 4px; width: 400px;" maxlength="64" /></div>
    <div style="margin-bottom: 16px;"><?= $LANGS['music'] ?>:<br><input type="text" name="profile_music" value="<?= $_USER->Info["i_music"] ?>" style="margin-top: 4px; width: 400px;" maxlength="64" /></div>
    <div style="margin-bottom: 16px;"><?= $LANGS['books'] ?>:<br><input type="text" name="profile_books" value="<?= $_USER->Info["i_books"] ?>" style="margin-top: 4px; width: 400px;" maxlength="64" /></div>
    </div>
</div>
    <div style="border-top: 1px solid #ccc;padding-top: 6px;margin-top: 6px;"><input type="submit" class="yt-uix-button yt-uix-button-primary" style="height: 25px;font-size: 12px;" name="save_profile_info" value="<?= $LANGS['editsavechanges'] ?>"></div>
</form>
<?php elseif ($_GET['page'] == 'playback') :?>
<form action="/my_account#playback" method="post">
    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
    <div style="border-bottom: 1px solid #ccc;padding-bottom: 6px;margin-bottom: 6px;"><input type="submit" class="yt-uix-button yt-uix-button-primary" style="height: 25px;font-size: 12px;" name="save_playback_info" value="<?= $LANGS['editsavechanges'] ?>"></div>
    <div class="dropdown-block" style="border-bottom:0">
    <div class="dropdown-title open" id="playback" onclick="openTab('playback');"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['videoplaybackquality'] ?></strong></div>
    <div class="content" id="playback-content" style="display:block;">
    <div style="margin-bottom: 16px;"><span style="color:#666"><?= $LANGS['videoplaybackqualitydesc'] ?></span><br>
    <input type="radio" id="hd_yes" name="hd" value="1" <?php if (isset($_COOKIE['vlphd']) && $_COOKIE['vlphd'] == 1): ?>checked<?php endif ?>>
    <label for="hd_yes"><?= $LANGS['alwayshd'] ?></label><br>
    <input type="radio" id="hd_no" name="hd" value="0" <?php if (isset($_COOKIE['vlphd']) && $_COOKIE['vlphd'] == 0): ?>checked<?php endif ?>>
    <label for="hd_no"><?= $LANGS['neverhd'] ?></label><br>
    </div>
    </div>
</div>
    <div style="border-top: 1px solid #ccc;padding-top: 6px;margin-top: 6px;"><input type="submit" class="yt-uix-button yt-uix-button-primary" style="height: 25px;font-size: 12px;" name="save_playback_info" value="<?= $LANGS['editsavechanges'] ?>"></div>
</form>
<?php elseif ($_GET['page'] == "modules"): ?>   
                <form action="/my_profile_modules" method="post">
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
                    <div style="border-bottom: 1px solid #ccc;padding-bottom: 6px;margin-bottom: 6px;"><input type="submit" class="yt-uix-button yt-uix-button-primary" name="save_profile" value="<?= $LANGS['editsavechanges'] ?>"></div>
                    <div class="dropdown-title" id="customize-homepage"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['customizethehomepage'] ?></strong></div>
                    <div class="dropdown-description" id="customize-homepage" style="color: #666;padding: 4px 18px;"><?= $LANGS['customizehomepagedesc'] ?></div>
                    <div class="content" id="about-me-content">
                        <table border="0" cellpadding="5" cellspacing="0">
                            <tr>
                                <td align="middle"><input type="checkbox" name="subscriptions" id="subscriptions"<?php if ($_USER->Info["h_subscriptions"] == 1) : ?> checked<?php endif ?>></td>
                                <td style="vertical-align: middle;"><label for="subscriptions"><?= $LANGS['subscriptions'] ?></label></td>
                            </tr>
                            <tr>
                                <td align="middle"><input type="checkbox" name="recommended" id="recommended"<?php if ($_USER->Info["h_recommended"] == 1) : ?> checked<?php endif ?>></td>
                                <td style="vertical-align: middle;"><label for="recommended"><?= $LANGS['recommendedforyou'] ?></label></td>
                            </tr>
                            <tr>
                                <td align="middle"><input type="checkbox" name="activity" id="activity"<?php if ($_USER->Info["h_activity"] == 1) : ?> checked<?php endif ?>></td>
                                <td style="vertical-align: middle;"><label for="activity"><?= $LANGS['friendactivity'] ?></label></td>
                            </tr>
                            <tr>
                                <td align="middle"><input type="checkbox" name="beingwatched" id="beingwatched"<?php if ($_USER->Info["h_beingwatched"] == 1) : ?> checked<?php endif ?>></td>
                                <td style="vertical-align: middle;"><label for="beingwatched"><?= $LANGS['beingwatched'] ?></label></td>
                            </tr>
                            <tr>
                                <td align="middle"><input type="checkbox" name="featured" id="featured"<?php if ($_USER->Info["h_featured"] == 1) : ?> checked<?php endif ?>></td>
                                <td style="vertical-align: middle;"><label for="featured"><?= $LANGS['featured'] ?></label></td>
                            </tr>
                            <tr>
                                <td align="middle"><input type="checkbox" name="mostpop" id="mostpop"<?php if ($_USER->Info["h_mostpop"] == 1) : ?> checked<?php endif ?>></td>
                                <td style="vertical-align: middle;"><label for="mostpop"><?= $LANGS['mostpopular'] ?></label></td>
                            </tr>
                        </table>
                        <br><div><strong><?= $LANGS['displaypreferences'] ?></strong></div>
                        <div><input type="checkbox" name="feed" id="feed"<?php if ($_USER->Info["h_feed"] == 1) : ?> checked<?php endif ?>>
                                <label for="feed"><strong><?= $LANGS['thefeed'] ?></strong>: <?= $LANGS['thefeeddesc'] ?></label></div>
                        <br><div><strong><?= $LANGS['friendactivitytitle'] ?></strong></div>
                        <div class="dropdown-description" id="customize-homepage" style="color: #666; margin-bottom: 10px;"><?= $LANGS['friendactivitydesc'] ?></div>
                    </div>
                    <div style="border-top: 1px solid #ccc;padding-top: 6px;margin-top: 6px;"><input type="submit" class="yt-uix-button yt-uix-button-primary" name="save_profile" value="<?= $LANGS['editsavechanges'] ?>"></div>
                </form>
                    
<?php elseif ($_GET['page'] == 'email') :?>
<form action="/my_account#email" method="post">
    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
    <div style="border-bottom: 1px solid #ccc;padding-bottom: 6px;margin-bottom: 6px;"><input type="submit" class="yt-uix-button yt-uix-button-primary" style="height: 25px;font-size: 12px;" name="save_email_info" value="<?= $LANGS['editsavechanges'] ?>"></div>
    <div class="dropdown-block">
    <div class="dropdown-title open" id="address" onclick="openTab('address');"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['email'] ?></strong></div>
    <div class="content" id="address-content" style="display:block;">
    <div style="margin-bottom: 16px;"><?= $LANGS['currentemail'] ?>: <span style="color:#666"><?= $_USER->Info['email'] ?></span>
    </div>
    <div style="margin-bottom: 16px;"><?= $LANGS['changeemailaddress'] ?>: 
        <br>
        <input type="text" name="email" placeholder="Your New Email Address..." style="margin-top: 4px; width: 400px;" maxlength="64">
        <input type="password" name="email_password" placeholder="Your Password..." style="margin-top: 4px; width: 400px;" maxlength="64">
        <br><input type="submit" class="yt-button" style="height: 25px;font-size: 12px;margin: 4px 0;" name="change_email" value="<?= $LANGS['changeemail'] ?>">
    </div>
</div>
</div>
<div class="dropdown-block" style="border-bottom:0;">
    <div class="dropdown-title closed" id="preferences" onclick="openTab('preferences');"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['emailprefs'] ?></strong></div>
    <div class="content" id="preferences-content" style="display:none;">
    <div style="margin-bottom: 4px;"><input type="checkbox" name="e_messages" id="e_messages"<?php if ($_USER->Info["e_messages"] == 1) : ?> checked<?php endif ?>> <label for="e_messages"><?= $LANGS['emailpm'] ?></label>
    </div>
    <div style="margin-bottom: 4px;"><input type="checkbox" name="e_comments" id="e_comments"<?php if ($_USER->Info["e_comments"] == 1) : ?> checked<?php endif ?>> <label for="e_comments"><?= $LANGS['emailcomm'] ?></label>
    </div><div style="margin-bottom: 4px;">
    <div><input type="checkbox" name="e_subscriptions" id="e_subscriptions"<?php if ($_USER->Info["e_subscriptions"] == 1) : ?> checked<?php endif ?>> <label for="e_subscriptions"><?= $LANGS['emailsub'] ?></label>
    </div>
</div>
</div>
    <div style="border-top: 1px solid #ccc;padding-top: 6px;margin-top: 6px;"><input type="submit" class="yt-uix-button yt-uix-button-primary" style="height: 25px;font-size: 12px;" name="save_email_info" value="<?= $LANGS['editsavechanges'] ?>"></div>
</form>
<?php elseif ($_GET['page'] == 'partner' and $_USER->Info['is_partner'] == 1) :?>
<style>
    .content td {
        margin: 0;
        padding: 4px;
        vertical-align: top;
    }
</style>
<form action="/my_account#partner" method="post" enctype="multipart/form-data">
    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
    <div style="border-bottom: 1px solid #ccc;padding-bottom: 6px;margin-bottom: 6px;"><input type="submit" class="yt-uix-button yt-uix-button-primary" style="height: 25px;font-size: 12px;" name="save_partner_settings" value="<?= $LANGS['editsavechanges'] ?>"></div>
    <div class="dropdown-block">
    <div class="dropdown-title open" id="images" onclick="openTab('images');"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['partnerimages'] ?></strong></div>
    <div class="content" id="images-content" style="display:block;">
    <table>
<tr style="display: none;">
<td align="right"><span style="font-weight:bold"><?= $LANGS['bannerimage'] ?>:<br><span class="smallText" style="color:#666; font-weight: normal;">(<?= $LANGS['recommendedsize'] ?>: 960x150)</span></td>
<?php if(!$_USER->Info["c_banner_image"]) : ?>
<td><input type="file" name="banner_img"> <input type="submit" name="change_banner_img" value="<?= $LANGS['submitimage'] ?>"></td>
<?php else : ?>
<td><input type="submit" name="delete_banner_image" class="yt-button" value="<?= $LANGS['deleteimage'] ?>"></td>
<td style="padding:0"><img src="<?= cache_bust($_USER->Info["c_banner_image"]) ?>" width="300"></td>
<?php endif ?>
</tr>
<tr>
<td align="right"><span style="font-weight:bold"><?= $LANGS['bannerimage'] ?>:<br><span class="smallText" style="color:#666; font-weight: normal;">(<?= $LANGS['recommendedsize'] ?>: 960x150)</span></td>
<?php if(!$_USER->Info["c_banner_image"]) : ?>
<td><input type="file" name="banner_img"> <input type="submit" name="change_banner_img" value="<?= $LANGS['submitimage'] ?>"></td>
<?php else : ?>
<td><input type="submit" name="delete_banner_image" class="yt-button" style="height: 25px;font-size: 12px;" value="<?= $LANGS['deleteimage'] ?>"></td>
<td style="padding:0"><img src="<?= cache_bust($_USER->Info["c_banner_image"]) ?>" width="300"></td>
<?php endif ?>
</tr>
<tr>
<td align="right"><span style="font-weight:bold"><?= $LANGS['minibannerimage'] ?>:<br><span class="smallText" style="color:#666; font-weight: normal;">(<?= $LANGS['recommendedsize'] ?>: 170x25)</span></td>
<?php if(!$_USER->Info["c_mbanner_image"]) : ?>
<td><input type="file" name="mbanner_image"> <input type="submit" name="change_mbanner_image" value="<?= $LANGS['submitimage'] ?>"></td>
<?php else : ?>
<td><input type="submit" name="delete_mbanner_image" class="yt-button" style="height: 25px;font-size: 12px;" value="<?= $LANGS['deleteimage'] ?>"></td>
<td><img src="<?= cache_bust($_USER->Info["c_mbanner_image"]) ?>" width="170"></td>
<?php endif ?>
</tr>
<tr>
<td align="right"><span style="font-weight:bold"><?= $LANGS['sideimage'] ?>:<br><span class="smallText" style="color:#666; font-weight: normal;">(<?= $LANGS['recommendedsize'] ?>: 300x250)</span></td>
<?php if(!$_USER->Info["c_sideimage"]) : ?>
<form action="/my_account" method="POST" enctype="multipart/form-data">
<input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
<td><input type="file" name="side_image"> <input type="submit" name="change_side_image" value="<?= $LANGS['submitimage'] ?>"></td>
</form>
<?php else : ?>
<form action="/my_account" method="POST" enctype="multipart/form-data">
<input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
<td><input type="submit" name="delete_side_image" class="yt-button" style="height: 25px;font-size: 12px;" value="<?= $LANGS['deleteimage'] ?>"></td>
</form>
<td><img src="<?= cache_bust($_USER->Info["c_sideimage"]) ?>" width="300"></td>
<?php endif ?>
</tr>
</table>
</div>
</div>
<div class="dropdown-block">
    <div class="dropdown-title closed" id="links" onclick="openTab('links');"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['partnerimagelinks'] ?></strong></div>
    <div class="content" id="links-content" style="display:none;">
        <table border="0" cellpadding="5" cellspacing="0">
<tr>
<td align="right"><span style="font-weight:bold"><?= $LANGS['bannerlink'] ?>:</span></td>
<td><input type="text" name="banner_website" value="<?= $_USER->Info["banner_link"] ?>" maxlength="64" style="width:200px" /></td>
</tr>
<tr>
<td align="right"><span style="font-weight:bold"><?= $LANGS['or'] ?></span></td>
<td></td>
</tr>
<tr>
<td align="right"><span style="font-weight:bold"><?= $LANGS['bannerimagemap'] ?>:</span></td>
<td><textarea name="banner_map" maxlength="1024" style="width: 300px;resize:vertical;height: 60px;margin-top: 4px;font-family: Arial, sans-serif;font-size: 12px;"><?= $_USER->Info["banner_map"] ?></textarea><br><a href="#" onclick="document.getElementById('format-info').classList.toggle('hid');return false;"><?= $LANGS['formatinfo'] ?></a></td>
</tr>
<tr class="hid" id="format-info">
<td align="right"></td>
<td><div style="background: #eee;border: 1px solid #ccc;padding: 6px;font-family: monospace;width: 450px;">&lt;map&gt; <b>&lt;---- <?= $LANGS['formatoptional'] ?></b><br />
&nbsp;&nbsp; &nbsp;&lt;area target=&quot;&quot; alt=&quot;Visit my website&quot; title=&quot;Visit my website&quot; href=&quot;http://www.example.com&quot;&nbsp;coords=&quot;25,50,200,100&quot; shape=&quot;rect&quot;&gt;<br />
&nbsp;&nbsp; &nbsp;&lt;area ...<br />
&nbsp;&nbsp; &nbsp;... &gt;<br />
&lt;/map&gt; <b>&lt;---- <?= $LANGS['formatoptional'] ?></b></div></td>
</tr>
<tr>
<td align="right" style="padding:18px"></td>
<td></td>
</tr>
<tr>
<td align="right"><span style="font-weight:bold"><?= $LANGS['sideimagelink'] ?>:</span></td>
<td><input type="text" name="side_website" value="<?= $_USER->Info["sideimage_link"] ?>" maxlength="64" style="width:200px" /></td>
</tr>
<tr>
<td align="right"><span style="font-weight:bold"><?= $LANGS['or'] ?></span></td>
<td></td>
</tr>
<tr>
<td align="right"><span style="font-weight:bold"><?= $LANGS['sideimagemap'] ?>:</span></td>
<td><textarea name="side_map" maxlength="1024" style="width: 300px;resize:vertical;height: 60px;margin-top: 4px;font-family: Arial, sans-serif;font-size: 12px;"><?= $_USER->Info["sideimage_map"] ?></textarea><br><a href="#" onclick="document.getElementById('format-info').classList.toggle('hid');return false;"><?= $LANGS['formatinfo'] ?></a></td>
</tr>
</table>
</div>
</div>
<div class="dropdown-block" style="border-bottom:0;">
    <div class="dropdown-title closed" id="custom-box" onclick="openTab('custom-box');"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['custombox'] ?></strong></div>
    <div class="content" id="custom-box-content" style="display:none;">
        <table border="0" cellpadding="5" cellspacing="0">
<tr>
<td align="middle"><input type="checkbox" name="c_custom_box" id="c_custom_box"<?php if ($_USER->Info["c_custom_box"] == 1) : ?> checked<?php endif ?>></td>
<td><label for="c_custom_box"><?= $LANGS['custombox'] ?></label></td>
</tr>
<tr>
<td align="right"><span style="font-weight:bold"><?= $LANGS['customboxtitle'] ?>:</span></td>
<td><input type="text" name="custom_box_title" value="<?= $_USER->Info["custom_box_title"] ?>" maxlength="60" style="width:200px" /></td>
</tr>
<tr>
<td align="right"><span style="font-weight:bold"><?= $LANGS['customboxcontent'] ?>:</span></td>
<td><textarea name="custom_box" maxlength="1024" style="width:350px;resize:vertical;height:275px;"><?= $_USER->Info["custom_box"] ?></textarea></td>
</tr>
</table>
</div>
</div>
    <div style="border-top: 1px solid #ccc;padding-top: 6px;margin-top: 6px;"><input type="submit" class="yt-uix-button yt-uix-button-primary" style="height: 25px;font-size: 12px;" name="save_partner_settings" value="<?= $LANGS['editsavechanges'] ?>"></div>
</form>
<?php elseif ($_GET['page'] == 'manageaccount') :?>
    <div class="dropdown-block">
    <div class="dropdown-title open" style="padding: 5px 0;" id="guidelinesstatus" onclick="openTab('guidelinesstatus');"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['accountstatuscg'] ?></strong></div>
    <div class="content" id="guidelinesstatus-content" style="display:block;">
    <div style="margin-bottom: 16px;"><?= $LANGS['goodaccount'] ?>
    </div>
    </div>
    </div>
    <div class="dropdown-block">
    <div class="dropdown-title closed" style="padding: 5px 0;" id="copyrightstatus" onclick="openTab('copyrightstatus');"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['accountstatuscopy'] ?></strong></div>
    <div class="content" id="copyrightstatus-content" style="display:none;">
    <?php $Strikes = $DB->execute("SELECT count(url) as amount FROM copyright_strikes WHERE for_user = :USERNAME",true,[":USERNAME" => $_USER->Username])["amount"]; ?>
    <div style="margin-bottom: 16px;"><?php if ($Strikes == 0) : ?><?= $LANGS['goodaccount'] ?><?php else: ?><span style="color: red;"><?php if ($Strikes > 1) : ?><?= str_replace("{s}",$Strikes,$LANGS['accountstrikes']) ?><?php else: ?><?= str_replace("{s}",$Strikes,$LANGS['accountstrike']) ?><?php endif?></span><?php endif?>
    </div>
    </div>
    </div>
    <form action="/my_account#manageaccount" method="post" onsubmit="return confirm('Are you sure you want to change your username?');">
    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
    <div class="dropdown-block">
    <div class="dropdown-title closed" style="padding: 5px 0;" id="changeusername" onclick="openTab('changeusername');"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['changeusername'] ?></strong></div>
    <div class="content" id="changeusername-content" style="display:none;">
    <?php if (strtotime((string) $_USER->Info['username_change'])<strtotime('-6 months')): ?>
    <div style="margin-bottom: 16px;"><?= $LANGS['usernamechangedesc'] ?>
        <br>
        <span style="width: 140px;display: inline-block;"><?= $LANGS['newusername'] ?>: </span><input type="text" name="new_username" style="margin-top: 4px; width: 150px;" maxlength="20"><br>
        <span style="width: 140px;display: inline-block;"><?= $LANGS['password'] ?>: </span><input type="password" name="username_password" style="margin-top: 4px; width: 150px;" maxlength="64">
        <br><input type="submit" class="yt-button" style="height: 25px;font-size: 12px;margin: 4px 0;" name="change_username" value="<?= $LANGS['changeusername'] ?>">
    </div>
    <?php else: ?>
        <b style="color: red"><?= $LANGS['cannotchangeusername'] ?><?php setlocale(LC_TIME, $LANGS['languagecode']);
    echo strftime($LANGS['myvideostimeformat'], strtotime('+6 months', strtotime((string) $_USER->Info['username_change'])));  ?>.</b>
    <?php endif ?>
    </div>
    </div>
    </form>
    <form action="/my_account#manageaccount" method="post" onsubmit="return confirm('Are you sure you want to change your password?');">
    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
    <div class="dropdown-block">
    <div class="dropdown-title closed" style="padding: 5px 0;" id="changepass" onclick="openTab('changepass');"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['changepassword'] ?></strong></div>
    <div class="content" id="changepass-content" style="display:none;">
    <div style="margin-bottom: 16px;">
        <span style="width: 140px;display: inline-block;"><?= $LANGS['currentpassword'] ?>: </span><input type="password" name="current_password" style="margin-top: 4px; width: 150px;" maxlength="64"><br>
        <span style="width: 140px;display: inline-block;"><?= $LANGS['newpassword'] ?>: </span><input type="password" name="new_password" style="margin-top: 4px; width: 150px;" maxlength="20"><br>
        <span style="width: 140px;display: inline-block;"><?= $LANGS['confirmnewpassword'] ?>: </span><input type="password" name="confirm_new_password" style="margin-top: 4px; width: 150px;" maxlength="20">
        <br><input type="submit" class="yt-button" style="height: 25px;font-size: 12px;margin: 4px 0;" name="change_password" value="<?= $LANGS['changepassword'] ?>">
    </div>
    </div>
    </div>
    </form>
    <form action="/my_account#manageaccount" method="post" onsubmit="return confirm('Do you really want to delete your account? Closing your account will PERMANENTLY remove your profile information from BitView! You will not be able to reopen your account once it\'s deleted.');">
    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
    <div class="dropdown-block" style="border-bottom:0">
    <div class="dropdown-title closed" style="padding: 5px 0;" id="deleteacc" onclick="openTab('deleteacc');"><img src="/img/pixel.gif" id="dropdownarrow"><strong><?= $LANGS['deleteaccount'] ?></strong></div>
    <div class="content" id="deleteacc-content" style="display:none;">
    <div style="margin-bottom: 16px;"><?= $LANGS['enterpassword'] ?>:  
        <input type="password" name="delete_password" style="margin-top: 4px; width: 150px;" maxlength="64">
        <br><input type="submit" class="yt-button" style="height: 25px;font-size: 12px;margin: 4px 0;" name="delete_account" value="<?= $LANGS['deleteaccount'] ?>">
    </div>
    </div>
    </div>
    </form>
<?php endif ?>
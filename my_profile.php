<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

// CSRF PROTECTION
if (strtoupper((string) $_SERVER['REQUEST_METHOD']) === 'GET') {
    $_SESSION['token'] = bin2hex(random_bytes(35));
}

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) { header("location: /login"); exit(); }
if (isset($_USER->Info["channel_new"]) && $_USER->Info["channel_new"] == 1 && (isset($_GET['page']) && $_GET['page'] != "about" && $_GET['page'] != "email" && $_GET['page'] != "playback" && $_GET['page'] != "partner")) {
    header("location: /my_account"); 
    exit(); 
}
$_USER->get_info();
if (isset($_USER->Info) && $_USER->Info["channel_new"] == 1 && (isset($_GET['page']) && $_GET['page'] == "partner" && $_USER->Info['is_partner'] == 0)) {
    header("location: /my_account"); 
    exit(); 
}
$Months   = [$LANGS['january'] => 1,$LANGS['february'] => 2,$LANGS['march'] => 3,$LANGS['april'] => 4,$LANGS['may'] => 5,$LANGS['june'] => 6,$LANGS['july'] => 7,$LANGS['august'] => 8,$LANGS['september'] => 9,$LANGS['october'] => 10,$LANGS['november'] => 11,$LANGS['december'] => 12];
$Countries  = ['AF' => $LANGS['cat_AF'], 'AX' => $LANGS['cat_AX'], 'AL' => $LANGS['cat_AL'], 'DZ' => $LANGS['cat_DZ'], 'AS' => $LANGS['cat_AS'], 'AD' => $LANGS['cat_AD'], 'AO' => $LANGS['cat_AO'], 'AI' => $LANGS['cat_AI'], 'AQ' => $LANGS['cat_AQ'], 'AG' => $LANGS['cat_AG'], 'AR' => $LANGS['cat_AR'], 'AM' => $LANGS['cat_AM'], 'AW' => $LANGS['cat_AW'], 'AU' => $LANGS['cat_AU'], 'AT' => $LANGS['cat_AT'], 'AZ' => $LANGS['cat_AZ'], 'BS' => $LANGS['cat_BS'], 'BH' => $LANGS['cat_BH'], 'BD' => $LANGS['cat_BD'], 'BB' => $LANGS['cat_BB'], 'BY' => $LANGS['cat_BY'], 'BE' => $LANGS['cat_BE'], 'BZ' => $LANGS['cat_BZ'], 'BJ' => $LANGS['cat_BJ'], 'BM' => $LANGS['cat_BM'], 'BT' => $LANGS['cat_BT'], 'BO' => $LANGS['cat_BO'], 'BQ' => $LANGS['cat_BQ'], 'BA' => $LANGS['cat_BA'], 'BW' => $LANGS['cat_BW'], 'BV' => $LANGS['cat_BV'], 'BR' => $LANGS['cat_BR'], 'IO' => $LANGS['cat_IO'], 'VG' => $LANGS['cat_VG'], 'BN' => $LANGS['cat_BN'], 'BG' => $LANGS['cat_BG'], 'BF' => $LANGS['cat_BF'], 'BI' => $LANGS['cat_BI'], 'KH' => $LANGS['cat_KH'], 'CM' => $LANGS['cat_CM'], 'CA' => $LANGS['cat_CA'], 'CV' => $LANGS['cat_CV'], 'KY' => $LANGS['cat_KY'], 'CF' => $LANGS['cat_CF'], 'TD' => $LANGS['cat_TD'], 'CL' => $LANGS['cat_CL'],'CN'=> $LANGS['cat_CN'], 'CX' => $LANGS['cat_CX'], 'CC' => $LANGS['cat_CC'], 'CO' => $LANGS['cat_CO'], 'KM' => $LANGS['cat_KM'], 'CK' => $LANGS['cat_CK'], 'CR' => $LANGS['cat_CR'], 'HR' => $LANGS['cat_HR'], 'CU' => $LANGS['cat_CU'], 'CW' => $LANGS['cat_CW'], 'CY' => $LANGS['cat_CY'], 'CZ' => $LANGS['cat_CZ'], 'CD' => $LANGS['cat_CD'], 'DK' => $LANGS['cat_DK'], 'DJ' => $LANGS['cat_DJ'], 'DM' => $LANGS['cat_DM'], 'DO' => $LANGS['cat_DO'], 'TL' => $LANGS['cat_TL'], 'EC' => $LANGS['cat_EC'], 'EG' => $LANGS['cat_EG'], 'SV' => $LANGS['cat_SV'], 'GQ' => $LANGS['cat_GQ'], 'ER' => $LANGS['cat_ER'], 'EE' => $LANGS['cat_EE'], 'ET' => $LANGS['cat_ET'], 'FK' => $LANGS['cat_FK'], 'FO' => $LANGS['cat_DO'], 'FJ' => $LANGS['cat_FJ'], 'FI' => $LANGS['cat_FI'], 'FR' => $LANGS['cat_FR'], 'GF' => $LANGS['cat_GF'], 'PF' => $LANGS['cat_PF'], 'TF' => $LANGS['cat_TF'], 'GA' => $LANGS['cat_GA'], 'GM' => $LANGS['cat_GM'], 'GE' => $LANGS['cat_GE'], 'DE' => $LANGS['cat_DE'], 'GH' => $LANGS['cat_GH'], 'GI' => $LANGS['cat_GI'], 'GR' => $LANGS['cat_GR'], 'GL' => $LANGS['cat_GL'], 'GD' => $LANGS['cat_GD'], 'GP' => $LANGS['cat_GP'], 'GU' => $LANGS['cat_GU'], 'GT' => $LANGS['cat_GT'], 'GG' => $LANGS['cat_GG'], 'GN' => $LANGS['cat_GN'], 'GW' => $LANGS['cat_GW'], 'GY' => $LANGS['cat_GY'], 'HT' => $LANGS['cat_HT'], 'HM' => $LANGS['cat_HM'], 'HN' => $LANGS['cat_HN'], 'HK' => $LANGS['cat_HK'], 'HU' => $LANGS['cat_HU'], 'IS' => $LANGS['cat_IS'], 'IN' => $LANGS['cat_IN'], 'ID' => $LANGS['cat_ID'], 'IR' => $LANGS['cat_IR'], 'IQ' => $LANGS['cat_IQ'], 'IE' => $LANGS['cat_IE'], 'IM' => $LANGS['cat_IM'], 'IL' => $LANGS['cat_IL'], 'IT' => $LANGS['cat_IT'], 'CI' => $LANGS['cat_CI'], 'JM' => $LANGS['cat_JM'], 'JP' => $LANGS['cat_JP'], 'JE' => $LANGS['cat_JE'], 'JO' => $LANGS['cat_JO'], 'KZ' => $LANGS['cat_KZ'], 'KE' => $LANGS['cat_KE'], 'KI' => $LANGS['cat_KI'], 'XK' => $LANGS['cat_XK'], 'KW' => $LANGS['cat_KW'], 'KG' => $LANGS['cat_KG'], 'LA' => $LANGS['cat_LA'], 'LV' => $LANGS['cat_LV'], 'LB' => $LANGS['cat_LB'], 'LS' => $LANGS['cat_LS'], 'LR' => $LANGS['cat_LR'], 'LY' => $LANGS['cat_LY'], 'LI' => $LANGS['cat_LI'], 'LT' => $LANGS['cat_LI'], 'LU' => $LANGS['cat_LU'], 'MO' => $LANGS['cat_MO'], 'MK' => $LANGS['cat_MK'], 'MG' => $LANGS['cat_MG'], 'MW' => $LANGS['cat_MW'], 'MY' => $LANGS['cat_MY'], 'MV' => $LANGS['cat_MV'], 'ML' => $LANGS['cat_ML'], 'MT' => $LANGS['cat_MT'], 'MH' => $LANGS['cat_MH'], 'MQ' => $LANGS['cat_MQ'], 'MR' => $LANGS['cat_MR'], 'MU' => $LANGS['cat_MU'], 'YT' => $LANGS['cat_YT'], 'MX' => $LANGS['cat_MX'], 'FM' => $LANGS['cat_FM'], 'MD' => $LANGS['cat_MD'], 'MC' => $LANGS['cat_MC'], 'MN' => $LANGS['cat_MN'], 'ME' => $LANGS['cat_ME'], 'MS' => $LANGS['cat_MS'], 'MA' => $LANGS['cat_MA'], 'MZ' => $LANGS['cat_MZ'], 'MM' => $LANGS['cat_MM'], 'NA' => $LANGS['cat_NA'], 'NR' => $LANGS['cat_NR'], 'NP' => $LANGS['cat_NP'], 'NL' => $LANGS['cat_NL'], 'NC' => $LANGS['cat_NC'], 'NZ' => $LANGS['cat_NZ'], 'NI' => $LANGS['cat_NI'], 'NE' => $LANGS['cat_NE'], 'NG' => $LANGS['cat_NG'], 'NU' => $LANGS['cat_NU'], 'NF' => $LANGS['cat_NF'], 'KP' => $LANGS['cat_KP'], 'MP' => $LANGS['cat_MP'], 'NO' => $LANGS['cat_NO'], 'OM' => $LANGS['cat_OM'], 'PK' => $LANGS['cat_PK'], 'PW' => $LANGS['cat_PW'], 'PS' => $LANGS['cat_PS'], 'PA' => $LANGS['cat_PA'], 'PG' => $LANGS['cat_PG'], 'PY' => $LANGS['cat_PY'], 'PE' => $LANGS['cat_PE'], 'PH' => $LANGS['cat_PH'], 'PN' => $LANGS['cat_PN'], 'PL' => $LANGS['cat_PL'], 'PT' => $LANGS['cat_PT'], 'PR' => $LANGS['cat_PR'], 'QA' => $LANGS['cat_QA'], 'CG' => $LANGS['cat_CG'], 'RE' => $LANGS['cat_RE'], 'RO' => $LANGS['cat_RO'], 'RU' => $LANGS['cat_RU'], 'RW' => $LANGS['cat_RW'], 'BL' => $LANGS['cat_BL'], 'SH' => $LANGS['cat_SH'], 'KN' => $LANGS['cat_KN'], 'LC' => $LANGS['cat_LC'], 'MF' => $LANGS['cat_MF'], 'PM' => $LANGS['cat_PM'], 'VC' => $LANGS['cat_VC'], 'WS' => $LANGS['cat_WS'], 'SM' => $LANGS['cat_SM'], 'ST' => $LANGS['cat_ST'], 'SA' => $LANGS['cat_SA'], 'SN' => $LANGS['cat_SN'], 'RS' => $LANGS['cat_RS'], 'SC' => $LANGS['cat_SC'], 'SL' => $LANGS['cat_SL'], 'SG' => $LANGS['cat_SG'], 'SX' => $LANGS['cat_SX'], 'SK' => $LANGS['cat_SK'], 'SI' => $LANGS['cat_SI'], 'SB' => $LANGS['cat_SB'], 'SO' => $LANGS['cat_SO'], 'ZA' => $LANGS['cat_ZA'], 'GS' => $LANGS['cat_GS'], 'KR' => $LANGS['cat_KR'], 'SS' => $LANGS['cat_SS'], 'ES' => $LANGS['cat_ES'], 'LK' => $LANGS['cat_LK'], 'SD' => $LANGS['cat_SD'], 'SR' => $LANGS['cat_SR'], 'SJ' => $LANGS['cat_SJ'], 'SZ' => $LANGS['cat_SZ'], 'SE' => $LANGS['cat_SE'], 'CH' => $LANGS['cat_CH'], 'SY' => $LANGS['cat_SY'], 'TW' => $LANGS['cat_TW'], 'TJ' => $LANGS['cat_TJ'], 'TZ' => $LANGS['cat_TZ'], 'TH' => $LANGS['cat_TH'], 'TG' => $LANGS['cat_TG'], 'TK' => $LANGS['cat_TK'], 'TO' => $LANGS['cat_TO'], 'TT' => $LANGS['cat_TT'], 'TN' => $LANGS['cat_TN'], 'TR' => $LANGS['cat_TR'], 'TM' => $LANGS['cat_TM'], 'TC' => $LANGS['cat_TC'], 'TV' => $LANGS['cat_TV'], 'VI' => $LANGS['cat_VI'], 'UG' => $LANGS['cat_UG'], 'UA' => $LANGS['cat_UA'], 'AE' => $LANGS['cat_AE'], 'GB' => $LANGS['cat_GB'], 'US' => $LANGS['cat_US'], 'UY' => $LANGS['cat_UY'], 'UZ' => $LANGS['cat_UZ'], 'VU' => $LANGS['cat_VU'], 'VA' => $LANGS['cat_VA'], 'VE' => $LANGS['cat_VE'], 'VN' => $LANGS['cat_VN'], 'WF' => $LANGS['cat_WF'], 'EH' => $LANGS['cat_EH'], 'YE' => $LANGS['cat_YE'], 'ZM' => $LANGS['cat_ZM'], 'ZW' => $LANGS['cat_ZW']];
$Channel_Type = [0 => $LANGS['type0'], 1 => $LANGS['type1'], 2 => $LANGS['type2'], 3 => $LANGS['type3'], 4 => $LANGS['type4'], 5 => $LANGS['type5'], 6 => $LANGS['type6']];

if ($_USER->Info["videos"] > 0) {
        $Total_Views = (int)$DB->execute("SELECT sum(views) as total FROM videos WHERE uploaded_by = :USERNAME", true, [":USERNAME" => $_USER->Username])["total"];
    } else {
        $Total_Views = 0;
    }

if (isset($_POST["change_background_image"])) {
    $Uploader = new upload($_FILES["background_image"]);
    $Uploader->file_new_name_body = $_USER->Username;
    $Uploader->file_overwrite          = true;
    $Uploader->image_background_color  = '#000000';
    $Uploader->image_convert           = 'jpg';
    $Uploader->image_ratio_fill        = false;
    $Uploader->file_max_size           = 2000000;
    $Uploader->jpeg_quality            = 75;
    $Uploader->allowed                 = ['image/jpeg','image/pjpeg','image/png','image/bmp','image/x-windows-bmp'];
    $Uploader->process("u/bck/");
    if ($Uploader->processed) {
        $DB->modify("UPDATE users SET c_background_image = :FILENAME WHERE username = :USERNAME",[":FILENAME" => "/u/bck/".$_USER->Username.".jpg", ":USERNAME" => $_USER->Username]);
        notification($LANGS['backgroundsuccess'], $_SERVER['REQUEST_URI'], "cfeeb2"); exit();
    } else {
        notification($LANGS['backgrounderror'], false); exit();
    }
}

if (isset($_POST["delete_background_image"])) {
        $DB->modify("UPDATE users SET c_background_image = '' WHERE username = :USERNAME",[":USERNAME" => $_USER->Username]);
        unlink($_SERVER['DOCUMENT_ROOT'].'/u/bck/'.$_USER->Username.'.jpg');
        notification($LANGS['backgrounddeleted'], $_SERVER['REQUEST_URI'], "cfeeb2"); 
}

if (isset($_POST["change_banner_img"])) {
    $Uploader = new upload($_FILES["banner_img"]);
    $Uploader->file_new_name_body = $_USER->Username;
    $Uploader->file_overwrite          = true;
    $Uploader->image_background_color  = '#000000';
    $Uploader->image_convert           = 'jpg';
    $Uploader->image_ratio_fill        = false;
    $Uploader->file_max_size           = 2000000;
    $Uploader->jpeg_quality            = 90;
    $Uploader->allowed                 = ['image/jpeg','image/pjpeg','image/png','image/bmp','image/x-windows-bmp'];
    $Uploader->process("u/bnr/");
    if ($Uploader->processed) {
        $DB->modify("UPDATE users SET c_banner_image = :FILENAME WHERE username = :USERNAME",[":FILENAME" => "/u/bnr/".$_USER->Username.".jpg", ":USERNAME" => $_USER->Username]);
        notification($LANGS['bannersuccess'], $_SERVER['REQUEST_URI'], "cfeeb2"); exit();
    } else {
        notification($LANGS['bannererror'], false); exit();
    }
}

if (isset($_POST["delete_banner_image"])) {
        $DB->modify("UPDATE users SET c_banner_image = '' WHERE username = :USERNAME",[":USERNAME" => $_USER->Username]);
        if (file_exists($_SERVER['DOCUMENT_ROOT']."/u/bnr/".$_USER->Username.".jpg")) {
            unlink($_SERVER['DOCUMENT_ROOT'].'/u/bnr/'.$_USER->Username.'.jpg');
        }
        else {
            unlink($_SERVER['DOCUMENT_ROOT'].'/u/bnr/'.$_USER->Username.'.png');
        }
        notification($LANGS['bannerdeleted'], $_SERVER['REQUEST_URI'], "cfeeb2"); 
}

if (isset($_POST["change_mbanner_image"])) {
    $Uploader = new upload($_FILES["mbanner_image"]);
    $Uploader->file_new_name_body = $_USER->Username;
    $Uploader->file_overwrite          = true;
    $Uploader->image_background_color  = '#000000';
    $Uploader->image_convert           = 'jpg';
    $Uploader->image_ratio_fill        = false;
    $Uploader->file_max_size           = 2000000;
    $Uploader->jpeg_quality            = 90;
    $Uploader->allowed                 = ['image/jpeg','image/pjpeg','image/png','image/bmp','image/x-windows-bmp'];
    $Uploader->process("u/mbnr/");
    if ($Uploader->processed) {
        $DB->modify("UPDATE users SET c_mbanner_image = :FILENAME WHERE username = :USERNAME",[":FILENAME" => "/u/mbnr/".$_USER->Username.".jpg", ":USERNAME" => $_USER->Username]);
        notification($LANGS['minibannersuccess'], $_SERVER['REQUEST_URI'], "cfeeb2"); exit();
    } else {
        notification($LANGS['minibannererror'], false); exit();
    }
}

if (isset($_POST["delete_mbanner_image"])) {
        $DB->modify("UPDATE users SET c_mbanner_image = '' WHERE username = :USERNAME",[":USERNAME" => $_USER->Username]);
        unlink($_SERVER['DOCUMENT_ROOT'].'/u/mbnr/'.$_USER->Username.'.jpg');
        notification($LANGS['minibannerdeleted'], $_SERVER['REQUEST_URI'], "cfeeb2"); 
}

if (isset($_POST["change_side_image"])) {
    $Uploader = new upload($_FILES["side_image"]);
    $Uploader->file_new_name_body = $_USER->Username;
    $Uploader->file_overwrite          = true;
    $Uploader->image_background_color  = '#000000';
    $Uploader->image_convert           = 'jpg';
    $Uploader->image_ratio_fill        = false;
    $Uploader->file_max_size           = 2000000;
    $Uploader->jpeg_quality            = 90;
    $Uploader->allowed                 = ['image/jpeg','image/pjpeg','image/png','image/bmp','image/x-windows-bmp'];
    $Uploader->process("u/simg/");
    if ($Uploader->processed) {
        $DB->modify("UPDATE users SET c_sideimage = :FILENAME WHERE username = :USERNAME",[":FILENAME" => "/u/simg/".$_USER->Username.".jpg", ":USERNAME" => $_USER->Username]);
        notification($LANGS['sideimagesuccess'], $_SERVER['REQUEST_URI'], "cfeeb2"); exit();
    } else {
        notification($LANGS['sideimageerror'], false); exit();
    }
}

if (isset($_POST["delete_side_image"])) {
        $DB->modify("UPDATE users SET c_sideimage = '' WHERE username = :USERNAME",[":USERNAME" => $_USER->Username]);
        unlink($_SERVER['DOCUMENT_ROOT'].'/u/simg/'.$_USER->Username.'.jpg');
        notification($LANGS['sideimagedeleted'], $_SERVER['REQUEST_URI'], "cfeeb2"); 
}

if (isset($_POST["delete_avatar_image"]) || (isset($_POST['avatar_type']) && $_POST['avatar_type'] == "3")) {
        $DB->modify("UPDATE users SET avatar = NULL WHERE username = :USERNAME",[":USERNAME" => $_USER->Username]);
        $DB->modify("UPDATE users SET is_avatar_video = '0' WHERE username = :USERNAME",[":USERNAME" => $_USER->Username]);
        unlink($_SERVER['DOCUMENT_ROOT'].'/u/av/'.$_USER->Username.'.jpg');
        notification($LANGS['avatardeleted'], $_SERVER['REQUEST_URI'], "cfeeb2"); 
}

if (isset($_POST["change_avatar_image"])) {
    $Uploader = new upload($_FILES["avatar_image"]);
    $Uploader->file_new_name_body = $_USER->Username;
    $Uploader->image_resize            = true;
    $Uploader->file_overwrite          = true;
    $Uploader->image_x                 = 300;
    $Uploader->image_y                 = 300;
    $Uploader->image_background_color  = '#000000';
    $Uploader->image_convert           = 'jpg';
    $Uploader->image_ratio_fill        = false;
    $Uploader->file_max_size           = 2000000;
    $Uploader->jpeg_quality            = 80;
    $Uploader->allowed                 = ['image/jpeg','image/pjpeg','image/png','image/bmp','image/x-windows-bmp'];
    $Uploader->process("u/av/");
    if ($Uploader->processed) {
        $DB->modify("UPDATE users SET avatar = :USERNAME WHERE username = :USERNAME",[":USERNAME" => $_USER->Username]);
        $DB->modify("UPDATE users SET is_avatar_video = '0' WHERE username = :USERNAME",[":USERNAME" => $_USER->Username]);
        notification($LANGS['avatarsuccess'], $_SERVER['REQUEST_URI'], "cfeeb2"); exit();
    } else {
        notification($LANGS['avatarerror'], false); exit();
    }
}

if (strtoupper((string) $_SERVER['REQUEST_METHOD']) === 'POST') {
    $token = $_POST['token'];
    if ((!$token || $token !== $_SESSION['token'])) {
        echo '<p class="error">Error: invalid form submission</p>';
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit;
    }
}

if (isset($_POST["save_profile"])) {
    $_GUMP->validation_rules([
        "profile_name"         => "max_len,64",
        "profile_gender"       => "required",
        "profile_relationship" => "required",
        "show_birthday"        => "required",
        "profile_about"        => "max_len,2048",
        "profile_hobbies"      => "max_len,128",
        "profile_books"        => "max_len,128",
        "profile_music"        => "max_len,128",
        "profile_movies"       => "max_len,128",
        "profile_website"      => "max_len,128|valid_url",
        "banner_website"      => "max_len,128|valid_url",
        "side_website"      => "max_len,128|valid_url",
        "banner_map"      => "max_len,1024",
        "side_map"      => "max_len,1024",
        "color_background"     => "required|hex_color",
        "color_highlight_header" => "required|hex_color",
        "color_highlight_inner"  => "required|hex_color",
        "color_normal_header"    => "required|hex_color",
        "color_normal_inner"     => "required|hex_color",
        "color_font"             => "required|hex_color",
        "color_title_font"       => "required|hex_color",
        "color_header_font"      => "required|hex_color",
        "color_links"            => "required|hex_color",
        "channels"               => "max_len,100",
        "c_font"                 => "max_len,20",
        "fc_title"               => "max_len,60",
        "custom_box_title"      => "max_len,60",
        "custom_box"            => "max_len,1024",
    ]);

    $_GUMP->filter_rules([
        "profile_name"          => "trim|NoHTML",
        "profile_gender"        => "trim|NoHTML",
        "profile_relationship"  => "trim|NoHTML",
        "profile_about"         => "trim|NoHTML",
        "profile_hobbies"       => "trim|NoHTML",
        "profile_books"         => "trim|NoHTML",
        "profile_music"         => "trim|NoHTML",
        "profile_movies"        => "trim|NoHTML",
        "profile_website"       => "trim|NoHTML",
        "banner_website"        => "trim|NoHTML",
        "side_website"          => "trim|NoHTML",
        "banner_map"        => "trim",
        "side_map"          => "trim",
        "profile_country"       => "trim|NoHTML",
        "custom_box_title"      => "trim|NoHTML",
        "custom_box"            => "trim|NoHTML",
        "channels"              => "trim|NoHTML",
        "fc_title"              => "trim|NoHTML"
    ]);

if (isset($_POST["channel1"])) {
        if(!empty($_POST['channel1'])) {
            $_POST['channels'] = $_POST['channel1'].',';
        }else{$_POST['channels'] = ',';}
        if(!empty($_POST['channel2'])) {
            $_POST['channels'] = $_POST['channels'].$_POST['channel2'].',';
        }else{$_POST['channels'] .= ',';}
        if(!empty($_POST['channel3'])) {
            $_POST['channels'] = $_POST['channels'].$_POST['channel3'].',';
        }else{$_POST['channels'] .= ',';}
        if(!empty($_POST['channel4'])) {
            $_POST['channels'] = $_POST['channels'].$_POST['channel4'].',';
        }else{$_POST['channels'] .= ',';}
    }else{
        $_POST['channels'] = ',,,,';
    }

    $Validation     = $_GUMP->run($OG_POST);

    if ($Validation) {
        if ($Validation["profile_gender"] == 0) { $GENDER = 0; }
        elseif ($Validation["profile_gender"] == 1) { $GENDER = 1; }
        elseif ($Validation["profile_gender"] == 2) { $GENDER = 2; }
        else { header("Location: /"); die(); }

        if ($Validation["profile_relationship"] == 0) { $RELATIONSHIP = 0; }
        elseif ($Validation["profile_relationship"] == 1) { $RELATIONSHIP = 1; }
        elseif ($Validation["profile_relationship"] == 2) { $RELATIONSHIP = 2; }
        elseif ($Validation["profile_relationship"] == 3) { $RELATIONSHIP = 3; }
        else { header("Location: /"); die(); }

        if ($Validation["show_birthday"] == 1) { $SHOW_BIRTHDAY = 1; }
        else                                   { $SHOW_BIRTHDAY = 0; }


        $Birthday = (int)$Validation["year"]."-".$Validation["month"]."-".(int)$Validation["day"];

        if (date_diff(date_create($Birthday), date_create('today'))->y < 13 || date_diff(date_create($Birthday), date_create('today'))->y >= 128) {
            $Birthday = $_USER->Info["i_age"];
        }


        if (isset($_POST["e_messages"])) { $E_Messages = 1; } else { $E_Messages = 0; }
        if (isset($_POST["e_comments"])) { $E_Comments = 1; } else { $E_Comments = 0; }
        if (isset($_POST["e_highlights"])) { $E_Subscriptions = 1; } else { $E_Subscriptions = 0; }
        if (isset($_POST["subs_box"])) { $subs_BOX = 1; } else { $subs_BOX = 0; }
        if (isset($_POST["subscrib_box"])) { $subscrib_BOX = 1; } else { $subscrib_BOX = 0; }
        if (isset($_POST["friends_box"])) { $friends_BOX = 1; } else { $friends_BOX = 0; }
        if (isset($_POST["bull_box"])) { $bull_BOX = 1; } else { $bull_BOX = 0; }
        if (isset($_POST["videos_box"])) { $videos_BOX = 1; } else { $videos_BOX = 0; }
        if (isset($_POST["fav_box"])) { $fav_BOX = 1; } else { $fav_BOX = 0; }
        if (isset($_POST["pl_box"])) { $pl_BOX = 1; } else { $pl_BOX = 0; }
        if (isset($_POST["comment_box"])) { $comment_BOX = 1; } else { $comment_BOX = 0; }
        if (isset($_POST["lastrat_box"])) { $last_ratings = 1; } else { $last_ratings = 0; }
        if (isset($_POST["big_box"])) { $big_BOX = 1; } else { $big_BOX = 0; }
        if (isset($_POST["c_background_image_fixed"])) { $background_fix = 1; } else { $background_fix = 0; }
        if (isset($_POST["c_custom_box"])) { $custom_box = 1; } else { $custom_box = 0; }


        $DB->modify("UPDATE users SET e_messages = :MESSAGES, e_comments = :COMMENTS, e_subscriptions = :SUBSCRIPTIONS, c_header_font = :HEADER_FONT, c_title_font = :TITLE_FONT, c_font = :CHANNEL_FONT, c_normal_font = :NORMAL_FONT, c_link_color = :LINKS, c_background = :BACKGROUND, c_background_image_position = :BACKGROUND_POSITION, c_background_image_repeat = :BACKGROUND_REPEAT, c_background_image_fixed = :BACKGROUND_FIXED, c_normal_header = :NORMAL_HEADER, c_normal_inner = :NORMAL_INNER, c_highlight_header = :HIGHLIGHT_HEADER, c_highlight_inner = :HIGHLIGHT_INNER, i_age = :BIRTHDAY, s_age = :SHOW_BIRTHDAY, i_movies = :MOVIES, i_website = :WEBSITE, banner_link = :BNRWEB, banner_map = :BNRMAP, sideimage_link = :SIDEWEB, sideimage_map = :SIDEMAP, i_name = :NAME, i_gender = :GENDER, i_relationship = :RELATIONSHIP, i_about = :ABOUT, i_books = :BOOKS, i_music = :MUSIC, i_hobbies = :HOBBIES, i_country = :COUNTRY, channels_title = :FCTITLE, type = :CHANNEL_TYPE, c_subscriptions_box = :SUBS_BOX, c_subscribers_box = :SUBSCRIB_BOX, c_friends_box = :FRIENDS_BOX, c_bulletins_box = :BULL_BOX, c_videos_box = :VIDEOS_BOX, c_favorites_box = :FAV_BOX, c_playlists_box = :PL_BOX, c_comments_box = :COMMENT_BOX, c_ratings_box = :LASTRATS_BOX, c_bigvideo_box = :BIG_BOX, channels = :CHANNELS, c_custom_box = :CUSTOM_BOX, custom_box_title = :CUSTOM_BOX_TITLE, custom_box = :CUSTOM_BOX_CONT WHERE username = :USERNAME",
                    [
                        ":MESSAGES"     => $E_Messages,
                        ":COMMENTS"     => $E_Comments,
                        ":SUBSCRIPTIONS"=> $E_Subscriptions,
                        ":NAME"         => $Validation["profile_name"],
                        ":GENDER"       => $GENDER,
                        ":RELATIONSHIP" => $RELATIONSHIP,
                        ":ABOUT"        => $Validation["profile_about"],
                        ":BOOKS"        => $Validation["profile_books"],
                        ":MUSIC"        => $Validation["profile_music"],
                        ":HOBBIES"      => $Validation["profile_hobbies"],
                        ":MOVIES"       => $Validation["profile_movies"],
                        ":WEBSITE"      => $Validation["profile_website"],
                        ":BNRWEB"       => $Validation["banner_website"],
                        ":SIDEWEB"      => $Validation["side_website"],
                        ":BNRWEB"       => $Validation["banner_map"],
                        ":SIDEWEB"      => $Validation["side_map"],
                        ":COUNTRY"      => $Validation["profile_country"],
                        ":FCTITLE"      => $Validation["fc_title"],
                        ":BACKGROUND"       => str_replace("#","",$Validation["color_background"]),
                        ":BACKGROUND_POSITION" => $_POST["c_background_image_position"],
                        ":BACKGROUND_REPEAT" => $_POST["c_background_image_repeat"],
                        ":BACKGROUND_FIXED" => $background_fix,
                        ":NORMAL_HEADER"    => str_replace("#","",$Validation["color_normal_header"]),
                        ":NORMAL_INNER"     => str_replace("#","",$Validation["color_normal_inner"]),
                        ":HIGHLIGHT_HEADER" => str_replace("#","",$Validation["color_highlight_header"]),
                        ":HIGHLIGHT_INNER"  => str_replace("#","",$Validation["color_highlight_inner"]),
                        ":BIRTHDAY"         => $Birthday,
                        ":SHOW_BIRTHDAY"    => $SHOW_BIRTHDAY,
                        ":LINKS"            => str_replace("#","",$Validation["color_links"]),
                        ":HEADER_FONT"      => str_replace("#","",$Validation["color_header_font"]),
                        ":TITLE_FONT"       => str_replace("#","",$Validation["color_title_font"]),
                        ":NORMAL_FONT"      => str_replace("#","",$Validation["color_font"]),
                        ":CHANNEL_FONT"     => $_POST["c_font"],
                        ":CHANNEL_TYPE"     => $_POST["channel_type"],
                        ":SUBS_BOX"         => $subs_BOX,
                        ":SUBSCRIB_BOX"     => $subscrib_BOX,
                        ":BULL_BOX"         => $bull_BOX,
                        ":VIDEOS_BOX"       => $videos_BOX,
                        ":FAV_BOX"          => $fav_BOX,
                        ":PL_BOX"          => $pl_BOX,
                        ":COMMENT_BOX"      => $comment_BOX,
                        ":LASTRATS_BOX"     => $last_ratings,
                        ":BIG_BOX"          => $big_BOX,
                        ":CHANNELS"         => $Validation["channels"],
                        ":FRIENDS_BOX"      => $friends_BOX,
                        ":CUSTOM_BOX"       => $custom_box,
                        ":CUSTOM_BOX_TITLE" => $Validation["custom_box_title"],
                        ":CUSTOM_BOX_CONT"  => $Validation["custom_box"],
                        ":USERNAME"         => $_USER->Username
                    ]);
        notification($LANGS['changessaved'],"/my_profile","cfeeb2"); exit();
    }
}

if (isset($_POST["save_profile_info"])) {
    $_GUMP->validation_rules([
        "profile_name"         => "max_len,64",
        "profile_gender"       => "required",
        "profile_relationship" => "required",
        "profile_about"        => "max_len,2048",
        "profile_hobbies"      => "max_len,128",
        "profile_books"        => "max_len,128",
        "profile_music"        => "max_len,128",
        "profile_movies"       => "max_len,128",
        "profile_website"      => "max_len,128|valid_url",
        "profile_hometown"     => "max_len,128",
        "profile_occupation"   => "max_len,128",
        "profile_companies"    => "max_len,128",
        "profile_schools"      => "max_len,128"
    ]);
    $_GUMP->filter_rules([
        "profile_name"          => "trim|NoHTML",
        "profile_gender"        => "trim|NoHTML",
        "profile_relationship"  => "trim|NoHTML",
        "profile_about"         => "trim|NoHTML",
        "profile_hobbies"       => "trim|NoHTML",
        "profile_books"         => "trim|NoHTML",
        "profile_music"         => "trim|NoHTML",
        "profile_movies"        => "trim|NoHTML",
        "profile_website"       => "trim|NoHTML",
        "profile_country"       => "trim|NoHTML",
        "profile_hometown"      => "trim|NoHTML",
        "profile_occupation"    => "trim|NoHTML",
        "profile_companies"     => "trim|NoHTML",
        "profile_schools"       => "trim|NoHTML"
    ]);

    $Validation     = $_GUMP->run($OG_POST);

    if ($Validation) {
        if ($Validation["profile_gender"] == 0) { $GENDER = 0; }
        elseif ($Validation["profile_gender"] == 1) { $GENDER = 1; }
        elseif ($Validation["profile_gender"] == 2) { $GENDER = 2; }
        else { header("Location: /"); die(); }

        if ($Validation["profile_relationship"] == 0) { $RELATIONSHIP = 0; }
        elseif ($Validation["profile_relationship"] == 1) { $RELATIONSHIP = 1; }
        elseif ($Validation["profile_relationship"] == 2) { $RELATIONSHIP = 2; }
        elseif ($Validation["profile_relationship"] == 3) { $RELATIONSHIP = 3; }
        else { header("Location: /"); die(); }

        $Birthday = (int)$Validation["year"]."-".$Validation["month"]."-".(int)$Validation["day"];

        if (date_diff(date_create($Birthday), date_create('today'))->y < 13 || date_diff(date_create($Birthday), date_create('today'))->y >= 128) {
            $Birthday = $_USER->Info["i_age"];
        }

        $DB->modify("UPDATE users SET i_age = :BIRTHDAY, i_movies = :MOVIES, i_website = :WEBSITE, i_name = :NAME, i_gender = :GENDER, i_relationship = :RELATIONSHIP, i_about = :ABOUT, i_books = :BOOKS, i_music = :MUSIC, i_hobbies = :HOBBIES, i_country = :COUNTRY, i_hometown = :HOMETOWN, i_occupation = :OCCUPATION, i_companies = :COMPANIES, i_schools = :SCHOOLS WHERE username = :USERNAME",
                    [
                        ":NAME"         => $Validation["profile_name"],
                        ":GENDER"       => $GENDER,
                        ":RELATIONSHIP" => $RELATIONSHIP,
                        ":BIRTHDAY"     => $Birthday,
                        ":ABOUT"        => $Validation["profile_about"],
                        ":BOOKS"        => $Validation["profile_books"],
                        ":MUSIC"        => $Validation["profile_music"],
                        ":HOBBIES"      => $Validation["profile_hobbies"],
                        ":MOVIES"       => $Validation["profile_movies"],
                        ":WEBSITE"      => $Validation["profile_website"],
                        ":COUNTRY"      => $Validation["profile_country"],
                        ":HOMETOWN"     => $Validation["profile_hometown"],
                        ":OCCUPATION"   => $Validation["profile_occupation"],
                        ":COMPANIES"   => $Validation["profile_companies"],
                        ":SCHOOLS"      => $Validation["profile_schools"],
                        ":USERNAME"     => $_USER->Username
                    ]);
        notification($LANGS['changessaved'],"/my_account#about","cfeeb2"); exit();
    }
}

if (isset($_POST["save_playback_info"])) {
    if ($_POST["hd"] == 1) {
        setcookie("vlphd", "1", ['expires' => time() + (86400 * 355), 'path' => "/"]);
    } else {
        setcookie("vlphd", "0", ['expires' => time() + (86400 * 355), 'path' => "/"]);
    }
    notification($LANGS['changessaved'],"/my_account#playback","cfeeb2"); exit();
}

if (isset($_POST["change_email"])) {
    $_GUMP->validation_rules([
        "email"       => "required|valid_email|max_len,128",
        "email_password"    => "required|max_len,128|min_len,4"
    ]);

    $_GUMP->filter_rules([
        "email"       => "trim|sanitize_email",
        "email_password"    => "trim"
    ]);

    $Validation = $_GUMP->run($OG_POST);
    if (password_verify((string) $Validation["email_password"],(string) $_USER->Info['password']) && $Validation['email']) {
        if ($DB->exists($Validation['email'],"email","users")) {
            notification("This email is already in use!", "/my_account#email"); exit();
        }
        else {
            $DB->modify("UPDATE users SET email = :EMAIL WHERE username = :USERNAME", [":EMAIL" => $Validation["email"],":USERNAME" => $_USER->Username]);
            notification($LANGS['changessaved'],"/my_account#email","cfeeb2"); exit();
        }
    }
    elseif (!$Validation['email']) {
       notification("Invalid email!","/my_account#email"); exit(); 
    }
    else {
        notification($LANGS['wrongpassword'],"/my_account#email"); exit();
    }
}

if (isset($_POST["change_username"])) {
    if (strtotime((string) $_USER->Info['username_change'])<strtotime('-6 months')) {
    $_GUMP->validation_rules([
        "new_username"       => "required|alpha_numeric|max_len,20",
        "username_password"    => "required|max_len,128|min_len,4"
    ]);

    $_GUMP->filter_rules([
        "new_username"       => "trim",
        "username_password"    => "trim"
    ]);

    $Validation = $_GUMP->run($OG_POST);
    if (password_verify((string) $Validation["username_password"],(string) $_USER->Info['password']) && $Validation['new_username']) {
        if ($DB->exists($Validation['new_username'],"username","users") || $DB->exists($Validation['new_username'],"displayname","users")) {
            notification("This username is already in use!", "/my_account#manageaccount"); exit();
        }
        else {
            $DB->modify("UPDATE users SET username_change = NOW() WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("UPDATE users SET displayname = :USERNAMENEW WHERE username = :USERNAME", [":USERNAMENEW" => $Validation["new_username"],":USERNAME" => $_USER->Username]);
            notification($LANGS['changessaved'],"/my_account#manageaccount","cfeeb2"); exit();
        }
    }
    elseif (!$Validation['new_username']) {
       notification("Invalid username!","/my_account#manageaccount"); exit(); 
    }
    else {
        notification($LANGS['wrongpassword'],"/my_account#manageaccount"); exit();
    }
} else {
        notification("You cannot do that yet!","/my_account#manageaccount"); exit();
}
}

if (isset($_POST["change_password"])) {
    $_GUMP->validation_rules([
        "current_password"      => "required|max_len,128|min_len,4",
        "new_password"          => "required|max_len,20|min_len,4",
        "confirm_new_password"  => "required|equalsfield,new_password"
    ]);

    $_GUMP->filter_rules([
        "current_password"          => "trim",
        "new_password"              => "trim",
        "confirm_new_password"      => "trim"
    ]);

    $Validation = $_GUMP->run($OG_POST);
    if ($Validation) {
        if (password_verify((string) $Validation["current_password"],(string) $_USER->Info['password'])) {
            $Password   = password_hash((string) $Validation["new_password"], PASSWORD_BCRYPT);
            $DB->modify("UPDATE users SET password = :PASSWORD WHERE username = :USERNAME", [":PASSWORD" => $Password,":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM remember_me WHERE userid = :USERNAME",[":USERNAME" => $_USER->Username]);
            if (isset($_COOKIE['remember'])) { setcookie("remember", "", ['expires' => time() - 86400 * 30, 'path' => "/"]); }
            $_USER->log_out();
            notification("Password changed successfully! You will need to log in again to access your account.","/","cfeeb2"); exit();
        }
        else {
            notification($LANGS['wrongpassword'],"/my_account#manageaccount"); exit();
        }
    }
    else {
        if ($_POST["new_password"] !== $_POST["confirm_new_password"]) {
            notification("The two passwords you entered don't match!","/my_account#manageaccount"); exit();
        } elseif (mb_strlen((string) $_POST["current_password"]) < 4 || mb_strlen((string) $_POST["new_password"]) < 4) {
            notification("Passwords must be over 4 letters long!","/my_account#manageaccount"); exit();
        }
    }
}

if (isset($_POST["delete_account"])) {
    $_GUMP->validation_rules([
        "delete_password"    => "required|max_len,20|min_len,4"
    ]);

    $_GUMP->filter_rules([
        "delete_password"    => "trim"
    ]);

    $Validation = $_GUMP->run($OG_POST);
    if (password_verify((string) $Validation["delete_password"],(string) $_USER->Info['password'])) {
            $DB->modify("UPDATE users SET has_terminated = 1 WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("UPDATE users SET is_banned = 1 WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
            $Subscriptions = $DB->execute("SELECT subscription FROM subscriptions WHERE subscriber = :USERNAME",false,[":USERNAME" => $_USER->Username]);
            $Subscribers = $DB->execute("SELECT subscriber FROM subscriptions WHERE subscription = :USERNAME",false,[":USERNAME" => $_USER->Username]);
            foreach ($Subscriptions as $Subscription) {
                $_SUB = new User($Subscription["subscription"],$DB);
                $_SUB->update_subscribers();
            }
            foreach ($Subscribers as $Subscriber) {
                $_SUB = new User($Subscriber["subscriber"],$DB);
                $_SUB->update_subscriptions();
            }
            $DB->modify("DELETE FROM users_flags WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM users_friends WHERE friend_2 = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM users_friends WHERE friend_1 = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM users_messages WHERE by_user = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM users_messages WHERE for_user = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM users_themes WHERE by_user = :USERNAME", [":USERNAME" => $_USER->Username]);

            $DB->modify("DELETE FROM api_keys WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);

            $DB->modify("DELETE FROM bulletins WHERE by_user = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM bulletins_new WHERE by_user = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM bulletins_comments WHERE by_user = :USERNAME", [":USERNAME" => $_USER->Username]);

            $DB->modify("DELETE FROM channel_comments WHERE by_user = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM channel_comments WHERE on_channel = :USERNAME", [":USERNAME" => $_USER->Username]);

            $DB->modify("DELETE FROM comment_votes WHERE by_user = :USERNAME", [":USERNAME" => $_USER->Username]);

            $DB->modify("DELETE FROM copyright_strikes WHERE for_user = :USERNAME", [":USERNAME" => $_USER->Username]);

            $DB->modify("DELETE FROM groups_members WHERE member = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM groups_messages WHERE by_user = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM groups_topics WHERE created_by = :USERNAME", [":USERNAME" => $_USER->Username]);

            $DB->modify("DELETE FROM partner_applications WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);

            $DB->modify("DELETE FROM remember_me WHERE userid = :USERNAME", [":USERNAME" => $_USER->Username]);

            $DB->modify("DELETE FROM subscriptions WHERE subscriber = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM subscriptions WHERE subscription = :USERNAME", [":USERNAME" => $_USER->Username]);

            $DB->modify("DELETE FROM playlists WHERE by_user = :USERNAME", [":USERNAME" => $_USER->Username]);

            $DB->modify("DELETE FROM videos WHERE uploaded_by = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM videos_comments WHERE by_user = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM videos_favorites WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM videos_favorites WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM videos_flags WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM videos_ratings WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM videos_responses WHERE from_user = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM videos_responses WHERE by_user = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM videos_spam WHERE by_user = :USERNAME", [":USERNAME" => $_USER->Username]);
            $DB->modify("DELETE FROM videos_uploads WHERE username = :USERNAME", [":USERNAME" => $_USER->Username]);

            if (isset($_COOKIE['remember'])) { setcookie("remember", "", ['expires' => time() - 86400 * 30, 'path' => "/"]); }
            $_USER->log_out();

            notification("Your account has been successfully deleted.","/","cfeeb2"); exit();
    }
    else {
        notification($LANGS['wrongpassword'],"/my_account#manageaccount"); exit();
    }
}

if (isset($_POST["save_email_info"])) {
    if (isset($_POST["e_messages"])) { $e_messages = 1; } else { $e_messages = 0; }
    if (isset($_POST["e_comments"])) { $e_comments = 1; } else { $e_comments = 0; }
    if (isset($_POST["e_subscriptions"])) { $e_subscriptions = 1; } else { $e_subscriptions = 0; }
    $DB->modify("UPDATE users SET e_messages = :E_MESSAGES, e_comments = :E_COMMENTS, e_subscriptions = :E_SUBSCRIPTIONS WHERE username = :USERNAME", [":E_MESSAGES" => $e_messages, ":E_COMMENTS" => $e_comments, ":E_SUBSCRIPTIONS" => $e_subscriptions, ":USERNAME" => $_USER->Username]);
    notification($LANGS['changessaved'],"/my_account#email","cfeeb2"); exit();
}

if (isset($_POST["save_partner_settings"])) {
    $_GUMP->validation_rules([
        "banner_website"      => "max_len,128|valid_url",
        "side_website"      => "max_len,128|valid_url",
        "banner_map"      => "max_len,1024",
        "side_map"      => "max_len,1024",
        "custom_box_title"      => "max_len,60",
        "custom_box"            => "max_len,1024"
    ]);

    $_GUMP->filter_rules([
        "banner_website"        => "trim|NoHTML",
        "side_website"          => "trim|NoHTML",
        "banner_map"        => "trim",
        "side_map"          => "trim",
        "custom_box_title"      => "trim|NoHTML",
        "custom_box"            => "trim|NoHTML"
    ]);

    $Validation     = $_GUMP->run($OG_POST);

    if ($Validation) {
        if (isset($_POST["c_custom_box"])) { $custom_box = 1; } else { $custom_box = 0; }
        $DB->modify("UPDATE users SET banner_link = :BNRWEB, sideimage_link = :SIDEWEB, banner_map = :BNRMAP, sideimage_map = :SIDEMAP, c_custom_box = :CUSTOM_BOX, custom_box_title = :CUSTOM_BOX_TITLE, custom_box = :CUSTOM_BOX_CONT WHERE username = :USERNAME",[
                        ":BNRWEB"       => $Validation["banner_website"],
                        ":SIDEWEB"      => $Validation["side_website"],
                        ":BNRMAP"       => $Validation["banner_map"],
                        ":SIDEMAP"      => $Validation["side_map"],
                        ":CUSTOM_BOX"       => $custom_box,
                        ":CUSTOM_BOX_TITLE" => $Validation["custom_box_title"],
                        ":CUSTOM_BOX_CONT"  => $Validation["custom_box"],
                        ":USERNAME"         => $_USER->Username
                    ]);
        notification($LANGS['changessaved'],"/my_account#partner","cfeeb2"); exit();
    }
}

$Birth_Year = date("Y",strtotime((string) $_USER->Info["i_age"]));
$Birth_Month = ltrim(date("m",strtotime((string) $_USER->Info["i_age"])),0);
$Birth_Day = ltrim(date("d",strtotime((string) $_USER->Info["i_age"])),0);
$CheckChannelType = $_USER->Info["type"];
$CheckBoxSubs = $_USER->Info["c_subscriptions_box"];
$CheckBoxSubscrib = $_USER->Info["c_subscribers_box"];
$CheckBoxBull = $_USER->Info["c_bulletins_box"];
$CheckBoxVid = $_USER->Info["c_videos_box"];
$CheckBoxFav = $_USER->Info["c_favorites_box"];
$CheckBoxPl = $_USER->Info["c_playlists_box"];
$CheckCountry = $_USER->Info["i_country"];
$CheckFCTitle = $_USER->Info["channels_title"];
$CheckBoxCom = $_USER->Info["c_comments_box"];
$CheckBoxRatings = $_USER->Info["c_ratings_box"];
$CheckBoxBig = $_USER->Info["c_bigvideo_box"];
$CheckBoxFriends = $_USER->Info["c_friends_box"];
$CheckRepeatBackground = $_USER->Info["c_background_image_repeat"];
$CheckPositionBackground = $_USER->Info["c_background_image_position"];
$CheckFixedBackground = $_USER->Info["c_background_image_fixed"];
$CheckCustomBox = $_USER->Info["c_custom_box"];
$CheckChannelFont = $_USER->Info["c_font"];

if ($_USER->Info["channel_new"] == 0) {
    $_PAGE = [
    "Page"          => "my_profile",
    "Page_Type"     => "my_profile"
];
}
else {
    $_PAGE = [
    "Page"          => "my_profile_new",
    "Page_Type"     => "my_profile_new"
];
}
require "_templates/_structures/main.php";

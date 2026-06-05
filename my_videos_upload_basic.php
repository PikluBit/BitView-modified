<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////UPLOAD MUST BE ENABLED
if (!$_USER->Logged_In)             { header("location: /login"); exit();   }
if (!$_CONFIG->Config["upload"])    { notification($LANGS['uploaddisabled'],"/"); exit(); }

$_USER->get_info();

//MAX 3 VIDEOS A DAY
$Count = $DB->execute("SELECT count(*) as amount FROM videos WHERE uploaded_by = :USERNAME AND is_deleted IS NULL AND DATE(uploaded_on) = CURDATE()",
                      true,
                      [":USERNAME" => $_USER->Username])["amount"];
if ($Count >= 3) { notification($LANGS['vidsday'],"/"); exit();; }
//WAIT 3 MINUTES AFTER UPLOADING A NEW VIDEO
$CountLastVideo = $DB->execute("SELECT UNIX_TIMESTAMP(uploaded_on) as last_upl FROM videos WHERE uploaded_by = :USERNAME AND is_deleted IS NULL ORDER BY `last_upl` DESC LIMIT 1",
                      true,
                      [":USERNAME" => $_USER->Username]);
if ($DB->Row_Num > 0 && $CountLastVideo["last_upl"]+180 >= time() and $_USER->Info["is_partner"] =! 1) { notification($LANGS['3mins'],"/"); exit();; }

//NO UPLOADS AT THE SAME TIME
$DB->execute("SELECT * FROM videos WHERE uploaded_by = :USERNAME AND status = 0 AND is_deleted IS NULL LIMIT 1", true, [":USERNAME" => $_USER->Username]);
if ($DB->Row_Num > 0) {
    notification("You can't upload more than one video at the same time!","/"); exit();
}


$Months     = [$LANGS['january'] => 1,$LANGS['february'] => 2,$LANGS['march'] => 3,$LANGS['april'] => 4,$LANGS['may'] => 5,$LANGS['june'] => 6,$LANGS['july'] => 7,$LANGS['august'] => 8,$LANGS['september'] => 9,$LANGS['october'] => 10,$LANGS['november'] => 11,$LANGS['december'] => 12];
$Categories = [1 => $LANGS['cat1'], 2 => $LANGS['cat2'], 3 => $LANGS['cat3'], 4 => $LANGS['cat4'], 5 => $LANGS['cat5'], 6 => $LANGS['cat6'], 7 => $LANGS['cat7'], 8 => $LANGS['cat8'], 9 => $LANGS['cat9'], 10 => $LANGS['cat10'], 11 => $LANGS['cat11'], 12 => $LANGS['cat12'], 13 => $LANGS['cat13'], 14 => $LANGS['cat14'], 15 => $LANGS['cat15'], 16 => $LANGS['cat16'], 17 => $LANGS['cat17'], 18 => $LANGS['cat18'], 19 => $LANGS['cat19'], 20 => $LANGS['cat20'], 21 => $LANGS['cat21']];
$Countries  = ['AF' => $LANGS['cat_AF'], 'AX' => $LANGS['cat_AX'], 'AL' => $LANGS['cat_AL'], 'DZ' => $LANGS['cat_DZ'], 'AS' => $LANGS['cat_AS'], 'AD' => $LANGS['cat_AD'], 'AO' => $LANGS['cat_AO'], 'AI' => $LANGS['cat_AI'], 'AQ' => $LANGS['cat_AQ'], 'AG' => $LANGS['cat_AG'], 'AR' => $LANGS['cat_AR'], 'AM' => $LANGS['cat_AM'], 'AW' => $LANGS['cat_AW'], 'AU' => $LANGS['cat_AU'], 'AT' => $LANGS['cat_AT'], 'AZ' => $LANGS['cat_AZ'], 'BS' => $LANGS['cat_BS'], 'BH' => $LANGS['cat_BH'], 'BD' => $LANGS['cat_BD'], 'BB' => $LANGS['cat_BB'], 'BY' => $LANGS['cat_BY'], 'BE' => $LANGS['cat_BE'], 'BZ' => $LANGS['cat_BZ'], 'BJ' => $LANGS['cat_BJ'], 'BM' => $LANGS['cat_BM'], 'BT' => $LANGS['cat_BT'], 'BO' => $LANGS['cat_BO'], 'BQ' => $LANGS['cat_BQ'], 'BA' => $LANGS['cat_BA'], 'BW' => $LANGS['cat_BW'], 'BV' => $LANGS['cat_BV'], 'BR' => $LANGS['cat_BR'], 'IO' => $LANGS['cat_IO'], 'VG' => $LANGS['cat_VG'], 'BN' => $LANGS['cat_BN'], 'BG' => $LANGS['cat_BG'], 'BF' => $LANGS['cat_BF'], 'BI' => $LANGS['cat_BI'], 'KH' => $LANGS['cat_KH'], 'CM' => $LANGS['cat_CM'], 'CA' => $LANGS['cat_CA'], 'CV' => $LANGS['cat_CV'], 'KY' => $LANGS['cat_KY'], 'CF' => $LANGS['cat_CF'], 'TD' => $LANGS['cat_TD'], 'CL' => $LANGS['cat_CL'],'CN'=> $LANGS['cat_CN'], 'CX' => $LANGS['cat_CX'], 'CC' => $LANGS['cat_CC'], 'CO' => $LANGS['cat_CO'], 'KM' => $LANGS['cat_KM'], 'CK' => $LANGS['cat_CK'], 'CR' => $LANGS['cat_CR'], 'HR' => $LANGS['cat_HR'], 'CU' => $LANGS['cat_CU'], 'CW' => $LANGS['cat_CW'], 'CY' => $LANGS['cat_CY'], 'CZ' => $LANGS['cat_CZ'], 'CD' => $LANGS['cat_CD'], 'DK' => $LANGS['cat_DK'], 'DJ' => $LANGS['cat_DJ'], 'DM' => $LANGS['cat_DM'], 'DO' => $LANGS['cat_DO'], 'TL' => $LANGS['cat_TL'], 'EC' => $LANGS['cat_EC'], 'EG' => $LANGS['cat_EG'], 'SV' => $LANGS['cat_SV'], 'GQ' => $LANGS['cat_GQ'], 'ER' => $LANGS['cat_ER'], 'EE' => $LANGS['cat_EE'], 'ET' => $LANGS['cat_ET'], 'FK' => $LANGS['cat_FK'], 'FO' => $LANGS['cat_DO'], 'FJ' => $LANGS['cat_FJ'], 'FI' => $LANGS['cat_FI'], 'FR' => $LANGS['cat_FR'], 'GF' => $LANGS['cat_GF'], 'PF' => $LANGS['cat_PF'], 'TF' => $LANGS['cat_TF'], 'GA' => $LANGS['cat_GA'], 'GM' => $LANGS['cat_GM'], 'GE' => $LANGS['cat_GE'], 'DE' => $LANGS['cat_DE'], 'GH' => $LANGS['cat_GH'], 'GI' => $LANGS['cat_GI'], 'GR' => $LANGS['cat_GR'], 'GL' => $LANGS['cat_GL'], 'GD' => $LANGS['cat_GD'], 'GP' => $LANGS['cat_GP'], 'GU' => $LANGS['cat_GU'], 'GT' => $LANGS['cat_GT'], 'GG' => $LANGS['cat_GG'], 'GN' => $LANGS['cat_GN'], 'GW' => $LANGS['cat_GW'], 'GY' => $LANGS['cat_GY'], 'HT' => $LANGS['cat_HT'], 'HM' => $LANGS['cat_HM'], 'HN' => $LANGS['cat_HN'], 'HK' => $LANGS['cat_HK'], 'HU' => $LANGS['cat_HU'], 'IS' => $LANGS['cat_IS'], 'IN' => $LANGS['cat_IN'], 'ID' => $LANGS['cat_ID'], 'IR' => $LANGS['cat_IR'], 'IQ' => $LANGS['cat_IQ'], $LANGS['cat_IE'], 'IM' => $LANGS['cat_IM'], 'IL' => $LANGS['cat_IL'], 'IT' => $LANGS['cat_IT'], 'CI' => $LANGS['cat_CI'], 'JM' => $LANGS['cat_JM'], 'JP' => $LANGS['cat_JP'], 'JE' => $LANGS['cat_JE'], 'JO' => $LANGS['cat_JO'], 'KZ' => $LANGS['cat_KZ'], 'KE' => $LANGS['cat_KE'], 'KI' => $LANGS['cat_KI'], 'XK' => $LANGS['cat_XK'], 'KW' => $LANGS['cat_KW'], 'KG' => $LANGS['cat_KG'], 'LA' => $LANGS['cat_LA'], 'LV' => $LANGS['cat_LV'], 'LB' => $LANGS['cat_LB'], 'LS' => $LANGS['cat_LS'], 'LR' => $LANGS['cat_LR'], 'LY' => $LANGS['cat_LY'], 'LI' => $LANGS['cat_LI'], 'LT' => $LANGS['cat_LI'], 'LU' => $LANGS['cat_LU'], 'MO' => $LANGS['cat_MO'], 'MK' => $LANGS['cat_MK'], 'MG' => $LANGS['cat_MG'], 'MW' => $LANGS['cat_MW'], 'MY' => $LANGS['cat_MY'], 'MV' => $LANGS['cat_MV'], 'ML' => $LANGS['cat_ML'], 'MT' => $LANGS['cat_MT'], 'MH' => $LANGS['cat_MH'], 'MQ' => $LANGS['cat_MQ'], 'MR' => $LANGS['cat_MR'], 'MU' => $LANGS['cat_MU'], 'YT' => $LANGS['cat_YT'], 'MX' => $LANGS['cat_MX'], 'FM' => $LANGS['cat_FM'], 'MD' => $LANGS['cat_MD'], 'MC' => $LANGS['cat_MC'], 'MN' => $LANGS['cat_MN'], 'ME' => $LANGS['cat_ME'], 'MS' => $LANGS['cat_MS'], 'MA' => $LANGS['cat_MA'], 'MZ' => $LANGS['cat_MZ'], 'MM' => $LANGS['cat_MM'], 'NA' => $LANGS['cat_NA'], 'NR' => $LANGS['cat_NR'], 'NP' => $LANGS['cat_NP'], 'NL' => $LANGS['cat_NL'], 'NC' => $LANGS['cat_NC'], 'NZ' => $LANGS['cat_NZ'], 'NI' => $LANGS['cat_NI'], 'NE' => $LANGS['cat_NE'], 'NG' => $LANGS['cat_NG'], 'NU' => $LANGS['cat_NU'], 'NF' => $LANGS['cat_NF'], 'KP' => $LANGS['cat_KP'], 'MP' => $LANGS['cat_MP'], 'NO' => $LANGS['cat_NO'], 'OM' => $LANGS['cat_OM'], 'PK' => $LANGS['cat_PK'], 'PW' => $LANGS['cat_PW'], 'PS' => $LANGS['cat_PS'], 'PA' => $LANGS['cat_PA'], 'PG' => $LANGS['cat_PG'], 'PY' => $LANGS['cat_PY'], 'PE' => $LANGS['cat_PE'], 'PH' => $LANGS['cat_PH'], 'PN' => $LANGS['cat_PN'], 'PL' => $LANGS['cat_PL'], 'PT' => $LANGS['cat_PT'], 'PR' => $LANGS['cat_PR'], 'QA' => $LANGS['cat_QA'], 'CG' => $LANGS['cat_CG'], 'RE' => $LANGS['cat_RE'], 'RO' => $LANGS['cat_RO'], 'RU' => $LANGS['cat_RU'], 'RW' => $LANGS['cat_RW'], 'BL' => $LANGS['cat_BL'], 'SH' => $LANGS['cat_SH'], 'KN' => $LANGS['cat_KN'], 'LC' => $LANGS['cat_LC'], 'MF' => $LANGS['cat_MF'], 'PM' => $LANGS['cat_PM'], 'VC' => $LANGS['cat_VC'], 'WS' => $LANGS['cat_WS'], 'SM' => $LANGS['cat_SM'], 'ST' => $LANGS['cat_ST'], 'SA' => $LANGS['cat_SA'], 'SN' => $LANGS['cat_SN'], 'RS' => $LANGS['cat_RS'], 'SC' => $LANGS['cat_SC'], 'SL' => $LANGS['cat_SL'], 'SG' => $LANGS['cat_SG'], 'SX' => $LANGS['cat_SX'], 'SK' => $LANGS['cat_SK'], 'SI' => $LANGS['cat_SI'], 'SB' => $LANGS['cat_SB'], 'SO' => $LANGS['cat_SO'], 'ZA' => $LANGS['cat_ZA'], 'GS' => $LANGS['cat_GS'], 'KR' => $LANGS['cat_KR'], 'SS' => $LANGS['cat_SS'], 'ES' => $LANGS['cat_ES'], 'LK' => $LANGS['cat_LK'], 'SD' => $LANGS['cat_SD'], 'SR' => $LANGS['cat_SR'], 'SJ' => $LANGS['cat_SJ'], 'SZ' => $LANGS['cat_SZ'], 'SE' => $LANGS['cat_SE'], 'CH' => $LANGS['cat_CH'], 'SY' => $LANGS['cat_SY'], 'TW' => $LANGS['cat_TW'], 'TJ' => $LANGS['cat_TJ'], 'TZ' => $LANGS['cat_TZ'], 'TH' => $LANGS['cat_TH'], 'TG' => $LANGS['cat_TG'], 'TK' => $LANGS['cat_TK'], 'TO' => $LANGS['cat_TO'], 'TT' => $LANGS['cat_TT'], 'TN' => $LANGS['cat_TN'], 'TR' => $LANGS['cat_TR'], 'TM' => $LANGS['cat_TM'], 'TC' => $LANGS['cat_TC'], 'TV' => $LANGS['cat_TV'], 'VI' => $LANGS['cat_VI'], 'UG' => $LANGS['cat_UG'], 'UA' => $LANGS['cat_UA'], 'AE' => $LANGS['cat_AE'], 'GB' => $LANGS['cat_GB'], 'US' => $LANGS['cat_US'], 'UY' => $LANGS['cat_UY'], 'UZ' => $LANGS['cat_UZ'], 'VU' => $LANGS['cat_VU'], 'VA' => $LANGS['cat_VA'], 'VE' => $LANGS['cat_VE'], 'VN' => $LANGS['cat_VN'], 'WF' => $LANGS['cat_WF'], 'EH' => $LANGS['cat_EH'], 'YE' => $LANGS['cat_YE'], 'ZM' => $LANGS['cat_ZM'], 'ZW' => $LANGS['cat_ZW']];


if (isset($_POST["upload_video"])) {
    $_GUMP->validation_rules([
        "title"         => "required|max_len,100",
        "description"   => "max_len,2048",
        "tags"          => "max_len,128",
        "category"      => "required",
        "address"       => "max_len,100"
    ]);

    $_GUMP->filter_rules([
        "title"         => "trim|NoHTML",
        "description"   => "trim|NoHTML",
        "tags"          => "trim|NoHTML",
        "month"         => "trim",
        "day"           => "trim",
        "year"          => "trim",
        "address"       => "trim|NoHTML",
        "country"       => "trim"
    ]);

    $Validation     = $_GUMP->run($_POST);

    if (!$Validation) {
        header("location: /my_videos_upload_basic"); exit();
    }
}

if (isset($_POST["upload_video2"]) && !empty($_FILES["video_file"]["name"])) {
    $_GUMP->validation_rules([
        "title"         => "required|max_len,100",
        "description"   => "max_len,2048",
        "tags"          => "max_len,128",
        "category"      => "required",
        "address"       => "max_len,100"
    ]);

    $_GUMP->filter_rules([
        "title"         => "trim|NoHTML",
        "description"   => "trim|NoHTML",
        "tags"          => "trim|NoHTML",
        "month"         => "trim",
        "day"           => "trim",
        "year"          => "trim",
        "address"       => "trim|NoHTML",
        "country"       => "trim"
    ]);

    $Validation     = $_GUMP->run($_POST);

    if ($Validation) {
        if (!isset($_CONFIG::$Categories[$Validation["category"]])) { $Validation["category"] = 1; }


        $Allowed_Types  = ["wmv","avi","mov","mpg","mpeg","mp4","m4v"];

        $Video_TMP      = $_FILES["video_file"]["tmp_name"];
        $Video_Type     = pathinfo((string) $_FILES["video_file"]["name"], PATHINFO_EXTENSION);
        $Video_Size     = $_FILES["video_file"]["size"] / 1048576;
        $File_Name      = $_FILES["video_file"]["name"];


        if (!isset($Countries[$Validation["country"]])) {
            $Validation["country"] = "";
        }

        if ($Validation["day"] != "0" && $Validation["month"] != "0" && $Validation["year"] != "0") {
            $Date = $Validation["year"]."-".$Validation["month"]."-".$Validation["day"];
        } else {
            $Date = "0000-00-00";
        }


	/* max size */
        if ($Video_Size <= 2048 && in_array(strtolower($Video_Type),$Allowed_Types)) {
            function random_string($Characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", $Length = null) {
                $charactersLength   = mb_strlen((string) $Characters);
                $randomString       = '';
                for ($i = 0; $i < $Length; $i++) {
                    $randomString .= $Characters[mt_rand(0, $charactersLength - 1)];
                }
                return $randomString;
            }

            $Main_URL   = random_string("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_",11);
            $File_URL   = random_string("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_",20);
            $DELETE_ID  = random_string("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_",12);

            if (isset($Validation["broadcast"]) && $Validation["broadcast"] != 2) { $Privacy = 1; } else { $Privacy = 2; }

            if (move_uploaded_file($Video_TMP,"u/tmp/$File_URL.video")) {
                $Title = $Validation["title"];
                $Description = $Validation["description"];
                $Tags        = $Validation["tags"];

                $Insert = $DB->modify("INSERT INTO videos(url,file_url,title,description,tags,uploaded_by,uploaded_on,privacy,file_name,address,country,date_recorded,category,delete_id) VALUES(:URL,:FILE_URL,:TITLE,:DESCRIPTION,:TAGS,:UPLOADED_BY,NOW(),:PRIVACY,:FILE_NAME,:ADDRESS,:COUNTRY,:DATE,:CATEGORY,:DELETE_ID)",
                                           [
                                               ":URL"          => $Main_URL,
                                               ":FILE_URL"     => $File_URL,
                                               ":TITLE"        => $Title,
                                               ":DESCRIPTION"  => $Description,
                                               ":TAGS"         => $Tags,
                                               ":PRIVACY"      => $Privacy,
                                               ":FILE_NAME"    => $File_Name,
                                               ":DATE"         => $Date,
                                               ":COUNTRY"      => $Validation["country"],
                                               ":ADDRESS"      => $Validation["address"],
                                               ":UPLOADED_BY"  => $_USER->Username,
                                               ":CATEGORY"     => (int)$Validation["category"],
                                               ":DELETE_ID"    => $DELETE_ID
                                           ]);

                $Insert = $DB->modify("INSERT INTO converting(url,date) VALUES(:URL,NOW())",
                                      [":URL" => $Main_URL]);

                $_USER->update_videos();
            } else {
                header("location: /"); exit();
            }
        } else {
            header("location: /my_videos_upload_basic"); exit();
        }
    } else {
        header("location: /my_videos_upload_basic"); exit();
    }
}



if (!isset($_POST["upload_video"]) && !isset($_POST["upload_video2"])) {
    $Page_Title = "Video Upload (Step 1 of 2)";
} elseif (!isset($_POST["upload_video2"])) {
    $Page_Title = "Video Upload (Step 2 of 2)";
} else {
    $Page_Title = "Video Uploaded";
}

$_PAGE = [
    "Page"          => "upload",
    "Page_Type"     => "upload"
];
require "_templates/_structures/main.php";

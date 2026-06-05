<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
exit("disabled");
//PERMISSIONS AND REQUIREMENTS
////USER MUST NOT BE LOGGED IN
////SIGN UP MUST BE ENABLED
if ($_USER->Logged_In)              { header("location: /"); exit(); }
if (!$_CONFIG->Config["signup"])    { header("location: /"); exit(); }

function random_string($Characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", $Length = null){
    $charactersLength   = mb_strlen((string) $Characters);
    $randomString       = '';
    for ($i = 0; $i < $Length; $i++) {
        $randomString .= $Characters[mt_rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function isDisposableEmail($email, $blocklist_path = null) {
    return false;
}

$Months   = [$LANGS['january'] => 1,$LANGS['february'] => 2,$LANGS['march'] => 3,$LANGS['april'] => 4,$LANGS['may'] => 5,$LANGS['june'] => 6,$LANGS['july'] => 7,$LANGS['august'] => 8,$LANGS['september'] => 9,$LANGS['october'] => 10,$LANGS['november'] => 11,$LANGS['december'] => 12];
$Countries  = ['AF' => $LANGS['cat_AF'], 'AX' => $LANGS['cat_AX'], 'AL' => $LANGS['cat_AL'], 'DZ' => $LANGS['cat_DZ'], 'AS' => $LANGS['cat_AS'], 'AD' => $LANGS['cat_AD'], 'AO' => $LANGS['cat_AO'], 'AI' => $LANGS['cat_AI'], 'AQ' => $LANGS['cat_AQ'], 'AG' => $LANGS['cat_AG'], 'AR' => $LANGS['cat_AR'], 'AM' => $LANGS['cat_AM'], 'AW' => $LANGS['cat_AW'], 'AU' => $LANGS['cat_AU'], 'AT' => $LANGS['cat_AT'], 'AZ' => $LANGS['cat_AZ'], 'BS' => $LANGS['cat_BS'], 'BH' => $LANGS['cat_BH'], 'BD' => $LANGS['cat_BD'], 'BB' => $LANGS['cat_BB'], 'BY' => $LANGS['cat_BY'], 'BE' => $LANGS['cat_BE'], 'BZ' => $LANGS['cat_BZ'], 'BJ' => $LANGS['cat_BJ'], 'BM' => $LANGS['cat_BM'], 'BT' => $LANGS['cat_BT'], 'BO' => $LANGS['cat_BO'], 'BQ' => $LANGS['cat_BQ'], 'BA' => $LANGS['cat_BA'], 'BW' => $LANGS['cat_BW'], 'BV' => $LANGS['cat_BV'], 'BR' => $LANGS['cat_BR'], 'IO' => $LANGS['cat_IO'], 'VG' => $LANGS['cat_VG'], 'BN' => $LANGS['cat_BN'], 'BG' => $LANGS['cat_BG'], 'BF' => $LANGS['cat_BF'], 'BI' => $LANGS['cat_BI'], 'KH' => $LANGS['cat_KH'], 'CM' => $LANGS['cat_CM'], 'CA' => $LANGS['cat_CA'], 'CV' => $LANGS['cat_CV'], 'KY' => $LANGS['cat_KY'], 'CF' => $LANGS['cat_CF'], 'TD' => $LANGS['cat_TD'], 'CL' => $LANGS['cat_CL'],'CN'=> $LANGS['cat_CN'], 'CX' => $LANGS['cat_CX'], 'CC' => $LANGS['cat_CC'], 'CO' => $LANGS['cat_CO'], 'KM' => $LANGS['cat_KM'], 'CK' => $LANGS['cat_CK'], 'CR' => $LANGS['cat_CR'], 'HR' => $LANGS['cat_HR'], 'CU' => $LANGS['cat_CU'], 'CW' => $LANGS['cat_CW'], 'CY' => $LANGS['cat_CY'], 'CZ' => $LANGS['cat_CZ'], 'CD' => $LANGS['cat_CD'], 'DK' => $LANGS['cat_DK'], 'DJ' => $LANGS['cat_DJ'], 'DM' => $LANGS['cat_DM'], 'DO' => $LANGS['cat_DO'], 'TL' => $LANGS['cat_TL'], 'EC' => $LANGS['cat_EC'], 'EG' => $LANGS['cat_EG'], 'SV' => $LANGS['cat_SV'], 'GQ' => $LANGS['cat_GQ'], 'ER' => $LANGS['cat_ER'], 'EE' => $LANGS['cat_EE'], 'ET' => $LANGS['cat_ET'], 'FK' => $LANGS['cat_FK'], 'FO' => $LANGS['cat_DO'], 'FJ' => $LANGS['cat_FJ'], 'FI' => $LANGS['cat_FI'], 'FR' => $LANGS['cat_FR'], 'GF' => $LANGS['cat_GF'], 'PF' => $LANGS['cat_PF'], 'TF' => $LANGS['cat_TF'], 'GA' => $LANGS['cat_GA'], 'GM' => $LANGS['cat_GM'], 'GE' => $LANGS['cat_GE'], 'DE' => $LANGS['cat_DE'], 'GH' => $LANGS['cat_GH'], 'GI' => $LANGS['cat_GI'], 'GR' => $LANGS['cat_GR'], 'GL' => $LANGS['cat_GL'], 'GD' => $LANGS['cat_GD'], 'GP' => $LANGS['cat_GP'], 'GU' => $LANGS['cat_GU'], 'GT' => $LANGS['cat_GT'], 'GG' => $LANGS['cat_GG'], 'GN' => $LANGS['cat_GN'], 'GW' => $LANGS['cat_GW'], 'GY' => $LANGS['cat_GY'], 'HT' => $LANGS['cat_HT'], 'HM' => $LANGS['cat_HM'], 'HN' => $LANGS['cat_HN'], 'HK' => $LANGS['cat_HK'], 'HU' => $LANGS['cat_HU'], 'IS' => $LANGS['cat_IS'], 'IN' => $LANGS['cat_IN'], 'ID' => $LANGS['cat_ID'], 'IR' => $LANGS['cat_IR'], 'IQ' => $LANGS['cat_IQ'], 'IE' => $LANGS['cat_IE'], 'IM' => $LANGS['cat_IM'], 'IL' => $LANGS['cat_IL'], 'IT' => $LANGS['cat_IT'], 'CI' => $LANGS['cat_CI'], 'JM' => $LANGS['cat_JM'], 'JP' => $LANGS['cat_JP'], 'JE' => $LANGS['cat_JE'], 'JO' => $LANGS['cat_JO'], 'KZ' => $LANGS['cat_KZ'], 'KE' => $LANGS['cat_KE'], 'KI' => $LANGS['cat_KI'], 'XK' => $LANGS['cat_XK'], 'KW' => $LANGS['cat_KW'], 'KG' => $LANGS['cat_KG'], 'LA' => $LANGS['cat_LA'], 'LV' => $LANGS['cat_LV'], 'LB' => $LANGS['cat_LB'], 'LS' => $LANGS['cat_LS'], 'LR' => $LANGS['cat_LR'], 'LY' => $LANGS['cat_LY'], 'LI' => $LANGS['cat_LI'], 'LT' => $LANGS['cat_LT'], 'LU' => $LANGS['cat_LU'], 'MO' => $LANGS['cat_MO'], 'MK' => $LANGS['cat_MK'], 'MG' => $LANGS['cat_MG'], 'MW' => $LANGS['cat_MW'], 'MY' => $LANGS['cat_MY'], 'MV' => $LANGS['cat_MV'], 'ML' => $LANGS['cat_ML'], 'MT' => $LANGS['cat_MT'], 'MH' => $LANGS['cat_MH'], 'MQ' => $LANGS['cat_MQ'], 'MR' => $LANGS['cat_MR'], 'MU' => $LANGS['cat_MU'], 'YT' => $LANGS['cat_YT'], 'MX' => $LANGS['cat_MX'], 'FM' => $LANGS['cat_FM'], 'MD' => $LANGS['cat_MD'], 'MC' => $LANGS['cat_MC'], 'MN' => $LANGS['cat_MN'], 'ME' => $LANGS['cat_ME'], 'MS' => $LANGS['cat_MS'], 'MA' => $LANGS['cat_MA'], 'MZ' => $LANGS['cat_MZ'], 'MM' => $LANGS['cat_MM'], 'NA' => $LANGS['cat_NA'], 'NR' => $LANGS['cat_NR'], 'NP' => $LANGS['cat_NP'], 'NL' => $LANGS['cat_NL'], 'NC' => $LANGS['cat_NC'], 'NZ' => $LANGS['cat_NZ'], 'NI' => $LANGS['cat_NI'], 'NE' => $LANGS['cat_NE'], 'NG' => $LANGS['cat_NG'], 'NU' => $LANGS['cat_NU'], 'NF' => $LANGS['cat_NF'], 'KP' => $LANGS['cat_KP'], 'MP' => $LANGS['cat_MP'], 'NO' => $LANGS['cat_NO'], 'OM' => $LANGS['cat_OM'], 'PK' => $LANGS['cat_PK'], 'PW' => $LANGS['cat_PW'], 'PS' => $LANGS['cat_PS'], 'PA' => $LANGS['cat_PA'], 'PG' => $LANGS['cat_PG'], 'PY' => $LANGS['cat_PY'], 'PE' => $LANGS['cat_PE'], 'PH' => $LANGS['cat_PH'], 'PN' => $LANGS['cat_PN'], 'PL' => $LANGS['cat_PL'], 'PT' => $LANGS['cat_PT'], 'PR' => $LANGS['cat_PR'], 'QA' => $LANGS['cat_QA'], 'CG' => $LANGS['cat_CG'], 'RE' => $LANGS['cat_RE'], 'RO' => $LANGS['cat_RO'], 'RU' => $LANGS['cat_RU'], 'RW' => $LANGS['cat_RW'], 'BL' => $LANGS['cat_BL'], 'SH' => $LANGS['cat_SH'], 'KN' => $LANGS['cat_KN'], 'LC' => $LANGS['cat_LC'], 'MF' => $LANGS['cat_MF'], 'PM' => $LANGS['cat_PM'], 'VC' => $LANGS['cat_VC'], 'WS' => $LANGS['cat_WS'], 'SM' => $LANGS['cat_SM'], 'ST' => $LANGS['cat_ST'], 'SA' => $LANGS['cat_SA'], 'SN' => $LANGS['cat_SN'], 'RS' => $LANGS['cat_RS'], 'SC' => $LANGS['cat_SC'], 'SL' => $LANGS['cat_SL'], 'SG' => $LANGS['cat_SG'], 'SX' => $LANGS['cat_SX'], 'SK' => $LANGS['cat_SK'], 'SI' => $LANGS['cat_SI'], 'SB' => $LANGS['cat_SB'], 'SO' => $LANGS['cat_SO'], 'ZA' => $LANGS['cat_ZA'], 'GS' => $LANGS['cat_GS'], 'KR' => $LANGS['cat_KR'], 'SS' => $LANGS['cat_SS'], 'ES' => $LANGS['cat_ES'], 'LK' => $LANGS['cat_LK'], 'SD' => $LANGS['cat_SD'], 'SR' => $LANGS['cat_SR'], 'SJ' => $LANGS['cat_SJ'], 'SZ' => $LANGS['cat_SZ'], 'SE' => $LANGS['cat_SE'], 'CH' => $LANGS['cat_CH'], 'SY' => $LANGS['cat_SY'], 'TW' => $LANGS['cat_TW'], 'TJ' => $LANGS['cat_TJ'], 'TZ' => $LANGS['cat_TZ'], 'TH' => $LANGS['cat_TH'], 'TG' => $LANGS['cat_TG'], 'TK' => $LANGS['cat_TK'], 'TO' => $LANGS['cat_TO'], 'TT' => $LANGS['cat_TT'], 'TN' => $LANGS['cat_TN'], 'TR' => $LANGS['cat_TR'], 'TM' => $LANGS['cat_TM'], 'TC' => $LANGS['cat_TC'], 'TV' => $LANGS['cat_TV'], 'VI' => $LANGS['cat_VI'], 'UG' => $LANGS['cat_UG'], 'UA' => $LANGS['cat_UA'], 'AE' => $LANGS['cat_AE'], 'GB' => $LANGS['cat_GB'], 'US' => $LANGS['cat_US'], 'UY' => $LANGS['cat_UY'], 'UZ' => $LANGS['cat_UZ'], 'VU' => $LANGS['cat_VU'], 'VA' => $LANGS['cat_VA'], 'VE' => $LANGS['cat_VE'], 'VN' => $LANGS['cat_VN'], 'WF' => $LANGS['cat_WF'], 'EH' => $LANGS['cat_EH'], 'YE' => $LANGS['cat_YE'], 'ZM' => $LANGS['cat_ZM'], 'ZW' => $LANGS['cat_ZW']];

if (isset($_POST["email"])) {
    $_GUMP->validation_rules([
        "email"             => "required|valid_email|max_len,60",
        "username"          => "required|alpha_numeric|max_len,20",
        "password"          => "required|max_len,20",
        "password_again"    => "required|equalsfield,password",
        "country"           => "required",
        "birthday_mon"      => "required",
        "birthday_day"      => "required",
        "birthday_yr"       => "required",
        "g-recaptcha-response" => "required"
    ]);

    $_GUMP->filter_rules([
        "email"             => "trim|sanitize_email",
        "username"          => "trim"
    ]);

    $Validation     = $_GUMP->run($OG_POST);
    $Sign_Up_Errors = [];

    if ($Validation) {
        $captcha = $OG_POST["h-captcha-response"] ?? '';
        $secretKey = "0x4AEC6A2B9b460aB43248ffB92e3D16ca9c456Ad0";

        $response = file_get_contents("https://api.hcaptcha.com/siteverify?secret=$secretKey&response=$captcha");
        $responseKeys = json_decode($response,true) ?? ['success' => false];

        if($responseKeys["success"]==true) {
            $captcha_solved = 1;
        } else {
           $captcha_solved = 1;
           //$captcha_solved = 1;

        }
        $Username   = $Validation["username"];
        $Email      = $Validation["email"];
        $Country    = $Validation["country"];
        $Birthday   = (int)$Validation["birthday_yr"]."-".(int)$Validation["birthday_mon"]."-".(int)$Validation["birthday_day"];

        if (ageCalculator($Birthday) < 14) {
            notification("You must be 14 or older to use BitView!","/signup"); exit();
        }

        $IP         = getenv('HTTP_CLIENT_IP')?: getenv('HTTP_X_FORWARDED_FOR')?: getenv('HTTP_X_FORWARDED')?: getenv('HTTP_FORWARDED_FOR')?: getenv('HTTP_FORWARDED')?: getenv('REMOTE_ADDR');

        if (isDisposableEmail($Email)) { notification("Disposable emails aren't allowed on BitView!","/signup"); exit(); }
        if (isTorRequest()) { notification($LANGS['torbrowser'],"/signup"); exit(); }
        if ($captcha_solved==0) { notification($LANGS['captchaincorrect'],"/signup"); exit(); }

        $spamopts = [
            "http" => [
                "header" => "Key: 87a85d99-b4da-4f0b-8f59-4521b62022e1"
            ]
        ];
        $IP_VAL = file_get_contents("https://check.getipintel.net/check.php?ip=$IP&contact=bitview@vistafan12.eu.org&flags=m");
        if ($IP_VAL == "1") { notification($LANGS['vpnbrowser'],"/signup"); exit(); }

        $Accounts_Amount = $DB->execute("SELECT count(*) as amount FROM users WHERE ip_address = :IP",true,
                                        [":IP" => $IP])["amount"];
        if ($Accounts_Amount >= 10) { notification($LANGS['toomanyaccounts'],"/signup"); exit(); }


        $Banned_Accounts = $DB->execute("SELECT count(*) as amount FROM users WHERE ip_address LIKE :IP AND is_banned = 1",true,
            [":IP" => "%$IP%"])["amount"];
        if ($Banned_Accounts >= 2) { notification($LANGS['banned2times'],"/signup"); exit(); }

        $DB->execute("SELECT username FROM users WHERE username = :USERNAME OR email = :EMAIL",
                     true,
                     [":USERNAME" => $Username, ":EMAIL" => $Email]);

        if ($DB->Row_Num === 0) {
            $Password   = password_hash((string) $Validation["password"], PASSWORD_BCRYPT);

            $DB->modify("INSERT IGNORE INTO users(username,displayname,email,password,registration_date,i_country,i_age) VALUES(:USERNAME,:DISPLAY,:EMAIL,:PASSWORD,NOW(),:COUNTRY,:BIRTHDAY)",
                        [":USERNAME" => $Username, ":DISPLAY" => $Username, ":EMAIL" => $Email, ":PASSWORD" => $Password, ":COUNTRY" => $Country, ":BIRTHDAY" => $Birthday]);

            $VKEY = random_string("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_", 20);

            $DB->modify("INSERT INTO email_verification(username,vkey,vdate) VALUES(:USERNAME,:VKEY,NOW())",
                        [":USERNAME" => $Username, ":VKEY" => $VKEY]);

            /*
            $Emailer = new Email();
            $Emailer->To      = $Email;
            $Emailer->To_Name = $Username;
            $Emailer->Subject = "Welcome to BitView";
            $Emailer->send_email('<h1><strong><a href="https://bitview.net/a/verify_email?key='.$VKEY.'">Confirm your email address</a> to start participating in the BitView community!</strong></h1><br><h1><strong>Thank You For Signing Up, '.$Username.'!</strong></h1><br><p>You&#39;ve taken the next step in becoming part of the BitView community. Now that you&#39;re a member, you can rate videos, post comments or upload your own videos to the site, you&#39;ll first need to <a href="https://bitview.net/a/verify_email?key='.$VKEY.'">confirm your email address</a>. If that link doesn&#39;t appear enter the following link into your browser:</p><p><a href="https://bitview.net/a/verify_email?key='.$VKEY.'">https://bitview.net/a/verify_email?key='.$VKEY.'</a></p>');
            */
            if ($DB->Row_Num === 1 && $_USER->log_in($Username)) {
                header("location: /"); exit();
            }
        } else {
            $Sign_Up_Errors[] = $LANGS['sameemail'];
        }
    } else {
        if (!ctype_alnum((string) $_POST["username"])) {
            $Sign_Up_Errors[] = $LANGS['usernamechar'];
        }
        if (!isset($_POST["username"]) || !isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["country"]) || !isset($_POST["password_again"])) {
            $Sign_Up_Errors[] = $LANGS['required'];
        }
        if ($_POST["password"] !== $_POST["password_again"]) {
            $Sign_Up_Errors[] = $LANGS['notmatch'];
        }
    }
}

$_PAGE = [
    "Page"          => "signup",
    "Page_Type"     => "home"
];
require "_templates/_structures/main.php";

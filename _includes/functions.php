<?php
use function PHP81_BC\strftime;

function notification(string $Message,$Redirect, string $Color = "FFA3A3") {
    $_SESSION["notification_msg"] = $Message;
    $_SESSION["notification_clr"] = $Color;
    if ($Redirect !== false) {
        header("location: $Redirect"); exit();
    }
    return true;
}
function get_time_ago($time) {
    if (isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE["lang"].".lang.php")) {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE["lang"] . ".lang.php";
	}
	elseif (!isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5) . ".lang.php")) {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5) . ".lang.php";
	}
	elseif (!isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) . ".lang.php")) {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2).".lang.php";
	}
	else {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/en-US.lang.php";
	}
    $time = time() - strtotime((string) $time);
    $time = ($time < 1)? 1 : $time;
    $tokens =  [
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second',
    ];

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        if ($numberOfUnits == 1 and $text == 'second') {
            return str_replace("{t}",$numberOfUnits.' '.$LANGS['second'],$LANGS['ago']);
        }
        if ($numberOfUnits > 1 and $text == 'second') {
            return str_replace("{t}",$numberOfUnits.' '.$LANGS['seconds'],$LANGS['ago']);
        }
        if ($numberOfUnits == 1 and $text == 'minute') {
            return str_replace("{t}",$numberOfUnits.' '.$LANGS['minute'],$LANGS['ago']);
        }
        if ($numberOfUnits > 1 and $text == 'minute') {
           return str_replace("{t}",$numberOfUnits.' '.$LANGS['minutes'],$LANGS['ago']);
        }
        if ($numberOfUnits == 1 and $text == 'hour') {
            return str_replace("{t}",$numberOfUnits.' '.$LANGS['hour'],$LANGS['ago']);
        }
        if ($numberOfUnits > 1 and $text == 'hour') {
            return str_replace("{t}",$numberOfUnits.' '.$LANGS['hours'],$LANGS['ago']);
        }
        if ($numberOfUnits == 1 and $text == 'day') {
            return str_replace("{t}",$numberOfUnits.' '.$LANGS['day'],$LANGS['ago']);
        }
        if ($numberOfUnits > 1 and $text == 'day') {
            return str_replace("{t}",$numberOfUnits.' '.$LANGS['days'],$LANGS['ago']);
        }
        if ($numberOfUnits == 1 and $text == 'week') {
            return str_replace("{t}",$numberOfUnits.' '.$LANGS['week'],$LANGS['ago']);
        }
        if ($numberOfUnits > 1 and $text == 'week') {
            return str_replace("{t}",$numberOfUnits.' '.$LANGS['weeks'],$LANGS['ago']);
        }
        if ($numberOfUnits == 1 and $text == 'month') {
            return str_replace("{t}",$numberOfUnits.' '.$LANGS['month'],$LANGS['ago']);
        }
        if ($numberOfUnits > 1 and $text == 'month') {
            return str_replace("{t}",$numberOfUnits.' '.$LANGS['months'],$LANGS['ago']);
        }
        if ($numberOfUnits == 1 and $text == 'year') {
            return str_replace("{t}",$numberOfUnits.' '.$LANGS['year'],$LANGS['ago']);
        }
        if ($numberOfUnits > 1 and $text == 'year') {
            return str_replace("{t}",$numberOfUnits.' '.$LANGS['years'],$LANGS['ago']);
        }
    }
}
function ageCalculator($dob){
    if(!empty($dob)){
        $birthdate = new DateTime($dob);
        $today   = new DateTime('today');
        $age = $birthdate->diff($today)->y;
        return $age;
    }else{
        return 0;
    }
}

function avg_ratings($Ratings) {
    if (is_array($Ratings)) {
        $Star_1 = $Ratings["1stars"];
        $Star_2 = $Ratings["2stars"];
        $Star_3 = $Ratings["3stars"];
        $Star_4 = $Ratings["4stars"];
        $Star_5 = $Ratings["5stars"];

        $Rating_Num = $Star_1 + $Star_2 + $Star_3 + $Star_4 + $Star_5;

        if ($Rating_Num > 0) {
            $Rating = ($Star_1 + $Star_2 * 2 + $Star_3 * 3 + $Star_4 * 4 + $Star_5 * 5) / $Rating_Num;
        } else {
            $Rating = 0;
        }
    } else {
        $Rating = $Ratings;
    }
return $Rating;

}

function show_ratings($Ratings,$width,$height) {
    $Rating_Num = 0;

    if (is_array($Ratings)) {
        $Star_1 = $Ratings["1stars"];
        $Star_2 = $Ratings["2stars"];
        $Star_3 = $Ratings["3stars"];
        $Star_4 = $Ratings["4stars"];
        $Star_5 = $Ratings["5stars"];

        $Rating_Num = $Star_1 + $Star_2 + $Star_3 + $Star_4 + $Star_5;

        if ($Rating_Num > 0) {
            $Rating = ($Star_1 + $Star_2 * 2 + $Star_3 * 3 + $Star_4 * 4 + $Star_5 * 5) / $Rating_Num;
        } else {
            $Rating = 0;
        }
    } else {
        $Rating = $Ratings;
    }

    $Full_Stars = substr((string) $Rating,0,1);
    $Half_Stars = substr((string) $Rating,2,3);
    $StarNum    = 0;

    $Width = "";
    $Height = "";

    if ($width != "auto") { $Width = "width='$width'"; }
    if ($height != "auto") { $Height = "height='$height'"; }

    if ($Rating_Num == 0 && $Rating == 0) {
        echo "no rating";
    }

    else {
        for($x = 0; $x < $Full_Stars; $x++) {
            $StarNum++;
            echo "<img src='/img/fullstar.png' $Width $Height> ";
        }
        if ($Half_Stars !== "" && $Half_Stars !== false) {
            $StarNum++;
            echo "<img src='/img/halfstar.png' $Width $Height> ";
        }
        while($StarNum < 5) {
            $StarNum++;
            echo "<img src='/img/nostar.png' $Width $Height> ";
        }
    }
}

function number_format_lang($String) {
    if (isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE["lang"].".lang.php")) {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE["lang"] . ".lang.php";
	}
	elseif (!isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5) . ".lang.php")) {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5) . ".lang.php";
	}
	elseif (!isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) . ".lang.php")) {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2).".lang.php";
	}
	else {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/en-US.lang.php";
	}
    if ($LANGS['numberformat'] == 1) {
        return number_format($String);
    }
    else {
        return $String;
    }
}

function time_machine($Date) {
    $Year = (int)date("Y", $Date);
    if ($Year == 2017 or $Year == 2018 or $Year == 2019 or $Year == 2020) {
        $TimeBack = "-12 years";
    }
    elseif ($Year == 2021) {
        $TimeBack = "-13 years";
    }
    elseif ($Year == 2022) {
        $TimeBack = "-14 years";
    }
    elseif ($Year >= 2023) {
        $TimeBack = "-14 years";
    }
    else {
        $TimeBack = "0 years";
    }
    if (isset($_COOKIE['time_machine'])) {
    return strtotime($TimeBack, $Date);
    }
    else {
    return strtotime("0 years", $Date);  
    }
}

function get_date($Date,$Format) {
    if (isset($_COOKIE['time_machine'])) { return strftime($Format, time_machine(strtotime((string) $Date))); }
    else {return strftime($Format, strtotime((string) $Date)); }
}

function cache_bust($File) {
    $Path = $_SERVER["DOCUMENT_ROOT"].$File;
    return file_exists($Path) ? $File."?".filemtime($Path) : '';
}

function avatar($User) {
    global $DB;
    $Check = $DB->execute("SELECT avatar FROM users WHERE username = :USERNAME",true,[":USERNAME" => $User]);

    if ($DB->Row_Num > 0) {
        $CheckVideo = $DB->execute("SELECT is_avatar_video FROM users WHERE username = :USERNAME",true,[":USERNAME" => $User]);

        if (empty($Check["avatar"])) {
            $Check = $DB->execute("SELECT url as avatar FROM videos WHERE uploaded_by = :USERNAME AND status = 2 AND privacy = 1 ORDER BY uploaded_on DESC LIMIT 1",true,[":USERNAME" => $User]);
        }
        if ($Check && file_exists($_SERVER["DOCUMENT_ROOT"]."/u/av/".$Check["avatar"].".jpg") || $CheckVideo["is_avatar_video"] == 1) {
        if ($CheckVideo["is_avatar_video"] == 1) { 
            return cache_bust("/u/thmp/".$Check["avatar"].".jpg");
        } else {
            return cache_bust("/u/av/".$Check["avatar"].".jpg");
        }
        } else {
            return "/img/no_videos_140.jpg";
        }
    }
    else {
        return "/img/no_videos_140.jpg";
    }
}

function timestamp($Time) {
    if ($Time >= 60 && $Time < 3600) {
        return ltrim(gmdate('i:s', $Time), 0);
    } elseif ($Time >= 3600) {
        return ltrim(gmdate('H:i:s', $Time), 0);
    }
    else {
        return gmdate('0:s', $Time);
    }
}

function videos($User)
{
    global $DB;
    $subs = $DB->execute("SELECT videos FROM users WHERE username = :USERNAME", true, [":USERNAME" => $User], false);

    if ($DB->Row_Num > 0) {
        return $subs['videos'];
    }
    else {
        return "null";
    }
}
function profile_views($User)
{
    global $DB;
    $subs = $DB->execute("SELECT profile_views FROM users WHERE username = :USERNAME", true, [":USERNAME" => $User], false);
    if ($DB->Row_Num > 0) {
        return $subs['profile_views'];
    }
    else {
        return "null";
    }
}
function subscribers($User)
{
    global $DB;
    $subs = $DB->execute("SELECT subscribers FROM users WHERE username = :USERNAME", true, [":USERNAME" => $User], false);
    if ($DB->Row_Num > 0) {
        return $subs['subscribers'];
    }
    else {
        return "null";
    }
}
function title($User)
{
    global $DB;
    $subs = $DB->execute("SELECT i_title FROM users WHERE username = :USERNAME", true, [":USERNAME" => $User], false);
    if ($DB->Row_Num > 0) {
        if (!empty($subs['i_title'])) {
        return $subs['i_title'];
        }
        else {
        $name = $DB->execute("SELECT displayname FROM users WHERE username = :USERNAME", true, [":USERNAME" => $User], false);
        return $name['displayname'];
        }
    }
    else {
        return $User;
    }
}
function about($User)
{
    global $DB;
    $subs = $DB->execute("SELECT i_desc FROM users WHERE username = :USERNAME", true, [":USERNAME" => $User], false);
    if ($DB->Row_Num > 0) {
        if (!empty($subs['i_desc'])) {
        return $subs['i_desc'];
        }
        else {
        $name = $DB->execute("SELECT i_about FROM users WHERE username = :USERNAME", true, [":USERNAME" => $User], false);
        return $name['i_about'];
        }
    }
    else {
        return "null";
    }
}

function displayname($User) {
    global $DB;
    $name = $DB->execute("SELECT displayname FROM users WHERE username = :USERNAME",true,[":USERNAME" => $User], false);
    if ($name) {
	   return $name['displayname'];
    }
    else {
        return $User;
    }
}

function make_length_clickable($string) {
    $ex = array_reverse(explode(":", (string) $string[1]));
    $seconds = 0;
    
    for($i = 0; $i < count($ex); $i++) {
        $seconds += (int)$ex[$i] * 60 ** $i;
    }
    
    return "<a href=\"#t=$seconds\">$string[1]</a>";
}

function make_user_clickable($text){
    $text = preg_replace_callback('/\b((\d+:){1,2}+\d+)\b/', 'make_length_clickable', (string) $text);
    return preg_replace('/(?<!\S)@([0-9a-zA-Z]+)/', '<a href="/user/$1">@$1</a>', (string) $text);
}


function make_text_bold($text)
{
    $query = $_GET["search"];
    return preg_replace("/\p{L}*?".preg_quote((string) $query)."\p{L}*/ui", "<b>$0</b>", (string) $text);
}


function isTorRequest() { // does not work currently and uses server ip
    return false;
    //$reverse_client_ip = implode('.', array_reverse(explode('.', (string) $_SERVER['REMOTE_ADDR'])));
    //$reverse_server_ip = implode('.', array_reverse(explode('.', (string) $_SERVER['SERVER_ADDR'])));
    //$hostname = $reverse_client_ip . "." . $_SERVER['SERVER_PORT'] . "." . $reverse_server_ip . ".ip-port.exitlist.torproject.org";
    //return gethostbyname($hostname) == "127.0.0.2";
}

function links($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1" rel="nofollow">$1</a>', (string) $text);
}

function sql_IN_fix($Array,$key = NULL) {
    $New_Array = "";
    if (!isset($key)) {
        foreach ($Array as $Value) {
            $New_Array .= "'" . $Value . "'" . ',';
        }
    } else {
        foreach ($Array as $Key => $Value) {
            $New_Array .= "'" . $Key . "'" . ',';
        }
    }
    return substr($New_Array,0,mb_strlen($New_Array) - 1);
}

function short_title($text, int $long) {
    $text = $text ?: "";
    $new_text = (mb_strlen((string) $text) > $long) ? mb_substr((string) $text,0,($long+3)).'...' : $text;
    return $new_text;
}

function short_body(string $string, int $length = 256) : string {
  return (mb_strlen($string) > $length)
    ? mb_substr(
        $string,
        0,
        (mb_strpos($string, "\n", 4) ?: $length - 3) + 1
      ) . '...'
    : $string;
}

function load_thumbnail($url) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/_includes/_classes/Video.class.php'; 
    if (isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE["lang"].".lang.php")) {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE["lang"] . ".lang.php";
	}
	elseif (!isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5) . ".lang.php")) {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5) . ".lang.php";
	}
	elseif (!isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) . ".lang.php")) {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2).".lang.php";
	}
	else {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/en-US.lang.php";
	}
    global $DB;
    global $_USER;
    $_VIDEO = new Video($url,$DB);
    if ($_VIDEO->exists()) {
        $_VIDEO->get_info();
        $_VIDEO->check_info();

        $length = timestamp($_VIDEO->Info["length"]);
        $title = $_VIDEO->Info['title'];
        if (!$_USER->can_watch_video($_VIDEO)) {
            $thumb = "/img/private_video-vfl20830.jpg";
            $length = "0:00";
            $title = "Private Video";
        }
        elseif (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$url.'.jpg')) {
            $thumb = "/u/thmp/$url.jpg";
        }
        else {
            $thumb = "/img/nothump.png";
        }
        return '<a href="/watch?v='.$url.'" class="video-thumb ux-thumb-128" id="video-thumb-'.$url.'"><span class="img"><img title="'.$title.'" alt="'.$title.'" src="'.$thumb.'"></span><span class="video-time">'. $length .'</span><span class="video-actions"><button type="button" class=" yt-uix-button yt-uix-button-short" id="yt-uix-button-short-'.$url.'" onclick="addToQuickList(this);return false;"><span class="yt-uix-button-content"><strong>+</strong></span></button></span><span class="video-in-quicklist">'. $LANGS['addedtoqueue'] .'</span></a>';
    }
    return "";
}
function videoEntry($url, $width, $history = false) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/_includes/_classes/Video.class.php'; 
    if (isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE["lang"].".lang.php")) {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE["lang"] . ".lang.php";
	}
	elseif (!isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5) . ".lang.php")) {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5) . ".lang.php";
	}
	elseif (!isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) . ".lang.php")) {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2).".lang.php";
	}
	else {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/en-US.lang.php";
	}
    global $DB;
    global $_USER;
    $_VIDEO = new Video($url,$DB);
    if ($_VIDEO->exists()) {
        $_VIDEO->get_info();
        $_VIDEO->check_info();
        if (!in_array($_VIDEO->URL,$_USER->Watched_Videos) || !$history) {
            $HTML = '<div class="video-entry">
                            '. load_thumbnail($url) .'
                                <div class="video-main-content" id="video-main-content" style="width: '. $width .'px;padding-left: 12px;">
                                    <div class="video-title video-title-results">
                                        <div class="video-long-title">
                                            <a id="video-long-title" href="/watch?v='. $url .'" title="'. mb_substr((string) $_VIDEO->Info["title"],0,128) .'" rel="nofollow">'. mb_substr((string) $_VIDEO->Info["title"],0,128) .'</a> '. ($_VIDEO->Info["hd"] == 1 ? '<a href="/watch?v=$url"><img src="/img/pixel.gif" class="hd-video-logo"></a>' : '') .'
                                        </div>
                                    </div>

                                    <div id="video-description" class="video-description">
                                        '. ($_VIDEO->Info["description"] ? short_title($_VIDEO->Info["description"],150) : $LANGS['nodesc']) .'
                                    </div>
                    
                                    <div class="vlfacets">
                                        <span id="video-added-time" class="video-date-added">'. get_time_ago($_VIDEO->Info["uploaded_on"]) .'</span>
                                        <span id="video-num-views" class="video-view-count">'. ($LANGS['numberformat'] == 1 ? number_format($_VIDEO->Info["views"]) : ($_VIDEO->Info["views"])) .' '.  $LANGS['videoviews'] .'</span>
                                        <span class="video-username"><a id="video-from-username" class="hLink" href="/user/'. $_VIDEO->Info["uploaded_by"] .'">'. displayname($_VIDEO->Info["uploaded_by"]) .'</a></span>
                                    </div>
                                <div class="video-clear-list-left"></div>
                            </div>
                            <div class="clear"></div>
                        </div>';
        } else {
            $HTML = '<div class="video-entry" style="opacity: 0.5;">
                            '. load_thumbnail($url) .'
                                <div class="video-main-content" id="video-main-content" style="width: '. $width .'px; padding-left: 12px;">
                                    <div class="vlfacets">
                                        <span id="video-added-time" class="video-date-added">'. $LANGS["previouslyviewed"] .'</span>
                                    </div>
                                    <div class="video-title video-title-results">
                                        <div class="video-long-title">
                                            <a id="video-long-title" href="/watch?v='. $url .'" title="'. mb_substr((string) $_VIDEO->Info["title"],0,128) .'" rel="nofollow">'. mb_substr((string) $_VIDEO->Info["title"],0,128) .'</a> '. ($_VIDEO->Info["hd"] == 1 ? '<a href="/watch?v=$url"><img src="/img/pixel.gif" class="hd-video-logo"></a>' : '') .'
                                        </div>
                                    </div>

                                    <div id="video-description" class="video-description">
                                        '. ($_VIDEO->Info["description"] ? short_title($_VIDEO->Info["description"],150) : $LANGS['nodesc']) .'
                                    </div>
                    
                                    <div class="vlfacets">
                                        <span id="video-added-time" class="video-date-added">'. get_time_ago($_VIDEO->Info["uploaded_on"]) .'</span>
                                        <span id="video-num-views" class="video-view-count">'. ($LANGS['numberformat'] == 1 ? number_format($_VIDEO->Info["views"]) : ($_VIDEO->Info["views"])) .' '.  $LANGS['videoviews'] .'</span>
                                        <span class="video-username"><a id="video-from-username" class="hLink" href="/user/'. $_VIDEO->Info["uploaded_by"] .'">'. displayname($_VIDEO->Info["uploaded_by"]) .'</a></span>
                                    </div>
                                <div class="video-clear-list-left"></div>
                            </div>
                            <div class="clear"></div>
                        </div>';
        }
        return $HTML;
    }
    return "";
}
function videoEntryGrid($url, $uploader = true, $history = false) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/_includes/_classes/Video.class.php'; 
    if (isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE["lang"].".lang.php")) {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE["lang"] . ".lang.php";
	}
	elseif (!isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5) . ".lang.php")) {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5) . ".lang.php";
	}
	elseif (!isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) . ".lang.php")) {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/" . substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2).".lang.php";
	}
	else {
	  include $_SERVER['DOCUMENT_ROOT'] . "/lang/en-US.lang.php";
	}
    global $DB;
    global $_USER;
    $_VIDEO = new Video($url,$DB);
    if ($_VIDEO->exists()) {
        $_VIDEO->get_info();
        $_VIDEO->check_info();
        if (!in_array($_VIDEO->URL,$_USER->Watched_Videos) || !$history) {
            $HTML = '<div class="homepage-sponsored-video">
                        '. load_thumbnail($url) .'
                        <div class="vtitle">
                            <a href="/watch?v='. $url .'" name="'. mb_substr((string) $_VIDEO->Info['title'],0,128) .'">'. mb_substr((string) $_VIDEO->Info['title'],0,128) .'</a>
                        </div>
                        <div class="vfacets" style="margin-bottom: 0px;">
                            <div class="dg" style="cursor: pointer;"></div>
                            <div class="vlfacets">
                                <div class="video-date-added" style="color:#666;margin:0">'. get_time_ago($_VIDEO->Info['uploaded_on']) .'</div>
                                <span id="video-num-views" style="color:#666;margin:0">'. ($LANGS['numberformat'] == 1 ? number_format($_VIDEO->Info["views"]) : ($_VIDEO->Info["views"])) .' '.  $LANGS['videoviews'] .'</span>
                                <div class="clearL"></div>
                                '. ($uploader ? '<div><span class="vlfrom"><a href="/user/'. $_VIDEO->Info["uploaded_by"] .'">'. displayname($_VIDEO->Info["uploaded_by"]) .'</a></span></div>' : '') .'
                            </div>
                        </div>
                    </div>';
        } else {
            $HTML = '<div class="homepage-sponsored-video" style="opacity: 0.5">
                        '. load_thumbnail($url) .'
                        <div class="vtitle">
                            <a href="/watch?v='. $url .'" name="'. mb_substr((string) $_VIDEO->Info['title'],0,128) .'">'. mb_substr((string) $_VIDEO->Info['title'],0,128) .'</a>
                        </div>
                        <div class="vfacets" style="margin-bottom: 0px;">
                            <div class="dg" style="cursor: pointer;"></div>
                            <div class="vlfacets">
                                <div class="video-date-added" style="color:#666;margin:0">'. get_time_ago($_VIDEO->Info['uploaded_on']) .'</div>
                                <span id="video-num-views" style="color:#666;margin:0">'. ($LANGS['numberformat'] == 1 ? number_format($_VIDEO->Info["views"]) : ($_VIDEO->Info["views"])) .' '.  $LANGS['videoviews'] .'</span>
                                '. ($uploader ? '<div><span class="vlfrom"><a href="/user/'. $_VIDEO->Info["uploaded_by"] .'">'. displayname($_VIDEO->Info["uploaded_by"]) .'</a></span></div>' : '') .'
                                <div style="color:#666;margin:0">'. $LANGS["previouslyviewed"] .'</div>
                                <div class="clearL"></div>
                            </div>
                        </div>
                    </div>';
        }
        return $HTML;
    }
    return "";
}

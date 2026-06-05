<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

function make_links_clickable($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', (string) $text);
}

//PERMISSIONS AND REQUIREMENTS
////"$_GET["v"]" MUST NOT BE LOGGED IN
if (!isset($_GET["v"])) { 
    if (isset($_COOKIE["feather"]) && $_COOKIE["feather"] == 1) {
        notification($LANGS['videonotexist'],"/"); exit();
    }
    else {
        $ErrorMessage = $LANGS['videonotexist'];
        $_PAGE = [
            "Page"          => "watch_error",
            "Page_Type"     => "watch",
            "Title"         => "BitView - Express Yourself.",
            "Description"   => "",
            "Keywords"      => "",
            "Show_Search"   => true,
            "new"           => true,
            "head"          => "watch"
        ];
        require "_templates/_structures/main.php";
    }
}
if (!$_CONFIG->Config["videos"])    { notification($LANGS['watchdisabled'],"/"); exit(); }
if (isset($_GET["c"]) && ($_GET["c"] !== "all")) { header("location: /"); exit(); }
$_VIDEO = new Video($_GET["v"],$DB);
$_INBOX = new Inbox($_USER,$DB);

$_USER->get_info();

if ($_VIDEO->exists()) {
    $_VIDEO->get_info();
    $_VIDEO->check_info();

    $_OWNER = new User($_VIDEO->Info["uploaded_by"],$DB);
    $_OWNER->get_info();

    //Redirect if the Uploader has been banned unless you're an admin or moderator
    if ($_VIDEO->Info["uploaded_by_banned"] && !$_USER->Is_Admin && !$_USER->Is_Moderator) { 
        if (isset($_COOKIE["feather"]) && $_COOKIE["feather"] == 1) {
            notification($LANGS['terminatedvideoerror'],"/"); exit();
        }
        else {
            $ErrorMessage = $LANGS['terminatedvideoerror'];
            $_PAGE = [
                "Page"          => "watch_error",
                "Page_Type"     => "watch",
                "Title"         => "BitView - Express Yourself.",
                "Description"   => "",
                "Keywords"      => "",
                "Show_Search"   => true,
                "new"           => true,
                "head"          => "watch"
            ];
            require "_templates/_structures/main.php";
            exit();
        }
    }

    //Redirect if the video has been deleted unless you're an admin or moderator
    if ($_VIDEO->Info["is_deleted"] && !$_USER->Is_Admin && !$_USER->Is_Moderator) { 
        if (isset($_COOKIE["feather"]) && $_COOKIE["feather"] == 1) {
            notification($LANGS['videonotexist'],"/"); exit();
        }
        else {
            $ErrorMessage = $LANGS['videonotexist'];
            $_PAGE = [
                "Page"          => "watch_error",
                "Page_Type"     => "watch",
                "Title"         => "BitView - Express Yourself.",
                "Description"   => "",
                "Keywords"      => "",
                "Show_Search"   => true,
                "new"           => true,
                "head"          => "watch"
            ];
            require "_templates/_structures/main.php";
            exit();
        }
    }

    if ($_VIDEO->Info["age_restricted"] && (!$_USER->Logged_In || $_USER->Logged_In && ageCalculator($_USER->Info['i_age']) < 18 && $_USER->Username != $_OWNER->Username && !$_USER->Is_Admin && !$_USER->Is_Moderator)) { header("Location: /verify_age?next_url=".urlencode((string) $_SERVER['REQUEST_URI'])); exit(); }

    if (!in_array($_VIDEO->URL,$_USER->Watched_Videos) && !empty($_SERVER["HTTP_REFERER"]) && mb_strpos((string) $_SERVER["HTTP_REFERER"],"bitview.net") === false && filter_var($_SERVER["HTTP_REFERER"], FILTER_VALIDATE_URL) !== FALSE) {
        $DB->modify("INSERT IGNORE INTO videos_links (link,url,clicks) VALUES (:LINK,:URL,1) ON DUPLICATE KEY UPDATE clicks = clicks + 1",[":LINK" => $_SERVER["HTTP_REFERER"],":URL" => $_VIDEO->URL]);
    }

    //Redirect is user is not able to watch it due to privacy settings
    if (!$_USER->can_watch_video($_VIDEO,$_OWNER)) { 
        if (isset($_COOKIE["feather"]) && $_COOKIE["feather"] == 1) {
            notification($LANGS['thisvideoisprivate'],"/"); exit();
        }
        else {
            $ErrorMessage = $LANGS['thisvideoisprivate'];
            $_PAGE = [
                "Page"          => "watch_error",
                "Page_Type"     => "watch",
                "Title"         => "BitView - Express Yourself.",
                "Description"   => "",
                "Keywords"      => "",
                "Show_Search"   => true,
                "new"           => true,
                "head"          => "watch"
            ];
            require "_templates/_structures/main.php";
        }
        exit();
    }


    //$Video_Tags     = $_VIDEO->tag_array();
    $_PAGINATION = new Pagination(10, 1000);
    $_PAGINATION->total($_VIDEO->Info["comments"]);
    if ($_VIDEO->Info["comments"] > 0) { $Video_Comments = $_VIDEO->comments(true,1,10); }

    if ($_USER->watch_video($_VIDEO))   { $Already_Watched = false; }
    else                                { $Already_Watched = true; }

    if ($_USER->Logged_In && $_USER->has_favorited($_VIDEO))    { $Has_Favorited  = true; }
    else                                                        { $Has_Favorited  = false; }

    $Total_Ratings = $_VIDEO->Info["1stars"] + $_VIDEO->Info["2stars"] + $_VIDEO->Info["3stars"] + $_VIDEO->Info["4stars"] + $_VIDEO->Info["5stars"];

    $Likes = $_VIDEO->Info["3stars"] + $_VIDEO->Info["4stars"] + $_VIDEO->Info["5stars"];
    $Dislikes = $_VIDEO->Info["1stars"] + $_VIDEO->Info["2stars"];

    if ($Total_Ratings != 0) {
        $Like_Ratio = round($Likes / $Total_Ratings, 2);
        $Dislike_Ratio = round(1 - $Like_Ratio, 2);
    }
    else {
        $Like_Ratio = 0;
        $Dislike_Ratio = 0;
    }

    $Highest_Rated = $DB->execute("SELECT * FROM videos_comments WHERE url = :URL and (likes - dislikes) > 0 ORDER BY likes DESC LIMIT 2",false,[":URL" => $_VIDEO->URL]);

    if (isset($_GET["pl"])) {
        $Playlist = $DB->execute("SELECT playlists.id, playlists.title FROM playlists INNER JOIN playlists_videos ON playlists_videos.playlist_id = playlists.id WHERE playlists_videos.url = :URL AND playlists_videos.playlist_id = :ID", true,
                                [
                                    ":URL" => $_VIDEO->URL,
                                    ":ID"  => $_GET["pl"]
                                ]);

        if ($DB->Row_Num == 0) {
            header("location: /watch?v=".$_VIDEO->URL);
        }
        $Current_Position = $DB->execute("SELECT position FROM playlists_videos WHERE playlist_id = :ID AND url = :URL", true, [":ID" => $Playlist["id"], ":URL" => $_VIDEO->URL])["position"];
        $Position = $Current_Position;
        $PLCount = $DB->execute("SELECT count(*) as position FROM playlists_videos WHERE playlist_id = :ID", true, [":ID" => $Playlist["id"]])["position"];
        $Next_Video = $DB->execute("SELECT * FROM playlists_videos WHERE playlists_videos.position > :POSITION AND playlists_videos.playlist_id = :ID ORDER BY position ASC LIMIT 1", true, [":POSITION" => $Current_Position, ":ID" => $_GET["pl"]]);
        if ($DB->Row_Num > 0) {
            $Next_Video_Pos = $Next_Video['position'];
            $_NXTVID = new Video($Next_Video["url"],$DB);
            if ($_NXTVID->exists()) {
                $_NXTVID->get_info();
            }
        }
        $Playlist_Videos = new Videos($DB,$_USER);
        $Playlist_Videos->ORDER_BY = "playlists_videos.position ASC";
        $Playlist_Videos->SELECT  .= ", playlists_videos.position";
        $Playlist_Videos->JOIN     = "INNER JOIN playlists_videos ON playlists_videos.url = videos.url";
        $Playlist_Videos->WHERE_C  = "AND playlists_videos.playlist_id = :PLAYLIST";
        $Playlist_Videos->Execute  = [":PLAYLIST" => $Playlist["id"]];
        $Playlist_Videos->Private_Videos = true;
        $Playlist_Videos->get();
        $Playlist_Amount             = $Playlist_Videos::$Amount;
        
        if ($Playlist_Videos::$Videos) {
            $Playlist_Videos = $Playlist_Videos->fix_values(true,true);
        } else {
            $Playlist_Videos = false;
        }
    }

    //MORE FROM

    /*$More_From = $DB->execute("SELECT * FROM videos WHERE uploaded_by = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL AND url != :URL ORDER BY videos.uploaded_on DESC LIMIT 4", false, [":USERNAME" => $_OWNER->Username, ":URL" => $_VIDEO->URL]);

    NOT NEEDED FOR THIS LAYOUT!!
    */

    //VIDEO RESPONSES
    $Video_Responses = new Videos($DB, $_USER);
    $Video_Responses->WHERE_C = "AND videos_responses.basevid_id = :VIDEOID AND videos_responses.is_added=1";
    $Video_Responses->JOIN = "INNER JOIN videos_responses ON videos_responses.vid_id = videos.url";
    $Video_Responses->ORDER_BY = "videos.uploaded_on DESC";
    $Video_Responses->Execute = [":VIDEOID" => $_GET["v"]];
    $Video_Responses->LIMIT      = 2;
    $Video_Responses->get();
    $Responses_Amount = $Video_Responses::$Amount;
    if ($Video_Responses::$Videos) {
        $Video_Responses = $Video_Responses->fix_values(true, false);
    } else {
        $Video_Responses = false;
    }

    $Featured_Video = $DB->execute("SELECT * FROM videos LEFT JOIN users_block ON ((:USERNAME = users_block.blocker AND videos.uploaded_by = users_block.blocked) OR (:USERNAME = users_block.blocked AND videos.uploaded_by = users_block.blocker)) WHERE videos.featured = 1 AND status = 2 AND (users_block.blocker IS NULL) AND privacy = 1 AND is_deleted IS NULL AND uploaded_by_banned = 0 AND url != :URL ORDER BY videos.uploaded_on DESC LIMIT 1", false, [":USERNAME" => $_USER->Username, ":URL" => $_VIDEO->URL]);

    $Featured_URL = $Featured_Video[0]['url'] ?? '';

    $Title = $_VIDEO->Info['title'];
    $Description = $_VIDEO->Info['description'];

    //RELATED VIDEOS
    $Related_Videos = new Videos($DB,$_USER);
    $Related_Videos->WHERE_C        = " AND MATCH(videos.title, videos.description) AGAINST (:TITLE :DESCRIPTION) AND videos.url <> :URL AND videos.url <> :FEATURED";
    $Related_Videos->Execute        = [":TITLE" => $Title, ":DESCRIPTION" => $Description, ":URL" => $_VIDEO->URL, ":FEATURED" => $Featured_URL];
    $Related_Videos->SELECT        .= ", MATCH(videos.title, videos.description) AGAINST (:TITLE :DESCRIPTION) as rel ";
    $Related_Videos->ORDER_BY       = "((rel * 100) * least(2, greatest(1, videos.views / 20))) DESC";
    $Related_Videos->LIMIT      = 19;
    $Related_Videos->get();
    $Related_Amount             = $Related_Videos::$Amount;

    if ($Related_Videos::$Videos) {
        $Related_Videos = $Related_Videos->fix_values(true,true);
        /* LEGACY CODE
        if ($Related_Amount > 1) {
            $Related_Tags = array();

            foreach ($Related_Videos as $Video_Tags1) {
                foreach ($Video_Tags1["tags"] as $Key => $Value) {
                    $Related_Tags[] = $Value;
                }
            }
            shuffle($Related_Tags);
            $Related_Tags = array_unique($Related_Tags);
            array_splice($Related_Tags,16);
        } */
    } else {
        $Related_Videos = [];
    }

    $Total_Ratings = $_VIDEO->Info["1stars"] + $_VIDEO->Info["2stars"] + $_VIDEO->Info["3stars"] + $_VIDEO->Info["4stars"] + $_VIDEO->Info["5stars"];
    if ($_USER->Logged_In) { $Rated = $_USER->has_rated($_VIDEO); }
    else                   { $Rated = false; }

    if ($_USER->Logged_In) { $Flagged = $_USER->has_flagged($_VIDEO); }
    else                   { $Flagged = false; }

    if ($_USER->Logged_In) { $Subscribed = $_USER->is_subscribed($_OWNER); }
    else                   { $Subscribed = false; }

    /* LEGACY CODE
    $Previous_Video             = new Videos($DB,$_USER);
    if (!isset($_GET["pl"])) {
        $Previous_Video->ORDER_BY   = "videos.uploaded_on DESC";
        $Previous_Video->WHERE_C    = "AND videos.uploaded_on < :DATE AND videos.uploaded_by = :USERNAME";
        $Previous_Video->Execute    = [":DATE" => $_VIDEO->Info["uploaded_on"], ":USERNAME" => $_OWNER->Username];
    } else {
        $Previous_Video->ORDER_BY   = "playlists_videos.position DESC";
        $Previous_Video->WHERE_C    = "AND playlists_videos.position < :POSITION AND playlists_videos.playlist_id = :PLAYLIST";
        $Previous_Video->Execute    = [":POSITION" => $Current_Position, ":PLAYLIST" => $Playlist["id"]];
        $Previous_Video->JOIN       = "INNER JOIN playlists_videos ON playlists_videos.url = videos.url";
    }
    $Previous_Video->LIMIT      = 1;
    $Previous_Video->get();

    if ($Previous_Video::$Videos) {
        $Previous_Video = $Previous_Video->fix_values(true);
    } else {
        $Previous_Video = false;
    } */

    $Next_Video             = new Videos($DB,$_USER);
    if (!isset($_GET["pl"])) {
        $Next_Video->ORDER_BY   = "videos.uploaded_on ASC";
        $Next_Video->WHERE_C    = "AND videos.uploaded_on > :DATE AND videos.uploaded_by = :USERNAME";
        $Next_Video->Execute    = [":DATE" => $_VIDEO->Info["uploaded_on"], ":USERNAME" => $_OWNER->Username];
    } else {
        $Next_Video->ORDER_BY   = "playlists_videos.position ASC";
        $Next_Video->WHERE_C    = "AND playlists_videos.position > :POSITION AND playlists_videos.playlist_id = :PLAYLIST";
        $Next_Video->Execute    = [":POSITION" => $Current_Position, ":PLAYLIST" => $Playlist["id"]];
        $Next_Video->JOIN       = "INNER JOIN playlists_videos ON playlists_videos.url = videos.url";
    }
    $Next_Video->LIMIT      = 1;
    $Next_Video->get();

    if ($Next_Video::$Videos) {
        $Next_Video = $Next_Video->fix_values(true);
    } else {
        $Next_Video = false;
    }

    //$LatestRatings       = $DB->execute("SELECT * FROM videos_ratings INNER JOIN videos on videos_ratings.url = videos.url WHERE videos_ratings.url = :URL ORDER BY videos_ratings.submit_date DESC LIMIT 5",false,[":URL" => $_VIDEO->URL]);

    $Video_Category = [1 => $LANGS['cat1'], 2 => $LANGS['cat2'], 3 => $LANGS['cat3'], 4 => $LANGS['cat4'], 5 => $LANGS['cat5'], 6 => $LANGS['cat6'], 7 => $LANGS['cat7'], 8 => $LANGS['cat8'], 9 => $LANGS['cat9'], 10 => $LANGS['cat10'], 11 => $LANGS['cat11'], 12 => $LANGS['cat12'], 13 => $LANGS['cat13'], 14 => $LANGS['cat14'], 15 => $LANGS['cat15'], 16 => $LANGS['cat16'], 17 => $LANGS['cat17'], 18 => $LANGS['cat18'], 19 => $LANGS['cat19'], 20 => $LANGS['cat20'], 21 => $LANGS['cat21']];

    function secondsToTime($inputSeconds) {
        $secondsInAMinute = 60;
        $secondsInAnHour = 60 * $secondsInAMinute;
        $secondsInADay = 24 * $secondsInAnHour;
        $days = floor($inputSeconds / $secondsInADay);
        $hourSeconds = $inputSeconds % $secondsInADay;
        $hours = floor($hourSeconds / $secondsInAnHour);
        $minuteSeconds = $hourSeconds % $secondsInAnHour;
        $minutes = floor($minuteSeconds / $secondsInAMinute);
        $remainingSeconds = $minuteSeconds % $secondsInAMinute;
        $seconds = ceil($remainingSeconds);
        $timeParts = [];
        $sections = [
            'day' => (int)$days,
            'hour' => (int)$hours,
            'minute' => (int)$minutes,
            'second' => (int)$seconds,
        ];
        foreach ($sections as $name => $value){
            if ($value > 0){
                $timeParts[] = $value. ' '.$name.($value == 1 ? '' : 's');
            }
        }
        return implode(', ', $timeParts);
    }

    //$In_Playlists = $DB->execute("SELECT playlists.title, playlists.id FROM playlists INNER JOIN playlists_videos ON playlists_videos.playlist_id = playlists.id WHERE playlists_videos.url = :URL", false, [":URL" => $_VIDEO->URL]);

    if (!empty($_VIDEO->Info["title"]))       { $Page_Title = $_VIDEO->Info["title"];   }
    else                                      { $Page_Description = "???";              }

    if (!empty($_VIDEO->Info["description"])) { $Page_Description = $_VIDEO->Info["description"];   }
    else                                      { $Page_Description = "No Description.";              }

    if (!empty($_VIDEO->Info["tags"]))        { $Page_Keywords    = $_VIDEO->Info["tags"];          }
    else                                      { $Page_Keywords    = $_CONFIG::$Statics["keywords"]; }

if (!isset($_GET["c"])) {
    if (isset($_COOKIE["feather"]) && $_COOKIE["feather"] == 1) {
        $Page = "watch_feather";
    }
    else {
        $Page = "watch";
    }
} elseif ($_GET["c"] == "all") {
    $Page = "watch_comments";
    if ($_VIDEO->Info["comments"] > 0) { $Video_Comments_All = $_VIDEO->comments(true,1); }
}
    if ($_VIDEO->Info["is_deleted"]) {
        notification($LANGS['videonotexist'], false);
    }
    $_PAGE = [
        "Page"          => $Page,
        "Page_Type"     => "watch",
        "Title"         => $Page_Title,
        "Description"   => $Page_Description,
        "Keywords"      => $Page_Keywords,
        "Show_Search"   => true,
        "new"           => true,
        "head"          => "watch"
    ];
    if (isset($_COOKIE["feather"]) && $_COOKIE["feather"] == 1) {
        require "_templates/_structures/main_feather.php";
    }
    else {
        require "_templates/_structures/main.php";
    }
} else {
    $Strike = $DB->execute("SELECT * FROM copyright_strikes WHERE copyright_strikes.url = :URL", true, [":URL" => $_VIDEO->URL]);
    $Copyright_Holder = $Strike['copyright_holder'] ?? '';
    $ErrorMessage = str_replace("{c}",$Copyright_Holder,$LANGS['copyrighterror']);
    if ($Strike) {
        if (isset($_COOKIE["feather"]) && $_COOKIE["feather"] == 1) {
            notification("$ErrorMessage","/"); exit();
        }
        else {
            $_PAGE = [
                "Page"          => "watch_error",
                "Page_Type"     => "watch",
                "Title"         => "BitView - Express Yourself.",
                "Description"   => "",
                "Keywords"      => "",
                "Show_Search"   => true,
                "new"           => true,
                "head"          => "watch"
            ];
            require "_templates/_structures/main.php";
        }
    }
    else {
        if (isset($_COOKIE["feather"]) && $_COOKIE["feather"] == 1) {
            notification($LANGS['videonotexist'],"/"); exit();
        }
        else {
            $ErrorMessage = $LANGS['videonotexist'];
            $_PAGE = [
                "Page"          => "watch_error",
                "Page_Type"     => "watch",
                "Title"         => "BitView - Express Yourself.",
                "Description"   => "",
                "Keywords"      => "",
                "Show_Search"   => true,
                "new"           => true,
                "head"          => "watch"
            ];
            require "_templates/_structures/main.php";
        }
    }
}

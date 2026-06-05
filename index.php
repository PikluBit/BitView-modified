<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

function get_popular($DB, $Order, $Date, $Category = "") {
    $Result = $DB->execute("SELECT * FROM videos INNER JOIN users ON users.username = videos.uploaded_by WHERE ".($Category ? "category = ".$Category." AND " : "")."videos.uploaded_on > DATE_SUB(NOW(), INTERVAL $Date) AND videos.reupload = 0 AND videos.privacy = 1 AND videos.status = 2 AND videos.is_deleted IS NULL AND videos.uploaded_by_banned = 0 AND users.is_reuploader = 0 ORDER BY $Order LIMIT 1");
    if ($DB->Row_Num < 1) {
        $Result = $DB->execute("SELECT * FROM videos INNER JOIN users ON users.username = videos.uploaded_by WHERE ".($Category ? "category = ".$Category." AND " : "")."videos.reupload = 0 AND videos.privacy = 1 AND videos.status = 2 AND videos.is_deleted IS NULL AND videos.uploaded_by_banned = 0 AND users.is_reuploader = 0 ORDER BY uploaded_on DESC,views DESC LIMIT 1");
    }
    return $Result;
}

$Blog_Posts     = $DB->execute("SELECT * FROM blog_posts ORDER BY submit_on DESC LIMIT 3");
$Box_MSG        = $DB->execute("SELECT value FROM config WHERE name = 'box_text'", true);
if ($DB->Row_Num < 1) {
    $Box_MSG = ['value' => 'SexView '];
}

if ($_USER->Logged_In) {
    $_USER->get_info();

    if (isset($_GET["understand"])) {
        $DB->modify("UPDATE copyright_strikes SET accepted = 1 WHERE url = :URL", [":URL" => $_GET["understand"]]);
        header("location: /");
        exit();
    }

    if ($_USER->Info["videos"] > 0) {
        $Total_Views = (int)$DB->execute("SELECT sum(views) as total FROM videos WHERE uploaded_by = :USERNAME and privacy = 1", true, [":USERNAME" => $_USER->Username])["total"];
    } else {
        $Total_Views = 0;
    }

    $Requests = (int)$DB->execute("SELECT count(id) as total FROM users_friends WHERE friend_2 = :USERNAME AND status = 0", true, [":USERNAME" => $_USER->Username])["total"];
    $Messages = $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND is_notification is NULL AND type = 0 AND seen = 0",true,[":USERNAME" => $_USER->Username])["amount"];
    $Modules = explode(",", (string) $_USER->Info['h_modules']);

    if ($_USER->Info['h_subscriptions']) {
    if ($_USER->Logged_In) {
        $Sub_Limit = $_USER->Info['h_subscriptions_limit'];
        $Sub_Style = $_USER->Info['h_subscriptions_style'];
    }
    else {
        $Sub_Limit = 8;
        $Sub_Style = 'grid';
    }
    $Subscriptions = new Videos($DB, $_USER);
    $Subscriptions->WHERE_C = "AND subscriptions.subscriber = :USERNAME and privacy = 1";
    $Subscriptions->JOIN    = "INNER JOIN subscriptions ON subscriptions.subscription = videos.uploaded_by";
    $Subscriptions->ORDER_BY = "videos.uploaded_on DESC";
    $Subscriptions->Execute = [":USERNAME" => $_USER->Username];
    $Subscriptions->LIMIT = (int)$Sub_Limit;
    $Subscriptions->get();
    if ($Subscriptions::$Videos) {
        $Subscriptions = $Subscriptions->fix_values(true, false);
    } else {
        $Subscriptions = false;
    }

    }

    $Strikes = $DB->execute("SELECT * FROM copyright_strikes WHERE accepted = 0 AND for_user = :USERNAME ORDER BY copyright_strikes.submit_date DESC", false, [":USERNAME" => $_USER->Username]);
}


//FEATURED VIDEOS
/* OLD CODE, MIGHT USE FOR OTHER PURPOSES
if (!$_USER->Logged_In or ($_USER->Logged_In && $_USER->Info['h_featured'])) {
if ($_USER->Logged_In) {
    $Featured_Limit = $_USER->Info['h_featured_limit'];
    $Featured_Style = $_USER->Info['h_featured_style'];
}
else {
    $Featured_Limit = 4;
    $Featured_Style = 'grid';
}
$Featured_Videos            = new Videos($DB, $_USER);
$Featured_Videos->WHERE_P   = ["videos.featured" => 1];
$Featured_Videos->ORDER_BY  = "videos.uploaded_on DESC";
$Featured_Videos->LIMIT     = (int)$Featured_Limit;
$Featured_Videos->get();

$Featured_Videos = $Featured_Videos->fix_values(true, true);
}
*/

$Featured_Videos            = new Videos($DB, $_USER);
$Featured_Videos->WHERE_P   = ["videos.featured" => 1];
$Featured_Videos->ORDER_BY  = "videos.uploaded_on DESC";
$Featured_Videos->LIMIT     = 3;
$Featured_Videos->get();

$Featured_Videos = $Featured_Videos->fix_values(true, true);
//RECENTLY VIEWED

if (!$_USER->Logged_In or ($_USER->Logged_In && $_USER->Info['h_beingwatched'])) {
if ($_USER->Logged_In) {
    $Being_Watched_Limit = $_USER->Info['h_beingwatched_limit'];
    $Being_Watched_Style = $_USER->Info['h_beingwatched_style'];
    if ($Being_Watched_Style == 'bigthumb') {
        $Being_Watched_Limit = 4;
    }
}
else {
    $Being_Watched_Limit = 4;
    $Being_Watched_Style = 'bigthumb';
}

$Recently_Viewed            = new Videos($DB, $_USER);
$Recently_Viewed->JOIN      = "INNER JOIN being_watched ON being_watched.url = videos.url";
$Recently_Viewed->ORDER_BY  = "being_watched.submit_date DESC";
$Recently_Viewed->LIMIT     = (int)$Being_Watched_Limit;
$Recently_Viewed->SELECT   .= ", being_watched.submit_date";
$Recently_Viewed->get();

$Recently_Viewed = $Recently_Viewed->fix_values(true);
}

/// CONTEST
$Latest_Contest = $DB->execute("SELECT * FROM contest ORDER BY id DESC LIMIT 1", true);

//GET TAGS
//$Video_Tags = $DB->execute("SELECT tags FROM videos WHERE tags <> '' AND privacy = 1 AND status = 2 AND is_deleted IS NULL AND uploaded_by_banned = 0 ORDER BY uploaded_on DESC LIMIT 200",false); NOT NEEDED FOR NOW

//RECOMMENDED
if (!$_USER->Logged_In or ($_USER->Logged_In && $_USER->Info['h_recommended'])) {
    $Recommended_Limit = 8;
    $Recommended_Style = 'grid';
    if (count($_USER->Watched_Videos) >= 1) {
        $Watched_Videos = array_slice($_USER->Watched_Videos, -6);
        $Watched_Videos = sql_IN_fix($Watched_Videos);
        $Watched_Videos_Titles = $DB->execute("SELECT title FROM videos WHERE url IN ($Watched_Videos) ORDER BY FIELD(url,$Watched_Videos)");
        shuffle($Watched_Videos_Titles);
        $All_Titles = "";

        foreach ($Watched_Videos_Titles as $Watched_Title) {
            $All_Titles .= $Watched_Title["title"]." ";
        }

        $All_Titles = array_filter(explode(" ", $All_Titles));
        $New_All_Titles = [];

        foreach ($All_Titles as $Title) {
            if (!in_array($Title, $Watched_Videos_Titles) && ctype_alnum($Title) && !is_numeric($Title) && mb_strlen($Title) >= 3) {
                $New_All_Titles[] = mb_strtolower($Title);
            }
        }

        $All_Titles = array_count_values($New_All_Titles);
        asort($All_Titles);
        $All_Titles = array_slice($All_Titles, -6);

        $New_All_Titles = "";
        $Main_Title = "";
        $Count = 0;
        $Amount = count($All_Titles);

        foreach ($All_Titles as $value => $key) {
            $Count++;
            if ($Count !== $Amount) {
                $New_All_Titles .= $value . " ";
            } else {
                $Main_Title = $value;
            }
        }

        $All_Titles = $New_All_Titles;

        if ($_USER->Logged_In) {
            $Recommended_Limit = $_USER->Info['h_recommended_limit'];
            $Recommended_Style = $_USER->Info['h_recommended_style'];
        }

        $Recommended_Videos              = new Videos($DB, $_USER);
        $Recommended_Videos->SELECT     .= ", (MATCH(videos.title) AGAINST(:MAIN_WORD)) as main_word,
                                              (MATCH(videos.title, videos.description, videos.tags) AGAINST (:OTHERS)) as other_words";
        $Recommended_Videos->WHERE_C     = " AND ((MATCH(videos.title, videos.description, videos.tags) AGAINST(:TITLES)) OR (YEARWEEK(videos.uploaded_on) = YEARWEEK(NOW()) AND videos.views > 100)) AND videos.url NOT IN ($Watched_Videos)";
        $Recommended_Videos->Execute     = [
                                                ":TITLES"      => $All_Titles . $Main_Title,
                                                ":MAIN_WORD"   => $Main_Title,
                                                ":OTHERS"      => $All_Titles
                                           ];
        $Recommended_Videos->LIMIT       = (int)$Recommended_Limit;
        $Recommended_Videos->get();
        $Recommended_Amount = $Recommended_Videos::$Amount;

        if ($Recommended_Videos::$Videos) {
            $Recommended_Videos = $Recommended_Videos->fix_values(true,true);
        } else {
            $Recommended_Videos = false;
        }
    }
}

// SPOTLIGHT
$Spotlight = $DB->execute("SELECT * from spotlight WHERE date between date_sub(now(),INTERVAL 1 WEEK) and now() ORDER BY date DESC LIMIT 1");
if ($Spotlight) { $Spotlight = $Spotlight[0]; } 

if ($Spotlight) {
    $URLs = sql_IN_fix(explode(",",(string) $Spotlight["videos"]));
    $Spotlight_Videos            = new Videos($DB, $_USER);
    $Spotlight_Videos->WHERE_C   = " AND url IN ($URLs)";
    $Spotlight_Videos->ORDER_BY  = "videos.views DESC";
    $Spotlight_Videos->LIMIT     = 4;
    $Spotlight_Videos->get();

    if ($Spotlight_Videos::$Videos) {
        $Spotlight_Videos = $Spotlight_Videos->fix_values(true, true);
    }
}

//MOST POPULAR
if (!$_USER->Logged_In or ($_USER->Logged_In && $_USER->Info['h_mostpop'])) {
$MostPop[0] = get_popular($DB, "videos.views DESC", "48 HOUR", 4);
$MostPop[1] = get_popular($DB, "videos.views DESC", "48 HOUR", 9);
$MostPop[2] = get_popular($DB, "videos.views DESC", "72 HOUR", 21);
$MostPop[3] = get_popular($DB, "videos.views DESC", "1 WEEK", 16);
$MostPop[4] = get_popular($DB, "videos.views DESC", "24 HOUR");
$MostPop[5] = get_popular($DB, "videos.views DESC", "48 HOUR", 10);
$MostPop[6] = get_popular($DB, "videos.views DESC", "24 HOUR", 1);
$MostPop[7] = get_popular($DB, "videos.views DESC", "1 WEEK", 17);
$MostPop[8] = get_popular($DB, "videos.views DESC", "24 HOUR", 20);
$MostPop[9] = get_popular($DB, "videos.favorites DESC,videos.views DESC", "24 HOUR");
}

    //FRIENDS ACTIVITY
if ($_USER->Logged_In and $_USER->Info['h_activity']) {
    //$Friends = $_USER->get_friends(1000, true);
    $Friends = $DB->execute("SELECT * FROM users_friends INNER JOIN users ON users_friends.friend_1 = users.username OR users_friends.friend_2 = users.username WHERE (users_friends.friend_1 = :USERNAME OR users_friends.friend_2 = :USERNAME) AND users_friends.status = 1 ORDER BY users_friends.id DESC LIMIT 2000",false,[":USERNAME" => $_USER->Username]);
    if ($Friends) {
        $Friends_Array  = [];
        foreach($Friends as $Array) {
            if ($Array["username"] != $_USER->Username) {
                $Friends_Array[] = $Array["username"];
            }
        }
        $SQL_Friends  = sql_IN_fix($Friends_Array);
        $Activity_Limit = $_USER->Info['h_activity_limit'];

        if ($SQL_Friends) {
        //BULLETINS
        $SELECT = "SELECT 'bulletin' as type_name, by_user as id, content, submit_date as date, url as title, 'a' as video_by, 'a' as video_uploader, id as video_desc, 'a' as hd, 'a' as 1stars, 'a' as 2stars, 'a' as 3stars, 'a' as 4stars, 'a' as 5stars, 'a' as length, 'a' as upload_date, 'a' as views FROM bulletins_new WHERE by_user IN ($SQL_Friends)";
        //COMMENTS
        $SELECT .= " UNION ALL SELECT 'comment' as type_name, videos.url as id, videos_comments.content as content, videos_comments.submit_on as date, videos.title as title, videos_comments.by_user as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, videos.uploaded_on as upload_date, videos.views as views FROM videos_comments INNER JOIN videos ON videos_comments.url = videos.url WHERE by_user IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL AND videos.uploaded_by_banned = 0";
        //RATINGS
        $SELECT .= " UNION ALL SELECT 'rating' as type_name, videos.url as id, videos_ratings.rating as content, videos_ratings.submit_date as date, videos.title as title, videos_ratings.username as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, videos.uploaded_on as upload_date, videos.views as views FROM videos_ratings INNER JOIN videos ON videos_ratings.url = videos.url WHERE username IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL AND videos.uploaded_by_banned = 0 AND videos_ratings.rating >= 3";
        //FAVORITES
        $SELECT .= " UNION ALL SELECT 'favorite' as type_name, videos.url as id, 'a' as content, videos_favorites.submit_on as date, videos.title as title, videos_favorites.username as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, videos.uploaded_on as upload_date, videos.views as views FROM videos_favorites INNER JOIN videos ON videos_favorites.url = videos.url WHERE username IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL AND videos.uploaded_by_banned = 0";
        //UPLOADS
        $SELECT .= " UNION ALL SELECT 'uploaded' as type_name, url as id, description as comment, uploaded_on as date, title as title, uploaded_by as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, uploaded_on as upload_date, videos.views as views FROM videos WHERE uploaded_by IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL AND videos.uploaded_by_banned = 0";
        //SUBSCRIPTIONS
        $SELECT .= " UNION ALL SELECT 'subscription' as type_name, subscriber as id, subscription as content, submit_date as date, '' as title, 'a' as video_by, 'a' as video_uploader, 'a' as video_desc, 'a' as hd, 'a' as 1stars, 'a' as 2stars, 'a' as 3stars, 'a' as 4stars, 'a' as 5stars, 'a' as length, 'a' as upload_date, 'a' as views FROM subscriptions WHERE subscriber IN ($SQL_Friends)";
        //FRIENDS
        $SELECT .= "UNION ALL SELECT 'friend' as type_name, friend_1 as id, friend_2 as content, submit_on, '' as title, 'a' as video_by, 'a' as video_uploader, 'a' as video_desc, 'a' as hd, 'a' as 1stars, 'a' as 2stars, 'a' as 3stars, 'a' as 4stars, 'a' as 5stars, 'a' as length, 'a' as upload_date, 'a' as views FROM users_friends as date WHERE (friend_1 IN ($SQL_Friends) OR friend_2 IN ($SQL_Friends)) AND status = 1 ";
        $Friends_Activity = $DB->execute("$SELECT ORDER BY date DESC LIMIT ".(int)$Activity_Limit);
    }
}
}

    //THE FEED
if ($_USER->Logged_In and $_USER->Info['h_feed']) {
    $Feed = $DB->execute("SELECT * FROM users_friends INNER JOIN users ON users_friends.friend_1 = users.username OR users_friends.friend_2 = users.username WHERE (users_friends.friend_1 = :USERNAME OR users_friends.friend_2 = :USERNAME) AND users_friends.status = 1 ORDER BY users_friends.id DESC LIMIT 2000",false,[":USERNAME" => $_USER->Username]);
    $Feed_Array  = [];
    foreach($Feed as $Array) {
        if ($Array["username"] != $_USER->Username) {
            $Feed_Array[] = $Array["username"];
        }
    }
    $Subscriptions = $DB->execute("SELECT * FROM users INNER JOIN subscriptions ON subscriptions.subscriber = :USERNAME WHERE subscriptions.subscription = users.username AND is_banned = 0",false,[":USERNAME" => $_USER->Username]);
    $Subscriptions_Array = [];

    if ($Subscriptions) {
        foreach($Subscriptions as $Subscription) {
            $Subscriptions_Array[] = $Subscription["username"];
        }
        $SQL_Subs  = sql_IN_fix($Subscriptions_Array);
    }

    array_push($Feed_Array, $_USER->Username);

    $SQL_Friends  = sql_IN_fix($Feed_Array);

    if ($SQL_Friends) {
    //BULLETINS
    $SELECT = "SELECT 'bulletin' as type_name, by_user as id, content, submit_date as date, url as title, 'a' as video_by, 'a' as video_uploader, id as video_desc, 'a' as hd, 'a' as 1stars, 'a' as 2stars, 'a' as 3stars, 'a' as 4stars, 'a' as 5stars, 'a' as length, 'a' as upload_date, 'a' as views FROM bulletins_new WHERE by_user IN ($SQL_Friends)";
    //COMMENTS
    $SELECT .= " UNION ALL SELECT 'comment' as type_name, videos.url as id, videos_comments.content as content, videos_comments.submit_on as date, videos.title as title, videos_comments.by_user as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, videos.uploaded_on as upload_date, videos.views as views FROM videos_comments INNER JOIN videos ON videos_comments.url = videos.url WHERE by_user IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL AND videos.uploaded_by_banned = 0";
    //RATINGS
    $SELECT .= " UNION ALL SELECT 'rating' as type_name, videos.url as id, videos_ratings.rating as content, videos_ratings.submit_date as date, videos.title as title, videos_ratings.username as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, videos.uploaded_on as upload_date, videos.views as views FROM videos_ratings INNER JOIN videos ON videos_ratings.url = videos.url WHERE username IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL AND videos.uploaded_by_banned = 0";
    //FAVORITES
    $SELECT .= " UNION ALL SELECT 'favorite' as type_name, videos.url as id, 'a' as content, videos_favorites.submit_on as date, videos.title as title, videos_favorites.username as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, videos.uploaded_on as upload_date, videos.views as views FROM videos_favorites INNER JOIN videos ON videos_favorites.url = videos.url WHERE username IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL AND videos.uploaded_by_banned = 0";
    //UPLOADS
    $SELECT .= " UNION ALL SELECT 'uploaded' as type_name, url as id, description as comment, uploaded_on as date, title as title, uploaded_by as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, uploaded_on as upload_date, videos.views as views FROM videos WHERE uploaded_by IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL AND videos.uploaded_by_banned = 0";
    //SUBSCRIPTIONS
    $SELECT .= " UNION ALL SELECT 'subscription' as type_name, subscriber as id, subscription as content, submit_date as date, '' as title, 'a' as video_by, 'a' as video_uploader, 'a' as video_desc, 'a' as hd, 'a' as 1stars, 'a' as 2stars, 'a' as 3stars, 'a' as 4stars, 'a' as 5stars, 'a' as length, 'a' as upload_date, 'a' as views FROM subscriptions WHERE subscriber IN ($SQL_Friends)";
    //SUBSCRIPTION VIDEOS
    if ($Subscriptions) {
    $SELECT .= " UNION ALL SELECT 'sub_videos' as type_name, url as id, description as comment, uploaded_on as date, title as title, uploaded_by as video_by, videos.uploaded_by as video_uploader, videos.description as video_desc, videos.hd as hd, videos.1stars as 1stars, videos.2stars as 2stars, videos.3stars as 3stars, videos.4stars as 4stars, videos.5stars as 5stars, videos.length as length, uploaded_on as upload_date, videos.views as views FROM videos WHERE uploaded_by IN ($SQL_Subs) AND videos.uploaded_by NOT IN ($SQL_Friends) AND videos.status = 2 AND videos.privacy = 1 AND videos.is_deleted IS NULL AND videos.uploaded_by_banned = 0";
    }
    //FRIENDS
    $SELECT .= " UNION ALL SELECT 'friend' as type_name, friend_1 as id, friend_2 as content, submit_on, '' as title, 'a' as video_by, 'a' as video_uploader, 'a' as video_desc, 'a' as hd, 'a' as 1stars, 'a' as 2stars, 'a' as 3stars, 'a' as 4stars, 'a' as 5stars, 'a' as length, 'a' as upload_date, 'a' as views FROM users_friends as date WHERE (friend_1 IN ($SQL_Friends) OR friend_2 IN ($SQL_Friends)) AND status = 1";
    $Feed_Activity = $DB->execute("$SELECT ORDER BY date DESC LIMIT 0,30");
}
if (count($_USER->Watched_Videos) >= 1) {
        $Watched_Videos = array_slice($_USER->Watched_Videos, -6);
        $Watched_Videos = sql_IN_fix($Watched_Videos);
        $Watched_Videos_Titles = $DB->execute("SELECT title FROM videos WHERE url IN ($Watched_Videos) ORDER BY FIELD(url,$Watched_Videos)");
        shuffle($Watched_Videos_Titles);
        $All_Titles = "";

        foreach ($Watched_Videos_Titles as $Watched_Title) {
            $All_Titles .= $Watched_Title["title"]." ";
        }

        $All_Titles = array_filter(explode(" ", $All_Titles));
        $New_All_Titles = [];

        foreach ($All_Titles as $Title) {
            if (!in_array($Title, $Watched_Videos_Titles) && ctype_alnum($Title) && !is_numeric($Title) && mb_strlen($Title) >= 3) {
                $New_All_Titles[] = mb_strtolower($Title);
            }
        }

        $All_Titles = array_count_values($New_All_Titles);
        asort($All_Titles);
        $All_Titles = array_slice($All_Titles, -6);

        $New_All_Titles = "";
        $Count = 0;
        $Amount = count($All_Titles);

        foreach ($All_Titles as $value => $key) {
            $Count++;
            if ($Count !== $Amount) {
                $New_All_Titles .= $value . " ";
            } else {
                $Main_Title = $value;
            }
        }

        $All_Titles = $New_All_Titles;

        $Recommended_Videos              = new Videos($DB, $_USER);
        $Recommended_Videos->SELECT     .= ", (MATCH(videos.title) AGAINST(:MAIN_WORD)) as main_word,
                                              (MATCH(videos.title, videos.description, videos.tags) AGAINST (:OTHERS)) as other_words";
        $Recommended_Videos->WHERE_C     = " AND ((MATCH(videos.title, videos.description, videos.tags) AGAINST(:TITLES)) OR (YEARWEEK(videos.uploaded_on) = YEARWEEK(NOW()) AND videos.views > 100)) AND videos.url NOT IN ($Watched_Videos)";
        $Recommended_Videos->Execute     = [
                                                ":TITLES"      => $All_Titles . $Main_Title,
                                                ":MAIN_WORD"   => $Main_Title,
                                                ":OTHERS"      => $All_Titles
                                           ];
        $Recommended_Videos->LIMIT       = 4;
        $Recommended_Videos->get();
        $Recommended_Amount = $Recommended_Videos::$Amount;

        if ($Recommended_Videos::$Videos) {
            $Recommended_Videos = $Recommended_Videos->fix_values(true,true);
        } else {
            $Recommended_Videos = false;
        }
    }
}

if (isset($_GET["hl"])) {
    // Replace all characters that aren't letters or dashes
    $new_lang = $_GET["hl"];
    $new_lang = preg_replace('/[^a-z\-]/i', '', (string) $new_lang);

    // Set lang cookie
    setcookie("lang", (string) $new_lang, ['expires' => time() + (86400 * 30), 'path' => "/"]);
    header("location: /");
    exit();
}

// EASTER EGG
if (!isset($_GET["golec"])) {
    $Page = "home";
} elseif (isset($_GET["golec"])) {
    $Page = "home_golec";
}

if ($_USER->Logged_In) {
    $ChannelTitle = displayname($_USER->Username);
    $HomeTitle = $LANGS['hometitle'];
    $Page_Title = str_replace("{n}", $ChannelTitle, $HomeTitle);
} else {
    $Page_Title = "Express Yourself.";
}

$_PAGE = [
    "Page"      => $Page,
    "Page_Type" => "home",
    "Title"      => "$Page_Title",
    "Show_Search" => true,
    "new"         => true
];
require "_templates/_structures/main.php";

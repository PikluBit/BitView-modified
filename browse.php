<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (isset($_GET["t"]) && $_GET["t"] >= 1 && $_GET["t"] <= 8) {
    $Type = (int)$_GET["t"];
} elseif (!isset($_GET["t"])) {
    $Type = 1;
} else {
    header("Location: /browse");
}

if (isset($_GET["d"]) && $_GET["d"] >= 1 && $_GET["d"] <= 8) {
    $Date = (int)$_GET["d"];
} elseif (!isset($_GET["d"])) {
    $Date = 1;
} else {
    header("Location: /browse");
}

$_USER->get_info();

$_PAGINATION = new Pagination(25, 1000);
$Types = [
    1 => "Most Viewed",
    2 => "Featured Videos",
    3 => "Most Discussed",
    4 => "Top Favorited",
    5 => "Top Rated",
    6 => "Recent Videos",
    7 => "Random",
    8 => "HD",
];

$Video_Category = [1 => $LANGS['cat1'], 2 => $LANGS['cat2'], 3 => $LANGS['cat3'], 4 => $LANGS['cat4'], 5 => $LANGS['cat5'], 6 => $LANGS['cat6'], 7 => $LANGS['cat7'], 8 => $LANGS['cat8'], 9 => $LANGS['cat9'], 10 => $LANGS['cat10'], 11 => $LANGS['cat11'], 12 => $LANGS['cat12'], 13 => $LANGS['cat13'], 14 => $LANGS['cat14'], 15 => $LANGS['cat15'], 16 => $LANGS['cat16'], 17 => $LANGS['cat17'], 18 => $LANGS['cat18'], 19 => $LANGS['cat19'], 20 => $LANGS['cat20'], 21 => $LANGS['cat21']];

if (isset($_GET['category']) && $_GET['category'] || isset($_GET['t']) && $_GET['t'] != 1) {
if ($Date == 1) {
    $WHEN = " AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 24 HOUR) ";
} elseif ($Date == 2) {
    $WHEN = " AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 1 WEEK) ";
} elseif ($Date == 3) {
    $WHEN = " AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 1 MONTH) ";
} else {
    $WHEN = "";
}

if (!isset($_GET["category"])) {
    $_GET["category"] = 0;

    //MOST VIEWED VIDEOS
    if ($Type == 1) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.views DESC";
        $Videos->WHERE_C  = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);
        $Amount = 25000;

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }

    //FEATURED VIDEOS
    if ($Type == 2) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.uploaded_on DESC";
        $Videos->WHERE_C = "AND featured = 1";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "AND featured = 1";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }

    //MOST DISCUSSED VIDEOS
    if ($Type == 3) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.comments DESC";
        $Videos->WHERE_C  = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }

    //TOP FAVORITED VIDEOS
    if ($Type == 4) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.favorites DESC, videos.views DESC";
        $Videos->WHERE_C  = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }

    //TOP RATED
    if ($Type == 5) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.5stars DESC";
        $Videos->WHERE_C  = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }
    //RECENT VIDEOS
    if ($Type == 6) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.uploaded_on DESC";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = new Videos($DB, $_USER);
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }
    //RANDOM
    if ($Type == 7) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "rand()";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = new Videos($DB, $_USER);
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = 25000;
    }
    //HD
    if ($Type == 8) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.uploaded_on DESC";
        $Videos->WHERE_C  = "AND videos.hd = true AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);
        $Amount = 25000;

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "AND videos.hd = true AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }
} else {
    if (!isset($_CONFIG::$Categories[$_GET["category"]])) {
        header("location: /browse");
        exit();
    }

    //MOST VIEWED VIDEOS
    if ($Type == 1) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.views DESC";
        $Videos->WHERE_P  = ["videos.category" => $_GET["category"]];
        $Videos->WHERE_C  = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);
        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }

    //FEATURED VIDEOS
    if ($Type == 2) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.uploaded_on DESC";
        $Videos->WHERE_P  = ["videos.category" => $_GET["category"]];
        $Videos->WHERE_C = "AND featured = 1";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "AND featured = 1";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }

    //MOST DISCUSSED VIDEOS
    if ($Type == 3) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.comments DESC";
        $Videos->WHERE_P  = ["videos.category" => $_GET["category"]];
        $Videos->WHERE_C  = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }

    //TOP FAVORITED VIDEOS
    if ($Type == 4) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.favorites DESC, videos.views DESC";
        $Videos->WHERE_P  = ["videos.category" => $_GET["category"]];
        $Videos->WHERE_C  = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }

    //TOP RATED
    if ($Type == 5) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.5stars DESC";
        $Videos->WHERE_P  = ["videos.category" => $_GET["category"]];
        $Videos->WHERE_C  = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);
        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }
    //RECENT VIDEOS
    if ($Type == 6) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.uploaded_on DESC";
        $Videos->WHERE_P  = ["videos.category" => $_GET["category"]];
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = new Videos($DB, $_USER);
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }
    //RANDOM
    if ($Type == 7) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "rand()";
        $Videos->WHERE_P  = ["videos.category" => $_GET["category"]];
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "$WHEN";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = 25000;
    }
    //HD
    if ($Type == 8) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.uploaded_on DESC";
        $Videos->WHERE_P  = ["videos.category" => $_GET["category"]];
        $Videos->WHERE_C  = "AND videos.hd = true AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();

        $Videos = $Videos->fix_values(true, true);
        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "AND videos.hd = true AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }
}

if (isset($_GET['r']) && $_GET['r'] == 1) {
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
                if (ctype_alnum($Title) && !is_numeric($Title) && mb_strlen($Title) >= 3) {
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

            $Videos              = new Videos($DB, $_USER);
            $Videos->SELECT     .= ", (MATCH(videos.title) AGAINST(:MAIN_WORD)) as main_word,
                                                  (MATCH(videos.title, videos.description, videos.tags) AGAINST (:OTHERS)) as other_words";
            $Videos->WHERE_C     = " AND ((MATCH(videos.title, videos.description, videos.tags) AGAINST(:TITLES)) OR (YEARWEEK(videos.uploaded_on) = YEARWEEK(NOW()) AND videos.views > 100)) AND videos.url NOT IN ($Watched_Videos)";
            $Videos->Execute     = [
                                                    ":TITLES"      => $All_Titles . $Main_Title,
                                                    ":MAIN_WORD"   => $Main_Title,
                                                    ":OTHERS"      => $All_Titles
                                               ];
            $Videos->LIMIT       = $_PAGINATION;
            $Videos->get();
            $Videos = $Videos->fix_values(true, true);

            $Amount = new Videos($DB, $_USER);
            $Amount->SELECT   .= ", (MATCH(videos.title) AGAINST(:MAIN_WORD)) as main_word,
                                                  (MATCH(videos.title, videos.description, videos.tags) AGAINST (:OTHERS)) as other_words";
            $Amount->WHERE_C   = " AND ((MATCH(videos.title, videos.description, videos.tags) AGAINST(:TITLES)) OR (YEARWEEK(videos.uploaded_on) = YEARWEEK(NOW()) AND videos.views > 100)) AND videos.url NOT IN ($Watched_Videos)";
            $Amount->Execute    = [
                                                    ":TITLES"      => $All_Titles . $Main_Title,
                                                    ":MAIN_WORD"   => $Main_Title,
                                                    ":OTHERS"      => $All_Titles
                                               ];
            $Amount->LIMIT = 25000;
            $Amount->get();

            $Amount = $Amount::$Amount;
        }
    }

$_PAGINATION->total($Amount);

$Popular_Video_Tags = $DB->execute("SELECT tags FROM videos WHERE tags <> '' AND privacy = 1 AND status = 2 AND is_deleted IS NULL AND uploaded_by_banned = 0 AND reupload = 0 ORDER BY uploaded_on DESC LIMIT 10");

$Popular_All_Tags = "";
foreach ($Popular_Video_Tags as $Tags) {
    $Popular_All_Tags .= $Tags["tags"].",";
}
$Popular_All_Tags = array_count_values(array_filter(explode(",", mb_substr($Popular_All_Tags, 0, mb_strlen($Popular_All_Tags) - 1))));
unset($Popular_All_Tags["bitview"]);
if ($Popular_All_Tags) {
    array_rand($Popular_All_Tags);
    $Popular_All_Tags = array_reverse(array_splice($Popular_All_Tags, -64));
}

    $_PAGE = [
        "Page"       => "browse",
        "Page_Type"  => "browse",
        "Show_Search" => true,
        "new"         => true
    ];
} else {
    $MVT_Videos = new Videos($DB, $_USER);
    $MVT_Videos->ORDER_BY = "videos.views DESC";
    $MVT_Videos->WHERE_D  = "AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
    $MVT_Videos->WHERE_C  = "AND videos.reupload = 0 AND users.is_reuploader = 0";
    $MVT_Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
    $MVT_Videos->LIMIT = 8;
    $MVT_Videos->Limit_Required = true;
    $MVT_Videos->get();

    $MVT_Videos = $MVT_Videos->fix_values(true, true);

    $Ent_Videos = new Videos($DB, $_USER);
    $Ent_Videos->ORDER_BY = "videos.views DESC";
    $Ent_Videos->WHERE_D  = "AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
    $Ent_Videos->WHERE_C  = "AND videos.reupload = 0 AND users.is_reuploader = 0";
    $Ent_Videos->WHERE_P  = ["videos.category" => 4];
    $Ent_Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
    $Ent_Videos->LIMIT = 4;
    $Ent_Videos->Limit_Required = true;
    $Ent_Videos->get();

    $Ent_Videos = $Ent_Videos->fix_values(true, true);

    $Spo_Videos = new Videos($DB, $_USER);
    $Spo_Videos->ORDER_BY = "videos.views DESC";
    $Spo_Videos->WHERE_D  = "AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
    $Spo_Videos->WHERE_C  = "AND videos.reupload = 0 AND users.is_reuploader = 0";
    $Spo_Videos->WHERE_P  = ["videos.category" => 18];
    $Spo_Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
    $Spo_Videos->LIMIT = 4;
    $Spo_Videos->Limit_Required = true;
    $Spo_Videos->get();

    $Spo_Videos = $Spo_Videos->fix_values(true, true);

    $Gam_Videos = new Videos($DB, $_USER);
    $Gam_Videos->ORDER_BY = "videos.views DESC";
    $Gam_Videos->WHERE_D  = "AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
    $Gam_Videos->WHERE_C  = "AND videos.reupload = 0 AND users.is_reuploader = 0";
    $Gam_Videos->WHERE_P  = ["videos.category" => 20];
    $Gam_Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
    $Gam_Videos->LIMIT = 4;
    $Gam_Videos->Limit_Required = true;
    $Gam_Videos->get();

    $Gam_Videos = $Gam_Videos->fix_values(true, true);

    $Sci_Videos = new Videos($DB, $_USER);
    $Sci_Videos->ORDER_BY = "videos.views DESC";
    $Sci_Videos->WHERE_D  = "AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
    $Sci_Videos->WHERE_C  = "AND videos.reupload = 0 AND users.is_reuploader = 0";
    $Sci_Videos->WHERE_P  = ["videos.category" => 16];
    $Sci_Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
    $Sci_Videos->LIMIT = 4;
    $Sci_Videos->Limit_Required = true;
    $Sci_Videos->get();

    $Sci_Videos = $Sci_Videos->fix_values(true, true);

    $Com_Videos = new Videos($DB, $_USER);
    $Com_Videos->ORDER_BY = "videos.views DESC";
    $Com_Videos->WHERE_D  = "AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
    $Com_Videos->WHERE_C  = "AND videos.reupload = 0 AND users.is_reuploader = 0";
    $Com_Videos->WHERE_P  = ["videos.category" => 9];
    $Com_Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
    $Com_Videos->LIMIT = 4;
    $Com_Videos->Limit_Required = true;
    $Com_Videos->get();

    $Com_Videos = $Com_Videos->fix_values(true, true);

    $Tra_Videos = new Videos($DB, $_USER);
    $Tra_Videos->ORDER_BY = "videos.views DESC";
    $Tra_Videos->WHERE_D  = "AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
    $Tra_Videos->WHERE_C  = "AND videos.reupload = 0 AND users.is_reuploader = 0";
    $Tra_Videos->WHERE_P  = ["videos.category" => 19];
    $Tra_Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
    $Tra_Videos->LIMIT = 4;
    $Tra_Videos->Limit_Required = true;
    $Tra_Videos->get();

    $Tra_Videos = $Tra_Videos->fix_values(true, true);

    $News_Videos = new Videos($DB, $_USER);
    $News_Videos->ORDER_BY = "videos.views DESC";
    $News_Videos->WHERE_D  = "AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
    $News_Videos->WHERE_C  = "AND videos.reupload = 0 AND users.is_reuploader = 0";
    $News_Videos->WHERE_P  = ["videos.category" => 11];
    $News_Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
    $News_Videos->LIMIT = 4;
    $News_Videos->Limit_Required = true;
    $News_Videos->get();

    $News_Videos = $News_Videos->fix_values(true, true);

    $Peo_Videos = new Videos($DB, $_USER);
    $Peo_Videos->ORDER_BY = "videos.views DESC";
    $Peo_Videos->WHERE_D  = "AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
    $Peo_Videos->WHERE_C  = "AND videos.reupload = 0 AND users.is_reuploader = 0";
    $Peo_Videos->WHERE_P  = ["videos.category" => 13];
    $Peo_Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
    $Peo_Videos->LIMIT = 4;
    $Peo_Videos->Limit_Required = true;
    $Peo_Videos->get();

    $Peo_Videos = $Peo_Videos->fix_values(true, true);

    $Edu_Videos = new Videos($DB, $_USER);
    $Edu_Videos->ORDER_BY = "videos.views DESC";
    $Edu_Videos->WHERE_D  = "AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
    $Edu_Videos->WHERE_C  = "AND videos.reupload = 0 AND users.is_reuploader = 0";
    $Edu_Videos->WHERE_P  = ["videos.category" => 3];
    $Edu_Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
    $Edu_Videos->LIMIT = 4;
    $Edu_Videos->Limit_Required = true;
    $Edu_Videos->get();

    $Edu_Videos = $Edu_Videos->fix_values(true, true);

    $Mus_Videos = new Videos($DB, $_USER);
    $Mus_Videos->ORDER_BY = "videos.views DESC";
    $Mus_Videos->WHERE_D  = "AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
    $Mus_Videos->WHERE_C  = "AND videos.reupload = 0 AND users.is_reuploader = 0";
    $Mus_Videos->WHERE_P  = ["videos.category" => 10];
    $Mus_Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
    $Mus_Videos->LIMIT = 8;
    $Mus_Videos->Limit_Required = true;
    $Mus_Videos->get();

    $Mus_Videos = $Mus_Videos->fix_values(true, true);

    $SMovies_Videos = new Videos($DB, $_USER);
    $SMovies_Videos->ORDER_BY = "videos.views DESC";
    $SMovies_Videos->WHERE_D  = "AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
    $SMovies_Videos->WHERE_C  = "AND videos.reupload = 0 AND users.is_reuploader = 0";
    $SMovies_Videos->WHERE_P  = ["videos.category" => 17];
    $SMovies_Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
    $SMovies_Videos->LIMIT = 8;
    $SMovies_Videos->Limit_Required = true;
    $SMovies_Videos->get();

    $SMovies_Videos = $SMovies_Videos->fix_values(true, true);

    $_PAGE = [
        "Page"       => "browse_new",
        "Page_Type"  => "browse",
        "Show_Search" => true,
        "new"         => true
    ];
}
require "_templates/_structures/main.php";

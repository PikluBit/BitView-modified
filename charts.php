<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (isset($_GET["t"]) && $_GET["t"] >= 1 && $_GET["t"] <= 8) {
    $Type = (int)$_GET["t"];
} elseif (!isset($_GET["t"])) {
    $Type = 1;
}

if (isset($_GET["d"]) && $_GET["d"] >= 1 && $_GET["d"] <= 4) {
    $Date = (int)$_GET["d"];
} elseif (!isset($_GET["d"])) {
    $Date = 1;
}

if (isset($_GET["c"]) && $_GET["c"] >= 1 && $_GET["c"] <= 21) {
    $Cat = (int)$_GET["c"];
} elseif (!isset($_GET["c"]) || isset($_GET["c"]) && $_GET["c"] == 0) {
    $Cat = 0;
}

$_USER->get_info();

$_PAGINATION = new Pagination(20, 1000);

$Types = [
    1 => $LANGS['mostviewedvideos'],
    2 => $LANGS['mostdiscussedvideos'],
    3 => $LANGS['mostliked'],
    4 => $LANGS['topfavorited'],
    5 => $LANGS['mostviewedhd'],
    6 => $LANGS['mostsubscribed'],
    7 => $LANGS['mostviewedusers'],
    8 => $LANGS['mostviewedpartners'],
];

$Dates = [
    1 => $LANGS['timetoday'],
    2 => $LANGS['timeweek'],
    3 => $LANGS['timemonth'],
    4 => $LANGS['alltime']
];

$Video_Category = [1 => $LANGS['cat1'], 2 => $LANGS['cat2'], 3 => $LANGS['cat3'], 4 => $LANGS['cat4'], 5 => $LANGS['cat5'], 6 => $LANGS['cat6'], 7 => $LANGS['cat7'], 8 => $LANGS['cat8'], 9 => $LANGS['cat9'], 10 => $LANGS['cat10'], 11 => $LANGS['cat11'], 12 => $LANGS['cat12'], 13 => $LANGS['cat13'], 14 => $LANGS['cat14'], 15 => $LANGS['cat15'], 16 => $LANGS['cat16'], 17 => $LANGS['cat17'], 18 => $LANGS['cat18'], 19 => $LANGS['cat19'], 20 => $LANGS['cat20'], 21 => $LANGS['cat21']];

if ($Date == 1) {
    $WHEN = " AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 24 HOUR) ";
} elseif ($Date == 2) {
    $WHEN = " AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 1 WEEK) ";
} elseif ($Date == 3) {
    $WHEN = " AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 1 MONTH) ";
} else {
    $WHEN = "";
}

if (!isset($_GET["c"]) || isset($_GET["c"]) && $_GET["c"] == 0 || $Type >= 6) {
    $_GET["c"] = 0;

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
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }
    if ($Type == 2) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.comments DESC";
        $Videos->WHERE_C  = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);
        $Amount = 25000;

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }
    if ($Type == 3) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.5stars DESC";
        $Videos->WHERE_C  = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);
        $Amount = 25000;

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }
    if ($Type == 4) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.favorites DESC";
        $Videos->WHERE_C  = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);
        $Amount = 25000;

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }
    if ($Type == 5) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.views DESC";
        $Videos->WHERE_C  = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0 AND videos.hd = 1";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);
        $Amount = 25000;

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0 AND videos.hd = 1";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }
    if ($Type == 6) {
        $DATE = "_day";
        if($_GET["d"] == "2") {
            $DATE = "_week";
        } elseif($_GET["d"] == "3") {
            $DATE = "_month";
        } elseif($_GET["d"] == "4") {
            $DATE = "";
        }
        $Users = $DB->execute("SELECT * FROM users WHERE subscribers".$DATE." > 0 AND is_banned = 0 ORDER BY subscribers".$DATE." DESC LIMIT $_PAGINATION->From, $_PAGINATION->To");
        $Amount = $DB->execute("SELECT count(*) FROM users WHERE subscribers".$DATE." > 0")[0]["count(*)"];
    }
    if ($Type == 7) {
        $DATE = "_day";
        if($_GET["d"] == "2") {
            $DATE = "_week";
        } elseif($_GET["d"] == "3") {
            $DATE = "_month";
        } elseif($_GET["d"] == "4") {
            $DATE = "";
        }
        $Users = $DB->execute("SELECT * FROM users WHERE video_views".$DATE." > 0 AND is_banned = 0 ORDER BY video_views".$DATE." DESC LIMIT $_PAGINATION->From, $_PAGINATION->To");
        $Amount = $DB->execute("SELECT count(*) FROM users WHERE video_views".$DATE." > 0")[0]["count(*)"];
    }
    if ($Type == 8) {
        $DATE = "_day";
        if($_GET["d"] == "2") {
            $DATE = "_week";
        } elseif($_GET["d"] == "3") {
            $DATE = "_month";
        } elseif($_GET["d"] == "4") {
            $DATE = "";
        }
        $Users = $DB->execute("SELECT * FROM users WHERE video_views".$DATE." > 0 AND is_banned = 0 AND users.is_partner = 1 ORDER BY video_views".$DATE." DESC LIMIT $_PAGINATION->From, $_PAGINATION->To");
        $Amount = $DB->execute("SELECT count(*) FROM users WHERE video_views".$DATE." > 0 AND users.is_partner = 1")[0]["count(*)"];
    }
} else {
    if (!isset($_CONFIG::$Categories[$_GET["c"]])) {
        header("location: /charts");
        exit();
    }

    if ($Type == 1) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.views DESC";
        $Videos->WHERE_C  = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Videos->WHERE_P  = ["videos.category" => $_GET["c"]];
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);
        $Amount = 25000;

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_P  = ["videos.category" => $_GET["c"]];
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }
    if ($Type == 2) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.comments DESC";
        $Videos->WHERE_P  = ["videos.category" => $_GET["c"]];
        $Videos->WHERE_C  = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);
        $Amount = 25000;

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_P  = ["videos.category" => $_GET["c"]];
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }
    if ($Type == 3) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.5stars DESC";
        $Videos->WHERE_P  = ["videos.category" => $_GET["c"]];
        $Videos->WHERE_C  = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);
        $Amount = 25000;

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_P  = ["videos.category" => $_GET["c"]];
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }
    if ($Type == 4) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.favorites DESC";
        $Videos->WHERE_P  = ["videos.category" => $_GET["c"]];
        $Videos->WHERE_C  = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);
        $Amount = 25000;

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_P  = ["videos.category" => $_GET["c"]];
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }
    if ($Type == 5) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.views DESC";
        $Videos->WHERE_P  = ["videos.category" => $_GET["c"]];
        $Videos->WHERE_C  = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0 AND videos.hd = 1";
        $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);
        $Amount = 25000;

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_P  = ["videos.category" => $_GET["c"]];
        $Amount->WHERE_C = "$WHEN AND videos.reupload = 0 AND users.is_reuploader = 0 AND videos.hd = 1";
        $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
        $Amount->LIMIT = 25000;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }
}

$_PAGINATION->total($Amount);

$_PAGE = [
    "Page"       => "charts",
    "Page_Type"  => "browse",
    "Show_Search" => true,
    "new"         => true
];

require "_templates/_structures/main.php";

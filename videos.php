<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

require $_SERVER['DOCUMENT_ROOT']."/404.php";
exit();

if (isset($_GET["t"]) && $_GET["t"] >= 1 && $_GET["t"] <= 7) {
    $Type = (int)$_GET["t"];
} elseif (!isset($_GET["t"])) {
    $Type = 1;
} else {
    header("Location: /videos.php");
}

$_PAGINATION = new Pagination(20, 15);
$Types = [
    1 => "Most Recent",
    2 => "Most Popular",
    3 => "Most Discussed",
    4 => "Most Added to Favorites",
    5 => "Random",
    6 => "Recently Featured",
    7 => "Top Rated"
];

if (!isset($_GET["category"])) {

//LATEST VIDEOS
    if ($Type == 1) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.uploaded_on DESC";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = 300;
    }

//MOST POPULAR VIDEOS
    if ($Type == 2) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.views DESC";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = 300;
    }

//MOST DISCUSSED VIDEOS
    if ($Type == 3) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.comments DESC";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = 300;
    }

//MOST FAVORITED VIDEOS
    if ($Type == 4) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.favorites DESC, videos.views DESC";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = 300;
    }

//RANDOM VIDEOS
    if ($Type == 5) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "rand()";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = 300;
    }

    if ($Type == 6) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.uploaded_on DESC";
        $Videos->WHERE_C = "AND featured = 1";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "AND featured = 1";
        $Amount->LIMIT = 300;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }

    if ($Type == 7) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.5stars DESC";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = 300;
    }
} else {
    if (!isset($_CONFIG::$Categories[$_GET["category"]])) { header("location: /videos.php"); exit(); }

    //LATEST VIDEOS
    if ($Type == 1) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.uploaded_on DESC";
        $Videos->WHERE_P  = ["videos.category" => $_GET["category"]];
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = 300;
    }

//MOST POPULAR VIDEOS
    if ($Type == 2) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.views DESC";
        $Videos->WHERE_P  = ["videos.category" => $_GET["category"]];
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = 300;
    }

//MOST DISCUSSED VIDEOS
    if ($Type == 3) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.comments DESC";
        $Videos->WHERE_P  = ["videos.category" => $_GET["category"]];
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = 300;
    }

//MOST FAVORITED VIDEOS
    if ($Type == 4) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.favorites DESC, videos.views DESC";
        $Videos->WHERE_P  = ["videos.category" => $_GET["category"]];
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = 300;
    }

//RANDOM VIDEOS
    if ($Type == 5) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "rand()";
        $Videos->WHERE_P  = ["videos.category" => $_GET["category"]];
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = 300;
    }

    if ($Type == 6) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.uploaded_on DESC";
        $Videos->WHERE_P  = ["videos.category" => $_GET["category"]];
        $Videos->WHERE_C = "AND featured = 1";
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = new Videos($DB, $_USER);
        $Amount->WHERE_C = "AND featured = 1";
        $Amount->LIMIT = 300;
        $Amount->get();

        $Amount = $Amount::$Amount;
    }

    if ($Type == 7) {
        $Videos = new Videos($DB, $_USER);
        $Videos->ORDER_BY = "videos.5stars DESC";
        $Videos->WHERE_P  = ["videos.category" => $_GET["category"]];
        $Videos->LIMIT = $_PAGINATION;
        $Videos->get();
        $Videos = $Videos->fix_values(true, true);

        $Amount = 300;
    }

/*
    $Videos = new Videos($DB, $_USER);
    $Videos->ORDER_BY = "videos.uploaded_on DESC";
    $Videos->WHERE_P  = ["videos.category" => $_GET["category"]];
    $Videos->LIMIT = $_PAGINATION;
    $Videos->get();
    $Videos = $Videos->fix_values(true, true);

    $Amount = $DB->execute("SELECT count(url) as amount FROM videos WHERE category = :CATEGORY",true,array(":CATEGORY" => $_GET["category"]))["amount"];
    if ($Amount == 0 || !$Videos) { header("location: /videos.php"); exit(); }
    if ($Amount > 300) { $Amount = 300; }*/
}
$_PAGINATION->total($Amount);


$_PAGE = [
    "Page"       => "videos",
    "Page_Type"  => "browse",
    "Show_Search" => true,
    "new"         => true
];
require "_templates/_structures/main.php";
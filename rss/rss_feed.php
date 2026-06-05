<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
ini_set("short_open_tag", 0);

if (isset($_GET["order"]) && $_GET["order"] >= 1 && $_GET["order"] <= 8) {
    $Type = (int)$_GET["order"];
} elseif (!isset($_GET["order"])) {
    $Type = 1;
} else {
    header("Location: /browse");
}

if (isset($_GET["date"]) && $_GET["date"] >= 1 && $_GET["date"] <= 8) {
    $Date = (int)$_GET["date"];
} elseif (!isset($_GET["date"])) {
    $Date = 1;
} else {
    header("Location: /browse");
}

if ($Date == 1) {
    $WHEN = " AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 24 HOUR) ";
} elseif ($Date == 2) {
    $WHEN = " AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 1 WEEK) ";
} elseif ($Date == 3) {
    $WHEN = " AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 1 MONTH) ";
} else {
    $WHEN = "";
}

//LATEST VIDEOS
$Videos              = new Videos($DB, $_USER);
if ($Type == 1) {
$Videos->ORDER_BY    = "videos.views DESC";
$Videos->WHERE_C  = "$WHEN";
}
if ($Type == 2) {
$Videos->ORDER_BY = "videos.uploaded_on DESC";
$Videos->WHERE_C  = "AND featured = 1";
}
if ($Type == 3) {
$Videos->ORDER_BY    = "videos.comments DESC";
$Videos->WHERE_C  = "$WHEN";
}
if ($Type == 4) {
$Videos->ORDER_BY    = "videos.favorites DESC";
$Videos->WHERE_C  = "$WHEN";
}
if ($Type == 5) {
$Videos->ORDER_BY    = "videos.5stars DESC";
$Videos->WHERE_C  = "$WHEN";
}
if ($Type == 6) {
$Videos->ORDER_BY    = "videos.uploaded_on DESC";
}
if ($Type == 7) {
$Videos->ORDER_BY    = "rand()";
}
if ($Type == 8) {
$Videos->ORDER_BY    = "videos.uploaded_on DESC";
$Videos->WHERE_C  = "AND videos.hd = true";
}
$Videos->LIMIT       = 16;
$Videos->get();
$Videos              = $Videos->fix_values(false, false);

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

$Dates = [
    1 => "Today",
    2 => "This Week",
    3 => "This Month",
    4 => "All Time",
];

foreach ($Types as $ID => $Type_Title) {
    if ($_GET["order"] == $ID) {
        $Title = "BitView - $Type_Title";
    }
}

foreach ($Dates as $ID => $Date_Title) {
    if ($_GET["date"] == $ID) {
        $Title .= " ($Date_Title)";
    }
}

header("Content-Type: application/rss+xml; charset=utf-8");
?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss version="2.0">
    <channel>
        <title><?= $Title ?></title>
        <link>http://www.bitview.net</link>
        <description>Recently Added Videos</description>
        <language>en-us</language>
        <copyright>Copyright (C) 2023 BitView</copyright>
        <?php foreach($Videos as $Video) : ?>

        <item>
            <title><?= $Video["title"] ?></title>
            <description><?= nl2br((string) $Video["description"]) ?></description>
            <link>http://www.bitview.net<?= $Video["link"] ?></link>
            <author><?= $Video["uploaded_by"] ?></author>
            <pubDate><?= date("D, d M Y H:i:s O", strtotime((string) $Video["uploaded_on"])) ?></pubDate>

            <media:keywords><?= $Video["tags"] ?></media:keywords>
            <media:thumbnail url="http://www.bitview.net/u/thmp/<?= $Video["url"] ?>.jpg" width="120" height="90" />
        </item>
        <?php endforeach ?>
    </channel>
</rss>
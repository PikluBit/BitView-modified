<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
ini_set("short_open_tag",0);

//LATEST VIDEOS
$Latest_Videos              = new Videos($DB,$_USER);
$Latest_Videos->ORDER_BY    = "videos.uploaded_on DESC";
$Latest_Videos->LIMIT       = 16;
$Latest_Videos->get();
$Latest_Videos              = $Latest_Videos->fix_values(false,false);


header("Content-Type: application/rss+xml; charset=utf-8");
?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss version="2.0">
    <channel>
        <title>BitView :: Recently Added Videos</title>
        <link>http://www.bitview.net</link>
        <description>Recently Added Videos</description>
        <language>en-us</language>
        <copyright>Copyright (C) 2017-2020 bitview.net</copyright>
        <?php foreach($Latest_Videos as $Video) : ?>

        <item>
            <title><?= $Video["title"] ?></title>
            <description><?= $Video["description"] ?></description>
            <link>http://www.bitview.net<?= $Video["link"] ?></link>
            <author><?= $Video["uploaded_by"] ?></author>
            <pubDate><?= date("D, d M Y H:i:s O", strtotime((string) $Video["uploaded_on"])) ?></pubDate>

            <media:keywords><?= $Video["tags"] ?></media:keywords>
            <media:thumbnail url="/u/thmp/<?= $Video["url"] ?>.jpg" width="120" height="90" />
        </item>
        <?php endforeach ?>
    </channel>
</rss>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php if (!isset($_PAGE["Description"])) : ?>BitView is the best place to share your videos with the world and your friends and family.<?php else : ?><?= $_PAGE["Description"] ?><?php endif ?>" />
<meta name="keywords" content="<?php if (!isset($_PAGE["Keywords"]) || empty($_PAGE["Keywords"])) : ?><?= $_CONFIG::$Statics["keywords"] ?><?php else : ?><?= $_PAGE["Keywords"] ?><?php endif ?>" />

<title><?= $_PAGE["Title"] ?> - BitView</title>
<link href="/css/main.css?3" rel="stylesheet" type="text/css" />
<?php if (isset($_COOKIE["feather"]) && $_COOKIE["feather"] == 1): ?><link href="/css/feather.css?20" rel="stylesheet" type="text/css" /><?php endif ?>
<?php if (isset($_COOKIE['dark'])): ?>
<link href="/css/dark.css?24" rel="stylesheet" type="text/css">
<?php endif?>
<link rel="apple-touch-icon-precomposed" href="/img/apple-touch-icon-iphone-60x60-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="/img/apple-touch-icon-ipad-76x76-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/img/apple-touch-icon-iphone-retina-120x120-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/img/apple-touch-icon-ipad-retina-152x152-precomposed.png">
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8433080377364721" crossorigin="anonymous"></script>


<meta property="og:type" content="video.other">

<meta property="og:title" content="<?= $_PAGE["Title"] ?>">
<meta property="og:description" content="<?= $_PAGE["Description"] ?>">
<meta property="og:image" content="<?= "https://".$_SERVER["HTTP_HOST"]?>/u/thmp/<?= $_VIDEO->URL ?>.jpg">
<meta property="og:url" content="<?= "https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] ?>">

<meta property="og:video:url" content="<?= "https://".$_SERVER["HTTP_HOST"] ?>/embed?v=<?= $_VIDEO->URL ?>">
<meta property="og:video:secure_url" content="<?= "https://".$_SERVER["HTTP_HOST"] ?>/embed?v=<?= $_VIDEO->URL ?>">
<meta property="og:video:type" content="text/html">
<meta property="og:video:width" content="640">
<meta property="og:video:height" content="360">

<meta property="og:video:duration" content="10">
<?php if (isset($_VIDEO->Info["uploaded_on"])) : ?>
    <meta property="og:video:release_date" content="<?= date(DATETIME::ISO8601, strtotime((string) $_VIDEO->Info["uploaded_on"])) ?>">
<?php endif ?>
<?php if (!empty($_VIDEO->Info["tags"])) : ?>
    <?php foreach (explode(",", (string) $_VIDEO->Info["tags"]) as $keyword) : ?>
        <meta property="og:video:tag" content="<?= mb_trim(htmlspecialchars($keyword, ENT_QUOTES)) ?>">
    <?php endforeach ?>
<?php endif ?>

<meta name="twitter:card" content="player">
<meta name="twitter:site" content="@BitView_">
<meta name="twitter:url" content="<?= "https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] ?>">
<meta name="twitter:title" content="<?= $_PAGE["Title"] ?>">
<meta name="twitter:description" content="<?= $_PAGE["Description"] ?>">
<meta name="twitter:image" content="<?= "https://".$_SERVER["HTTP_HOST"] ?>/u/thmp/<?= $_VIDEO->URL ?>.jpg">
<meta name="twitter:player" content="<?= "https://".$_SERVER["HTTP_HOST"] ?>/embed?v=<?= $_VIDEO->URL ?>">
<meta name="twitter:player:width" content="640">
<meta name="twitter:player:height" content="360">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script>
    function addToQuickList(e) {
        var url = e.id.replace("yt-uix-button-short-","");
        var msg = e.parentElement.parentElement.querySelector(".video-in-quicklist");
        e.style.display = "none";
        msg.style.display = "block";
        e.parentElement.parentElement.classList.add('in-quicklist');
        var url = "/a/quicklist?v="+url;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                } else {
                    showErrorMessage();
                }
            };
            xhr.onerror = function() {
                showErrorMessage();
            };
            xhr.send();
    }
</script>
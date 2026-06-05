<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php if (!isset($_PAGE["Description"])) : ?>BitView is the best place to share your videos with the world and your friends and family.<?php else : ?><?= $_PAGE["Description"] ?><?php endif ?>" />
<meta name="keywords" content="<?php if (!isset($_PAGE["Keywords"])) : ?><?= $_CONFIG::$Statics["keywords"] ?><?php else : ?><?= $_PAGE["Keywords"] ?><?php endif ?>" />

<title>BitView - <?php if (!isset($_PAGE["Title"])) : ?>Express Yourself.<?php else : ?><?= $_PAGE["Title"] ?><?php endif ?></title>
<link href="/css/main.css?<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/css/main.css') ?>" rel="stylesheet" type="text/css" />
<!--[if lt IE 8]>
<link href="/css/main.css?11" rel="stylesheet" type="text/css" />
<![endif]-->
<?php if (isset($_COOKIE['dark'])): ?>
<link href="/css/dark.css?20" rel="stylesheet" type="text/css">
<?php endif?>
<link rel="apple-touch-icon-precomposed" href="/img/apple-touch-icon-iphone-60x60-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="/img/apple-touch-icon-ipad-76x76-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/img/apple-touch-icon-iphone-retina-120x120-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/img/apple-touch-icon-ipad-retina-152x152-precomposed.png">
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8433080377364721" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php if (!isset($_PAGE["Description"])) : ?>BitView is the best place to share your videos with the world and your friends and family.<?php else : ?><?= $_PAGE["Description"] ?><?php endif ?>" />
<meta name="keywords" content="<?php if (!isset($_PAGE["Keywords"])) : ?><?= $_CONFIG::$Statics["keywords"] ?><?php else : ?><?= $_PAGE["Keywords"] ?><?php endif ?>" />

<title>BitView - <?php if (!isset($_PAGE["Title"])) : ?>Express Yourself.<?php else : ?><?= $_PAGE["Title"] ?><?php endif ?></title>
<link href="/css/main.css?21" rel="stylesheet" type="text/css" />
<!--[if lt IE 8]>
<link href="/css/main.css?10" rel="stylesheet" type="text/css" />
<![endif]-->
<?php if (isset($_COOKIE['dark'])): ?>
<link href="/css/dark.css?20" rel="stylesheet" type="text/css">
<?php endif?>
<link rel="apple-touch-icon-precomposed" href="/img/apple-touch-icon-iphone-60x60-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="/img/apple-touch-icon-ipad-76x76-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/img/apple-touch-icon-iphone-retina-120x120-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/img/apple-touch-icon-ipad-retina-152x152-precomposed.png">
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8433080377364721" crossorigin="anonymous"></script>
<?php if (isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/".$_COOKIE["lang"].".lang.php")) : ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/lang/".$_COOKIE["lang"].".lang.php" ?>
<?php elseif (!isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/".substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5).".lang.php")) : ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/lang/".substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5).".lang.php" ?>
<?php elseif (!isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/".substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2).".lang.php")) : ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/lang/".substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2).".lang.php" ?>
<?php else : ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/lang/en-US.lang.php" ?>
<?php endif ?>
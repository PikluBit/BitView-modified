<style>
    #bv-static-main-content {
    width: 765px;
    float: left;
    color: #333;
    margin-top: 15px;
}
h1.bv-static {
    font-size: 24px;
    font-weight: bold;
    margin-top: 0;
    color: #000;
    margin-bottom: 6px;
}
h2.bv-static {
    font-size: 18px;
    font-weight: bold;
    color: #000;
    margin-top: 18px;
    margin-bottom: 6px
}
h3.bv-static {
    font-size: 15px;
    font-weight: bold;
    color: #000;
    margin-top: 18px;
    margin-bottom: 6px;
}
h4.bv-static {
    font-size: 12px;
    font-weight: bold;
    color: #000;
    margin-top: 18px;
    margin-bottom: 6px
}
p.bv-static {
    margin-bottom: 12px;
    line-height: 15px;
}
.bv-static-single-rule {
    border-top: 1px solid #ccc;
    margin-bottom: 10px;
}
.bv-static-tt-entry {
    margin: 15px 0 25px 0;
}
.bv-static-tt-entry .icon {
    float: left;
}
.bv-static-tt-entry .info {
    margin-left: 110px;
}
#bv-static-sidebar-nav {
    width: 175px;
    float: left;
    margin-right: 20px;
    margin-top: 15px;
    height: 100%;
}
.bv-static-sidebar-subhead {
    padding: 6px 0;
    color: #333;
    margin-top: 1px;
    font-weight: bold;
}
ul.bv-static-sidebar-list {
    margin: 0;
    padding: 3px 0;
}
.bv-static-sidebar-item {
    list-style: none;
    margin: 0;
    padding: 3px 6px;
}
li.bv-static-sidebar-item a:link, li.bv-static-sidebar-item a:visited {
    text-decoration: none;
    color: #03c;
}
.bv-static-sidebar-item-highlight {
    list-style: none;
    margin: 0;
    padding: 3px 6px;
}
li.bv-static-sidebar-item-highlight a:link, li.bv-static-sidebar-item-highlight a:visited {
    text-decoration: none;
    color: #000;
}
</style>
<div id="bv-static-sidebar-nav">
    
<div class="bv-static-sidebar-subhead">
    BitView
</div>
<ul class="bv-static-sidebar-list">
    <li class="bv-static-sidebar-item"><a href="/blog"><?= $LANGS['bitviewblog'] ?></a></li>
</ul>

<div class="bv-static-sidebar-subhead">
    <?= $LANGS['discover'] ?>
</div>
<ul class="bv-static-sidebar-list">
    <li class="bv-static-sidebar-item"><a href="/bitviewonyoursite"><?= $LANGS['bvsite'] ?></a></li>
    <li class="bv-static-sidebar-item"><a href="/rss_feeds"><?= $LANGS['bvrss'] ?></a></li>
    <li class="bv-static-sidebar-item-highlight"><a href="/testview">TestView</a></li>
</ul>

<div class="bv-static-sidebar-subhead">
    <?= $LANGS['programs'] ?>
</div>
<ul class="bv-static-sidebar-list">
        <li class="bv-static-sidebar-item"><a href="/partners"><?= $LANGS['partnerships'] ?></a></li>
    <li class="bv-static-sidebar-item"><a href="https://dev.bitview.net"><?= $LANGS['developers'] ?></a></li>
</ul>

<div class="bv-static-sidebar-subhead">
    <?= $LANGS['help'] ?>
</div>
<ul class="bv-static-sidebar-list">
    <li class="bv-static-sidebar-item"><a href="/help"><?= $LANGS['helpcenter'] ?></a></li>
</ul>

</div>
<div id="bv-static-main-content">
    <h1 class="bv-static">TestView</h1>

    <p class="bv-static"><?= $LANGS['testviewdesc'] ?></p>
    
    <hr class="bv-static-single-rule">

    <div class="bv-static-tt-entry">
        <div class="icon"><a href="/testview?flash_player=<?php if (!isset($_COOKIE["html5_player"])): ?>1<?php else: ?>0<?php endif?>"><img src="/img/flashtest.png" width="103" height="74" border="0" alt="<?= $LANGS['flashvideo'] ?>"></a></div>
        <div class="info">
            <h3 class="bv-static"><?= $LANGS['flashvideo'] ?></h3>
            <p class="bv-static" style="margin-top: 0"><?= $LANGS['flashvideodesc'] ?></p>
            <p class="bv-static"><b><?php if (!isset($_COOKIE["html5_player"])): ?><a href="/testview?flash_player=1"><?= $LANGS['tryitout'] ?></a><?php else: ?><a href="/testview?flash_player=0"><?= $LANGS['disabletest'] ?></a><?php endif ?></b>
            </p>
        </div>
    </div>
    <div class="bv-static-tt-entry">
        <div class="icon"><a href="/testview?feather=<?php if (!isset($_COOKIE["feather"])): ?>1<?php else: ?>0<?php endif?>"><img src="/img/feathertest.png" width="103" height="74" border="0" alt="Feather"></a></div>
        <div class="info">
            <h3 class="bv-static"><?= $LANGS['feather'] ?></h3>
            <p class="bv-static" style="margin-top: 0"><?= $LANGS['featherdesc'] ?></p>
            <p class="bv-static"><b><?php if (!isset($_COOKIE["feather"])): ?><a href="/testview?feather=1"><?= $LANGS['tryitout'] ?></a><?php else: ?><a href="/testview?feather=0"><?= $LANGS['disabletest'] ?></a><?php endif ?></b>
            </p>
        </div>
    </div>
    <div class="bv-static-tt-entry">
        <div class="icon"><a href="/testview?time_machine=<?php if (!isset($_COOKIE["time_machine"])): ?>1<?php else: ?>0<?php endif?>"><img src="/img/timemachinetest.png" width="103" height="74" border="0" alt="Time Machine"></a></div>
        <div class="info">
            <h3 class="bv-static"><?= $LANGS['timemachine'] ?></h3>
            <p class="bv-static" style="margin-top: 0"><?= $LANGS['timemachinedesc'] ?></p>
            <p class="bv-static"><b><?php if (!isset($_COOKIE["time_machine"])): ?><a href="/testview?time_machine=1"><?= $LANGS['tryitout'] ?></a><?php else: ?><a href="/testview?time_machine=0"><?= $LANGS['disabletest'] ?></a><?php endif ?></b>
            </p>
        </div>
    </div>
    <div class="bv-static-tt-entry">
        <div class="icon"><a href="/testview?dark=<?php if (!isset($_COOKIE["dark"])): ?>1<?php else: ?>0<?php endif?>"><img src="/img/darktest.png" width="103" height="74" border="0" alt="Lights Out"></a></div>
        <div class="info">
            <h3 class="bv-static"><?= $LANGS['lightsout'] ?></h3>
            <p class="bv-static" style="margin-top: 0"><?= $LANGS['lightsoutdesc'] ?></p>
            <p class="bv-static"><b><?php if (!isset($_COOKIE["dark"])): ?><a href="/testview?dark=1"><?= $LANGS['tryitout'] ?></a><?php else: ?><a href="/testview?dark=0"><?= $LANGS['disabletest'] ?></a><?php endif ?></b>
            </p>
        </div>
    </div>
</div>
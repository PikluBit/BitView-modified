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
.arrowHead {
    font-weight: normal;
    font-size: 14px;
}
.bv-uix-expander .bv-uix-expander-arrow {
    background-position: 0 -344px;
}
.bv-uix-expander-arrow {
    height: 16px;
    width: 12px;
    margin-right: 4px;
    background: url(/img/master-vfl87445.png) no-repeat 0 -322px;
    vertical-align: middle;
    border:0;
}
.bv-uix-expander-head {
    cursor: pointer;
    color: #000;
}
.bv-uix-expander-head {
    margin: 0;
}
.bv-uix-expander-head:hover {
    color: #666;
}
.bv-uix-expander .bv-uix-expander-body {
    display: none;
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
    <li class="bv-static-sidebar-item-highlight"><a href="/bitviewonyoursite"><?= $LANGS['bvsite'] ?></a></li>
    <li class="bv-static-sidebar-item"><a href="/rss_feeds"><?= $LANGS['bvrss'] ?></a></li>
    <li class="bv-static-sidebar-item"><a href="/testview">TestView</a></li>
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
    <h1 class="bv-static"><?= $LANGS['bvsite'] ?></h1>
    
    <p class="bv-static"><?= $LANGS['bvsitedesc1'] ?></p>
    
    <p class="bv-static"><?= $LANGS['bvsitedesc2'] ?></p>
    
    <hr class="bv-static-single-rule">
    <h2 class="bv-static"><?= $LANGS['bvsitetitle1'] ?></h2>
    <div class="bv-uix-expander" onclick="if (this.className == 'bv-uix-expander'){ this.className = 'bv-uix-expander-expanded';} else { this.className = 'bv-uix-expander';}">
        <h3 class="bv-uix-expander-head">
            <button title="" class="bv-uix-expander-arrow master-sprite"></button>
            <span class="arrowHead"><?= $LANGS['bvsitesectiontitle1'] ?></span>
        </h3>
        <div class="bv-uix-expander-body" id="bv-uix-expander-body" onclick='event.stopPropagation();'>
            <ol>
                <li><?= $LANGS['bvsitesection1desc1'] ?></li>
                <li><?= $LANGS['bvsitesection1desc2'] ?></li>  
                <li><?= $LANGS['bvsitesection1desc3'] ?></li>
            </ol>
        </div>
    </div>
    <br>
    <div class="bv-uix-expander" onclick="if (this.className == 'bv-uix-expander'){ this.className = 'bv-uix-expander-expanded';} else { this.className = 'bv-uix-expander';}">
        <h3 class="bv-uix-expander-head">
            <button title="" class="bv-uix-expander-arrow master-sprite"></button>
            <span class="arrowHead"><?= $LANGS['bvsitesectiontitle2'] ?></span>
        </h3>
        <div class="bv-uix-expander-body" id="bv-uix-expander-body" onclick='event.stopPropagation();'>
            <p class="bv-static"><?= $LANGS['bvsitesection2desc1'] ?></p>
            <ol>
                <li><?= $LANGS['bvsitesection2desc2'] ?></li>
                <li><?= $LANGS['bvsitesection2desc3'] ?></li>  
                <li><?= $LANGS['bvsitesection2desc4'] ?></li>
                <li><?= $LANGS['bvsitesection2desc5'] ?></li>
            </ol>
        </div>
    </div>
    <br>
    <hr class="bv-static-single-rule">
    <h2 class="yt-static"><?= $LANGS['bvsitetitle2'] ?></h2>
    <div class="bv-uix-expander" onclick="if (this.className == 'bv-uix-expander'){ this.className = 'bv-uix-expander-expanded';} else { this.className = 'bv-uix-expander';}">
        <h3 class="bv-uix-expander-head">
            <button title="" class="bv-uix-expander-arrow master-sprite"></button>
            <span class="arrowHead"><?= $LANGS['bvsitesectiontitle3'] ?></span>
        </h3>
        <div class="bv-uix-expander-body" id="bv-uix-expander-body" onclick='event.stopPropagation();'>
            <p class="bv-static"><?= $LANGS['bvsitesection3desc1'] ?></p>
            <p class="bv-static"><?= $LANGS['bvsitesection3desc2'] ?></p>

        <p class="bv-static"><img src="/img/pic_herotrap_373x375.jpg" alt="Screenshot of Herotrap's website"></p>
        </div>
    </div>
    <br>
    <div class="bv-uix-expander" onclick="if (this.className == 'bv-uix-expander'){ this.className = 'bv-uix-expander-expanded';} else { this.className = 'bv-uix-expander';}">
        <h3 class="bv-uix-expander-head">
            <button title="" class="bv-uix-expander-arrow master-sprite"></button>
            <span class="arrowHead"><?= $LANGS['bvsitesectiontitle4'] ?></span>
        </h3>
        <div class="bv-uix-expander-body" id="bv-uix-expander-body" onclick='event.stopPropagation();'>
            <p class="bv-static"><?= $LANGS['bvsitesection4desc1'] ?></p>
            <p class="bv-static"><?= $LANGS['bvsitesection4desc2'] ?></p>
            <p class="bv-static"><?= $LANGS['bvsitesection4desc3'] ?><br>
        </div>
    </div><br>
</div>
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
    <li class="bv-static-sidebar-item-highlight"><a href="/rss_feeds"><?= $LANGS['bvrss'] ?></a></li>
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
    <h1 class="bv-static"><?= $LANGS['bvrss'] ?></h1>
    
    <h2 class="bv-static"><?= $LANGS['rsstitle1'] ?></h2>

    <p class="bv-static" style="margin-top: 0"><?= $LANGS['rssdesc1'] ?></p>

    <h2 class="bv-static"><?= $LANGS['rsstitle2'] ?></h2>

    <p class="bv-static" style="margin-top: 0"><?= $LANGS['rssdesc2'] ?></p>

    <p class="bv-static"><?= $LANGS['rssdesc3'] ?></p>
    
    <hr class="bv-static-single-rule" align="left">
    
    <h2 class="bv-static"><?= $LANGS['rsstitle3'] ?></h2>

    <p class="bv-static" style="margin-top: 0"><?= $LANGS['rssdesc4'] ?></p>
    
    <table cellspacing="0" cellpadding="6" border="0">
        <tbody><tr valign="top">
            <td><img src="/img/rsstop.gif" alt="RSS screenshot"></td>
            <td><?= $LANGS['rssdesc5'] ?></td>
        </tr>
        <tr valign="top">
            <td><img src="/img/rssbot.gif" alt="RSS screenshot"></td>
            <td><?= $LANGS['rssdesc6'] ?></td>
        </tr>
    </tbody></table>

</div>
<style type="text/css">
.videoModifiers {
    padding: 5px 0px;
    border-bottom: 1px solid #ccc;
    text-align: center;
}
.videoModifiers div.first {
    border-left: 0px;
    padding: 0px 10px 0px 2px;
}
.videoModifiers div.subcategory {
    border-left: 1px solid #ccc;
    padding: 0px 10px;
    font-size: 11px;
    display: inline;
}
.videoModifiers .selected {
    font-weight: bold;
}
</style>
<div id="header-wrapper">
    <div id="header-left">
    Show Message
    </div>
    <div class="clearL"></div>
</div>
<div class="videoModifiers">
        <div class="subcategory first"><a href="/my_account">My Profile</a></div>
        <div class="subcategory"><a href="/my_videos">My Videos</a></div>
        <div class="subcategory"><a href="/my_favorites">My Favorites</a></div>
        <div class="subcategory"><span class="selected">My Messages</span></div>
        <div class="subcategory"><a href="/my_subscriptions">My Subscriptions</a></div>
        <div class="subcategory"><a href="/my_playlists">My Playlists</a></div>
        <div class="clear"></div>
</div>
<br>
<div style="margin:0 0 13px;text-align:center;word-spacing: 8px">
    <a href="/inbox">Messages</a> | <a href="/send_message">Send</a>
</div>
<div class="small_box_header" style="padding:5px">
    Message: <?= preg_replace('/\s+?(\S+)?$/', '', mb_substr((string) $Message["content"], 0, 55)); ?>
</div>
<div class="small_box_in" style="padding:4;position:relative;overflow:hidden">
    <div style="float:left;width:100px">
        <?php
        $Check = $DB->execute("SELECT url FROM videos WHERE uploaded_by = :USERNAME ORDER BY uploaded_on DESC LIMIT 1", true, [":USERNAME" => $Message["by_user"]]);
    if ($Check) {
        $Avatar = "/u/thmp/".$Check["url"].".jpg";
    } else {
        $Avatar = "/img/nothump.png";
    }
    ?>
        <a href="/user/<?= $Message["by_user"] ?>"><img src="<?= $Avatar ?>" width="80" height="60"></a>&nbsp;
    </div>
    <div style="float:left;position:relative;bottom:1px;width:670px">
        <div>
        <?= make_links_clickable(nl2br((string) $Message["content"])) ?>
        </div>
        <div style="border-top:1px dashed #ccc;margin-top:8px;line-height:16px;padding-top:6px;font-size:11px">
            <b>By:</b> <a href="/user/<?= $Message["by_user"] ?>"><?= $Message["by_user"] ?></a><br />
            <b>From:</b> <?= date("F d, Y, h:i A", strtotime((string) $Message["submit_on"])) ?><br />
            <b>Words:</b> <?= str_word_count((string) $Message["content"]) ?><br />
            <a href="/send_message?to=<?= $Message["by_user"] ?>" style="font-weight:bold">Reply to message</a>
        </div>
    </div>
</div>
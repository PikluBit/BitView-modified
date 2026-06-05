<style>
#header {
    margin: 10px 0;
    font-size: 13px;
}
.video-time, .video-corner-text span {
    padding: 0 4px;
    font-weight: bold;
    font-size: 11px;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    background-color: #000;
    color: #fff !important;
    height: 14px;
    line-height: 14px;
    opacity: 0.75;
    filter: alpha(opacity = 75);
    display: -moz-inline-stack;
    display: inline-block;
    vertical-align: top;
    zoom: 1;
}
.video-time {
    margin-top: 0;
    margin-right: 0;
    position: absolute;
    right: 4px;
    bottom: 4px;
    opacity: 0.75;
}
#side-column {
    width: 224px;
    min-height: 362px;
    float: right;
    font-size: 13px;
    background-color: #eaeaea;
    padding: 10px 30px 0 16px;
    margin-top: 0;
}
#side-column p {
    margin-bottom: 23px;
    margin-top: 0;
}
#side-column h4 {
    font-weight: bold;
    margin: 0 0 5px 0;
}
#main-content {
    float: left;
    width: 670px;
}
#main-content-fg {
    width: 670px;
}
.gray-tab-box-header {
    background-color: #ccc;
    font-weight: bold;
}
.gray-tab-box-header .first {
    -moz-border-radius-topright: 0;
    -moz-border-radius-bottomright: 0;
    -webkit-border-top-right-radius: 0;
    -webkit-border-bottom-right-radius: 0;
}
.gray-tab-box-header .selected {
    background-color: #333;
    color: #fff;
}
.gray-tab-box-header .subcategory {
    font-size: 13px;
    float: left;
    padding: 6px 13px;
    cursor: pointer;
    cursor: hand;
}
.gray-tab-box-content {
    width: 670px;
    background-color: #fff;
    font-size: 13px;
}
.gray-tab-box-content .tab-content {
    display: none;
}
.gray-tab-box-content .selected {
    display: block;
}
#choose-video-list {
    float: right;
    background-color: #eaeaea;
    width: 319px;
    height: 284px;
    padding: 8px 13px;
    margin-top: 20px;
}
#choose-video-list-info {
    margin-bottom: 5px;
}
#choose-video-list select {
    width: 320px;
    height: 230px;
    margin-bottom: 5px;
}
#record-video-info, #upload-video-info, #choose-video-info {
    float: left;
    width: 240px;
    padding-top: 10px;
    padding-left: 5px;
}
h4 {
    font-size: 1.0833em;
}
#upload-video-info ul {
    margin-bottom: 20px;
    list-style-position: inside;
    list-style-type: disc;
}
#record-video-info-text h2, #upload-video-info h2, #choose-video-info h2 {
    margin-top: 0;
}
#upload-video-flash, #choose-video-none {
    float: right;
    background-color: #eaeaea;
    width: 245px;
    height: 199px;
    padding: 100px 40px 1px 60px;
    text-align: center;
    margin-top: 20px;
}
#upload-video-flash-msg, #choose-video-none-msg {
    color: #666;
    font-weight: bold;
    font-size: 16px;
    margin-bottom: 10px;
}
</style>
<script>
    function selectTab(e) {
        document.getElementsByClassName('subcategory')[0].classList.remove("selected");
        document.getElementsByClassName('subcategory')[1].classList.remove("selected");
        e.classList.add("selected");
        document.getElementsByClassName('tab-content')[0].classList.remove("selected");
        document.getElementsByClassName('tab-content')[1].classList.remove("selected");
        document.getElementById(e.id + '-content').classList.add('selected');
    }
</script>
<div id="header">
    <div class="floatL">
<span class="video-thumb ux-thumb-54" id="video-thumb-<?= $_VIDEO->URL ?>"><span class="img"><img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$_VIDEO->Info['url'].'.jpg')): ?>src="/u/thmp/<?= $_VIDEO->Info['url'] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> title="<?= $_VIDEO->Info['title'] ?>"></span>      
<span class="video-time"><?= timestamp($_VIDEO->Info['length']) ?></span></span>
    </div>
    <div class="floatL" style="margin-left: 8px;">
        <div>
            <span class="bold"><?= $LANGS['postingresponse'] ?></span> <a href="/watch?v=<?= $_VIDEO->URL ?>" dir="ltr"><?= $_VIDEO->Info['title'] ?></a>
        </div>
        <div class="grayText">
<?= str_replace("{n}",$Responses_Amount,$LANGS['responsessofar']) ?>
        </div>
    </div>
    <div class="clearL"></div>
</div>
<div id="side-column" class="yt-rounded">
    <?= $LANGS['responsesdesc1'] ?><?= $LANGS['responsesdesc2'] ?><?= $LANGS['responsesdesc3'] ?>
</div>
<div id="main-content">

    <div id="main-content-fg" class="gray-tab-box">
        <div class="gray-tab-box-header yt-rounded">
            <div id="choose-tab" class="subcategory first yt-rounded selected" onclick="selectTab(this)"><?= $LANGS['chooseavideo'] ?></div>
            <div id="upload-tab" class="subcategory " onclick="selectTab(this)"><?= $LANGS['uploadavideo'] ?></div>
            <div class="clear"></div>
        </div>
        <div class="gray-tab-box-content">
            <div id="choose-tab-content" class="tab-content selected">
                        <div id="choose-video-list">
                            <div id="choose-video-list-info"><?= $LANGS['selectvideo'] ?></div>
                            <form id="choose-video-form" method="post" action="/video_response_upload?v=<?= $_VIDEO->URL ?>">
                                <input type="hidden" name="v" value="<?= $_VIDEO->URL ?>">
                                <input type="hidden" name="respond" value="1">
                                <select multiple="multiple" name="video_response_id">
                                    <?php foreach ($Videos as $Video): ?>
                                    <option value="<?= $Video['url'] ?>"><?= $Video['title'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div class="alignR">
                                    <input type="submit" class="yt-uix-button yt-uix-button-primary" name="video_submit" value="<?= $LANGS['useselectedvideo'] ?>" style="margin-right:2px">
                                </div></form>
                        </div>
                    <div id="choose-video-info">
                        <h2><?= $LANGS['choosevideotitle'] ?></h2>
                    </div>
                <div class="clear"></div>
            </div>
            <div id="upload-tab-content" class="tab-content ">
                <div id="upload-video-flash">
                    <div id="upload-video-flash-msg"><?= $LANGS['clickstart'] ?></div>
                    <button type="button" class=" yt-uix-button yt-uix-button-primary" onclick="parent.location='/my_videos_upload';;return false;"><span class="yt-uix-button-content"><?= $LANGS['start'] ?></span></button>
                </div>
                <div id="upload-video-info">
                    <h2><?= $LANGS['uploadvideoresponse'] ?></h2>
                    <ul>
                        <li class="grayText"><?= $LANGS['uploadsize'] ?></li>
                        <li class="grayText"><?php if ($_USER->Info['is_partner'] == 1): ?><?= $LANGS['uploadlengthpartners'] ?><?php else: ?><?= $LANGS['uploadlength'] ?><?php endif ?></li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>

        </div>      </div>  </div>
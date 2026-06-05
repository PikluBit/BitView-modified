<style>
    .vlAnnotationsContainer {
        width: 100%;
        height: 100%;
        position: absolute;
        overflow: visible;
        left: 0px;
        top: 0px;
        z-index: 5000;
    }
    .vlPlayer2010 .vlControls {
        z-index: unset;
        border-right: 1px solid #ccc;
    }
    .vlPlayer2010 .vlProgressAll {
        z-index: 9999;
    }
    .vlPlayer2010 .vlPlay, .vlPlayer2010 .vlSound {
    z-index: 333333333333;
    position: relative;
}
    .vlPlayer2010 .vlOptions, .vlPlayer2010 .vlButtonsRight {
        display: none;
    }
    .vlPlayer2010 .vlControlsBar {
        opacity: 1!important;
    }
    #annotationseditor-container {
        width: 308px;
        height: 390px;
        float: right;
        position: relative;
    }
    #watch-video-container {
        float: left;
        width: 640px;
    }
    .bottomBar {
        height: 26px;
        width: 100%;
        background: linear-gradient(#00000014, #ffffff00 80%);
        border-top: 1px solid #ccc;
        box-shadow: 0 -1px 2px #00000020;
    }
    .topBar {
        height: 30px;
        padding: 6px 0;
    }
    .expand-buttons .yt-uix-button-arrow {
        margin-top: 0;
    }
    #annotationseditor-container-inside {
        border-radius: 6px;
        margin-left: 4px;
        box-shadow: inset 0 1px 2px 0.5px #00000040;
        background: #fff;
        overflow: hidden;
    }
    .menu-annotation {
        border-bottom: 1px solid #ddd;
        padding: 6px;
        cursor: pointer;
    }
    .yt-ann-button {
        color: #02a;
        font-weight: bold;
        border: 1px solid #bdddea;
        background: linear-gradient(#ebf9ff, #bdebff, #ebf9ff);
        border-radius: 4px;
        padding: 6px 0;
        width: 68px;
        cursor: pointer;
    }
    .yt-ann-button:hover {
        border: 1px solid #cce1ea;
        background: linear-gradient(#f9fdff, #d6f3ff, #f9fdff);
    }
    .yt-ann-button:active {
        background: linear-gradient(#c7eeff, #fcfeff);
    }
    .button-shadow {
        width: 68px;
        padding: 3px;
        height: 28px;
        background: linear-gradient(180deg, #ccc, transparent 30%);
        border-radius: 6px;
        float: right;
    }
    .timestamps {
        margin-top: 4px;
    }
    .timestamps input {
        border: 1px solid #ccc;
        width: 64px;
        height: 20px;
        text-align: center;
        color: #03c;
    }
    #annotationseditor-loading {
        border-top: 1px solid #ddd;
        border-radius: 6px;
        padding: 8px;
        margin: 4px;
        height: 290px;
        color: #999;
        text-align: center;
        line-height: 260px;
        display: none;
    }
    #link {
        height: 24px;
        width: 24px;
        border: 0;
        margin-right: 4px;
        background: url(/img/link.svg) no-repeat center;
        vertical-align: middle;
        position: relative;
        top: -1px;
        cursor: pointer;
    }
    .annotation:active {
        cursor: grabbing;
    }
    .annotation {
        cursor: grab;
        overflow: visible;
    }
    .resize {
        width: 8px;
        height: 8px;
        background: white;
        position: absolute;
        border: 1px solid #00000090;
        box-shadow: inset -1px -1px #00000030;
        display: block!important;
    }
    .resize-0 {
        top: -6px;
        left: -6px;
        cursor: nwse-resize;
    }
    .resize-1 {
        bottom: -6px;
        left: -6px;
        cursor: nesw-resize;
    }
    .resize-2 {
        top: -6px;
        right: -6px;
        cursor: nesw-resize;
    }
    .resize-3 {
        bottom: -6px;
        right: -6px;
        cursor: nwse-resize;
    }
    .ann-icon {
        width: 18px;
        height: 18px;
        background: red;
        float: left;
        margin-right: 6px;
        border: 0;
        cursor: pointer;
    }
    #note {
        background: url(/img/note_ann.svg) no-repeat;
    }
    #speech {
        background: url(/img/speech_ann.svg) no-repeat;
    }
    #highlight {
        background: url(/img/highlight_ann.svg) no-repeat;
    }
    .timestamp-icon {
        width: 24px;
        height: 24px;
        background: red;
        margin: 0 6px;
        vertical-align: middle;
        position: relative;
        top: -1px;
    }
    .timestamp-icon#icon-1 {
        background: url(/img/ts-1.svg) no-repeat center;
    }
    .timestamp-icon#icon-2 {
        background: url(/img/ts-2.svg) no-repeat center;
    }
    .timestamp-icon#icon-3 {
        background: url(/img/ts-3.svg) no-repeat center;
    }
    #status {
        float: right;
        color: #999;
        line-height: 34px;
        margin-right: 10px;
    }
    .del-icon {
        width: 18px;
        height: 18px;
        background: url(/img/del.svg) no-repeat center;
        background-size: 18px;
        float: right;
        border: 0;
        cursor: pointer;
    }
    .editor-container {
        padding: 6px;
        background: #eee;
    }
    #annotationseditor-container-inside-items {
        overflow: scroll;
        height: 321px;
    }
    #add-link-screen {
        background: #00000050;
        position: absolute;
        top: 134px;
        z-index: 4444444;
        width: 960px;
        height: 402px;
        opacity: 1;
    }
    .add-link-box {
        width: 380px;
        position: relative;
        top: 120px;
        left: 118px;
        padding: 8px 12px;
        background: linear-gradient(#ddd, #fff 50%);
        border-radius: 4px;
        box-shadow: 0 2px 3px #00000070;
    }
    .menu-annotation:hover {
        background: linear-gradient(#0691ff30, #ffffff00 50%);
    }
    .menu-expand {
        display: block;
        width: 100%;
        height: 0;
        overflow: hidden;
        transition: height 0.4s ease-in-out;
    }
    .menu-expand.expanded {
        height: 33px; /* ME REPITES ESE NUMERIN?!?!? */
    }
    .expand-buttons {
        margin-top: 8px;
        padding: 0 6px;
        text-align: center;
    }
    .expand-buttons .yt-uix-button {
        margin: 0 5px;
    }
    .colorSelIcon {
        background: url(/img/colorsel.svg) no-repeat;
        width: 19px;
        margin-right: 8px;
        border-right: 1px solid #ccc;
        padding-right: 8px;
    }
    .linkSelIcon {
        background: url(/img/link.svg) no-repeat;
        width: 16px;
        background-size: 16px;
        margin-right: 8px;
        border-right: 1px solid #ccc;
        padding-right: 8px;
    }
    .color-selector {
        position: absolute;
        background: #ffffffcc;
        top: 0;
        z-index: 44555;
        border-radius: 4px;
        padding: 6px;
        box-shadow: 0 2px 2px #00000050;
    }
    #select-white {
        background: #ffffffcc;
    }
    #select-grey {
        background: #999999cc;
        color: #ffffff;
    }
    #select-black {
        background: #00000080;
        color: #ffffff;
    }
    #select-lightblue {
        background: #b4c8dfcc;
    }
    #select-red {
        background: #cb3e3ecc;
        color: #fff;
    }
    #select-blue {
        background: #063894cc;
        color: #fff;
    }
    #select-green {
        background: #2e9528cc;
        color: #fff;
    }
    .select-color {
        display: inline-block;
        width: 20px;
        height: 20px;
        line-height: 20px;
        font-weight: bold;
        text-align: center;
        margin: 0 3px;
        cursor: pointer;
    }
    .addBtn {
        background: linear-gradient(#ffffff, #eaeaea 80%);
        box-shadow: inset -1px 0px white;
        border: 0;
        border-right: 1px solid #ccc;
        height: 26px;
        width: 32px;
        cursor: pointer;
    }
    .addBtn:hover {
        background: linear-gradient(#ffffff, #d9d9d9 100%);
    }
    .addBtn:active {
        background: linear-gradient(#bbbbbb, #fff 100%);
    }
    .noteIcon {
        background: url(/img/note_ann.svg) no-repeat;
        width: 18px;
        height: 18px;
        line-height: 20px;
        margin-top: 6px;
    }
    .speechIcon {
        background: url(/img/speech_ann.svg) no-repeat;
        width: 18px;
        height: 18px;
        line-height: 20px;
        margin-top: 6px;
    }
    .highlightIcon {
        background: url(/img/highlight_ann.svg) no-repeat;
        width: 18px;
        height: 18px;
        line-height: 20px;
        margin-top: 6px;
    }
    .plusIcon {
        background: url(/img/plus.svg) no-repeat;
        width: 8px;
        height: 8px;
        line-height: 20px;
        top: -30px;
        left: 12px;
        position: relative;
    }
    .tipSelIcon {
        background: url(/img/speech_ann.svg) no-repeat;
        width: 16px;
        background-size: 16px;
        margin-right: 8px;
        border-right: 1px solid #ccc;
        padding-right: 8px;
    }
    .tip_sk {
        width: 14px;
        height: 14px;
        background: url(/img/tip_sk.png);
        position: absolute;
        z-index: 333;
        cursor: grab;
        filter: drop-shadow(1px 1px 1px #00000050);
    }
    .tip_sk:active {
        cursor: grabbing;
    }
    .vlAnnotationsContainer svg {
        pointer-events: none;
    }
    .link-selection {
        display: inline-block;
        background: white;
        border: 1px solid #999;
        padding: 4px;
        font-weight: bold;
        width: 200px;
        cursor: pointer;
    }
    .link-selection-border {
        display: inline-block;
        background: linear-gradient(#eeeeee, white);
        border: 1px solid #999;
        border-left: 0;
        border-radius: 0 8px 8px 0;
        padding: 4px 8px;
        font-weight: bold;
        width: 10px;
        cursor: pointer;
    }
    .add-link-value {
        display: inline-block;
        background: white;
        border: 1px solid #999;
        padding: 4px;
        width: 360px;
        box-shadow: inset 0 1px 2px #00000030;
    }
    .link-selection-dropdown {
        position: absolute;
        background: white;
        left: 75px;
        width: 230px;
    }
    .link-selection-dropdown li {
        padding: 4px;
        font-weight: bold;
        cursor: pointer;
    }
    .link-selection-dropdown li:hover {
        background: #eee;
    }
    .link #link {
        background: url(/img/link_active.svg) no-repeat center;
        background-size: 14px;
        filter: drop-shadow(0 0 4px #2dc4f7);
    }
    .edit-video-header {
        border-bottom: 1px solid #999;
        padding: 5px 0;
        margin-bottom: 8px;
        height: 22px;
    }
    .edit-link {
        border: 1px solid #999;
        border-bottom: 0;
        padding: 6px 12px;
        height: 14px;
        display: inline-block;
    }
    .edit-link.active {
        background: white;
        padding-bottom: 7px;
        color: #000;
    }
</style>
<script>
    var video_url = "<?= $_VIDEO->URL ?>";
    var uploader = "<?= $_USER->Username ?>";
    var saved = "<?= $LANGS['saved'] ?>";
    var published = "<?= $LANGS['published'] ?>";
    var notvaliddate = "<?= $LANGS['notvaliddate'] ?>";
    var outsiderange = "<?= $LANGS['outsiderange'] ?>";
    var video_pl = "<?= $LANGS['video_pl'] ?>";
    var playlist_pl = "<?= $LANGS['playlist_pl'] ?>";
    var channel_pl = "<?= $LANGS['channel_pl'] ?>";
    var search_pl = "<?= $LANGS['search_pl'] ?>";
    var entertext = "<?= $LANGS['entertext'] ?>";
</script>
<script src="/player/annotations_editor.js"></script>
<div style="clear:both"></div>
<h1 style="margin: 8px 0;"><?= $_VIDEO->Info['title'] ?></h1>
<div class="edit-video-header">
    <a href="/edit_video?v=<?= $_VIDEO->URL ?>" class="edit-link"><?= $LANGS['infoandsettings'] ?></a>
    <span class="edit-link active"><?= $LANGS['annotations'] ?></span>
    <!--a href="/my_videos_captions?v=<?= $_VIDEO->URL ?>" class="edit-link"><?= $LANGS['captionsandsubtitles'] ?></a-->
    <a href="/watch?v=<?= $_VIDEO->URL ?>" style="margin-left: 12px;"><?= $LANGS['viewonvideopage'] ?></a>
</div>
<div class="editor-container">
    <div id="watch-video-container">
        <div id="watch-video" class="">
            <div id="watch-player" style="background: transparent; z-index: 1000;">
                <?php $_VIDEO->show_video(640, 360, true, $LANGS) ?>
            </div>
        </div>
    </div>
    <div id="annotationseditor-container">
        <div class="topBar"><div class="button-shadow"><button type="button" class="yt-ann-button" onclick="publish();"><span class="yt-uix-button-content"><?= $LANGS['publish'] ?></span></button></div><span id="status"></span></div>
        <div id="annotationseditor-container-inside">
        <div id="annotationseditor-loading">
            <span><img src="/img/icn_loading_animated.gif" style="vertical-align: middle;margin-right: 4px;position: relative;top: -1px;"><?= $LANGS['loading'] ?></span>
        </div>
        <div id="annotationseditor-container-inside-items"></div>
        <div class="bottomBar"><button class="addBtn" onclick="addElement('note')"><img class="noteIcon" src="/img/pixel.gif"><img class="plusIcon" src="/img/pixel.gif"></button><button class="addBtn" onclick="addElement('speech')"><img class="speechIcon" src="/img/pixel.gif"><img class="plusIcon" src="/img/pixel.gif"></button><button class="addBtn" onclick="addElement('highlight')"><img class="highlightIcon" src="/img/pixel.gif"><img class="plusIcon" src="/img/pixel.gif"></button></div>
        </div>
    </div>
    <div style="clear: both;"></div>
</div>
<div id="add-link-screen" class="hid">
    <div class="add-link-box">
        <h1><?= $LANGS['addlink'] ?></h1>
        <div><span style="font-weight: bold;color: #d87700;margin-right: 8px;"><?= $LANGS['linktype'] ?></span><div class="link-selection" onclick="openDropdownLink();" id="video"><?= $LANGS['video'] ?></div><div class="link-selection-border" onclick="openDropdownLink();"><img class="yt-uix-button-arrow" src="/img/pixel.gif" alt=""></div><div class="link-selection-dropdown hid">
    <ul>
        <li id="video-sel" onclick="selectLinkType('video',this)"><?= $LANGS['video'] ?></li>
        <li id="playlist-sel" onclick="selectLinkType('playlist',this)"><?= $LANGS['playlist'] ?></li>
        <li id="channel-sel" onclick="selectLinkType('channel',this)"><?= $LANGS['channel'] ?></li>
        <li id="compose-sel" onclick="selectLinkType('compose',this)"><?= $LANGS['composemessage'] ?></li>
        <li id="response-sel" onclick="selectLinkType('response',this)"><?= $LANGS['videoresponseupload'] ?></li>
        <li id="search-sel" onclick="selectLinkType('search',this)"><?= $LANGS['searchquery'] ?></li>
    </ul></div></div>
        <div style="padding: 8px 0;"><input type="text" class="add-link-value" placeholder="<?= $LANGS['video_pl'] ?>"></div>
        <div><span id="validurl" style="color: red; font-size: 11px; opacity: 0;cursor: default;"><?= $LANGS['entervalidurl'] ?></span>
            <div style="display: inline-block;width: auto;float: right;"><button class="yt-uix-button" onclick="cancelLink();" style="margin-right: 8px"><?= $LANGS['cancel'] ?></button><button class="yt-uix-button yt-uix-button-primary" onclick="saveLink();"><?= $LANGS['editsavechanges'] ?></button></div><div style="clear:both"></div></div>
    </div>
</div>
<div class="color-selector hid" id=""><div class="select-color" onclick="selectColor(this)" id="select-white">a</div><div class="select-color" onclick="selectColor(this)" id="select-grey">a</div><div class="select-color" onclick="selectColor(this)" id="select-black">a</div><div class="select-color" onclick="selectColor(this)" id="select-lightblue">a</div><div class="select-color" onclick="selectColor(this)" id="select-red">a</div><div class="select-color" onclick="selectColor(this)" id="select-blue">a</div><div class="select-color" onclick="selectColor(this)" id="select-green">a</div></div>
<style type="text/css">
.profileModifiers {
    padding: 5px 0px;
    border-bottom: 1px solid #ccc;
    text-align: center;
}
.profileModifiers div.first {
    border-left: 0px;
    padding: 0px 10px 0px 2px;
}
.profileModifiers div.subcategory {
    border-left: 1px solid #ccc;
    padding: 0px 10px;
    font-size: 11px;
    display: inline;
}
.profileModifiers .selected {
    font-weight: bold;
}
.thumb {
    border: 3px double #999;
    margin: 5px 5px 2px;
    height: 72px;
    object-fit: cover;
}
.wrapper .yt-button, .wrapper a.yt-button {
    padding: 4px 10px;
    margin:0;
}
.left-column {
    float: left;
    width: 500px;
    margin-bottom: 12px;
}
.right-column {
    float: right;
    margin-bottom: 12px;
}
.savechanges {
    background: #eaeaea;
    padding: 8px 10px;
    border: 1px solid #ccc;
    line-height: 26px;
}
.editheader {
    background: transparent url(/img/mmgrads-vfl38740.gif) repeat-x scroll 0 0;
    padding: 5px 8px;
    font-weight: bold;
    cursor: pointer;
}
.editheader:hover {
    color: #666;
}
.videoinfo {
    border: 1px solid #999;
    margin-top: 10px;
}
.arr {
    background-image: url(/img/master-vfl87445.png);
    background-position: 43px -1393px;
    width: 9px;
    height: 11px;
    margin-right: 4px;
}
.container {
    padding: 8px 10px;
    border-top: 1px solid #999;
}
.infotitle {
    font-weight: bold;
    margin-bottom: 4px;
    color: #333;
}
.information {
    border-bottom: 1px dotted #999;
    padding-bottom: 8px;
    margin-bottom: 8px;
}
.information.last {
    margin: 0;
    border: 0;
}
#video-thumbnail .vimg120 {
    padding: 2px;
    border: 1px solid #999;
}
.submitimage {
    width: 340px;
    float: right;
    padding: 21px 0;
}
.partnerinfo {
    width: 340px;
    float: right;
}
#video-thumbnail .vimg120.new {
    border-color: #ffd300;
    background: #fff3c3;
}
#broadcasting-options .information {
    line-height: 22px;
}
.broadcasttitle {
    font-weight: bold;
    color: #000;
    cursor: pointer;
}
.broadcasttitle:hover {
    color: #666;
}
.broadcastdiv {
    margin-left: 14px;
}
#comments-arr, #ratings-arr {
    transform: rotate(-90deg);
}
.nav-header {
    margin-bottom: 8px;
}
#video-thumbnail .vimg120 {
    width: 120px;
    margin: 0 !important;
}
.edit-video-header {
    border-bottom: 1px solid #999;
    padding: 5px 0;
    float: left;
    width: 100%;
    margin: 8px 0;
    height: 22px;
    margin-bottom: 8px;
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
    function showHideInfo() {
        var x = document.getElementById("video-info");
        var y = document.getElementById("info-arr");
        if (x.style.display === "block") {
            x.style.display = "none";
            y.style.transform = "rotate(-90deg)";
        } else {
            x.style.display = "block";
            y.style.transform = "none";
        }
    }
    function showHideThumbnail() {
        var x = document.getElementById("video-thumbnail");
        var y = document.getElementById("thumb-arr");
        if (x.style.display === "block") {
            x.style.display = "none";
            y.style.transform = "rotate(-90deg)";
        } else {
            x.style.display = "block";
            y.style.transform = "none";
        }
    }
    function showHideBroadcast() {
        var x = document.getElementById("broadcasting-options");
        var y = document.getElementById("broadcast-arr");
        if (x.style.display === "block") {
            x.style.display = "none";
            y.style.transform = "rotate(-90deg)";
        } else {
            x.style.display = "block";
            y.style.transform = "none";
        }
    }
    function showHideDateMap() {
        var x = document.getElementById("date-and-map");
        var y = document.getElementById("datemap-arr");
        if (x.style.display === "block") {
            x.style.display = "none";
            y.style.transform = "rotate(-90deg)";
        } else {
            x.style.display = "block";
            y.style.transform = "none";
        }
    }
    function showHidePrivacy() {
        var x = document.getElementById("privacy");
        var y = document.getElementById("privacy-arr");
        if (x.style.display === "block") {
            x.style.display = "none";
            y.style.transform = "rotate(-90deg)";
        } else {
            x.style.display = "block";
            y.style.transform = "none";
        }
    }
    function showHideComments() {
        var x = document.getElementById("comments");
        var y = document.getElementById("comments-arr");
        if (x.style.display === "block") {
            x.style.display = "none";
            y.style.transform = "rotate(-90deg)";
        } else {
            x.style.display = "block";
            y.style.transform = "none";
        }
    }
    function showHideRatings() {
        var x = document.getElementById("ratings");
        var y = document.getElementById("ratings-arr");
        if (x.style.display === "block") {
            x.style.display = "none";
            y.style.transform = "rotate(-90deg)";
        } else {
            x.style.display = "block";
            y.style.transform = "none";
        }
    }
    function setToday() {
        document.getElementById("month").value = "<?= date("n") ?>";
        document.getElementById("day").value = "<?= date("j") ?>";
        document.getElementById("year").value = "<?= date("Y") ?>";
    }
    function clearDate() {
        document.getElementById("month").value = "0";
        document.getElementById("day").value = "0";
        document.getElementById("year").value = "0";
    }
    function searchLocation() {
        var address = document.getElementById('address').value
        window.open("http://maps.google.com/?q="+address, "_blank");
    }
    function clearLocation() {
        document.getElementById('address').value = "";
    }
    function clearCountry() {
        document.getElementById("country").value = "0";

    }
</script>
<div style="clear:both"></div><h1 style="margin: 0;"><?= $_VIDEO->Info['title'] ?></h1><!-- left column - FOR ADS ONLY IF MY SUBS -->
<div class="edit-video-header">
    <span class="edit-link active"><?= $LANGS['infoandsettings'] ?></span>
    <a class="edit-link" href="/my_videos_annotations?v=<?= $_VIDEO->URL ?>"><?= $LANGS['annotations'] ?></a>
    <!--a href="/my_videos_captions?v=<?= $_VIDEO->URL ?>" class="edit-link"><?= $LANGS['captionsandsubtitles'] ?></a-->
    <a href="/watch?v=<?= $_VIDEO->URL ?>" style="margin-left: 12px;"><?= $LANGS['viewonvideopage'] ?></a>
</div>
<div style="clear: both;"></div>
<?php if (!isset($_GET['analytics']) || isset($_GET['analytics']) && $_GET['analytics'] != "true"): ?>
<form action="/edit_video?v=<?= $_VIDEO->Info["url"] ?>" method="POST" enctype="multipart/form-data">
<div class="left-column" style="overflow:hidden;white-space: nowrap">
            <div class="savechanges">
            <input type="submit" class="yt-uix-button yt-uix-button-primary" name="video_submit" value="<?= $LANGS['editsavechanges'] ?>" style="margin-right:2px"> <?= $LANGS['or'] ?> <a href="/my_videos"><?= $LANGS['editcancel'] ?></a>
            </div>
            <div class="videoinfo">
                <div class="editheader" onclick="showHideInfo()"><img src="/img/pixel.gif" class="arr" id="info-arr"> <?= $LANGS['videoinfo'] ?>
                </div>
                    <div class="container" id="video-info" style="display:block">
                    <div class="information"><div class="infotitle"><?= $LANGS['title'] ?>:</div><input type="text" name="title" value="<?= $_VIDEO->Info["title"]?>" maxlength="100" style="width: 470px;"></div>
                    <div class="information"><div class="infotitle"><?= $LANGS['desc'] ?>:</div><textarea name="description" style="font-family: Arial,sans-serif;width: 470px;resize: vertical;" maxlength="2048" cols="68" rows="6"><?= $_VIDEO->Info["description"] ?></textarea></div>
                    <div class="information"><div class="infotitle"><?= $LANGS['tags'] ?>:</div><textarea name="tags" style="font-family: Arial, sans-serif;width: 470px;resize: vertical;" maxlength="128" cols="68" rows="6"><?= $_VIDEO->Info["tags"] ?></textarea></div>
                    <div class="information last"><div class="infotitle"><?= $LANGS['category'] ?>:</div><select name="category">
                                    <?php foreach ($Video_Category as $ID => $Category) : ?>
                                        <option value="<?= $ID ?>"<?php if ($ID == $_VIDEO->Info["category"]) : ?> selected<?php endif ?>><?= $Category ?></option>
                                    <?php endforeach ?>
                                </select></div>
                    </div>
            </div>
            <div class="videoinfo">
                <div class="editheader" onclick="showHideThumbnail()"><img src="/img/pixel.gif" class="arr" id="thumb-arr"> <?= $LANGS['videothumbnail'] ?>
                </div>
                    <div class="container" id="video-thumbnail" style="display:block">
                    <?php if($_USER->Info["is_partner"]) : ?>
                    <span onclick="document.getElementById('thumbnail-select').click();document.getElementById('thumbnail').classList.add('new');" style="cursor:pointer"><img id="thumbnail" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$_VIDEO->Info["url"].'.jpg')): ?>src="/u/thmp/<?= $_VIDEO->Info["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg120">
                    </span>
                <div class="submitimage"><input type="file" name="image" id="thumbnail-select" style="display:none"><input type="submit" name="change_image" class="yt-button" value="<?= $LANGS['uploadthumbnail'] ?>">
                <div style="font-size: 10px;width: 345px;line-break: auto;white-space: break-spaces;margin-top: 4px;"><?= $LANGS['customthumbdesc'] ?></div>
                    </div>
                <?php else : ?>
                    <span onclick="location.href = '/watch?v=<?= $_VIDEO->Info['url'] ?>'" style="cursor:pointer"><img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$_VIDEO->Info["url"].'.jpg')): ?>src="/u/thmp/<?= $_VIDEO->Info["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg120">
                    </span>
                <div class="partnerinfo"><input type="file" name="image" id="thumbnail-select" style="display:none">
                <div style="font-size: 11px;width: 345px;line-break: auto;white-space: break-spaces;margin-top: 4px;"><h3><?= $LANGS['customthumbtitle'] ?></h3><?= $LANGS['customthumbinfo'] ?></div><a href="/partners" class="yt-button" style="margin-top: 4px;"><?= $LANGS['partnerreadmore'] ?></a>
                    </div>
                    <?php endif ?>
                    </div>
            </div>
            <?php if ($_USER->Info['is_partner'] == 1): ?>
            <div class="videoinfo">
                <div class="editheader" onclick="showHideVideoUpdate()"><img src="/img/pixel.gif" class="arr" id="thumb-arr"> <?= $LANGS['updatevideo'] ?>
                </div>
                    <div class="container" id="update-video" style="display:block">
                        <input type="file" id="video_file" name="video_file" accept="video/mpeg,video/x-ms-wmv,video/avi,video/quicktime,video/mp4,video/m4v"> <input type="submit" name="update_video_file" id="update_video_file" value="<?= $LANGS['updatevideo'] ?>">
                    <br><br><?= $LANGS['updatevideofilesize'] ?>
                    </div>
            </div>
            <?php endif ?>
            <div class="videoinfo">
                <div class="editheader" onclick="showHideBroadcast()"><img src="/img/pixel.gif" class="arr" id="broadcast-arr"> <?= $LANGS['broadcastingoptions'] ?>
                </div>
                    <div class="container" id="broadcasting-options" style="display:block">
                    <div class="information">
                        <div class="broadcasttitle" onclick="showHidePrivacy();"><img src="/img/pixel.gif" class="arr" id="privacy-arr"> <?= $LANGS['privacy'] ?></div>
                        <div class="broadcastdiv" id="privacy" style="display:block"><label style="position:relative;bottom:4px;right:4px"><input type="radio" name="privacy" value="1" style="position:relative;top:2px"<?php if ($_VIDEO->Info["privacy"] == 1) : ?> checked<?php endif ?> /><?= $LANGS['public'] ?> (<?= $LANGS['publicdesc'] ?>)</label><br>
                        <label style="position:relative;bottom:4px;right:4px"><input type="radio" name="privacy" value="3" style="position:relative;top:2px"<?php if ($_VIDEO->Info["privacy"] == 3) : ?> checked<?php endif ?> /><?= $LANGS['unlisted'] ?> (<?= $LANGS['unlisteddesc'] ?>)</label><br>
                        <label style="position:relative;bottom:4px;right:4px"><input type="radio" name="privacy" value="2" style="position:relative;top:2px"<?php if ($_VIDEO->Info["privacy"] == 2) : ?> checked<?php endif ?> /><?= $LANGS['private'] ?> (<?= $LANGS['privatedesc'] ?>)</label></div>
                            </div>
                    <div class="information">
                        <div class="broadcasttitle" onclick="showHideComments();"><img src="/img/pixel.gif" class="arr" id="comments-arr"> <?= $LANGS['statcomments'] ?></div>
                        <div class="broadcastdiv" id="comments" style="display:none"><label style="position:relative;bottom:4px;right:4px"><input type="radio" name="e_comments" value="1" style="position:relative;top:2px"<?php if ($_VIDEO->Info["e_comments"] == 1) : ?> checked<?php endif ?> /><?= $LANGS['allowcomments'] ?></label><br>
                        <label style="position:relative;bottom:4px;right:4px"><input type="radio" name="e_comments" value="2" style="position:relative;top:2px"<?php if ($_VIDEO->Info["e_comments"] == 2) : ?> checked<?php endif ?> /><?= $LANGS['allowfriendcomments'] ?></label><br>
                        <label style="position:relative;bottom:4px;right:4px"><input type="radio" name="e_comments" value="0" style="position:relative;top:2px"<?php if ($_VIDEO->Info["e_comments"] == 0) : ?> checked<?php endif ?> /><?= $LANGS['disablecomments'] ?></label></div></div>
                    <div class="information last" onclick="showHideRatings();" style="padding:0">
                        <div class="broadcasttitle"><img src="/img/pixel.gif" class="arr" id="ratings-arr"> <?= $LANGS['statratings'] ?></div>
                        <div class="broadcastdiv" id="ratings" style="display:none"><label style="position:relative;bottom:4px;right:4px"><input type="radio" name="e_ratings" value="1" style="position:relative;top:2px"<?php if ($_VIDEO->Info["e_ratings"] == 1) : ?> checked<?php endif ?> /><?= $LANGS['allowratings'] ?></label><br>
                        <label style="position:relative;bottom:4px;right:4px"><input type="radio" name="e_ratings" value="0" style="position:relative;top:2px"<?php if ($_VIDEO->Info["e_ratings"] == 0) : ?> checked<?php endif ?> /><?= $LANGS['dontallowratings'] ?></label></div></div>
                    </div>
            </div>
            <div class="savechanges" style="margin-top: 10px">
            <input type="submit" class="yt-uix-button yt-uix-button-primary" name="video_submit" value="<?= $LANGS['editsavechanges'] ?>" style="margin-right:2px"> <?= $LANGS['or'] ?> <a href="/my_videos"><?= $LANGS['editcancel'] ?></a>
            </div>
</div>
<div class="right-column"><iframe id="embedplayer" src="/embed?v=<?= $_VIDEO->URL ?>" width="448" height="382" allowfullscreen scrolling="off" frameborder="0"></iframe>
    <div class="videoinfo">
                <div class="editheader" onclick="showHideDateMap()"><img src="/img/pixel.gif" class="arr" id="datemap-arr"> <?= $LANGS['dateandmap'] ?>
                </div>
                    <div class="container" id="date-and-map" style="display:block;">
                    <div class="information last">
                    <div style="font-size: 12px;font-weight:bold;margin-bottom: 4px;"><?= $LANGS['recordedon'] ?>:</div>
                                <select name="month" id="month">
                                    <option value="0">---</option>
                                    <option value="1" <?php if ($Month == 1) : ?>selected<?php endif ?>><?= $LANGS['january'] ?></option>
                                    <option value="2" <?php if ($Month == 2) : ?>selected<?php endif ?>><?= $LANGS['february'] ?></option>
                                    <option value="3" <?php if ($Month == 3) : ?>selected<?php endif ?>><?= $LANGS['march'] ?></option>
                                    <option value="4" <?php if ($Month == 4) : ?>selected<?php endif ?>><?= $LANGS['april'] ?></option>
                                    <option value="5" <?php if ($Month == 5) : ?>selected<?php endif ?>><?= $LANGS['may'] ?></option>
                                    <option value="6" <?php if ($Month == 6) : ?>selected<?php endif ?>><?= $LANGS['june'] ?></option>
                                    <option value="7" <?php if ($Month == 7) : ?>selected<?php endif ?>><?= $LANGS['july'] ?></option>
                                    <option value="8" <?php if ($Month == 8) : ?>selected<?php endif ?>><?= $LANGS['august'] ?></option>
                                    <option value="9" <?php if ($Month == 9) : ?>selected<?php endif ?>><?= $LANGS['september'] ?></option>
                                    <option value="10" <?php if ($Month == 10) : ?>selected<?php endif ?>><?= $LANGS['october'] ?></option>
                                    <option value="11" <?php if ($Month == 11) : ?>selected<?php endif ?>><?= $LANGS['november'] ?></option>
                                    <option value="12" <?php if ($Month == 12) : ?>selected<?php endif ?>><?= $LANGS['december'] ?></option>
                                </select>
                                <select name="day" id="day">
                                    <option value="0">---</option>
                                    <?php for ($x = 1; $x <= 31; $x++) : ?>
                                    <option value="<?= $x ?>" <?php if ($Day == $x) : ?>selected<?php endif ?>><?= $x ?></option>
                                <?php endfor ?>
                                </select>
                                <select name="year" id="year">
                                    <option value="0">---</option>
                                    <?php for($x = date("Y");$x >= 1910;$x--) : ?>
                                    <option value="<?= $x ?>" <?php if ($Year == $x) : ?>selected<?php endif ?>><?= $x ?></option>
                                <?php endfor ?>
                                </select>
                                <a href="javascript:void(0)" class="yt-button" style="padding: 2px 10px;" onclick="setToday()"><?= $LANGS['timetoday'] ?></a>&nbsp;
                                <a href="javascript:void(0)" class="yt-button" style="padding: 2px 10px;" onclick="clearDate()"><?= $LANGS['clear'] ?></a>
                            </div>
                            <div class="information last">
                                <div style="font-size: 12px;font-weight:bold;margin-bottom: 4px;"><?= $LANGS['addressrecorded'] ?>:</div>
                                <input type="text" id="address" name="address" value="<?= $_VIDEO->Info["address"]?>" maxlength="100" style="width: 250px;">
                                <a href="javascript:void(0)" class="yt-button" style="padding: 2px 10px;" onclick="searchLocation()"><?= $LANGS['search'] ?></a>&nbsp;
                                <a href="javascript:void(0)" class="yt-button" style="padding: 2px 10px;" onclick="clearLocation()"><?= $LANGS['clear'] ?></a>
                            </div>
                            <div class="information last">
                                <div style="font-size: 12px;font-weight:bold;margin-bottom: 4px;"><?= $LANGS['country'] ?>:</div>
                                <select id="country" name="country">
                                <option value="0">---</option>
                                <?php foreach ($Countries as $val => $name) : ?>
                                    <option value="<?= $val ?>"<?php if ($CheckCountry == $val) : ?> selected<?php endif ?>><?= $name ?></option>
                                <?php endforeach ?>
                            </select>
                                <a href="javascript:void(0)" class="yt-button" style="padding: 2px 10px;" onclick="clearCountry()"><?= $LANGS['clear'] ?></a>
                            </div>
 
                            </div>
            </div>
</div>
</form>
<?php else: ?>
<div style="margin:0;width:960px">
                        <style>
                            #chartdiv {
                                width   : 100%;
                                height  : 300px;
                            }
                            #chartdiv[title="JavaScript charts"] {
                                display: none !important;
                            }
                        </style>
                        <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
                        <script src="https://www.amcharts.com/lib/3/serial.js"></script>
                        <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
                        <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
                        <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
                        <div class="a_box">
                            <div style="font-weight:bold;font-size:14px;margin-bottom:8px;margin-top:4px;"><?= $LANGS['viewchart'] ?></div>
                            <script>
                                var chart = AmCharts.makeChart("chartdiv", {
                                    "type": "serial",
                                    "theme": "light",
                                    "marginRight": 10,
                                    "marginLeft": 10,
                                    "autoMarginOffset": 20,
                                    "mouseWheelZoomEnabled":true,
                                    "dataDateFormat": "YYYY-MM-DD",
                                    "valueAxes": [{
                                        "id": "v1",
                                        "axisAlpha": 0,
                                        "position": "left",
                                        "ignoreAxisWidth":true
                                    }],
                                    "balloon": {
                                        "borderThickness": 0,
                                        "shadowAlpha": 1,
                                    },
                                    "graphs": [{
                                        "id": "g1",
                                        "balloon":{
                                            "drop":false,
                                            "adjustBorderColor":false,
                                            "color":"#ffffff"
                                        },
                                        "bullet": "square",
                                        "bulletBorderAlpha": 1,
                                        "bulletColor": "#67b7dc",
                                        "bulletSize": 6,
                                        "hideBulletsCount": 50,
                                        "lineThickness": 2,
                                        "title": "blue line",
                                        "useLineColorForBulletBorder": true,
                                        "valueField": "value",
                                        "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
                                    }],
                                    "chartScrollbar": {
                                        "graph": "g1",
                                        "oppositeAxis":false,
                                        "offset":30,
                                        "scrollbarHeight": 80,
                                        "backgroundAlpha": 0,
                                        "selectedBackgroundAlpha": 0.1,
                                        "selectedBackgroundColor": "#888888",
                                        "graphFillAlpha": 0,
                                        "graphLineAlpha": 1,
                                        "selectedGraphFillAlpha": 0,
                                        "selectedGraphLineAlpha": 1,
                                        "autoGridCount":true,
                                        "color":"#AAAAAA"
                                    },
                                    "chartCursor": {
                                        "pan": true,
                                        "valueLineEnabled": true,
                                        "valueLineBalloonEnabled": true,
                                        "cursorAlpha":1,
                                        "cursorColor":"#258cbb",
                                        "limitToGraph":"g1",
                                        "valueLineAlpha":0.2,
                                        "valueZoomable":true
                                    },
                                    "valueScrollbar":{
                                        "oppositeAxis":false,
                                        "offset":50,
                                        "scrollbarHeight":10
                                    },
                                    "categoryField": "date",
                                    "categoryAxis": {
                                        "parseDates": true,
                                        "dashLength": 1,
                                        "minorGridEnabled": true
                                    },
                                    "export": {
                                        "enabled": false
                                    },
                                    "dataProvider": [
                                        <?php if ($Daily_Views) : ?>
                                        <?php foreach ($Daily_Views as $View) : ?>
                                        {
                                            "date": "<?= $View["submit_date"] ?>",
                                            "value": <?= $View["views"] ?>
                                        },
                                        <?php endforeach ?>
                                        <?php else : ?>
                                        {
                                            "date": "0",
                                            "value": 0
                                        },
                                        <?php endif ?>
                                    ]
                                });

                                chart.addListener("rendered", zoomChart);

                                zoomChart();

                                function zoomChart() {
                                    chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
                                }
                            </script>

                            <!-- HTML -->
                            <div id="chartdiv"></div>
                            <style>
                                a[title="JavaScript charts"] {
                                    display: none !important;
                                }
                            </style>
                    </div>
<?php endif?>
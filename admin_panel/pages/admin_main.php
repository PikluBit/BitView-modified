<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
use function PHP81_BC\strftime;
if (!$_USER->Logged_In || (!$_USER->Is_Moderator && !$_USER->Is_Admin)) {
    header("location: /");
    exit();
}
?>
<div style="float: left;width:59%">
    <style>
        #chartdiv {
            width: 96%;
            height: 300px;
            padding: 0px;
            margin-bottom: 5px;
            margin-left: 8px;
        }
        #chartdiv[title="JavaScript charts"] {
            display: none !important;
        }
        #chartdiv2 {
            width: 96%;
            height: 300px;
            padding: 0px;
            margin-bottom: 5px;
            margin-left: 8px;
        }
        #chartdiv2[title="JavaScript charts"] {
            display: none !important;
        }
        .amcharts-main-div * {
            font-family: Arial, sans-serif!important;
        }
    </style>
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <div class="a_box">
        <div class="a_box_title">View Chart</div>
        <script>
                                var chart1 = AmCharts.makeChart("chartdiv", {
                                    "type": "serial",
                                    "theme": "none",
                                    "marginLeft": 0,
                                    "marginRight": 0,
                                    "marginTop": 15,
                                    "marginBottom": 0,
                                    "autoMarginOffset": 0,
                                    "mouseWheelZoomEnabled":true,
                                    "dataDateFormat": "YYYY-MM-DD",
                                    "valueAxes": [{
                                        "id": "v1",
                                        "axisAlpha": 0,
                                        "position": "right",
                                        "ignoreAxisWidth":false,
                                        "tickLength":0,
                                        "inside": true
                                    }],
                                    "balloon": {
                                        "borderThickness": 0,
                                        "shadowAlpha": 0,
                                    },
                                    "graphs": [{
                                        "id": "g1",
                                        "balloon":{
                                            "drop":false,
                                            "adjustBorderColor":false,
                                            "color":"#ffffff",
                                            "type": "smoothedLine"
                                        },
                                        "lineColor": "#30831B",
                                        "bullet": "none",
                                        "fillAlphas": 0.2,
                                        "bulletBorderAlpha": 1,
                                        "bulletColor": "#085800",
                                        "bulletSize": 6,
                                        "hideBulletsCount": 50,
                                        "lineThickness": 1.5,
                                        "title": "blue line",
                                        "useLineColorForBulletBorder": true,
                                        "valueField": "value",
                                        "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
                                    }],
                                    "chartScrollbar": {
                                        "graph": "g1",
                                        "oppositeAxis":false,
                                        "dragIcon": "/img/dragIcon.svg",
                                        "dragIconWidth": 11,
                                        "dragIconHeight": 17,
                                        "offset":30,
                                        "scrollbarHeight": 50,
                                        "backgroundAlpha": 0.05,
                                        "selectedBackgroundAlpha": 1,
                                        "backgroundColor": "#dddddd",
                                        "selectedBackgroundColor": "#fff",
                                        "graphFillAlpha": 0.1,
                                        "graphLineAlpha": 0.6,
                                        "selectedGraphLineColor": "#3399fa",
                                        "selectedGraphFillColor": "#EEF5FD",
                                        "selectedGraphFillAlpha": 1,
                                        "selectedGraphLineAlpha": 1,
                                        "autoGridCount":true,
                                        "color":"#000",
                                        "gridColor":"#ddd",
                                    },
                                    "chartCursor": {
                                        "pan": true,
                                        "valueLineEnabled": true,
                                        "valueLineBalloonEnabled": true,
                                        "cursorAlpha":1,
                                        "cursorColor":"#085800",
                                        "limitToGraph":"g1",
                                        "valueLineAlpha":0.2,
                                        "valueZoomable":true
                                    },
                                    "categoryField": "date",
                                    "categoryAxis": {
                                        "parseDates": true,
                                        "equalSpacing": true,
                                        "dashLength": 0,
                                        "minorGridEnabled": true,
                                        "boldPeriodBeginning": true
                                    },
                                    "export": {
                                        "enabled": false
                                    },
                                    "dataProvider": [
                                        <?php foreach ($Views_Stats as $View) : ?>
                                        {
                                            "date": "<?= $View["submit_date"] ?>",
                                            "value": <?= $View["views"] ?>
                                        },
                                    <?php endforeach ?>
                                        ]
                                });

                                chart1.addListener("rendered", zoomChart);
                            </script>
        <!-- HTML -->
        <div id="chartdiv"></div>
    </div>
    <div class="a_box">
        <div class="a_box_title">User Chart</div>

        <script>
            var chart = AmCharts.makeChart("chartdiv2", {"type": "serial",
                "theme": "none",
                "marginLeft": 0,
                "marginRight": 0,
                "marginTop": 15,
                "marginBottom": 0,
                "autoMarginOffset": 0,
                "mouseWheelZoomEnabled":true,
                "dataDateFormat": "YYYY-MM-DD",
                "valueAxes": [{
                    "id": "v1",
                    "axisAlpha": 0,
                    "position": "right",
                    "ignoreAxisWidth":false,
                    "tickLength":0,
                    "inside": true
                }],
                "balloon": {
                    "borderThickness": 0,
                    "shadowAlpha": 0,
                },
                "graphs": [{
                    "id": "g1",
                    "balloon":{
                        "drop":false,
                        "adjustBorderColor":false,
                        "color":"#ffffff",
                        "type": "smoothedLine"
                    },
                    "lineColor": "#30831B",
                    "bullet": "none",
                    "fillAlphas": 0.2,
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#085800",
                    "bulletSize": 6,
                    "hideBulletsCount": 50,
                    "lineThickness": 1.5,
                    "title": "blue line",
                    "useLineColorForBulletBorder": true,
                    "valueField": "value",
                    "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
                }],
                "chartScrollbar": {
                    "graph": "g1",
                    "oppositeAxis":false,
                    "dragIcon": "/img/dragIcon.svg",
                    "dragIconWidth": 11,
                    "dragIconHeight": 17,
                    "offset":30,
                    "scrollbarHeight": 50,
                    "backgroundAlpha": 0.05,
                    "selectedBackgroundAlpha": 1,
                    "backgroundColor": "#dddddd",
                    "selectedBackgroundColor": "#fff",
                    "graphFillAlpha": 0.1,
                    "graphLineAlpha": 0.6,
                    "selectedGraphLineColor": "#3399fa",
                    "selectedGraphFillColor": "#EEF5FD",
                    "selectedGraphFillAlpha": 1,
                    "selectedGraphLineAlpha": 1,
                    "autoGridCount":true,
                    "color":"#000",
                    "gridColor":"#ddd",
                },
                "chartCursor": {
                    "pan": true,
                    "valueLineEnabled": true,
                    "valueLineBalloonEnabled": true,
                    "cursorAlpha":1,
                    "cursorColor":"#085800",
                    "limitToGraph":"g1",
                    "valueLineAlpha":0.2,
                    "valueZoomable":true
                },
                "categoryField": "date",
                "categoryAxis": {
                    "parseDates": true,
                    "equalSpacing": true,
                    "dashLength": 0,
                    "minorGridEnabled": true,
                    "boldPeriodBeginning": true
                },
                "export": {
                    "enabled": false
                },
                "dataProvider": [
                    <?php foreach ($Users_Stats as $User) : ?>
                    {
                        "date": "<?= $User["registration_date"] ?>",
                        "value": <?= $User["amount"] ?>
                    },
                    <?php endforeach ?>
                ]
            });
            chart.addListener("rendered", zoomChart);
        </script>

        <!-- HTML -->
        <div id="chartdiv2"></div>
    </div>
    <div class="a_box">
        <div class="a_box_title">Blog Posts</div>
        <form action="/admin_panel/?page=main" autocomplete="off" method="post" style="border-bottom:1px solid #CCC;padding:8px;margin:0 0 5px 0">
            <input type="text" name="blog_title" placeholder="Title" size="66" maxlength="128" style="border:1px solid #999; font-family: Arial, sans-serif;margin-bottom: 6px; padding: 1px 4px;font-size: 12px;width: 98%">
            <textarea name="blog_content" cols="64" rows="10" placeholder="Text" maxlength="16777215" style="resize: vertical;border:1px solid #999; font-family: Arial, sans-serif;margin-bottom: 6px;font-size: 12px;padding: 4px;width: 98%"></textarea>
            <div style="font-size: 11px;margin-bottom: 4px;">HTML tags supported. Line breaks will be added to the blog post automatically.</div>
            <input type="submit" name="blog_submit" value="Submit" class="yt-button" style="margin: 0;padding: 0.3em 0.8333em;font-size: 13px;">
        </form>
        <h2 style="margin-top:0;margin-bottom: 0;padding: 4px 5px 9px 10px;border-bottom: 1px solid #ccc;">Previous Blog Posts</h2>
        <div style="max-height:174px;overflow-y:auto; padding: 10px;">
                <?php foreach ($Blog_Posts as $Blog_Post) : ?>
                    <div style="margin-bottom: 6px;border-bottom: 1px solid #ccc;padding-bottom: 6px;">
                        <div><a href="/blog#<?= $Blog_Post['id'] ?>" style="font-weight: bold;"><?= $Blog_Post["title"] ?></a></div>
                        <div style="color:#333;margin: 3px 0;"><?= strftime("%A, %B %e, %Y", strtotime((string) $Blog_Post["submit_on"])); ?></div>
                        <div><a href="/admin_panel/?page=main&db=<?= $Blog_Post["id"] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Delete</a></div>
                    </div>
                <?php endforeach ?>
        </div>
    </div>
</div>
<div style="float: left;width:39%;margin-left:2%">
    <div class="a_box">
        <div class="a_box_title">Site Stats <a id="view-all" href="/admin_panel/?page=stats">(view all)</a></div>
        <div style="max-height:500px;overflow-y:auto;padding: 6px 10px;">
            <table width="100%" border="0px">
                <tr>
                    <td width="105"><b>Users:</b></td>
                    <td><?= number_format($Stats2["all_users"]) ?> (<b><?= number_format($Stats3["banned_users"]) ?></b>)</td>
                </tr>
                <tr>
                    <td><b>Videos:</b></td>
                    <td><?= number_format($Stats["all_videos"]) ?></td>
                </tr>
                <tr>
                    <td><b>Total Views:</b></td>
                    <td><?= number_format($Stats["all_views"]) ?></td>
                </tr>
                <tr>
                    <td><b>Total Comments:</b></td>
                    <td><?= number_format($Stats["all_comments"]) ?></td>
                </tr>
                <tr>
                    <td><b>Total Favorites:</b></td>
                    <td><?= number_format($Stats["all_favorites"]) ?></td>
                </tr>
                <tr>
                    <td><b>Total Ratings:</b></td>
                    <td><?= number_format($Ratings) ?></td>
                </tr>
                <tr>
                    <td><b>Total Friends:</b></td>
                    <td><?= number_format($Friends) ?></td>
                </tr>
                <tr>
                    <td><b>Total Subs:</b></td>
                    <td><?= number_format($Subscriptions) ?></td>
                </tr>
                <tr>
                    <td><b>Total Bulletins:</b></td>
                    <td><?= number_format($Bulletins + $Bulletins_2) ?></td>
                </tr>
                <tr>
                    <td><b>Videos Converting:</b></td>
                    <td><?= number_format($ConvertStat) ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="a_box">
        <div class="a_box_title">Server Information <a id="view-all" href="/admin_panel/?page=stats">(view all)</a></div>
        <div style="max-height:500px;overflow-y:auto;padding: 6px 10px;">
            <table width="100%">
                <tr>
                    <td style="width:100px"><b>PHP Version:</b></td>
                    <td><?= phpversion() ?></td>
                </tr>
                <tr>
                    <td><b>Max POST Size:</b></td>
                    <td><?= ini_get("post_max_size") ?></td>
                </tr>
                <tr>
                    <td><b>Max File Size:</b></td>
                    <td><?= ini_get("upload_max_filesize") ?></td>
                </tr>
                <tr>
                    <td><b>Max Exec. Time:</b></td>
                    <td><?= ini_get("max_execution_time") ?>s</td>
                </tr>
                <tr>
                    <td><b>Max Input Time:</b></td>
                    <td><?= ini_get("max_input_time") ?>s</td>
                </tr>
                <tr>
                    <td><b>Server Protocol:</b></td>
                    <td><?= $_SERVER["SERVER_PROTOCOL"] ?></td>
                </tr>
                <tr>
                    <td><b>Disk Used:</b></td>
                    <td><?= round((@disk_total_space("/var/www") - @disk_free_space("/var/www")) / 1048576 / 1024,2) ?>GB / <?= round(@disk_total_space("/var/www") / 1048576 / 1024) ?>GB</td>
                </tr>
            </table>
        </div>
    </div>
    <div style="float:left;width:100%">
        <div class="a_box">
            <div class="a_box_title">Latest Videos</div>
            <div style="max-height:700px;overflow-y:auto; padding: 5px;">
                    <?php foreach ($Recent_Videos as $Video) : ?>
                        <div style="padding: 0 0 16px 0">
                            <div class="videothumb" style="padding:0"><a href="/watch?v=<?= $Video["url"] ?>"><img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> width="61"></a></div>
                            <div class="videotitle"><a href="/watch?v=<?= $Video["url"] ?>"><?= mb_substr((string) $Video["title"], 0, 30) ?></a></div>
                            <div style="font-size: 10px; color: #333; margin-top: 1px;"><a href="/user/<?= $Video["uploaded_by"] ?>"><?= displayname($Video["uploaded_by"]) ?></a> · <?= date("M d, Y", strtotime((string) $Video["uploaded_on"])) ?> · <?= $Video["views"] ?> views</div>
                            <div><a href="/admin_panel/?page=videos&ve=<?= $Video["url"] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Video</a> <a href="/admin_panel/?page=users&ue=<?= $Video["uploaded_by"] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Uploader</a></div>
                            <div style="clear:both"></div>
                        </div>
                    <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
<div style="clear:both"></div>
<div style="float:left;width:100%">
    <div class="a_box">
        <div class="a_box_title">Latest Comments</div>
        <div style="max-height:500px;overflow-y:auto; padding: 5px;">
        <script>
            function delete_comment(id) {
                document.getElementById(id).outerHTML = "";
            }
        </script>
                <?php foreach ($Comments as $Comment) : ?>
                    <div style="margin-bottom:10px" id="<?= $Comment['id'] ?>">
                        <div class="videothumb" style="padding:0; width: 72px;"><a href="/watch?v=<?= $Comment["url"] ?>"><img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Comment["url"].'.jpg')): ?>src="/u/thmp/<?= $Comment["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> width="72"></a></div>
                        <?php $Title = $DB->execute("SELECT * FROM videos WHERE url = :URL", true, [":URL" => $Comment["url"]]); ?>
                        <div style="padding:0"><a href="/admin_panel/?page=users&ue=<?= $Comment["by_user"] ?>" style="font-weight: bold;"><?= $Comment["by_user"] ?></a> commented on <a href="/watch?v=<?= $Comment["url"] ?>" style="font-weight: bold;"><?= $Title['title'] ?></a> <span style="font-size: 11px;color: #666;">(<?= get_time_ago($Comment['submit_on']) ?>)</span><div style="font-style: italic;margin: 4px 0;">"<?= nl2br((string) $Comment["content"]) ?>"</div></div>
                        <div><a href="/a/delete_video_comment?id=<?= $Comment['id'] ?>" target="_blank" onclick="delete_comment(<?= $Comment['id'] ?>);" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Delete Comment</a> <a href="/admin_panel/?page=users&ue=<?= $Comment['by_user'] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Comment Author</a> <a href="/admin_panel/?page=users&ue=<?= $Title['uploaded_by'] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Video Uploader</a> <a href="/admin_panel/?page=videos&ve=<?= $Comment['url'] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Video</a></div>
                    </div>
                <?php endforeach ?>
        </div>
    </div>
</div>
<div style="clear:both"></div>

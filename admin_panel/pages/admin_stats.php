<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
if (!$_USER->Logged_In || (!$_USER->Is_Moderator && !$_USER->Is_Admin)) {
    header("location: /");
    exit();
}
?>
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
        <div class="a_box_title">User Chart <a id="view-all" style="margin-left: 6px;" href="/admin_panel/?page=stats">Daily</a> · <a id="view-all" href="/admin_panel/?page=stats&view_u=e">Evolution</a></div>

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
<div style="float: left;width:49%;">
    <div class="a_box">
        <div class="a_box_title">Site Stats</div>
        <div style="max-height:500px;overflow-y:auto">
            <table width="100%" border="0px">
                <tr>
                    <td width="50%"><b>Users:</b></td>
                    <td><?= number_format($Stats2["all_users"] ?? 0) ?> (<b><?= number_format($Stats3["banned_users"] ?? 0) ?></b>)</td>
                </tr>
                <tr>
                    <td><b>Videos:</b></td>
                    <td><?= number_format($Stats["all_videos"] ?? 0) ?></td>
                </tr>
                <tr>
                    <td><b>Playlists:</b></td>
                    <td><?= number_format($Playlists ?? 0) ?></td>
                </tr>
                <tr>
                    <td><b>Total Views:</b></td>
                    <td><?= number_format($Stats["all_views"] ?? 0) ?></td>
                </tr>
                <tr>
                    <td><b>Total Comments:</b></td>
                    <td><?= number_format($Stats["all_comments"] ?? 0) ?></td>
                </tr>
                <tr>
                    <td><b>Total Channel Comments:</b></td>
                    <td><?= number_format($Channel_Comments ?? 0) ?></td>
                </tr>
                <tr>
                    <td><b>Total Comment Votes:</b></td>
                    <td><?= number_format($Comment_Votes ?? 0) ?></td>
                </tr>
                <tr>
                    <td><b>Total Video Responses:</b></td>
                    <td><?= number_format($Responses ?? 0) ?></td>
                </tr>
                <tr>
                    <td><b>Total Favorites:</b></td>
                    <td><?= number_format($Stats["all_favorites"] ?? 0) ?></td>
                </tr>
                <tr>
                    <td><b>Total Ratings:</b></td>
                    <td><?= number_format($Ratings ?? 0) ?></td>
                </tr>
                <tr>
                    <td><b>Total Friends:</b></td>
                    <td><?= number_format($Friends ?? 0) ?></td>
                </tr>
                <tr>
                    <td><b>Total Subscriptions:</b></td>
                    <td><?= number_format($Subscriptions ?? 0) ?></td>
                </tr>
                <tr>
                    <td><b>Total Bulletins:</b></td>
                    <td><?= number_format((($Bulletins ?? 0) + ($Bulletins_2 ?? 0))) ?></td>
                </tr>
                <tr>
                    <td><b>Total Groups:</b></td>
                    <td><?= number_format($Groups ?? 0) ?></td>
                </tr>
                <tr>
                    <td><b>Total Messages:</b></td>
                    <td><?= number_format($Messages ?? 0) ?></td>
                </tr>
                <tr>
                    <td><b>Linked Videos:</b></td>
                    <td><?= number_format($Links ?? 0) ?></td>
                </tr>
                <tr>
                    <td><b>Total Searches:</b></td>
                    <td><?= number_format($Searches ?? 0) ?> <span style="font-size: 10px;color:#666">(since October 9th, 2023)</span></td>
                </tr>
                <tr>
                    <td><b>Average Views per Video:</b></td>
                    <td><?= number_format($AvgViews ?? 0) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div style="float: left;width:49%;margin-left:1%">
    <div class="a_box">
        <div class="a_box_title">Server Information</div>
        <div style="max-height:500px;overflow-y:auto">
            <?php
            $__disk_total = @disk_total_space("/var/www");
            $__disk_free = @disk_free_space("/var/www");
            $__disk_total_gb = $__disk_total ? ($__disk_total / 1048576 / 1024) : 0;
            $__disk_used_gb = ($__disk_total && $__disk_free) ? (($__disk_total - $__disk_free) / 1048576 / 1024) : 0;
            $__disk_pct = ($__disk_total_gb > 0) ? (($__disk_used_gb / $__disk_total_gb) * 100) : 0;
            ?>
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
                    <td><?= number_format($__disk_used_gb, 2) ?>GB / <?= number_format($__disk_total_gb, 2) ?>GB</td>
                </tr>
                <tr><style>.barempty {
                        height: 8px;
                        background-image: url(/img/insight_bars.png);
                        width: 340px;
                        float: right;
                    }
                    .barfull {
                        height: 8px;
                        background-image: url(/img/insight_bars.png);
                        background-position: 0 -16px;
                        width: 340px;
                        float: left;
                    }
                    </style>
                    <td colspan="2"><div class="barempty"><div class="barfull" style="width: <?= max(0, min(100, round($__disk_pct, 2))) ?>%;"></div></div></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div style="clear:both"></div>
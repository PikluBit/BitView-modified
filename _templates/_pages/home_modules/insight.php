<?php use function PHP81_BC\strftime; ?>
<style>
#chartdiv {
    width   : 100%;
    height  : 300px;
    border  : 1px solid #000;
    margin-bottom: 6px;
}
#chartdiv1 {
    width   : 100%;
    height  : 250px;
}
#chartdiv2 {
    width   : 100%;
    height  : 300px;
    border  : 1px solid #000;
}
#chartdiv3 {
    width   : 100%;
    height  : 180px;
}
#chartdivpie {
    width   : 100%;
    height  : 115px;
}
#chartdivmap {
    width   : 100%;
    height  : 220px;
    border  : 1px solid #000;
}
.amcharts-main-div * {
    font-family: Arial, sans-serif!important;
}
#chartdiv[title="JavaScript charts"] {
    display: none !important;
}
a[title="Interactive JavaScript maps"] {
    display: none !important;
}
a[title="JavaScript charts"] {
    display: none !important;
}
rect[aria-label="Zoom chart using cursor arrows"] {
    stroke-opacity: 1;
    stroke-width: 1px;
}
#daily-views {
    width: 50%;
    float: left;
}
#my-videos {
    width: 50%;
    float: left;
}
#demographics {
    width: 50%;
    float: left;
}
.element {
    height: 16px;
    line-height: 16px;
}
.barempty {
    height: 8px;
    background-image: url(/img/insight_bars.png);
    width: 150px;
    float: right;
    margin: 4px 0;
    margin-left: 6px;
}
.barfull {
    height: 8px;
    background-image: url(/img/insight_bars.png);
    background-position: 0 -16px;
    width: 150px;
    float: left;
}
</style>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/ammap.js"></script>
<script src="https://www.amcharts.com/lib/3/maps/js/worldLow.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<div class="page-heading">
                <div>
                    <div id="my-account-header">
                        <h1>
                            <span class="yt-menulink yt-menulink-primary" id="" style="" onmouseenter="this.className += ' yt-menulink-primary-hover';" onmouseleave="this.className = this.className.replace(' yt-menulink-primary-hover', '');"><a class="yt-menulink-btn yt-button yt-button-primary" href="/my_account" onclick=""><?= $LANGS['myaccount'] ?></a><a class="yt-menulink-arr" href="/my_account" onclick=""></a>
                                <ul class="yt-menulink-menu">
                                    <li><a href="/inbox" onclick=""><?= $LANGS['inbox'] ?></a></li>
                                    <li><a href="/my_videos" onclick=""><?= $LANGS['vidsfavs'] ?></a></li>
                                    <li><a href="/my_subscriptions" onclick=""><?= $LANGS['subscriptions'] ?></a></li>
                                    <li><a href="/address_book" onclick="">Address Book</a></li>
                                    <li><a href="/my_account" onclick=""><?= $LANGS['accountsettings'] ?></a></li>
                                    <li><a href="/user/<?= $_USER->Username ?>" onclick=""><?= $LANGS['mychannel'] ?></a></li>
                                    <li><a href="/insight" onclick="">Insight: Statistics and Data</a></li>
                                </ul>
                            </span>
                            &nbsp;<span class="subSep">/</span>&nbsp;
                            <span><?= $LANGS['insight'] ?></span>
                        </h1>
                    </div>
                </div>
</div><!-- left column - FOR ADS ONLY IF MY SUBS -->
<div id="nav-pane">
                <div class="header">
                </div>
                <div id="list-pane">
                    <div class="folder<?php if (!$_GET['page']):?> selected<?php endif?>"><a class="name" href="/insight">Channel</a></div>
                    <div class="subfolder channel-subfolder" style="text-decoration: none;background-color:#d6e1f5;"><a class="name" href="/insight">Summary</a></div>
                    <div class="subfolder channel-subfolder" style="text-decoration: none;"><a class="name" href="/insight">Views</a></div>
                    <div class="subfolder channel-subfolder" style="text-decoration: none;"><a class="name" href="/insight">Demographics</a></div>
                    <div class="subfolder channel-subfolder" style="text-decoration: none;"><a class="name" href="/insight">Community</a></div>
                </div>
            </div>
                            <div id="view-pane" style="margin-bottom: 10px;    margin-top: 10px;">
                <div class="header yt2009-sub-header">
                    <div class="pager"></div>
                    <h2>Summary<div style="width: 687px;text-align: right;display: inline-block;"><span class="yt-menubutton yt-menubutton-primary" id="" style="" onmouseenter="this.className += ' yt-menubutton-primary-hover';" onmouseleave="this.className = this.className.replace(' yt-menubutton-primary-hover', '');"><a class="yt-menubutton-btn yt-button yt-button-primary" href="#" onclick=""><span><?php if ($_GET['d'] == "w" || !$_GET['d']): ?><?php setlocale(LC_TIME, $LANGS['languagecode']); echo strftime($LANGS['shorttimeformat'], time_machine(strtotime(date('Y-m-d', strtotime("-1 week"))))); ?><?php elseif ($_GET['d'] == "m"): ?><?php setlocale(LC_TIME, $LANGS['languagecode']); echo strftime($LANGS['shorttimeformat'], time_machine(strtotime(date('Y-m-d', strtotime("-1 month"))))); ?><?php elseif ($_GET['d'] == "d"): ?><?php setlocale(LC_TIME, $LANGS['languagecode']); echo strftime($LANGS['shorttimeformat'], time_machine(strtotime(date('Y-m-d', strtotime("-1 day"))))); ?><?php elseif ($_GET['d'] == "a"): ?><?php setlocale(LC_TIME, $LANGS['languagecode']); echo strftime($LANGS['shorttimeformat'], time_machine(strtotime(date('Y-m-d', strtotime((string) $_USER->Info['registration_date']))))); ?><?php endif?> - <?php setlocale(LC_TIME, $LANGS['languagecode']); echo strftime($LANGS['shorttimeformat'], time_machine(strtotime(date('Y-m-d')))); ?></span></a><a class="yt-menubutton-arr yt-button yt-button-primary" href="#" onclick=""><button></button><span></span></a>
                            <ul class="yt-menubutton-menu" style="left:0;top: 1.4em;">
                                <li><a href="/insight?d=d"><?= $LANGS['timetoday'] ?></a></li>
                                <li><a href="/insight?d=w"><?= $LANGS['timeweek'] ?></a></li>
                                <li><a href="/insight?d=m"><?= $LANGS['timemonth'] ?></a></li>
                                <li><a href="/insight?d=a"><?= $LANGS['alltime'] ?></a></li>
                            </ul>
                        </span></div></h2>
                    
                </div>
                <div class="splitter">
                    <div class="view">
                        <div class="settings">
                            <div class="search">
                            </div>
                        </div>
                                <div id="video_grid" class="browseGridView marT10">
                                    <style>
                                        g[transform="translate(230,28)"] { display: none;}
                                    </style>
                                    <?php if (!$_GET['page']): ?>
                                        <div style="height: 640px;">
                                        <div id="daily-views">
                                            <h2 style="color: #03c;">Views</h2>
                                            <span style="color: #666;">How many views are my videos getting?</span>
                                            <script>
                                var chart1 = AmCharts.makeChart("chartdiv1", {
                                    "type": "serial",
                                    "theme": "none",
                                    "marginLeft": 0,
                                    "autoMarginOffset": 0,
                                    "dataDateFormat": "YYYY-MM-DD",
                                    "zoomOutButtonImageSize": 0,
                                    "zoomOutText": "",
                                    "valueAxes": [{
                                        "id": "v1",
                                        "axisAlpha": 1,
                                        "axisColor": "#999",
                                        "position": "left",
                                        "ignoreAxisWidth":false,
                                        "tickLength":3,
                                        "inside": false,
                                        "color": "#999" 
                                    }],
                                    "graphs": [{
                                        "id": "g1",
                                        "lineColor": "#30831B",
                                        "fillAlphas": 0.2,
                                        "lineThickness": 1.5,
                                        "title": "blue line",
                                        "valueField": "value",
                                    }],
                                    "categoryField": "date",
                                    "categoryAxis": {
                                        "parseDates": true,
                                        "equalSpacing": true,
                                        "dashLength": 0,
                                        "minorGridEnabled": true,
                                        "boldPeriodBeginning": false,
                                        "axisColor": "#999",
                                        "color": "#999",
                                        "gridPosition": "start",
                                        "dateFormats": [{"period":"fff","format":"JJ:NN:SS"},
                                            {"period":"ss","format":"JJ:NN:SS"},
                                            {"period":"mm","format":"JJ:NN"},
                                            {"period":"hh","format":"JJ:NN"},
                                            {"period":"DD","format":"M/D/YY"},
                                            {"period":"WW","format":"M/D/YY"},
                                            {"period":"MM","format":"M/D/YY"},
                                            {"period":"YYYY","format":"YYYY"}]
                                    },
                                    "export": {
                                        "enabled": false
                                    },
                                    "dataProvider": [
                                        <?php if ($Daily_Views) : ?>
                                        <?php foreach ($Daily_Views as $View) : ?>
                                        {
                                            "date": "<?= $View["Date"] ?>",
                                            "value": <?= $View["Total"] ?>
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

                                chart1.addListener("rendered", zoomChart);

                                zoomChart();

                                function zoomChart() {
                                    chart1.zoomToIndexes(chart1.dataProvider.length - <?php if ($_GET['d'] == "w" || !$_GET['d']): ?>8<?php elseif ($_GET['d'] == "m"): ?>30<?php elseif ($_GET['d'] == "d"): ?>0<?php elseif ($_GET['d'] == "a"): ?>100000000000<?php endif?>, chart1.dataProvider.length - 1);
                                }
                            </script>

                            <!-- HTML -->
                            <div id="chartdiv1"></div>
                                        </div>
                                        <div id="my-videos">
                                            <h2><a href="/my_videos">My videos</a></h2>
                                            <div class="element" style="border-bottom: 1px solid #999;color: #666;">
                                            <div class="row" style="width: 50%; float: left;">
                                            Video
                                            </div>
                                            <div class="row" style="width: 50%; float: left;">Views (% of total)
                                            </div>
                                            </div>
                                            <?php $Count = 0 ?>
                                            <?php foreach ($Daily_Views_Num as $ViewNum): ?>
                                            <?php $Count++ ?>
                                            <div class="element" <?php if (!($Count % 2)):?>style="background-color:#EEEEEE"<?php endif ?>>
                                            <div class="row" style="width: 50%; float: left;">
                                            <a href="/watch?v=<?= $ViewNum['url'] ?>"><?= short_title($ViewNum['title'],20) ?></a>
                                            </div>
                                            <div class="row" style="width: 50%; float: left;text-align: right;">
                                                <?= round(($ViewNum['total'] / $Daily_Views_Total) * 100,1) ?>
                                                <div class="barempty"><div class="barfull" style="width: <?= round(($ViewNum['total'] / $Daily_Views_Total) * 100,1) ?>%;"></div></div>
                                            </div>
                                            </div>
                                            <?php endforeach ?>
                                        </div>
                                    <div>
                                        <div style="clear:both;padding-bottom: 18px;"></div>
                                        <div id="demographics">
                                            <h2 style="color: #03c;">Demographics</h2>
                                            <span style="color: #666;">Who is subscribed in this channel?</span>
                                        <?php if ($Gender_Total > 0): ?>
                                        <script>
                                        var chartpie = AmCharts.makeChart( "chartdivpie", {
                                          "type": "pie",
                                          "theme": "none",
                                          "startDuration": 0,
                                          "labelText": "[[title]] [[percents]]%",
                                          "marginBottom": 0,
                                          "marginTop": 0,
                                          "autoMarginOffset": 0,
                                          "minRadius": 30,
                                          "color": "#999999",
                                          "outlineAlpha": 1,
                                          "baseColor": "#499402",
                                          "dataProvider": [ {
                                            "country": "Male",
                                            "litres": <?= $Gender_1 ?>
                                          }, {
                                            "country": "Female",
                                            "litres": <?= $Gender_2 ?>
                                          } ],
                                          "valueField": "litres",
                                          "titleField": "country",
                                           "balloon":{
                                           "enabled": false,
                                          },
                                          "export": {
                                            "enabled": false
                                          }
                                        } );
                                        </script>
                                    <?php endif ?>
                                        <!-- HTML -->
                                        <div id="chartdivpie"><?php if ($Gender_Total == 0): ?><span style="text-align: center;width: 270px;margin: 0 auto;display: block;position: relative;top: 46px">There is insufficient data to display
Demographics. Try selecting a different time range.</span><?php endif ?></div>
                                        <script>
                                    var chart3 = AmCharts.makeChart( "chartdiv3", {
                                      "type": "serial",
                                      "theme": "none",
                                      "dataProvider": [ {
                                        "country": "13-17",
                                        "visits": <?= $Age_13_17 ?>
                                      }, {
                                        "country": "18-24",
                                        "visits": <?= $Age_18_24 ?>
                                      }, {
                                        "country": "25-34",
                                        "visits": <?= $Age_25_34 ?>
                                      }, {
                                        "country": "35-44",
                                        "visits": <?= $Age_35_44 ?>
                                      }, {
                                        "country": "45-54",
                                        "visits": <?= $Age_45_54 ?>
                                      }, {
                                        "country": "55-64",
                                        "visits": <?= $Age_55_64 ?>
                                      }, {
                                        "country": "65+",
                                        "visits": <?= $Age_65 ?>
                                      } ],
                                      "valueAxes": [ {
                                        "gridColor": "#000",
                                        "gridAlpha": 0.1,
                                        "dashLength": 4,
                                        "maximum": 100,
                                        "labelFunction": function(value) {
                                              return Math.abs(value) + '%';
                                            },
                                        "axisColor": "#999",
                                        "color": "#999",
                                      } ],
                                      "gridAboveGraphs": true,
                                      "graphs": [ {
                                        "fillAlphas": 1,
                                        "lineAlpha": 0,
                                        "type": "column",
                                        "valueField": "visits",
                                        "lineColor": "green"
                                      } ],
                                    "balloon": {
                                        "enabled": false,
                                      },
                                      "rotate": true,
                                      "categoryField": "country",
                                      "categoryAxis": {
                                        "gridPosition": "center",
                                        "gridAlpha": 0,
                                        "tickPosition": "center",
                                        "tickLength": 10,
                                        "axisColor": "#999",
                                        "color": "#999",
                                      },
                                      "export": {
                                        "enabled": false
                                      }

                                    } );
                                    </script>

                                    <!-- HTML -->
                                    <div id="chartdiv3"></div>           
                                    </div>
                                    <div id="my-videos">
                                            <h2 style="color:#03c">Popularity</h2>
                                            <span style="color: #666;">Where are my subscribers located?</span>
                                            <script>
                                        var map = AmCharts.makeChart( "chartdivmap", {
                                          "type": "map",
                                          "theme": "none",
                                          "colorSteps": 6,
                                          "backgroundAlpha": 1,
                                          "backgroundColor": "#EBF7FD",
                                          "zoomOnDoubleClick": false,
                                          "panEventsEnabled": false,
                                          "dragMap": false,
                                          "dataProvider": {
                                            "map": "worldLow",
                                            "areas": [ <?php if ($Countries) : ?>
                                            <?php foreach ($Countries as $Country) : ?>
                                            {
                                                "id": "<?= $Country["country"] ?>",
                                                "value": <?= $Country["amount"] ?>
                                            },
                                            <?php endforeach ?>
                                            <?php else : ?>
                                            {
                                                "id": "0",
                                                "value": 0
                                            },
                                            <?php endif ?>
                                            ]
                                          },

                                          "areasSettings": {
                                            "autoZoom": false,
                                            "color": "#EEEFD6",
                                            "colorSolid": "#082F00",
                                            "outlineThickness": 0.5,
                                            "unlistedAreasOutlineColor": "#999",
                                            "unlistedAreasColor": "#EEEFD6",
                                            "selectedOutlineThickness": 0,
                                            "balloonText": "[[title]]: <strong>[[value]]</strong>",
                                          },
                                          "valueLegend": {
                                            "bottom": 10,
                                            "minValue": "Less",
                                            "maxValue": "More",
                                            "borderColor": "#EBF7FD",
                                            "width": 75,
                                            "height": 13,
                                          },

                                          "zoomControl": {
                                                "panControlEnabled": false,
                                                "zoomControlEnabled": false,
                                                "homeButtonEnabled": false
                                          },

                                          "export": {
                                            "enabled": false
                                          }

                                        } );
                                        </script>
                                        <div id="chartdivmap"></div>   
                                        </div>
                                    </div>
                                    <?php elseif ($_GET['page'] == "all"):?>
                        <div class="a_box">
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
                                        <?php if ($Daily_Subs) : ?>
                                        <?php foreach ($Daily_Subs as $Sub) : ?>
                                        {
                                            "date": "<?= $Sub["Date"] ?>",
                                            "value": <?= $Sub["Total"] ?>
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

                                chart1.addListener("rendered", zoomChart);

                                zoomChart();

                                function zoomChart() {
                                    chart1.zoomToIndexes(chart1.dataProvider.length - 8, chart1.dataProvider.length - 1);
                                }
                            </script>

                            <!-- HTML -->
                            <div id="chartdiv"></div>

                            <script>
                                var chart2 = AmCharts.makeChart("chartdiv2", {
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
                                        "bulletColor": "#30831B",
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
                                        "backgroundColor": "#eee",
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
                                        <?php if ($Daily_Views) : ?>
                                        <?php foreach ($Daily_Views as $View) : ?>
                                        {
                                            "date": "<?= $View["Date"] ?>",
                                            "value": <?= $View["Total"] ?>
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

                                chart2.addListener("rendered", zoomChart);

                                zoomChart();

                                function zoomChart() {
                                    chart2.zoomToIndexes(chart2.dataProvider.length - 8, chart2.dataProvider.length - 1);
                                }
                            </script>

                            <!-- HTML -->
                            <div id="chartdiv2"></div>
                        <?php endif?>
        
</div>
                    
</div></div></div>
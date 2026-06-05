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
#list-pane .folder.selected {
    background: transparent url(/img/sel-bck-vfl34546.png) repeat-x;
    background-color: #cccccc;
}
#nav-pane .header {
    height: 32px;
    padding: 9px 0;
}
.row {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
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
#list-pane a {
    display: block;
    padding: 4px 10px;
    padding-right: 4px;
    font-weight: 700;
    color: black;
    font-size: 12px;
}
.folder {
    height: auto;
    padding: 0;
    text-decoration: none;
}
.name:hover {
    text-decoration: none;
}
#view-pane .header {
    height: auto;
    padding: 0;
}
#view-pane .splitter {
    border-top: 1px solid #999;
}
#list-pane {
    border-top: 1px solid #999;
    font-size: 12px;
}
h2 {
    line-height: 12px;
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
<!-- left column - FOR ADS ONLY IF MY SUBS -->
<div id="nav-pane">
                <div class="header" <?php if (isset($_GET['v'])): ?>style="height:71px"<?php endif?>>
                </div>
                <div id="list-pane">
                    <div class="folder<?php if (!isset($_GET['v'])):?> selected<?php endif?>"><a class="name" href="/insight<?php if (isset($_GET['d'])): ?>?d=<?= $_GET['d'] ?><?php endif ?>"><?= $LANGS['channel'] ?></a></div>
                    <div class="subfolder channel-subfolder" style="text-decoration: none;<?php if (!isset($_GET['page']) && !isset($_GET['v'])): ?>background-color:#d6e1f5;<?php endif?>"><a class="name" href="/insight<?php if (isset($_GET['d'])): ?>?d=<?= $_GET['d'] ?><?php endif ?>"><?= $LANGS['summary'] ?></a></div>
                    <div class="subfolder channel-subfolder" style="text-decoration: none;<?php if (isset($_GET['page']) && $_GET['page'] == "views" && !isset($_GET['v'])): ?>background-color:#d6e1f5;<?php endif?>"><a class="name" href="/insight?page=views<?php if (isset($_GET['d'])): ?>&d=<?= $_GET['d'] ?><?php endif ?>"><?= $LANGS['statviews'] ?></a></div>
                    <div class="subfolder channel-subfolder" style="text-decoration: none;<?php if (isset($_GET['page']) && $_GET['page'] == "demographics" && !isset($_GET['v'])): ?>background-color:#d6e1f5;<?php endif?>"><a class="name" href="/insight?page=demographics<?php if (isset($_GET['d'])): ?>&d=<?= $_GET['d'] ?><?php endif ?>"><?= $LANGS['demographics'] ?></a></div>
                    <div class="subfolder channel-subfolder" style="text-decoration: none;<?php if (isset($_GET['page']) && $_GET['page'] == "community" && !isset($_GET['v'])): ?>background-color:#d6e1f5;<?php endif?>"><a class="name" href="/insight?page=community<?php if (isset($_GET['d'])): ?>&d=<?= $_GET['d'] ?><?php endif ?>"><?= $LANGS['community'] ?></a></div>
                    <?php if (isset($_GET['v'])): ?>
                    <div class="folder<?php if ($_GET['v']):?> selected<?php endif?>"><a class="name" style="min-height: 38px;" href="/insight?v=<?= $_GET['v'] ?><?php if (isset($_GET['d'])): ?>&d=<?= $_GET['d'] ?><?php endif ?>"><img id="thumbnail" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$_VIDEO->Info["url"].'.jpg')): ?>src="/u/thmp/<?= $_VIDEO->Info["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg50" style="vertical-align: top;float: left;margin-right: 3px;"> <?= $_VIDEO->Info['title'] ?></a></div>
                    <div class="subfolder channel-subfolder" style="text-decoration: none;<?php if (!isset($_GET['page']) && isset($_GET['v'])): ?>background-color:#d6e1f5;<?php endif?>"><a class="name" href="/insight?v=<?= $_GET['v'] ?><?php if (isset($_GET['d'])): ?>&d=<?= $_GET['d'] ?><?php endif ?>"><?= $LANGS['statviews'] ?></a></div>
                <?php endif?>
                </div>
            </div>
                            <div id="view-pane" style="margin-bottom: 10px;">
                <div class="header yt2009-sub-header">
                    <div class="pager"></div>
                    <?php if (!isset($_GET['v'])): ?>
                    <h2><?= $LANGS['allvideos'] ?></h2>
                    <?php else: ?>
                    <div> 
                        <div style="float: left; padding-right: 10px;">
                            <a href="/watch?v=<?= $_VIDEO->Info["url"] ?>"><img id="thumbnail" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$_VIDEO->Info["url"].'.jpg')): ?>src="/u/thmp/<?= $_VIDEO->Info["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg70" style="border:0"></a>&nbsp;
                        </div>
                        <h2><?= $_VIDEO->Info["title"] ?></h2>
                        <div class="vfacets" style="line-height: 18px;">
                            <span class="grayText"><?= $LANGS['statadded'] ?>:</span>
                             <?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['videotimeformat'], time_machine(strtotime((string) $_VIDEO->Info["uploaded_on"]))); }
                    else {echo strftime($LANGS['videotimeformat'], strtotime((string) $_VIDEO->Info["uploaded_on"])); }  ?><br>
                            <span class="grayText"><?= $LANGS['statviews'] ?>:</span>
                            <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_VIDEO->Info["views"]) ?><?php else: ?><?= ($_VIDEO->Info["views"]) ?><?php endif ?><br>
                        </div>
                    </div>
                    <?php endif?>
                    <h2><span style="display: inline-block;width: 300px;"><?php if (!isset($_GET['page']) && !isset($_GET['v'])): ?><?= $LANGS['summary'] ?><?php elseif (isset($_GET['page']) && $_GET['page'] == "views" || isset($_GET['v'])): ?><?= $LANGS['statviews'] ?><?php elseif (isset($_GET['page']) && $_GET['page'] == "demographics"): ?><?= $LANGS['demographics'] ?><?php elseif (isset($_GET['page']) && $_GET['page'] == "community"): ?><?= $LANGS['community'] ?><?php endif ?></span><div style="width: 460px;text-align: right;display: inline-block;<?php if (isset($_GET['v'])): ?>opacity: 0;pointer-events: none<?php endif ?>">

                        <button type="button" id="vm-sort-btn" onclick="dropdown(this);return false;" onfocusout="dropdown(this);" class=" yt-uix-button yt-uix-button-text"><span class="yt-uix-button-content"><?php if (isset($_GET['d']) && $_GET['d'] == "w" || !isset($_GET['d'])): ?><?php setlocale(LC_TIME, $LANGS['languagecode']); echo strftime($LANGS['shorttimeformat'], time_machine(strtotime(date('Y-m-d', strtotime("-1 week"))))); ?><?php elseif ($_GET['d'] == "m"): ?><?php setlocale(LC_TIME, $LANGS['languagecode']); echo strftime($LANGS['shorttimeformat'], time_machine(strtotime(date('Y-m-d', strtotime("-1 month"))))); ?><?php elseif ($_GET['d'] == "d"): ?><?php setlocale(LC_TIME, $LANGS['languagecode']); echo strftime($LANGS['shorttimeformat'], time_machine(strtotime(date('Y-m-d', strtotime("-1 day"))))); ?><?php elseif ($_GET['d'] == "a"): ?><?php setlocale(LC_TIME, $LANGS['languagecode']); echo strftime($LANGS['shorttimeformat'], time_machine(strtotime(date('Y-m-d', strtotime((string) $_USER->Info['registration_date']))))); ?><?php endif?> - <?php setlocale(LC_TIME, $LANGS['languagecode']); echo strftime($LANGS['shorttimeformat'], time_machine(strtotime(date('Y-m-d')))); ?></span> <img class="yt-uix-button-arrow" src="/img/pixel.gif" alt="">
                            <ul style="min-width: 65px; left: 650.227px; top: 259.469px;" class="yt-uix-button-menu yt-uix-button-menu-text hid">
                                <li><span href="/insight?<?php if (isset($_GET['v'])): ?>v=<?= $_GET['v'] ?>&<?php endif?>d=d<?php if (isset($_GET['page'])): ?>&page=<?= $_GET['page'] ?><?php endif ?>" id="vm-sort-newest" onclick=";window.location.href=this.getAttribute('href');return false;" class=" yt-uix-button-menu-item"><?= $LANGS['timetoday'] ?></span></li>
                                <li><span href="/insight?<?php if (isset($_GET['v'])): ?>v=<?= $_GET['v'] ?>&<?php endif?>d=w<?php if (isset($_GET['page'])): ?>&page=<?= $_GET['page'] ?><?php endif ?>" id="vm-sort-oldest" onclick=";window.location.href=this.getAttribute('href');return false;" class=" yt-uix-button-menu-item"><?= $LANGS['timeweek'] ?></span></li>
                                <li><span href="/insight?<?php if (isset($_GET['v'])): ?>v=<?= $_GET['v'] ?>&<?php endif?>d=m<?php if (isset($_GET['page'])): ?>&page=<?= $_GET['page'] ?><?php endif ?>" id="vm-sort-viewed" onclick=";window.location.href=this.getAttribute('href');return false;" class=" yt-uix-button-menu-item"><?= $LANGS['timemonth'] ?></span></li>
                                <li><span href="/insight?<?php if (isset($_GET['v'])): ?>v=<?= $_GET['v'] ?>&<?php endif?>d=a<?php if (isset($_GET['page'])): ?>&page=<?= $_GET['page'] ?><?php endif ?>" id="vm-sort-longest" onclick=";window.location.href=this.getAttribute('href');return false;" class=" yt-uix-button-menu-item"><?= $LANGS['alltime'] ?></span></li>
                            </ul>
                        </button></div></h2>
                    
                </div>
                <div class="splitter">
                    <div class="view">
                        <div class="settings">
                            <div style="font-weight:bold;font-size:14px;margin-bottom:8px;float:left;position:relative;top:2px">
                <form action="/my_videos" method="GET" id="num_change" style="position:relative;left:3px;display:inline-block">
                    
                </form>
            </div>
                <div style="text-align:left">
                    <form action="/my_videos" method="GET" style="position:relative;bottom:1px" autocomplete="off">
                        <input type="text" maxlength="20" name="search" style="width:400px;"> <input class="yt-button" style="padding: 2px 10px;font-size: 12px;margin-left: 10px;" type="submit" value="<?= $LANGS['searchmyvideos'] ?>">
                    </form>
                </div>
                            <form action="/my_videos" method="POST" id="bulk_form">
            
                        </form></div>
                                <div id="video_grid" class="browseGridView marT10">
                                    <style>
                                        g[transform="translate(230,28)"] { display: none;}
                                    </style>
                                    <?php if (!isset($_GET['v'])): ?>
                                    <?php if (!isset($_GET['page'])): ?>
                                        <div style="height: 640px;">
                                        <div id="daily-views">
                                            <h2><a href="/insight?page=views<?php if (isset($_GET['d'])): ?>&d=<?= $_GET['d'] ?><?php endif ?>"><?= $LANGS['statviews'] ?></a></h2>
                                            <span style="color: #666;"><?= $LANGS['viewsdesc'] ?></span>
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
                                    chart1.zoomToIndexes(chart1.dataProvider.length - <?php if (isset($_GET['d']) && $_GET['d'] == "w" || !isset($_GET['d'])): ?>8<?php elseif ($_GET['d'] == "m"): ?>30<?php elseif ($_GET['d'] == "d"): ?>0<?php elseif ($_GET['d'] == "a"): ?>100000000000<?php endif?>, chart1.dataProvider.length - 1);
                                }
                            </script>

                            <!-- HTML -->
                            <div id="chartdiv1"></div>
                                        </div>
                                        <div id="my-videos">
                                            <h2><a href="/my_videos"><?= $LANGS['myvideos'] ?></a></h2>
                                            <div class="element" style="border-bottom: 1px solid #999;color: #666;">
                                            <div class="row" style="width: 50%; float: left;">
                                            <?= $LANGS['video'] ?>
                                            </div>
                                            <div class="row" style="width: 50%; float: left;"><?= $LANGS['viewspercentage'] ?>
                                            </div>
                                            </div>
                                            <?php if ($Daily_Views_Num): ?>
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
                                            <?php endif ?>
                                        </div>
                                    <div>
                                        <div style="clear:both;padding-bottom: 18px;"></div>
                                        <div id="demographics">
                                            <h2 style="color: #03c;"><a href="/insight?page=demographics<?php if (isset($_GET['d'])): ?>&d=<?= $_GET['d'] ?><?php endif ?>"><?= $LANGS['demographics'] ?></a></h2>
                                            <span style="color: #666;"><?= $LANGS['demodesc'] ?></span>
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
                                          "color": "#666",
                                          "outlineAlpha": 1,
                                          "labelRadius": 10,
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
                                        <div id="chartdivpie"><?php if ($Gender_Total == 0): ?><span style="text-align: center;width: 270px;margin: 0 auto;display: block;position: relative;top: 46px"><?= $LANGS['insufdemo'] ?></span><?php endif ?></div>
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
                                        "gridColor": "#666",
                                        "gridAlpha": 0.5,
                                        "dashLength": 4,
                                        "maximum": 100,
                                        "labelFunction": function(value) {
                                              return Math.abs(value) + '%';
                                            },
                                        "axisColor": "#666",
                                        "color": "#666",
                                        "minHorizontalGap": 50,
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
                                        "axisColor": "#666",
                                        "color": "#666",
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
                                            <h2 style="color:#03c"><a href="/insight?page=community<?php if (isset($_GET['d'])): ?>&d=<?= $_GET['d'] ?><?php endif ?>"><?= $LANGS['community'] ?></a></h2>
                                            <span style="color: #666;margin-bottom: 4px;display: block;"><?= $LANGS['commdesc'] ?></span>
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
                                    <?php elseif ($_GET['page'] == "views"): ?>
                                        <div style="height: 450px">
                                        <style>
                                            #daily-views {
                                                width: 100%;
                                                float: left;
                                            }
                                            .barempty {
                                                width: 330px;
                                            }
                                        </style>
                                        <div id="daily-views">
                                            <span style="color: #666;"><?= $LANGS['viewsdesc'] ?></span>
                                            <script>
                                var chart1 = AmCharts.makeChart("chartdiv1", {
                                    "type": "serial",
                                    "theme": "none",
                                    "marginLeft": 0,
                                    "marginRight": 0,
                                    "marginTop": 10,
                                    "marginBottom": 0,
                                    "autoMarginOffset": 0,
                                    "mouseWheelZoomEnabled":true,
                                    "dataDateFormat": "YYYY-MM-DD",
                                    "zoomOutText": "",
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
                                    chart1.zoomToIndexes(chart1.dataProvider.length - 8, chart1.dataProvider.length - 1);
                                }
                            </script>

                            <!-- HTML -->
                            <div id="chartdiv1"></div>
                            <div id="my-videos" style="width:100%; margin-top: 4px;">
                                            <div class="element" style="border-bottom: 1px solid #999;color: #000; font-weight: bold;">
                                            <div class="row" style="width: 50%; float: left;">
                                            <?= $LANGS['topvideos'] ?>
                                            </div>
                                            <div class="row" style="width: 50%; float: left;"><?= $LANGS['percentoftotalviews'] ?>
                                            </div>
                                            </div>
                                            <?php $Count = 0 ?>
                                            <?php if ($Daily_Views_Num): ?>
                                            <?php foreach ($Daily_Views_Num as $ViewNum): ?>
                                            <?php $Count++ ?>
                                            <div class="element" <?php if (!($Count % 2)):?>style="background-color:#EEEEEE"<?php endif ?>>
                                            <div class="row" style="width: 50%; float: left;">
                                            <a href="/watch?v=<?= $ViewNum['url'] ?>"><?= short_title($ViewNum['title'],64) ?></a>
                                            </div>
                                            <div class="row" style="width: 50%; float: left;text-align: right;">
                                                <?= round(($ViewNum['total'] / $Daily_Views_Total) * 100,1) ?>
                                                <div class="barempty"><div class="barfull" style="width: <?= round(($ViewNum['total'] / $Daily_Views_Total) * 100,1) ?>%;"></div></div>
                                            </div>
                                            </div>
                                            <?php endforeach ?>
                                            <?php endif ?>
                                        </div>
                                        </div>
                                    </div>
                        <?php elseif ($_GET['page'] == "demographics"): ?>
                                        <style>
                                            #demographics {
                                                width: 100%;
                                                float: left;
                                            }
                                            #chartdivpie {
                                                width: 50%;
                                                float: right;
                                                height: 200px;
                                            }
                                            #chartdiv3 {
                                                width: 50%;
                                                float: left;
                                                height: 200px;
                                            }
                                        </style>
                                        <div style="height: 210px">
                                        <div id="demographics">
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
                                          "minRadius": 80,
                                          "color": "#666",
                                          "outlineAlpha": 1,
                                          "baseColor": "#499402",
                                          "labelRadius": 5,
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
                                        <div style="width: 50%;font-weight: bold;float: left;"><?= $LANGS['ageranges'] ?></div><div style="width: 50%;font-weight: bold;float: left;"><?= $LANGS['genderranges'] ?></div><div id="chartdivpie"><?php if ($Gender_Total == 0): ?><span style="text-align: center;width: 270px;margin: 0 auto;display: block;position: relative;top: 64px"><?= $LANGS['insufdemo'] ?></span><?php endif ?></div>
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
                                        "gridColor": "#666",
                                        "gridAlpha": 0.5,
                                        "dashLength": 4,
                                        "maximum": 100,
                                        "labelFunction": function(value) {
                                              return Math.abs(value) + '%';
                                            },
                                        "axisColor": "#666",
                                        "color": "#666",
                                        "minHorizontalGap": 50,
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
                                        "axisColor": "#666",
                                        "color": "#666",
                                      },
                                      "export": {
                                        "enabled": false
                                      }

                                    } );
                                    </script>

                                    <!-- HTML -->
                                    <div id="chartdiv3"></div>           
                                    </div>
                                    </div>
                            <?php elseif ($_GET['page'] == "community"): ?>
                                        <div style="height: 540px">
                                        <style>
                                            #daily-views {
                                                width: 100%;
                                                float: left;
                                            }
                                            #chartdiv1 {
                                                width: 50%;
                                                float: left;
                                            } 
                                            .barempty {
                                                width: 330px;
                                            }
                                            #chartdivmap {
                                                width: 47%;
                                                float: right;
                                                height: 250px;
                                            }
                                            #chartdiv2 {
                                                width: 100%;
                                                border: 0;
                                                height: 215px;
                                            }
                                        </style>
                                        <div id="daily-views">
                                            <script>
                                                function changeEnView() {
                                                    var letter = document.getElementById('enview').value;
                                                    location.href = '/insight?page=community&d=<?php if (isset($_GET['d'])): ?><?= $_GET['d'] ?><?php endif ?>&t=<?php if (isset($_GET['t'])): ?><?= $_GET['t'] ?><?php endif ?>&i='+letter;
                                                }
                                            </script>
                                            <span style="color: #666;margin-right: 12px; float: left"><?= $LANGS['engdesc'] ?><br>
                                                <select id="enview" onchange="changeEnView();">
                                                    <option value="a" <?php if (isset($_GET['i']) && $_GET['i'] == "a" || !isset($_GET['i'])):?>selected<?php endif ?>><?= $LANGS['engagements'] ?></option>
                                                    <option value="r" <?php if (isset($_GET['i']) && $_GET['i'] == "r"):?>selected<?php endif ?>><?= $LANGS['statratings'] ?></option>
                                                    <option value="c" <?php if (isset($_GET['i']) && $_GET['i'] == "c"):?>selected<?php endif ?>><?= $LANGS['statcomments'] ?></option>
                                                    <option value="f" <?php if (isset($_GET['i']) && $_GET['i'] == "f"):?>selected<?php endif ?>><?= $LANGS['favorites'] ?></option>
                                                </select>
                                            </span>
                                            <span style="color: #666;"><?= $LANGS['commdesc'] ?></span>
                                            <script>
                                var chart1 = AmCharts.makeChart("chartdiv1", {
                                    "type": "serial",
                                    "theme": "none",
                                    "marginLeft": 0,
                                    "marginRight": 0,
                                    "marginTop": 10,
                                    "marginBottom": 0,
                                    "autoMarginOffset": 0,
                                    "mouseWheelZoomEnabled":true,
                                    "dataDateFormat": "YYYY-MM-DD",
                                    "zoomOutText": "",
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
                                        <?php if ($Daily_Interactions) : ?>
                                        <?php foreach ($Daily_Interactions as $Interaction) : ?>
                                        {
                                            "date": "<?= $Interaction["Date"] ?>",
                                            "value": <?= $Interaction["Total"] ?>
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
                            <div id="chartdiv1"></div>
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
                            <div id="daily-views">
                                            <script>
                                                function changeSubView(e) {
                                                    var letter = e.value;
                                                    location.href = '/insight?page=community&d=<?php if (isset($_GET['d'])): ?><?= $_GET['d'] ?><?php endif ?>&i=<?php if (isset($_GET['i'])): ?><?= $_GET['i'] ?><?php endif ?>&t='+letter;
                                                }
                                            </script>
                                            <h2><?= $LANGS['dailysubs'] ?></h2>
                                            <input type="radio" id="daily" value="d" name="view" onclick="changeSubView(this)" <?php if (!isset($_GET['t']) || isset($_GET['t']) && $_GET['t'] == "d"): ?>checked<?php endif ?>>
                                            <label for="daily"><?= $LANGS['daily'] ?></label>
                                            <input type="radio" id="total" name="view" onclick="changeSubView(this)" value="t" <?php if (isset($_GET['t']) && $_GET['t'] == "t"): ?>checked<?php endif ?>>
                                            <label for="t"><?= $LANGS['total'] ?></label>
                                            <script>
                                var chart2 = AmCharts.makeChart("chartdiv2", {
                                    "type": "serial",
                                    "theme": "none",
                                    "marginLeft": 0,
                                    "marginRight": 0,
                                    "marginTop": 10,
                                    "marginBottom": 0,
                                    "autoMarginOffset": 0,
                                    "mouseWheelZoomEnabled":true,
                                    "dataDateFormat": "YYYY-MM-DD",
                                    "zoomOutText": "",
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

                                chart2.addListener("rendered", zoomChart);

                                zoomChart();

                                function zoomChart() {
                                    chart1.zoomToIndexes(chart1.dataProvider.length - <?php if (isset($_GET['d']) && $_GET['d'] == "w" || !isset($_GET['d'])): ?>8<?php elseif (isset($_GET['d']) && $_GET['d'] == "m"): ?>30<?php elseif (isset($_GET['d']) && $_GET['d'] == "d"): ?>0<?php elseif (isset($_GET['d']) && $_GET['d'] == "a"): ?>100000000000<?php endif?>, chart1.dataProvider.length - 1);
                                }
                            </script>

                            <!-- HTML -->
                            <div id="chartdiv2"></div>
                                        </div>
                                        </div>
                                    </div>
                        <?php endif?>
                        <?php else: ?>
                        <?php if (!isset($_GET['page'])): ?>
                                        <div style="height: 285px">
                                        <style>
                                            #daily-views {
                                                width: 100%;
                                                float: left;
                                            }
                                            .barempty {
                                                width: 330px;
                                            }
                                        </style>
                                        <div id="daily-views">
                                            <span style="color: #666;"><?= $LANGS['insightvideodesc'] ?></span>
                                            <div>
                                            <script>
                                                function changeEnView() {
                                                    var letter = document.getElementById('enview').value;
                                                    location.href = '/insight?v=<?= $_GET['v'] ?>&i='+letter;
                                                }
                                            </script>
                                            <select id="enview" onchange="changeEnView();">
                                                    <option value="d" <?php if (isset($_GET['i']) && $_GET['i'] == "d" || !isset($_GET['i'])):?>selected<?php endif ?>><?= $LANGS['dailyviews'] ?></option>
                                                    <option value="t" <?php if (isset($_GET['i']) && $_GET['i'] == "t"):?>selected<?php endif ?>><?= $LANGS['videototalviews'] ?></option>
                                                    <option value="r" <?php if (isset($_GET['i']) && $_GET['i'] == "r"):?>selected<?php endif ?>><?= $LANGS['statratings'] ?></option>
                                                    <option value="c" <?php if (isset($_GET['i']) && $_GET['i'] == "c"):?>selected<?php endif ?>><?= $LANGS['statcomments'] ?></option>
                                                    <option value="f" <?php if (isset($_GET['i']) && $_GET['i'] == "f"):?>selected<?php endif ?>><?= $LANGS['favorites'] ?></option>
                                                </select>
                                            </div>
                                            <script>
                                var chart1 = AmCharts.makeChart("chartdiv1", {
                                    "type": "serial",
                                    "theme": "none",
                                    "marginLeft": 0,
                                    "marginRight": 0,
                                    "marginTop": 10,
                                    "marginBottom": 0,
                                    "autoMarginOffset": 0,
                                    "mouseWheelZoomEnabled":true,
                                    "dataDateFormat": "YYYY-MM-DD",
                                    "zoomOutText": "",
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
                                    chart1.zoomToIndexes(chart1.dataProvider.length - 8, chart1.dataProvider.length - 1);
                                }
                            </script>

                            <!-- HTML -->
                            <div id="chartdiv1"></div>
                                        </div>
                                    </div>
                            <?php endif ?>
                        <?php endif?>
        
</div>
                    
</div></div></div>
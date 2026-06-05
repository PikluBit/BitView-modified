<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
if (!$_USER->Logged_In || (!$_USER->Is_Moderator && !$_USER->Is_Admin)) {
    header("location: /");
    exit();
}
?>
<?php if (!isset($_GET["ve"])) : ?>
<div style="width:100%">
    <div class="a_box">
        <div class="a_box_title">Latest Videos</div>
        <div style="max-height:300px;overflow-y:auto;">
                        <?php $Count = 0 ?>
                    <?php foreach ($Recent_Videos as $Video) : ?>
                        <?php $Count++ ?>
                        <div style="padding: 10px<?php if ($Video["is_deleted"]) : ?>;background:#ffcccc<?php elseif (!($Count % 2)): ?>;background:#eee<?php endif ?>">
                            <div class="videothumb" style="padding:0"><a href="/watch?v=<?= $Video["url"] ?>"><img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> width="61"></a></div>
                            <div class="videotitle"><a href="/watch?v=<?= $Video["url"] ?>"><?= $Video["title"] ?></a></div>
                            <div style="font-size: 10px; color: #333; margin-top: 1px;"><a href="/user/<?= $Video["uploaded_by"] ?>"><?= displayname($Video["uploaded_by"]) ?></a> · <?= date("M d, Y", strtotime((string) $Video["uploaded_on"])) ?> · <?= $Video["views"] ?> views · <?= $Video["comments"] ?> comments · favorited <?= $Video["favorites"] ?> times · <?php $Rating = ["1stars" => $Video["1stars"], "2stars" => $Video["2stars"], "3stars" => $Video["3stars"], "4stars" => $Video["4stars"], "5stars" => $Video["5stars"]]; echo array_sum($Rating) ?> ratings · <?php $Rating = ["1stars" => $Video["1stars"], "2stars" => $Video["2stars"], "3stars" => $Video["3stars"], "4stars" => $Video["4stars"], "5stars" => $Video["5stars"]]; echo round(avg_ratings($Rating),2) ?> stars</div>
                            <div><a href="/admin_panel/?page=videos&ve=<?= $Video["url"] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Video</a> <a href="/admin_panel/?page=users&ue=<?= $Video["uploaded_by"] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Uploader</a> <a href="/admin_panel/?page=videos&ve=<?= $Video["url"] ?>&analytics=true" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Insight</a></div>
                            <div style="clear:both"></div>
                        </div>
                    <?php endforeach ?>
            </div>
    </div>
</div>
<div style="">
    <div class="a_box">
        <div class="a_box_title">Video Reports</div>
        <?php if ($Reports): ?>
        <div style="max-height:500px;overflow-y:auto">
                <?php foreach ($Reports as $Report) : ?>
                <?php $Video = $DB->execute("SELECT * FROM videos WHERE url = :URL", true, [":URL" => $Report["url"]]); ?>
                <?php 
                $Reason["1.1"] = "Sexual Content // graphic sexual activity";
                $Reason["1.2"] = "Sexual Content // nudity";
                $Reason["1.3"] = "Sexual Content // suggestive, but without nudity";
                $Reason["1.4"] = "Sexual Content // other sexual content";

                $Reason["2.1"] = "Violent or Repulsive Content // adults fighting";
                $Reason["2.2"] = "Violent or Repulsive Content // physical attack";
                $Reason["2.3"] = "Violent or Repulsive Content // youth violence";
                $Reason["2.4"] = "Violent or Repulsive Content // animal abuse";
                $Reason["2.5"] = "Violent or Repulsive Content // disgusting content";

                $Reason["3.1"] = "Hateful or Abusive Content // promotes hatred or violence";
                $Reason["3.2"] = "Hateful or Abusive Content // abusing vulnerable individuals";
                $Reason["3.3"] = "Hateful or Abusive Content // bullying";

                $Reason["4.1"] = "Harmful Dangerous Acts // drug abuse";
                $Reason["4.2"] = "Harmful Dangerous Acts // abuse of fire or explosives";
                $Reason["4.3"] = "Harmful Dangerous Acts // other dangerous activities";

                $Reason["5"]   = "Child Abuse";

                $Reason["6.1"] = "Spam // mass advertising";
                $Reason["6.2"] = "Spam // misleading text";
                $Reason["6.3"] = "Spam // misleading thumbnail";
                $Reason["6.4"] = "Spam // scams / fraud";

                $Reason["7.1"] = "Infringes My Rights // infringes my copyright";
                $Reason["7.2"] = "Infringes My Rights // invades my privacy";
                $Reason["7.3"] = "Infringes My Rights // reveals personal information";

                ?>
                <div style="padding: 10px">
                    <table class="atable reporterinfo" width="100%" class="atable" id="users-table" style="border: 1px solid #999;background: white;">
                    <tbody>
                    <tr>
                        <td align="center">Reporter</td>
                        <td align="center">Reason</td>
                        <?php if ($Report['additional_info']): ?>
                        <td align="center">Additional Info</td>
                        <?php endif ?>
                        <td align="center">Date</td>
                    </tr>
                    <tr>
                        <td align="center"><a href="/user/<?= $Report['username'] ?>"><?= $Report['username'] ?></a></td>
                        <td align="center"><?= $Reason[$Report['number']] ?></td>
                        <?php if ($Report['additional_info']): ?>
                        <td align="center"><?= $Report['additional_info'] ?></td>
                        <?php endif ?>
                        <td align="center"><?= get_time_ago($Report['submit_date']) ?></td>
                    </tr>
                                    </tbody></table>
                    <div style="border: 1px solid #999;border-top: 0;padding: 8px;">
                    <div class="videothumb" style="padding:0"><a href="/watch?v=<?= $Video["url"] ?>"><img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> width="61"></a></div>
                    <div class="videotitle"><a href="/watch?v=<?= $Video["url"] ?>"><?= $Video["title"] ?></a></div>
                    <div style="font-size: 10px; color: #333; margin-top: 1px;">Uploaded by <a href="/user/<?= $Video["uploaded_by"] ?>"><?= displayname($Video["uploaded_by"]) ?></a> · <?= date("M d, Y H:m:s", strtotime((string) $Video["uploaded_on"])) ?> · <?= $Video["views"] ?> views · <?= $Video["comments"] ?> comments · favorited <?= $Video["favorites"] ?> times · <?php $Rating = ["1stars" => $Video["1stars"], "2stars" => $Video["2stars"], "3stars" => $Video["3stars"], "4stars" => $Video["4stars"], "5stars" => $Video["5stars"]]; echo array_sum($Rating) ?> ratings · <?php $Rating = ["1stars" => $Video["1stars"], "2stars" => $Video["2stars"], "3stars" => $Video["3stars"], "4stars" => $Video["4stars"], "5stars" => $Video["5stars"]]; echo round(avg_ratings($Rating),2) ?> stars</div>
                    <div><a href="/admin_panel/?page=videos&ve=<?= $Video["url"] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Video</a> <a href="/admin_panel/?page=users&ue=<?= $Video["uploaded_by"] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Uploader</a> <a href="/admin_panel/?page=users&ue=<?= $Report["username"] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Reporter</a> <a href="/admin_panel/?page=videos&resolve=<?= $Report["url"] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Resolve</a></div>
                    <div style="clear:both"></div>
                    </div>
                </div>
                <?php endforeach ?>
        </div>
    <?php else: ?>
    <div style="padding: 10px; text-align: center; font-weight: bold">No Video Reports!</div>
    <?php endif?>
    </div>
</div>
<div style="clear:both"></div>
<div style="float:right;width:100%;">
    <div class="a_box">
        <div class="a_box_title">Edit Video</div>
        <div style="max-height:500px;overflow-y:auto">
            <div style="padding:16px; text-align: center;">
                <form action="/admin_panel/?page=videos" method="post">
                    <input type="url" placeholder="Video URL" name="url" maxlength="128" style="width:300px" /> <input class="yt-button" type="submit" name="edit_video" value="Edit Video" style="font-size: 12px;padding: 0.2333em 0.8333em;">
                </form>
            </div>
        </div>
    </div>
</div>
<div style="clear:both"></div>
<?php else : ?>
    <div class="video_edit_header">
        <a style="float:left" href="/watch?v=<?= $_VIDEO->Info["url"] ?>"><img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$_VIDEO->Info["url"].'.jpg')): ?>src="/u/thmp/<?= $_VIDEO->Info["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> style="width:88px;height:66px;display:inline-block;vertical-align: middle; border: 3px double #999;"></a>
        <div style="float:left;margin-left:6px"><div style="font-weight:bold;font-size:16px"><?= $_VIDEO->Info['title'] ?></div><div style="font-size: 11px; color: #333; margin-top: 3px;margin-bottom: 3px"><a href="/user/<?= $_VIDEO->Info["uploaded_by"] ?>"><?= displayname($_VIDEO->Info["uploaded_by"]) ?></a> · <?= date("F d, Y, h:i A", strtotime((string) $_VIDEO->Info["uploaded_on"])) ?> · <?= $_VIDEO->Info["views"] ?> views · <?= $_VIDEO->Info["comments"] ?> comments · favorited <?= $_VIDEO->Info["favorites"] ?> times · <?php $Rating = ["1stars" => $_VIDEO->Info["1stars"], "2stars" => $_VIDEO->Info["2stars"], "3stars" => $_VIDEO->Info["3stars"], "4stars" => $_VIDEO->Info["4stars"], "5stars" => $_VIDEO->Info["5stars"]]; echo array_sum($Rating) ?> ratings</div><div class="stars"><?= show_ratings($_VIDEO->Info,"12px","12px") ?></div><div><?php if (isset($_GET["analytics"]) && !($_GET["analytics"] == "true")): ?><a href="/admin_panel/?page=videos&ve=<?= $_GET['ve'] ?>&analytics=true" class="yt-button" style="padding: 0.15em 0.8333em;font-size: 12px;margin:0;" type="button">Insight</a> <?php else: ?><a href="/admin_panel/?page=videos&ve=<?= $_GET['ve'] ?>" class="yt-button" style="padding: 0.15em 0.8333em;font-size: 12px;margin:0;" type="button">Edit Video</a><?php endif ?> <a href="/admin_panel/?page=users&ue=<?= $_VIDEO->Info['uploaded_by'] ?>" class="yt-button" style="padding: 0.15em 0.8333em;font-size: 12px;margin:0;" type="button">Edit Uploader</a> <a href="/watch?v=<?= $_GET['ve'] ?>" class="yt-button" style="padding: 0.15em 0.8333em;font-size: 12px;margin:0;" type="button">Play</a></div></div>
    </div>
    <?php if (!isset($_GET["analytics"])) : ?>
    <form action="/admin_panel/?page=videos&ve=<?= $_VIDEO->Info["url"] ?>" method="post">
    <div style="font-size: 0; text-align: center;margin-bottom: 10px;" id="user-actions-admin">
            <?php if ($_VIDEO->Info["status"] != 1 && $_VIDEO->Info["file_url"]) : ?>
                <?php if ($_VIDEO->Info["status"] === 2) : ?>
                    <input type="submit" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin:0;" name="change_thumbnail" value="Generate Thumbnail" onclick="if (!confirm('Are you sure that you want to permanently change this videos thumbnail? Also cache must be cleared to view the new one!')) { return false; }"/>
                    <input type="submit" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin:0;" name="feature" value="<?php if (!$_VIDEO->Info["featured"]) : ?>Feature<?php else : ?>Unfeature<?php endif ?>"/>
                    <input type="submit" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin:0;" name="age_restrict" value="<?php if (!$_VIDEO->Info["age_restricted"]) : ?>Age-restrict<?php else : ?>Remove age restriction<?php endif ?>"/>
                <?php endif ?>
                <?php if ($_VIDEO->Info["is_deleted"]) : ?>
                    <?php if ($_USER->Is_Admin) : ?>
                        <input type="submit" name="purge_video" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin:0;" value="Purge" onclick="if (!confirm('Are you sure you want to purge this video? Only the database record will remain!')) { return false }" />
                    <?php endif ?>
                    <input type="submit" name="restore_video" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin:0;" value="Restore" onclick="if (!confirm('Are you sure you want to restore this video?')) { return false }" />
                <?php else: ?>
                    <?php if (!$Strike) : ?>
                        <input type="submit" name="strike_user" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin:0;" value="Copyright Strike" onclick="if (!confirm('Are you sure you want to strike this video's uploader?')) { return false; }"/>
                    <?php endif ?>
                    <input type="submit" name="delete_video" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin:0;" value="Delete" onclick="if (!confirm('Are you sure you want to delete this video?')) { return false }" />
                <?php endif ?>
            <?php endif ?>
        </div>
        </form>
    <form action="/admin_panel/?page=videos&ve=<?= $_VIDEO->Info["url"] ?>" method="post" style="margin:0 auto">
        <div class="a_box">
        <div class="a_box_title">Edit Video Info</div>
        <div style="width:50%;margin-right:1%;float:left;border-right:1px solid #ddd">
            <table cellpadding="4">
                <tr>
                    <td align="right">Title:</td>
                    <td><input type="text" name="title" maxlength="100" value="<?= $_VIDEO->Info["title"] ?>" style="width: 239px;"></td>
                </tr>
                <tr>
                    <td valign="top" align="right">Description:</td>
                    <td><textarea cols="28" name="description" maxlength="2048" rows="6" style="font-family: Arial, sans-serif; resize: vertical;min-height: 100px;width: 241px;"><?= $_VIDEO->Info["description"] ?></textarea></td>
                </tr>
                <tr>
                    <td align="right">Tags:</td>
                    <td><input type="text" name="tags" maxlength="128" style="width: 239px;" value="<?= $_VIDEO->Info["tags"] ?>"></td>
                </tr>
                <tr>
                    <td align="right">Category:</td>
                    <td>
                        <select name="category" style="width:247px">
                            <?php foreach ($_CONFIG::$Categories as $ID => $Category) : ?>
                                <option value="<?= $ID ?>"<?php if ($ID == $_VIDEO->Info["category"]) : ?> selected<?php endif ?>><?= $Category ?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <div style="width:48%;margin-left:0%;float:left">
            <table cellpadding="5">
                <tr>
                    <td align="right">Privacy:</td>
                    <td>
                        <select name="privacy">
                            <option value="1"<?php if ($_VIDEO->Info["privacy"] == 1) : ?> selected<?php endif ?>>Public</option>
                            <option value="2"<?php if ($_VIDEO->Info["privacy"] == 2) : ?> selected<?php endif ?>>Private</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right">Views:</td>
                    <td><input type="number" name="views" maxlength="9" value="<?= $_VIDEO->Info["views"] ?>" style="width:200px"></td>
                </tr>
                <tr>
                    <td align="right">Ratings:</td>
                    <td>
                        <input type="number" name="1star" title="1 Star" maxlength="9" value="<?= $_VIDEO->Info["1stars"] ?>" style="width:31px">
                        <input type="number" name="2star" title="2 Stars" maxlength="9" value="<?= $_VIDEO->Info["2stars"] ?>" style="width:31px">
                        <input type="number" name="3star" title="3 Stars" maxlength="9" value="<?= $_VIDEO->Info["3stars"] ?>" style="width:31px">
                        <input type="number" name="4star" title="4 Stars" maxlength="9" value="<?= $_VIDEO->Info["4stars"] ?>" style="width:31px">
                        <input type="number" name="5star" title="5 Stars" maxlength="9" value="<?= $_VIDEO->Info["5stars"] ?>" style="width:31px"><br />
                        <?php if ($Raters) : ?>
                        <div style="margin-top:5px"><a href="javascript:void(0)" onclick="alert('<?php foreach($Raters as $Rater) : ?><?= $Rater["username"] ?> rated <?= $Rater["rating"] ?> stars\n<?php endforeach ?>')">Who rated this video?</a></div>
                        <?php endif ?>
                    </td>
                </tr>
            </table>
        </div><div style="clear:both"><div style="text-align:center;word-spacing:15px;padding: 10px;border-top: 1px solid #ddd;"><input type="submit" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin:0;margin-bottom:6px" name="save_video" value="Save Information"></div></div>
        </div>
        <div style="clear:both"></div>
    </form>
    <?php else: ?>
        <div>
                        <style>
                            #chartdiv {
                                width   : 100%;
                                height  : 300px;
                                margin-bottom: 5px;
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
                            <div class="a_box_title">View Chart</div>
                            <script>
                                var chart = AmCharts.makeChart("chartdiv", {
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
                            </script>

                            <!-- HTML -->
                            <div id="chartdiv"></div>
                            <style>
                                a[title="JavaScript charts"] {
                                    display: none !important;
                                }
                            </style>
                    </div>
    <?php endif ?>
<?php endif ?>
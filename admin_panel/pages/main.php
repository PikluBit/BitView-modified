<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
if (!$_USER->Logged_In || (!$_USER->Is_Moderator && !$_USER->Is_Admin)) {
    header("location: /");
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php require $_SERVER['DOCUMENT_ROOT'] . "/_templates/_heads/main.php" ?>
        <link href="/css/admin_panel.css" rel="stylesheet" type="text/css" />
        <style>
            .wrapper {
                width: 960px !important;
                margin: 0 auto;
            }
            .admin_l {
                width: 20%;
                margin: 0 2% 0 0;
                float: left;
            }
            .admin_r {
                width: 78%;
                float: left;
            }
            .a_menu {
                background: #D5E5F5;
                border-radius: 5px;
                -moz-border-radius: 5px;
                -webkit-border-radius: 5px;
                overflow: hidden;
                -webkit-box-shadow: 0px 5px 5px 0px rgba(0,0,0,0.25);
                -moz-box-shadow: 0px 5px 5px 0px rgba(0,0,0,0.25);
                box-shadow: 0px 5px 5px 0px rgba(0,0,0,0.25);
            }
            .a_menu > div:first-of-type {
                text-align: center;
                font-weight: bold;
                font-size: 14px;
                padding: 6px;
            }
            .a_menu > a {
                display: block;
                text-decoration: none;
                font-size: 13px;
                padding: 4px 5px;
                margin-bottom: 4px;
                background: #b2daf5
            }
            .a_menu > a:hover, .a_menu #sel {
                background: #cfe1ee;
                color: #0097d6;
            }
            .a_menu > a:last-of-type {
                margin: 0;
            }
            .atable td {
                border: 1px solid #0000002b;
                border-top: 0;
                border-left: 0;
                text-align: left;
            }
            .atable td:last-of-type {
                border-right: 0;
            }
            .atable tr:last-of-type td {
                border-bottom: 0;
            }
            .atable tr:first-of-type td {
                border-left: 1px solid #999;
                border-bottom: 1px solid #999;
                font-size: 11px;
                white-space: nowrap;
                text-overflow: ellipsis;
                background: transparent url(/img/mmgrads-vfl38740.gif) repeat-x scroll 0 0;
                padding: 2px 4px;
            }
            .atable tr:first-of-type td:first-of-type {
                border-left: 0;
            }
            table.atable {
                border-collapse: collapse;
                width: 100%;
            }
            .atable th,.atable td {
                padding: 5px;
            }
            .a_box {
                border: 1px solid #CCC;
                box-sizing: border-box;
                margin-bottom: 15px;
                border-radius: 6px;
            }
            .video_edit_header {
                width: 100%;
                padding-bottom: 10px;
                margin-bottom: 10px;
                border-bottom: 1px solid #ccc;
                overflow: hidden;
            }
            .a_box table {
                padding: 5px;
            }
            .a_box_title {
                position: relative;
                font-size: 14px;
                font-weight: 700;
                padding: 6px 6px 5px 10px;
                background: #eaeaea;
                border-bottom: 1px solid #ccc;
                border-radius: 5px 5px 0 0;
            }
            .yt-uix-button, .yt-button {
                display: inline-block;
                height: auto;
            }
            a[href="http://www.amcharts.com"] {
                display: none!important;
            }
            .videotitle {
                font-weight: bold;
                text-wrap: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                display: block;
            }
            .videothumb {
                border: 3px double #999;
                width: 61px;
                float: left;
                margin-right: 6px;
            }
            .otherchannel {
                padding: 5px;
                border-bottom: 1px solid #ccc;
            }
            .otherchannel:last-of-type {
                border: 0
            }
            .stars img {
                margin-right: -3px;
            }
            .stars {
                pointer-events: none;
            }
            #view-pane .header {
                border-bottom: 1px solid #999;
                padding-bottom: 2px;
            }
            #nav-pane .header {
                border-bottom: 1px solid #999;
                padding-bottom: 7px;
            }
            #list-pane .folder {
                height: auto;
                padding: 4px 8px 4px;
            }
            #list-pane .folder.selected {
                background: url(/img/sel-bck-omar-vfl34546.png);
                height: auto;
                padding: 4px 8px 4px;
            }
            .folder .name {
                color: #333;
                font-weight: normal;
            }
        </style>
    </head>
    <body>
        <?php require $_SERVER['DOCUMENT_ROOT'] . "/_templates/_layout/header.php" ?>
        <div class="wrapper">
            <style type="text/css">
                .videoModifiers {
                    padding: 5px 0px;
                    border-bottom: 1px solid #ccc;
                    text-align: center;
                }
                .videos_box_title {
                    width:90%
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
                .confirmBox, .errorBox {
                    width: 948px;
                    margin: 0 auto;
                    margin-bottom: 6px;
                }
                #user-actions-admin .yt-button {
                    border-radius: 0;
                    border-left-width: 0;
                    font-size: 11px !important;
                }
                #user-actions-admin .yt-button:first-of-type {
                    border-left-width: 1px;
                    border-radius: 3px 0 0 3px;
                }
                #user-actions-admin .yt-button:last-of-type {
                    border-radius: 0 3px 3px 0;
                }
            </style>
            <?php if ($_USER->Has_Permission) : ?>
                <?php require "sidebar.php" ?>
            <?php endif ?>
            <div id="view-pane" style="margin-bottom: 10px;<?php if (!$_USER->Has_Permission) : ?>width:100%<?php endif ?>" >
                <?php if ($_USER->Has_Permission) : ?><div class="header yt2009-sub-header">
                    <div class="pager"></div>
                    <h2><?php
                        if($_PAGE["Page"] == "admin_main") {
                            echo "Overview";
                        }
                        if($_PAGE["Page"] == "admin_users") {
                            echo "Users";
                        }
                        if($_PAGE["Page"] == "admin_interactions") {
                            echo "Interactions";
                        }
                        if($_PAGE["Page"] == "admin_videos") {
                            echo "Videos";
                        }
                        if($_PAGE["Page"] == "admin_contest") {
                            echo "Contests";
                        }
                        if($_PAGE["Page"] == "admin_stats") {
                            echo "Statistics";
                        }
                        if($_PAGE["Page"] == "admin_log") {
                            echo "Audit Log";
                        }
                        if($_PAGE["Page"] == "admin_config") {
                            echo "Settings";
                        }

                    ?></h2>
                </div>
                <div class="splitter">
                    <div class="view">

                        <div id="video_grid" class="marT10 browseListView">
                            <?php require $_PAGE["Page"].".php" ?>
                        </div>

                    </div>
                </div>
                <?php endif ?>
                <?php if (!$_USER->Has_Permission) : ?>
                <div >
                    <div>

                        <div>
                            <?php require $_PAGE["Page"].".php" ?>
                        </div>

                    </div>
                </div>
                <?php endif ?>
            </div>

        <?php require $_SERVER['DOCUMENT_ROOT'] . "/_templates/_layout/footer.php" ?>
    </body>
</html>

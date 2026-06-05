<?php

//* Function to convert Hex colors to RGBA
function hex2rgba( $color, $opacity = false ) {

    $defaultColor = 'rgb(0,0,0)';

    // Return default color if no color provided
    if ( empty( $color ) ) {
        return $defaultColor;
    }

    // Ignore "#" if provided
    if ( $color[0] == '#' ) {
        $color = substr( (string) $color, 1 );
    }

    // Check if color has 6 or 3 characters, get values
    if ( strlen((string) $color) == 6 ) {
        $hex = [ $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] ];
    } elseif ( strlen( (string) $color ) == 3 ) {
        $hex = [ $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] ];
    } else {
        return $default;
    }

    // Convert hex values to rgb values
    $rgb =  array_map( 'hexdec', $hex );

    // Check if opacity is set(rgba or rgb)
    if ( $opacity ) {
        if( abs( $opacity ) > 1 ) {
            $opacity = 1.0;
        }
        $output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode( ",", $rgb ) . ')';
    }

    // Return rgb(a) color string
    return $output;

} ?>
<?php if ($_PROFILE->Info['c_theme'] == "My Old Theme"): ?>
<style>
body, #channel-body { 
<?php if($_PROFILE->Info["c_background_image"]) : ?>
background-image: url(<?= cache_bust($_PROFILE->Info["c_background_image"]) ?>);
<?php if($_PROFILE->Info["c_background_image_fixed"] == 1) : ?>background-attachment: fixed;<?php endif ?>
<?php if($_PROFILE->Info["c_background_image_repeat"] == 1) : ?>background-repeat: repeat;<?php elseif($_PROFILE->Info["c_background_image_repeat"] == 2) : ?>background-repeat: repeat-x;<?php elseif ($_PROFILE->Info["c_background_image_repeat"] == 3) : ?>background-repeat: repeat-y;<?php elseif($_PROFILE->Info["c_background_image_repeat"] == 0) : ?>background-repeat: no-repeat;<?php endif ?> 
<?php if($_PROFILE->Info["c_background_image_position"] == 0) : ?>background-position: top;<?php elseif ($_PROFILE->Info["c_background_image_position"] == 1) : ?>background-position: center;<?php elseif ($_PROFILE->Info["c_background_image_position"] == 2) : ?>background-position: bottom;<?php endif ?>
background-size: auto;
<?php endif ?>
font-family: <?= $_PROFILE->Info["c_font"] ?>,<?php if($_PROFILE->Info["c_font"] == "Arial" or $_PROFILE->Info["c_font"] == "Verdana") : ?>sans-serif<?php elseif ($_PROFILE->Info["c_font"] == "Georgia" or $_PROFILE->Info["c_font"] == "Times New Roman") : ?>serif<?php elseif($_PROFILE->Info["c_font"] == "Courier New") : ?>monospace<?php endif ?>!important;
}
#channel-body {
    background-color: #<?= $_PROFILE->Info["c_background"] ?> !important; 
}
#channel_edit_close {
    color: #<?= $_PROFILE->Info["c_link_color"] ?>;
    cursor: pointer;
    border-bottom: 1px dotted;
}
#masthead-container {
    border-bottom: 3px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
}
.outer-box {
    color: #<?= $_PROFILE->Info["c_link_color"] ?>;
}
.outer-box {
    background-color: #<?= $_PROFILE->Info["c_highlight_inner"] ?>;
}
.inner-box-bg-color {
    background-color: #<?= $_PROFILE->Info["c_normal_inner"] ?>;
}
.outer-box-bg-color {
    color: #<?= $_PROFILE->Info["c_link_color"] ?>;
}
.outer-box-bg-color {
    background-color: #<?= $_PROFILE->Info["c_highlight_inner"] ?>;
}
.outer-box-color-as-border-color {
    border-color: #<?= $_PROFILE->Info["c_link_color"] ?>;
}
.outer-box-color {
    color: #<?= $_PROFILE->Info["c_link_color"] ?>;
}
#playnav-chevron {
    border-left-color: #<?= $_PROFILE->Info["c_highlight_inner"] ?>;
}
#playnav-navbar a.navbar-tab-selected, #playnav-navbar a.navbar-tab:hover {
    color: #<?= $_PROFILE->Info["c_normal_inner"] ?> !important;
}
#playnav-navbar a.navbar-tab-selected, #playnav-navbar a.navbar-tab:hover {
    background-color: #<?= $_PROFILE->Info["c_highlight_inner"] ?>;
}
.outer-box .inner-box-bg-color a {
    color: #<?= $_PROFILE->Info["c_link_color"] ?>;
}
.outer-box .inner-box-link-color {
    color: #<?= $_PROFILE->Info["c_link_color"] ?>;
}
.outer-box a {
    color: #<?= $_PROFILE->Info["c_link_color"] ?>;
}
a.view-button-selected .tri, .view-button:hover .tri {
    border-top-color: #<?= $_PROFILE->Info["c_normal_inner"] ?>;
    border-bottom-color: #<?= $_PROFILE->Info["c_normal_inner"] ?>;
    background-color: #<?= $_PROFILE->Info["c_normal_inner"] ?>;
}
a.view-button-selected .a, .view-button:hover .a {
    background-color: #<?= $_PROFILE->Info["c_normal_inner"] ?>!important;
}
a.view-button-selected .tri, a.view-button:hover .tri {
    border-left-color: #<?= $_PROFILE->Info["c_title_font"] ?>!important;
}
a.view-button-selected, a.view-button:hover {
    background-color: #<?= $_PROFILE->Info["c_highlight_inner"] ?>;
}
.view-button .tri {
    border-left-color: #<?= $_PROFILE->Info["c_normal_inner"] ?>;
}
.view-button .tri {
    background-color: #<?= $_PROFILE->Info["c_link_color"] ?>;
}
.view-button .tri {
    border-top-color: #<?= $_PROFILE->Info["c_link_color"] ?>;
    border-bottom-color: #<?= $_PROFILE->Info["c_link_color"] ?>;
}
.view-button .a {
    background-color: #<?= $_PROFILE->Info["c_link_color"] ?>;
}
.inner-box-colors {
    background-color: #<?= $_PROFILE->Info["c_normal_inner"] ?>;
}
.inner-box-colors {
    color: #<?= $_PROFILE->Info["c_normal_font"] ?>;
}
.panel-tab-selected .panel-tab-indicator-arrow {
    border-bottom-color: #<?= $_PROFILE->Info["c_normal_inner"] ?> !important;
}
.panel-tab-indicator-arrow {
    border-color: #<?= $_PROFILE->Info["c_highlight_inner"] ?>;
}
a.title-text-color, .title-text-color a {
    color: #<?= $_PROFILE->Info["c_title_font"] ?> !important;
}
.title-text-color {
    color: #<?= $_PROFILE->Info["c_title_font"] ?> !important;
}
.playnav-item .selector {
    background-color: #<?= $_PROFILE->Info["c_highlight_inner"] ?>;
}
.link-as-border-color {
    border-color: #<?= $_PROFILE->Info["c_link_color"] ?>;
}
.outer-box-bg-as-border {
    border-color: #<?= $_PROFILE->Info["c_highlight_inner"] ?>;
}
.channel-cmd {
    border-bottom-color: #<?= $_PROFILE->Info["c_link_color"] ?>;
}
#playnav-video-panel-loading {
    background-color: #<?= $_PROFILE->Info["c_normal_inner"] ?> !important;
}
.inner-box {
    background-color: #<?= $_PROFILE->Info["c_normal_inner"] ?>;
}
.inner-box {
    color: #<?= $_PROFILE->Info["c_normal_font"] ?>;
}
.outer-box .inner-box a, .outer-box .inner-box-colors a {
    color: #<?= $_PROFILE->Info["c_link_color"] ?>;
    font-family: <?= $_PROFILE->Info["c_font"] ?>,<?php if($_PROFILE->Info["c_font"] == "Arial" or $_PROFILE->Info["c_font"] == "Verdana") : ?>sans-serif<?php elseif ($_PROFILE->Info["c_font"] == "Georgia" or $_PROFILE->Info["c_font"] == "Times New Roman") : ?>serif<?php elseif($_PROFILE->Info["c_font"] == "Courier New") : ?>monospace<?php endif ?>!important;
}
.box-outline-color {
    border-color: #333333;
}
a.view-button-selected, a.view-button:hover, #playnav-navbar a.navbar-tab-selected, #playnav-navbar a.navbar-tab:hover {
    background-color: #<?= $_PROFILE->Info["c_title_font"] ?>;
}
.playnav-bottom-link > a {
    color: #<?= $_PROFILE->Info['c_link_color'] ?> !important;
}
.panel-tab-selected .playnav-bottom-link > a {
    color: #<?= $_PROFILE->Info["c_link_color"] ?> !important;
}
</style>
<?php else:?>
<?php 
$Custom_Theme = $DB->execute("SELECT * FROM users_themes WHERE by_user = :USERNAME LIMIT 1",true,[":USERNAME" => $_PROFILE->Username]);
if (!$Custom_Theme) {
    $Custom_Theme = [];
}
$wrapperOpacity = 1;
$boxOpacity = 1;
$repeatBackground = 0;
if (!$Custom_Theme || $_PROFILE->Info['c_theme'] == "Grey") {
    $backgroundColor = "CCCCCC";
    $wrapperColor = "999999";
    $wrapperTextColor = "000000";
    $wrapperLinkColor = "0000cc";
    $boxBackgroundColor = "eeeeff";
    $titleTextColor = "000000";
    $linkColor = "0000cc";
    $bodyTextColor = "333333";
    $font = "Arial";
}
if ($_PROFILE->Info['c_theme'] == "Blue") {
    $backgroundColor = "003366";
    $wrapperColor = "0066CC";
    $wrapperTextColor = "ffffff";
    $wrapperLinkColor = "0000CC";
    $boxBackgroundColor = "3D8BD8";
    $titleTextColor = "ffffff";
    $linkColor = "99C2EB";
    $bodyTextColor = "ffffff";
    $font = "Arial";
}
if ($_PROFILE->Info['c_theme'] == "Red") {
    $backgroundColor = "660000";
    $wrapperColor = "990000";
    $wrapperTextColor = "FFFFFF";
    $wrapperLinkColor = "FF0000";
    $boxBackgroundColor = "660000";
    $titleTextColor = "FFFFFF";
    $linkColor = "FF0000";
    $bodyTextColor = "FFFFFF";
    $font = "Arial";
}
if ($_PROFILE->Info['c_theme'] == "Sunlight") {
    $backgroundColor = "FFE599";
    $wrapperColor = "E69138";
    $wrapperTextColor = "FFFFFF";
    $wrapperLinkColor = "FFD966";
    $boxBackgroundColor = "FFD966";
    $titleTextColor = "E69138";
    $linkColor = "E69138";
    $bodyTextColor = "E69138";
    $font = "Arial";
}
if ($_PROFILE->Info['c_theme'] == "Forest") {
    $backgroundColor = "274E13";
    $wrapperColor = "38761D";
    $wrapperTextColor = "FFFFFF";
    $wrapperLinkColor = "FFFFFF";
    $boxBackgroundColor = "6AA84F";
    $titleTextColor = "274E13";
    $linkColor = "38761D";
    $bodyTextColor = "274E13";
    $font = "Arial";
}
if ($_PROFILE->Info['c_theme'] == "8-bit") {
    $backgroundColor = "666666";
    $wrapperColor = "444444";
    $wrapperTextColor = "FFFFFF";
    $wrapperLinkColor = "FF0000";
    $boxBackgroundColor = "000000";
    $titleTextColor = "AAAAAA";
    $linkColor = "FF0000";
    $bodyTextColor = "666666";
    $font = "Courier New";
}
if ($_PROFILE->Info['c_theme'] == "Princess") {
    $backgroundColor = "FF99CC";
    $wrapperColor = "aa66cc";
    $wrapperTextColor = "FFFFFF";
    $wrapperLinkColor = "351C75";
    $boxBackgroundColor = "FFFFFF";
    $titleTextColor = "8a2c87";
    $linkColor = "351C75";
    $bodyTextColor = "333366";
    $font = "Arial";
}
if ($_PROFILE->Info['c_theme'] == "Fire") {
    $backgroundColor = "660000";
    $wrapperColor = "FF0000";
    $wrapperTextColor = "ffffff";
    $wrapperLinkColor = "FFFF00";
    $boxBackgroundColor = "FF9900";
    $titleTextColor = "FFFF00";
    $linkColor = "FFDBA6";
    $bodyTextColor = "FFFFFF";
    $font = "Arial";
}
if ($_PROFILE->Info['c_theme'] == "Stealth") {
    $backgroundColor = "000000";
    $wrapperColor = "444444";
    $wrapperTextColor = "000000";
    $wrapperLinkColor = "CCCCCC";
    $boxBackgroundColor = "666666";
    $titleTextColor = "000000";
    $linkColor = "444444";
    $bodyTextColor = "444444";
    $font = "Arial";
}
if ($_PROFILE->Info['c_theme'] == "Clean") {
    $backgroundColor = "FFFFFF";
    $wrapperColor = "D6D6D6";
    $wrapperTextColor = "666666";
    $wrapperLinkColor = "0033CC";
    $boxBackgroundColor = "FFFFFF";
    $titleTextColor = "666666";
    $linkColor = "0033CC";
    $bodyTextColor = "000000";
    $font = "Arial";
}
if ($Custom_Theme && $_PROFILE->Info['c_theme'] == "Custom") {
    $wrapperOpacity = $Custom_Theme['wrapper_opacity'];
    $boxOpacity = $Custom_Theme['box_opacity'];
    $backgroundColor = $Custom_Theme['background_color'];
    $wrapperColor = $Custom_Theme['wrapper_color'];
    $wrapperTextColor = $Custom_Theme["wrapper_text_color"];
    $wrapperLinkColor = $Custom_Theme['wrapper_link_color'];
    $boxBackgroundColor = $Custom_Theme["box_background_color"];
    $titleTextColor = $Custom_Theme["title_text_color"];
    $linkColor = $Custom_Theme["link_color"];
    $bodyTextColor = $Custom_Theme["body_text_color"];
    $font = $Custom_Theme["font"];
    $repeatBackground = $Custom_Theme["background_repeat_check"];
} ?>
<style>
body, #channel-body { 
<?php if($_PROFILE->Info["c_background_image"]) : ?>
background-image: url(<?= cache_bust($_PROFILE->Info["c_background_image"]) ?>);
<?php if($repeatBackground == 1) : ?>background-repeat: repeat;<?php elseif($repeatBackground == 0) : ?>background-repeat: no-repeat;<?php endif ?> 
background-size: auto;
<?php endif ?>
font-family: <?= $font ?>,<?php if($font == "Arial" or $font == "Verdana") : ?>sans-serif<?php elseif($font == "Georgia" or $font == "Times New Roman") : ?>serif<?php elseif($font == "Courier New") : ?>monospace<?php endif ?>!important;
}
#channel-body {
    background-color: #<?= $backgroundColor ?> !important; 
}
#channel_edit_close {
    color: #<?= $linkColor ?>;
    cursor: pointer;
    border-bottom: 1px dotted;
}
#masthead-container {
    border-bottom: 3px solid #<?= $wrapperColor ?> !important;
}
.outer-box {
    color: #<?= $wrapperTextColor ?>;
}
.outer-box {
    background-color: <?= hex2rgba($wrapperColor, $wrapperOpacity) ?>;
}
.inner-box-bg-color {
    background-color: <?= hex2rgba($boxBackgroundColor,$boxOpacity) ?>;
}
.outer-box-bg-color {
    color: #<?= $wrapperTextColor ?>;
}
.outer-box-bg-color {
    background-color: <?= hex2rgba($wrapperColor,$wrapperOpacity) ?>;
}
.outer-box-color-as-border-color {
    border-color: #<?= $wrapperTextColor ?>;
}
.outer-box-color {
    color: #<?= $wrapperTextColor ?>;
}
#playnav-chevron {
    border-left-color: <?= hex2rgba($wrapperColor,$wrapperOpacity) ?>;
}
#playnav-navbar a.navbar-tab-selected, #playnav-navbar a.navbar-tab:hover {
    color: #<?= $boxBackgroundColor ?> !important;
}
#playnav-navbar a.navbar-tab-selected, #playnav-navbar a.navbar-tab:hover {
    background-color: #<?= $titleTextColor ?>;
}
.outer-box .inner-box-bg-color a {
    color: #<?= $linkColor ?>;
}
.outer-box .inner-box-link-color {
    color: #<?= $linkColor ?>;
}
.outer-box a {
    color: #<?= $linkColor ?>;
}
a.view-button-selected .tri, .view-button:hover .tri {
    border-top-color: #<?= $boxBackgroundColor ?>;
    border-bottom-color: #<?= $boxBackgroundColor ?>;
    background-color: #<?= $boxBackgroundColor ?>;
}
a.view-button-selected .a, .view-button:hover .a {
    background-color: #<?= $boxBackgroundColor ?>!important;
}
a.view-button-selected .tri, a.view-button:hover .tri {
    border-left-color: #<?= $titleTextColor ?>!important;
}
a.view-button-selected, a.view-button:hover {
    background-color: #<?= $titleTextColor ?>!important;
}
.view-button .tri {
    border-left-color: #<?= $boxBackgroundColor ?>;
}
.view-button .tri {
    background-color: #<?= $linkColor ?>;
}
.view-button .tri {
    border-top-color: #<?= $linkColor ?>;
    border-bottom-color: #<?= $linkColor ?>;
}
.view-button .a {
    background-color: #<?= $linkColor ?>;
}
.inner-box-colors {
    background-color: <?= hex2rgba($boxBackgroundColor,$boxOpacity) ?>;
}
.inner-box-colors {
    color: #<?= $bodyTextColor ?>;
}
.panel-tab-selected .panel-tab-indicator-arrow {
    border-bottom-color: <?= hex2rgba($boxBackgroundColor,$boxOpacity) ?> !important;
}
a.title-text-color, .title-text-color a {
    color: #<?= $titleTextColor ?> !important;
}
.title-text-color {
    color: #<?= $titleTextColor ?> !important;
}
.playnav-item .selector {
    background-color: #<?= $wrapperColor ?>;
}
.link-as-border-color {
    border-color: #<?= $linkColor ?>;
}
.outer-box-bg-as-border {
    border-color: #<?= $wrapperColor ?>;
}
.channel-cmd {
    border-bottom-color: #<?= $linkColor ?>;
}
#playnav-video-panel-loading {
    background-color: #<?= $boxBackgroundColor ?> !important;
}
.inner-box {
    background-color: <?= hex2rgba($boxBackgroundColor,$boxOpacity) ?>;
}
.outer-box .inner-box a, .outer-box .inner-box-colors a {
    color: #<?= $linkColor ?>;
    font-family: <?= $font ?>,<?php if($font == "Arial" or $font == "Verdana") : ?>sans-serif<?php elseif($font == "Georgia" or $font == "Times New Roman") : ?>serif<?php elseif($font == "Courier New") : ?>monospace<?php endif ?>!important;
}
.box-outline-color {
    border-color: #333333;
}
a.view-button-selected, a.view-button:hover, #playnav-navbar a.navbar-tab-selected, #playnav-navbar a.navbar-tab:hover {
    background-color: #<?= $titleTextColor ?>;
}
.playnav-bottom-link > a {
    color: #<?= $wrapperLinkColor ?> !important;
}
.panel-tab-selected .playnav-bottom-link > a {
    color: #<?= $wrapperTextColor ?> !important;
}
a.inner-box-color-as-link, .inner-box-colors .playnav-show .show-facets .show-mini-description, .inner-box-color, .inner-box {
    color: #<?= $bodyTextColor ?> !important;
}
</style>
<?php endif ?>
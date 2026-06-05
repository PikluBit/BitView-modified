<?php 
$Custom_Theme = $DB->execute("SELECT * FROM users_themes WHERE by_user = :USERNAME LIMIT 1",false,[":USERNAME" => $_PROFILE->Username]);
if (!$Custom_Theme) {
    $Custom_Theme = [];
}
if ($_PROFILE->Info['c_theme'] == "Grey") {
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
if ($_PROFILE->Info['c_theme'] == "My Old Theme") {
    $backgroundColor = $_PROFILE->Info['c_background'];
    $wrapperColor = $_PROFILE->Info['c_highlight_inner'];
    $wrapperTextColor = $_PROFILE->Info["c_link_color"];
    $wrapperLinkColor = $_PROFILE->Info['c_link_color'];
    $boxBackgroundColor = $_PROFILE->Info["c_normal_inner"];
    $titleTextColor = $_PROFILE->Info["c_title_font"];
    $linkColor = $_PROFILE->Info["c_link_color"];
    $bodyTextColor = $_PROFILE->Info["c_normal_font"];
    $font = $_PROFILE->Info["c_font"];
}
if ($_PROFILE->Info['c_theme'] == "Custom" && $Custom_Theme) {
    foreach ($Custom_Theme as $Custom) {
        if ($Custom['wrapper_opacity'] != 0) {
            $wrapperOpacity = dechex((int) $Custom['wrapper_opacity'] * 255);
        }
        else {
            $wrapperOpacity = "00";
        }
        if ($Custom['box_opacity'] != 0) {
            $boxOpacity = dechex((int) $Custom['box_opacity'] * 255);
        }
        else {
            $boxOpacity = "00";
        }
        $backgroundColor = $Custom['background_color'];
        $wrapperColor = $Custom['wrapper_color'];
        $wrapperTextColor = $Custom["wrapper_text_color"];
        $wrapperLinkColor = $Custom['wrapper_link_color'];
        $boxBackgroundColor = $Custom["box_background_color"];
        $titleTextColor = $Custom["title_text_color"];
        $linkColor = $Custom["link_color"];
        $bodyTextColor = $Custom["body_text_color"];
        $font = $Custom["font"];
        $repeatBackground = $Custom["background_repeat_check"];
    }
} ?>
<script>
    
function set_theme_obj(e) {
    <?php if ($Custom_Theme): ?>
    <?php foreach ($Custom_Theme as $Custom): ?>
    if (document.getElementsByClassName('theme_selected')[0] > 1 && document.getElementsByClassName('theme_selected')[0].id == "custom" && (_gel('background_color').value != "#<?= $Custom['background_color'] ?>" || _gel('wrapper_color').value != "#<?= $Custom['wrapper_color'] ?>" || _gel('wrapper_text_color').value != "#<?= $Custom['wrapper_text_color'] ?>" || _gel('wrapper_link_color').value != "#<?= $Custom['wrapper_link_color'] ?>" || (_gel('wrapper_opacity').value / 100) != "<?= $Custom['wrapper_opacity'] ?>" || _gel('background_repeat_check').checked != "<?= $Custom['background_repeat_check'] ?>" || _gel('box_background_color').value != "#<?= $Custom['box_background_color'] ?>" || _gel('title_text_color').value != "#<?= $Custom['title_text_color'] ?>" || _gel('link_color').value != "#<?= $Custom['link_color'] ?>" || _gel('body_text_color').value != "#<?= $Custom['body_text_color'] ?>" || (_gel('box_opacity').value / 100) != "<?= $Custom['box_opacity'] ?>") && theme_saved == false) {
        var confirmation = confirm("<?= $LANGS['unsavedchanges'] ?>");
    }
    else {
        var confirmation = true;
    }
    <?php endforeach ?>
    <?php else: ?>
    var confirmation = true;
    <?php endif ?>
    if (confirmation == true) {
    document.getElementsByClassName("theme_selected")[0].classList.remove("theme_selected");
    _gel(e).classList.add("theme_selected")
    if (e == "default") {
        select_popup_color("#CCCCCC","background_color","no");
        _gel('background_color-preview').style.backgroundColor = "#CCCCCC";
        _gel('background_color').value = "#CCCCCC";

        select_popup_color("#999999","wrapper_color","no");
        _gel('wrapper_color-preview').style.backgroundColor = "#999999";
        _gel('wrapper_color').value = "#999999";

        select_popup_color("#000000","wrapper_text_color","no");
        _gel('wrapper_text_color-preview').style.backgroundColor = "#000000";
        _gel('wrapper_text_color').value = "#000000";

        select_popup_color("#0000cc","wrapper_link_color","no");
        _gel('wrapper_link_color-preview').style.backgroundColor = "#0000cc";
        _gel('wrapper_link_color').value = "#0000cc";

        select_popup_color("#eeeeff","box_background_color","no");
        _gel('box_background_color-preview').style.backgroundColor = "#eeeeff";
        _gel('box_background_color').value = "#eeeeff";

        select_popup_color("#000000","title_text_color","no");
        _gel('title_text_color-preview').style.backgroundColor = "#000000";
        _gel('title_text_color').value = "#000000";

        select_popup_color("#0000cc","link_color","no");
        _gel('link_color-preview').style.backgroundColor = "#0000cc";
        _gel('link_color').value = "#0000cc";

        select_popup_color("#333333","body_text_color","no");
        _gel('body_text_color-preview').style.backgroundColor = "#333333";
        _gel('body_text_color').value = "#333333";

        _gel('wrapper_opacity').value = "100";
        _gel('box_opacity').value = "100";

        var style = 'body, #channel-body {font-family: Arial, sans-serif !important;} .outer-box .inner-box a, .outer-box .inner-box-colors a {font-family: Arial, sans-serif !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
        _gel('theme_edit_name').value = "Grey";
        _gel('theme_display_name').innerHTML = "Grey";
        _gel("background_repeat_check").checked = 0;
    }
    if (e == "blue") {
        select_popup_color("#003366","background_color","no");
        _gel('background_color-preview').style.backgroundColor = "#003366";
        _gel('background_color').value = "#003366";

        select_popup_color("#0066CC","wrapper_color","no");
        _gel('wrapper_color-preview').style.backgroundColor = "#0066CC";
        _gel('wrapper_color').value = "#0066CC";

        select_popup_color("#ffffff","wrapper_text_color","no");
        _gel('wrapper_text_color-preview').style.backgroundColor = "#ffffff";
        _gel('wrapper_text_color').value = "#ffffff";

        select_popup_color("#0000CC","wrapper_link_color","no");
        _gel('wrapper_link_color-preview').style.backgroundColor = "#0000CC";
        _gel('wrapper_link_color').value = "#0000CC";

        select_popup_color("#3D8BD8","box_background_color","no");
        _gel('box_background_color-preview').style.backgroundColor = "#3D8BD8";
        _gel('box_background_color').value = "#3D8BD8";

        select_popup_color("#ffffff","title_text_color","no");
        _gel('title_text_color-preview').style.backgroundColor = "#ffffff";
        _gel('title_text_color').value = "#ffffff";

        select_popup_color("#99C2EB","link_color","no");
        _gel('link_color-preview').style.backgroundColor = "#99C2EB";
        _gel('link_color').value = "#99C2EB";

        select_popup_color("#ffffff","body_text_color","no");
        _gel('body_text_color-preview').style.backgroundColor = "#ffffff";
        _gel('body_text_color').value = "#ffffff";

        _gel('wrapper_opacity').value = "100";
        _gel('box_opacity').value = "100";

        var style = 'body, #channel-body {font-family: Arial, sans-serif !important;} .outer-box .inner-box a, .outer-box .inner-box-colors a {font-family: Arial, sans-serif !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
        _gel('theme_edit_name').value = "Blue";
        _gel('theme_display_name').innerHTML = "Blue";
        _gel("background_repeat_check").checked = 0;
    }
    if (e == "scary") {
        select_popup_color("#660000","background_color","no");
        _gel('background_color-preview').style.backgroundColor = "#660000";
        _gel('background_color').value = "#660000";

        select_popup_color("#990000","wrapper_color","no");
        _gel('wrapper_color-preview').style.backgroundColor = "#990000";
        _gel('wrapper_color').value = "#990000";

        select_popup_color("#ffffff","wrapper_text_color","no");
        _gel('wrapper_text_color-preview').style.backgroundColor = "#ffffff";
        _gel('wrapper_text_color').value = "#ffffff";

        select_popup_color("#FF0000","wrapper_link_color","no");
        _gel('wrapper_link_color-preview').style.backgroundColor = "#FF0000";
        _gel('wrapper_link_color').value = "#FF0000";

        select_popup_color("#660000","box_background_color","no");
        _gel('box_background_color-preview').style.backgroundColor = "#660000";
        _gel('box_background_color').value = "#660000";

        select_popup_color("#ffffff","title_text_color","no");
        _gel('title_text_color-preview').style.backgroundColor = "#ffffff";
        _gel('title_text_color').value = "#ffffff";

        select_popup_color("#FF0000","link_color","no");
        _gel('link_color-preview').style.backgroundColor = "#FF0000";
        _gel('link_color').value = "#FF0000";

        select_popup_color("#ffffff","body_text_color","no");
        _gel('body_text_color-preview').style.backgroundColor = "#ffffff";
        _gel('body_text_color').value = "#ffffff";

        _gel('wrapper_opacity').value = "100";
        _gel('box_opacity').value = "100";

        var style = 'body, #channel-body {font-family: Arial, sans-serif !important;} .outer-box .inner-box a, .outer-box .inner-box-colors a {font-family: Arial, sans-serif !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
        _gel('theme_edit_name').value = "Red";
        _gel('theme_display_name').innerHTML = "Red";
        _gel("background_repeat_check").checked = 0;
    }
    if (e == "sunlight") {
        select_popup_color("#FFE599","background_color","no");
        _gel('background_color-preview').style.backgroundColor = "#FFE599";
        _gel('background_color').value = "#FFE599";

        select_popup_color("#E69138","wrapper_color","no");
        _gel('wrapper_color-preview').style.backgroundColor = "#E69138";
        _gel('wrapper_color').value = "#E69138";

        select_popup_color("#ffffff","wrapper_text_color","no");
        _gel('wrapper_text_color-preview').style.backgroundColor = "#ffffff";
        _gel('wrapper_text_color').value = "#ffffff";

        select_popup_color("#FFD966","wrapper_link_color","no");
        _gel('wrapper_link_color-preview').style.backgroundColor = "#FFD966";
        _gel('wrapper_link_color').value = "#FFD966";

        select_popup_color("#FFD966","box_background_color","no");
        _gel('box_background_color-preview').style.backgroundColor = "#FFD966";
        _gel('box_background_color').value = "#FFD966";

        select_popup_color("#E69138","title_text_color","no");
        _gel('title_text_color-preview').style.backgroundColor = "#E69138";
        _gel('title_text_color').value = "#E69138";

        select_popup_color("#E69138","link_color","no");
        _gel('link_color-preview').style.backgroundColor = "#E69138";
        _gel('link_color').value = "#E69138";

        select_popup_color("#E69138","body_text_color","no");
        _gel('body_text_color-preview').style.backgroundColor = "#E69138";
        _gel('body_text_color').value = "#E69138";

        _gel('wrapper_opacity').value = "100";
        _gel('box_opacity').value = "100";

        var style = 'body, #channel-body {font-family: Arial, sans-serif !important;} .outer-box .inner-box a, .outer-box .inner-box-colors a {font-family: Arial, sans-serif !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
        _gel('theme_edit_name').value = "Sunlight";
        _gel('theme_display_name').innerHTML = "Sunlight";
        _gel("background_repeat_check").checked = 0;
    }
    if (e == "forest") {
        select_popup_color("#274E13","background_color","no");
        _gel('background_color-preview').style.backgroundColor = "#274E13";
        _gel('background_color').value = "#274E13";

        select_popup_color("#38761D","wrapper_color","no");
        _gel('wrapper_color-preview').style.backgroundColor = "#38761D";
        _gel('wrapper_color').value = "#38761D";

        select_popup_color("#ffffff","wrapper_text_color","no");
        _gel('wrapper_text_color-preview').style.backgroundColor = "#ffffff";
        _gel('wrapper_text_color').value = "#ffffff";

        select_popup_color("#ffffff","wrapper_link_color","no");
        _gel('wrapper_link_color-preview').style.backgroundColor = "#ffffff";
        _gel('wrapper_link_color').value = "#ffffff";

        select_popup_color("#6AA84F","box_background_color","no");
        _gel('box_background_color-preview').style.backgroundColor = "#6AA84F";
        _gel('box_background_color').value = "#6AA84F";

        select_popup_color("#274E13","title_text_color","no");
        _gel('title_text_color-preview').style.backgroundColor = "#274E13";
        _gel('title_text_color').value = "#274E13";

        select_popup_color("#38761D","link_color","no");
        _gel('link_color-preview').style.backgroundColor = "#38761D";
        _gel('link_color').value = "#38761D";

        select_popup_color("#274E13","body_text_color","no");
        _gel('body_text_color-preview').style.backgroundColor = "#274E13";
        _gel('body_text_color').value = "#274E13";

        _gel('wrapper_opacity').value = "100";
        _gel('box_opacity').value = "100";

        var style = 'body, #channel-body {font-family: Arial, sans-serif !important;} .outer-box .inner-box a, .outer-box .inner-box-colors a {font-family: Arial, sans-serif !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
        _gel('theme_edit_name').value = "Forest";
        _gel('theme_display_name').innerHTML = "Forest";
        _gel("background_repeat_check").checked = 0;
    }
    if (e == "8bit") {
        select_popup_color("#666666","background_color","no");
        _gel('background_color-preview').style.backgroundColor = "#666666";
        _gel('background_color').value = "#666666";

        select_popup_color("#444444","wrapper_color","no");
        _gel('wrapper_color-preview').style.backgroundColor = "#444444";
        _gel('wrapper_color').value = "#444444";

        select_popup_color("#FFFFFF","wrapper_text_color","no");
        _gel('wrapper_text_color-preview').style.backgroundColor = "#FFFFFF";
        _gel('wrapper_text_color').value = "#FFFFFF";

        select_popup_color("#FF0000","wrapper_link_color","no");
        _gel('wrapper_link_color-preview').style.backgroundColor = "#FF0000";
        _gel('wrapper_link_color').value = "#FF0000";

        select_popup_color("#000000","box_background_color","no");
        _gel('box_background_color-preview').style.backgroundColor = "#000000";
        _gel('box_background_color').value = "#000000";

        select_popup_color("#AAAAAA","title_text_color","no");
        _gel('title_text_color-preview').style.backgroundColor = "#AAAAAA";
        _gel('title_text_color').value = "#AAAAAA";

        select_popup_color("#FF0000","link_color","no");
        _gel('link_color-preview').style.backgroundColor = "#FF0000";
        _gel('link_color').value = "#FF0000";

        select_popup_color("#666666","body_text_color","no");
        _gel('body_text_color-preview').style.backgroundColor = "#666666";
        _gel('body_text_color').value = "#666666";

        _gel('wrapper_opacity').value = "100";
        _gel('box_opacity').value = "100";

        var style = 'body, #channel-body {font-family: Courier New, monospaced !important;} .outer-box .inner-box a, .outer-box .inner-box-colors a {font-family: Arial, sans-serif !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
        _gel('theme_edit_name').value = "8-bit";
        _gel('theme_display_name').innerHTML = "8-bit";
        _gel("background_repeat_check").checked = 0;
    }
    if (e == "princess") {
        select_popup_color("#FF99CC","background_color","no");
        _gel('background_color-preview').style.backgroundColor = "#FF99CC";
        _gel('background_color').value = "#FF99CC";

        select_popup_color("#aa66cc","wrapper_color","no");
        _gel('wrapper_color-preview').style.backgroundColor = "#aa66cc";
        _gel('wrapper_color').value = "#aa66cc";

        select_popup_color("#FFFFFF","wrapper_text_color","no");
        _gel('wrapper_text_color-preview').style.backgroundColor = "#FFFFFF";
        _gel('wrapper_text_color').value = "#FFFFFF";

        select_popup_color("#351C75","wrapper_link_color","no");
        _gel('wrapper_link_color-preview').style.backgroundColor = "#351C75";
        _gel('wrapper_link_color').value = "#351C75";

        select_popup_color("#FFFFFF","box_background_color","no");
        _gel('box_background_color-preview').style.backgroundColor = "#FFFFFF";
        _gel('box_background_color').value = "#FFFFFF";

        select_popup_color("#8a2c87","title_text_color","no");
        _gel('title_text_color-preview').style.backgroundColor = "#8a2c87";
        _gel('title_text_color').value = "#8a2c87";

        select_popup_color("#351C75","link_color","no");
        _gel('link_color-preview').style.backgroundColor = "#351C75";
        _gel('link_color').value = "#351C75";

        select_popup_color("#333366","body_text_color","no");
        _gel('body_text_color-preview').style.backgroundColor = "#333366";
        _gel('body_text_color').value = "#333366";

        _gel('wrapper_opacity').value = "100";
        _gel('box_opacity').value = "100";

        var style = 'body, #channel-body {font-family: Arial, sans-serif !important;} .outer-box .inner-box a, .outer-box .inner-box-colors a {font-family: Arial, sans-serif !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
        _gel('theme_edit_name').value = "Princess";
        _gel('theme_display_name').innerHTML = "Princess";
        _gel("background_repeat_check").checked = 0;
    }
    if (e == "fire") {
        select_popup_color("#660000","background_color","no");
        _gel('background_color-preview').style.backgroundColor = "#660000";
        _gel('background_color').value = "#660000";

        select_popup_color("#FF0000","wrapper_color","no");
        _gel('wrapper_color-preview').style.backgroundColor = "#FF0000";
        _gel('wrapper_color').value = "#FF0000";

        select_popup_color("#FFFFFF","wrapper_text_color","no");
        _gel('wrapper_text_color-preview').style.backgroundColor = "#FFFFFF";
        _gel('wrapper_text_color').value = "#FFFFFF";

        select_popup_color("#FFFF00","wrapper_link_color","no");
        _gel('wrapper_link_color-preview').style.backgroundColor = "#FFFF00";
        _gel('wrapper_link_color').value = "#FFFF00";

        select_popup_color("#FF9900","box_background_color","no");
        _gel('box_background_color-preview').style.backgroundColor = "#FF9900";
        _gel('box_background_color').value = "#FF9900";

        select_popup_color("#FFFF00","title_text_color","no");
        _gel('title_text_color-preview').style.backgroundColor = "#FFFF00";
        _gel('title_text_color').value = "#FFFF00";

        select_popup_color("#FFDBA6","link_color","no");
        _gel('link_color-preview').style.backgroundColor = "#FFDBA6";
        _gel('link_color').value = "#FFDBA6";

        select_popup_color("#FFFFFF","body_text_color","no");
        _gel('body_text_color-preview').style.backgroundColor = "#FFFFFF";
        _gel('body_text_color').value = "#FFFFFF";

        _gel('wrapper_opacity').value = "100";
        _gel('box_opacity').value = "100";

        var style = 'body, #channel-body {font-family: Arial, sans-serif !important;} .outer-box .inner-box a, .outer-box .inner-box-colors a {font-family: Arial, sans-serif !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
        _gel('theme_edit_name').value = "Fire";
        _gel('theme_display_name').innerHTML = "Fire";
        _gel("background_repeat_check").checked = 0;
    }
    if (e == "stealth") {
        select_popup_color("#000000","background_color","no");
        _gel('background_color-preview').style.backgroundColor = "#000000";
        _gel('background_color').value = "#000000";

        select_popup_color("#444444","wrapper_color","no");
        _gel('wrapper_color-preview').style.backgroundColor = "#444444";
        _gel('wrapper_color').value = "#444444";

        select_popup_color("#000000","wrapper_text_color","no");
        _gel('wrapper_text_color-preview').style.backgroundColor = "#000000";
        _gel('wrapper_text_color').value = "#000000";

        select_popup_color("#CCCCCC","wrapper_link_color","no");
        _gel('wrapper_link_color-preview').style.backgroundColor = "#CCCCCC";
        _gel('wrapper_link_color').value = "#CCCCCC";

        select_popup_color("#666666","box_background_color","no");
        _gel('box_background_color-preview').style.backgroundColor = "#666666";
        _gel('box_background_color').value = "#666666";

        select_popup_color("#000000","title_text_color","no");
        _gel('title_text_color-preview').style.backgroundColor = "#000000";
        _gel('title_text_color').value = "#000000";

        select_popup_color("#444444","link_color","no");
        _gel('link_color-preview').style.backgroundColor = "#444444";
        _gel('link_color').value = "#444444";

        select_popup_color("#444444","body_text_color","no");
        _gel('body_text_color-preview').style.backgroundColor = "#444444";
        _gel('body_text_color').value = "#444444";

        _gel('wrapper_opacity').value = "100";
        _gel('box_opacity').value = "100";

        var style = 'body, #channel-body {font-family: Arial, sans-serif !important;} .outer-box .inner-box a, .outer-box .inner-box-colors a {font-family: Arial, sans-serif !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
        _gel('theme_edit_name').value = "Stealth";
        _gel('theme_display_name').innerHTML = "Stealth";
        _gel("background_repeat_check").checked = 0;
    }
    if (e == "clean") {
        select_popup_color("#FFFFFF","background_color","no");
        _gel('background_color-preview').style.backgroundColor = "#FFFFFF";
        _gel('background_color').value = "#FFFFFF";

        select_popup_color("#D6D6D6","wrapper_color","no");
        _gel('wrapper_color-preview').style.backgroundColor = "#D6D6D6";
        _gel('wrapper_color').value = "#D6D6D6";

        select_popup_color("#666666","wrapper_text_color","no");
        _gel('wrapper_text_color-preview').style.backgroundColor = "#666666";
        _gel('wrapper_text_color').value = "#666666";

        select_popup_color("#0033CC","wrapper_link_color","no");
        _gel('wrapper_link_color-preview').style.backgroundColor = "#0033CC";
        _gel('wrapper_link_color').value = "#0033CC";

        select_popup_color("#FFFFFF","box_background_color","no");
        _gel('box_background_color-preview').style.backgroundColor = "#FF9900";
        _gel('box_background_color').value = "#FF9900";

        select_popup_color("#666666","title_text_color","no");
        _gel('title_text_color-preview').style.backgroundColor = "#666666";
        _gel('title_text_color').value = "#666666";

        select_popup_color("#0033CC","link_color","no");
        _gel('link_color-preview').style.backgroundColor = "#0033CC";
        _gel('link_color').value = "#0033CC";

        select_popup_color("#000000","body_text_color","no");
        _gel('body_text_color-preview').style.backgroundColor = "#000000";
        _gel('body_text_color').value = "#000000";

        _gel('wrapper_opacity').value = "100";
        _gel('box_opacity').value = "100";

        var style = 'body, #channel-body {font-family: Arial, sans-serif !important;} .outer-box .inner-box a, .outer-box .inner-box-colors a {font-family: Arial, sans-serif !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
        _gel('theme_edit_name').value = "Clean";
        _gel('theme_display_name').innerHTML = "Clean";
        _gel("background_repeat_check").checked = 0;
    }
    if (e == "my_old_theme") {
        select_popup_color("#<?= $_PROFILE->Info['c_background'] ?>","background_color","no");
        _gel('background_color-preview').style.backgroundColor = "#<?= $_PROFILE->Info['c_background'] ?>";
        _gel('background_color').value = "#<?= $_PROFILE->Info['c_background'] ?>";

        select_popup_color("#<?= $_PROFILE->Info['c_highlight_inner'] ?>","wrapper_color","no");
        _gel('wrapper_color-preview').style.backgroundColor = "#<?= $_PROFILE->Info['c_highlight_inner'] ?>";
        _gel('wrapper_color').value = "#<?= $_PROFILE->Info['c_highlight_inner'] ?>";

        select_popup_color("#<?= $_PROFILE->Info["c_link_color"] ?>","wrapper_text_color","no");
        _gel('wrapper_text_color-preview').style.backgroundColor = "#<?= $_PROFILE->Info["c_link_color"] ?>";
        _gel('wrapper_text_color').value = "#<?= $_PROFILE->Info["c_link_color"] ?>";

        select_popup_color("#<?= $_PROFILE->Info["c_link_color"] ?>","wrapper_link_color","no");
        _gel('wrapper_link_color-preview').style.backgroundColor = "#<?= $_PROFILE->Info["c_link_color"] ?>";
        _gel('wrapper_link_color').value = "#<?= $_PROFILE->Info["c_link_color"] ?>";

        select_popup_color("#<?= $_PROFILE->Info["c_normal_inner"] ?>","box_background_color","no");
        _gel('box_background_color-preview').style.backgroundColor = "#<?= $_PROFILE->Info["c_normal_inner"] ?>";
        _gel('box_background_color').value = "#<?= $_PROFILE->Info["c_normal_inner"] ?>";

        select_popup_color("#<?= $_PROFILE->Info["c_title_font"] ?>","title_text_color","no");
        _gel('title_text_color-preview').style.backgroundColor = "#<?= $_PROFILE->Info["c_title_font"] ?>";
        _gel('title_text_color').value = "#<?= $_PROFILE->Info["c_title_font"] ?>";

        select_popup_color("#<?= $_PROFILE->Info["c_link_color"] ?>","link_color","no");
        _gel('link_color-preview').style.backgroundColor = "#<?= $_PROFILE->Info["c_link_color"] ?>";
        _gel('link_color').value = "#<?= $_PROFILE->Info["c_link_color"] ?>";

        select_popup_color("#<?= $_PROFILE->Info["c_normal_font"] ?>","body_text_color","no");
        _gel('body_text_color-preview').style.backgroundColor = "#<?= $_PROFILE->Info["c_normal_font"] ?>";
        _gel('body_text_color').value = "#<?= $_PROFILE->Info["c_normal_font"] ?>";

        _gel('wrapper_opacity').value = "100";
        _gel('box_opacity').value = "100";

        var style = 'body, #channel-body {font-family: <?= $_PROFILE->Info["c_font"] ?> !important;} .outer-box .inner-box a, .outer-box .inner-box-colors a {font-family: Arial, sans-serif !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
        _gel('theme_edit_name').value = "My Old Theme";
        _gel('theme_display_name').innerHTML = "My Old Theme";
        _gel("background_repeat_check").checked = <?= $_PROFILE->Info['c_background_image_repeat'] ?>;
    }
    if (e == "custom") {
        <?php foreach ($Custom_Theme as $Custom): ?>
        select_popup_color("#<?= $Custom['background_color'] ?>","background_color");
        _gel('background_color-preview').style.backgroundColor = "#<?= $Custom['background_color'] ?>";
        _gel('background_color').value = "#<?= $Custom['background_color'] ?>";

        select_popup_color("#<?= $Custom['wrapper_color'] ?>","wrapper_color");
        _gel('wrapper_color-preview').style.backgroundColor = "#<?= $Custom['wrapper_color'] ?>";
        _gel('wrapper_color').value = "#<?= $Custom['wrapper_color'] ?>";

        select_popup_color("#<?= $Custom['wrapper_text_color'] ?>","wrapper_text_color");
        _gel('wrapper_text_color-preview').style.backgroundColor = "#<?= $Custom['wrapper_text_color'] ?>";
        _gel('wrapper_text_color').value = "#<?= $Custom['wrapper_text_color'] ?>";

        select_popup_color("#<?= $Custom['wrapper_text_color'] ?>","wrapper_link_color");
        _gel('wrapper_link_color-preview').style.backgroundColor = "#<?= $Custom['wrapper_link_color'] ?>";
        _gel('wrapper_link_color').value = "#<?= $Custom['wrapper_link_color'] ?>";

        select_popup_color("#<?= $Custom['box_background_color'] ?>","box_background_color");
        _gel('box_background_color-preview').style.backgroundColor = "#<?= $Custom['box_background_color'] ?>";
        _gel('box_background_color').value = "#<?= $Custom['box_background_color'] ?>";

        select_popup_color("#<?= $Custom['title_text_color'] ?>","title_text_color");
        _gel('title_text_color-preview').style.backgroundColor = "#<?= $Custom['title_text_color'] ?>";
        _gel('title_text_color').value = "#<?= $Custom['title_text_color'] ?>";

        select_popup_color("#<?= $Custom['link_color'] ?>","link_color");
        _gel('link_color-preview').style.backgroundColor = "#<?= $Custom['link_color'] ?>";
        _gel('link_color').value = "#<?= $Custom['link_color'] ?>";

        select_popup_color("#<?= $Custom['body_text_color'] ?>","body_text_color");
        _gel('body_text_color-preview').style.backgroundColor = "#<?= $Custom['body_text_color'] ?>";
        _gel('body_text_color').value = "#<?= $Custom['body_text_color'] ?>";

        _gel('wrapper_opacity').value = "<?= $Custom['wrapper_opacity'] * 100 ?>";
        _gel('box_opacity').value = "<?= $Custom['box_opacity'] * 100 ?>";

        var style = 'body, #channel-body {font-family: <?= $Custom["font"] ?> !important;} .outer-box .inner-box a, .outer-box .inner-box-colors a {font-family: <?= $Custom["font"] ?> !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
        _gel('theme_edit_name').value = "Custom";
        _gel('theme_display_name').innerHTML = "Custom";
        _gel("background_repeat_check").checked = <?= $Custom['background_repeat_check'] ?>;
        edit_wrapper_opacity();
        edit_box_opacity();
        <?php endforeach ?>
    }
}
}
</script>
<div id="edit_controls" class="edit_controls_outer" style="background-color: #cee3ff;">
                <div class="edit_controls_top_border">&nbsp;</div>
                <div class="channel_tabs">
                        <div class="channel_tabs_inner" dir="ltr">
        <div style="float: left;display: inline-block;height: 31px;line-height: 32px;font-weight: bold;color: #999;padding: 0 10px;"><?= $LANGS['editchannel'] ?></div>
                                        <div class="channel_settings_tab_spacer">&nbsp;</div>
                                        <div id="channel_tab_info" class="channel_settings_tab" onclick="channel_edit_tab('info')" dir="ltr">
                <?= $LANGS['settings'] ?>
        </div>

                                        <div id="channel_tab_colors" class="channel_settings_tab" onclick="channel_edit_tab('colors')" dir="ltr">
                <?= $LANGS['themescolors'] ?>
        </div>

                                        <div id="channel_tab_layout" class="channel_settings_tab" onclick="channel_edit_tab('layout')" dir="ltr">
                <?= $LANGS['channelmodules'] ?>
        </div>

                                        <div id="channel_tab_playnav" class="channel_settings_tab" onclick="channel_edit_tab('playnav')" dir="ltr">
                <?= $LANGS['videosandpl'] ?>
        </div>
        <div class="hLink floatR" onclick="channel_edit_tab('close')" id="channel_edit_close" style="padding-top: 0.75em; font-size: 11px; display: none;"><?= $LANGS['close'] ?></div>
        <div class="spacer">&nbsp;</div>
                <div id="tab_contents_info" style="display: none;" class="channel_tab_content">
                <div id="info-messages" style="display:none"></div>

        <form action="/user/<?= $_PROFILE->Username ?>" method="POST">
        <table width="100%"><tbody><tr>
                <td width="50%" style="padding: 10px 10px 7px 10px;border-right:1px dotted #bbb" valign="top">
                        <div class="settings_label">URL:</div>
                        <div class="settings_control"><a href="/user/<?= $_USER->Username ?>">http://www.bitview.net/user/<?= $_USER->Username ?></a></div>
                        <div class="settings_separator">&nbsp;</div>
                        <div class="settings_label"><?= $LANGS['title'] ?>:</div>
                        <div class="settings_control"><input name="title" value="<?= $_PROFILE->Info['i_title'] ?>" id="channel_title_input" value="" style="width:200px" maxlength="50"></div>
                        <div class="settings_separator">&nbsp;</div>
                        <div class="settings_label"><?= $LANGS['channeltype'] ?>:</div>
                        <div class="settings_control">  <span>
                <select id="channel_type" name="channel_type" onchange="">
                        <?php foreach($Channel_Type as $value => $item) : ?>
                        <option value="<?= $value ?>"<?php if ($_PROFILE->Info['type'] == $value) : ?> selected<?php endif ?>><?= $item ?></option>
                    <?php endforeach ?>
                </select>
        </span>
</div>
                </td>
                <td width="50%" style="padding: 10px 10px 7px 10px" valign="top">
                        <div class="settings_label"><?= $LANGS['channeltags'] ?>:
                                <div style="font-size:80%;color:#666"><?= $LANGS['commaseparated'] ?></div>
                        </div>
                        <div class="settings_control"><textarea name="keywords" rows="4" cols="250" style="width:350px" maxlength="256"><?= $_PROFILE->Info['i_tags'] ?></textarea><br>
                                <span style="font-size:90%;color:#333"><?= $LANGS['channeltagsdesc'] ?></span>
                        </div>
                </td>
        </tr></tbody></table>
        <div class="settings_separator_save">&nbsp;</div>
        <div class="channel_settings_save">
                                <button type="sumbit" name="channel_settings_save" class="yt-uix-button yt-uix-button-primary"><span class="yt-uix-button-content"><?= $LANGS['editsavechanges'] ?></span></button>
<?= $LANGS['or'] ?>
                                <a href="#" onclick="channel_edit_tab('close', true);return false"><?= $LANGS['editcancel'] ?></a>
                <div class="save_overlay">
<center><img src="/img/icn_loading_animated.gif"></center>
</div>


        </div>
        <div class="cb">&nbsp;</div>
        </form>
                </div>
                <div id="tab_contents_colors" style="display: none;" class="channel_tab_content">
                <div id="colors-messages" style="display:none"></div>

        <div id="theme_container">      <div id="default" class="theme_selector_div <?php if ($_PROFILE->Info['c_theme'] == "Grey"): ?>theme_selected<?php endif?>" style="font-family:arial" onclick="set_theme_obj(this.id);"><div style="background-color: #CCCCCC;color:#333333;padding: 3px;line-height:120%"><div style="background-color: #999999;color: #000000;padding:3px;font-size:10px"><div style="float:right;width:4em;background-color:#eeeeff;font-size:9px;padding-left:1px;color:#333333"><span style="color:#000000;font-size:120%">A</span> &nbsp;<span style="color:#0000cc;text-decoration:underline">url</span><br>abc</div><span style="color:#0000cc;text-decoration:underline">url</span><br>abc</div></div><div style="text-align:center;"><span class="theme_title" style="padding:2px;height:2em;overflow:hidden">Grey</span><br><a href="#" class="hLink" onclick="delete_theme('default');return false;" style="font-size: 75%; visibility: hidden; display: none;" id="delete_default">delete</a></div></div><div id="blue" class="theme_selector_div <?php if ($_PROFILE->Info['c_theme'] == "Blue"): ?>theme_selected<?php endif?>" style="font-family:arial" onclick="set_theme_obj(this.id);"><div style="background-color: #003366;color:#ffffff;padding: 3px;line-height:120%"><div style="background-color: #0066CC;color: #ffffff;padding:3px;font-size:10px"><div style="float:right;width:4em;background-color:#3D8BD8;font-size:9px;padding-left:1px;color:#ffffff"><span style="color:#ffffff;font-size:120%">A</span> &nbsp;<span style="color:#99C2EB;text-decoration:underline">url</span><br>abc</div><span style="color:#0000CC;text-decoration:underline">url</span><br>abc</div></div><div style="text-align:center;"><span class="theme_title" style="padding:2px;height:2em;overflow:hidden">Blue</span><br><a href="#" class="hLink" onclick="delete_theme('blue');return false;" style="font-size:75%;visibility:hidden" id="delete_blue">delete</a></div></div><div id="scary" class="theme_selector_div <?php if ($_PROFILE->Info['c_theme'] == "Red"): ?>theme_selected<?php endif?>" style="font-family:arial" onclick="set_theme_obj(this.id);"><div style="background-color: #660000;color:#FFFFFF;padding: 3px;line-height:120%"><div style="background-color: #990000;color: #FFFFFF;padding:3px;font-size:10px"><div style="float:right;width:4em;background-color:#660000;font-size:9px;padding-left:1px;color:#FFFFFF"><span style="color:#FFFFFF;font-size:120%">A</span> &nbsp;<span style="color:#FF0000;text-decoration:underline">url</span><br>abc</div><span style="color:#FF0000;text-decoration:underline">url</span><br>abc</div></div><div style="text-align:center;"><span class="theme_title" style="padding:2px;height:2em;overflow:hidden">Red</span><br><a href="#" class="hLink" onclick="delete_theme('scary');return false;" style="font-size:75%;visibility:hidden" id="delete_scary">delete</a></div></div><div id="sunlight" class="theme_selector_div <?php if ($_PROFILE->Info['c_theme'] == "Sunlight"): ?>theme_selected<?php endif?>" style="font-family:arial" onclick="set_theme_obj(this.id);"><div style="background-color: #FFE599;color:#E69138;padding: 3px;line-height:120%"><div style="background-color: #E69138;color: #FFFFFF;padding:3px;font-size:10px"><div style="float:right;width:4em;background-color:#FFD966;font-size:9px;padding-left:1px;color:#E69138"><span style="color:#E69138;font-size:120%">A</span> &nbsp;<span style="color:#E69138;text-decoration:underline">url</span><br>abc</div><span style="color:#FFD966;text-decoration:underline">url</span><br>abc</div></div><div style="text-align:center;"><span class="theme_title" style="padding:2px;height:2em;overflow:hidden">Sunlight</span><br><a href="#" class="hLink" onclick="delete_theme('sunlight');return false;" style="font-size:75%;visibility:hidden" id="delete_sunlight">delete</a></div></div><div id="forest" class="theme_selector_div <?php if ($_PROFILE->Info['c_theme'] == "Forest"): ?>theme_selected<?php endif?>" style="font-family:Arial" onclick="set_theme_obj(this.id);"><div style="background-color: #274E13;color:#274E13;padding: 3px;line-height:120%"><div style="background-color: #38761D;color: #ffffff;padding:3px;font-size:10px"><div style="float:right;width:4em;background-color:#6AA84F;font-size:9px;padding-left:1px;color:#274E13"><span style="color:#274E13;font-size:120%">A</span> &nbsp;<span style="color:#38761D;text-decoration:underline">url</span><br>abc</div><span style="color:#FFFFFF;text-decoration:underline">url</span><br>abc</div></div><div style="text-align:center;"><span class="theme_title" style="padding:2px;height:2em;overflow:hidden">Forest</span><br><a href="#" class="hLink" onclick="delete_theme('forest');return false;" style="font-size:75%;visibility:hidden" id="delete_forest">delete</a></div></div><div id="8bit" class="theme_selector_div <?php if ($_PROFILE->Info['c_theme'] == "8-bit"): ?>theme_selected<?php endif?>" style="font-family:Courier New" onclick="set_theme_obj(this.id);"><div style="background-color: #666666;color:#666666;padding: 3px;line-height:120%"><div style="background-color: #444444;color: #FFFFFF;padding:3px;font-size:10px"><div style="float:right;width:4em;background-color:#000000;font-size:9px;padding-left:1px;color:#666666"><span style="color:#AAAAAA;font-size:120%">A</span> &nbsp;<span style="color:#FF0000;text-decoration:underline">url</span><br>abc</div><span style="color:#FF0000;text-decoration:underline">url</span><br>abc</div></div><div style="text-align:center;"><span class="theme_title" style="padding:2px;height:2em;overflow:hidden">8-bit</span><br><a href="#" class="hLink" onclick="delete_theme('8bit');return false;" style="font-size:75%;visibility:hidden" id="delete_8bit">delete</a></div></div><div id="princess" class="theme_selector_div <?php if ($_PROFILE->Info['c_theme'] == "Princess"): ?>theme_selected<?php endif?>" style="font-family:arial" onclick="set_theme_obj(this.id);"><div style="background-color: #ff99cc;color:#333366;padding: 3px;line-height:120%"><div style="background-color: #aa66cc;color: #ffffff;padding:3px;font-size:10px"><div style="float:right;width:4em;background-color:#ffffff;font-size:9px;padding-left:1px;color:#333366"><span style="color:#8a2c87;font-size:120%">A</span> &nbsp;<span style="color:#351C75;text-decoration:underline">url</span><br>abc</div><span style="color:#351C75;text-decoration:underline">url</span><br>abc</div></div><div style="text-align:center;"><span class="theme_title" style="padding:2px;height:2em;overflow:hidden">Princess</span><br><a href="#" class="hLink" onclick="delete_theme('princess');return false;" style="font-size:75%;visibility:hidden" id="delete_princess">delete</a></div></div><div id="fire" class="theme_selector_div <?php if ($_PROFILE->Info['c_theme'] == "Fire"): ?>theme_selected<?php endif?>" style="font-family:arial" onclick="set_theme_obj(this.id);"><div style="background-color: #660000;color:#ffffff;padding: 3px;line-height:120%"><div style="background-color: #FF0000;color: #ffffff;padding:3px;font-size:10px"><div style="float:right;width:4em;background-color:#FF9900;font-size:9px;padding-left:1px;color:#ffffff"><span style="color:#FFFF00;font-size:120%">A</span> &nbsp;<span style="color:#FFDBA6;text-decoration:underline">url</span><br>abc</div><span style="color:#FFFF00;text-decoration:underline">url</span><br>abc</div></div><div style="text-align:center;"><span class="theme_title" style="padding:2px;height:2em;overflow:hidden">Fire</span><br><a href="#" class="hLink" onclick="delete_theme('fire');return false;" style="font-size:75%;visibility:hidden" id="delete_fire">delete</a></div></div><div id="stealth" class="theme_selector_div <?php if ($_PROFILE->Info['c_theme'] == "Stealth"): ?>theme_selected<?php endif?>" style="font-family:arial" onclick="set_theme_obj(this.id);"><div style="background-color: #000000;color:#444444;padding: 3px;line-height:120%"><div style="background-color: #444444;color: #000000;padding:3px;font-size:10px"><div style="float:right;width:4em;background-color:#666666;font-size:9px;padding-left:1px;color:#444444"><span style="color:#000000;font-size:120%">A</span> &nbsp;<span style="color:#444444;text-decoration:underline">url</span><br>abc</div><span style="color:#CCCCCC;text-decoration:underline">url</span><br>abc</div></div><div style="text-align:center;"><span class="theme_title" style="padding:2px;height:2em;overflow:hidden">Stealth</span><br><a href="#" class="hLink" onclick="delete_theme('stealth');return false;" style="font-size:75%;visibility:hidden" id="delete_stealth">delete</a></div></div>
        <?php if ($_PROFILE->Info['c_theme'] == "My Old Theme"): ?>
        <div id="my_old_theme" class="theme_selector_div <?php if ($_PROFILE->Info['c_theme'] == "My Old Theme"): ?>theme_selected<?php endif?>" style="font-family:arial" onclick="set_theme_obj(this.id);"><div style="background-color: #<?= $_PROFILE->Info['c_background'] ?>;color:#<?= $_PROFILE->Info['c_normal_inner'] ?>;padding: 3px;line-height:120%"><div style="background-color: #<?= $_PROFILE->Info['c_highlight_inner'] ?>;color: #<?= $_PROFILE->Info['c_link_color'] ?>;padding:3px;font-size:10px"><div style="float:right;width:4em;background-color:#<?= $_PROFILE->Info['c_normal_inner'] ?>;font-size:9px;padding-left:1px;color:#<?= $_PROFILE->Info['c_normal_font'] ?>"><span style="color:#<?= $_PROFILE->Info['c_title_font'] ?>;font-size:120%">A</span> &nbsp;<span style="color:#<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration:underline">url</span><br>abc</div><span style="color:#<?= $_PROFILE->Info['c_link_color'] ?>;text-decoration:underline">url</span><br>abc</div></div><div style="text-align:center;"><span class="theme_title" style="font-family: <?= $_PROFILE->Info["c_font"] ?>,<?php if($_PROFILE->Info["c_font"] == "Arial" or $_PROFILE->Info["c_font"] == "Verdana") : ?>sans-serif<?php elseif ($_PROFILE->Info["c_font"] == "Georgia" or $_PROFILE->Info["c_font"] == "Times New Roman") : ?>serif<?php elseif($_PROFILE->Info["c_font"] == "Courier New") : ?>monospace<?php endif ?>;padding:2px;height:2em;overflow:hidden">My Old Theme</span><br><a href="#" class="hLink" onclick="delete_theme('my_old_theme');return false;" style="font-size: 75%; visibility: hidden; display: none;" id="delete_my_old_theme">delete</a></div></div><?php endif ?>
        <?php if (isset($Custom) && $Custom): ?>
        <?php foreach ($Custom_Theme as $Custom): ?>
        <div id="custom" class="theme_selector_div <?php if ($_PROFILE->Info['c_theme'] == "Custom"): ?>theme_selected<?php endif?>" style="font-family:arial" onclick="set_theme_obj(this.id);"><div style="background-color: #<?= $Custom['background_color'] ?>;color:#<?= $Custom['wrapper_text_color'] ?>;padding: 3px;line-height:120%"><div style="background-color: #<?= $Custom['wrapper_color'] ?>;color: #<?= $Custom['wrapper_text_color'] ?>;padding:3px;font-size:10px"><div style="float:right;width:4em;background-color:#<?= $Custom['box_background_color'] ?>;font-size:9px;padding-left:1px;color:#<?= $Custom['body_text_color'] ?>"><span style="color:#<?= $Custom['title_text_color'] ?>;font-size:120%">A</span> &nbsp;<span style="color:#<?= $Custom['link_color'] ?>;text-decoration:underline">url</span><br>abc</div><span style="color:#<?= $Custom['wrapper_link_color'] ?>;text-decoration:underline">url</span><br>abc</div></div><div style="text-align:center;"><span class="theme_title" style="font-family: <?= $Custom['font'] ?>,<?php if($Custom['font'] == "Arial" or $Custom['font'] == "Verdana") : ?>sans-serif<?php elseif ($Custom['font'] == "Georgia" or $Custom['font'] == "Times New Roman") : ?>serif<?php elseif($Custom['font'] == "Courier New") : ?>monospace<?php endif ?>;padding:2px;height:2em;overflow:hidden">Custom</span><br><a href="#" class="hLink" onclick="delete_theme('custom');return false;" style="font-size: 75%; visibility: hidden; display: none;" id="delete_my_old_theme">delete</a></div></div><?php endforeach ?><?php endif ?></div>
        <div class="cb">&nbsp;</div>
        <div style="background-color:#eee;margin:0.5em;-moz-border-radius:3px;border-radius:3px;zoom:1;display:inline-block;width: 948px;">
                <div style="float:right;padding:0.7em;position:relative;line-height: 26px;">
                                        <button type="button" class=" yt-uix-button yt-uix-button-primary" onclick="save_themes();return false;"><span class="yt-uix-button-content"><?= $LANGS['editsavechanges'] ?></span></button>
<?= $LANGS['or'] ?>
                                <a href="#" onclick="channel_edit_tab('close', true);return false"><?= $LANGS['editcancel'] ?></a>
                <div id="save_theme_overlay" class="save_overlay" style="top:8px;padding: 5px;left:7px;width:86%;">
<center><img src="/img/icn_loading_animated.gif"></center>
</div>


                </div>
                <div style="float:left;padding:0.6em;font-size:14pt">
                        "<input type="text" size="30" style="width:8em;display:none;border:0;font-size:14pt" id="theme_edit_name" onkeypress="update_theme_name(this, event);" value="<?= $_PROFILE->Info['c_theme'] ?>"><span id="theme_display_name" style="display: inline;"><?= $_PROFILE->Info['c_theme'] ?></span>"
                </div>
                <div id="theme_edit_link" style="float: left; padding: 1em;" class=""><a class="hLink" href="#" onclick="document.getElementById('theme_advanced_editor').style.display = 'block';document.getElementById('theme_edit_link').style.display = 'none';document.getElementById('theme_edit_link_hide').style.display = 'block';return false;"><?= $LANGS['showadvancedoptions'] ?></a></div>
                <div id="delete_link_text" style="display:none">delete</div>
                <div id="are_you_sure_you_want_to_delete_text" style="display:none">Are you sure you want to remove this?</div>
                <div id="theme_edit_link_hide" style="float: left; padding: 1em; display: none;"><a class="hLink" href="#" onclick="document.getElementById('theme_advanced_editor').style.display = 'none';document.getElementById('theme_edit_link').style.display = 'block';document.getElementById('theme_edit_link_hide').style.display = 'none';return false;"><?= $LANGS['hideadvancedoptions'] ?></a></div>
                <div style="float:left;padding:1.25em 0 0 1.5em;">
                        <div id="theme_progress_bar" style="display:none;background-color:#f8f8f8;border:1px solid #ccc;height:8px;font-size:1px;line-height:1px;width:80px"><div id="theme_progress_inner" style="background-color: #d0d0f8;width:0%;font-size:1px;line-height:1px;height:8px"></div></div>
                </div>
                <div class="cb"></div>
        </div>
        <div>
        <table id="theme_advanced_editor" style="display: none;"><tbody><tr>
        <td width="460" align="left" valign="top" style="border-right:1px dotted #ddd;">
                <div style="padding: 0.5em 2em">
                        <div style="font-size:130%"><?= $LANGS['general'] ?></div>
                                <div id="font_option" style="padding:2px;">
                <div style="float:left;padding:4px;"><?= $LANGS['font'] ?></div>
                <select name="font" id="font" style="float:right" onchange="change_channel_font();">
                                <option value="Times New Roman" <?php if ($font == "Times New Roman" && $_PROFILE->Info['c_theme'] == "Custom") :?>selected <?php endif ?>>Times New Roman</option>
                                <option value="Arial" <?php if ($font == "Arial" or $_PROFILE->Info['c_theme'] != "Custom"):?>selected <?php endif ?>>Arial</option>
                                <option value="Verdana" <?php if ($font == "Verdana" && $_PROFILE->Info['c_theme'] == "Custom"):?>selected <?php endif ?>>Verdana</option>
                                <option value="Georgia" <?php if ($font == "Georgia" && $_PROFILE->Info['c_theme'] == "Custom"):?>selected <?php endif ?>>Georgia</option>
                                <option value="Courier New" <?php if ($font == "Courier New" && ($_PROFILE->Info['c_theme'] == "Custom" || $_PROFILE->Info['c_theme'] == "8-bit")):?>selected <?php endif ?>>Courier New</option>
                </select>
                <div class="settings_separator_light">&nbsp;</div>
        </div>

                                <div id="background_color_option" style="padding:2px;">
                <div style="float:left;padding:4px;"><?= $LANGS['bgcolor'] ?></div>
                <input type="text" maxlength="7" style="float:right;width:50px;font-size:10px;margin-left:2px" id="background_color" name="background_color" value="#<?= $backgroundColor?>" onblur="color_picker_keypress(this);" oninput="color_picker_keypress(this);" onpaste="color_picker_keypress(this);">
                <div class="color_selector" onclick="popup_color_grid('background_color')">
                        <div id="background_color-preview" style="width:13px;height:13px;background-color:#<?= $backgroundColor?>">&nbsp;</div>
                </div>
                <div class="settings_separator_light">&nbsp;</div>
                <div id="popup_color_grid_background_color" class="popup_color_grid" style="display:none;right: 475px;margin-top: -3px;">
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#000000;cursor:pointer" onclick="select_popup_color('#000000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#444444;cursor:pointer" onclick="select_popup_color('#444444');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#666666;cursor:pointer" onclick="select_popup_color('#666666');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#999999;cursor:pointer" onclick="select_popup_color('#999999');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CCCCCC;cursor:pointer" onclick="select_popup_color('#CCCCCC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EEEEEE;cursor:pointer" onclick="select_popup_color('#EEEEEE');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F3F3F3;cursor:pointer" onclick="select_popup_color('#F3F3F3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFFFFF;cursor:pointer" onclick="select_popup_color('#FFFFFF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF0000;cursor:pointer" onclick="select_popup_color('#FF0000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF9900;cursor:pointer" onclick="select_popup_color('#FF9900');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFFF00;cursor:pointer" onclick="select_popup_color('#FFFF00');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#00FF00;cursor:pointer" onclick="select_popup_color('#00FF00');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#00FFFF;cursor:pointer" onclick="select_popup_color('#00FFFF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0000FF;cursor:pointer" onclick="select_popup_color('#0000FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#9900FF;cursor:pointer" onclick="select_popup_color('#9900FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF00FF;cursor:pointer" onclick="select_popup_color('#FF00FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFCCCC;cursor:pointer" onclick="select_popup_color('#FFCCCC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FCE5CD;cursor:pointer" onclick="select_popup_color('#FCE5CD');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFF2CC;cursor:pointer" onclick="select_popup_color('#FFF2CC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D9EAD3;cursor:pointer" onclick="select_popup_color('#D9EAD3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D0E0E3;cursor:pointer" onclick="select_popup_color('#D0E0E3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CFE2F3;cursor:pointer" onclick="select_popup_color('#CFE2F3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D9D2E9;cursor:pointer" onclick="select_popup_color('#D9D2E9');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EAD1DC;cursor:pointer" onclick="select_popup_color('#EAD1DC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EA9999;cursor:pointer" onclick="select_popup_color('#EA9999');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F9CB9C;cursor:pointer" onclick="select_popup_color('#F9CB9C');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFE599;cursor:pointer" onclick="select_popup_color('#FFE599');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B6D7A8;cursor:pointer" onclick="select_popup_color('#B6D7A8');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#A2C4C9;cursor:pointer" onclick="select_popup_color('#A2C4C9');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#9FC5E8;cursor:pointer" onclick="select_popup_color('#9FC5E8');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B4A7D6;cursor:pointer" onclick="select_popup_color('#B4A7D6');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D5A6BD;cursor:pointer" onclick="select_popup_color('#D5A6BD');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#E06666;cursor:pointer" onclick="select_popup_color('#E06666');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F6B26B;cursor:pointer" onclick="select_popup_color('#F6B26B');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFD966;cursor:pointer" onclick="select_popup_color('#FFD966');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#93C47D;cursor:pointer" onclick="select_popup_color('#93C47D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#76A5AF;cursor:pointer" onclick="select_popup_color('#76A5AF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#6FA8DC;cursor:pointer" onclick="select_popup_color('#6FA8DC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#8E7CC3;cursor:pointer" onclick="select_popup_color('#8E7CC3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#C27BA0;cursor:pointer" onclick="select_popup_color('#C27BA0');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CC0000;cursor:pointer" onclick="select_popup_color('#CC0000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#E69138;cursor:pointer" onclick="select_popup_color('#E69138');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F1C232;cursor:pointer" onclick="select_popup_color('#F1C232');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#6AA84F;cursor:pointer" onclick="select_popup_color('#6AA84F');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#45818E;cursor:pointer" onclick="select_popup_color('#45818E');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#3D85C6;cursor:pointer" onclick="select_popup_color('#3D85C6');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#674EA7;cursor:pointer" onclick="select_popup_color('#674EA7');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#A64D79;cursor:pointer" onclick="select_popup_color('#A64D79');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#990000;cursor:pointer" onclick="select_popup_color('#990000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B45F06;cursor:pointer" onclick="select_popup_color('#B45F06');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#BF9000;cursor:pointer" onclick="select_popup_color('#BF9000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#38761D;cursor:pointer" onclick="select_popup_color('#38761D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#134F5C;cursor:pointer" onclick="select_popup_color('#134F5C');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0B5394;cursor:pointer" onclick="select_popup_color('#0B5394');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#351C75;cursor:pointer" onclick="select_popup_color('#351C75');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#741B47;cursor:pointer" onclick="select_popup_color('#741B47');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#660000;cursor:pointer" onclick="select_popup_color('#660000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#783F04;cursor:pointer" onclick="select_popup_color('#783F04');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#7F6000;cursor:pointer" onclick="select_popup_color('#7F6000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#274E13;cursor:pointer" onclick="select_popup_color('#274E13');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0C343D;cursor:pointer" onclick="select_popup_color('#0C343D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#073763;cursor:pointer" onclick="select_popup_color('#073763');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#20124D;cursor:pointer" onclick="select_popup_color('#20124D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#4C1130;cursor:pointer" onclick="select_popup_color('#4C1130');">&nbsp;</div>
                <div class="cb">&nbsp;</div>
        </div>
        </div>

                                <div id="wrapper_color_option" style="padding:2px;">
                <div style="float:left;padding:4px;"><?= $LANGS['wrappercolor'] ?></div>
                <input type="text" maxlength="7" style="float:right;width:50px;font-size:10px;margin-left:2px" id="wrapper_color" name="wrapper_color" value="#<?= $wrapperColor?>"onblur="color_picker_keypress(this);" oninput="color_picker_keypress(this);" onpaste="color_picker_keypress(this);">
                <div class="color_selector" onclick="popup_color_grid('wrapper_color')">
                        <div id="wrapper_color-preview" style="width:13px;height:13px;background-color:#<?= $wrapperColor?>">&nbsp;</div>
                </div>
                <div class="settings_separator_light">&nbsp;</div>
                <div id="popup_color_grid_wrapper_color" class="popup_color_grid" style="display:none;right: 475px;margin-top: -3px;">
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#000000;cursor:pointer" onclick="select_popup_color('#000000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#444444;cursor:pointer" onclick="select_popup_color('#444444');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#666666;cursor:pointer" onclick="select_popup_color('#666666');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#999999;cursor:pointer" onclick="select_popup_color('#999999');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CCCCCC;cursor:pointer" onclick="select_popup_color('#CCCCCC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EEEEEE;cursor:pointer" onclick="select_popup_color('#EEEEEE');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F3F3F3;cursor:pointer" onclick="select_popup_color('#F3F3F3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFFFFF;cursor:pointer" onclick="select_popup_color('#FFFFFF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF0000;cursor:pointer" onclick="select_popup_color('#FF0000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF9900;cursor:pointer" onclick="select_popup_color('#FF9900');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFFF00;cursor:pointer" onclick="select_popup_color('#FFFF00');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#00FF00;cursor:pointer" onclick="select_popup_color('#00FF00');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#00FFFF;cursor:pointer" onclick="select_popup_color('#00FFFF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0000FF;cursor:pointer" onclick="select_popup_color('#0000FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#9900FF;cursor:pointer" onclick="select_popup_color('#9900FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF00FF;cursor:pointer" onclick="select_popup_color('#FF00FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFCCCC;cursor:pointer" onclick="select_popup_color('#FFCCCC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FCE5CD;cursor:pointer" onclick="select_popup_color('#FCE5CD');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFF2CC;cursor:pointer" onclick="select_popup_color('#FFF2CC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D9EAD3;cursor:pointer" onclick="select_popup_color('#D9EAD3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D0E0E3;cursor:pointer" onclick="select_popup_color('#D0E0E3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CFE2F3;cursor:pointer" onclick="select_popup_color('#CFE2F3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D9D2E9;cursor:pointer" onclick="select_popup_color('#D9D2E9');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EAD1DC;cursor:pointer" onclick="select_popup_color('#EAD1DC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EA9999;cursor:pointer" onclick="select_popup_color('#EA9999');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F9CB9C;cursor:pointer" onclick="select_popup_color('#F9CB9C');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFE599;cursor:pointer" onclick="select_popup_color('#FFE599');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B6D7A8;cursor:pointer" onclick="select_popup_color('#B6D7A8');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#A2C4C9;cursor:pointer" onclick="select_popup_color('#A2C4C9');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#9FC5E8;cursor:pointer" onclick="select_popup_color('#9FC5E8');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B4A7D6;cursor:pointer" onclick="select_popup_color('#B4A7D6');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D5A6BD;cursor:pointer" onclick="select_popup_color('#D5A6BD');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#E06666;cursor:pointer" onclick="select_popup_color('#E06666');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F6B26B;cursor:pointer" onclick="select_popup_color('#F6B26B');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFD966;cursor:pointer" onclick="select_popup_color('#FFD966');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#93C47D;cursor:pointer" onclick="select_popup_color('#93C47D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#76A5AF;cursor:pointer" onclick="select_popup_color('#76A5AF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#6FA8DC;cursor:pointer" onclick="select_popup_color('#6FA8DC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#8E7CC3;cursor:pointer" onclick="select_popup_color('#8E7CC3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#C27BA0;cursor:pointer" onclick="select_popup_color('#C27BA0');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CC0000;cursor:pointer" onclick="select_popup_color('#CC0000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#E69138;cursor:pointer" onclick="select_popup_color('#E69138');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F1C232;cursor:pointer" onclick="select_popup_color('#F1C232');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#6AA84F;cursor:pointer" onclick="select_popup_color('#6AA84F');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#45818E;cursor:pointer" onclick="select_popup_color('#45818E');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#3D85C6;cursor:pointer" onclick="select_popup_color('#3D85C6');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#674EA7;cursor:pointer" onclick="select_popup_color('#674EA7');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#A64D79;cursor:pointer" onclick="select_popup_color('#A64D79');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#990000;cursor:pointer" onclick="select_popup_color('#990000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B45F06;cursor:pointer" onclick="select_popup_color('#B45F06');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#BF9000;cursor:pointer" onclick="select_popup_color('#BF9000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#38761D;cursor:pointer" onclick="select_popup_color('#38761D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#134F5C;cursor:pointer" onclick="select_popup_color('#134F5C');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0B5394;cursor:pointer" onclick="select_popup_color('#0B5394');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#351C75;cursor:pointer" onclick="select_popup_color('#351C75');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#741B47;cursor:pointer" onclick="select_popup_color('#741B47');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#660000;cursor:pointer" onclick="select_popup_color('#660000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#783F04;cursor:pointer" onclick="select_popup_color('#783F04');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#7F6000;cursor:pointer" onclick="select_popup_color('#7F6000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#274E13;cursor:pointer" onclick="select_popup_color('#274E13');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0C343D;cursor:pointer" onclick="select_popup_color('#0C343D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#073763;cursor:pointer" onclick="select_popup_color('#073763');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#20124D;cursor:pointer" onclick="select_popup_color('#20124D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#4C1130;cursor:pointer" onclick="select_popup_color('#4C1130');">&nbsp;</div>
                <div class="cb">&nbsp;</div>
        </div>
        </div>

                                <div id="wrapper_text_color_option" style="padding:2px;">
                <div style="float:left;padding:4px;"><?= $LANGS['wrappertextcolor'] ?></div>
                <input type="text" maxlength="7" style="float:right;width:50px;font-size:10px;margin-left:2px" id="wrapper_text_color" name="wrapper_text_color" value="#<?= $wrapperTextColor?>"onblur="color_picker_keypress(this);" oninput="color_picker_keypress(this);" onpaste="color_picker_keypress(this);">
                <div class="color_selector" onclick="popup_color_grid('wrapper_text_color')">
                        <div id="wrapper_text_color-preview" style="width:13px;height:13px;background-color:#<?= $wrapperTextColor?>">&nbsp;</div>
                </div>
                <div class="settings_separator_light">&nbsp;</div>
                <div id="popup_color_grid_wrapper_text_color" class="popup_color_grid" style="display:none;right: 475px;margin-top: -3px;">
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#000000;cursor:pointer" onclick="select_popup_color('#000000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#444444;cursor:pointer" onclick="select_popup_color('#444444');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#666666;cursor:pointer" onclick="select_popup_color('#666666');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#999999;cursor:pointer" onclick="select_popup_color('#999999');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CCCCCC;cursor:pointer" onclick="select_popup_color('#CCCCCC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EEEEEE;cursor:pointer" onclick="select_popup_color('#EEEEEE');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F3F3F3;cursor:pointer" onclick="select_popup_color('#F3F3F3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFFFFF;cursor:pointer" onclick="select_popup_color('#FFFFFF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF0000;cursor:pointer" onclick="select_popup_color('#FF0000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF9900;cursor:pointer" onclick="select_popup_color('#FF9900');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFFF00;cursor:pointer" onclick="select_popup_color('#FFFF00');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#00FF00;cursor:pointer" onclick="select_popup_color('#00FF00');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#00FFFF;cursor:pointer" onclick="select_popup_color('#00FFFF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0000FF;cursor:pointer" onclick="select_popup_color('#0000FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#9900FF;cursor:pointer" onclick="select_popup_color('#9900FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF00FF;cursor:pointer" onclick="select_popup_color('#FF00FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFCCCC;cursor:pointer" onclick="select_popup_color('#FFCCCC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FCE5CD;cursor:pointer" onclick="select_popup_color('#FCE5CD');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFF2CC;cursor:pointer" onclick="select_popup_color('#FFF2CC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D9EAD3;cursor:pointer" onclick="select_popup_color('#D9EAD3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D0E0E3;cursor:pointer" onclick="select_popup_color('#D0E0E3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CFE2F3;cursor:pointer" onclick="select_popup_color('#CFE2F3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D9D2E9;cursor:pointer" onclick="select_popup_color('#D9D2E9');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EAD1DC;cursor:pointer" onclick="select_popup_color('#EAD1DC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EA9999;cursor:pointer" onclick="select_popup_color('#EA9999');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F9CB9C;cursor:pointer" onclick="select_popup_color('#F9CB9C');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFE599;cursor:pointer" onclick="select_popup_color('#FFE599');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B6D7A8;cursor:pointer" onclick="select_popup_color('#B6D7A8');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#A2C4C9;cursor:pointer" onclick="select_popup_color('#A2C4C9');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#9FC5E8;cursor:pointer" onclick="select_popup_color('#9FC5E8');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B4A7D6;cursor:pointer" onclick="select_popup_color('#B4A7D6');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D5A6BD;cursor:pointer" onclick="select_popup_color('#D5A6BD');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#E06666;cursor:pointer" onclick="select_popup_color('#E06666');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F6B26B;cursor:pointer" onclick="select_popup_color('#F6B26B');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFD966;cursor:pointer" onclick="select_popup_color('#FFD966');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#93C47D;cursor:pointer" onclick="select_popup_color('#93C47D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#76A5AF;cursor:pointer" onclick="select_popup_color('#76A5AF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#6FA8DC;cursor:pointer" onclick="select_popup_color('#6FA8DC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#8E7CC3;cursor:pointer" onclick="select_popup_color('#8E7CC3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#C27BA0;cursor:pointer" onclick="select_popup_color('#C27BA0');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CC0000;cursor:pointer" onclick="select_popup_color('#CC0000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#E69138;cursor:pointer" onclick="select_popup_color('#E69138');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F1C232;cursor:pointer" onclick="select_popup_color('#F1C232');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#6AA84F;cursor:pointer" onclick="select_popup_color('#6AA84F');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#45818E;cursor:pointer" onclick="select_popup_color('#45818E');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#3D85C6;cursor:pointer" onclick="select_popup_color('#3D85C6');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#674EA7;cursor:pointer" onclick="select_popup_color('#674EA7');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#A64D79;cursor:pointer" onclick="select_popup_color('#A64D79');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#990000;cursor:pointer" onclick="select_popup_color('#990000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B45F06;cursor:pointer" onclick="select_popup_color('#B45F06');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#BF9000;cursor:pointer" onclick="select_popup_color('#BF9000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#38761D;cursor:pointer" onclick="select_popup_color('#38761D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#134F5C;cursor:pointer" onclick="select_popup_color('#134F5C');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0B5394;cursor:pointer" onclick="select_popup_color('#0B5394');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#351C75;cursor:pointer" onclick="select_popup_color('#351C75');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#741B47;cursor:pointer" onclick="select_popup_color('#741B47');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#660000;cursor:pointer" onclick="select_popup_color('#660000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#783F04;cursor:pointer" onclick="select_popup_color('#783F04');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#7F6000;cursor:pointer" onclick="select_popup_color('#7F6000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#274E13;cursor:pointer" onclick="select_popup_color('#274E13');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0C343D;cursor:pointer" onclick="select_popup_color('#0C343D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#073763;cursor:pointer" onclick="select_popup_color('#073763');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#20124D;cursor:pointer" onclick="select_popup_color('#20124D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#4C1130;cursor:pointer" onclick="select_popup_color('#4C1130');">&nbsp;</div>
                <div class="cb">&nbsp;</div>
        </div>
        </div>

                                <div id="wrapper_link_color_option" style="padding:2px;">
                <div style="float:left;padding:4px;"><?= $LANGS['wrapperlinkcolor'] ?></div>
                <input type="text" maxlength="7" style="float:right;width:50px;font-size:10px;margin-left:2px" id="wrapper_link_color" name="wrapper_link_color" value="#<?= $wrapperLinkColor?>"onblur="color_picker_keypress(this);" oninput="color_picker_keypress(this);" onpaste="color_picker_keypress(this);">
                <div class="color_selector" onclick="popup_color_grid('wrapper_link_color')">
                        <div id="wrapper_link_color-preview" style="width:13px;height:13px;background-color:#<?= $wrapperLinkColor?>">&nbsp;</div>
                </div>
                <div class="settings_separator_light">&nbsp;</div>
                <div id="popup_color_grid_wrapper_link_color" class="popup_color_grid" style="display:none;right: 475px;margin-top: -3px;">
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#000000;cursor:pointer" onclick="select_popup_color('#000000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#444444;cursor:pointer" onclick="select_popup_color('#444444');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#666666;cursor:pointer" onclick="select_popup_color('#666666');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#999999;cursor:pointer" onclick="select_popup_color('#999999');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CCCCCC;cursor:pointer" onclick="select_popup_color('#CCCCCC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EEEEEE;cursor:pointer" onclick="select_popup_color('#EEEEEE');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F3F3F3;cursor:pointer" onclick="select_popup_color('#F3F3F3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFFFFF;cursor:pointer" onclick="select_popup_color('#FFFFFF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF0000;cursor:pointer" onclick="select_popup_color('#FF0000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF9900;cursor:pointer" onclick="select_popup_color('#FF9900');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFFF00;cursor:pointer" onclick="select_popup_color('#FFFF00');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#00FF00;cursor:pointer" onclick="select_popup_color('#00FF00');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#00FFFF;cursor:pointer" onclick="select_popup_color('#00FFFF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0000FF;cursor:pointer" onclick="select_popup_color('#0000FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#9900FF;cursor:pointer" onclick="select_popup_color('#9900FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF00FF;cursor:pointer" onclick="select_popup_color('#FF00FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFCCCC;cursor:pointer" onclick="select_popup_color('#FFCCCC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FCE5CD;cursor:pointer" onclick="select_popup_color('#FCE5CD');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFF2CC;cursor:pointer" onclick="select_popup_color('#FFF2CC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D9EAD3;cursor:pointer" onclick="select_popup_color('#D9EAD3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D0E0E3;cursor:pointer" onclick="select_popup_color('#D0E0E3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CFE2F3;cursor:pointer" onclick="select_popup_color('#CFE2F3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D9D2E9;cursor:pointer" onclick="select_popup_color('#D9D2E9');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EAD1DC;cursor:pointer" onclick="select_popup_color('#EAD1DC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EA9999;cursor:pointer" onclick="select_popup_color('#EA9999');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F9CB9C;cursor:pointer" onclick="select_popup_color('#F9CB9C');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFE599;cursor:pointer" onclick="select_popup_color('#FFE599');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B6D7A8;cursor:pointer" onclick="select_popup_color('#B6D7A8');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#A2C4C9;cursor:pointer" onclick="select_popup_color('#A2C4C9');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#9FC5E8;cursor:pointer" onclick="select_popup_color('#9FC5E8');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B4A7D6;cursor:pointer" onclick="select_popup_color('#B4A7D6');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D5A6BD;cursor:pointer" onclick="select_popup_color('#D5A6BD');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#E06666;cursor:pointer" onclick="select_popup_color('#E06666');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F6B26B;cursor:pointer" onclick="select_popup_color('#F6B26B');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFD966;cursor:pointer" onclick="select_popup_color('#FFD966');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#93C47D;cursor:pointer" onclick="select_popup_color('#93C47D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#76A5AF;cursor:pointer" onclick="select_popup_color('#76A5AF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#6FA8DC;cursor:pointer" onclick="select_popup_color('#6FA8DC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#8E7CC3;cursor:pointer" onclick="select_popup_color('#8E7CC3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#C27BA0;cursor:pointer" onclick="select_popup_color('#C27BA0');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CC0000;cursor:pointer" onclick="select_popup_color('#CC0000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#E69138;cursor:pointer" onclick="select_popup_color('#E69138');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F1C232;cursor:pointer" onclick="select_popup_color('#F1C232');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#6AA84F;cursor:pointer" onclick="select_popup_color('#6AA84F');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#45818E;cursor:pointer" onclick="select_popup_color('#45818E');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#3D85C6;cursor:pointer" onclick="select_popup_color('#3D85C6');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#674EA7;cursor:pointer" onclick="select_popup_color('#674EA7');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#A64D79;cursor:pointer" onclick="select_popup_color('#A64D79');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#990000;cursor:pointer" onclick="select_popup_color('#990000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B45F06;cursor:pointer" onclick="select_popup_color('#B45F06');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#BF9000;cursor:pointer" onclick="select_popup_color('#BF9000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#38761D;cursor:pointer" onclick="select_popup_color('#38761D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#134F5C;cursor:pointer" onclick="select_popup_color('#134F5C');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0B5394;cursor:pointer" onclick="select_popup_color('#0B5394');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#351C75;cursor:pointer" onclick="select_popup_color('#351C75');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#741B47;cursor:pointer" onclick="select_popup_color('#741B47');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#660000;cursor:pointer" onclick="select_popup_color('#660000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#783F04;cursor:pointer" onclick="select_popup_color('#783F04');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#7F6000;cursor:pointer" onclick="select_popup_color('#7F6000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#274E13;cursor:pointer" onclick="select_popup_color('#274E13');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0C343D;cursor:pointer" onclick="select_popup_color('#0C343D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#073763;cursor:pointer" onclick="select_popup_color('#073763');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#20124D;cursor:pointer" onclick="select_popup_color('#20124D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#4C1130;cursor:pointer" onclick="select_popup_color('#4C1130');">&nbsp;</div>
                <div class="cb">&nbsp;</div>
        </div>
        </div>

                                <div id="wrapper_opacity_option" style="padding:2px;">
                <div style="float:left;padding:4px;"><?= $LANGS['wrappertransparency'] ?></div>
                <select name="wrapper_opacity" id="wrapper_opacity" style="float:right" onchange="edit_wrapper_opacity();">
                    <?php if ($_PROFILE->Info['c_theme'] == "Custom"): ?>
                    <?php foreach ($Custom_Theme as $Custom): ?>
                        <option value="100" <?php if ($Custom['wrapper_opacity'] * 100 == 100 ): ?> selected <?php endif ?>><?= $LANGS['type0'] ?></option>
                        <option value="90" <?php if ($Custom['wrapper_opacity'] * 100 == 90 ): ?> selected <?php endif ?>>10%</option>
                        <option value="80" <?php if ($Custom['wrapper_opacity'] * 100 == 80 ): ?> selected <?php endif ?>>20%</option>
                        <option value="70" <?php if ($Custom['wrapper_opacity'] * 100 == 70 ): ?> selected <?php endif ?>>30%</option>
                        <option value="60" <?php if ($Custom['wrapper_opacity'] * 100 == 60 ): ?> selected <?php endif ?>>40%</option>
                        <option value="50" <?php if ($Custom['wrapper_opacity'] * 100 == 50 ): ?> selected <?php endif ?>>50%</option>
                        <option value="40" <?php if ($Custom['wrapper_opacity'] * 100 == 40 ): ?> selected <?php endif ?>>60%</option>
                        <option value="30" <?php if ($Custom['wrapper_opacity'] * 100 == 30 ): ?> selected <?php endif ?>>70%</option>
                        <option value="20" <?php if ($Custom['wrapper_opacity'] * 100 == 20 ): ?> selected <?php endif ?>>80%</option>
                        <option value="10" <?php if ($Custom['wrapper_opacity'] * 100 == 10 ): ?> selected <?php endif ?>>90%</option>
                        <option value="0" <?php if ($Custom['wrapper_opacity'] * 100 == 0 ): ?> selected <?php endif ?>>100%</option>
                    <?php endforeach ?>
                <?php else: ?>
                    <option value="100"><?= $LANGS['type0'] ?></option>
                    <option value="90">10%</option>
                    <option value="80">20%</option>
                    <option value="70">30%</option>
                    <option value="60">40%</option>
                    <option value="50">50%</option>
                    <option value="40">60%</option>
                    <option value="30">70%</option>
                    <option value="20">80%</option>
                    <option value="10">90%</option>
                    <option value="0">100%</option>
                <?php endif?>
                </select>
                <div class="settings_separator_light">&nbsp;</div>
        </div>

                                <script>
                window.background_image_counter = 1;
        </script>
        <div id="background_image_option" style="padding:2px;">
                <div style="float:left;padding:4px"><?= $LANGS['backgroundimage'] ?>:</div>
                <div id="background_upload_div" style="float:right">
                        <input type="hidden" name="background_image" id="background_image" value="">
                        <form action="/user/<?= $_USER->Username ?>" name="uploader" method="post" enctype="multipart/form-data" id="imageUploadForm">
                        <input type="hidden" name="channel_background_counter" id="channel_background_counter" value="1">
                <input type="hidden" name="upload_type" value="channel_background">
                <input type="submit" style="display:none">
                <?php if(!$_PROFILE->Info["c_background_image"]) : ?>
                <input name="body_background_image_path" id="body_background_image_path" type="file" onchange="uploadBackgroundImage();" style="font-size: 9px;">
                <?php else: ?>
                    <a href="#" id="delete_background_image" onclick="deleteBackgroundImage();return false;">Delete</a>
                <?php endif ?>
        </form>
                        <br>
                        <div class="smallText" style="color:#666;padding:3px;width:240px"><?= $LANGS['bgimgdesc'] ?></div>
                </div>
                <div class="settings_separator_light">&nbsp;</div>
        </div>
        <div id="background_repeat_option" style="padding:2px;">
                <div style="float:left;padding:4px"><?= $LANGS['repeatbackground'] ?>:</div>
                <div style="float:right">
                        <input type="hidden" name="background_repeat" id="background_repeat" value="no-repeat">
                        <input type="checkbox" name="background_repeat_check" id="background_repeat_check" onclick="repeat_background();" <?php if ($repeatBackground == 1): ?>checked<?php endif ?>>
                </div>
                <div class="settings_separator_light">&nbsp;</div>
        </div>

                </div>
        </td>
        <td width="460" valign="top" id="css_options_parent" style="padding:0.5em 0 0.1em 2em">
                <div style="font-size:130%"><?= $LANGS['colorpalettes'] ?></div>
                <select onchange="set_palette(this.value)" style="display:none">
                        <option value="default" selected="">Default</option>
                </select>
                <div id="palette_colors" style="padding-left: 1em;">
                                <div id="box_background_color_option" style="padding:2px;">
                <div style="float:left;padding:4px;"><?= $LANGS['bgcolor'] ?></div>
                <input type="text" maxlength="7" style="float:right;width:50px;font-size:10px;margin-left:2px" id="box_background_color" name="box_background_color" value="#<?= $boxBackgroundColor?>"onblur="color_picker_keypress(this);" oninput="color_picker_keypress(this);" onpaste="color_picker_keypress(this);">
                <div class="color_selector" onclick="popup_color_grid('box_background_color')">
                        <div id="box_background_color-preview" style="width:13px;height:13px;background-color:#<?= $boxBackgroundColor?>">&nbsp;</div>
                </div>
                <div class="settings_separator_light">&nbsp;</div>
                <div id="popup_color_grid_box_background_color" class="popup_color_grid" style="display:none;right: -34px;margin-top: -3px;">
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#000000;cursor:pointer" onclick="select_popup_color('#000000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#444444;cursor:pointer" onclick="select_popup_color('#444444');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#666666;cursor:pointer" onclick="select_popup_color('#666666');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#999999;cursor:pointer" onclick="select_popup_color('#999999');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CCCCCC;cursor:pointer" onclick="select_popup_color('#CCCCCC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EEEEEE;cursor:pointer" onclick="select_popup_color('#EEEEEE');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F3F3F3;cursor:pointer" onclick="select_popup_color('#F3F3F3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFFFFF;cursor:pointer" onclick="select_popup_color('#FFFFFF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF0000;cursor:pointer" onclick="select_popup_color('#FF0000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF9900;cursor:pointer" onclick="select_popup_color('#FF9900');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFFF00;cursor:pointer" onclick="select_popup_color('#FFFF00');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#00FF00;cursor:pointer" onclick="select_popup_color('#00FF00');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#00FFFF;cursor:pointer" onclick="select_popup_color('#00FFFF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0000FF;cursor:pointer" onclick="select_popup_color('#0000FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#9900FF;cursor:pointer" onclick="select_popup_color('#9900FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF00FF;cursor:pointer" onclick="select_popup_color('#FF00FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFCCCC;cursor:pointer" onclick="select_popup_color('#FFCCCC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FCE5CD;cursor:pointer" onclick="select_popup_color('#FCE5CD');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFF2CC;cursor:pointer" onclick="select_popup_color('#FFF2CC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D9EAD3;cursor:pointer" onclick="select_popup_color('#D9EAD3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D0E0E3;cursor:pointer" onclick="select_popup_color('#D0E0E3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CFE2F3;cursor:pointer" onclick="select_popup_color('#CFE2F3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D9D2E9;cursor:pointer" onclick="select_popup_color('#D9D2E9');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EAD1DC;cursor:pointer" onclick="select_popup_color('#EAD1DC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EA9999;cursor:pointer" onclick="select_popup_color('#EA9999');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F9CB9C;cursor:pointer" onclick="select_popup_color('#F9CB9C');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFE599;cursor:pointer" onclick="select_popup_color('#FFE599');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B6D7A8;cursor:pointer" onclick="select_popup_color('#B6D7A8');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#A2C4C9;cursor:pointer" onclick="select_popup_color('#A2C4C9');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#9FC5E8;cursor:pointer" onclick="select_popup_color('#9FC5E8');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B4A7D6;cursor:pointer" onclick="select_popup_color('#B4A7D6');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D5A6BD;cursor:pointer" onclick="select_popup_color('#D5A6BD');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#E06666;cursor:pointer" onclick="select_popup_color('#E06666');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F6B26B;cursor:pointer" onclick="select_popup_color('#F6B26B');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFD966;cursor:pointer" onclick="select_popup_color('#FFD966');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#93C47D;cursor:pointer" onclick="select_popup_color('#93C47D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#76A5AF;cursor:pointer" onclick="select_popup_color('#76A5AF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#6FA8DC;cursor:pointer" onclick="select_popup_color('#6FA8DC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#8E7CC3;cursor:pointer" onclick="select_popup_color('#8E7CC3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#C27BA0;cursor:pointer" onclick="select_popup_color('#C27BA0');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CC0000;cursor:pointer" onclick="select_popup_color('#CC0000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#E69138;cursor:pointer" onclick="select_popup_color('#E69138');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F1C232;cursor:pointer" onclick="select_popup_color('#F1C232');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#6AA84F;cursor:pointer" onclick="select_popup_color('#6AA84F');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#45818E;cursor:pointer" onclick="select_popup_color('#45818E');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#3D85C6;cursor:pointer" onclick="select_popup_color('#3D85C6');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#674EA7;cursor:pointer" onclick="select_popup_color('#674EA7');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#A64D79;cursor:pointer" onclick="select_popup_color('#A64D79');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#990000;cursor:pointer" onclick="select_popup_color('#990000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B45F06;cursor:pointer" onclick="select_popup_color('#B45F06');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#BF9000;cursor:pointer" onclick="select_popup_color('#BF9000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#38761D;cursor:pointer" onclick="select_popup_color('#38761D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#134F5C;cursor:pointer" onclick="select_popup_color('#134F5C');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0B5394;cursor:pointer" onclick="select_popup_color('#0B5394');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#351C75;cursor:pointer" onclick="select_popup_color('#351C75');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#741B47;cursor:pointer" onclick="select_popup_color('#741B47');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#660000;cursor:pointer" onclick="select_popup_color('#660000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#783F04;cursor:pointer" onclick="select_popup_color('#783F04');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#7F6000;cursor:pointer" onclick="select_popup_color('#7F6000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#274E13;cursor:pointer" onclick="select_popup_color('#274E13');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0C343D;cursor:pointer" onclick="select_popup_color('#0C343D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#073763;cursor:pointer" onclick="select_popup_color('#073763');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#20124D;cursor:pointer" onclick="select_popup_color('#20124D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#4C1130;cursor:pointer" onclick="select_popup_color('#4C1130');">&nbsp;</div>
                <div class="cb">&nbsp;</div>
        </div>
        </div>

                                <div id="title_text_color_option" style="padding:2px;">
                <div style="float:left;padding:4px;"><?= $LANGS['titletextcolor'] ?></div>
                <input type="text" maxlength="7" style="float:right;width:50px;font-size:10px;margin-left:2px" id="title_text_color" name="title_text_color" value="#<?= $titleTextColor?>"onblur="color_picker_keypress(this);" oninput="color_picker_keypress(this);" onpaste="color_picker_keypress(this);">
                <div class="color_selector" onclick="popup_color_grid('title_text_color')">
                        <div id="title_text_color-preview" style="width:13px;height:13px;background-color:#<?= $titleTextColor?>">&nbsp;</div>
                </div>
                <div class="settings_separator_light">&nbsp;</div>
                <div id="popup_color_grid_title_text_color" class="popup_color_grid" style="display:none;right: -34px;margin-top: -3px;">
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#000000;cursor:pointer" onclick="select_popup_color('#000000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#444444;cursor:pointer" onclick="select_popup_color('#444444');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#666666;cursor:pointer" onclick="select_popup_color('#666666');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#999999;cursor:pointer" onclick="select_popup_color('#999999');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CCCCCC;cursor:pointer" onclick="select_popup_color('#CCCCCC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EEEEEE;cursor:pointer" onclick="select_popup_color('#EEEEEE');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F3F3F3;cursor:pointer" onclick="select_popup_color('#F3F3F3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFFFFF;cursor:pointer" onclick="select_popup_color('#FFFFFF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF0000;cursor:pointer" onclick="select_popup_color('#FF0000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF9900;cursor:pointer" onclick="select_popup_color('#FF9900');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFFF00;cursor:pointer" onclick="select_popup_color('#FFFF00');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#00FF00;cursor:pointer" onclick="select_popup_color('#00FF00');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#00FFFF;cursor:pointer" onclick="select_popup_color('#00FFFF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0000FF;cursor:pointer" onclick="select_popup_color('#0000FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#9900FF;cursor:pointer" onclick="select_popup_color('#9900FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF00FF;cursor:pointer" onclick="select_popup_color('#FF00FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFCCCC;cursor:pointer" onclick="select_popup_color('#FFCCCC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FCE5CD;cursor:pointer" onclick="select_popup_color('#FCE5CD');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFF2CC;cursor:pointer" onclick="select_popup_color('#FFF2CC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D9EAD3;cursor:pointer" onclick="select_popup_color('#D9EAD3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D0E0E3;cursor:pointer" onclick="select_popup_color('#D0E0E3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CFE2F3;cursor:pointer" onclick="select_popup_color('#CFE2F3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D9D2E9;cursor:pointer" onclick="select_popup_color('#D9D2E9');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EAD1DC;cursor:pointer" onclick="select_popup_color('#EAD1DC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EA9999;cursor:pointer" onclick="select_popup_color('#EA9999');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F9CB9C;cursor:pointer" onclick="select_popup_color('#F9CB9C');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFE599;cursor:pointer" onclick="select_popup_color('#FFE599');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B6D7A8;cursor:pointer" onclick="select_popup_color('#B6D7A8');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#A2C4C9;cursor:pointer" onclick="select_popup_color('#A2C4C9');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#9FC5E8;cursor:pointer" onclick="select_popup_color('#9FC5E8');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B4A7D6;cursor:pointer" onclick="select_popup_color('#B4A7D6');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D5A6BD;cursor:pointer" onclick="select_popup_color('#D5A6BD');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#E06666;cursor:pointer" onclick="select_popup_color('#E06666');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F6B26B;cursor:pointer" onclick="select_popup_color('#F6B26B');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFD966;cursor:pointer" onclick="select_popup_color('#FFD966');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#93C47D;cursor:pointer" onclick="select_popup_color('#93C47D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#76A5AF;cursor:pointer" onclick="select_popup_color('#76A5AF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#6FA8DC;cursor:pointer" onclick="select_popup_color('#6FA8DC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#8E7CC3;cursor:pointer" onclick="select_popup_color('#8E7CC3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#C27BA0;cursor:pointer" onclick="select_popup_color('#C27BA0');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CC0000;cursor:pointer" onclick="select_popup_color('#CC0000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#E69138;cursor:pointer" onclick="select_popup_color('#E69138');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F1C232;cursor:pointer" onclick="select_popup_color('#F1C232');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#6AA84F;cursor:pointer" onclick="select_popup_color('#6AA84F');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#45818E;cursor:pointer" onclick="select_popup_color('#45818E');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#3D85C6;cursor:pointer" onclick="select_popup_color('#3D85C6');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#674EA7;cursor:pointer" onclick="select_popup_color('#674EA7');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#A64D79;cursor:pointer" onclick="select_popup_color('#A64D79');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#990000;cursor:pointer" onclick="select_popup_color('#990000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B45F06;cursor:pointer" onclick="select_popup_color('#B45F06');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#BF9000;cursor:pointer" onclick="select_popup_color('#BF9000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#38761D;cursor:pointer" onclick="select_popup_color('#38761D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#134F5C;cursor:pointer" onclick="select_popup_color('#134F5C');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0B5394;cursor:pointer" onclick="select_popup_color('#0B5394');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#351C75;cursor:pointer" onclick="select_popup_color('#351C75');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#741B47;cursor:pointer" onclick="select_popup_color('#741B47');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#660000;cursor:pointer" onclick="select_popup_color('#660000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#783F04;cursor:pointer" onclick="select_popup_color('#783F04');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#7F6000;cursor:pointer" onclick="select_popup_color('#7F6000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#274E13;cursor:pointer" onclick="select_popup_color('#274E13');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0C343D;cursor:pointer" onclick="select_popup_color('#0C343D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#073763;cursor:pointer" onclick="select_popup_color('#073763');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#20124D;cursor:pointer" onclick="select_popup_color('#20124D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#4C1130;cursor:pointer" onclick="select_popup_color('#4C1130');">&nbsp;</div>
                <div class="cb">&nbsp;</div>
        </div>
        </div>

                                <div id="link_color_option" style="padding:2px;">
                <div style="float:left;padding:4px;"><?= $LANGS['linkcolor'] ?></div>
                <input type="text" maxlength="7" style="float:right;width:50px;font-size:10px;margin-left:2px" id="link_color" name="link_color" value="#<?= $linkColor?>"onblur="color_picker_keypress(this);" oninput="color_picker_keypress(this);" onpaste="color_picker_keypress(this);">
                <div class="color_selector" onclick="popup_color_grid('link_color')">
                        <div id="link_color-preview" style="width:13px;height:13px;background-color:#<?= $linkColor?>">&nbsp;</div>
                </div>
                <div class="settings_separator_light">&nbsp;</div>
                <div id="popup_color_grid_link_color" class="popup_color_grid" style="display:none;right: -34px;margin-top: -3px;">
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#000000;cursor:pointer" onclick="select_popup_color('#000000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#444444;cursor:pointer" onclick="select_popup_color('#444444');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#666666;cursor:pointer" onclick="select_popup_color('#666666');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#999999;cursor:pointer" onclick="select_popup_color('#999999');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CCCCCC;cursor:pointer" onclick="select_popup_color('#CCCCCC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EEEEEE;cursor:pointer" onclick="select_popup_color('#EEEEEE');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F3F3F3;cursor:pointer" onclick="select_popup_color('#F3F3F3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFFFFF;cursor:pointer" onclick="select_popup_color('#FFFFFF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF0000;cursor:pointer" onclick="select_popup_color('#FF0000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF9900;cursor:pointer" onclick="select_popup_color('#FF9900');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFFF00;cursor:pointer" onclick="select_popup_color('#FFFF00');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#00FF00;cursor:pointer" onclick="select_popup_color('#00FF00');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#00FFFF;cursor:pointer" onclick="select_popup_color('#00FFFF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0000FF;cursor:pointer" onclick="select_popup_color('#0000FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#9900FF;cursor:pointer" onclick="select_popup_color('#9900FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF00FF;cursor:pointer" onclick="select_popup_color('#FF00FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFCCCC;cursor:pointer" onclick="select_popup_color('#FFCCCC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FCE5CD;cursor:pointer" onclick="select_popup_color('#FCE5CD');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFF2CC;cursor:pointer" onclick="select_popup_color('#FFF2CC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D9EAD3;cursor:pointer" onclick="select_popup_color('#D9EAD3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D0E0E3;cursor:pointer" onclick="select_popup_color('#D0E0E3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CFE2F3;cursor:pointer" onclick="select_popup_color('#CFE2F3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D9D2E9;cursor:pointer" onclick="select_popup_color('#D9D2E9');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EAD1DC;cursor:pointer" onclick="select_popup_color('#EAD1DC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EA9999;cursor:pointer" onclick="select_popup_color('#EA9999');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F9CB9C;cursor:pointer" onclick="select_popup_color('#F9CB9C');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFE599;cursor:pointer" onclick="select_popup_color('#FFE599');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B6D7A8;cursor:pointer" onclick="select_popup_color('#B6D7A8');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#A2C4C9;cursor:pointer" onclick="select_popup_color('#A2C4C9');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#9FC5E8;cursor:pointer" onclick="select_popup_color('#9FC5E8');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B4A7D6;cursor:pointer" onclick="select_popup_color('#B4A7D6');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D5A6BD;cursor:pointer" onclick="select_popup_color('#D5A6BD');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#E06666;cursor:pointer" onclick="select_popup_color('#E06666');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F6B26B;cursor:pointer" onclick="select_popup_color('#F6B26B');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFD966;cursor:pointer" onclick="select_popup_color('#FFD966');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#93C47D;cursor:pointer" onclick="select_popup_color('#93C47D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#76A5AF;cursor:pointer" onclick="select_popup_color('#76A5AF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#6FA8DC;cursor:pointer" onclick="select_popup_color('#6FA8DC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#8E7CC3;cursor:pointer" onclick="select_popup_color('#8E7CC3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#C27BA0;cursor:pointer" onclick="select_popup_color('#C27BA0');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CC0000;cursor:pointer" onclick="select_popup_color('#CC0000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#E69138;cursor:pointer" onclick="select_popup_color('#E69138');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F1C232;cursor:pointer" onclick="select_popup_color('#F1C232');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#6AA84F;cursor:pointer" onclick="select_popup_color('#6AA84F');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#45818E;cursor:pointer" onclick="select_popup_color('#45818E');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#3D85C6;cursor:pointer" onclick="select_popup_color('#3D85C6');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#674EA7;cursor:pointer" onclick="select_popup_color('#674EA7');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#A64D79;cursor:pointer" onclick="select_popup_color('#A64D79');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#990000;cursor:pointer" onclick="select_popup_color('#990000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B45F06;cursor:pointer" onclick="select_popup_color('#B45F06');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#BF9000;cursor:pointer" onclick="select_popup_color('#BF9000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#38761D;cursor:pointer" onclick="select_popup_color('#38761D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#134F5C;cursor:pointer" onclick="select_popup_color('#134F5C');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0B5394;cursor:pointer" onclick="select_popup_color('#0B5394');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#351C75;cursor:pointer" onclick="select_popup_color('#351C75');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#741B47;cursor:pointer" onclick="select_popup_color('#741B47');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#660000;cursor:pointer" onclick="select_popup_color('#660000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#783F04;cursor:pointer" onclick="select_popup_color('#783F04');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#7F6000;cursor:pointer" onclick="select_popup_color('#7F6000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#274E13;cursor:pointer" onclick="select_popup_color('#274E13');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0C343D;cursor:pointer" onclick="select_popup_color('#0C343D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#073763;cursor:pointer" onclick="select_popup_color('#073763');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#20124D;cursor:pointer" onclick="select_popup_color('#20124D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#4C1130;cursor:pointer" onclick="select_popup_color('#4C1130');">&nbsp;</div>
                <div class="cb">&nbsp;</div>
        </div>
        </div>

                                <div id="body_text_color_option" style="padding:2px;">
                <div style="float:left;padding:4px;"><?= $LANGS['bodytextcolor'] ?></div>
                <input type="text" maxlength="7" style="float:right;width:50px;font-size:10px;margin-left:2px" id="body_text_color" name="body_text_color" value="#<?= $bodyTextColor?>"onblur="color_picker_keypress(this);" oninput="color_picker_keypress(this);" onpaste="color_picker_keypress(this);">
                <div class="color_selector" onclick="popup_color_grid('body_text_color')">
                        <div id="body_text_color-preview" style="width:13px;height:13px;background-color:#<?= $bodyTextColor?>">&nbsp;</div>
                </div>
                <div class="settings_separator_light">&nbsp;</div>
                <div id="popup_color_grid_body_text_color" class="popup_color_grid" style="display:none;right: -34px;margin-top: -3px;">
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#000000;cursor:pointer" onclick="select_popup_color('#000000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#444444;cursor:pointer" onclick="select_popup_color('#444444');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#666666;cursor:pointer" onclick="select_popup_color('#666666');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#999999;cursor:pointer" onclick="select_popup_color('#999999');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CCCCCC;cursor:pointer" onclick="select_popup_color('#CCCCCC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EEEEEE;cursor:pointer" onclick="select_popup_color('#EEEEEE');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F3F3F3;cursor:pointer" onclick="select_popup_color('#F3F3F3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFFFFF;cursor:pointer" onclick="select_popup_color('#FFFFFF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF0000;cursor:pointer" onclick="select_popup_color('#FF0000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF9900;cursor:pointer" onclick="select_popup_color('#FF9900');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFFF00;cursor:pointer" onclick="select_popup_color('#FFFF00');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#00FF00;cursor:pointer" onclick="select_popup_color('#00FF00');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#00FFFF;cursor:pointer" onclick="select_popup_color('#00FFFF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0000FF;cursor:pointer" onclick="select_popup_color('#0000FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#9900FF;cursor:pointer" onclick="select_popup_color('#9900FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FF00FF;cursor:pointer" onclick="select_popup_color('#FF00FF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFCCCC;cursor:pointer" onclick="select_popup_color('#FFCCCC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FCE5CD;cursor:pointer" onclick="select_popup_color('#FCE5CD');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFF2CC;cursor:pointer" onclick="select_popup_color('#FFF2CC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D9EAD3;cursor:pointer" onclick="select_popup_color('#D9EAD3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D0E0E3;cursor:pointer" onclick="select_popup_color('#D0E0E3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CFE2F3;cursor:pointer" onclick="select_popup_color('#CFE2F3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D9D2E9;cursor:pointer" onclick="select_popup_color('#D9D2E9');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EAD1DC;cursor:pointer" onclick="select_popup_color('#EAD1DC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#EA9999;cursor:pointer" onclick="select_popup_color('#EA9999');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F9CB9C;cursor:pointer" onclick="select_popup_color('#F9CB9C');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFE599;cursor:pointer" onclick="select_popup_color('#FFE599');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B6D7A8;cursor:pointer" onclick="select_popup_color('#B6D7A8');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#A2C4C9;cursor:pointer" onclick="select_popup_color('#A2C4C9');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#9FC5E8;cursor:pointer" onclick="select_popup_color('#9FC5E8');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B4A7D6;cursor:pointer" onclick="select_popup_color('#B4A7D6');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#D5A6BD;cursor:pointer" onclick="select_popup_color('#D5A6BD');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#E06666;cursor:pointer" onclick="select_popup_color('#E06666');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F6B26B;cursor:pointer" onclick="select_popup_color('#F6B26B');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#FFD966;cursor:pointer" onclick="select_popup_color('#FFD966');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#93C47D;cursor:pointer" onclick="select_popup_color('#93C47D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#76A5AF;cursor:pointer" onclick="select_popup_color('#76A5AF');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#6FA8DC;cursor:pointer" onclick="select_popup_color('#6FA8DC');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#8E7CC3;cursor:pointer" onclick="select_popup_color('#8E7CC3');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#C27BA0;cursor:pointer" onclick="select_popup_color('#C27BA0');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#CC0000;cursor:pointer" onclick="select_popup_color('#CC0000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#E69138;cursor:pointer" onclick="select_popup_color('#E69138');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#F1C232;cursor:pointer" onclick="select_popup_color('#F1C232');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#6AA84F;cursor:pointer" onclick="select_popup_color('#6AA84F');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#45818E;cursor:pointer" onclick="select_popup_color('#45818E');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#3D85C6;cursor:pointer" onclick="select_popup_color('#3D85C6');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#674EA7;cursor:pointer" onclick="select_popup_color('#674EA7');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#A64D79;cursor:pointer" onclick="select_popup_color('#A64D79');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#990000;cursor:pointer" onclick="select_popup_color('#990000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#B45F06;cursor:pointer" onclick="select_popup_color('#B45F06');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#BF9000;cursor:pointer" onclick="select_popup_color('#BF9000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#38761D;cursor:pointer" onclick="select_popup_color('#38761D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#134F5C;cursor:pointer" onclick="select_popup_color('#134F5C');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0B5394;cursor:pointer" onclick="select_popup_color('#0B5394');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#351C75;cursor:pointer" onclick="select_popup_color('#351C75');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#741B47;cursor:pointer" onclick="select_popup_color('#741B47');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#660000;cursor:pointer" onclick="select_popup_color('#660000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#783F04;cursor:pointer" onclick="select_popup_color('#783F04');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#7F6000;cursor:pointer" onclick="select_popup_color('#7F6000');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#274E13;cursor:pointer" onclick="select_popup_color('#274E13');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#0C343D;cursor:pointer" onclick="select_popup_color('#0C343D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#073763;cursor:pointer" onclick="select_popup_color('#073763');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#20124D;cursor:pointer" onclick="select_popup_color('#20124D');">&nbsp;</div>
                        <div style="float:left;margin:2px;width:12px;height:12px;background-color:#4C1130;cursor:pointer" onclick="select_popup_color('#4C1130');">&nbsp;</div>
                <div class="cb">&nbsp;</div>
        </div>
        </div>

                                <div id="box_opacity_option" style="padding:2px;">
                <div style="float:left;padding:4px;"><?= $LANGS['transparency'] ?></div>
                <select name="box_opacity" id="box_opacity" style="float:right" onchange="edit_box_opacity();">
                        <?php if ($_PROFILE->Info['c_theme'] == "Custom"): ?>
                    <?php foreach ($Custom_Theme as $Custom): ?>
                        <option value="100" <?php if ($Custom['box_opacity'] * 100 == 100 ): ?> selected <?php endif ?>><?= $LANGS['type0'] ?></option>
                        <option value="90" <?php if ($Custom['box_opacity'] * 100 == 90 ): ?> selected <?php endif ?>>10%</option>
                        <option value="80" <?php if ($Custom['box_opacity'] * 100 == 80 ): ?> selected <?php endif ?>>20%</option>
                        <option value="70" <?php if ($Custom['box_opacity'] * 100 == 70 ): ?> selected <?php endif ?>>30%</option>
                        <option value="60" <?php if ($Custom['box_opacity'] * 100 == 60 ): ?> selected <?php endif ?>>40%</option>
                        <option value="50" <?php if ($Custom['box_opacity'] * 100 == 50 ): ?> selected <?php endif ?>>50%</option>
                        <option value="40" <?php if ($Custom['box_opacity'] * 100 == 40 ): ?> selected <?php endif ?>>60%</option>
                        <option value="30" <?php if ($Custom['box_opacity'] * 100 == 30 ): ?> selected <?php endif ?>>70%</option>
                        <option value="20" <?php if ($Custom['box_opacity'] * 100 == 20 ): ?> selected <?php endif ?>>80%</option>
                        <option value="10" <?php if ($Custom['box_opacity'] * 100 == 10 ): ?> selected <?php endif ?>>90%</option>
                        <option value="0" <?php if ($Custom['box_opacity'] * 100 == 0 ): ?> selected <?php endif ?>>100%</option>
                    <?php endforeach ?>
                <?php else: ?>
                    <option value="100"><?= $LANGS['type0'] ?></option>
                    <option value="90">10%</option>
                    <option value="80">20%</option>
                    <option value="70">30%</option>
                    <option value="60">40%</option>
                    <option value="50">50%</option>
                    <option value="40">60%</option>
                    <option value="30">70%</option>
                    <option value="20">80%</option>
                    <option value="10">90%</option>
                    <option value="0">100%</option>
                <?php endif?>
                </select>
                <div class="settings_separator_light">&nbsp;</div>
        </div>

                </div>
        </td>
        </tr></tbody></table></div>
                </div>
                <div id="tab_contents_layout" style="display: none;" class="channel_tab_content">
                <div id="layout-messages" style="display:none"></div>

        <form action="/user/<?= $_PROFILE->Username ?>" method="POST">
                        <div style="font-size:110%;padding: 5px;float:left;width:300px">
                                <label>
                                <input name="user_comments" value="user_comments" type="checkbox" <?php if ($_PROFILE->Info['c_comments_box'] == 1): ?>checked=""<?php endif ?> onclick="add_or_remove_box(this)">
                                <?= $LANGS['statcomments'] ?> &nbsp;&nbsp;
                                </label>
                        </div>
                        <div style="font-size:110%;padding: 5px;float:left;width:300px">
                                <label>
                                <input name="user_friends" value="user_friends" type="checkbox" <?php if ($_PROFILE->Info['c_friends_box'] == 1): ?>checked=""<?php endif ?> onclick="add_or_remove_box(this)">
                                <?= $LANGS['friends'] ?> &nbsp;&nbsp;
                                </label>
                        </div>
                        <div style="font-size:110%;padding: 5px;float:left;width:300px">
                                <label>
                                <input name="user_hubber_links" value="user_hubber_links" type="checkbox" <?php if ($_PROFILE->Info['c_bulletins_box'] == 1): ?>checked=""<?php endif ?> onclick="add_or_remove_box(this)">
                                <?= $LANGS['featuredchannels'] ?> &nbsp;&nbsp;
                                </label>
                        </div>
                        <div style="font-size:110%;padding: 5px;float:left;width:300px">
                                <label>
                                <input name="user_recent_activity" value="user_recent_activity" type="checkbox" <?php if ($_PROFILE->Info['c_ratings_box'] == 1): ?>checked=""<?php endif ?> onclick="add_or_remove_box(this)">
                                <?= $LANGS['recentratings'] ?> &nbsp;&nbsp;
                                </label>
                        </div>
                        <div style="font-size:110%;padding: 5px;float:left;width:300px">
                                <label>
                                <input name="user_subscribers" value="user_subscribers" type="checkbox" <?php if ($_PROFILE->Info['c_subscribers_box'] == 1): ?>checked=""<?php endif ?> onclick="add_or_remove_box(this)">
                                <?= $LANGS['cstatsubs'] ?> &nbsp;&nbsp;
                                </label>
                        </div>
                        <div style="font-size:110%;padding: 5px;float:left;width:300px">
                                <label>
                                <input name="user_subscriptions" value="user_subscriptions" type="checkbox" <?php if ($_PROFILE->Info['c_subscriptions_box'] == 1): ?>checked=""<?php endif ?> onclick="add_or_remove_box(this)">
                                <?= $LANGS['subscriptions'] ?> &nbsp;&nbsp;
                                </label>
                        </div>
                <div class="cb"></div>
                <div class="cb">&nbsp;</div>
                <div class="settings_separator_save">&nbsp;</div>
                <div class="channel_settings_save">
                                        <button type="submit" class=" yt-uix-button yt-uix-button-primary" name="save_modules"><span class="yt-uix-button-content"><?= $LANGS['editsavechanges'] ?></span></button>
<?= $LANGS['or'] ?>
                                <a href="#" onclick="channel_edit_tab('close', true);return false"><?= $LANGS['editcancel'] ?></a>
                <div class="save_overlay">
<center><img src="/img/icn_loading_animated.gif"></center>
</div>


                </div>
                <div class="cb">&nbsp;</div>
        </form>
                </div>
                <div id="tab_contents_playnav" style="display: none;" class="channel_tab_content">
                <div id="playnav-messages" style="display:none"></div>


        <form action="/user/<?= $_PROFILE->Username ?>" method="POST">
        <div id="playnav_settings">
                <div id="display_settings">
                        <div><?= $LANGS['whichcontent'] ?></div>
                        <div style="width:92%;padding:0.5em;border:1px solid #ccc;overflow:auto;background-color:#fff">
                <label>
                    <input id="display_uploads" type="checkbox" name="uploads" <?php if ($_PROFILE->Info['c_videos_box'] == 1): ?>checked=""<?php endif?>><?= $LANGS['myuploadedvideos'] ?></label><br>
                <label>
                    <input id="display_favorites" type="checkbox" name="favorites" <?php if ($_PROFILE->Info['c_favorites_box'] == 1): ?>checked=""<?php endif?>><?= $LANGS['myfavorites'] ?></label><br>
                <label>
                    <input id="display_playlists" type="checkbox"name="playlists" <?php if ($_PROFILE->Info['c_playlists_box'] == 1): ?>checked=""<?php endif?>><?= $LANGS['playlists'] ?></label>
            </div>
                        <div style="padding:0.25em" id="display_all_container">
                                <label>
                                        <input id="display_all" type="checkbox" name="all" <?php if ($_PROFILE->Info['c_all'] == 1): ?>checked=""<?php endif?>><?= $LANGS['alsoshowall'] ?>                               </label>
                        </div>
                </div>

                <div id="featured_content">
                        <div style="padding-top: 1em">
<?= $LANGS['featuredvideo'] ?><br><?php $Videos_List = $DB->execute("SELECT * FROM videos WHERE uploaded_by = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL ORDER BY videos.uploaded_on DESC",false,[":USERNAME" => $_PROFILE->Username]); ?>
                                <div id="featured_vid_select_box">
                                        <select name="featured_video_id" style="width:200px">
                                                <option value="00000000000"><?= $LANGS['usemostrecent'] ?></option>
                                                <?php foreach ($Videos_List as $Video): ?>
                                                <option value="<?= $Video['url'] ?>" <?php if ($Video['url'] == $_PROFILE->Info['c_featured_video']): ?>selected = ""<?php endif ?>><?= $Video['title'] ?></option>
                                                <?php endforeach ?>
                                        </select>
                                </div>
                                <br>
                                <input type="text" id="featured_video_url" name="featured_video_url" value="Copy and paste a video URL here" style="color:#999;margin-top:6px" class="playnav-edit-field hid">
                        </div>
                                <div style="padding-top:0.6em">
                                        <label><input type="checkbox" name="autoplay" <?php if ($_PROFILE->Info['c_autoplay'] == 1): ?>checked=""<?php endif?>><?= $LANGS['autoplayfeatured'] ?>
                                        </label>
                                </div>
                </div>
                <div class="cb">&nbsp;</div>
                <div class="settings_separator_save">&nbsp;</div>
                <div class="channel_settings_save">
                                        <button type="submit" class=" yt-uix-button yt-uix-button-primary" name="save_settings_user_play"><span class="yt-uix-button-content"><?= $LANGS['editsavechanges'] ?></span></button>
<?= $LANGS['or'] ?>
                                <a href="#" onclick="channel_edit_tab('close', true);return false"><?= $LANGS['editcancel'] ?></a>
                <div class="save_overlay">
<center><img src="/img/icn_loading_animated.gif"></center>
</div>


                </div>
                <div class="cb">&nbsp;</div>
        </div>
        </form>

                </div>
                        </div>
                </div>
                <div class="edit_controls_bottom_border">&nbsp;</div>
        </div>
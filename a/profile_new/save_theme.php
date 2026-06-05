<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/_includes/init.php";
header("Content-Type: application/json", true);

if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}

$_GUMP->validation_rules([
    "theme"                 => "required|max_len,30",
    "font"                  => "required|max_len,20",
    "background_color"      => "required|hex_color",
    "wrapper_color"         => "required|hex_color",
    "wrapper_text_color"    => "required|hex_color",
    "wrapper_link_color"    => "required|hex_color",
    "box_background_color"  => "required|hex_color",
    "title_text_color"      => "required|hex_color",
    "link_color"            => "required|hex_color",
    "body_text_color"       => "required|hex_color",
    "repeat_background"     => "required",
    "wrapper_opacity"       => "required",
    "box_opacity"           => "required"
]);
$_GUMP->filter_rules([
    "theme"          => "trim|NoHTML",
    "font"          => "trim|NoHTML"
]);

$Validation = $_GUMP->run($_POST);

if ($Validation) {
    $Check = $DB->execute("SELECT * FROM users_themes WHERE by_user = :USERNAME",false,[":USERNAME" => $_USER->Username]);
    if ($Validation['theme'] == "Custom") {
        $DB->modify("UPDATE users SET c_theme = :THEME WHERE username = :USERNAME",[":THEME" => "Custom", ":USERNAME" => $_USER->Username]);
        if (!$Check) {
        $DB->modify("INSERT INTO users_themes (by_user,background_color,wrapper_color, wrapper_text_color,wrapper_link_color,box_background_color,title_text_color,link_color, body_text_color,wrapper_opacity,box_opacity,background_repeat_check,font) VALUES (:USERNAME,:BACKGROUND,:WRAPPERCOLOR,:WRAPPERTEXTCOLOR,:WRAPPERLINKCOLOR,:BOXBGCOLOR,:TITILETEXTCOLOR,:LINKCOLOR,:BODYTEXTCOLOR,:WRAPPEROPACITY,:BOXOPACITY,:REPEAT,:FONT)",[
            ":BACKGROUND" => str_replace("#","",$Validation["background_color"]),
            ":WRAPPERCOLOR" => str_replace("#","",$Validation["wrapper_color"]),
            ":WRAPPERTEXTCOLOR" => str_replace("#","",$Validation["wrapper_text_color"]),
            ":WRAPPERLINKCOLOR" => str_replace("#","",$Validation["wrapper_link_color"]),
            ":BOXBGCOLOR" => str_replace("#","",$Validation["box_background_color"]),
            ":TITILETEXTCOLOR" => str_replace("#","",$Validation["title_text_color"]),
            ":LINKCOLOR" => str_replace("#","",$Validation["link_color"]),
            ":BODYTEXTCOLOR" => str_replace("#","",$Validation["body_text_color"]),
            ":WRAPPEROPACITY" => $Validation["wrapper_opacity"],
            ":BOXOPACITY" => $Validation["box_opacity"],
            ":REPEAT" => $Validation["repeat_background"],
            ":FONT" => $Validation["font"],
            ":USERNAME" => $_USER->Username
        ]);
    }
    else {
        $DB->modify("UPDATE users_themes SET background_color = :BACKGROUND, wrapper_color = :WRAPPERCOLOR, wrapper_text_color = :WRAPPERTEXTCOLOR, wrapper_link_color = :WRAPPERLINKCOLOR, box_background_color = :BOXBGCOLOR, title_text_color = :TITILETEXTCOLOR, link_color = :LINKCOLOR, body_text_color = :BODYTEXTCOLOR, wrapper_opacity = :WRAPPEROPACITY, box_opacity = :BOXOPACITY, background_repeat_check = :REPEAT, font = :FONT WHERE by_user = :USERNAME",[
            ":BACKGROUND" => str_replace("#","",$Validation["background_color"]),
            ":WRAPPERCOLOR" => str_replace("#","",$Validation["wrapper_color"]),
            ":WRAPPERTEXTCOLOR" => str_replace("#","",$Validation["wrapper_text_color"]),
            ":WRAPPERLINKCOLOR" => str_replace("#","",$Validation["wrapper_link_color"]),
            ":BOXBGCOLOR" => str_replace("#","",$Validation["box_background_color"]),
            ":TITILETEXTCOLOR" => str_replace("#","",$Validation["title_text_color"]),
            ":LINKCOLOR" => str_replace("#","",$Validation["link_color"]),
            ":BODYTEXTCOLOR" => str_replace("#","",$Validation["body_text_color"]),
            ":WRAPPEROPACITY" => $Validation["wrapper_opacity"],
            ":BOXOPACITY" => $Validation["box_opacity"],
            ":REPEAT" => $Validation["repeat_background"],
            ":FONT" => $Validation["font"],
            ":USERNAME" => $_USER->Username
        ]);
    }
        die(json_encode(["response" => "success"]));
    }
    if ($Validation['theme'] != "Grey" && $Validation['theme'] != "Blue" && $Validation['theme'] != "Red" && $Validation['theme'] != "Sunlight" && $Validation['theme'] != "Forest" && $Validation['theme'] != "8-bit" && $Validation['theme'] != "Princess" && $Validation['theme'] != "Fire" && $Validation['theme'] != "Stealth" && $Validation['theme'] != "Clear" && $Validation['theme'] != "Custom" && $Validation['theme'] != "My Old Theme") {
        die(json_encode(["response" => "error"]));
    }
    elseif ($Validation['theme'] != "Custom") {
        $DB->modify("UPDATE users SET c_theme = :THEME WHERE username = :USERNAME",[":THEME" => $Validation['theme'], ":USERNAME" => $_USER->Username]);
        die(json_encode(["response" => "success"]));
    }
}
else {
    die(json_encode(["response" => "error"]));
}

?>
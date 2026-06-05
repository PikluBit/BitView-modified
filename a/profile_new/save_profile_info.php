<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/_includes/init.php";
header("Content-Type: application/json", true);

if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}
if (($_POST["i_name_chk"]) == "true") { $i_name_chk = 1; } else { $i_name_chk = 0; }
if (($_POST["i_channelviews_chk"]) == "true") { $i_channelviews_chk = 1; } else { $i_channelviews_chk = 0; }
if (($_POST["i_videoviews_chk"]) == "true") { $i_videoviews_chk = 1; } else { $i_videoviews_chk = 0; }
if (($_POST["i_videoswatched_chk"]) == "true") { $i_videoswatched_chk = 1; } else { $i_videoswatched_chk = 0; }
if (($_POST["i_age_chk"]) == "true") { $i_age_chk = 1; } else { $i_age_chk = 0; }
if (($_POST["i_last_login_chk"]) == "true") { $i_last_login_chk = 1; } else { $i_last_login_chk = 0; }
if (($_POST["i_subscribers_chk"]) == "true") { $i_subscribers_chk = 1; } else { $i_subscribers_chk = 0; }
if (($_POST["i_website_chk"]) == "true") { $i_website_chk = 1; } else { $i_website_chk = 0; }
if (($_POST["i_description_chk"]) == "true") { $i_description_chk = 1; } else { $i_description_chk = 0; }
if (($_POST["i_about_chk"]) == "true") { $i_about_chk = 1; } else { $i_about_chk = 0; }
if (($_POST["i_hometown_chk"]) == "true") { $i_hometown_chk = 1; } else { $i_hometown_chk = 0; }
if (($_POST["i_country_chk"]) == "true") { $i_country_chk = 1; } else { $i_country_chk = 0; }
if (($_POST["i_occupation_chk"]) == "true") { $i_occupation_chk = 1; } else { $i_occupation_chk = 0; }
if (($_POST["i_companies_chk"]) == "true") { $i_companies_chk = 1; } else { $i_companies_chk = 0; }
if (($_POST["i_schools_chk"]) == "true") { $i_schools_chk = 1; } else { $i_schools_chk = 0; }
if (($_POST["i_hobbies_chk"]) == "true") { $i_hobbies_chk = 1; } else { $i_hobbies_chk = 0; }
if (($_POST["i_movies_chk"]) == "true") { $i_movies_chk = 1; } else { $i_movies_chk = 0; }
if (($_POST["i_music_chk"]) == "true") { $i_music_chk = 1; } else { $i_music_chk = 0; }
if (($_POST["i_books_chk"]) == "true") { $i_books_chk = 1; } else { $i_books_chk = 0; }
$Displayed_Elements = $i_name_chk.",".$i_channelviews_chk.",".$i_videoviews_chk.",".$i_videoswatched_chk.",".$i_age_chk.",".$i_last_login_chk.",".$i_subscribers_chk.",".$i_website_chk.",".$i_description_chk.",".$i_about_chk.",".$i_hometown_chk.",".$i_country_chk.",".$i_occupation_chk.",".$i_companies_chk.",".$i_schools_chk.",".$i_hobbies_chk.",".$i_movies_chk.",".$i_music_chk.",".$i_books_chk;

$_GUMP->validation_rules([
    "i_name"       => "max_len,30",
    "i_website"       => "max_len,128|valid_url",
    "i_desc"       => "max_len,5000",
    "i_about"       => "max_len,2048",
    "i_hometown"       => "max_len,128",
    "i_occupation"       => "max_len,128",
    "i_companies"       => "max_len,128",
    "i_schools"       => "max_len,128",
    "i_hobbies"       => "max_len,128",
    "i_movies"       => "max_len,128",
    "i_music"       => "max_len,128",
    "i_books"       => "max_len,128"
]);

$_GUMP->filter_rules([
    "i_name"       => "trim|NoHTML",
    "i_website"       => "trim|NoHTML",
    "i_desc"       => "trim|NoHTML",
    "i_about"       => "trim|NoHTML",
    "i_hometown"       => "trim|NoHTML",
    "i_country"       => "trim|NoHTML",
    "i_occupation"       => "trim|NoHTML",
    "i_companies"       => "trim|NoHTML",
    "i_schools"       => "trim|NoHTML",
    "i_hobbies"       => "trim|NoHTML",
    "i_movies"       => "trim|NoHTML",
    "i_music"       => "trim|NoHTML",
    "i_books"       => "trim|NoHTML"
]);

$Validation     = $_GUMP->run($_POST);

if ($Validation) { 
    $DB->modify("UPDATE users SET i_info = :INFO, i_name = :NAME, i_website = :WEBSITE, i_desc = :DESCRIPTION, i_about = :ABOUT, i_hometown = :HOMETOWN, i_country = :COUNTRY, i_occupation = :OCCUPATION, i_companies = :COMPANIES, i_schools = :SCHOOLS, i_hobbies = :HOBBIES, i_movies = :MOVIES, i_music = :MUSIC, i_books = :BOOKS WHERE username = :USERNAME",[":INFO" => $Displayed_Elements,":NAME" => $Validation['i_name'],":WEBSITE" => $Validation['i_website'],":DESCRIPTION" => $Validation['i_desc'],":ABOUT" => $Validation['i_about'],":HOMETOWN" => $Validation['i_hometown'],":COUNTRY" => $Validation['i_country'],":OCCUPATION" => $Validation['i_occupation'],":COMPANIES" => $Validation['i_companies'],":SCHOOLS" => $Validation['i_schools'],":HOBBIES" => $Validation['i_hobbies'],":MOVIES" => $Validation['i_movies'],":MUSIC" => $Validation['i_music'],":BOOKS" => $Validation['i_books'],":USERNAME" => $_USER->Username]);
    die(json_encode(["response" => "success"]));
}
else {
    die(json_encode(["response" => "error"]));
}
?>
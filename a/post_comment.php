<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/_includes/init.php";
header("Content-Type: application/json", true);

if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}

function make_links_clickable($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', (string) $text);
}

$_GUMP->validation_rules([
    "comment_text"    => "required|max_len,500|min_len,1",
    "attach_url"     => "required|max_len,100"
]);

$_GUMP->filter_rules([
    "comment_text"    => "trim|NoHTML",
    "attach_url"     => "trim"
]);

$Validation = $_GUMP->run($_POST);

if ($Validation) {
    $URL     = $Validation["attach_url"];
    $Comment = $Validation["comment_text"];

    $Video  = new Video($URL,$DB);
    $Video_Exists    = $Video->exists();

    if ($Video_Exists !== false) {
        $Spam = $DB->execute("SELECT id FROM videos_comments WHERE content = :COMMENT AND by_user = :BY_USER AND url = :URL", false,
                             [
                                 ":URL"     => $URL,
                                 ":COMMENT" => $Comment,
                                 ":BY_USER" => $_USER->Username
                             ]);
        $Spam_2 = $DB->execute("SELECT by_user FROM videos_comments WHERE url = :URL ORDER BY submit_on DESC LIMIT 5", false, [":URL" => $URL]);

        if (isset($Spam_2[0]["by_user"],$Spam_2[1]["by_user"],$Spam_2[2]["by_user"],$Spam_2[3]["by_user"],$Spam_2[4]["by_user"])) {
            if ($Spam_2[0]["by_user"] == $_USER->Username && $Spam_2[1]["by_user"] == $_USER->Username && $Spam_2[2]["by_user"] == $_USER->Username && $Spam_2[3]["by_user"] == $_USER->Username && $Spam_2[4]["by_user"] == $_USER->Username ) {
                $Not_Spam = false;
            } else {
                $Not_Spam = true;
            }
        } else {
            $Not_Spam = true;
        }

        if (!$Spam && $Not_Spam) {
            $Video_Info = $DB->execute("SELECT * FROM videos WHERE url = :URL", true, [":URL" => $URL]);
            $Username = $Video_Info["uploaded_by"];

            $DB->execute("SELECT blocker FROM users_block WHERE (blocker = :USERNAME AND blocked = :OTHER) OR (blocker = :OTHER AND blocked = :USERNAME)", false,
                        [
                            ":USERNAME" => $_USER->Username,
                            ":OTHER"    => $Username
                        ]);

            if ($DB->Row_Num > 0) {
                die(json_encode(["response" => "error"]));
            }

            if ($Video_Info["e_comments"] == 0 && $_USER->Username != $Username) { die(); }
            $DB->modify("INSERT INTO videos_comments (url,content,by_user,submit_on) VALUES (:URL,:COMMENT,:BY_USER,NOW())", [":URL" => $URL, ":COMMENT" => $Comment, ":BY_USER" => $_USER->Username]);
            $Last_ID = $DB->last_id();

            $DB->modify("UPDATE videos SET comments = comments + 1 WHERE url = :URL", [":URL" => $URL]);
            if ($Username != $_USER->Username) {
                        exec("php send_email.php c $Last_ID > /dev/null 2>&1 &");
                        $_INBOX = new Inbox($_USER,$DB);
                        $_INBOX->send_message($Video_Info["title"],$Comment,$Video_Info["uploaded_by"],$Video_Info["url"],2);
            }
            if (str_contains((string) $Comment, "@")) {
                    preg_match_all("/(?<!\S)@([0-9a-zA-Z]+)/", (string) $Comment, $Mentions);
                    foreach ($Mentions[1] as $Mention) {
                        $Exist = $DB->execute("SELECT username FROM users WHERE username = :USER LIMIT 1", true, [":USER" => $Mention]);
                        if (ctype_alnum($Mention) && $DB->Row_Num > 0 && strtolower((string) $_USER->username) !== strtolower($Mention)) {
                            $_INBOX = new Inbox($_USER,$DB);
                            $_INBOX->send_message($Video_Info["title"],$Comment,$Mention,$Video_Info["url"],4);
                        }
                    }
                }
            die(json_encode(["response" => "success"]));
        } else {
        	if ($Spam) {
                die(json_encode(["response" => "spam"]));
            }
            elseif ($Not_Spam == false) {
                die(json_encode(["response" => "spam2"]));
            }
        }
    }
}
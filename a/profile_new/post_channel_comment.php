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
    "username"     => "required|max_len,100"
]);

$_GUMP->filter_rules([
    "comment_text"    => "trim|NoHTML",
    "username"     => "trim"
]);

$Validation = $_GUMP->run($_POST);

if ($Validation) {
    $URL     = $Validation["username"];
    $Comment = $Validation["comment_text"];

    $_PROFILE = new User($URL,$DB);

    if ($_PROFILE->get_info() !== false && !$_PROFILE->is_banned()) {
        $_PROFILE->get_info();
        $DB->execute("SELECT blocker FROM users_block WHERE (blocker = :USERNAME AND blocked = :OTHER) OR (blocker = :OTHER AND blocked = :USERNAME)", false,
                        [
                            ":USERNAME" => $_USER->Username,
                            ":OTHER"    => $_PROFILE->Username
                        ]);

            if ($DB->Row_Num > 0) {
                die(json_encode(["response" => "error"]));
            }
        $Spam = $DB->execute("SELECT id FROM channel_comments WHERE content = :COMMENT AND by_user = :BY_USER AND on_channel = :URL", false,
                             [
                                 ":URL"     => $URL,
                                 ":COMMENT" => $Comment,
                                 ":BY_USER" => $_USER->Username
                             ]);
        $Spam_2 = $DB->execute("SELECT by_user FROM channel_comments WHERE on_channel = :URL ORDER BY submit_date DESC LIMIT 5", false, [":URL" => $URL]);

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
            $Profile_Info = $DB->execute("SELECT * FROM users WHERE username = :URL", true, [":URL" => $URL]);
            $DB->modify("INSERT INTO channel_comments (on_channel,content,by_user,submit_date) VALUES (:URL,:COMMENT,:BY_USER,NOW())", [":URL" => $URL, ":COMMENT" => $Comment, ":BY_USER" => $_USER->Username]);
            $Last_ID = $DB->last_id();

            $DB->modify("UPDATE users SET channel_comments = channel_comments + 1 WHERE username = :URL", [":URL" => $URL]);
            if (str_contains((string) $Comment, "@")) {
                    preg_match_all("/(?<!\S)@([0-9a-zA-Z]+)/", (string) $Comment, $Mentions);
                    foreach ($Mentions[1] as $Mention) {
                        $Exist = $DB->execute("SELECT username FROM users WHERE username = :USER LIMIT 1", true, [":USER" => $Mention]);
                        if (ctype_alnum($Mention) && $DB->Row_Num > 0 && strtolower((string) $_USER->username) !== strtolower($Mention)) {
                            $_INBOX = new Inbox($_USER,$DB);
                            $_INBOX->send_message($URL,$Comment,$Mention,"",5);
                        }
                    }
                }
            if ($URL != $_USER->Username) {
                        exec("php send_email.php c $Last_ID > /dev/null 2>&1 &");
                        $_INBOX = new Inbox($_USER,$DB);
                        $_INBOX->send_message("Channel comment for ".$URL,$Comment,$URL,"",2);
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
?>
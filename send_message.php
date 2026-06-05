<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) {
    header("location: /login");
    exit();
}

$_INBOX = new Inbox($_USER, $DB);

if (isset($_POST["send_message"])) {
    $_GUMP->validation_rules([
        "to_user"  => "required|max_len,20|alpha_numeric",
        "subject"  => "required|max_len,200",
        "message"  => "required|max_len,500",
        "attach_video"  => "max_len,200"
    ]);

    $_GUMP->filter_rules([
        "to_user"  => "trim|NoHTML",
        "subject"  => "trim|NoHTML",
        "message"  => "trim|NoHTML",
        "attach_video"  => "trim|NoHTML"
    ]);

    $Validation     = $_GUMP->run($_POST);

    if ($Validation) {
        $To = new User($Validation["to_user"], $DB);
        if (!empty($Validation["attach_video"])) {
            $parts = parse_url((string) $Validation["attach_video"]);
            mb_parse_str($parts['query'], $query);
            $At_URL = new Video($query["v"],$DB);
            $Att_URL = $At_URL->URL;
            $Type = 1;
        }
        else {
            $Att_URL = "";
            $Type = 0;
        }
        if ($To->exists()) {
            $DB->execute("SELECT blocker FROM users_block WHERE (blocker = :USERNAME AND blocked = :OTHER) OR (blocker = :OTHER AND blocked = :USERNAME)", false,
                        [
                            ":USERNAME" => $_USER->Username,
                            ":OTHER"    => $To->Username
                        ]);

            if ($DB->Row_Num > 0) {
                notification("You can't send a message to this user because you are blocked.", "/send_message");
            }
            if ($_INBOX->send_message($Validation["subject"],$Validation["message"], $To->Username,$Att_URL, $Type)) {
                notification($LANGS['messagesent'], "/inbox", "cfeeb2");
                exit();
            }
        } else {
            notification($LANGS['usernotexist'], "/send_message");
            exit();
        }
    }
}


$_PAGE = [
    "Page"          => "send_message",
    "Page_Type"     => "my_messages"
];
require "_templates/_structures/main.php";

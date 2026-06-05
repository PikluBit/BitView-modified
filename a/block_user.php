<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//REQUIREMENTS / PERMISSIONS
//- Requires Login
//- Requires ($_GET["user"])
//- User doesn't equal Block
if (!$_USER->Logged_In)                                        { header("location: /"); exit(); }
if (!isset($_GET["user"]))                                     { header("location: /"); exit(); }
if (strtolower((string) $_USER->Username) == strtolower((string) $_GET["user"])) { header("location: /"); exit(); }

$User = $DB->execute("SELECT username FROM users WHERE username = :USERNAME", true, [":USERNAME" => $_GET["user"]]);

if ($DB->Row_Num == 1) {
    $User = new User($User["username"],$DB);
    //CHECK BLOCK STATUS
    $Blocked = $DB->execute("SELECT blocker, blocked FROM users_block WHERE (blocker = :USERNAME AND blocked = :USER) OR (blocker = :USER AND blocked = :USERNAME)", true, [":USERNAME" => $_USER->Username, ":USER" => $User->Username]);

    if ($DB->Row_Num > 0) {
        if ($Blocked["blocker"] == $_USER->Username) {
            $Has_Blocked    = true;
            $Is_Blocked     = false;
        } else {
            $Has_Blocked    = false;
            $Is_Blocked     = true;
        }
    } else {
        $Has_Blocked    = false;
        $Is_Blocked     = false;
    }

    if (!$Has_Blocked && !$Is_Blocked) {
        echo("Blocking...");
        //BLOCK USER
        $DB->modify("INSERT INTO users_block VALUES (:YOU,:USER)",
                   [
                       ":YOU"   => $_USER->Username,
                       ":USER"  => $User->Username
                   ]);


        //REMOVE SUBSCRIPTIONS
        $DB->modify("DELETE FROM subscriptions WHERE subscriber = :USER AND subscription = :YOU",
                   [
                       ":YOU"   => $_USER->Username,
                       ":USER"  => $User->Username
                   ]);
        if ($DB->Row_Num == 1) {
            $User->update_subscriptions();
            $_USER->update_subscribers();
        }

        $DB->modify("DELETE FROM subscriptions WHERE subscription = :USER AND subscriber = :YOU",
                   [
                       ":YOU"   => $_USER->Username,
                       ":USER"  => $User->Username
                   ]);
        if ($DB->Row_Num == 1) {
            $User->update_subscribers();
            $_USER->update_subscriptions();
        }


        //REMOVE FRIENDS
        $Friends = $DB->execute("SELECT * FROM users_friends WHERE (friend_1 = :USERNAME AND friend_2 = :OTHER) OR (friend_1 = :OTHER AND friend_2 = :USERNAME)", true,
                               [
                                   ":USERNAME"  => $_USER->Username,
                                   ":OTHER"     => $User->Username
                               ]);

        if ($DB->Row_Num > 0) {
            $Status     = $Friends["status"];
            $Friend_1   = $Friends["friend_1"];
            $Friend_2   = $Friends["friend_2"];

            $DB->modify("DELETE FROM users_friends WHERE friend_1 = :USERNAME AND friend_2 = :OTHER AND status = :STATUS",[":USERNAME" => $Friend_1, ":OTHER" => $Friend_2, ":STATUS" => $Status]);
            if ($DB->Row_Num == 1 && $Status == 1) {
                $DB->modify("UPDATE users SET friends = GREATEST(friends - 1, 0) WHERE username = :USERNAME",[":USERNAME" => $Friend_1]);
                $DB->modify("UPDATE users SET friends = GREATEST(friends - 1, 0) WHERE username = :OTHER",[":OTHER" => $Friend_2]);
            }
        }

        header("location: /user/". $_GET['user']); exit();
    } elseif ($Has_Blocked == true) {
        echo("Unblocking...");
        //UNBLOCK USER
        $DB->modify("DELETE FROM users_block WHERE blocker = :YOU AND blocked = :USER",
                   [
                       ":YOU"   => $_USER->Username,
                       ":USER"  => $User->Username
                   ]);
        header("location: /user/". $_GET['user']); exit();
    }
}
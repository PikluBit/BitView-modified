<?php

class User
{
    public $Logged_In;
    public $Username;
    public $Subscribers;
    public $Is_Admin;
    public $Is_Moderator;
    public $Has_Permission;
    public $Info;
    public $Watched_Videos = [];
    public $QuickList = [];
    private $Is_Banned;

    public function __construct(string $Username, private readonly DB $DB, bool $Log_In = false)
    {
        if (!empty($Username) && $Log_In && (isset($_SESSION["username"]) && $_SESSION["username"] === $Username)) {
            $this->Username     = $Username;
            $this->Logged_In    = true;

            if (!$this->get_permissions() || $this->is_banned()) {
                $this->log_out();
                header("Location: /watch?v=zB_AIBLdXsy");
                exit();
            }
        } elseif (!empty($Username)) {
            $this->Logged_In    = false;
            $this->Username     = $Username;
        } else {
            $this->Logged_In    = false;
            $this->Username     = null;
        }

        if (!isset($_SESSION["watched_videos"])) {
            $_SESSION["watched_videos"] = [];
        }
        $this->Watched_Videos = $_SESSION["watched_videos"];
        
        if (!isset($_SESSION["quicklist"])) {
            $_SESSION["quicklist"] = [];
        }
        $this->QuickList = $_SESSION["quicklist"];
        if (!empty($this->Username)) { $this->Subscribers = $this->DB->execute("SELECT count(*) as amount FROM users INNER JOIN subscriptions ON subscriptions.subscription = :USERNAME WHERE subscriptions.subscriber = users.username AND is_banned = 0",true, [":USERNAME" => $this->Username],false)['amount']; }
        else { $this->Subscribers = 0; }
    }

    public function exists()
    {
        if (isset($this->Username) && !empty($this->Username)) {
            $Check = $this->DB->execute(
                "SELECT username FROM users WHERE username = :USERNAME",
                true,
                [":USERNAME" => $this->Username],
                false
            );

            if ($this->DB->Row_Num === 1) {
                $Username       = $Check["username"];
                $this->Username = $Username;
                return $Username;
            }
        }

        return false;
    }

    public function get_info()
    {
        if (isset($this->Username) && !empty($this->Username)) {
            $Info = $this->DB->execute(
                "SELECT * FROM users WHERE username = :USERNAME",
                true,
                [":USERNAME" => $this->Username],
                false
            );
            if ($this->DB->Row_Num === 1) {
                $this->Info                = $Info;
                $this->Username            = $this->Info["username"];
                $this->Is_Moderator        = $this->Info["is_moderator"];
                $this->Is_Admin            = $this->Info["is_admin"];
                $this->Is_Banned           = $this->Info["is_banned"];
                $this->Info["subscribers"] = $this->Subscribers;
                return true;
            }
        }
        return false;
    }

    public function has_info()
    {
        if (isset($this->Info)) {
            return true;
        }
        return false;
    }

    private function get_permissions()
    {
        $Permissions = $this->DB->execute(
            "SELECT is_banned, is_admin, is_moderator FROM users WHERE username = :USERNAME",
            true,
            [":USERNAME" => $this->Username],
            false
        );

        if ($this->DB->Row_Num === 1) {
            if (!$Permissions["is_banned"]) {
                $this->Is_Banned = false;
            } else {
                $this->Is_Banned = true;
            }

            if (!$Permissions["is_admin"]) {
                $this->Is_Admin = false;
            } else {
                $this->Is_Admin = true;
            }

            if (!$Permissions["is_moderator"]) {
                $this->Is_Moderator = false;
            } else {
                $this->Is_Moderator = true;
            }

            if (isset($_SESSION["has_permission"]) && $_SESSION["has_permission"] === true) {
                $this->Has_Permission = true;
            } else {
                $this->Has_Permission = false;
            }
            return true;
        } else {
            return false;
        }
    }

    public function set_permission()
    {
        if (($this->Is_Admin || $this->Is_Moderator) && !$this->Has_Permission) {
            $_SESSION["has_permission"] = true;
            $this->Has_Permission       = true;
            return true;
        }
        return false;
    }

    public function is_banned()
    {
        if (!isset($this->Is_Banned)) {
            $this->get_permissions();
        }
        if ($this->Is_Banned) {
            return true;
        }
        return false;
    }

    public function ban()
    {
        if ($this->Is_Admin || $this->Is_Moderator) {
            throw new Exception("You can only ban regular users!");
        }

        if (!$this->is_banned()) {
            $this->DB->modify(
                "UPDATE users SET is_banned = 1, avatar = '', is_partner = 0, is_avatar_video = 0 WHERE username = :USERNAME",
                [":USERNAME" => $this->Username],
                false
            );
            $this->DB->modify(
                "UPDATE videos SET uploaded_by_banned = 1 WHERE uploaded_by = :USERNAME",
                [":USERNAME" => $this->Username],
                false
            );
            $Subscriptions = $this->DB->execute("SELECT subscription FROM subscriptions WHERE subscriber = :USERNAME",false,[":USERNAME" => $this->Username],false);
            foreach ($Subscriptions as $Subscription) {
                $_USER = new User($Subscription["subscription"],$this->DB);
                $_USER->update_subscribers();
            }
            $this->DB->modify(
                "UPDATE videos SET uploaded_by_banned = 1 WHERE uploaded_by = :USERNAME",
                [":USERNAME" => $this->Username],
                false
            );
            $this->Is_Banned = true;
            return true;
        } else {
            $this->DB->modify(
                "UPDATE users SET is_banned = 0 WHERE username = :USERNAME",
                [":USERNAME" => $this->Username],
                false
            );
            $this->DB->modify(
                "UPDATE videos SET uploaded_by_banned = 0 WHERE uploaded_by = :USERNAME",
                [":USERNAME" => $this->Username],
                false
            );
            $Subscriptions = $this->DB->execute("SELECT subscription FROM subscriptions WHERE subscriber = :USERNAME",false,[":USERNAME" => $this->Username],false);
            foreach ($Subscriptions as $Subscription) {
                $_USER = new User($Subscription["subscription"],$this->DB);
                $_USER->update_subscribers();
            }
            $this->Is_Banned = false;
            return false;
        }
    }

    public function log_out()
    {
        if ($this->Logged_In) {
            session_destroy();
            if (isset($_COOKIE['remember'])) {
                setcookie("remember", "", ['expires' => time() - 86400 * 30, 'path' => "/"]);
            }
            $this->DB->modify("DELETE FROM remember_me WHERE userid = :USERNAME",[":USERNAME" => $this->Username]);

            $this->Logged_In    = false;
            $this->Username     = null;

            return true;
        } else {
            return false;
        }
    }

    public function log_in(string $Username)
    {
        if (!$this->Logged_In && ctype_alnum($Username) && !empty($Username) && mb_strlen($Username) <= 20) {
            $this->Username = $Username;

            if (!$this->is_banned()) {


                $_SESSION["username"]   = $Username;
                $this->Logged_In        = true;

                if (isset($_SESSION["login_attempts"])) {
                    unset($_SESSION["login_attempts"]);
                }
                if (isset($_SESSION["captcha"])) {
                    unset($_SESSION["captcha"]);
                }

                $this->DB->modify(
                    "UPDATE users SET ip_address = :IP, last_login = NOW() WHERE username = :USERNAME",
                    [":IP" => getenv('HTTP_CLIENT_IP') ?: getenv('HTTP_X_FORWARDED_FOR') ?: getenv('HTTP_X_FORWARDED') ?: getenv('HTTP_FORWARDED_FOR') ?: getenv('HTTP_FORWARDED') ?: getenv('REMOTE_ADDR'), ":USERNAME" => $this->Username],
                    false
                );

                session_regenerate_id();

                return true;
            } else {
                header("Location: /watch?v=zB_AIBLdXsy");
                exit();
            }
        }
        return false;
    }

    public function is_user(string $Username)
    {
        if (isset($this->Username) && strcasecmp($this->Username, $Username) === 0) {
            return true;
        }
        return false;
    }

    public function watch_video(Video $_VIDEO)
    {
        if (isset($_VIDEO->Exists)) {
            $Exists = (bool)$_VIDEO->Exists;
        } else {
            $Exists = (bool)$_VIDEO->exists();
        }

        if ($Exists) {

            if (!$_VIDEO->has_info()) {
                $_VIDEO->get_info();
            }

            $Amount = $this->DB->execute("SELECT count(url) as amount FROM being_watched", true, [], false)["amount"];
            if ($Amount < 200) {
                $this->DB->modify(
                    "INSERT IGNORE INTO being_watched (url,submit_date) VALUES (:URL,NOW())",
                    [":URL" => $_VIDEO->Info["url"]],
                    false
                );
            } else {
                $this->DB->modify("DELETE FROM being_watched ORDER BY submit_date ASC LIMIT 1",[],false);
                $this->DB->modify(
                    "INSERT IGNORE INTO being_watched (url,submit_date) VALUES (:URL,NOW())",
                    [":URL" => $_VIDEO->Info["url"]],
                    false
                );
            }
            if ($this->DB->Row_Num == 0) {
                $this->DB->modify(
                    "UPDATE being_watched SET submit_date = NOW() WHERE url = :URL",
                    [":URL" => $_VIDEO->Info["url"]],
                    false
                );
            }

            if (!in_array($_VIDEO->Info["url"], $this->Watched_Videos, true)) {
                $this->Watched_Videos[]         = $_VIDEO->Info["url"];
                $_SESSION["watched_videos"][]   = $_VIDEO->Info["url"];

                if ($this->Logged_In) {
                    //INCREASE USERS WATCHED VIDEOS
                    $this->DB->modify(
                        "UPDATE users SET videos_watched = videos_watched + 1 WHERE username = :USERNAME",
                        [":USERNAME" => $this->Username],
                        false
                    );

                    if ($this->has_info()) {
                        $this->Info["videos_watched"]++;
                    }
                }

                //INCREASE VIEWS
                if (!empty($_SERVER['HTTP_REFERER'])) {
                    if ($_VIDEO->add_view()) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function change_avatar(Video $_VIDEO)
    {
        if (file_exists($_SERVER["DOCUMENT_ROOT"]."/u/thmp/$_VIDEO->URL.jpg")) {
            $this->DB->modify("UPDATE users SET avatar = :AVATAR WHERE username = :USERNAME", [":AVATAR" => $_VIDEO->URL, ":USERNAME" => $this->Username], false);
            $this->DB->modify("UPDATE users SET is_avatar_video = '1' WHERE username = :USERNAME", [":USERNAME" => $this->Username],false);
            return true;
        }
        return false;
    }

    public function has_favorited(Video $_VIDEO)
    {
        if (isset($_VIDEO->Exists)) {
            $Exists = (bool)$_VIDEO->Exists;
        } else {
            $Exists = (bool)$_VIDEO->exists();
        }

        if ($Exists) {

            if (!$_VIDEO->has_info()) {
                $_VIDEO->get_info();
            }

            $this->DB->execute(
                "SELECT username FROM videos_favorites WHERE username = :USERNAME AND url = :URL",
                true,
                [":USERNAME" => $this->Username, ":URL" => $_VIDEO->Info["url"]],
                false
            );

            if ($this->DB->Row_Num === 1) {
                return true;
            }
        }
        return false;
    }

    public function favorite_video(Video $_VIDEO)
    {
        if (isset($_VIDEO->Exists)) {
            $Exists = (bool)$_VIDEO->Exists;
        } else {
            $Exists = (bool)$_VIDEO->exists();
        }

        if ($Exists) {
            if (!$_VIDEO->has_info()) {
                $_VIDEO->get_info();
            }

            if (!$this->has_favorited($_VIDEO)) {
                $this->DB->modify(
                    "INSERT IGNORE INTO videos_favorites (username,url,submit_on) VALUES (:USERNAME,:URL,NOW())",
                    [":USERNAME" => $this->Username, ":URL" => $_VIDEO->Info["url"]],
                    false
                );

                if ($this->DB->Row_Num === 1) {
                    $this->DB->modify(
                        "UPDATE users SET favorites = favorites + 1 WHERE username = :USERNAME",
                        [":USERNAME" => $this->Username],
                        false
                    );

                    $this->DB->modify(
                        "UPDATE videos SET favorites = favorites + 1 WHERE url = :URL",
                        [":URL" => $_VIDEO->Info["url"]],
                        false
                    );

                    if ($this->has_info()) {
                        $this->Info["favorites"]++;
                    }
                }
            } else {
                $this->DB->modify(
                    "DELETE FROM videos_favorites WHERE username = :USERNAME AND url = :URL",
                    [":USERNAME" => $this->Username, ":URL" => $_VIDEO->Info["url"]],
                    false
                );
                if ($this->DB->Row_Num === 1) {
                    $this->DB->modify(
                        "UPDATE users SET favorites = favorites - 1 WHERE username = :USERNAME",
                        [":USERNAME" => $this->Username],
                        false
                    );

                    $this->DB->modify(
                        "UPDATE videos SET favorites = favorites - 1 WHERE url = :URL",
                        [":URL" => $_VIDEO->Info["url"]],
                        false
                    );

                    if ($this->has_info()) {
                        $this->Info["favorites"]--;
                    }
                }
            }
            return true;
        }
        return false;
    }

    public function can_watch_video(Video $_VIDEO, User $_OWNER = null)
    {
        if (isset($_VIDEO->Exists)) {
            $Exists = (bool)$_VIDEO->Exists;
        } else {
            $Exists = (bool)$_VIDEO->exists();
        }

        if ($Exists) {
            if (!$_VIDEO->has_info()) {
                $_VIDEO->get_info();
            }

            if (($_VIDEO->Info["privacy"] == 1 && !$_VIDEO->Info["is_deleted"] && $_VIDEO->Info["uploaded_by_banned"] == 0) || ($_VIDEO->Info["privacy"] == 3 && !$_VIDEO->Info["is_deleted"] && $_VIDEO->Info["uploaded_by_banned"] == 0) || $this->Is_Admin || $this->Is_Moderator || (!$_VIDEO->Info["is_deleted"] && $this->Info["uploaded_by_banned"] == 0 && $this->Logged_In && strcasecmp((string) $_VIDEO->Info["uploaded_by"], (string) $this->Username) == 0)) {
                return true;
            } elseif ($_VIDEO->Info["privacy"] == 2 && $this->Logged_In && isset($_OWNER) && $this->is_friends_with($_OWNER) !== false) {
                return true;
            }
        }
        return false;
    }

    public function get_friends($LIMIT = 16, $Info = false)
    {
        if ($this->has_info() && $this->Info["friends"] == 0) {
            return [];
        }

        if (is_a($LIMIT, "Pagination")) {
            $LIMIT = "LIMIT ".$LIMIT->From.", ".$LIMIT->To;
        } else {
            $LIMIT = "LIMIT ".(int)$LIMIT;
        }

        if ($Info) {
            $JOIN = "INNER JOIN users ON users_friends.friend_1 = users.username OR users_friends.friend_2 = users.username";
            $WHERE = "AND users.username <> '$this->Username' AND users.is_banned = 0";
        } else {
            $JOIN = "";
            $WHERE = "";
        }

        $Friends = $this->DB->execute("SELECT * FROM users_friends $JOIN WHERE (users_friends.friend_1 = :USERNAME OR users_friends.friend_2 = :USERNAME) AND users_friends.status = 1 $WHERE ORDER BY users_friends.submit_on DESC $LIMIT", false, [":USERNAME" => $this->Username]);
        return $Friends;
    }

    public function is_friends_with(User $_USER)
    {
        $Check = $this->DB->execute("SELECT status, id, friend_1 FROM users_friends WHERE (friend_1 = :USERNAME AND friend_2 = :USERNAME_2) OR (friend_1 = :USERNAME_2 AND friend_2 = :USERNAME)", true, [":USERNAME" => $this->Username, ":USERNAME_2" => $_USER->Username],false);

        if ($this->DB->Row_Num == 1) {
            return $Check;
        } else {
            return false;
        }
    }

    public function add_friend(User $_USER)
    {
        if (strcasecmp((string) $_USER->Username, (string) $this->Username) == 0 || !$_USER->exists()) {
            return false;
        }

        //CHECK
        $this->DB->execute(
            "SELECT id FROM users_friends WHERE (friend_1 = :USERNAME AND friend_2 = :INVITE) OR (friend_1 = :INVITE AND friend_2 = :USERNAME) LIMIT 1",
            false,
            [":USERNAME" => $this->Username, ":INVITE" => $_USER->Username],
            false
        );

        if ($this->DB->Row_Num == 0) {
            $this->DB->modify(
                "INSERT INTO users_friends (friend_1,friend_2,submit_on) VALUES (:FRIEND_1,:FRIEND_2,NOW())",
                [":FRIEND_1" => $this->Username, ":FRIEND_2" => $_USER->Username],
                false
            );

            if ($this->DB->Row_Num == 1) {
                return true;
            }
        }
        return false;
    }

    public function accept_friend($ID)
    {
        $this->DB->modify(
            "UPDATE users_friends SET status = 1 WHERE id = :ID AND status = 0 AND friend_2 = :USERNAME",
            [":ID" => (int)$ID, ":USERNAME" => $this->Username],
            false
        );

        if ($this->DB->Row_Num == 1) {
            $Check = $this->DB->execute(
                "SELECT friend_1 FROM users_friends WHERE id = :ID",
                true,
                [":ID" => (int)$ID],
                false
            );

            $this->DB->modify(
                "UPDATE users SET friends = friends + 1 WHERE username = :USERNAME OR username = :INVITE",
                [":USERNAME" => $this->Username, ":INVITE" => $Check["friend_1"]],
                false
            );
            return true;
        }
        return false;
    }

    public function deny_friend($ID)
    {
        $this->DB->modify(
            "DELETE FROM users_friends WHERE id = :ID AND (friend_1 = :USERNAME OR friend_2 = :USERNAME) AND status = 0",
            [":USERNAME" => $this->Username, ":ID" => (int)$ID],
            false
        );

        if ($this->DB->Row_Num == 1) {
            return true;
        }
        return false;
    }

    public function remove_friend(User $_USER)
    {
        $this->DB->modify(
            "DELETE FROM users_friends WHERE (friend_1 = :USERNAME AND friend_2 = :INVITE) OR (friend_1 = :INVITE AND friend_2 = :USERNAME) AND status = 1",
            [":USERNAME" => $this->Username, ":INVITE" => $_USER->Username],
            false
        );

        if ($this->DB->Row_Num == 1) {
            $this->DB->modify(
                "UPDATE users SET friends = friends - 1 WHERE username = :USERNAME OR username = :INVITE",
                [":USERNAME" => $this->Username, ":INVITE" => $_USER->Username],
                false
            );
            return true;
        }
        return false;
    }

    public function has_rated(Video $_VIDEO)
    {
        $Rating = $this->DB->execute("SELECT rating FROM videos_ratings WHERE url = :URL AND username = :USERNAME", true, [":URL" => $_VIDEO->URL, ":USERNAME" => $this->Username],false);

        if ($this->DB->Row_Num > 0) {
            return $Rating["rating"];
        }
        return false;
    }

    public function rate_video(Video $_VIDEO, int $Rating)
    {
        $Rating = round($Rating);
        if ($Rating < 1 || $Rating > 5) {
            return false;
        }

        $Rated = $this->has_rated($_VIDEO);
        $Column = $Rating."stars";
        $R_Column = $Rated."stars";

        if ($Rated === false) {
            $this->DB->modify(
                "INSERT INTO videos_ratings (url,username,rating,submit_date) VALUES (:URL,:USERNAME,:RATING,NOW())",
                [":URL" => $_VIDEO->URL, ":USERNAME" => $this->Username, ":RATING" => $Rating],
                false
            );
            if ($this->DB->Row_Num > 0) {
                $this->DB->modify("UPDATE videos SET $Column = $Column + 1 WHERE url = :URL", [":URL" => $_VIDEO->URL]);
            }
            return false;
        } else {
            $this->DB->modify("UPDATE videos_ratings SET rating = :RATING, submit_date = NOW() WHERE url = :URL AND username = :USERNAME", [":URL" => $_VIDEO->URL, ":USERNAME" => $this->Username, ":RATING" => $Rating]);
            if ($this->DB->Row_Num > 0) {
                $this->DB->modify("UPDATE videos SET $Column = $Column + 1, $R_Column = $R_Column - 1 WHERE url = :URL", [":URL" => $_VIDEO->URL]);
            }
            return true;
        }
    }

    public function has_flagged(Video $_VIDEO)
    {
        $this->DB->execute("SELECT url FROM videos_flags WHERE url = :URL AND username = :USERNAME", false, [":URL" => $_VIDEO->URL, ":USERNAME" => $this->Username],false);

        if ($this->DB->Row_Num > 0) {
            return true;
        }
        return false;
    }

    public function has_flagged_user($Username)
    {
        $this->DB->execute("SELECT username FROM users_flags WHERE username = :USERNAME", false, [":USERNAME" => $Username],false);

        if ($this->DB->Row_Num > 0) {
            return true;
        }
        return false;
    }

    public function flag_video(Video $_VIDEO)
    {
        if ($this->has_flagged($_VIDEO)) {
            $this->DB->modify("DELETE FROM videos_flags WHERE url = :URL AND username = :USERNAME", [":URL" => $_VIDEO->URL, ":USERNAME" => $this->Username],false);
            return false;
        } else {
            $this->DB->modify("INSERT INTO videos_flags (url,username,submit_date) VALUES (:URL,:USERNAME,NOW())", [":URL" => $_VIDEO->URL, ":USERNAME" => $this->Username],false);
            return true;
        }
    }

    public function is_subscribed(User $_USER)
    {
        if (isset($_USER->Info["subscribers"]) && $_USER->Info["subscribers"] == 0) {
            return false;
        }

        $this->DB->execute("SELECT subscriber FROM subscriptions WHERE subscriber = :YOU AND subscription = :USER", true, [":YOU" => $this->Username, ":USER" => $_USER->Username],false);

        if ($this->DB->Row_Num > 0) {
            return true;
        }
        return false;
    }

    public function is_blocked(User $_USER)
    {
        $this->DB->execute("SELECT blocker FROM users_block WHERE (blocker = :YOU AND blocked = :USER)", true, [":YOU" => $this->Username, ":USER" => $_USER->Username],false);

        if ($this->DB->Row_Num > 0) {
            return true;
        }
        return false;
    }

    public function update_videos()
    {
        $Videos_Public = 0;
        $Videos_Private = 0;
        $Videos_Converting = 0;

        $Videos = $this->DB->execute("SELECT * FROM videos WHERE uploaded_by = :USERNAME AND is_deleted IS NULL", false, [":USERNAME" => $this->Username], false);
        foreach ($Videos as $Video) {
            if ($Video['status'] == 2) {
                if ($Video['privacy'] == 1) {
                    $Videos_Public += 1;
                } else {
                    $Videos_Private += 1;
                }
            } else {
                $Videos_Converting += 1;
            }
        }
        $this->DB->modify("UPDATE users SET videos = :VIDEOS, private_videos = :PRIVATE_VIDEOS, converting_videos = :CONVERTING_VIDEOS WHERE username = :YOU", [":VIDEOS" => $Videos_Public, ":PRIVATE_VIDEOS" => $Videos_Private, ":CONVERTING_VIDEOS" => $Videos_Converting, ":YOU" => $this->Username],false);
    }

    public function update_subscribers()
    {
        $this->Subscribers = $this->DB->execute("SELECT count(*) as amount FROM users INNER JOIN subscriptions ON subscriptions.subscription = :USERNAME WHERE subscriptions.subscriber = users.username AND is_banned = 0",true, [":USERNAME" => $this->Username],false)['amount'];
        $this->DB->modify("UPDATE users SET subscribers = :SUBSCRIBERS WHERE username = :YOU", [":SUBSCRIBERS" => $this->Subscribers, ":YOU" => $this->Username],false);
    }

    public function update_subscriptions()
    {
        $Subscriptions = $this->DB->execute("SELECT count(*) as amount FROM users INNER JOIN subscriptions ON subscriptions.subscriber = :USERNAME WHERE subscriptions.subscription = users.username AND is_banned = 0",true, [":USERNAME" => $this->Username],false)['amount'];
        $this->DB->modify("UPDATE users SET subscriptions = :SUBSCRIPTIONS WHERE username = :YOU", [":SUBSCRIPTIONS" => $Subscriptions, ":YOU" => $this->Username],false);
    }

    public function subscribe(User $_USER)
    {
        $this->DB->modify("INSERT IGNORE INTO subscriptions(subscriber,subscription,submit_date) VALUES (:YOU,:USER,NOW())", [":YOU" => $this->Username, ":USER" => $_USER->Username],false);

        if ($this->DB->Row_Num > 0) {
            $subscribed = true;
        } else {
            $this->DB->modify("DELETE FROM subscriptions WHERE subscriber = :YOU AND subscription = :USER", [":YOU" => $this->Username, ":USER" => $_USER->Username],false);
            $subscribed = false;
        }
        $_USER->update_subscribers();
        $this->update_subscriptions();
        return $subscribed;
    }
}

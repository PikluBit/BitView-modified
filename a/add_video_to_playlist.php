<?php if (isset($_GET["close"])) : ?><script type="text/javascript">window.close();</script><?php endif ?>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["v"]
if (!$_USER->Logged_In)                               { header("location: /login"); exit(); }
if (!isset($_GET["v"]) || mb_strlen((string) $_GET["v"]) > 11) { header("location: /"); exit();          }

$_VIDEO = new Video($_GET["v"],$DB);

$Playlist = $_GET["pl"];
$Playlist_ID = $DB->execute("SELECT id FROM playlists WHERE id = :ID AND by_user = :USERNAME", true, [":ID" => $Playlist, ":USERNAME" => $_USER->Username])["id"];

if ($_VIDEO->exists()) {
                    $DB->execute("SELECT url FROM playlists_videos WHERE url = :URL AND playlist_id = :ID", true, [":URL" => $_VIDEO->URL, ":ID" => $Playlist_ID]);

                    if ($DB->Row_Num == 0) {
                        $Position = $DB->execute("SELECT position FROM playlists_videos WHERE playlist_id = :ID ORDER BY position DESC LIMIT 1", true, [":ID" => $Playlist_ID]);
                        if ($Position) {
                            $Position = $Position["position"] + 1;
                        } else {
                            $Position = 1;
                        }

                        $DB->modify("INSERT INTO playlists_videos(url,playlist_id,position) VALUES (:URL,:ID,:POSITION)", [":URL" => $_VIDEO->URL, ":ID" => $Playlist_ID, ":POSITION" => $Position]);
                        $DB->modify("UPDATE playlists SET update_date = NOW() WHERE id = :ID",[":ID" => $Playlist_ID]);
                        $Count++;
                    }
                }

?>
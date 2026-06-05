<?php

class Video
{
    public $Info;
    public $Exists;
    public $URL;

    public function __construct(string $URL, private readonly DB $DB, array $Data = null)
    {
        $this->URL  = $URL;
        if (isset($Data)) {
            $this->Info = $Data;
        }
    }

    public function exists()
    {
        $Check = $this->DB->execute("SELECT url FROM videos WHERE url = :URL", true, [":URL" => $this->URL], false);

        if ($this->DB->Row_Num === 1) {
            $this->Exists = true;
            $this->URL    = $Check["url"];
            return true;
        }
        $this->Exists = false;
        return false;
    }

    public function get_info()
    {
        if (!$this->has_info()) {
            $Info = $this->DB->execute("SELECT * FROM videos WHERE url = :URL", true, [":URL" => $this->URL],false);

            if ($this->DB->Row_Num === 1) {
                $this->Info = $Info;
                $this->URL  = $Info["url"];
                return true;
            } else {
                die("err10");
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

    public function check_info()
    {
        if (!$this->has_info()) {
            $this->Info = [];
        }
        if (!isset($this->Info["title"]) || empty($this->Info["title"])) {
            $this->Info["title"] = false;
        }
        if (!isset($this->Info["description"]) || empty($this->Info["description"])) {
            $this->Info["description"] = false;
        }
        if (!isset($this->Info["tags"]) || empty($this->Info["tags"])) {
            $this->Info["tags"] = false;
        }
        if (!isset($this->Info["uploaded_by"]) || empty($this->Info["uploaded_by"])) {
            $this->Info["uploaded_by"] = false;
        }
        if (!isset($this->Info["uploaded_on"]) || empty($this->Info["uploaded_on"])) {
            $this->Info["uploaded_on"] = false;
        }
        if (!isset($this->Info["length"]) || empty($this->Info["length"])) {
            $this->Info["length"] = false;
        }
        if (!isset($this->Info["views"]) || empty($this->Info["views"])) {
            $this->Info["views"] = 0;
        }
        if (!isset($this->Info["comments"]) || empty($this->Info["comments"])) {
            $this->Info["comments"] = 0;
        }
        if (!isset($this->Info["uploaded_by_banned"]) || $this->Info["uploaded_by_banned"] == 0) {
            $this->Info["uploaded_by_banned"] = false;
        } else {
            $this->Info["uploaded_by_banned"] = true;
        }
        if (!isset($this->Info["is_deleted"]) || $this->Info["is_deleted"] == 0) {
            $this->Info["is_deleted"] = false;
        } else {
            $this->Info["is_deleted"] = true;
        }
        return true;
    }

    public function tag_array()
    {
        if ($this->Info["tags"]) {
            return array_filter(explode(",", (string) $this->Info["tags"]));
        }
        return false;
    }

    public function comments(bool $Include_Users = false, int $ORDER = 0, int $LIMIT = 64, int $OFFSET = 0)
    {
        if ($ORDER === 0) {
            $ORDER = "ASC";
        } else {
            $ORDER = "DESC";
        }

        if (!$Include_Users) {
            $Comments = $this->DB->execute(
                "SELECT * FROM videos_comments WHERE url = :URL ORDER BY submit_on $ORDER LIMIT $LIMIT",
                false,
                [":URL" => $this->URL],
                false
            );
            if ($this->DB->Row_Num > 0) {
                return $Comments;
            }
        } else {
            $Comments = $this->DB->execute(
                "SELECT videos_comments.*, users.videos, users.favorites, users.friends FROM videos_comments INNER JOIN users ON videos_comments.by_user = users.username WHERE videos_comments.url = :URL ORDER BY videos_comments.submit_on $ORDER LIMIT $OFFSET, $LIMIT",
                false,
                [":URL" => $this->URL],
                false
            );
            if ($this->DB->Row_Num > 0) {
                return $Comments;
            }
        }
        return false;
    }

    public function show_video(int $Width, int $Height, bool $Autoplay, array $LANGS)
    {
        if (!$this->has_info()) {
            $this->get_info();
        }

        require_once $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/player.php";
        return true;
    }

    public function add_view(int $Amount = 1)
    {
        if (isset($this->Exists) && $this->Exists && $Amount !== 0) {
            $Amount = (int)$Amount;

            $this->DB->modify(
                "UPDATE videos SET views = views + :AMOUNT WHERE url = :URL",
                [":AMOUNT" => $Amount, ":URL" => $this->URL],
                false
            );
            $this->DB->modify(
                "UPDATE users SET video_views = video_views + :AMOUNT WHERE username = :USERNAME",
                [":AMOUNT" => $Amount, ":USERNAME" => $this->Info["uploaded_by"]],
                false
            );
            $this->DB->modify("INSERT IGNORE INTO views_day(url,views,submit_date) VALUES(:URL,:AMOUNT,NOW()) ON DUPLICATE KEY UPDATE views = views + :AMOUNT", [":URL" => $this->URL, ":AMOUNT" => $Amount],false);
            if (isset($_GET["pl"])) {
                $this->DB->modify("UPDATE playlists SET views = views + 1 WHERE id = :URL",[":URL" => $_GET["pl"]],false);
            }

            if ($this->DB->Row_Num === 1) {
                return true;
            }
        }
        return false;
    }

    public function delete()
    {
        if (isset($this->Exists) && $this->Exists) {
            if (!$this->has_info()) {
                $this->get_info();
            }

            // Fake delete the video so we can look at or restore if needed
            $this->change_info(['is_deleted' => true]);
            //DELETE FROM UPLOADS TABLE
            $this->DB->modify("DELETE FROM videos_uploads WHERE vid = :URL", [":URL" => $this->Info["url"]]);

            $_USER = new User($this->Info["uploaded_by"],$this->DB);
            $_USER->update_videos();

            return true;
        }
        return false;
    }

    public function restore()
    {
        if (isset($this->Exists) && $this->Exists) {
            if (!$this->has_info()) {
                $this->get_info();
            }

            // Check if we can restore the video
            if ($this->Info["status"] == 2 && $this->Info["is_deleted"]) {
                $this->change_info(['is_deleted' => false]);

                $_USER = new User($this->Info["uploaded_by"],$this->DB);
                $_USER->update_videos();

                return true;
            }
        }
        return false;
    }

    public function purge()
    {
        if (isset($this->Exists) && $this->Exists) {
            if (!$this->has_info()) {
                $this->get_info();
            }

            // Fake delete if the video hasn't been already
            if (!$this->Info["is_deleted"]) {
                $this->delete();
            }

            //DELETE FROM CONVERTING TABLE
            $this->DB->modify(
                "DELETE FROM converting WHERE url = :URL",
                [":URL" => $this->Info["url"]],
                false
            );

            $this->DB->modify("DELETE FROM views_day WHERE url = :URL", [":URL" => $this->URL],false);

            $Converting_File = @glob($_SERVER['DOCUMENT_ROOT']."/u/tmp/".$this->Info["file_url"].".*")[0];
            @unlink($Converting_File);

            $Normal_File = @glob($_SERVER['DOCUMENT_ROOT']."/videos/".$this->Info["file_url"].".*")[0];
            @unlink($Normal_File);

            @unlink($_SERVER['DOCUMENT_ROOT']."/u/thmp/".$this->Info["url"].".jpg");

            $this->change_info(["file_url" => false]);
            return true;
        }
        return false;
    }

    public function change_info(array $Array)
    {
        if (count($Array) > 0 && isset($this->Exists) && $this->Exists) {
            $Update_SQL = "UPDATE videos SET ";
            $Execute = [];

            if (isset($Array["title"])) {
                $Update_SQL .= "title = :TITLE, ";
                $Execute[":TITLE"] = $Array["title"];
            }

            if (isset($Array["description"])) {
                $Update_SQL .= "description = :DESCRIPTION, ";
                $Execute[":DESCRIPTION"] = $Array["description"];
            }

            if (isset($Array["tags"])) {
                $Update_SQL .= "tags = :TAGS, ";
                $Execute[":TAGS"] = $Array["tags"];
            }

            if (isset($Array["category"])) {
                $Update_SQL .= "category = :CATEGORY, ";
                $Execute[":CATEGORY"] = (int)$Array["category"];
            }

            if (isset($Array["privacy"]) && ($Array["privacy"] == 1 || $Array["privacy"] == 2 || $Array["privacy"] == 3)) {
                if (!$this->has_info()) {
                    $this->get_info();
                }

                if ($Array["privacy"] == 1 && $this->Info["privacy"] != 1) {
                    $Update_SQL .= "privacy = 1, ";
                    if ($this->Info["status"] == 2) {
                        $User_Update = true;
                    }
                }

                if (($Array["privacy"] == 2 || $Array["privacy"] == 3)) {
                    if ($Array["privacy"] == 2) {
                        $Update_SQL .= "privacy = 2, ";
                    }
                    else {
                        $Update_SQL .= "privacy = 3, ";
                    }
                    if ($this->Info["status"] == 2 && ($this->Info["privacy"] != 2 && $this->Info["privacy"] != 3)) {
                        $User_Update = true;
                    }
                }
            }

            if (isset($Array["views"])) {
                if (!$this->has_info()) {
                    $this->get_info();
                }

                if ($Array["views"] != $this->Info["views"]) {
                    if ($Array["views"] > $this->Info["views"]) {
                        $Views = $Array["views"] - $this->Info["views"];
                    } elseif ($Array["views"] < $this->Info["views"]) {
                        $Views = $Array["views"] - $this->Info["views"];
                    } else {
                        $Views = 0;
                    }

                    $this->add_view($Views);
                }
            }

            if (isset($Array["date_recorded"])) {
                $Update_SQL .= "date_recorded = :DATE, ";
                $Execute[":DATE"] = $Array["date_recorded"];
            }

            if (isset($Array["e_comments"])) {
                $Update_SQL .= "e_comments = :E_COMMENTS, ";
                $Execute[":E_COMMENTS"] = $Array["e_comments"];
            }

            if (isset($Array["e_ratings"])) {
                $Update_SQL .= "e_ratings = :E_RATINGS, ";
                $Execute[":E_RATINGS"] = $Array["e_ratings"];
            }

            if (isset($Array["address"])) {
                $Update_SQL .= "address = :ADDRESS, ";
                $Execute[":ADDRESS"] = $Array["address"];
            }

            if (isset($Array["country"])) {
                $Update_SQL .= "country = :COUNTRY, ";
                $Execute[":COUNTRY"] = $Array["country"];
            }

            if (isset($Array["file_url"])) {
                if ($Array['file_url'] === false) {
                    $Update_SQL .= "file_url = NULL, ";
		} else {
                    $Update_SQL .= "file_url = :FILE_URL, ";
                    $Execute[":FILE_URL"] = $Array["file_url"];
		}
            }

            if (isset($Array["is_deleted"])) {
	        $Update_SQL .= 'is_deleted = ' . (($Array['is_deleted']) ? 'NOW()' : 'NULL') . ', ';
            }

            $Update_SQL      = mb_substr($Update_SQL, 0, mb_strlen($Update_SQL) - 2)." WHERE url = :URL";
            $Execute[":URL"] = $this->URL;


            $this->DB->modify(
                $Update_SQL,
                $Execute
            );

            if (isset($User_Update)) {
                $_USER = new User($this->Info["uploaded_by"],$this->DB);
                $_USER->update_videos();
            }
            return true;
        }
        return false;
    }
}

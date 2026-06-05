<?php

class Videos
{
    public $WHERE_P            = false;
    public $WHERE_D            = "";
    public $WHERE_C            = "";
    public $SELECT             = "videos.*";
    public $ORDER_BY           = false;
    public $STATUS             = 2;
    public $Private_Videos     = false;
    public $Deleted_Videos     = false;
    public $Banned_Users       = false;
    public $Blocked_Users      = false;
    public $LIMIT              = 999;
    public $Limit_Required     = false;
    public $JOIN               = "";
    public $Can_Watch          = false;
    public $Execute            = [];

    public static $Videos;
    public static $Amount;

    public function __construct(private readonly DB $DB, private readonly User $_USER)
    {
    }

    public function get()
    {
        if (is_a($this->LIMIT, "Pagination")) {
            $LIMIT = "LIMIT ".$this->LIMIT->From.", ".$this->LIMIT->To;
        } elseif ($this->LIMIT === false) {
            $LIMIT = "";
        } else {
            $LIMIT = "LIMIT ".(int)$this->LIMIT;
        }


        if ($this->ORDER_BY === false) {
            $ORDER_BY = "";
        } else {
            $ORDER_BY = "ORDER BY $this->ORDER_BY";
        }


        $WHERE = "WHERE ";
        if ($this->STATUS === 2) {
            $WHERE .= "(videos.status = 2 OR videos.status IS NULL)";
        } elseif ($this->STATUS === 1) {
            $WHERE .= "(videos.status = 1 OR videos.status IS NULL)";
        } elseif ($this->STATUS === 0) {
            $WHERE .= "(videos.status = 0 OR videos.status IS NULL)";
        } elseif ($this->STATUS === -1) {
            $WHERE .= "(videos.status = -1 OR videos.status IS NULL)";
        } elseif ($this->STATUS === false) {
            $WHERE .= "";
        }
        if ($this->Private_Videos === false && $WHERE != "WHERE ") {
            $WHERE .= " AND ";
        }
        if ($this->Private_Videos === false) {
            $WHERE .= "(videos.privacy <> 2 AND videos.privacy <> 3 OR videos.privacy IS NULL)";
        } else {
            $WHERE .= "";
        }
        if ($this->Deleted_Videos === false && $WHERE != "WHERE ") {
            $WHERE .= " AND ";
        }
        if ($this->Deleted_Videos === false) {
            $WHERE .= "(videos.is_deleted IS NULL)";
        } else {
            $WHERE .= "";
        }
        if ($this->Banned_Users === false && $WHERE != "WHERE ") {
            $WHERE .= " AND ";
        }
        if ($this->Banned_Users === false) {
            $WHERE .= "(videos.uploaded_by_banned <> 1 OR videos.uploaded_by_banned IS NULL)";
        }
        else {
            $WHERE .= "";
        }
        if ($this->Blocked_Users === false && $this->_USER->Logged_In && $WHERE != "WHERE ")  { 
            $WHERE .= " AND ";
        }
        if ($this->Blocked_Users === false && $this->_USER->Logged_In)  { 
            $Username = $this->_USER->Username;
            $this->JOIN   .= " LEFT JOIN users_block ON (('$Username' = users_block.blocker AND videos.uploaded_by = users_block.blocked) OR ('$Username' = users_block.blocked AND videos.uploaded_by = users_block.blocker)) ";
            $WHERE        .= "(users_block.blocker IS NULL)";
        }
        else {
            $WHERE .= "";
        }
        if (!empty($WHERE) && $WHERE !== "WHERE " && $this->WHERE_P !== false) {
            $WHERE .= " AND ";
        }

        if ($this->WHERE_P !== false && is_array($this->WHERE_P) && count($this->WHERE_P) > 0) {
            $Amount     = count($this->WHERE_P);
            $Count      = 0;
            $Execute    = [];
            foreach ($this->WHERE_P as $P => $Value) {
                $Count++;
                $WHERE .= "$P = :".str_replace(".", "", $P);
                if ($Amount !== $Count) {
                    $WHERE .= " AND ";
                }
                $Execute[":".str_replace(".", "", $P)] = $Value;
            }
        } else {
            $Execute = [];
        }


        if (count($this->Execute) > 0) {
            foreach($this->Execute as $Exec => $Value) {
                $Execute[$Exec] = $Value;
            }
        }

        // DEBUG
        //echo "SELECT $this->SELECT FROM videos $this->JOIN $WHERE $this->WHERE_C $ORDER_BY $LIMIT<br><br>";
        $Videos = $this->DB->execute("SELECT $this->SELECT FROM videos $this->JOIN $WHERE $this->WHERE_D $this->WHERE_C $ORDER_BY $LIMIT", false, $Execute);
        if ($this->Limit_Required && $this->DB->Row_Num < $this->LIMIT) {
            $Videos = $this->DB->execute("SELECT $this->SELECT FROM videos $this->JOIN $WHERE $this->WHERE_C ORDER BY uploaded_on DESC,views DESC $LIMIT", false, $Execute);
        }
        static::$Amount = $this->DB->Row_Num;

        if (static::$Amount > 0) {
            $this::$Videos = $Videos;
            return true;
        }
        $this::$Videos = [];
        return false;
    }

    public function fix_values(bool $Thumbnail = true, bool $Tag_Array = false)
    {
        if (!static::$Videos) {
            return [];
        }

        $Base_Folder = $_SERVER['DOCUMENT_ROOT'];
        foreach (static::$Videos as $Video => $Value) {
            if (($this->_USER->Logged_In && $this->_USER->Username === static::$Videos[$Video]["uploaded_by"] && !static::$Videos[$Video]["is_deleted"] && !static::$Videos[$Video]["uploaded_by_banned"]) || (static::$Videos[$Video]["privacy"] == 1 && !static::$Videos[$Video]["is_deleted"] && !static::$Videos[$Video]["uploaded_by_banned"]) || (static::$Videos[$Video]["privacy"] == 3 && !static::$Videos[$Video]["is_deleted"] && !static::$Videos[$Video]["uploaded_by_banned"]) || $this->Can_Watch) {
                $Can_Watch = true;
            } else {
                $Can_Watch = false;
            }


            if (!isset(static::$Videos[$Video]["url"]) || empty(static::$Videos[$Video]["url"])) {
                static::$Videos[$Video]["url"]          = "";
                static::$Videos[$Video]["link"]         = "";
                static::$Videos[$Video]["thumb"]        = "/img/nothump.png";
            } else {
                if ($Can_Watch) {
                    static::$Videos[$Video]["link"]     = "/watch?v=" . static::$Videos[$Video]["url"];
                    if (file_exists($Base_Folder."/u/thmp/".static::$Videos[$Video]["url"].".jpg")) {
                        static::$Videos[$Video]["thumb"] = "/u/thmp/" . static::$Videos[$Video]["url"] . ".jpg";
                    } else {
                        static::$Videos[$Video]["thumb"]    = "/img/nothump.png";
                    }
                } else {
                    if (static::$Videos[$Video]["privacy"] == 2) {
                        static::$Videos[$Video]["link"]     = "/watch?v=" . static::$Videos[$Video]["url"];
                        static::$Videos[$Video]["thumb"]    = "/img/private_video-vfl20830.jpg";
                    } else {
                        static::$Videos[$Video]["link"]     = "";
                        static::$Videos[$Video]["thumb"]    = "/img/nothump.png";
                    }
                }
            }
            if (!isset(static::$Videos[$Video]["title"]) || empty(static::$Videos[$Video]["title"]) || static::$Videos[$Video]["is_deleted"] || static::$Videos[$Video]["uploaded_by_banned"]) {
                static::$Videos[$Video]["title"] = "Deleted Video";
            } elseif (!$Can_Watch) {
                static::$Videos[$Video]["title"] = "Private Video";
            } else {
                static::$Videos[$Video]["title"] = static::$Videos[$Video]["title"];
            }

            if (!isset(static::$Videos[$Video]["description"]) || empty(static::$Videos[$Video]["description"]) || static::$Videos[$Video]["is_deleted"] || static::$Videos[$Video]["uploaded_by_banned"]) {
                static::$Videos[$Video]["description"] = false;
            } elseif (!$Can_Watch) {
                static::$Videos[$Video]["description"] = "";
            } else {
                static::$Videos[$Video]["description"] = static::$Videos[$Video]["description"];
            }
            if (!isset(static::$Videos[$Video]["tags"]) || empty(static::$Videos[$Video]["tags"]) || !$Can_Watch) {
                static::$Videos[$Video]["tags"]                     = false;
                if ($Tag_Array) {
                    static::$Videos[$Video]["tags"]   = [];
                }
            } elseif ($Tag_Array) {
                static::$Videos[$Video]["tags"] = array_filter(explode(",", (string) static::$Videos[$Video]["tags"]));
            } else {
                static::$Videos[$Video]["tags"] = static::$Videos[$Video]["tags"];
            }
            if (!isset(static::$Videos[$Video]["uploaded_by"]) || empty(static::$Videos[$Video]["uploaded_by"]) || !$Can_Watch) {
                static::$Videos[$Video]["uploaded_by"]      = "";
                static::$Videos[$Video]["uploader_link"]    = "/";
            } else {
                static::$Videos[$Video]["uploader_link"]    = "/user/".static::$Videos[$Video]["uploaded_by"];
            }
            if (!isset(static::$Videos[$Video]["views"]) || empty(static::$Videos[$Video]["views"]) || !$Can_Watch) {
                static::$Videos[$Video]["views"]    = 0;
            }
            if (!isset(static::$Videos[$Video]["comments"]) || empty(static::$Videos[$Video]["comments"]) || !$Can_Watch) {
                static::$Videos[$Video]["comments"] = 0;
            }
            if (!isset(static::$Videos[$Video]["length"]) || empty(static::$Videos[$Video]["length"]) || !$Can_Watch) {
                static::$Videos[$Video]["length"]   = 0;
            }
        }

        if ($this->LIMIT !== 1) {
            return static::$Videos;
        } else {
            return static::$Videos[0];
        }
    }
}

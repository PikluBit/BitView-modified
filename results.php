<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////"$_GET["search"]" MUST BE SET
////"_GET["search"]" MUST BE ABOVE 3 AND UNDER 128 CHARACTERS
if (!isset($_GET["search"])) {
    header("location: /");
    exit();
}
if (mb_strlen((string) $_GET["search"]) < 2 || mb_strlen((string) $_GET["search"]) > 128) {
    notification($LANGS['searcherror'], "/");
    exit();
}
if (!isset($_GET["t"])) {
    header("location: /");
    exit();
}

$SearchQuery = $_GET["search"];
$Query = str_replace("'","''",$SearchQuery);

$_PAGINATION = new Pagination(20, 99);

if ($_GET["t"] == "Search All") {

    $Users = $DB->execute("SELECT * FROM users LEFT JOIN users_block ON ((:USERNAME = users_block.blocker AND users.username = users_block.blocked) OR (:USERNAME = users_block.blocked AND users.username = users_block.blocker)) WHERE (username LIKE :TITLE OR displayname LIKE :TITLE OR i_title LIKE :TITLE OR i_tags LIKE :TITLE) AND is_banned = 0 AND users_block.blocker IS NULL ORDER BY subscribers DESC LIMIT 1", false, [":TITLE" => "%".$Query."%", ":USERNAME" => $_USER->Username],false);

    $Playlists = $DB->execute("SELECT * FROM playlists INNER JOIN users ON users.username = playlists.by_user LEFT JOIN users_block ON ((:USERNAME = users_block.blocker AND playlists.by_user = users_block.blocked) OR (:USERNAME = users_block.blocked AND playlists.by_user = users_block.blocker)) WHERE users.is_banned = 0 AND playlists.title LIKE :TITLE AND users_block.blocker IS NULL or playlists.by_user LIKE :TITLE AND users_block.blocker IS NULL ORDER BY submit_date DESC LIMIT 1", false, [":TITLE" => "%".$Query."%", ":USERNAME" => $_USER->Username],false);

    if (isset($_GET["uploaded"]) && $_GET["uploaded"] == "d") {
    $WHEN = " AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 24 HOUR) ";
    } elseif (isset($_GET["uploaded"]) && $_GET["uploaded"] == "w") {
        $WHEN = " AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 1 WEEK) ";
    } elseif (isset($_GET["uploaded"]) && $_GET["uploaded"] == "m") {
        $WHEN = " AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 1 MONTH) ";
    } else {
        $WHEN = "";
    }

    if (isset($_GET["type"]) && $_GET["type"] == "hd") {
        $TYPE = " AND videos.hd = 1 ";
    } elseif (isset($_GET["type"]) && $_GET["type"] == "partner") {
        $TYPE = " AND users.is_partner = 1 ";
    } else {
        $TYPE = "";
    }

    if (isset($_GET["length"]) && $_GET["length"] == "s") {
        $LENGTH = " AND videos.length <= 270 ";
    } elseif (isset($_GET["length"]) && $_GET["length"] == "l") {
        $LENGTH = " AND videos.length > 780";
    }
    else {
        $LENGTH = "";
    }

    $Amount             = new Videos($DB, $_USER);
    $Amount->SELECT     = "count(url) as amount";
    $Amount->WHERE_C    = " AND (MATCH(tags) AGAINST (:SEARCH) COLLATE utf8mb4_general_ci OR videos.uploaded_by = :SEARCH COLLATE utf8mb4_general_ci OR videos.title COLLATE utf8mb4_general_ci LIKE '%:SEARCH%' OR videos.description COLLATE utf8mb4_general_ci LIKE '%:SEARCH%')".$WHEN.$TYPE.$LENGTH;
    $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
    $Amount->Execute    = [":SEARCH" => $Query];
    $Amount->get();
    $_PAGINATION->total($Amount::$Videos[0]["amount"]);

    if (!isset($_GET["order"])) {
        $Order_By = "((user_relevance * 1000) + (title_relevance * 100) 
                                        + (description * 50)
                                        + (tag_relevance * 10)
                                        + (tag_relevance_2 / 10)
                                        + (videos.views / 100) 
                                        + (videos.5stars / 50)
                                        - (videos.1stars))
                                        + (CASE WHEN user_relevance > 0 THEN (-DATEDIFF(NOW(), videos.uploaded_on) / 8) else 0 end) DESC";
    } elseif ($_GET["order"] == "date") {
        $Order_By = "videos.uploaded_on DESC";
    } elseif ($_GET["order"] == "name") {
        $Order_By = "videos.title ASC";
    } elseif ($_GET["order"] == "views") {
        $Order_By = "videos.views DESC";
    } elseif ($_GET["order"] == "rating") {
        $Order_By = "videos.5stars DESC";
    } else {
        header("location: /");
        exit();
    }
    $Videos             = new Videos($DB, $_USER);
    $Videos->SELECT     = "videos.*, (videos.uploaded_by = :SEARCH) as user_relevance, (title COLLATE utf8mb4_general_ci LIKE '%:SEARCH%') as title_relevance, videos.tags LIKE ('%:SEARCH%') as tag_relevance, (MATCH(tags) AGAINST (:SEARCH)) as tag_relevance_2, (videos.description COLLATE utf8mb4_general_ci LIKE '%:SEARCH%') as description_relevance";
    $Videos->WHERE_C    = " AND (MATCH(tags) AGAINST (:SEARCH) COLLATE utf8mb4_general_ci OR videos.uploaded_by = :SEARCH COLLATE utf8mb4_general_ci OR videos.title COLLATE utf8mb4_general_ci LIKE '%:SEARCH%' OR videos.description COLLATE utf8mb4_general_ci LIKE '%:SEARCH%')".$WHEN.$TYPE.$LENGTH;
    $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
    $Videos->ORDER_BY   = $Order_By;
    $Videos->Execute    = [":SEARCH" => $Query];
    $Videos->LIMIT      = $_PAGINATION;
    $Videos->get();

    $Videos_Amount      = $Videos::$Amount;

    if ($Videos::$Videos) {
        $Videos = $Videos->fix_values(true, true);

        if ($Videos_Amount > 1) {
            $Related_Tags = [];

            foreach($Videos as $Video_Tags1) {
                foreach ($Video_Tags1["tags"] as $Value) {
                    $Related_Tags[] = $Value;
                }
            }
            shuffle($Related_Tags);
            $Related_Tags = array_splice($Related_Tags, -32);
        }
    }
    $Total_Amount = $_PAGINATION->Total;
}
elseif (isset($_GET["t"]) && $_GET["t"] == "Search Videos") {

    if (isset($_GET["uploaded"]) && $_GET["uploaded"] == "d") {
    $WHEN = " AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 24 HOUR) ";
    } elseif (isset($_GET["uploaded"]) && $_GET["uploaded"] == "w") {
        $WHEN = " AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 1 WEEK) ";
    } elseif (isset($_GET["uploaded"]) && $_GET["uploaded"] == "m") {
        $WHEN = " AND videos.uploaded_on > DATE_SUB(NOW(), INTERVAL 1 MONTH) ";
    } elseif (!isset($_GET["uploaded"])) {
        $WHEN = "";
    }

    if (isset($_GET["type"]) && $_GET["type"] == "hd") {
        $TYPE = " AND videos.hd = 1 ";
    } elseif (isset($_GET["type"]) && $_GET["type"] == "partner") {
        $TYPE = " AND users.is_partner = 1 ";
    } elseif (!isset($_GET["type"])) {
        $TYPE = "";
    }

    if (isset($_GET["length"]) && $_GET["length"] == "s") {
        $LENGTH = " AND videos.length <= 270 ";
    } elseif (isset($_GET["length"]) && $_GET["length"] == "l") {
        $LENGTH = " AND videos.length >= 780";
    }
    else {
        $LENGTH = "";
    }

    $Amount             = new Videos($DB, $_USER);
    $Amount->SELECT     = "count(url) as amount";
    $Amount->WHERE_C    = " AND (MATCH(tags) AGAINST (:SEARCH) COLLATE utf8mb4_general_ci OR videos.uploaded_by = :SEARCH COLLATE utf8mb4_general_ci OR videos.title COLLATE utf8mb4_general_ci LIKE '%:QUERY%' OR videos.description COLLATE utf8mb4_general_ci LIKE '%:QUERY%')".$WHEN.$TYPE.$LENGTH;
    $Amount->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
    $Amount->Execute    = [":SEARCH" => $Query];
    $Amount->get();
    $_PAGINATION->total($Amount::$Videos[0]["amount"]);

    if (!isset($_GET["order"])) {
        $Order_By = "((user_relevance * 1000) + (title_relevance * 100) 
                                        + (description * 50)
                                        + (tag_relevance * 10)
                                        + (tag_relevance_2 / 10)
                                        + (videos.views / 100) 
                                        + (videos.5stars / 50)
                                        - (videos.1stars))
                                        + (CASE WHEN user_relevance > 0 THEN (-DATEDIFF(NOW(), videos.uploaded_on) / 8) else 0 end) DESC";
    } elseif ($_GET["order"] == "date") {
        $Order_By = "videos.uploaded_on DESC";
    } elseif ($_GET["order"] == "name") {
        $Order_By = "videos.title ASC";
    } elseif ($_GET["order"] == "views") {
        $Order_By = "videos.views DESC";
    } elseif ($_GET["order"] == "rating") {
        $Order_By = "videos.5stars DESC";
    } else {
        header("location: /");
        exit();
    }
    $Videos             = new Videos($DB, $_USER);
    $Videos->SELECT     = "videos.*, (videos.uploaded_by = :SEARCH) as user_relevance, (title COLLATE utf8mb4_general_ci LIKE '%:SEARCH%') as title_relevance, videos.tags LIKE ('%:SEARCH%') as tag_relevance, (MATCH(tags) AGAINST (:SEARCH)) as tag_relevance_2, (videos.description COLLATE utf8mb4_general_ci LIKE '%:SEARCH%') as description_relevance";
    $Videos->WHERE_C    = " AND (MATCH(tags) AGAINST (:SEARCH) COLLATE utf8mb4_general_ci OR videos.uploaded_by = :SEARCH COLLATE utf8mb4_general_ci OR videos.title COLLATE utf8mb4_general_ci LIKE '%:SEARCH%' OR videos.description COLLATE utf8mb4_general_ci LIKE '%:SEARCH%')".$WHEN.$TYPE.$LENGTH;
    $Videos->JOIN    = "INNER JOIN users ON users.username = videos.uploaded_by";
    $Videos->ORDER_BY   = $Order_By;
    $Videos->Execute    = [":SEARCH" => $Query];
    $Videos->LIMIT      = $_PAGINATION;
    $Videos->get();

    $Videos_Amount      = $Videos::$Amount;

    if ($Videos::$Videos) {
        $Videos = $Videos->fix_values(true, true);

        if ($Videos_Amount > 1) {
            $Related_Tags = [];

            foreach($Videos as $Video_Tags1) {
                foreach ($Video_Tags1["tags"] as $Value) {
                    $Related_Tags[] = $Value;
                }
            }
            shuffle($Related_Tags);
            $Related_Tags = array_splice($Related_Tags, -32);
        }
    }
    $Total_Amount = $_PAGINATION->Total;
}
elseif ($_GET["t"] == "Search Users") {
    if (mb_strlen($Query) < 2) {
        notification("Requires at least 2 characters", "/");
        exit();
    }
    if (mb_strlen($Query) > 128) {
        header("location: /");
        exit();
    }

    $Search = str_replace('"', "", str_replace("'", "", str_replace("_", "", $Query)));

    if (!isset($_GET["order"])) {
        $Order_By = "";
    } elseif ($_GET["order"] == "views") {
        $Order_By = "ORDER BY video_views DESC";
    } elseif ($_GET["order"] == "subscribers") {
        $Order_By = "ORDER BY subscribers DESC";
    } else {
        header("location: /");
        exit();
    }

    $Users = $DB->execute("SELECT * FROM users WHERE (username LIKE :SEARCH OR displayname LIKE :SEARCH OR i_tags LIKE :SEARCH OR i_title LIKE :SEARCH) AND is_banned = 0 ".$Order_By." LIMIT $_PAGINATION->From, $_PAGINATION->To", false, [':SEARCH' => "%".$Search."%"]);

    $Amount = $DB->execute("SELECT count(username) as amount FROM users WHERE (username LIKE :SEARCH OR displayname LIKE :SEARCH OR i_tags LIKE :SEARCH OR i_title LIKE :SEARCH) AND is_banned = 0", true, [':SEARCH' => "%".$Search."%"])["amount"];

    $_PAGINATION->total($Amount);

} elseif ($_GET["t"] == "Search Playlists") {
    $Amount = $DB->execute("SELECT count(*) as amount FROM playlists WHERE title LIKE :TITLE or by_user LIKE :TITLE", true, [":TITLE" => "%".$Query."%"])["amount"];
    $_PAGINATION->total($DB->Row_Num);
    $Playlists = $DB->execute("SELECT * FROM playlists INNER JOIN users ON users.username = playlists.by_user LEFT JOIN users_block ON ((:USERNAME = users_block.blocker AND playlists.by_user = users_block.blocked) OR (:USERNAME = users_block.blocked AND playlists.by_user = users_block.blocker)) WHERE users.is_banned = 0 AND playlists.title LIKE :TITLE AND users_block.blocker IS NULL or playlists.by_user LIKE :TITLE AND users_block.blocker IS NULL ORDER BY submit_date DESC LIMIT $_PAGINATION->From, $_PAGINATION->To", false, [":USERNAME" => $_USER->Username, ":TITLE" => "%".$Query."%"]);
} else {
    header("location: /");
    exit();
}

if (!isset($_GET['p']) || isset($_GET["p"]) && $_GET['p'] == 1) {
    $Current_Page_Num = 1;
    $Last_Page_Num = 20;
}
else {
    $Current_Page_Num = ($_GET['p'] - 1) * 20;
    if ($Videos_Amount > 19) {
        $Last_Page_Num = ($_GET['p']) * 20;
    }
    else {
        $Last_Page_Num = ($_GET['p'] - 1) * 20 + $Videos_Amount; 
    }
}

$Referer = $_SERVER['HTTP_REFERER'] ?? '';
$parts = parse_url((string) $Referer);
if (isset($parts['query'])) {
    mb_parse_str($parts['query'], $query);
}

if (str_contains((string) $SearchQuery, "butt") || str_contains((string) $SearchQuery, "ELANTICRISTO2007") || str_contains(strtolower((string) $SearchQuery), "grand wizard") || str_contains(strtolower((string) $SearchQuery), "endstufe") || str_contains(strtolower((string) $SearchQuery), "christchurch") || str_contains(strtolower((string) $SearchQuery), "johnny rebel") || str_contains(strtolower((string) $SearchQuery), "rape") || str_contains(strtolower((string) $SearchQuery), "hitler") || str_contains(strtolower((string) $SearchQuery), "nazi") || str_contains(strtolower((string) $SearchQuery), "sex") || str_contains(strtolower((string) $SearchQuery), "cum") || str_contains(strtolower((string) $SearchQuery), "moonman") || str_contains(strtolower((string) $SearchQuery), "negro") || str_contains(strtolower((string) $SearchQuery), "nigger") || str_contains(strtolower((string) $SearchQuery), "nigga") || str_contains(strtolower((string) $SearchQuery), "faggot") || str_contains(strtolower((string) $SearchQuery), "fuck") || str_contains(strtolower((string) $SearchQuery), "shit") || str_contains(strtolower((string) $SearchQuery), "fag") || str_contains(strtolower((string) $SearchQuery), "tranny") || str_contains(strtolower((string) $SearchQuery), "kuz") || str_contains(strtolower((string) $SearchQuery), "nibba") || str_contains(strtolower((string) $SearchQuery), "nibber") || str_contains(strtolower((string) $SearchQuery), "whore") || str_contains(strtolower((string) $SearchQuery), "bitch") || str_contains(strtolower((string) $SearchQuery), "porn") || str_contains(strtolower((string) $SearchQuery), "gore") || str_contains(strtolower((string) $SearchQuery), "beaner") || str_contains(strtolower((string) $SearchQuery), "niggabyte") || str_contains(strtolower((string) $SearchQuery), "niggapotomous") || str_contains(strtolower((string) $SearchQuery), "niggerette") || str_contains(strtolower((string) $SearchQuery), "niggerachi") || str_contains(strtolower((string) $SearchQuery), "nigglet") || str_contains(strtolower((string) $SearchQuery), "ni**er") || str_contains(strtolower((string) $SearchQuery), "ni**a") || str_contains(strtolower((string) $SearchQuery), "niggas") || str_contains(strtolower((string) $SearchQuery), "niggers") || str_contains(strtolower((string) $SearchQuery), "niggerino")) {
      }
elseif ($_PAGINATION->Total > 0 && isset($query['search']) && $SearchQuery != $query['search'] && preg_match('/^[a-z0-9!?-_\']+$/i', (string) $SearchQuery) && !str_starts_with((string) $SearchQuery, ".")) {
    $DB->modify("INSERT IGNORE INTO search (query,clicks) VALUES (:QUERY,1) ON DUPLICATE KEY UPDATE clicks = clicks + 1",[":QUERY" => $SearchQuery]);
}

if ($_PAGINATION->Total <= 0) {
    $DB->modify("DELETE FROM search WHERE query = :QUERY",[":QUERY" => $SearchQuery]);
}

$_PAGE = [
    "Page"          => "results",
    "Page_Type"     => "home",
    "Title"      => str_replace("{s}",$Query,$LANGS['results'])
];
require "_templates/_structures/main.php";
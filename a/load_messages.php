<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
use function PHP81_BC\strftime;

function make_links_clickable($text)
{
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', (string) $text);
}

$_USER->get_info();

if (!$_USER->Logged_In) {
    header("location: /login");
    exit();
}

$_PAGINATION = new Pagination(20, 9999);

if (!isset($_GET["view"]) || $_GET["view"] == "inbox") {
    $Amount = $DB->execute(
        "SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME",
        true,
        [":USERNAME" => $_USER->Username]
    )["amount"];
} elseif ($_GET["view"] == "comments") {
    $Amount = $DB->execute(
        "SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND is_notification = 1 OR type = 2",
        true,
        [":USERNAME" => $_USER->Username]
    )["amount"];
}
elseif ($_GET["view"] == "shared") {
    $Amount = $DB->execute(
        "SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND type = 1",
        true,
        [":USERNAME" => $_USER->Username]
    )["amount"];
}
elseif ($_GET["view"] == "messages") {
    $Amount = $DB->execute(
        "SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND type = 0 AND is_notification IS NULL",
        true,
        [":USERNAME" => $_USER->Username]
    )["amount"];
}
elseif ($_GET["view"] == "responses") {
    $Amount = $DB->execute(
        "SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND type = 3",
        true,
        [":USERNAME" => $_USER->Username]
    )["amount"];
}
if ($_GET["view"] == "sent") {
    $Amount = $DB->execute(
        "SELECT count(id) as amount FROM users_messages WHERE by_user = :USERNAME",
        true,
        [":USERNAME" => $_USER->Username]
    )["amount"];
}

$_PAGINATION->total($Amount);

$_INBOX = new Inbox($_USER, $DB);

if (!isset($_GET["view"]) || $_GET["view"] == "inbox") {
    $Messages = $_INBOX->messages($_PAGINATION, 6);
} elseif ($_GET["view"] == "comments") {
    $Messages = $_INBOX->messages($_PAGINATION, 2);
}
elseif ($_GET["view"] == "shared") {
    $Messages = $_INBOX->messages($_PAGINATION, 1);
}
elseif ($_GET["view"] == "responses") {
    $Messages = $_INBOX->messages($_PAGINATION, 3);
}
elseif ($_GET["view"] == "messages") {
    $Messages = $_INBOX->messages($_PAGINATION, 0);
}
if ($_GET["view"] == "sent") {
    $Messages = $_INBOX->messages($_PAGINATION, 6, 1);
}

?>        
<div id="message-pane-loading" class="hid" style="height: 100%;width: 808px;position: absolute;background: #ffffff90;z-index: 44444;"><div align="center"><img src="/img/icn_loading_animated.gif" style="padding-top:150px;"></div></div>
                        <table id="table">
                                <thead>
                                    <tr id="headings">
                                        <td id="heading-check" class="first heading" width="2%"><div><input id="all-items-checkbox" type="checkbox" onclick="toggle(this)"></div></td>
                                        <td class="first heading" width="20%">
                                            <?php if ($_GET['view'] != "sent"): ?>
                                                <?= $LANGS['from'] ?>
                                            <?php else: ?>
                                                <?= $LANGS['to'] ?>
                                            <?php endif?>
                                        </td>
                                        <td class="first heading" width="50%">
                                            <?= $LANGS['subject'] ?>
                                        </td>
                                        <td id="heading-filter" class="heading" width="20%">
                                            <?= $LANGS['date'] ?>
                                        </td>
                                    </tr>
                                <tbody id="messages">
        <?php if ($Messages) : ?>
            <table cellpadding="5px" cellspacing="0" border="0" style="width:100%" id="messages_in">
                <tbody>
                <?php $Count = 0 ?>
                <?php foreach ($Messages as $Message) : ?>
                <?php 
                if ($Message["type"] == 0) {
                    if ($Message["subject"]) {
                        $MTitle = $Message["subject"];
                    }
                    else {
                        $MTitle = $Message["content"];
                    }
                    $Video = new Video($Message["attach_url"],$DB);
                }
                elseif ($Message["type"] == 1) {
                    $MTitle = $Message["subject"];
                }
                elseif ($Message["type"] == 2) {
                    if ($Message["subject"] != "Channel comment for ".$Message["for_user"] && $Message["subject"] != "Channel mention for ".$Message["for_user"]) {
                        $MTitle = $LANGS['msgcomment'].": &quot;".$Message["subject"]."&quot;";
                    }
                    elseif ($Message["subject"] == "Channel comment for ".$Message["for_user"]) {
                        $MTitle = $LANGS['msgchannelcomment'].": &quot;".$Message["content"]."&quot;";
                    }
                }
                elseif ($Message["type"] == 3) {
                    $MTitle = $LANGS['msgvideoresponse'].": &quot;".$Message["subject"]."&quot;";
                }
                elseif ($Message["type"] == 4) {
                    $MTitle = $LANGS['msgmention'].": &quot;".$Message["content"]."&quot;";
                }
                elseif ($Message["type"] == 5) {
                    $MTitle = str_replace("{channel}", $Message["subject"], $LANGS['msgmentionchannel']).": &quot;".$Message["content"]."&quot;";
                } ?>
                <?php $Count++ ?>
                <tr class="ms_sct<?php if ($Message['seen'] == 0) : ?> unread<?php endif ?>" id="ms-<?= $Message["id"] ?>" <?php if ($Count % 2-1) : ?>style="background:white;"<?php else : ?> style="background:#f0f0f0;" <?php endif ?>>
                    <td id="heading-check" class="first heading" width="2%">
                        <div><input id="chk-o-<?= $Message["id"] ?>" type="checkbox" onclick="check(<?= $Message["id"] ?>,this)"></div>
                    </td>
                    <td id="by_user" width="20%">
                        <?php if ($_GET['view'] != "sent"): ?>
                        <a href="/user/<?= $Message["by_user"] ?>"> <?= displayname($Message["by_user"]) ?></a>
                        <?php else: ?>
                        <a href="/user/<?= $Message["for_user"] ?>"> <?= displayname($Message["for_user"]) ?></a>
                        <?php endif ?>
                    </td>
                    <td width="50%" onclick="readMessage(<?= $Message["id"] ?>)">
                        <a href="javascript:void(0)" class="ms_sub"><?php if ($Message['type'] == 1): ?><img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Message["attach_url"].'.jpg')): ?>src="/u/thmp/<?= $Message["attach_url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> width=32 valign="middle"> <?php endif?><?= $MTitle ?></a>
                    </td>
                    <td align="left" width="20%" onclick="readMessage(<?= $Message["id"] ?>)">
                        <span>
                            <?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['shorttimeformat'], time_machine(strtotime((string) $Message["submit_on"]))); }
                    else {echo strftime($LANGS['shorttimeformat'], strtotime((string) $Message["submit_on"])); }  ?>
                </span>
                    </td>
                </tr>
                <tr class="in_message <?php if ($Message["seen"] == 0) : ?>noread<?php endif ?> hddn" id="i_<?= $Message["id"] ?>" <?php if ($Message["seen"] == 1) : ?>style="background:#fff!important;"<?php else : ?>style="background:#fff;"<?php endif ?>>
                    <?php
                        if ($_GET['view'] != "sent") {
                            $Avatar = avatar($Message["by_user"]);
                        }
                        else {
                            $Avatar = avatar($Message["for_user"]);
                        }
                    ?>
                    <td colspan="1" align="middle" valign="top" width="2%" style="padding: 5px 0;">
                        <div><input id="chk-i-<?= $Message["id"] ?>" type="checkbox" style="margin: 3px;" onclick="check(<?= $Message["id"] ?>,this)"></div>
                    <td colspan="1" align="left" style="padding: 8px 4px;" valign="top" width="20%">
                        <div class="avt" id="avt_<?= $Message['id'] ?>">
                        <?php if ($_GET['view'] != "sent"): ?>
                        <a href="/user/<?= $Message["by_user"] ?>"><img src="<?= $Avatar ?>" width="66" height="66" class="avatar" alt="<?= displayname($Message["by_user"]) ?>"></a><br>
                        <a href="/user/<?= $Message["by_user"] ?>"> <?= displayname($Message["by_user"]) ?></a>
                        <?php else: ?>
                        <a href="/user/<?= $Message["for_user"] ?>"><img src="<?= $Avatar ?>" width="66" height="66" class="avatar" alt="<?= displayname($Message["for_user"]) ?>"></a><br>
                        <a href="/user/<?= $Message["for_user"] ?>"> <?= displayname($Message["for_user"]) ?></a>
                        <?php endif ?>
                        </div>
                    </td>
                    <td colspan="1" valign="top" style="padding: 2px 4px">
                        <div title="<?= $MTitle ?>" style="line-height: 14px;padding: 6px 0;cursor:pointer;width: 360px;" onclick="readMessage(<?= $Message["id"] ?>)">
                            <?= $MTitle ?>
                        </div>
                        <div class="msg_in" id="msg_in_<?= $Message['id'] ?>">
                        <div>
                        <?= make_user_clickable(make_links_clickable(nl2br((string) $Message["content"]))) ?>
                        </div>
                        <?php if ($Message["attach_url"]): ?>
                        <div class="video-cell">
                            <?php
                            $Video = new Video($Message["attach_url"],$DB);

                            if ($Video->exists()) {
                            $Video->get_info();
                            } 
                            
                            $Video = $Video->Info;

                            ?>
                            <div class="video-entry">
                                <div class="v90WideEntry">
                                    <div class="v90WrapperOuter">
                                        <div class="v90WrapperInner">
                                            <a id="video-title-results" href="/watch?v=<?= $Video["url"] ?>" rel="nofollow">
                                                <img title="<?= mb_substr((string) $Video["title"],0,100) ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg90">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="video-main-content" id="video-main-content">
                                    <div class="video-title video-title-results">
                                        <div class="video-long-title">
                                            <a id="video-long-title" href="/watch?v=<?= $Video["url"] ?>" title="<?= mb_substr((string) $Video["title"],0,128) ?>" rel="nofollow"><?= mb_substr((string) $Video["title"],0,128) ?></a> <?php if ($Video['hd'] == 1): ?><a href="/watch?v=<?= $Video["url"] ?>"><img src="/img/pixel.gif" class="hd-video-logo"></a><?php endif ?>
                                        </div>
                                    </div>
                    
                                    <div id="video-description" class="video-description">
                                        <?php if($Video["description"]) : ?>
                    <?= short_title($Video["description"], 128) ?>
                    <?php else : ?><?= $LANGS['nodesc'] ?><?php endif ?>
                                    </div>
                                </div>
                                <div class="video-clear-list-left"></div>
                            </div>
                        </div>
                    <?php endif?>
                                        <div class="messages_reply_section">

                            <div class="irs_buttons">
<input type="submit" class="yt-uix-button" value="<?= $LANGS['reply'] ?>" onclick="location.href='/send_message?to=<?= $Message["by_user"] ?>&subj=Re:+<?= urlencode((string) $Message["subject"]) ?>'">
                                    <input type="submit" class="yt-uix-button" value="<?= $LANGS['delete'] ?>" onclick="location.href='/a/delete_pm_message?id=<?= $Message["id"] ?>'">
                            </div>
                        </div>
                        </div>

                    </td>
                    <td align="left" valign="top" style="padding: 8px 4px;line-height: 14px;" width="20%">
                        <span>
                            <?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['shorttimeformat'], time_machine(strtotime((string) $Message["submit_on"]))); }
                    else {echo strftime($LANGS['shorttimeformat'], strtotime((string) $Message["submit_on"])); }  ?>
                </span>
                    </td>
                </tr>
                    <?php if ($Count == 2) : ?><?php $Count = 0 ?><?php endif ?>
                <?php endforeach ?>

                </tbody></table>
        <?php else : ?>
        <table cellpadding="5px" cellspacing="0" border="0" style="width:100%" id="messages_in">
                <tbody>
                <div style="padding:60px 10px;font-size:16px;text-align:center; background: white;color:#666;font-weight: bold;"><?= $LANGS['nomsg'] ?></div>
        </tbody></table>
        <?php endif ?>

        <?php if ($Messages) : ?>
        <?php endif ?>
    <div class="footer">
    <?php $_SERVER["SCRIPT_FILENAME"] = "inbox"; ?>
    <?php $_PAGINATION->new_show_pages_videos("#". $_GET['view'],true,true); ?>
    </div>
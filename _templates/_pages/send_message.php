<link href="/css/messages.css?20" rel="stylesheet" type="text/css" />
<style type="text/css">
.profileModifiers {
    padding: 5px 0px;
    border-bottom: 1px solid #ccc;
    text-align: center;
}
.profileModifiers div.first {
    border-left: 0px;
    padding: 0px 10px 0px 2px;
}
.profileModifiers div.subcategory {
    border-left: 1px solid #ccc;
    padding: 0px 10px;
    font-size: 11px;
    display: inline;
}
.profileModifiers .selected {
    font-weight: bold;
}
#list-pane a {
    color: #333;
    font-weight: normal;
}
#list-pane a.channel-subfolder {
    padding: 4px 20px;
    font-weight: normal;
}
</style>

<div class="container-div">
    <div id="vm-title"><?= $LANGS['messagesmenu'] ?></div>
    <table cellspacing="0" cellpadding="0" border="0">
        <tbody>
        <tr>
            <td id="folderlinks-cell" valign="top">
                
                <?php $Messages_Amount = $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND seen = 0", true, [":USERNAME" => $_USER->Username])["amount"] ?>
        <?php $Notifications_Amount = $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND (is_notification = 1 or type = 2 or type = 4 or type = 5) AND seen = 0",true,[":USERNAME" => $_USER->Username])["amount"];
        $PM_Amount = $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND type = 0 AND seen = 0",true,[":USERNAME" => $_USER->Username])["amount"];
        $Sh_Amount = $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND type = 1 AND seen = 0",true,[":USERNAME" => $_USER->Username])["amount"];
        $Res_Amount = $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND type = 3 AND seen = 0",true,[":USERNAME" => $_USER->Username])["amount"];
        $Invites = (int)$DB->execute("SELECT count(id) as total FROM users_friends WHERE friend_2 = :USERNAME AND status = 0", true, [":USERNAME" => $_USER->Username])["total"]; ?>
                <div id="vm-layout-left">
                    <ol class="vm-vertical-nav">
                        <li><button type="button" id="inbox_compose_button" onclick="window.location.href='/send_message'" class=" yt-uix-button" style="margin: 10px;margin-top: 0;"><?= $LANGS['compose'] ?></button></li>
                        <li><a class="" href="/inbox"><span <?php if ($Messages_Amount > 0): ?> style="font-weight: bold;" <?php endif ?>><?= $LANGS['inbox'] ?></span><?php if ($Messages_Amount > 0): ?> (<?= $Messages_Amount ?>)<?php endif ?></a></li>
                        <li><a class="" href="/inbox?v=p"><span <?php if ($PM_Amount > 0): ?> style="font-weight: bold;" <?php endif ?>><?= $LANGS['personalmessages'] ?></span><?php if ($PM_Amount > 0): ?> (<?= $PM_Amount ?>)<?php endif ?></a></li>
                        <li><a class="" href="/inbox?v=s"><span <?php if ($Sh_Amount > 0): ?> style="font-weight: bold;" <?php endif ?>><?= $LANGS['sharedwithyouinbox'] ?></span><?php if ($Sh_Amount > 0): ?> (<?= $Sh_Amount ?>)<?php endif ?></a></li>
                        <li><a class="" href="/inbox?v=c"><span <?php if ($Notifications_Amount > 0): ?> style="font-weight: bold;" <?php endif ?>><?= $LANGS['msgcom'] ?></span><?php if ($Notifications_Amount > 0): ?> (<?= $Notifications_Amount ?>)<?php endif ?></a></li>
                        <li><a class="" href="/address_book?v=fi"><span <?php if ($Invites > 0): ?> style="font-weight: bold;" <?php endif ?>><?= $LANGS['friendinvitesinbox'] ?></span><?php if ($Invites > 0): ?> (<?= $Invites ?>)<?php endif ?></a></li>
                        <li><a class="" href="/inbox?v=r"><span <?php if ($Res_Amount > 0): ?> style="font-weight: bold;" <?php endif ?>><?= $LANGS['videoresponsesinbox'] ?></span><?php if ($Res_Amount > 0): ?> (<?= $Res_Amount ?>)<?php endif ?></a></li>
                        <li><a class="" href="/inbox?by_user=1"><?= $LANGS['sent'] ?></a></li>
                        <li><a class="" href="/address_book" style="text-align: center; margin: 10px 0; padding: 5px 0"><?= $LANGS['addressbook'] ?> »</a></li>
                    </ol>
                </div>
            </td>
            <td id="compose-cell" valign="top" colspan="2" height="100%">
                <div id="message_reading">
                    <div id="vm-page-subheader">
                        <h3><?= $LANGS['compose'] ?></h3>
                    </div>
                    <div id="message-pane" style="padding: 10px;">
                       <table id="table">
<form action="/send_message" method="post" autocomplete="off">
    <table width="640px" border="0" cellpadding="5" cellspacing="0" style="margin:0 auto">
        <tr><td align="right"><span><?= $LANGS['from'] ?>:</span></td>
            <td><span style="color:#666"><a href="/user/<?= ($_USER->Username) ?>" style="color: #666;"><?= displayname($_USER->Username) ?></a></span></td></tr>
        <tr>
            <td align="right"><span><?= $LANGS['to'] ?>:</span></td>
            <td><input type="text" name="to_user" maxlength="20" style="width:100%"<?php if (isset($_GET["to"]) && !empty($_GET["to"]) && mb_strlen((string) $_GET["to"]) <= 20) : ?> value="<?= $_GET["to"] ?>"<?php endif ?> /></td>
        </tr>
        <tr>
            <td align="right"><span><?= $LANGS['subject'] ?>:</span></td>
            <td><input type="text" name="subject" maxlength="200" style="width:100%"<?php if (isset($_GET["subj"]) && !empty($_GET["subj"])) : ?> value="<?= $_GET["subj"] ?>"<?php endif ?> /></td>
        </tr>
        <tr>
            <td align="right" valign="top"><span><?= $LANGS['messagecont'] ?>:</span></td>
            <td><textarea name="message" maxlength="500" style="width:100%;overflow:hidden;resize:vertical" rows="4"></textarea></td>
        </tr>
        <tr>
            <td align="right"><span><?= $LANGS['attachvideo'] ?>:</span></td>
            <td><input type="text" name="attach_video" maxlength="200" style="width:100%"<?php if (isset($_GET["attach_video"]) && !empty($_GET["attach_video"]) && mb_strlen((string) $_GET["attach_video"]) <= 20) : ?> value="<?= $_GET["attach_video"] ?>"<?php endif ?> /></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" class="yt-uix-button" name="send_message" value="<?= $LANGS['sendmessagebutton'] ?>"> <button onclick="location.href='/inbox'" type="button" class="yt-uix-button"><?= $LANGS['cancel'] ?></button></td>
        </tr>
    </table>
                    </div>
                </div>
            </td>
        </tr>
    </tbody></table>
</div>
</div>
</div>
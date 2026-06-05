<div style="margin:0 0 13px;text-align:center;word-spacing: 8px">
    <b><?= $LANGS['friends'] ?></b> | <a href="/my_friends_invite"><?= $LANGS['invites'] ?></a>
</div>
<div>
    <div class="videos_box" style="width:100%;background:#eaf0fa!important">
        <div class="videos_box_conainer">
            <div class="videos_box_head">
                <div style="float:left">
                    <?= $LANGS['myfriends'] ?>
                </div>
            </div>
            <div class="videos_box_in" style="padding:0<?php if ($Friends) : ?>;border-bottom:0<?php endif ?>">
                <?php if ($Friends) : ?>
                <style>
                    .videos_box_in table td {
                        border-bottom: 1px solid #eee;
                    }
                </style>
                    <table cellpadding="5" cellspacing="0" width="100%">
                        <?php foreach ($Friends as $Friend) : ?>
                            <?php
                            if ($Friend["friend_1"] !== $_USER->Username) { $Friend_Name = $Friend["friend_1"]; }
                            else                                          { $Friend_Name = $Friend["friend_2"]; }
                            ?>
                            <tr style="font-size: 14px">
                                <td align="left" width="15%"><a href="/user/<?= $Friend_Name ?>"><?= displayname($Friend_Name) ?></a></td>
                                <td align="left" width="40%">
                                    <a href="/user/<?= $Friend["username"] ?>&page=videos"><img src="/img/icon_vid.gif" style="vertical-align:text-bottom"></a> (<a href="/user/<?= $Friend["username"] ?>&page=videos"><?= $Friend["videos"] ?></a>) <div style="display:inline-block;display:inline;margin:0 3px">|</div> <a href="/user/<?= $Friend["username"] ?>&page=favorites"><img src="/img/icon_fav.gif" style="vertical-align:text-bottom"></a> (<a href="/user/<?= $Friend["username"] ?>&page=favorites"><?= $Friend["favorites"] ?></a>) <div style="display:inline-block;display:inline;margin:0 3px">|</div> <a href="/user/<?= $Friend["username"] ?>&page=friends"> <img src="/img/icon_friends.gif" style="vertical-align:text-bottom"></a> (<a href="/user/<?= $Friend["username"] ?>&page=friends"><?= $Friend["friends"] ?></a>)
                                </td>
                                <td align="right" width="20%"><a href="/send_message?to=<?= $Friend_Name ?>"><?= $LANGS['sendmessagebutton'] ?></a> | <a href="/my_friends?remove=<?= $Friend_Name ?>"><?= $LANGS['delete'] ?></a></td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                <?php else : ?>
                    <div style="font-size:13px;color:#444;text-align:center;padding:17px 0 16px"><?= $LANGS['nofriends'] ?></div>
                <?php endif ?>
            </div>
            <?php if ($Friends) : ?>
                <div style="text-align:right;font-size:13px;color:#444;font-weight:bold;padding:5px 0"><?php $_PAGINATION->show_pages() ?></div>
            <?php endif ?>
        </div>
    </div>
</div>
<div class="clear"></div>
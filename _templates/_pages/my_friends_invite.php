<?php use function PHP81_BC\strftime; ?>
<div style="margin:0 0 13px;text-align:center;word-spacing: 8px">
    <a href="/my_friends"><?= $LANGS['friends'] ?></a> | <b><?= $LANGS['invites'] ?></b>
</div>
<div style="width:48%;float:left;margin-right:4%">
    <div class="videos_box" style="width:100%;background:#eaf0fa!important">
        <div class="videos_box_conainer">
            <div class="videos_box_head">
                <div style="float:left">
                    <?= $LANGS['myinvites'] ?>
                </div>
            </div>
            <div class="videos_box_in" style="padding:0<?php if ($My_Invites) : ?>;border-bottom:0<?php endif ?>">
                <?php if ($My_Invites) : ?>
                    <table cellpadding="3" cellspacing="0" width="100%">
                        <tr>
                            <td><b><?= $LANGS['to'] ?></b></td>
                            <td><b><?= $LANGS['date'] ?></b></td>
                            <td align="middle" style="width:20%"><b><?= $LANGS['actions'] ?></b></td>
                        </tr>
                        <?php foreach ($My_Invites as $Invite) : ?>
                            <tr>
                                <td align="left" width="20%"><a href="/user/<?= $Invite["friend_2"] ?>"><?= displayname($Invite["friend_2"])?></a></td>
                                <td align="left" width="65%">
                                    <?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['timehourformat'], time_machine(strtotime((string) $Invite["submit_on"]))); }
                    else {echo strftime($LANGS['timehourformat'], strtotime((string) $Invite["submit_on"])); }  ?>
                                    </td>
                                <td align="middle" width="5%"><a href="/my_friends_invite?retract=<?= $Invite["id"] ?>"><?= $LANGS['retract'] ?></a></td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                <?php else : ?>
                    <div style="font-size:13px;color:#444;text-align:center;padding:17px 0 16px"><?= $LANGS['noinvites'] ?></div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<div style="width:48%;float:left;">
    <div class="videos_box" style="width:100%;background:#eaf0fa!important">
        <div class="videos_box_conainer">
            <div class="videos_box_head">
                <div style="float:left">
                    <?= $LANGS['incominginvites'] ?>
                </div>
            </div>
            <div class="videos_box_in" style="padding:0<?php if ($Other_Invites) : ?>;border-bottom:0<?php endif ?>">
                <?php if ($Other_Invites) : ?>
                    <table cellpadding="3" cellspacing="0" width="100%">
                        <tr>
                            <td><b><?= $LANGS['from'] ?></b></td>
                            <td><b><?= $LANGS['date'] ?></b></td>
                            <td style="width:20%"><b><?= $LANGS['actions'] ?></b></td>
                        </tr>
                        <?php foreach ($Other_Invites as $Invite) : ?>
                            <tr>
                                <td align="left" width="27%"><a href="/user/<?= $Invite["friend_1"] ?>"><?=displayname($Invite["friend_1"]) ?></a></td>
                                <td align="left" width="50%"><?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['timehourformat'], time_machine(strtotime((string) $Invite["submit_on"]))); }
                    else {echo strftime($LANGS['timehourformat'], strtotime((string) $Invite["submit_on"])); }  ?></td>
                                <td align="left" width="23%"><a href="/my_friends_invite?accept=<?= $Invite["id"] ?>"><?= $LANGS['accept'] ?></a> | <a href="/my_friends_invite?retract=<?= $Invite["id"] ?>"><?= $LANGS['decline'] ?></a></td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                <?php else : ?>
                    <div style="font-size:13px;color:#444;text-align:center;padding:17px 0 16px"><?= $LANGS['noinvites'] ?></div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>

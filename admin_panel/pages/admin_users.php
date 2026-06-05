<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
use function PHP81_BC\strftime;
if (!$_USER->Logged_In || (!$_USER->Is_Moderator && !$_USER->Is_Admin)) {
    header("location: /");
    exit();
}
?>
<?php if (!isset($_GET["ue"])) : ?>
    <script>
        function adminUserSearch() {
            var search_term = document.getElementById('search_Term').value;
            var amount = document.getElementById('search_Amount').value;
            var type = document.getElementById('search_Type').value;
            document.getElementById('users-table').style.opacity = 0.25;
            $.ajax({
                url: "/admin_panel/a/searchUser.php?query="+ search_term +"&type="+ type +"&amount=" + amount,
                success: function(html){
                    if(html){
                        document.getElementById('users-table').style.opacity = 1;
                        document.getElementById('users-table').outerHTML = html;
                    } else {
                        alert('Something went wrong!')
                    }
                }
            });
        }
        function adminChangeOrder(order_by,e) {
            var search_term = document.getElementById('search_Term').value;
            var amount = document.getElementById('search_Amount').value;
            var type = document.getElementById('search_Type').value;
            var order = 0;
            if (e.innerHTML == "&harr;" || e.innerHTML == "↔") {
                e.innerHTML = "&uarr;";
                order = 1;
            }
            else if (e.innerHTML == "&uarr;" || e.innerHTML == "↑") {
                e.innerHTML = "&darr;";
                order = 2;
            }
            else {
                e.innerHTML = "&harr;";
                order = 0;
            }
            document.getElementById('users-table').style.opacity = 0.25;
            $.ajax({
                url: "/admin_panel/a/changeOrder.php?order_by="+ order_by +"&order="+ order +"&query="+ search_term +"&type="+ type +"&amount=" + amount,
                success: function(html){
                    if(html){
                        document.getElementById('users-table').style.opacity = 1;
                        document.getElementById('users-table').outerHTML = html;
                    } else {
                        alert('Something went wrong!')
                    }
                }
            });
        }
    </script>
    <div style="float:left;width:100%;margin-right:1%">
        <div class="a_box" style="margin-bottom: 6px;">
            <div class="a_box_title">
            <div>
                <?php if (!isset($_GET["search"]) && !isset($_GET["vi"]) && !isset($_GET["us"]) && !isset($_GET["su"]) && !isset($_GET["fr"]) && !isset($_GET["re"])) : ?>Newest Users<?php else : ?>Users<?php endif ?>
                <form action="/admin_panel" method="GET" id="num_change" style="position:relative;left:3px;display:inline-block">
                    <input type="hidden" name="page" value="users">
                    <?php if (isset($_GET["search"])) : ?><input type="hidden" name="search" value="<?= $_GET["search"] ?>"><?php endif ?>
                    <select name="amount" id="search_Amount" style="border: 1px solid #999;" onchange="adminUserSearch();">
                        <option value="16"<?php if (isset($_GET["amount"]) && $_GET["amount"] == 16) : ?> selected<?php endif ?>>16</option>
                        <option value="32"<?php if (isset($_GET["amount"]) && $_GET["amount"] == 32) : ?> selected<?php endif ?>>32</option>
                        <option value="64"<?php if (isset($_GET["amount"]) && $_GET["amount"] == 64) : ?> selected<?php endif ?>>64</option>
                        <option value="128"<?php if (isset($_GET["amount"]) && $_GET["amount"] == 128) : ?> selected<?php endif ?>>128</option>
                        <option value="256"<?php if (isset($_GET["amount"]) && $_GET["amount"] == 256) : ?> selected<?php endif ?>>256</option>
                    </select>
                </form>
            </div>
                <div style="position: absolute;right: 5px;top: 5px;">
                    <input type="hidden" name="page" value="users">
                        <?php if (isset($_GET["amount"])) : ?><input type="hidden" name="amount" value="<?= (int)$_GET["amount"] ?>"><?php endif ?>
                    <input type="text" id="search_Term" maxlength="100" onkeyup="if (event.keyCode === 13) { document.getElementById('search_Submit').click();}" name="search"<?php if (isset($_GET["search"])) : ?> value="<?= $_GET["search"] ?>"<?php endif ?> style="border:1px solid #999;height: 17.5px; width: 200px;">
                    <select name="type" id="search_Type" style="border: 1px solid #999;height: 21px;font-size: 12px;">
                        <option value="1" selected>Username</option>
                        <option value="2">Email</option>
                    </select>
                    <input class="yt-button" style="font-size: 12px;padding: 0.2333em 0.8333em;" type="submit" id="search_Submit" value="Search" onclick="adminUserSearch();">
                </div>
            </div>
            <div style="clear:both"></div>
            <div style="max-height:500px;overflow-y:auto;border-radius: 0 0 5px 5px;">
                <table width="100%" class="atable" id="users-table" style="opacity: 1">
                    <tr>
                        <td align="center">Username <a href="#" onclick="adminChangeOrder('username',this);return false;">&harr;</a></td>
                        <td align="center">Videos <a href="#" onclick="adminChangeOrder('videos',this);return false;">&harr;</td>
                        <td align="center">Subscribers <a href="#" onclick="adminChangeOrder('subscribers',this);return false;">&harr;</td>
                        <td align="center">Friends <a href="#" onclick="adminChangeOrder('friends',this);return false;">&harr;</td>
                        <td align="center">Register Date <a href="#" onclick="adminChangeOrder('registration_date',this);return false;">&harr;</td>
                        <td align="center">Actions</td>
                    </tr>
                    <?php foreach ($Latest_Users as $User) : ?>
                        <?php if ($User["ip_address"] != "") {
                                $Other_Unbanned_Channels_List = $DB->execute("SELECT * FROM users WHERE ip_address = :IP AND username <> :USERNAME AND is_banned = 0",false,
                                    [":USERNAME" => $User["username"], ":IP" => $User["ip_address"]]);
                                $Other_Banned_Channels_List = $DB->execute("SELECT * FROM users WHERE ip_address = :IP AND username <> :USERNAME AND is_banned = 1",false,
                                    [":USERNAME" => $User["username"], ":IP" => $User["ip_address"]]);
                                $Other_Channels_List = $DB->execute("SELECT * FROM users WHERE ip_address = :IP AND username <> :USERNAME AND is_banned = 0",false,
                                    [":USERNAME" => $User["username"], ":IP" => $User["ip_address"]]);
                                if ($DB->Row_Num == 0) {
                                    $Other_Channels_List = false;
                                    $Other_Unbanned_Channels_List = false;
                                    $Other_Banned_Channels_List = false;
                                }
                            } else {
                                $Other_Channels_List = false;
                                $Other_Unbanned_Channels_List = false;
                                $Other_Banned_Channels_List = false;
                            } ?>
                        <tr 
                        <?php if ($User["is_banned"] && $Other_Unbanned_Channels_List) : ?>style="background-color: #ff9696;"<?php endif ?>
                        <?php if ($User["is_banned"]) : ?>style="background-color: #ffcccc;"<?php endif ?>
                        <?php if ($User["is_moderator"] || $User["is_admin"]) : ?>style="background-color: #e2f0ff;"<?php endif ?>
                        <?php if ($User["is_partner"]) : ?>style="background-color: #e2ffcc;"<?php endif ?>
                        <?php if (!$User["is_banned"] && $Other_Banned_Channels_List) : ?>style="background-color: #ffc848;"<?php endif ?>
                        <?php if ($User["is_reuploader"]) : ?>style="background-color: #ffe2cc;"<?php endif ?>
                        <?php if ($Other_Channels_List) : ?>style="background-color: #fffdcc;"<?php endif ?>>
                            <td><a href="/user/<?= $User["username"] ?>"><?= $User["username"] ?></a></td>
                            <td align="center"><?= $User["videos"] + $User["private_videos"] ?></td>
                            <td align="center"><?= $User["subscribers"] ?></td>
                            <td align="center"><?= $User["friends"] ?></td>
                            <td align="center"><?= date("M d, Y", strtotime((string) $User["registration_date"])) ?></td>
                            <td align="center"><a class="yt-button" href="/admin_panel/?page=users&ue=<?= $User["username"] ?>">Edit</a>
                                <form action="/admin_panel/?page=users" method="post" style="display: inline-block;" value="Herotrap">
                                <?php if ($User["is_banned"] == 0 && !$User["is_admin"] && !$User["is_moderator"]) : ?>
        <button name="ban_user_list" value="<?= $User["username"] ?>" style="font-size:12px" class="yt-button" onclick="if (!confirm('Are you sure you want to ban this user?')) { return false }">Ban</button>
    <?php elseif (!$User["is_admin"] && !$User["is_moderator"]) : ?>
        <button name="ban_user_list" value="<?= $User["username"] ?>" style="font-size:12px" class="yt-button" onclick="if (!confirm('Are you sure you want to unban this user?')) { return false }">Unban</button>
    <?php endif ?></form></td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>
        </div>
    </div>
    <div style="margin-bottom:10px"><b>Legend:</b>
    <span style="margin-left: 10px;"><span style="width: 10px;height: 10px;display: inline-block;background: #ff9696;position: relative;top: 0.5px;"></span> Banned User with Other (Unbanned) Accounts</span>
    <span style="margin-left: 10px;"><span style="width: 10px;height: 10px;display: inline-block;background: #ffc848;position: relative;top: 0.5px;"></span> Has Other (Banned) Accounts</span>
    <span style="margin-left: 10px;"><span style="width: 10px;height: 10px;display: inline-block;background: #ffcccc;position: relative;top: 0.5px;"></span> Banned User</span>
    <span style="margin-left: 10px;"><span style="width: 10px;height: 10px;display: inline-block;background: #ffe2cc;position: relative;top: 0.5px;"></span> Reuploader</span>
    <br>
    <span style="margin-left: 10px;"><span style="width: 10px;height: 10px;display: inline-block;background: #fffdcc;position: relative;top: 0.5px;"></span> Has Other (Unbanned) Accounts</span>
    <span style="margin-left: 10px;"><span style="width: 10px;height: 10px;display: inline-block;background: #e2ffcc;position: relative;top: 0.5px;"></span> Partner</span>
    <span style="margin-left: 10px;"><span style="width: 10px;height: 10px;display: inline-block;background: #e2f0ff;position: relative;top: 0.5px;"></span> Moderator / Admin</span>
</div>
<div class="a_box">
        <div class="a_box_title">User Reports</div>
        <div style="max-height:500px;overflow-y:auto">
            <?php if ($Reports): ?>
            <table width="100%" class="atable">
                 <tr>
                    <td align="center">Reported User</b></td>
                    <td align="center">Reason</b></td>
                    <td align="center">Date</b></td>
                    <td align="center">Actions</b></td>
                </tr>
                <?php foreach ($Reports as $Report) : ?>
                <?php $User = $DB->execute("SELECT * FROM users WHERE username = :USERNAME",true,[":USERNAME" => $Report["username"]]); ?>
                <tr>
                    <td width="40"><a href="/user/<?= $Report["username"] ?>"><?= $Report["username"] ?></a></td>
                    <td><?php if($Report["reason"] == 1) : ?>Inappropriate avatar/background <?php else : ?>Breaking Community Guidelines<?php endif ?>  </td>
                    <td align="center"><?= date("M d, Y", strtotime((string) $Report["submit_date"])) ?></td>
                    <td align="center"><a class="yt-button" href="/admin_panel/?page=users&ue=<?= $User["username"] ?>">Edit</a>
                                <form action="/admin_panel/?page=users" method="post" style="display: inline-block;" value="Herotrap">
                                <?php if ($User["is_banned"] == 0 && !$User["is_admin"] && !$User["is_moderator"]) : ?>
        <button name="ban_user_list" value="<?= $User["username"] ?>" style="font-size:12px" class="yt-button" onclick="if (!confirm('Are you sure you want to ban this user?')) { return false }">Ban</button>
    <?php elseif (!$User["is_admin"] && !$User["is_moderator"]) : ?>
        <button name="ban_user_list" value="<?= $User["username"] ?>" style="font-size:12px" class="yt-button" onclick="if (!confirm('Are you sure you want to unban this user?')) { return false }">Unban</button>
    <?php endif ?></form><a style="font-size:12px" class="yt-button" href="/admin_panel/?page=users&resolve=<?= $Report["username"] ?>">Mark as Resolved</a></td>
                </tr>
                <?php endforeach ?>
            </table>
        <?php else: ?>
            <div style="padding: 10px; text-align: center; font-weight: bold">No User Reports!</div>
        <?php endif ?>
        </div>
    </div>
<div style="float:left;width:50%">
    <div class="a_box">
        <div class="a_box_title">Partner Applications</div>
        <div style="max-height:500px;overflow-y:auto;">
            <?php if ($Applications) : ?>
            <table width="100%" class="atable">
                 <tr>
                    <td align="center">User</td>
                    <td align="center">Date</td>
                    <td align="center">Actions</td>
                </tr>
                <?php foreach ($Applications as $Application) : ?>
                <?php if ($Application["is_partner"] == 0): ?>
                <tr>
                    <td width="80"><a href="/user/<?= $Application["username"] ?>"><?= $Application["username"] ?></a></td>
                    <td align="center"><?= date("M d, Y", strtotime((string) $Application["submit_date"])) ?></td>
                    <td align="center"><a style="font-size:12px" class="yt-button" href="/admin_panel/?page=users&accept=<?= $Application["username"] ?>">Accept</a> <a style="font-size:12px" class="yt-button" href="/admin_panel/?page=users&decline=<?= $Application["username"] ?>">Decline</a></td>
                </tr>
            <?php endif ?>
                <?php endforeach ?>
            </table>
            <?php else: ?>
                <div style="padding: 10px; text-align: center; font-weight: bold">No Partner Applications!</div>
            <?php endif?>
        </div>
    </div>
</div>
<div style="float:right;width:49%;margin-left:1%">
    <div class="a_box">
        <div class="a_box_title">Edit User</div>
        <div style="padding:16px; text-align: center;">
            <form action="/admin_panel/" method="get">
                <input type="hidden" name="page" value="users" />
                <input type="text" placeholder="Username" name="ue" style="width:180px;border:1px solid #999;height: 17.5px;" maxlength="11" />
                <button type="submit" class="yt-button" style="font-size: 12px;padding: 0.2333em 0.8333em;">Edit User</button>
            </form>
        </div>
    </div>
</div>
<div style="clear:both"></div>
<?php else : ?>
<div style="width:100%;padding-bottom:8px;margin-bottom:10px;border-bottom:1px solid #ccc;font-size:16px;font-weight:normal;overflow:hidden">
    <div style="float:left"><a style="font-weight: bold;" href="/user/<?= $_MEMBER->Info["username"] ?>"><?= $_MEMBER->Info["username"] ?></a> <a style="font-size:12px" href="/admin_panel/user_comments?ue=<?= $_MEMBER->Info["username"] ?>">(check user's comments)</a></div>
</div>
<div>
</div>
<form action="/admin_panel/?page=users&ue=<?= $_MEMBER->Info["username"] ?>" method="post">
<div style="margin-bottom: 12px;">
        <div style="font-size: 0; text-align: center" id="user-actions-admin">
        <input type="submit" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin:0;" name="change_password" value="Reset Password" onclick="if (!confirm('Are you sure you want to change this users password? You will need to give the user the new password so that he can log in again!')) { return false; } ">
        <?php if ($_MEMBER->Info["is_verified"] == 0): ?>
        <input type="submit" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin: 0;" name="verify" value="Verify">
        <?php endif ?>
    <?php if ($_MEMBER->Info["is_banned"] == 0 && !$_MEMBER->Is_Admin && !$_MEMBER->Is_Moderator) : ?>
        <input type="submit" name="ban_user" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin: 0;" value="Ban" onclick="if (!confirm('Are you sure you want to ban this user?')) { return false }">
    <?php elseif (!$_MEMBER->Is_Admin && !$_MEMBER->Is_Moderator) : ?>
        <input type="submit" name="ban_user" value="Unban" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin: 0;" onclick="if (!confirm('Are you sure you want to unban this user?')) { return false }">
    <?php endif ?>
    <?php if ($_MEMBER->Info["is_banned"] == 0 && !$_MEMBER->Is_Admin && !$_MEMBER->Is_Moderator) : ?>
        <input type="submit" name="ban_all_user_channels" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin: 0;" value="Ban All Accounts" onclick="if (!confirm('Are you sure you want to ban ALL this users channels?')) { return false }">
    <?php endif ?>
    <input type="submit" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin: 0;" name="delete_activity" value="Delete Activity" onclick="if (!confirm('This deletes all comments/messages this user sent, are you sure you want to delete it all?')) { return false; } ">
    <?php if ($_USER->Is_Admin && !$_MEMBER->Is_Admin) : ?>
        <?php if (!$_MEMBER->Is_Moderator) : ?>
            <input type="submit" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin: 0;" name="add_moderator" value="Make Moderator" onclick="if (!confirm('Are you sure you want to make this user a moderator?')) { return false }">
        <?php else : ?>
            <input type="submit" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin: 0;" name="add_moderator" value="Remove Moderator" onclick="if (!confirm('Are you sure you want to remove this users moderator status?')) { return false }">
        <?php endif ?>
    <?php endif ?>
    <?php if (!$_MEMBER->Info["is_partner"]) : ?>
            <input type="submit" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin: 0;" name="add_partner" value="Make Partner" onclick="if (!confirm('Are you sure you want to make this user a partner?')) { return false }">
        <?php else : ?>
            <input type="submit" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin: 0;" name="add_partner" value="Remove Partner" onclick="if (!confirm('Are you sure you want to remove this users partner status?')) { return false }">
        <?php endif ?>
    <?php if (!$_MEMBER->Info["is_reuploader"]) : ?>
        <input type="submit" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin: 0;" name="add_reuploader" value="Mark as Reuploader" onclick="if (!confirm('Are you sure you want to make this user a reuploader?')) { return false }">
    <?php else : ?>
        <input type="submit" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin: 0;" name="add_reuploader" value="Unmark as Reuploader" onclick="if (!confirm('Are you sure you want to remove this users reuploader status?')) { return false }">
    <?php endif ?>
</div>
</div>
</form>
<div class="a_box">
        <div class="a_box_title">User Notes</div>
        <form action="/admin_panel/?page=users&ue=<?= $_MEMBER->Info["username"] ?>" method="post">
        <div style="text-align: left;">
                <table width="100%" border="0" cellpadding="5" cellspacing="0" style="margin:0 auto">
            <tbody>
            <tr>
                <td align="left" colspan="2">If you ban a user, please specify why you did so. You can also use this note area to write important notes on a user.</td>
            </tr>
            <tr>
                <td align="left" width="70%"><textarea style="width: 100%;height: 120px;" type="text" maxlength="1000" name="note"><?= $Notes['content'] ?? '' ?></textarea></td>
                <td align="left" valign="top"><input type="submit" class="yt-button yt-uix-button-primary" style="padding: 0.3888em 0.8333em;font-size: 12px;margin: 6px;margin:0;margin-bottom: 4px;" name="save_note" value="Save Note"><?php if (isset($Notes['by_user'])): ?><br><span style="color: #666;font-size: 11px;">Last updated by <a href="/admin_panel/?page=users&ue=<?= $Notes['by_user'] ?>"><?= $Notes['by_user'] ?></a></span><?php endif ?></td>
            </tr>
        </tbody></table>
        </div>
        </form>
    </div>
<div style="float:left;width:49%;margin-right:1%">
    <div class="a_box">
        <div class="a_box_title">User Information</div>
        <div style="text-align: left;">
                <table width="100%" border="0" cellpadding="5" cellspacing="0" style="margin:0 auto">
            <tr>
                <td align="left"><span style="font-weight:bold">Display Name:</span></td>
                <td><?= $_MEMBER->Info["displayname"] ?></td>
            </tr>
            <tr>
                <td align="left"><span style="font-weight:bold">Channel Title:</span></td>
                <td><?= $_MEMBER->Info["i_title"] ?></td>
            </tr>
            <tr>
                <td align="left"><span style="font-weight:bold">Email:</span></td>
                <td><?= $_MEMBER->Info["email"] ?></td>
            </tr>
            <tr>
                <td align="left"><span style="font-weight:bold">Registration Date:</span></td>
                <td><?php if (strtotime((string) $_MEMBER->Info["registration_date"]) > 0) {
                    echo strftime('%B %e %Y, %I:%M:%S %p', strtotime((string) $_MEMBER->Info["registration_date"])); 
                } else {
                    echo "None";
                } ?></td>
            </tr>
            <tr>
                <td align="left"><span style="font-weight:bold">Last Login:</span></td>
                <td><?php if (strtotime((string) $_MEMBER->Info["last_login"]) > 0) {
                    echo strftime('%B %e %Y, %I:%M:%S %p', strtotime((string) $_MEMBER->Info["last_login"])); 
                } else {
                    echo "None";
                } ?></td>
            </tr>
            <tr>
                <td align="left"><span style="font-weight:bold">Failed Login Attempt:</span></td>
                <td><?php if (strtotime((string) $_MEMBER->Info["failed_login_attempt"]) > 0) {
                    echo strftime('%B %e %Y, %I:%M:%S %p', strtotime((string) $_MEMBER->Info["failed_login_attempt"])); 
                } else {
                    echo "None";
                } ?></td>
            </tr>
            <tr>
                <td align="left"><span style="font-weight:bold">Subscribers:</span></td>
                <td><?= $_MEMBER->Info["subscribers"] ?></td>
            </tr>
            <tr>
                <td align="left"><span style="font-weight:bold">... of which are banned:</span></td>
                <td><?= $DB->execute("SELECT count(*) FROM subscriptions INNER JOIN users ON users.username = subscriptions.subscriber WHERE subscription = :USERNAME AND users.is_banned = 1",true,[":USERNAME" => $_MEMBER->Username])["count(*)"] ?></td>
            </tr>
            <tr>
                <td align="left"><span style="font-weight:bold">Subscriptions:</span></td>
                <td><?= $_MEMBER->Info["subscriptions"] ?></td>
            </tr>
            <tr>
                <td align="left"><span style="font-weight:bold">Friends:</span></td>
                <td><?= $_MEMBER->Info["friends"] ?></td>
            </tr>
            <tr>
                <td align="left"><span style="font-weight:bold">Video Views:</span></td>
                <td><?= $_MEMBER->Info["video_views"] ?></td>
            </tr>
            <tr>
                <td align="left"><span style="font-weight:bold">Profile Views:</span></td>
                <td><?= $_MEMBER->Info["profile_views"] ?></td>
            </tr>
            <tr>
                <td align="left"><span style="font-weight:bold">Birthday:</span></td>
                <td><?php if ($_MEMBER->Info["i_age"] != '0000-00-00') {
                    echo strftime('%B %e, %Y', strtotime((string) $_MEMBER->Info["i_age"])); 
                } else {
                    echo "None";
                } ?></td>
            </tr>
            <tr>
                <td align="left"><span style="font-weight:bold">Copyright Strikes:</span></td>
                <td><?php if ($Strikes < 3) : ?><?= $Strikes ?><?php else : ?><span style="color:red;font-weight:bold"><?= $Strikes ?></span><?php endif ?></td>
            </tr>
            <tr>
                <td align="left"><span style="font-weight:bold">Account Status:</span></td>
                <td><?php if ($_MEMBER->Is_Admin) : ?>Administrator<?php elseif ($_MEMBER->Is_Moderator) : ?>Moderator<?php elseif ($_MEMBER->Info['is_partner']) : ?>Partner<?php else : ?>User<?php endif ?><?php if ($_MEMBER->Info['is_verified'] == 0): ?> (Unverified)<?php endif ?></td>
            </tr>
        </table>
        </div>
    </div>
</div>
<div style="float:left;width:49%;margin-left:1%">
    <div class="a_box">
        <div class="a_box_title">Other Accounts by User</div>
        <div style="text-align: left; padding: 6px;">
            <?php if ($Other_Channels) : ?>
                <div style="overflow-y:auto">
                    <?php foreach ($Other_Channels as $Channel) : ?>
                        <div class="otherchannel">
                        <a style="display:block;<?php if ($Channel["is_banned"]) : ?>color:red; font-weight:bold<?php endif ?>" href="/admin_panel/?page=users&ue=<?= $Channel["username"] ?>"><?= $Channel["username"] ?></a><div style="font-size:11px;color:#666">Registered on <?= strftime('%B %e %Y', strtotime((string) $Channel["registration_date"])) ?>, <?= $Channel["videos"] ?> videos, <?= $Channel["subscribers"] ?> subscribers</div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php else : ?>
                <div style="text-align:center; font-weight: bold; font-size:14px">No other channels by this user</div>
            <?php endif ?>
        </div>
    </div>
</div>
<div style="clear:both"></div>
<div class="a_box">
        <div class="a_box_title">Recent Activity</div>
        <div style="padding: 8px;height: 250px;overflow: scroll;resize: vertical;">
            <?php $Count = 0 ?>
            <?php foreach ($Recent_Activity as $Activity) : ?>
                        <?php $Count++ ?>
                        <?php if ($Activity["type_name"] == "comment") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-C" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $_MEMBER->Username ?>"><?= displayname($_MEMBER->Username) ?></a> <?= $LANGS['activitycomment'] ?> <a id="video-long-title" href="/watch?v=<?= $Activity["id"] ?>" title="<?= $Activity["title"] ?>" rel="nofollow"><?= short_title($Activity["title"],20) ?></a>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                                    <div class="video-entry">
                                        <?= load_thumbnail($Activity['id']) ?>
                            
                                        <div class="video-main-content" id="video-main-content" style="width: 458px;padding-left: 12px;">
                                            <i>"<?= short_title(nl2br((string) $Activity['content']),300) ?>"</i>
                                        <div class="video-clear-list-left"></div>
                                    </div>
                                </div>
                            </div>
                        <?php elseif ($Activity["type_name"] == "bulletin") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-BUL" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $Activity['id'] ?>"><?= displayname($Activity['id']) ?></a> 
                                </span> <span id="bulletin-content"><?= nl2br((string) $Activity['content']) ?> </span>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                                <?php
                                    $_VIDEO = new Video($Activity["rating"],$DB);

                                    if ($_VIDEO->exists()) {
                                    $_VIDEO->get_info();
                                    } 
                                    ?>
                                <?php if ($_VIDEO->exists()) :?>
                                <div class="video-entry">
                                        <?= load_thumbnail($_VIDEO->URL) ?>
                                        <div class="video-main-content" id="video-main-content" style="width: 458px;padding-left: 12px;">
                                            <div class="video-title video-title-results">
                                                <div class="video-long-title">
                                                    <a id="video-long-title" href="/watch?v=<?= $_VIDEO->Info['url'] ?>" title="<?= mb_substr((string) $_VIDEO->Info["title"],0,128) ?>" rel="nofollow"><?= mb_substr((string) $_VIDEO->Info["title"],0,128) ?></a> <?php if ($_VIDEO->Info['hd'] == 1): ?><a href="/watch?v=<?= $_VIDEO->Info["id"] ?>"><img src="/img/pixel.gif" class="hd-video-logo"></a><?php endif ?>
                                                </div>
                                            </div>
                            
                                            <div id="video-description" class="video-description">
                                                <?php if($_VIDEO->Info["description"]) : ?>
                                            <?= short_title($_VIDEO->Info["description"],150) ?>
                                            <?php else : ?><?= $LANGS['nodesc'] ?><?php endif ?>
                                            </div>
                            
                                            <div class="vlfacets">
                                                <span id="video-added-time" class="video-date-added"><?= get_time_ago($_VIDEO->Info["uploaded_on"]) ?></span>
                                                <span id="video-num-views" class="video-view-count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_VIDEO->Info["views"]) ?><?php else: ?><?= ($_VIDEO->Info["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>
                                                <span class="video-username"><a id="video-from-username" class="hLink" href="/user/<?=$_VIDEO->Info["uploaded_by"]?>"><?= displayname($_VIDEO->Info["uploaded_by"]) ?></a></span>
                                            </div>
                                        <div class="video-clear-list-left"></div>
                                    </div>
                                </div>
                            <?php endif?>
                            </div> 
                        <?php elseif ($Activity["type_name"] == "rating") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-E" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $_MEMBER->Username ?>"><?= displayname($_MEMBER->Username) ?></a> <?= $LANGS['activitylike'] ?>&nbsp;
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                                    <div class="video-entry">
                                        <?= load_thumbnail($Activity['id']) ?>
                                        <?php
                                        $_VIDEO = new Video($Activity["id"],$DB);

                                        if ($_VIDEO->exists()) {
                                        $_VIDEO->get_info();
                                        } 
                                        ?>
                                        <?php if ($_VIDEO->exists()) :?>
                                        <div class="video-main-content" id="video-main-content" style="width: 458px;padding-left: 12px;">
                                            <div class="video-title video-title-results">
                                                <div class="video-long-title">
                                                    <a id="video-long-title" href="/watch?v=<?= $Activity["id"] ?>" title="<?= mb_substr((string) $Activity["title"],0,128) ?>" rel="nofollow"><?= mb_substr((string) $Activity["title"],0,128) ?></a> <?php if ($_VIDEO->Info['hd'] == 1): ?><a href="/watch?v=<?= $Activity["id"] ?>"><img src="/img/pixel.gif" class="hd-video-logo"></a><?php endif ?>
                                                </div>
                                            </div>
                            
                                            <div id="video-description" class="video-description">
                                                <?php if($_VIDEO->Info['description']) : ?>
                            <?= short_title($_VIDEO->Info['description'],150) ?>
                            <?php else : ?><?= $LANGS['nodesc'] ?><?php endif ?>
                                            </div>
                            
                                            <div class="vlfacets">
                                                <span id="video-added-time" class="video-date-added"><?= get_time_ago($Activity["date"]) ?></span>
                                                <span id="video-num-views" class="video-view-count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_VIDEO->Info['views']) ?><?php else: ?><?= ($_VIDEO->Info['views']) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>
                                                <span class="video-username"><a id="video-from-username" class="hLink" href="/user/<?=$_VIDEO->Info['uploaded_by']?>"><?= displayname($_VIDEO->Info['uploaded_by']) ?></a></span>
                                            </div>
                                        <div class="video-clear-list-left"></div>
                                    </div>
                                <?php endif ?>
                                </div>
                            </div>
                        <?php elseif ($Activity["type_name"] == "uploaded") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-U" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $_MEMBER->Username ?>"><?= displayname($_MEMBER->Username) ?></a> <?= $LANGS['activityupload'] ?>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                                    <div class="video-entry">
                                        <?= load_thumbnail($Activity['id']) ?>
                                        <?php
                                        $_VIDEO = new Video($Activity["id"],$DB);

                                        if ($_VIDEO->exists()) {
                                        $_VIDEO->get_info();
                                        } 
                                        ?>
                                        <?php if ($_VIDEO->exists()) :?>
                                        <div class="video-main-content" id="video-main-content" style="width: 458px;padding-left: 12px;">
                                            <div class="video-title video-title-results">
                                                <div class="video-long-title">
                                                    <a id="video-long-title" href="/watch?v=<?= $Activity["id"] ?>" title="<?= mb_substr((string) $Activity["title"],0,128) ?>" rel="nofollow"><?= mb_substr((string) $Activity["title"],0,128) ?></a> <?php if ($_VIDEO->Info['hd'] == 1): ?><a href="/watch?v=<?= $Activity["id"] ?>"><img src="/img/pixel.gif" class="hd-video-logo"></a><?php endif ?>
                                                </div>
                                            </div>
                            
                                            <div id="video-description" class="video-description">
                                                <?php if($_VIDEO->Info['description']) : ?>
                            <?= short_title($_VIDEO->Info['description'],150) ?>
                            <?php else : ?><?= $LANGS['nodesc'] ?><?php endif ?>
                                            </div>
                            
                                            <div class="vlfacets">
                                                <span id="video-added-time" class="video-date-added"><?= get_time_ago($Activity["date"]) ?></span>
                                                <span id="video-num-views" class="video-view-count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_VIDEO->Info['views']) ?><?php else: ?><?= ($_VIDEO->Info['views']) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>
                                                <span class="video-username"><a id="video-from-username" class="hLink" href="/user/<?=$_VIDEO->Info['uploaded_by']?>"><?= displayname($_VIDEO->Info['uploaded_by']) ?></a></span>
                                            </div>
                                        <div class="video-clear-list-left"></div>
                                    </div>
                                <?php endif ?>
                                </div>
                            </div>
                        <?php elseif ($Activity["type_name"] == "friend") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-FRI" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $Activity['id'] ?>"><?= displayname($Activity['id']) ?></a> <?= $LANGS['activityfriend'] ?> <a id="video-long-title" href="/user/<?= $Activity['content'] ?>" rel="nofollow"><?= displayname($Activity["content"]) ?></a>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                            </div> 
                        <?php elseif ($Activity["type_name"] == "favorite") : ?>
                            <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-F" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $_MEMBER->Username ?>"><?= displayname($_MEMBER->Username) ?></a> <?= $LANGS['activityfavorite'] ?>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                                    <div class="video-entry">
                                        <?= load_thumbnail($Activity['id']) ?>
                                        <?php
                                        $_VIDEO = new Video($Activity["id"],$DB);

                                        if ($_VIDEO->exists()) {
                                        $_VIDEO->get_info();
                                        } 
                                        ?>
                                        <?php if ($_VIDEO->exists()) :?>
                                        <div class="video-main-content" id="video-main-content" style="width: 458px;padding-left: 12px;">
                                            <div class="video-title video-title-results">
                                                <div class="video-long-title">
                                                    <a id="video-long-title" href="/watch?v=<?= $Activity["id"] ?>" title="<?= mb_substr((string) $Activity["title"],0,128) ?>" rel="nofollow"><?= mb_substr((string) $Activity["title"],0,128) ?></a> <?php if ($_VIDEO->Info['hd'] == 1): ?><a href="/watch?v=<?= $Activity["id"] ?>"><img src="/img/pixel.gif" class="hd-video-logo"></a><?php endif ?>
                                                </div>
                                            </div>
                            
                                            <div id="video-description" class="video-description">
                                                <?php if($_VIDEO->Info['description']) : ?>
                            <?= short_title($_VIDEO->Info['description'],150) ?>
                            <?php else : ?><?= $LANGS['nodesc'] ?><?php endif ?>
                                            </div>
                            
                                            <div class="vlfacets">
                                                <span id="video-added-time" class="video-date-added"><?= get_time_ago($Activity["date"]) ?></span>
                                                <span id="video-num-views" class="video-view-count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_VIDEO->Info['views']) ?><?php else: ?><?= ($_VIDEO->Info['views']) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>
                                                <span class="video-username"><a id="video-from-username" class="hLink" href="/user/<?=$_VIDEO->Info['uploaded_by']?>"><?= displayname($_VIDEO->Info['uploaded_by']) ?></a></span>
                                            </div>
                                        <div class="video-clear-list-left"></div>
                                    </div>
                                <?php endif ?>
                                </div>
                            </div>
                        <?php elseif ($Activity["type_name"] == "subscription") : ?>
                               <div class="feed-item-<?= $Count ?>" id="feed-item">
                                <span class="feed_icon">
                                    <img class="icon-S" src="/img/pixel.gif">
                                </span>
                                <span class="feed_title">
                                    <a href="/user/<?= $Activity['id'] ?>"><?= displayname($Activity['id']) ?></a> <?= $LANGS['activitysubscription'] ?> <a id="video-long-title" href="/user/<?= $Activity['content'] ?>" rel="nofollow"><?= displayname($Activity["content"]) ?></a>
                                </span>
                                <span class="timestamp">(<?= get_time_ago($Activity['date']) ?>)</span>
                            </div> 
                        <?php endif ?>
                    <?php endforeach ?>
                    <div style="clear:both"></div>
        </div>
    </div>
<?php if ($_MEMBER->Info["avatar"] || $_MEMBER->Info["c_background_image"]) : ?>
<div style="width:49%;margin-left:1%;float:right">
    <div class="a_box">
    <div class="a_box_title">Edit User Images</div>
    <table width="100%" border="0" cellpadding="5" cellspacing="0" style="margin:0 auto">
            <?php if ($_MEMBER->Info["avatar"]) : ?>
            <form action="/admin_panel/?page=users&ue=<?= $_MEMBER->Info["username"] ?>" method="post">
            <tr>
                <td align="right"><span style="font-weight:bold">Avatar:</span></td>
                <td width="60px"><span class="user-thumb-large" style="display:inline-block;">
                    <a href="/user/<?= $_MEMBER->Username ?>" style="z-index: 50000;position: relative;"><img src="<?= avatar($_MEMBER->Username) ?>" <?php if ($_MEMBER->Info["is_avatar_video"] == 1) : ?>class="avatarvideo"<?php endif ?> alt="<?= $_MEMBER->Username ?>"></a>
                </span></td>
                <td><input type="submit" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin: 0;" name="delete_user_avatar" value="Delete Avatar Image"></td>
            </tr>
            </form>
            <?php endif ?>
            <?php if ($_MEMBER->Info["c_background_image"]) : ?>
            <form action="/admin_panel/?page=users&ue=<?= $_MEMBER->Info["username"] ?>" method="post">
            <tr>
                <td align="right"><span style="font-weight:bold">Background:</span></td>
                <td width="60px">
                    <a href="/u/bck/<?= $_MEMBER->Username ?>.jpg" style="z-index: 50000;position: relative;"><img src="/u/bck/<?= $_MEMBER->Username ?>.jpg" width="66" alt="<?= $_MEMBER->Username ?>"></a></td>
                <td><input type="submit" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin: 0;" name="delete_user_background" value="Delete Background Image"></td>
            </tr>
            </form>
            <?php endif ?>
</table>
</div>
</div>
<?php endif ?>
<form action="/admin_panel/?page=users&ue=<?= $_MEMBER->Info["username"] ?>" method="post">
    <div style="width:49%;margin-right:1%;float:left">
        <div class="a_box">
        <div class="a_box_title">Edit User Info</div>
        <table width="100%" border="0" cellpadding="5" cellspacing="0" style="margin:0 auto">
            <tr>
                <td align="right"><span style="font-weight:bold">Name:</span></td>
                <td><input type="text" name="profile_name" value="<?= $_MEMBER->Info["i_name"] ?>" maxlength="64" style="width:180px" /></td>
            </tr>
            <tr>
                <td align="right"><span style="font-weight:bold">Display Name:</span></td>
                <td><input type="text" name="displayname" value="<?= $_MEMBER->Info["displayname"] ?>" maxlength="128" style="width:180px" /></td>
            </tr>
            <tr>
                <td align="right"><span style="font-weight:bold">Website:</span></td>
                <td><input type="text" name="profile_website" value="<?= $_MEMBER->Info["i_website"] ?>" maxlength="128" style="width:180px" /></td>
            </tr>
            <tr>
                <td align="right"><span style="font-weight:bold">Gender:</span></td>
                <td>
                    <select name="profile_gender">
                        <option value="0"<?php if ($_MEMBER->Info["i_gender"] == 0) : ?> selected<?php endif ?>>Private</option>
                        <option value="1"<?php if ($_MEMBER->Info["i_gender"] == 1) : ?> selected<?php endif ?>>Male</option>
                        <option value="2"<?php if ($_MEMBER->Info["i_gender"] == 2) : ?> selected<?php endif ?>>Female</option>
                    </select>
                </td>
            </tr>
            <td align="right"><span style="font-weight:bold">Relationship:</span></td>
            <td>
                <select name="profile_relationship">
                    <option value="0"<?php if ($_MEMBER->Info["i_relationship"] == 0) : ?> selected<?php endif ?>>Private</option>
                    <option value="1"<?php if ($_MEMBER->Info["i_relationship"] == 1) : ?> selected<?php endif ?>>Single</option>
                    <option value="2"<?php if ($_MEMBER->Info["i_relationship"] == 2) : ?> selected<?php endif ?>>Taken</option>
                    <option value="3"<?php if ($_MEMBER->Info["i_relationship"] == 3) : ?> selected<?php endif ?>>Married</option>
                </select>
            </td>
            <tr>
                <td align="right"><span style="font-weight:bold">About Me:</span></td>
                <td><textarea type="text" name="profile_about" value="" maxlength="256" style="width:180px" /><?= $_MEMBER->Info["i_about"] ?></textarea></td>
            </tr>
            <tr>
                <td align="right"><span style="font-weight:bold">Hobbies:</span></td>
                <td><input type="text" name="profile_hobbies" value="<?= $_MEMBER->Info["i_hobbies"] ?>" maxlength="128" style="width:180px" /></td>
            </tr>
            <tr>
                <td align="right"><span style="font-weight:bold">Favorite Books:</span></td>
                <td><input type="text" name="profile_books" value="<?= $_MEMBER->Info["i_books"] ?>" maxlength="128" style="width:180px" /></td>
            </tr>
            <tr>
                <td align="right"><span style="font-weight:bold">Favorite Movies:</span></td>
                <td><input type="text" name="profile_movies" value="<?= $_MEMBER->Info["i_movies"] ?>" maxlength="128" style="width:180px" /></td>
            </tr>
            <tr>
                <td align="right"><span style="font-weight:bold">Favorite Music:</span></td>
                <td><input type="text" name="profile_music" value="<?= $_MEMBER->Info["i_music"] ?>" maxlength="128" style="width:180px" /></td>
            </tr>
        </table>
        <input type="submit" class="yt-button" style="padding: 0.3888em 0.8333em;font-size: 12px;margin: 6px;margin-left: 120px;margin-top: 0;" name="save_user" value="Save Information">
    </div>
    
</div>
<div style="float:right; width: 49%; margin-left:1%">
<style>
    #chartdiv {
        width: 96%;
        height: 200px;
        padding: 0px;
        margin-bottom: 5px;
        margin-left: 8px;
    }
    #chartdiv[title="JavaScript charts"] {
        display: none !important;
    }
    #chartdiv2 {
        width: 96%;
        height: 200px;
        padding: 0px;
        margin-bottom: 5px;
        margin-left: 8px;
    }
    #chartdiv2[title="JavaScript charts"] {
        display: none !important;
    }
    .amcharts-main-div * {
        font-family: Arial, sans-serif!important;
    }
</style>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<div class="a_box">
        <div class="a_box_title">Statistics</div>
        <div style="padding: 10px">
            <b>Views Chart:</b>
        <script>
                                var chart1 = AmCharts.makeChart("chartdiv", {
                                    "type": "serial",
                                    "theme": "none",
                                    "marginLeft": 0,
                                    "marginRight": 0,
                                    "marginTop": 15,
                                    "marginBottom": 0,
                                    "autoMarginOffset": 0,
                                    "mouseWheelZoomEnabled":true,
                                    "dataDateFormat": "YYYY-MM-DD",
                                    "valueAxes": [{
                                        "id": "v1",
                                        "axisAlpha": 0,
                                        "position": "right",
                                        "ignoreAxisWidth":false,
                                        "tickLength":0,
                                        "inside": true
                                    }],
                                    "balloon": {
                                        "borderThickness": 0,
                                        "shadowAlpha": 0,
                                    },
                                    "graphs": [{
                                        "id": "g1",
                                        "balloon":{
                                            "drop":false,
                                            "adjustBorderColor":false,
                                            "color":"#ffffff",
                                            "type": "smoothedLine"
                                        },
                                        "lineColor": "#30831B",
                                        "bullet": "none",
                                        "fillAlphas": 0.2,
                                        "bulletBorderAlpha": 1,
                                        "bulletColor": "#085800",
                                        "bulletSize": 6,
                                        "hideBulletsCount": 50,
                                        "lineThickness": 1.5,
                                        "title": "blue line",
                                        "useLineColorForBulletBorder": true,
                                        "valueField": "value",
                                        "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
                                    }],
                                    "chartScrollbar": {
                                        "graph": "g1",
                                        "oppositeAxis":false,
                                        "dragIcon": "/img/dragIcon.svg",
                                        "dragIconWidth": 11,
                                        "dragIconHeight": 17,
                                        "offset":30,
                                        "scrollbarHeight": 50,
                                        "backgroundAlpha": 0.05,
                                        "selectedBackgroundAlpha": 1,
                                        "backgroundColor": "#dddddd",
                                        "selectedBackgroundColor": "#fff",
                                        "graphFillAlpha": 0.1,
                                        "graphLineAlpha": 0.6,
                                        "selectedGraphLineColor": "#3399fa",
                                        "selectedGraphFillColor": "#EEF5FD",
                                        "selectedGraphFillAlpha": 1,
                                        "selectedGraphLineAlpha": 1,
                                        "autoGridCount":true,
                                        "color":"#000",
                                        "gridColor":"#ddd",
                                    },
                                    "chartCursor": {
                                        "pan": true,
                                        "valueLineEnabled": true,
                                        "valueLineBalloonEnabled": true,
                                        "cursorAlpha":1,
                                        "cursorColor":"#085800",
                                        "limitToGraph":"g1",
                                        "valueLineAlpha":0.2,
                                        "valueZoomable":true
                                    },
                                    "categoryField": "date",
                                    "categoryAxis": {
                                        "parseDates": true,
                                        "equalSpacing": true,
                                        "dashLength": 0,
                                        "minorGridEnabled": true,
                                        "boldPeriodBeginning": true
                                    },
                                    "export": {
                                        "enabled": false
                                    },
                                    "dataProvider": [
                                        <?php foreach ($Daily_Views as $View) : ?>
                                        {
                                            "date": "<?= $View["Date"] ?>",
                                            "value": <?= $View["Total"] ?>
                                        },
                                    <?php endforeach ?>
                                        ]
                                });

                                chart1.addListener("rendered", zoomChart);
                            </script>
        <!-- HTML -->
        <div id="chartdiv"></div>
        <br>
        <b>Subscribers Chart:</b>
        <script>
                                var chart2 = AmCharts.makeChart("chartdiv2", {
                                    "type": "serial",
                                    "theme": "none",
                                    "marginLeft": 0,
                                    "marginRight": 0,
                                    "marginTop": 15,
                                    "marginBottom": 0,
                                    "autoMarginOffset": 0,
                                    "mouseWheelZoomEnabled":true,
                                    "dataDateFormat": "YYYY-MM-DD",
                                    "valueAxes": [{
                                        "id": "v1",
                                        "axisAlpha": 0,
                                        "position": "right",
                                        "ignoreAxisWidth":false,
                                        "tickLength":0,
                                        "inside": true
                                    }],
                                    "balloon": {
                                        "borderThickness": 0,
                                        "shadowAlpha": 0,
                                    },
                                    "graphs": [{
                                        "id": "g1",
                                        "balloon":{
                                            "drop":false,
                                            "adjustBorderColor":false,
                                            "color":"#ffffff",
                                            "type": "smoothedLine"
                                        },
                                        "lineColor": "#30831B",
                                        "bullet": "none",
                                        "fillAlphas": 0.2,
                                        "bulletBorderAlpha": 1,
                                        "bulletColor": "#085800",
                                        "bulletSize": 6,
                                        "hideBulletsCount": 50,
                                        "lineThickness": 1.5,
                                        "title": "blue line",
                                        "useLineColorForBulletBorder": true,
                                        "valueField": "value",
                                        "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
                                    }],
                                    "chartScrollbar": {
                                        "graph": "g1",
                                        "oppositeAxis":false,
                                        "dragIcon": "/img/dragIcon.svg",
                                        "dragIconWidth": 11,
                                        "dragIconHeight": 17,
                                        "offset":30,
                                        "scrollbarHeight": 50,
                                        "backgroundAlpha": 0.05,
                                        "selectedBackgroundAlpha": 1,
                                        "backgroundColor": "#dddddd",
                                        "selectedBackgroundColor": "#fff",
                                        "graphFillAlpha": 0.1,
                                        "graphLineAlpha": 0.6,
                                        "selectedGraphLineColor": "#3399fa",
                                        "selectedGraphFillColor": "#EEF5FD",
                                        "selectedGraphFillAlpha": 1,
                                        "selectedGraphLineAlpha": 1,
                                        "autoGridCount":true,
                                        "color":"#000",
                                        "gridColor":"#ddd",
                                    },
                                    "chartCursor": {
                                        "pan": true,
                                        "valueLineEnabled": true,
                                        "valueLineBalloonEnabled": true,
                                        "cursorAlpha":1,
                                        "cursorColor":"#085800",
                                        "limitToGraph":"g1",
                                        "valueLineAlpha":0.2,
                                        "valueZoomable":true
                                    },
                                    "categoryField": "date",
                                    "categoryAxis": {
                                        "parseDates": true,
                                        "equalSpacing": true,
                                        "dashLength": 0,
                                        "minorGridEnabled": true,
                                        "boldPeriodBeginning": true
                                    },
                                    "export": {
                                        "enabled": false
                                    },
                                    "dataProvider": [
                                        <?php foreach ($Daily_Subs as $View) : ?>
                                        {
                                            "date": "<?= $View["Date"] ?>",
                                            "value": <?= $View["Total"] ?>
                                        },
                                    <?php endforeach ?>
                                        ]
                                });

                                chart2.addListener("rendered", zoomChart);
                            </script>
        <!-- HTML -->
        <div id="chartdiv2"></div>
</div>
</div>
</div>
    <div style="clear:both"></div>
</form>
<?php endif ?>
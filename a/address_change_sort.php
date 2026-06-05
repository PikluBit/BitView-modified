<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}

$_USER->get_info();

if ($_GET['o'] == 1) {
    $Order = "DESC";
}
else {
    $Order = "ASC";
}

if ($_GET['v'] == "fi") {
    $Status = "0";
}
else {
    $Status = "1";
}

$Friends = $DB->execute("SELECT * FROM users_friends INNER JOIN users ON users_friends.friend_1 = users.username OR users_friends.friend_2 = users.username WHERE (users_friends.friend_1 = :USERNAME OR users_friends.friend_2 = :USERNAME) AND users_friends.status = :STATUS AND users.username <> :USERNAME AND users.is_banned = 0 ORDER BY users.displayname $Order", false, [":STATUS" => $Status, ":USERNAME" => $_USER->Username]);
?>
<div id="user-list" style="height: 436px;overflow: scroll;display: block;">
<?php if ($Friends) :?>
<?php foreach ($Friends as $Friend): ?>
<div class="user" id="<?= $Friend['username'] ?>">
    <div width="20" id="user-check" class="check"><div><input class="user-sel" id="sel-<?= $Friend['username'] ?>" onclick="change_user('<?= $Friend["username"] ?>', 0);" type="checkbox"></div></div>
    <div id="username" class="username" onclick="change_user('<?= $Friend["username"] ?>', 1);">
    <div><?= displayname($Friend['username']) ?></div>
    </div>
</div>
<div style="clear:both"></div>
<?php endforeach ?>
<?php else: ?>
<div style="text-align: center;padding: 20px 0;">No contacts...</div>
<?php endif ?>
</div>
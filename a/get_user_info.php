<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
use function PHP81_BC\strftime;

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
if (!$_USER->Logged_In) {
    header("location: /");
    exit();
}

// Sanitize user input, remove all characters other than letters, numbers, dashes and underscores
$Friend = $_GET['user'];
$Friend = preg_replace('/[^0-9a-z\-\_]/i', '', (string) $Friend);

// Execute sanitized query

$FInfo = $DB->execute("SELECT * FROM users_friends WHERE friend_1 = :FRIEND AND friend_2 = :USERNAME OR friend_2 = :FRIEND AND friend_1 = :USERNAME", true, [':USERNAME' => $_USER->Username, ':FRIEND' => $Friend]);

$_FRIEND = new User($_GET["user"],$DB);
$_FRIEND->get_info();

?>
<div class="user-el<?php if ($_GET['open'] == 0): ?> closed<?php endif ?>" id="ue-<?= htmlspecialchars((string) $Friend) ?>">
    <div class="user-hd" <?php if ($FInfo && $FInfo['status'] == "0"): ?>id="hd-<?= $FInfo['id'] ?>"<?php endif ?> onclick="hd_open('<?= htmlspecialchars((string) $Friend) ?>');">
        <img src="/img/pixel.gif" class="menu-arr<?php if ($_GET['open'] == 1): ?> open<?php endif ?>" id="info-arr-<?= htmlspecialchars((string) $Friend) ?>"><?= displayname(htmlspecialchars((string) $Friend)) ?> / <a href="/user/<?= htmlspecialchars((string) $Friend) ?>"><?= displayname(htmlspecialchars((string) $Friend)) ?></a>
    </div>
    <div class="user-in" id="in-<?= htmlspecialchars((string) $Friend) ?>">
        <div class="user-thumb-large">
            <a href="/user/<?= htmlspecialchars((string) $Friend) ?>" style="z-index: 50000;position: relative;"><img src="<?= avatar(htmlspecialchars((string) $Friend)) ?>" alt="<?= displayname(htmlspecialchars((string) $Friend)) ?>"></a>
        </div>
        <div class="user-info">
            <div class="user-info-item">
            <?= $LANGS['friendstatus'] ?>:<br><span class="user-info-grey">
                <?php if (!$_USER->is_blocked($_FRIEND)): ?>
                <?php if ($FInfo && $FInfo['status'] == "1"): ?><?= $LANGS['friendssince'] ?> <?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['videotimeformat'], time_machine(strtotime((string) $FInfo['submit_on']))); }
                    else {echo strftime($LANGS['videotimeformat'], strtotime((string) $FInfo['submit_on'])); }  ?> <a href="/address_book?remove=<?= htmlspecialchars((string) $Friend) ?>">(<?= $LANGS['removefriend'] ?>)</a><?php else: ?><?= $LANGS['friendsinvitenot'] ?><?php endif ?></span>
                <?php else: ?>
                    <span class="user-info-grey">
                                Blocked user <a href="/address_book?remove=<?= htmlspecialchars((string) $Friend) ?>">(Unblock)</a></span>
                <?php endif ?>
            </div>
            <div class="user-info-item">
            <?= $LANGS['channel'] ?>:<br><span class="user-info-grey"><a href="/user/<?= htmlspecialchars((string) $Friend) ?>"><?= displayname(htmlspecialchars((string) $Friend)) ?></a> <a href="/a/subscription_center?user=<?= htmlspecialchars((string) $Friend) ?>">(<?php if ($_USER->is_subscribed($_FRIEND)):?><?= $LANGS['unsubscribe'] ?><?php else: ?><?= $LANGS['subscribe'] ?><?php endif ?>)</a></span>
            </div>
            <?php if ($FInfo && $FInfo['status'] == "0"): ?>
            <button onclick="location.href='/address_book?accept=<?= $FInfo['id'] ?>';"  class="yt-uix-button yt-uix-button-primary"><?= $LANGS['accept'] ?></button>
            <button onclick="location.href='/address_book?retract=<?= $FInfo['id'] ?>';" class="yt-uix-button yt-uix-button-primary"><?= $LANGS['decline'] ?></button>
            <?php endif ?>
            <button onclick="unselect('<?= htmlspecialchars((string) $Friend) ?>');" class="yt-uix-button yt-uix-button-primary"><?= $LANGS['unselect'] ?></button>
        </div>
    </div>
</div>
<div style="clear:both;margin-bottom: 8px;"></div>
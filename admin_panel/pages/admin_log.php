<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
if (!$_USER->Logged_In || (!$_USER->Is_Moderator && !$_USER->Is_Admin)) {
    header("location: /");
    exit();
}
?>
<div class="wrapper">
    <div style="float:left;width:76%;">
        <div class="a_box">
            <div class="a_box_title">Audit Log</div>
            <div style="padding: 8px;">
                <div class="time-slice-modifiers" width="30%">
                    <span class="browse-modifiers-extended-category-lbl"><span class="browse-modifiers-extended-category-lbl">Filter by User:</span></span>
                    <span class="yt-menulink" id="more-time-sub-modifiers-menulink" style="" onmouseenter="this.className += ' yt-menulink-hover';" onmouseleave="this.className = this.className.replace(' yt-menulink-hover', '');"><a class="yt-menulink-btn yt-button yt-button-" href="#" onclick="return false"><?php if (!isset($_GET['fu']) || !$_GET['fu']): ?>All<?php else: ?><?= $_GET['fu'] ?><?php endif ?></a><a class="yt-menulink-arr" href="#" onclick="return false"></a>
                        <ul class="yt-menulink-menu">
                            <?php foreach ($WhoDid as $User): ?>
                            <li><a href="/admin_panel/?page=log&fu=<?= $User['whodid'] ?>"><?= $User['whodid'] ?></a></li>
                            <?php endforeach ?>
                            <li><a href="/admin_panel/?page=log">All</a></li>
                        </ul>  
                        </span>
            <div class="clear"></div>
                                                </div>
                <?php
                $Expressions = [
                    '/ed user/',
                    '/^Updated password/',
                    '/^Striked/',
                    '/ed video $/',
                    '/^Showed privated/'
                ];
                foreach ($Logs as $Log):
                    preg_match('/^.* /', (string) $Log['whatdid'], $matches);
                    $LogData = preg_replace('/^.* /', '', (string) $Log['whatdid']);
                    $LogInfo = $matches[0];
                    $LogType = 0;
                    foreach($Expressions as $TypeNum => $Regex) {
                        if (preg_match($Regex, $LogInfo)) {
                            $LogType = $TypeNum + 1;
                            break;
                        }
                    }
                    if ($LogType === 4) {
                        $_VIDEO = new Video($LogData,$DB);
                        if ($_VIDEO->exists()) {
                            $_VIDEO->get_info();
                            $LogData = $_VIDEO->Info['title'];
                        }
                        else {
                            $LogData = 'Deleted';
                        }
                    }
                    elseif ($LogType === 0) {
                        $LogData = '';
                        $LogInfo = $Log['whatdid'];
                    }
                ?>
                    <div style="padding:6px"><a style="font-weight: bold;" href="/user/<?= $Log['whodid'] ?>"><?= $Log['whodid'] ?></a> <?= $LogInfo ?> <?php if ($LogType != 4): ?><a style="font-weight:bold" href="/user/<?= $LogData ?>"><?= $LogData ?></a><?php else: ?><a style="font-weight:bold" href="/watch?v=<?= $_VIDEO->URL ?>"><?= $LogData ?></a><?php endif ?> <span style="font-size: 11px;color: #666;">(<?= get_time_ago($Log['dater']) ?>)</span></div>
                <?php if ($LogType != 4 && $LogType > 0): ?><a href="/admin_panel/?page=users&ue=<?= $Log['whodid'] ?>" class="yt-button" style="padding: 0.3888em 0.8333em;">Edit Staff</a> <a href="/admin_panel/?page=users&ue=<?= $LogData ?>" class="yt-button" style="padding: 0.3888em 0.8333em;">Edit User</a><?php elseif ($LogType == 0): ?><a href="/admin_panel/?page=users&ue=<?= $Log['whodid'] ?>" class="yt-button" style="padding: 0.3888em 0.8333em;">Edit Staff</a> <a href="/admin_panel/?page=config" class="yt-button" style="padding: 0.3888em 0.8333em;">Edit Settings</a><?php elseif ($LogType == 4): ?><a href="/admin_panel/?page=users&ue=<?= $Log['whodid'] ?>" class="yt-button" style="padding: 0.3888em 0.8333em;">Edit Staff</a> <a href="/admin_panel/?page=videos&ve=<?= $_VIDEO->URL ?>" class="yt-button" style="padding: 0.3888em 0.8333em;">Edit Video</a> <a href="/admin_panel/?page=users&ue=<?= $_VIDEO->Info['uploaded_by'] ?>" class="yt-button" style="padding: 0.3888em 0.8333em;">Edit Uploader</a><?php endif ?>
                <?php endforeach ?>
                <div style="padding: 6px; font-weight: bold;"><?php if (1 < $_PAGINATION->Current_Page): ?><a href="/admin_panel/?page=log&p=<?= $_PAGINATION->Current_Page-1 ?>" style="margin-right: 6px;">Previous</a><?php endif ?><?php $i = 1 ?><?php while ($i < $TotalPages + 1): ?><?php if ($i != $_PAGINATION->Current_Page): ?><a href="/admin_panel/?page=log&p=<?= $i ?>" style="margin-right: 6px;"><?= $i ?></a><?php else: ?><b style="margin-right: 6px;"><?= $i ?></b><?php endif?><?php $i++ ?><?php endwhile ?><?php if ($_PAGINATION->Current_Page < $TotalPages): ?><a href="/admin_panel/?page=log&p=<?= $_PAGINATION->Current_Page+1 ?>" style="margin-right: 6px;">Next</a><?php endif ?></div>
            </div>
        </div>
    </div>
    <div style="clear:both"></div>
</div>
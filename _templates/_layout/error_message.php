<script>
function hide(e) {
    document.getElementById(e +'-box').outerHTML = "";
}
</script>
<?php if ($_SESSION["notification_clr"] == "cfeeb2" || $_SESSION["notification_clr"] == "green"): ?>
<div id="success-box" class="yt-alert yt-alert-success yt-rounded">
        <div class="yt-alert-icon master-sprite"></div>
        <div class="yt-alert-close" onclick="hide('success');"><div class="yt-alert-close-icon master-sprite"></div></div>
        <div id="" class="yt-alert-content">
            <?= $_SESSION["notification_msg"] ?>
        </div>
        <div class="clear"></div>
    </div>
<?php elseif ($_SESSION["notification_clr"] == "fff9d4" || $_SESSION["notification_clr"] == "yellow"): ?>
<div id="warn-box" class="yt-alert yt-alert-warn yt-rounded">
    <div class="yt-alert-icon master-sprite"></div>
    <div class="yt-alert-close" onclick="hide('warn');"><div class="yt-alert-close-icon master-sprite"></div></div>
    <div id="" class="yt-alert-content">
        <?= $_SESSION["notification_msg"] ?>
    </div>
    <div class="clear"></div>
</div>
<?php elseif ($_SESSION["notification_clr"] == "cce0f5" || $_SESSION["notification_clr"] == "blue"): ?>
<div id="info-box" class="yt-alert yt-alert-info yt-rounded">
    <div class="yt-alert-icon master-sprite"></div>
    <div class="yt-alert-close" onclick="hide('info');"><div class="yt-alert-close-icon master-sprite"></div></div>
    <div id="" class="yt-alert-content">
        <?= $_SESSION["notification_msg"] ?>
    </div>
    <div class="clear"></div>
</div>
<?php else: ?>
<div id="error-box" class="yt-alert yt-alert-error yt-rounded">
        <div class="yt-alert-icon master-sprite"></div>
        <div class="yt-alert-close" onclick="hide('error');"><div class="yt-alert-close-icon master-sprite"></div></div>
        <div id="" class="yt-alert-content">
            <?= $_SESSION["notification_msg"] ?>
        </div>
        <div class="clear"></div>
    </div>
<?php endif ?>
<?php
unset($_SESSION["notification_msg"]);
unset($_SESSION["notification_clr"]);
?>
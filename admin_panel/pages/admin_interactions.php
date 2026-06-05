<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
if (!$_USER->Logged_In || (!$_USER->Is_Moderator && !$_USER->Is_Admin)) {
    header("location: /");
    exit();
}
?>
<div style="float:left;width:100%">
    <div class="a_box">
        <div class="a_box_title">Latest Comments</div>
        <div style="max-height:500px;overflow-y:auto; padding: 5px;">
        <script>
            function delete_comment(id) {
                document.getElementById(id).outerHTML = "";
            }
        </script>
                <?php foreach ($Comments as $Comment) : ?>
                    <div style="margin-bottom:10px" id="<?= $Comment['id'] ?>">
                        <div class="videothumb" style="padding:0; width: 72px;"><a href="/watch?v=<?= $Comment["url"] ?>"><img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Comment["url"].'.jpg')): ?>src="/u/thmp/<?= $Comment["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> width="72"></a></div>
                        <?php $Title = $DB->execute("SELECT * FROM videos WHERE url = :URL", true, [":URL" => $Comment["url"]]); ?>
                        <div style="padding:0"><a href="/admin_panel/?page=users&ue=<?= $Comment["by_user"] ?>" style="font-weight: bold;"><?= $Comment["by_user"] ?></a> commented on <a href="/watch?v=<?= $Comment["url"] ?>" style="font-weight: bold;"><?= $Title['title'] ?></a> <span style="font-size: 11px;color: #666;">(<?= get_time_ago($Comment['submit_on']) ?>)</span><div style="font-style: italic;margin: 4px 0;">"<?= nl2br((string) $Comment["content"]) ?>"</div></div>
                        <div><a href="/a/delete_video_comment?id=<?= $Comment['id'] ?>" target="_blank" onclick="delete_comment(<?= $Comment['id'] ?>);" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Delete Comment</a> <a href="/admin_panel/?page=users&ue=<?= $Comment['by_user'] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Comment Author</a> <a href="/admin_panel/?page=users&ue=<?= $Title['uploaded_by'] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Video Uploader</a> <a href="/admin_panel/?page=videos&ve=<?= $Comment['url'] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Video</a></div>
                    </div>
                <?php endforeach ?>
        </div>
    </div>
</div>
<div style="float:left;width:100%">
    <div class="a_box">
        <div class="a_box_title">Latest Comments Marked as Spam</div>
        <div style="max-height:500px;overflow-y:auto; padding: 5px;">
        <script>
            function delete_comment(id) {
                document.getElementById(id).outerHTML = "";
            }
        </script>
                <?php foreach ($Comments_Spam as $Comment) : ?>
                    <div style="margin-bottom:10px" id="<?= $Comment['id'] ?>">
                        <div class="videothumb" style="padding:0; width: 72px;"><a href="/watch?v=<?= $Comment["url"] ?>"><img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Comment["url"].'.jpg')): ?>src="/u/thmp/<?= $Comment["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> width="72"></a></div>
                        <?php $Title = $DB->execute("SELECT * FROM videos WHERE url = :URL", true, [":URL" => $Comment["url"]]); ?>
                        <div style="padding:0"><a href="/admin_panel/?page=users&ue=<?= $Comment["by_user"] ?>" style="font-weight: bold;"><?= $Comment["by_user"] ?></a> commented on <a href="/watch?v=<?= $Comment["url"] ?>" style="font-weight: bold;"><?= $Title['title'] ?></a> <span style="font-size: 11px;color: #666;">(<?= get_time_ago($Comment['submit_on']) ?>)</span>&nbsp;&nbsp;<span style="font-weight: bold; color: red;">Marked as spam <?= $Comment['spam'] ?> time(s)</span><div style="font-style: italic;margin: 4px 0;">"<?= nl2br((string) $Comment["content"]) ?>"</div></div>
                        <div><a href="/a/delete_video_comment?id=<?= $Comment['id'] ?>" target="_blank" onclick="delete_comment(<?= $Comment['id'] ?>);" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Delete Comment</a> <a href="/admin_panel/?page=users&ue=<?= $Comment['by_user'] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Comment Author</a> <a href="/admin_panel/?page=users&ue=<?= $Title['uploaded_by'] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Video Uploader</a> <a href="/admin_panel/?page=videos&ve=<?= $Comment['url'] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Video</a></div>
                    </div>
                <?php endforeach ?>
        </div>
    </div>
</div>
<div style="float:left;width:63.4%;margin-right:1%">
    <div class="a_box">
        <div class="a_box_title">Latest Ratings</div>
        <div style="max-height:300px;overflow-y:auto; padding: 10px;">
            <?php foreach ($Ratings as $Rating) : ?>
                    <div style="margin-bottom:10px">
                        <div class="videothumb" style="padding:0; width: 72px;"><a href="/watch?v=<?= $Rating["url"] ?>"><img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Rating["url"].'.jpg')): ?>src="/u/thmp/<?= $Rating["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> width="72"></a></div>
                        <?php $Title = $DB->execute("SELECT * FROM videos WHERE url = :URL", true, [":URL" => $Rating["url"]]); ?>
                        <div style="padding:0"><a href="/admin_panel/?page=users&ue=<?= $Rating["username"] ?>" style="font-weight: bold;"><?= $Rating["username"] ?></a> rated <a href="/watch?v=<?= $Rating["url"] ?>" style="font-weight: bold;"><?= $Title['title'] ?></a> <span style="font-size: 11px;color: #666;">(<?= get_time_ago($Rating['submit_date']) ?>)</span><div class="stars"><?= show_ratings($Rating["rating"], "12px", "12px") ?></div></div>
                        <div><a href="/admin_panel/?page=users&ue=<?= $Rating['username'] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Rater</a> <a href="/admin_panel/?page=users&ue=<?= $Title['uploaded_by'] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Video Uploader</a> <a href="/admin_panel/?page=videos&ve=<?= $Rating['url'] ?>" class="yt-button" style="padding: 3px .83333333em;font-size: 12px;margin: 0;margin-top: 2px;">Edit Video</a></div>
                    </div>
                <?php endforeach ?>
        </div>
    </div>
</div>
<div style="float:right;width: 35.6%;">
    <div class="a_box">
        <div class="a_box_title">Show Private Messages</div>
        <div style="padding:10px 8px">
            <form action="/admin_panel/private_messages.php" method="get">
                <input type="text" placeholder="Username" name="ue" maxlength="20" style="width:180px;border:1px solid #999;height: 17.5px;" />
                <button type="submit" style="font-size: 12px;padding: 0.2333em 0.8333em; margin:0" class="yt-button" <?php if (!($_USER->Is_Admin)) : ?>onclick="if (!confirm('Private Messages are encrypted for moderators, please contact an admin')) { return false; }"<?php endif ?>>Show</button>
            </form>
        </div>
    </div>
</div>
<div style="float:right;width: 35.6%;">
    <div class="a_box">
        <div class="a_box_title">Show Comments</div>
        <div style="padding:10px 8px">
            <form action="/admin_panel/user_comments.php" method="get">
                <input type="text" placeholder="Username" name="ue" maxlength="20" style="width:180px;border:1px solid #999;height: 17.5px;" />
                <button type="submit" style="font-size: 12px;padding: 0.2333em 0.8333em; margin:0" class="yt-button" <?php if (!($_USER->Is_Admin)) : ?>onclick="if (!confirm('Private Messages are encrypted for moderators, please contact an admin')) { return false; }"<?php endif ?>>Show</button>
            </form>
        </div>
    </div>
</div>
<div style="clear:both"></div>

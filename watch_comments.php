<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
use function PHP81_BC\strftime;

require $_SERVER['DOCUMENT_ROOT']."/404.php";
exit();
?>

<script>
    function delete_comment(id) {
        document.getElementById("cid_"+id).outerHTML = "";
    }
</script>
<div id="baseDiv">
	<div id="search-settings-clr" class="hid"></div> 
	<div> 
		<div style="float: left; padding-right: 10px;">
			<a href="/watch?v=<?= $_VIDEO->Info["url"] ?>"><img src="/u/thmp/<?= $_VIDEO->Info["url"] ?>.jpg" class="vimg90"></a>&nbsp;
		</div>
		<div class="vtitle">
			<span class="xlargeText"><a href="/watch?v=<?= $_VIDEO->Info["url"] ?>"><?= $_VIDEO->Info["title"] ?></a></span>
			<div class="runtime" style="position: absolute;"><?= gmdate('i:s', $_VIDEO->Info["length"]) ?></div>
		</div>
		<div class="vfacets">
			<span class="grayText"><?= $LANGS['statadded'] ?>:</span>
			<?php setlocale(LC_TIME, $LANGS['languagecode']);
			echo strftime($LANGS['timehourformat'], strtotime((string) $_VIDEO->Info["uploaded_on"])); ?><br>
			<span class="grayText"><?= $LANGS['from'] ?>:</span>
			<a href="profile?user=<?= $_VIDEO->Info["uploaded_by"] ?>"><?= displayname($_VIDEO->Info["uploaded_by"]) ?></a><br>
			<span class="grayText"><?= $LANGS['statviews'] ?>:</span>
			<?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_VIDEO->Info["views"]) ?><?php else: ?><?= ($_VIDEO->Info["views"]) ?><?php endif ?><br>
		</div>
	</div>
	<?php if ($_VIDEO->Info['e_comments'] == 1 or $_VIDEO->Info['e_comments'] == 2 and $_USER->is_friends_with($_OWNER) == true or $_VIDEO->Info['e_comments'] == 2 and $_USER->Username == $_OWNER->Username) :?>
	<div style="clear: both">
		<div style="width: 550px;">
				<table>
					<tbody><tr>
						<td width="100%"><h2 class="commentHeading"><?= $LANGS['allcomments'] ?> <span style="color: #666;font-weight: normal;font-size: 14px;">(<?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_VIDEO->Info["comments"]) ?><?php else: ?><?= ($_VIDEO->Info["comments"]) ?><?php endif ?>)</span></h2>
								<div style="margin:5px;">
	</div>

</td>
						<td nowrap="" align="right">		<div id="reply_main_comment2" class="commentHeading">
			<?php if ($_USER->Logged_In) : ?><a href="#commentform" class="eLink"><?= $LANGS['commentpost'] ?></a><?php endif ?>
		</div>
</td>
					</tr>
					<tr>
						<td></td>
					</tr>
				</tbody></table>
			<br>
		</div>
		<div style="clear: both;width: 550px;">
		<div id="div_main_comment2"></div>
		<div id="recent_comments">
				<?php if ($_VIDEO->Info["comments"] > 0 && $Video_Comments_All) : ?>
				<?php foreach ($Video_Comments_All as $Video_Comment) : ?>
			<div id="cid_<?= $Video_Comment["id"] ?>"  class="watch-comment-entry">
		<div class="watch-comment-head" <?php if ($Video_Comment["by_user"] == "vistafan12" || $Video_Comment["by_user"] == "BitView" || $Video_Comment["by_user"] == "hwd") : ?>style="background-color: #BBDEFB;"<?php endif?><?php if ($Video_Comment["by_user"] == $_VIDEO->Info["uploaded_by"]) : ?>style="background-color: #fffcc2;"<?php endif?>>
			<div class="watch-comment-info">
				<a class="watch-comment-auth" href="profile?user=<?= $Video_Comment["by_user"] ?>" rel="nofollow"><?= displayname($Video_Comment["by_user"]) ?></a>
				<span class="watch-comment-time"> (<?= get_time_ago($Video_Comment["submit_on"]) ?>) </span>
                <?php if ($_USER->Logged_In && (($_USER->Is_Admin || $_USER->Is_Moderator) || ($_USER->Username == $_VIDEO->Info["uploaded_by"]))) : ?>
                    <span class="watch-comment-time"> (<a href="/a/delete_video_comment?id=<?= $Video_Comment["id"] ?>" onclick="delete_comment(<?= $Video_Comment["id"] ?>)" onclick="delete_comment(<?= $Video_Comment["id"] ?>)" target="_blank"><?= $LANGS['delete'] ?></a>)</span>
                <?php endif ?>
			</div>

			<div class="clearL"></div>
		</div>
			<div id="comment_body">
				<div class="watch-comment-body">
					<?= $Video_Comment["content"] ?>
				</div>
			</div>


	</div> 
	<?php endforeach ?>
            <?php else : ?>
                <div style="text-align:center;padding:20px 0 10px"><?= $LANGS['nocomments'] ?></div>
            <?php endif ?>
</div> <!-- end recent_comments -->
		</div>
		<?php if (!$_USER->Logged_In) : ?>
			<br>
				<h2 class="commentHeading"><?= $LANGS['commentlogin'] ?></h2>
				<div style="margin-top: 8px;">
				<?= $LANGS['commentlogindesc'] ?>
				</div>
				<?php endif ?>
				<?php if ($_USER->Logged_In) : ?>
            <form action="/watch?v=<?= $_VIDEO->Info["url"] ?>&c=all" method="post" id="commentform" style="margin-top: 10px;">
                <textarea cols="55" rows="3" id="comment_text" name="comment_text" maxlength="256"></textarea><br />
                <input type="submit" class="yt-button yt-button-primary" name="comment_submit" style="margin-top: 5px;" value="<?= $LANGS['postcomment'] ?>" />
            </form>
            <?php endif ?>
	</div>
<?php else: ?>
	<div style="clear: both;font-size: 16px;margin-top: 8px;">
	<strong>Adding comments has been disabled for this video.</strong>
</div>
<?php endif?>
		<div class="clear"></div>
</div>
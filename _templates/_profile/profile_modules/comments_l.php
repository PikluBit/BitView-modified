<?php if ($_PROFILE->Info['c_comments_box'] == 1): ?>
<div class="inner-box" id="user_comments">
		<div style="zoom:1">
		<div class="box-title title-text-color">
<?= $LANGS['channelcomments'] ?>
					(<span name="channel-box-item-count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["channel_comments"]) ?><?php else: ?><?= ($_PROFILE->Info["channel_comments"]) ?><?php endif ?></span>)
		</div>
		<?php if ($_PROFILE->Username == $_USER->Username): ?><div class="updown_arrows "><img id="user_comments-left-arrow" src="/img/pixel.gif" class="module-left-arrow disabled"><img id="user_comments-up-arrow" src="/img/pixel.gif" class="module-up-arrow <?php if ($Modules_L[0] == "comments"): ?> disabled<?php endif ?>" onclick="move_up('comments');return false"><img id="user_comments-down-arrow" src="/img/pixel.gif" class="module-down-arrow <?php if (end($Modules_L) == "comments"): ?>disabled<?php endif ?>" onclick="move_down('comments');return false"><img id="user_comments-right-arrow" src="/img/pixel.gif" class="module-right-arrow" onclick="move_right('comments')"></div><?php endif ?>
		<div style="float:right;zoom:1;_display:inline;white-space:nowrap">
			<div style="float:right">
		<a href="#" onclick="change_comments_page('<?= $_PROFILE->Username ?>',1);return false;">
<?= $LANGS['refresh'] ?>
		</a>
			</div>
		</div>
		<div class="cb"></div>
		</div>


	<div id="user_comments-messages" style="color:#333;margin:1em;padding:1em;display:none"></div>
	
	<div id="user_comments-body">
	<div class="commentsTableFull text-field outer-box-bg-as-border">
	<table border="0" cellspacing="0" cellpadding="0" id="profile_comments_table">
		<tbody>
			<?php if ($Comments) : ?>
                        <?php foreach ($Comments as $Comment) : ?>
			<tr class="commentsTableFull" id="cc_<?= $Comment["id"] ?>">
					<td valign="top" width="60" style="padding-bottom: 15px;">
			  <div class="user-thumb-medium"><div>
<a href="/user/<?= $Comment["by_user"] ?>">
    <img id="" src="<?= avatar($Comment["by_user"]) ?>" alt="<?= displayname($Comment["by_user"]) ?>">
</a>
  </div></div>

		</td>
		<td valign="top" style="padding-bottom: 15px;">
			<div style="float:left; margin-bottom: 5px;">
				<a name="profile-comment-username" href="/user/<?= $Comment["by_user"] ?>" style="font-size: 12px;"><b><?= displayname($Comment["by_user"]) ?></b></a>
				<span class="profile-comment-time-created">(<?= get_time_ago($Comment["submit_date"]) ?>)</span>
			</div>
				<div style="float:right; margin-bottom: 5px">
				<?php if ($_USER->Logged_In && ($_USER->Is_Admin || $_USER->Is_Moderator || $_USER->Username == $_PROFILE->Username || $_USER->Username == $Comment["by_user"])) : ?><a style="float:right" href="javascript:void(0)" onclick="delete_channel_comment(<?= $Comment["id"] ?>)"><?= $LANGS['delete'] ?></a><?php endif ?>
				<?php if ($_USER->Logged_In && $_USER->Username == $_PROFILE->Username && !$_USER->is_blocked(new User($Comment["by_user"],$DB))): ?><span style="float:right">&nbsp;|&nbsp;</span><a style="float:right" href="/a/block_user?user=<?= $Comment['by_user'] ?>"><?= $LANGS['blockuser'] ?></a><?php endif?>
				</div>
			<div class="profile-comment-body" style="clear:both;">
				<?= make_user_clickable(make_links_clickable(nl2br((string) $Comment["content"]))) ?>
			</div>
		</td>
		</tr> 
	<?php endforeach ?>
	<?php endif?>
	</tbody></table>
	<?php if ($_PROFILE->Info['channel_comments'] == 0): ?><div class="alignC">There are no comments for this user.</div><?php endif ?>
	</div>
		<?php if (!$_USER->Logged_In): ?>
		<div id="user-comments-login-add-comment" style="font-size: 12px; margin-top: 10px" class="alignC">
			<a href="/login"><?= $LANGS['addcomment'] ?></a>
			</div>
		<?php else: ?>
		<?php if (!$_PROFILE->is_blocked($_USER)): ?>
			<div id="comment_entry_box"><a name="entry"></a>
		<div style="padding-bottom: 3px; font-size: 14px;font-weight: bold;"><?= $LANGS['addcomment'] ?></div>
		<form action="">
			<textarea name="comment_entry_box" id="comment_entry_box_text" cols="80" rows="3" style="width:98%"></textarea>
			<br>
			<input id="comment_entry_submit_button" type="button" value="<?= $LANGS['postcomment'] ?>" onclick="post_channel_comment('<?= $_PROFILE->Username ?>')" style="margin-top:2px;">
		</form>
		</div>
		<?php else: ?>
			You can't comment on this channel because you are blocked!
		<?php endif?>
		<?php endif ?>
		<?php if (isset($Page_Amount) && $Page_Amount > 0):?>
		<div style="font-size: 12px; text-align: right; margin-top: 7px;font-weight:bold">
		<?php if ($Page_Amount > 1):?>
                            <?php foreach (range(1,$Page_Amount) as $Num):?>
                            <?php if ($Num != 1):?><a href="#" id="change-page-<?= $Num ?>" style="font-weight: bold;font-family: <?= $_PROFILE->Info["c_font"] ?>,sans-serif;" onclick="change_comments_page('<?= $_PROFILE->Username ?>',<?= $Num ?>); return false;"><?= $Num ?></a>&nbsp;<?php else: ?><span id="current-page-<?= $Num ?>"><?= $Num ?></span>&nbsp;<?php endif ?>
                            <?php endforeach ?><?php if ($Page_Amount > 1):?><a href="#" id="change-page-next" style="font-weight: bold;font-family: <?= $_PROFILE->Info["c_font"] ?>,sans-serif;" onclick="change_comments_page('<?= $_PROFILE->Username ?>',2);return false;"><?= $LANGS['next'] ?></a><?php endif ?>
                        <?php else: ?>
                            <span id="current-page-1">1</span>
                        <?php endif ?>
	</div>
<?php endif ?>


	</div>
	<div class="clear"></div>
</div>
<?php endif ?>
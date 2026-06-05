<?php if ($_PROFILE->Info['c_subscriptions_box'] == 1): ?>
<?php $Limit = $_PROFILE->Info['c_subscriptions_rows'] * 7; ?>
<?php $Users_Subscriptions_Main = $DB->execute("SELECT * FROM users INNER JOIN subscriptions ON subscriptions.subscriber = :USERNAME WHERE subscriptions.subscription = users.username AND is_banned = 0 ORDER BY subscriptions.submit_date DESC LIMIT ".(int)$Limit,false,[":USERNAME" => $_PROFILE->Username]); ?>
<div class="inner-box" id="user_subscriptions">
		<div style="zoom:1">
		<div class="box-title title-text-color">
<?= $LANGS['subscriptions'] ?>
					(<a href="/user/<?= $_PROFILE->Username ?>&page=subscriptions" class="headersSmall" name="channel-box-item-count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["subscriptions"]) ?><?php else: ?><?= ($_PROFILE->Info["subscriptions"]) ?><?php endif ?></a>)
		</div>
		<?php if ($_PROFILE->Username == $_USER->Username): ?><div class="updown_arrows "><img id="user_subscriptions-left-arrow" src="/img/pixel.gif" class="module-left-arrow " onclick="move_left('subscriptions')"><img id="user_subscriptions-up-arrow" src="/img/pixel.gif" class="module-up-arrow <?php if ($Modules_R[0] == "subscriptions"): ?> disabled<?php endif ?>" onclick="move_up('subscriptions');return false"><img id="user_subscriptions-down-arrow" src="/img/pixel.gif" class="module-down-arrow <?php if (end($Modules_R) == "subscriptions"): ?>disabled<?php endif ?>" onclick="move_down('subscriptions');return false"><img id="user_subscriptions-right-arrow" src="/img/pixel.gif" class="module-right-arrow disabled"></div><?php endif ?>
		<div style="float:right;zoom:1;_display:inline;white-space:nowrap">
			<?php if ($_PROFILE->Username == $_USER->Username): ?>
                    <a class="channel-cmd" href="#" onclick="document.getElementById('user_subscriptions').classList.add('edit_mode');return false;" id="user_subscriptions_edit_link"><?= mb_strtolower((string) $LANGS['edit'])  ?></a>
                <?php endif ?>
		</div>
		<div class="cb"></div>
		</div>
		<?php if ($_PROFILE->Username == $_USER->Username): ?>

        <img src="/img/pixel.gif" class="edit-widget" style="right: 85px;">
<div class="edit_info">
    <form action="/user/Herotrap" method="POST">
    <div class="edit_top_box" style="padding: 6px;">
    
    <div class="edit_info">
        <div id="edit_info" style="float:left;padding-left:4px;">
        <div>
<?= $LANGS['homerows'] ?>:
			<select name="rows_to_show" id="rows_to_show_subscriptions">
				<option value="1" <?php if ($_PROFILE->Info['c_subscriptions_rows'] == 1): ?>selected=""<?php endif ?>>1</option>
				<option value="2" <?php if ($_PROFILE->Info['c_subscriptions_rows'] == 2): ?>selected=""<?php endif ?>>2</option>
				<option value="3" <?php if ($_PROFILE->Info['c_subscriptions_rows'] == 3): ?>selected=""<?php endif ?>>3</option>
			</select>
		</div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
        <div class="edit_profile_separator spacer" style="border-style: solid">&nbsp;</div>
        <div class="user_subscriptions_save_cancel" style="position:relative;line-height: 27px;">
        <button type="button" class=" yt-uix-button yt-uix-button-primary" name="save_settings_user_subscriptions" onclick="save_rows('subscriptions');"><span class="yt-uix-button-content"><?= $LANGS['editsavechanges'] ?></span></button>
<?= $LANGS['or'] ?>
        <a href="#" onclick="document.getElementById('user_subscriptions').classList.remove('edit_mode');return false;"><?= $LANGS['editcancel'] ?></a>
        <div class="save_overlay" style="padding:0.4em;padding-left:3em;width:60%">
            <img src="/img/icn_loading_animated.gif">
        </div>
    </div>
    </div>
    </form>
        </div>
    <?php endif ?>
	<div id="user_subscriptions-messages" style="color:#333;margin:1em;padding:1em;display:none"></div>
	<div id="user_subscriptions-body">
	<div style="zoom:1;margin: 0 -12px">
		<?php if ($Users_Subscriptions_Main): ?>
			<?php foreach ($Users_Subscriptions_Main as $Subscription): ?>
				<div class="user-peep" style="width:14.2%;"><center>
					<div class="user-thumb-large link-as-border-color">
					  	<div>
							<a href="/user/<?= $Subscription['username'] ?>">
							    <img id="" src="<?= avatar($Subscription['username']) ?>" alt="<?= displayname($Subscription['username']) ?>">
							</a>
						</div>
					</div>
					<a href="/user/<?= $Subscription['username'] ?>" title="<?= displayname($Subscription['username']) ?>"><?= short_title(displayname($Subscription['username']),12) ?></a>
				</center></div>
			<?php endforeach ?>
		<?php endif ?>
		<div style="clear:both;font-height:1px"></div>
	</div>
	<div>
				<div style="font-size: 12px; text-align: right; margin-top: 7px;">
		<b><a name="channel-box-see-all" href="/user/<?= $_PROFILE->Username ?>&page=subscriptions">
<?= $LANGS['seeall'] ?>
		</a></b>
	</div>

	</div>
	</div>
	<div class="clear"></div>
</div>
<?php endif ?>
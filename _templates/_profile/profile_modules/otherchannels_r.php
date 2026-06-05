<?php if ($_PROFILE->Info['c_bulletins_box'] == 1): ?>
<?php $fc = explode(",", (string) $_PROFILE->Info["channels"]); ?>
<?php if(!empty($fc[0])): ?>
<div class="inner-box" id="user_hubber_links">
		<div style="zoom:1">
		<div class="box-title title-text-color">
	<?php if (!$_PROFILE->Info["channels_title"]): ?><?= $LANGS['featuredchannels'] ?><?php else: ?><?= $_PROFILE->Info["channels_title"] ?><?php endif ?>
		</div>
		<?php if ($_PROFILE->Username == $_USER->Username): ?><div class="updown_arrows "><img id="user_hubber_links-left-arrow" src="/img/pixel.gif" class="module-left-arrow " onclick="move_left('hubber_links')"><img id="user_hubber_links-up-arrow" src="/img/pixel.gif" class="module-up-arrow <?php if ($Modules_R[0] == "otherchannels"): ?> disabled<?php endif ?>" onclick="move_up('hubber_links');return false"><img id="user_hubber_links-down-arrow" src="/img/pixel.gif" class="module-down-arrow <?php if (end($Modules_R) == "otherchannels"): ?>disabled<?php endif ?>" onclick="move_down('hubber_links');return false"><img id="user_hubber_links-right-arrow" src="/img/pixel.gif" class="module-right-arrow disabled"></div><?php endif ?>
		<div style="float:right;zoom:1;_display:inline;white-space:nowrap">
			<?php if ($_PROFILE->Username == $_USER->Username): ?>
                    <a class="channel-cmd" href="#" onclick="document.getElementById('user_hubber_links').classList.add('edit_mode');return false;" id="user_hubber_links_edit_link"><?= mb_strtolower((string) $LANGS['edit'])  ?></a>
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
        <div id="edit_info_fc_title" style="float:left;padding-left:4px;">
        <div style="float:left;"><?= $LANGS['title'] ?>:</div>
        <br>
        <div style="float:left;text-align:right;">
                    <input type="text" name="fc_title" maxlength="60" style="width: 565px;" id="fc_title" maxlength="128" value="<?php if (!$_PROFILE->Info["channels_title"]): ?><?= $LANGS['featuredchannels'] ?><?php else: ?><?= $_PROFILE->Info["channels_title"] ?><?php endif ?>">
        </div>
        <div style="float:left;margin-top: 6px;"><?= $LANGS['featuredchannelsdesc'] ?></div>
        <div style="float:left;text-align:right;">
                    <textarea maxlength="125" type="text" name="fc" id="fc" class="edit_text" style="width: 565px;height: 80px;resize: none;margin-top: 2px;margin-bottom: 6px;"><?= $_PROFILE->Info['channels'] ?></textarea>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
        <div class="edit_profile_separator spacer" style="border-style: solid">&nbsp;</div>
        <div class="user_hubber_links_save_cancel" style="position:relative;line-height: 27px;">
        <button type="button" class=" yt-uix-button yt-uix-button-primary" name="save_settings_user_hubber_links" onclick="save_featured_channels();"><span class="yt-uix-button-content"><?= $LANGS['editsavechanges'] ?></span></button>
<?= $LANGS['or'] ?>
        <a href="#" onclick="document.getElementById('user_hubber_links').classList.remove('edit_mode');return false;"><?= $LANGS['editcancel'] ?></a>
        <div class="save_overlay" style="padding:0.4em;padding-left:3em;width:60%">
            <img src="/img/icn_loading_animated.gif">
        </div>
    </div>
    </div>
    </form>
        </div>
    <?php endif ?>

	<div id="user_hubber_links-messages" style="color:#333;margin:1em;padding:1em;display:none"></div>
	<?php for ($i = 0; $i < count($fc); $i++): ?>
	<div id="user_hubber_links-body">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tbody>
				
				<tr class="commentsTableFull">
				<td valign="top" width="60" style="padding-bottom: 15px;">
				  <div class="user-thumb-medium"><div>
<a href="/user/<?= $fc[$i] ?>">
    <img id="" src="<?= avatar($fc[$i]); ?>" alt="<?= displayname($fc[$i]); ?>">
</a>
  </div></div>

			</td><td valign="top" style="padding-bottom: 15px;">
			
				<div style="margin-bottom: 5px;">
					<a href="/user/<?= $fc[$i] ?>" style="font-size: 12px;"><b><?= title($fc[$i]); ?></b></a>
				</div>
				<div style="margin-right:7px">
					<?= short_title(nl2br((string) about($fc[$i])),80); ?>
				</div>
					
			</td><td valign="top" width="30%">
				<div><span class="smallText" width="100%"><?= $LANGS['videos'] ?>:</span> <?php if ($LANGS['numberformat'] == 1): ?><?= (videos($fc[$i])); ?><?php else: ?><?= videos($fc[$i]); ?><?php endif ?></div>
				<div><span class="smallText" width="100%"><?= $LANGS['channelviews'] ?>:</span> <?php if ($LANGS['numberformat'] == 1): ?><?= (profile_views($fc[$i])); ?><?php else: ?><?= profile_views($fc[$i]); ?><?php endif ?></div>
				<div><span class="smallText" width="100%"><?= $LANGS['channelsubscribers'] ?>:</span> <?php if ($LANGS['numberformat'] == 1): ?><?= (subscribers($fc[$i])); ?><?php else: ?><?= subscribers($fc[$i]); ?><?php endif ?></div>
			</td>
			</tr>
		</tbody></table>
	</div>
	<?php endfor ?>
	<div class="clear"></div>
</div>
<?php endif ?>
<?php if (empty($fc[0]) and $_USER->Username == $_PROFILE->Username): ?>
<div class="inner-box" id="user_hubber_links">
		<div style="zoom:1">
		<div class="box-title title-text-color">
	<?php if (!$_PROFILE->Info["channels_title"]): ?><?= $LANGS['featuredchannels'] ?><?php else: ?><?= $_PROFILE->Info["channels_title"] ?><?php endif ?>
		</div>
		<?php if ($_PROFILE->Username == $_USER->Username): ?><div class="updown_arrows "><img id="user_hubber_links-left-arrow" src="/img/pixel.gif" class="module-left-arrow " onclick="move_left('hubber_links')"><img id="user_hubber_links-up-arrow" src="/img/pixel.gif" class="module-up-arrow <?php if ($Modules_R[0] == "otherchannels"): ?> disabled<?php endif ?>" onclick="move_up('hubber_links');return false"><img id="user_hubber_links-down-arrow" src="/img/pixel.gif" class="module-down-arrow <?php if (end($Modules_R) == "otherchannels"): ?>disabled<?php endif ?>" onclick="move_down('hubber_links');return false"><img id="user_hubber_links-right-arrow" src="/img/pixel.gif" class="module-right-arrow disabled"></div><?php endif ?>
		<div style="float:right;zoom:1;_display:inline;white-space:nowrap">
			<?php if ($_PROFILE->Username == $_USER->Username): ?>
                    <a class="channel-cmd" href="#" onclick="document.getElementById('user_hubber_links').classList.add('edit_mode');return false;" id="user_hubber_links_edit_link"><?= mb_strtolower((string) $LANGS['edit'])  ?></a>
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
        <div id="edit_info_fc_title" style="float:left;padding-left:4px;">
        <div style="float:left;"><?= $LANGS['title'] ?>:</div>
        <br>
        <div style="float:left;text-align:right;">
                    <input type="text" name="fc_title" maxlength="60" style="width: 565px;" id="fc_title" maxlength="128" value="<?php if (!$_PROFILE->Info["channels_title"]): ?><?= $LANGS['featuredchannels'] ?><?php else: ?><?= $_PROFILE->Info["channels_title"] ?><?php endif ?>">
        </div>
        <div style="float:left;margin-top: 6px;"><?= $LANGS['featuredchannelsdesc'] ?></div>
        <div style="float:left;text-align:right;">
                    <textarea maxlength="125" type="text" name="fc" id="fc" class="edit_text" style="width: 565px;height: 80px;resize: none;margin-top: 2px;margin-bottom: 6px;"><?= $_PROFILE->Info['channels'] ?></textarea>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
        <div class="edit_profile_separator spacer" style="border-style: solid">&nbsp;</div>
        <div class="user_hubber_links_save_cancel" style="position:relative;line-height: 27px;">
        <button type="button" class=" yt-uix-button yt-uix-button-primary" name="save_settings_user_hubber_links" onclick="save_featured_channels();"><span class="yt-uix-button-content"><?= $LANGS['editsavechanges'] ?></span></button>
<?= $LANGS['or'] ?>
        <a href="#" onclick="document.getElementById('user_hubber_links').classList.remove('edit_mode');return false;"><?= $LANGS['editcancel'] ?></a>
        <div class="save_overlay" style="padding:0.4em;padding-left:3em;width:60%">
            <img src="/img/icn_loading_animated.gif">
        </div>
    </div>
    </div>
    </form>
        </div>
    <?php endif ?>

	<div id="user_hubber_links-messages" style="color:#333;margin:1em;padding:1em;display:none"></div>
	
	<div id="user_hubber_links-body">
		<?= $LANGS['featuredchannelsdefault'] ?>
	</div>
	<div class="clear"></div>
</div>
<?php endif ?>
<?php endif ?>
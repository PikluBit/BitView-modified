<?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/header_profile_new.php" ?>
<?php if ($_USER->Logged_In and $_USER->Username == $_PROFILE->Username): ?><?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_profile/custom.php" ?><?php endif ?>
<div id="baseDiv">
<div id="channel-body" class="jsloaded" style="height: 688px;">
    <?php if($_PROFILE->Info["is_partner"] and $_PROFILE->Info["c_banner_image"]): ?>
<div class="partnerBanner">
<?php if($_PROFILE->Info["banner_link"]): ?>
<a href="<?= $_PROFILE->Info["banner_link"] ?>">
<img src="<?= cache_bust($_PROFILE->Info["c_banner_image"]) ?>" width="960" height="150">
</a>
<?php else: ?>
<img src="<?= cache_bust($_PROFILE->Info["c_banner_image"]) ?>" width="960" height="150">
<?php endif ?>
</div>
<?php endif ?>
	<div id="channel-base-div">
	<div class="outer-box" style="z-index: 0">
				<div class="inner-box" style="font-size: 11px; padding-top: 8px; padding-bottom: 8px; margin-top: 3px; margin-bottom: 6px;">
					<a href="/user/<?= $_PROFILE->Username ?>">« <?= str_replace('{c}',displayname($_PROFILE->Username),$LANGS['backtochannel']) ?></a>
				</div>
				<div class="cb"></div>

							<div class="inner-box" id="user_subscribers">
		<div style="zoom:1">
		<div class="box-title title-text-color">
<?= $LANGS['channelsubscribers'] ?>
					(<span name="channel-box-item-count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["subscribers"]) ?><?php else: ?><?= ($_PROFILE->Info["subscribers"]) ?><?php endif ?></span>)
		</div>
		<div style="float:right;zoom:1;_display:inline;white-space:nowrap">
			<div style="float:right">
			</div>
		</div>
		<div class="cb"></div>
		</div>


	<div id="user_subscribers-messages" style="color:#333;margin:1em;padding:1em;display:none"></div>
	
	<div id="user_subscribers-body">
<?php if ($Users_Subscribers) : ?>
	<div style="zoom:1;margin: 0 -12px">
				<?php foreach ($Users_Subscribers as $Subscriber) : ?>
			<div class="user-peep" style="width:10%;"><center>
				  <div class="user-thumb-large link-as-border-color"><div>
<a href="/user/<?= $Subscriber['username'] ?>">
    <img id="" src="<?= avatar($Subscriber['username']) ?>" alt="<?= displayname($Subscriber['username']) ?>">
</a>
  </div></div>

				<a href="/user/<?= $Subscriber['username'] ?>" title="<?= displayname($Subscriber['username']) ?>"><?= short_title(displayname($Subscriber['username']),10) ?></a>

			</center></div>
		<?php endforeach?>
		<div style="clear:both;font-height:1px"></div>
	</div>
	<div>
				<div style="font-size: 12px; text-align: right; margin-top: 7px;font-weight:bold">
		<?php $_PAGINATION->new_show_pages_videos("user=$_PROFILE->Username&page=subscribers") ?>
	</div>
	</div>
	<?php endif ?>
	</div>
	<div class="clear"></div>
</div>

			</div>
	</div>
</div>
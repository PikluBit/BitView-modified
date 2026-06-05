<?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/profile_style.php" ?>
<div id="baseDiv">
                <?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/header_profile.php" ?>
    
        <br>
        <!--Begin Page Container Table-->
<?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_profile/main_links.php" ?>  
<div style="width: 958px; text-align: left;" class="sub_box">
	<div>
		<div class="BoxesInnerOpacity">	
				<div class="headerRCBox">
	</b> <div class="content">	<div class="headerTitleEdit">
		<span><?= $LANGS['friends'] ?> (<?= $_PROFILE->Info["friends"] ?>)</span>
		<div class="clear">
	</div>
</div>
	</div>
			<div class="headerBoxOpacity"></div>
		</div>

		<div class="basicBoxes" style="width:958px">
			<div class="BoxesInnerOpacity">
				<div style="float:left;margin:8px;">
				<?php if ($Friends) : ?>
				<?php foreach ($Friends as $Friend) : ?>
						
<div style="float:left;margin:8px;">
								<div style="margin-top:3px;margin-right:8px;text-align:left;">
		<div>
				<div class="user-thumb-jumbo"><a href="/user/<?= $Friend["username"] ?>"><img src="<?= avatar($Friend["username"]) ?>" width="120" height="90" style="margin-right: 12px;"></a></div>
		</div>
		<div class="title">
				
			
				<a href="/user/<?= $Friend["username"] ?>" style="font-size: 11px;"><?= displayname($Friend["username"]) ?></a>
			
		</div>
	</div>
</div>
						
						<?php unset($Avatar) ?>
						<?php endforeach ?>
						<?php else : ?>
							<div style="font-size:15px;color:#<?= $_PROFILE->Info["c_normal_font"] ?>;text-align:center;padding:22px 0 29px"><?= $LANGS['nofriends'] ?></div>
						<?php endif ?>
		</div>
				</div>
				<div style="clear:both;"></div>
				<div class="basicBoxesOpacity"></div>
			</div>
		</div>
		
		<div class="headerTitle">
			<div class="pagingDiv">
	<?php $_PAGINATION->new_show_pages_videos("user=$_PROFILE->Username&page=friends") ?>
		
		</div>
		</div>

	</div>
</div>





		
		
		
	</div>
</div>

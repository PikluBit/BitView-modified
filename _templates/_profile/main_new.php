<?php use function PHP81_BC\strftime; ?>
<script src="/js/my_profile_new.js"></script>
<script>
    var profile_username                   = "<?= $_PROFILE->Username ?>";

    var langs_somethingwentwrong           = "<?= $LANGS['somethingwentwrong'] ?>";
    var langs_subscribe                    = "<?= $LANGS['subscribe'] ?>";
    var langs_unsubscribe                  = "<?= $LANGS['unsubscribe'] ?>";
    var langs_addingcomment                = "<?= $LANGS['addingcomment'] ?>";
    var langs_commentposted                = "<?= $LANGS['commentposted'] ?>";
    var langs_commentspammsg               = "<?= $LANGS['commentspammsg'] ?>";
    var langs_commentspammsg2              = "<?= $LANGS['commentspammsg2'] ?>";
    var langs_postcomment                  = "<?= $LANGS['postcomment'] ?>";
    var langs_emptycomment                 = "<?= $LANGS['emptycomment'] ?>";
    var langs_flagthisvid                  = "<?= $LANGS['flagthisvid'] ?>";
    var langs_removeflag                   = "<?= $LANGS['removeflag'] ?>";
    var langs_addingcomment                = "<?= $LANGS['addingcomment'] ?>";
    var langs_posting                      = "<?= $LANGS['posting'] ?>";
    var langs_postbulletin                 = "<?= mb_strtolower((string) $LANGS['postbulletin']) ?>";
    var langs_profilechangessaved          = "<?= $LANGS['profilechangessaved'] ?>";
</script>
<?php require_once $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/header_profile_new.php" ?>
<?php if ($_USER->Logged_In and $_USER->Username == $_PROFILE->Username): ?><?php require_once $_SERVER['DOCUMENT_ROOT']."/_templates/_profile/custom.php" ?><?php endif ?>
<div id="baseDiv">
<div id="channel-body" class="jsloaded">
    <?php if($_PROFILE->Info["is_partner"] and $_PROFILE->Info["c_banner_image"]): ?>
<div class="partnerBanner">
<?php if ($_PROFILE->Info["banner_map"]): ?>
<map id="imgmap">
        <?php
        $config_bmap = HTMLPurifier_Config::createDefault();
        $config_bmap->set('HTML.Allowed', 'area[target|alt|title|href|shape|coords]');
        $config_bmap->set('AutoFormat.RemoveEmpty', false);
        $def = $config_bmap->getHTMLDefinition(true);

        $area = $def->addElement(
        'area',   // name
        'Block',  // content set
        'Empty', // don't allow children
        'Common', // attribute collection
        [ // attributes
        'name' => 'CDATA',
        'id' => 'ID',
        'alt' => 'Text',
        'coords' => 'CDATA',
        'accesskey' => 'Character',
        'nohref' => new HTMLPurifier_AttrDef_Enum(['nohref']),
        'href' => 'URI',
        'shape' => new HTMLPurifier_AttrDef_Enum(['rect','circle','poly','default']),
        'tabindex' => 'Number',
        'target' => new HTMLPurifier_AttrDef_Enum(['_blank','_self','_target','_top'])
        ]
        );
        $area->excludes = ['area' => true];
        $purifier_bmap = new HTMLPurifier($config_bmap);

        $banner_map = $purifier_bmap->purify(htmlspecialchars_decode((string) $_PROFILE->Info["banner_map"]));
        ?>
        <?= $banner_map ?>
</map>
<img usemap="#imgmap" src="<?= cache_bust($_PROFILE->Info["c_banner_image"]) ?>" width="960" height="150">
<?php elseif ($_PROFILE->Info["banner_link"]): ?>
<a href="<?= $_PROFILE->Info["banner_link"] ?>">
<img src="<?= cache_bust($_PROFILE->Info["c_banner_image"]) ?>" width="960" height="150">
</a>
<?php else: ?>
<img src="<?= cache_bust($_PROFILE->Info["c_banner_image"]) ?>" width="960" height="150">
<?php endif ?>
</div>
<?php endif ?>
	<div id="channel-base-div">
	
				<div id="user_playlist_navigator" class="outer-box">
			<div id="playnav-channel-header" class="inner-box-bg-color">
		<div id="playnav-channel-name" class="outer-box-bg-color">
			<div class="channel-thumb-holder outer-box-color-as-border-color">
				  <div class="user-thumb-semismall"><div>

    <img id="" src="<?= avatar($_PROFILE->Username) ?>" alt="">

  </div></div>

			</div>
			<?php if($_PROFILE->Info["i_title"] == null) : ?>
			<div style="float:left;padding:0.4em;">
					<div class="channel-title outer-box-color" style="display:none;" id="channel_title"></div>
					<div class="channel-title outer-box-color" style="padding:9px 0 0 0" id="channel_base_title"><?= $LANGS['chpretitle'] ?? '' ?><?= displayname($_PROFILE->Username) ?><?= $LANGS['chposttitle'] ?? '' ?></div>
			</div>
			<?php else : ?>
				<div style="float:left;padding:0.4em;">
					<div class="channel-title outer-box-color" id="channel_title"><?= $_PROFILE->Info["i_title"] ?></div>
					<div class="channel-title outer-box-color" style="font-size:11px" id="channel_base_title"><?= $PageTitle ?></div>
			</div>
			<?php endif ?>
			<div style="float:left;padding-top:10px;_display:inline" id="subscribe-buttons">
				<div id="subscribe_user_playlist_navigator" class="subscribe-div">
				<?php if(!$Is_Subscribed) : ?>
                            <div id="subscribeDiv">
                                <a class="yt-button yt-button-urgent" <?php if ($_USER->Logged_In && $_USER->Username != $_PROFILE->Username && !$_PROFILE->is_blocked($_USER)) : ?>href="javascript:void(0)" onclick="subscribe()"<?php elseif (!$_USER->Logged_In) : ?>href="/login"<?php elseif ($_PROFILE->is_blocked($_USER)) : ?>href="#" onclick='alert("You can&#39;t subscribe to this channel because you are blocked!");return false;'<?php else : ?>href="#" onclick='alert("<?= $LANGS['subyourself'] ?>");return false;'<?php endif ?>class="action-button" title="subscribe to <?= $_PROFILE->Username ?>'s videos">
                                    <span class="action-button-text" id="subscribe-button"><?= $LANGS['subscribe'] ?></span>
                                </a>
                            </div> 
                        <?php else : ?>
                            <div id="unsubscribeDiv">
                                <a class="yt-button yt-button-urgent unsubscribe" href="javascript:void(0)" onclick="subscribe()" class="action-button" title="unsubscribe from <?= $_PROFILE->Username ?>'s videos">
                                    <span class="action-button-text" id="unsubscribe-button"><?= $LANGS['unsubscribe'] ?></span>
                                </a>
                            </div>
                        <?php endif ?>
			</div>

			</div>
		</div>
		<div id="playnav-chevron">&nbsp;</div>
        <?php if ($Profile_Empty == 0): ?>
			<div id="playnav-navbar">
                    <?php if ($_PROFILE->Info["c_all"] != 0) : ?>
						<a class="navbar-tab inner-box-link-color navbar-tab-selected" id="playnav-navbar-tab-all" href="javascript:;" onmousedown="selectTab('all','<?= $_PROFILE->Username ?>');"><?= $LANGS['all'] ?></a>
                    <?php endif ?>

					<?php if ($_PROFILE->Info["c_videos_box"] != 0) : ?>
						<a class="navbar-tab inner-box-link-color <?php if ($_PROFILE->Info["c_all"] == 0) : ?> navbar-tab-selected<?php endif ?>" id="playnav-navbar-tab-uploads" href="javascript:;" onmousedown="selectTab('uploads','<?= $_PROFILE->Username ?>');"><?= $LANGS['uploads'] ?></a>
					<?php endif ?>

					<?php if ($_PROFILE->Info["c_favorites_box"] != 0) : ?>
						<a class="navbar-tab inner-box-link-color <?php if ($_PROFILE->Info["c_all"] == 0 && $_PROFILE->Info["c_videos_box"] == 0) : ?> navbar-tab-selected<?php endif ?>" id="playnav-navbar-tab-favorites" href="javascript:;" onmousedown="selectTab('favorites','<?= $_PROFILE->Username ?>');"><?= $LANGS['favorites'] ?></a>
					<?php endif ?>

					<?php if ($_PROFILE->Info["c_playlists_box"] != 0) : ?>
						<a class="navbar-tab inner-box-link-color <?php if ($_PROFILE->Info["c_all"] == 0 && $_PROFILE->Info["c_videos_box"] == 0 && $_PROFILE->Info["c_favorites_box"] == 0) : ?> navbar-tab-selected<?php endif ?>" id="playnav-navbar-tab-playlists" href="javascript:;" onmousedown="selectTab('playlists','<?= $_PROFILE->Username ?>');"><?= $LANGS['channelpl'] ?></a>
					<?php endif ?>
			</div>
        <?php else: ?>  
        <div style="float:left;padding-top: 1.2em" class="inner-box"><?= displayname($_PROFILE->Username) ?> has no videos available.</div>  
        <?php endif ?>
		
        <?php if ($Profile_Empty == 0): ?>
		<div id="playnav-navbar-toggle">
						<a title="Switch to Grid View" href="javascript:;" onmousedown="selectView('grid','<?= $_PROFILE->Username ?>');" id="gridview-icon" class="view-button">
		<div class="contents">
			<div class="a yt xl"></div>
			<div class="a yt xc"></div>
			<div class="a yt xr"></div>
			<div class="a yc xl"></div>
			<div class="a yc xc"></div>
			<div class="a yc xr"></div>
			<div class="a yb xl"></div>
			<div class="a yb xc"></div>
			<div class="a yb xr"></div>
		</div>
	</a>
		<a title="Switch to Player View" href="javascript:;" onmousedown="selectView('play','<?= $_USER->Username ?>');" id="playview-icon" class="view-button view-button-selected">
		<div class="contents">
			<div class="a box"></div>		
			<div class="a tri"></div>
			<div class="a yt"></div>
			<div class="a yc"></div>
			<div class="a yb"></div>
		</div>
	</a>
    <?php if ($_PROFILE->Username == $_USER->Username): ?>
    <a href="#" onclick="document.getElementById('playnav-channel-header').classList.add('edit_mode');return false;" style="float:right;margin-right: 16px;border-bottom: 1px dotted;text-decoration: none;"><?= mb_strtolower((string) $LANGS['edit']) ?></a>
    <?php endif ?>


		</div>
    <?php endif?>
		<div class="cb"></div>
        <img src="/img/pixel.gif" class="edit-widget">
		<div class="edit_info">
    <form action="/user/<?= $_PROFILE->Username ?>" method="POST">
    <div class="edit_top_box">
        <div id="display_settings_box" style="width: 30%;padding: 1em;float: left;zoom: 1;">
        <div>
<?= $LANGS['whichcontent'] ?>
        </div>
        <div id="edit_display_settings">
        <div style="width:92%;padding:0.5em;border:1px solid #ccc;overflow:auto;background-color:#fff">
                <label>
                    <input id="display_uploads" type="checkbox" name="box_uploads" <?php if ($_PROFILE->Info['c_videos_box'] == 1): ?>checked=""<?php endif?>><?= $LANGS['myuploadedvideos'] ?></label><br>
                <label>
                    <input id="display_favorites" type="checkbox" name="box_favorites" <?php if ($_PROFILE->Info['c_favorites_box'] == 1): ?>checked=""<?php endif?>><?= $LANGS['myfavorites'] ?></label><br>
                <label>
                    <input id="display_playlists" type="checkbox"name="box_playlists" <?php if ($_PROFILE->Info['c_playlists_box'] == 1): ?>checked=""<?php endif?>><?= $LANGS['playlists'] ?></label>
            </div>
        <div style="padding:0.25em" id="display_all_container">
                                <label>
                                        <input id="display_all" type="checkbox" name="box_all" <?php if ($_PROFILE->Info['c_all'] == 1): ?>checked=""<?php endif?>><?= $LANGS['alsoshowall'] ?>                            </label>
                        </div>
        </div>
    </div>
        <div id="featured_content_edit" style="width: 30%;padding: 1em;border-left: 1px dotted #bbb;border-right: 1px dotted #bbb;float: left;">
                        <div style="padding-top: 1em">
<?= $LANGS['featuredvideo'] ?><br><?php $Videos_List = $DB->execute("SELECT * FROM videos WHERE uploaded_by = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL ORDER BY videos.uploaded_on DESC",false,[":USERNAME" => $_PROFILE->Username]); ?>
                                <div id="featured_vid_select_box">
                                        <select name="box_featured_video_id" style="width:200px">
                                                <option value="00000000000"><?= $LANGS['usemostrecent'] ?></option>
                                                <?php foreach ($Videos_List as $Video): ?>
                                                <option value="<?= $Video['url'] ?>" <?php if ($Video['url'] == $_PROFILE->Info['c_featured_video']): ?>selected = ""<?php endif ?>><?= $Video['title'] ?></option>
                                                <?php endforeach ?>
                                        </select>
                                </div>
                                <br>
                                <input type="text" id="featured_video_url" name="featured_video_url" value="Copy and paste a video URL here" style="color:#999;margin-top:6px" class="playnav-edit-field hid">
                        </div>
                                <div style="padding-top:0.6em">
                                        <label><input type="checkbox" name="box_autoplay" <?php if ($_PROFILE->Info['c_autoplay'] == 1): ?>checked=""<?php endif?>><?= $LANGS['autoplayfeatured'] ?>
                                        </label>
                                </div>
                </div>
        <div class="edit_separator"></div>
            <div class="user_play_save_cancel" style="position:relative">
        <button type="submit" class=" yt-uix-button yt-uix-button-primary" name="save_box_settings_user_play"><span class="yt-uix-button-content"><?= $LANGS['editsavechanges'] ?></span></button>
<?= $LANGS['or'] ?>
        <a href="#" onclick="document.getElementById('playnav-channel-header').classList.remove('edit_mode');return false;"><?= $LANGS['editcancel'] ?></a>
        <div class="save_overlay" style="padding:0.4em;padding-left:3em;width:60%">
            <img src="/img/icn_loading_animated.gif">
        </div>
    </div>

    </div>
    </form>
        </div>
	</div>
	<div id="subscribeMessage" class="hid">&nbsp;</div>

		<div id="user_playlist_navigator-messages" style="color:#333;display:none"></div>

			<div id="playnav-body">
				
	<div id="playnav-player" class="playnav-player-container" style="visibility:visible">
		<div id="profile-player-div">
			<?php if (isset($LatVideo) && $LatVideo > 0) : ?>
    		<?php foreach ($LatVideo as $Video) : ?>
    			<?php
                $_VIDEO = new Video($Video["url"],$DB);

                if ($_VIDEO->exists()) {
                $_VIDEO->get_info();
                } 
                ?>
            <?php $_VIDEO->show_video(640, 360, true, $LANGS) ?>
        <?php endforeach ?>
    <?php endif ?>
    </div>
		</div>
				<div id="playnav-playview" class="" style="display: block;">
					<div id="playnav-left-panel">
						<div class="playnav-player-container"></div>
						<div id="playnav-video-details">
								<div id="playnav-bottom-links">
		<div id="playnav-bottom-links-clip" style="font-family: Arial,sans-serif;">
			<table><tbody><tr>
					<td id="playnav-panel-tab-info" class="panel-tab-selected">
		
	
		<table class="panel-tabs">
			<tbody><tr>
				<td class="panel-tab-title-cell <?php if ($LangCode == "es-ES"): ?>es_ES<?php elseif ($LangCode == "es-MX"): ?>es_MX<?php elseif ($LangCode == "pt-BR"): ?>pt_BR<?php elseif ($LangCode == "ru"): ?>ru_RU<?php endif?>">
					<div class="playnav-panel-tab-icon" id="panel-icon-info" onmouseover="addclass('playnav-panel-tab-info', 'panel-tab-hovered')" onmouseout="removeclass('playnav-panel-tab-info', 'panel-tab-hovered')" onmousedown="selectPanel('info','<?= $Video['url'] ?? '' ?>')"></div>
					<div class="playnav-bottom-link" id="info-bottom-link">
						<a href="javascript:;" onmouseover="addclass('playnav-panel-tab-info', 'panel-tab-hovered')" onmouseout="removeclass('playnav-panel-tab-info', 'panel-tab-hovered')" onmousedown="selectPanel('info','<?= $Video['url'] ?? '' ?>')"><?= $LANGS['info'] ?></a>
					</div>
					<div class="spacer">&nbsp;</div>
				</td>
			</tr>
			<tr>
				<td class="panel-tab-indicator-cell inner-box-opacity">
					<div class="panel-tab-indicator-arrow"></div>
				</td>
			</tr>
		</tbody></table>
	</td>

				
						<td id="playnav-panel-tab-comments">
		
	
		<table class="panel-tabs">
			<tbody><tr>
				<td class="panel-tab-title-cell <?php if ($LangCode == "es-ES"): ?>es_ES<?php elseif ($LangCode == "es-MX"): ?>es_MX<?php elseif ($LangCode == "pt-BR"): ?>pt_BR<?php elseif ($LangCode == "ru"): ?>ru_RU<?php endif?>">
					<div class="playnav-panel-tab-icon" id="panel-icon-comments" onmouseover="addclass('playnav-panel-tab-comments', 'panel-tab-hovered')" onmouseout="removeclass('playnav-panel-tab-comments', 'panel-tab-hovered')" onmousedown="selectPanel('comments','<?= $Video['url'] ?? '' ?>')"></div>
					<div class="playnav-bottom-link" id="comments-bottom-link">
						<a href="javascript:;" onmouseover="addclass('playnav-panel-tab-comments', 'panel-tab-hovered')" onmouseout="removeclass('playnav-panel-tab-comments', 'panel-tab-hovered')" onmousedown="selectPanel('comments','<?= $Video['url'] ?? '' ?>')"><?= $LANGS['statcomments'] ?></a>
					</div>
					<div class="spacer">&nbsp;</div>
				</td>
			</tr>
			<tr>
				<td class="panel-tab-indicator-cell inner-box-opacity">
					<div class="panel-tab-indicator-arrow"></div>
				</td>
			</tr>
		</tbody></table>
	</td>

				
					<td id="playnav-panel-tab-favorite">
		
	
		<table class="panel-tabs">
			<tbody><tr>
				<td class="panel-tab-title-cell <?php if ($LangCode == "es-ES"): ?>es_ES<?php elseif ($LangCode == "es-MX"): ?>es_MX<?php elseif ($LangCode == "pt-BR"): ?>pt_BR<?php elseif ($LangCode == "ru"): ?>ru_RU<?php endif?>">
					<div class="playnav-panel-tab-icon" id="panel-icon-favorite" onmouseover="addclass('playnav-panel-tab-favorite', 'panel-tab-hovered')" onmouseout="removeclass('playnav-panel-tab-favorite', 'panel-tab-hovered')" onmousedown="selectPanel('favorite','<?= $Video['url'] ?? '' ?>')"></div>
					<div class="playnav-bottom-link" id="favorite-bottom-link">
						<a href="javascript:;" onmouseover="addclass('playnav-panel-tab-favorite', 'panel-tab-hovered')" onmouseout="removeclass('playnav-panel-tab-favorite', 'panel-tab-hovered')" onmousedown="selectPanel('favorite','<?= $Video['url'] ?? '' ?>')"><?= $LANGS['favorite'] ?></a>
					</div>
					<div class="spacer">&nbsp;</div>
				</td>
			</tr>
			<tr>
				<td class="panel-tab-indicator-cell inner-box-opacity">
					<div class="panel-tab-indicator-arrow"></div>
				</td>
			</tr>
		</tbody></table>
	</td>

					<td id="playnav-panel-tab-share">
		
	
		<table class="panel-tabs">
			<tbody><tr>
				<td class="panel-tab-title-cell <?php if ($LangCode == "es-ES"): ?>es_ES<?php elseif ($LangCode == "es-MX"): ?>es_MX<?php elseif ($LangCode == "pt-BR"): ?>pt_BR<?php elseif ($LangCode == "ru"): ?>ru_RU<?php endif?>">
					<div class="playnav-panel-tab-icon" id="panel-icon-share" onmouseover="addclass('playnav-panel-tab-share', 'panel-tab-hovered')" onmouseout="removeclass('playnav-panel-tab-share', 'panel-tab-hovered')"></div>
					<div class="playnav-bottom-link" id="share-bottom-link">
						<a href="javascript:;" onmouseover="addclass('playnav-panel-tab-share', 'panel-tab-hovered')" onmouseout="removeclass('playnav-panel-tab-share', 'panel-tab-hovered')" onmousedown="selectPanel('share','<?= $Video['url'] ?? '' ?>')"><?= $LANGS['share'] ?></a>
					</div>
					<div class="spacer">&nbsp;</div>
				</td>
			</tr>
			<tr>
				<td class="panel-tab-indicator-cell inner-box-opacity">
					<div class="panel-tab-indicator-arrow"></div>
				</td>
			</tr>
		</tbody></table>
	</td>

					<td id="playnav-panel-tab-playlists">
		
	
		<table class="panel-tabs">
			<tbody><tr>
				<td class="panel-tab-title-cell <?php if ($LangCode == "es-ES"): ?>es_ES<?php elseif ($LangCode == "es-MX"): ?>es_MX<?php elseif ($LangCode == "pt-BR"): ?>pt_BR<?php elseif ($LangCode == "ru"): ?>ru_RU<?php endif?>">
					<div class="playnav-panel-tab-icon" id="panel-icon-playlists" onmouseover="addclass('playnav-panel-tab-playlists', 'panel-tab-hovered')" onmouseout="removeclass('playnav-panel-tab-playlists', 'panel-tab-hovered')"></div>
					<div class="playnav-bottom-link" id="playlists-bottom-link">
						<a href="javascript:;" onmouseover="addclass('playnav-panel-tab-playlists', 'panel-tab-hovered')" onmouseout="removeclass('playnav-panel-tab-playlists', 'panel-tab-hovered')" onmousedown="selectPanel('playlists','<?= $Video['url'] ?? '' ?>')"><?= $LANGS['playlists'] ?></a>
					</div>
					<div class="spacer">&nbsp;</div>
				</td>
			</tr>
			<tr>
				<td class="panel-tab-indicator-cell inner-box-opacity">
					<div class="panel-tab-indicator-arrow"></div>
				</td>
			</tr>
		</tbody></table>
	</td>

					<td id="playnav-panel-tab-flag">
		
	
		<table class="panel-tabs">
			<tbody><tr>
				<td class="panel-tab-title-cell <?php if ($LangCode == "es-ES"): ?>es_ES<?php elseif ($LangCode == "es-MX"): ?>es_MX<?php elseif ($LangCode == "pt-BR"): ?>pt_BR<?php elseif ($LangCode == "ru"): ?>ru_RU<?php endif?>">
					<div class="playnav-panel-tab-icon" id="panel-icon-flag" onmouseover="addclass('playnav-panel-tab-flag', 'panel-tab-hovered')" onmouseout="removeclass('playnav-panel-tab-flag', 'panel-tab-hovered')" onmousedown="selectPanel('flag','<?= $Video['url'] ?? '' ?>')"></div>
					<div class="playnav-bottom-link" id="flag-bottom-link">
						<a href="javascript:;" onmouseover="addclass('playnav-panel-tab-flag', 'panel-tab-hovered')" onmouseout="removeclass('playnav-panel-tab-flag', 'panel-tab-hovered')" onmousedown="selectPanel('flag','<?= $Video['url'] ?? '' ?>')"><?= $LANGS['flag'] ?></a>
					</div>
					<div class="spacer">&nbsp;</div>
				</td>
			</tr>
			<tr>
				<td class="panel-tab-indicator-cell inner-box-opacity">
					<div class="panel-tab-indicator-arrow"></div>
				</td>
			</tr>
		</tbody></table>
	</td>

			</tr></tbody></table>
		</div>
		
		<div class="cb"></div>
		
		<div class="playnav-video-panel inner-box-colors border-box-sizing">
            <?php if ($Profile_Empty == 0 && isset($_VIDEO)): ?>
			<div id="playnav-video-panel-inner" class="border-box-sizing">
				<div id="playnav-panel-info" class="scrollable">
						<div id="playnav-curvideo-rating">
        <?php if (isset($_VIDEO)) { $_UPLOADER = new User($_VIDEO->Info['uploaded_by'],$DB); } ?>
        <?php if (isset($_UPLOADER) && !$_UPLOADER->is_blocked($_USER)) : ?>
        <div id="channel-like-action">
            <div id="channel-like-buttons">
                <?php if (isset($_VIDEO) && $_USER->Logged_In) { $Rated = $_USER->has_rated($_VIDEO); }
                        else { $Rated = false; } ?>
                <button id="watch-like" class="<?php if ($Rated >= 3): ?>active <?php endif ?>master-sprite-new yt-uix-button yt-uix-tooltip" title="<?= $LANGS['liketooltip'] ?>" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" <?php if ($_USER->Logged_In): ?>onclick="like(); return false;"<?php else: ?>onclick="window.location.href = '/login'; return false;"<?php endif ?> type="button">
                    <img class="yt-uix-button-icon-watch-like" src="/img/pixel.gif" alt="">
                <span class="yt-uix-button-content"><?= $LANGS['like'] ?></span>
                </button>
                <button id="watch-unlike" class="<?php if ($Rated <= 2 && $Rated > 0): ?>active <?php endif ?>master-sprite-new yt-uix-button yt-uix-tooltip" onmouseover="showTooltip(this);" onmouseout="hideTooltip();" title="<?= $LANGS['disliketooltip'] ?>" <?php if ($_USER->Logged_In): ?>onclick="dislike(); return false;"<?php else: ?>onclick="window.location.href = '/login'; return false;"<?php endif ?> type="button">
                    <img class="yt-uix-button-icon-watch-unlike" src="/img/pixel.gif" alt="">
                </button>
            </div>
            <form method="post" action="" name="likeForm" class="hid">
                <input type="hidden" id="like_video_id" value="<?= $Video['url'] ?>">
            </form>
        </div>
        <?php endif ?>
	</div>
	<div id="playnav-curvideo-title" class="inner-box-title">

		<span style="cursor:pointer;margin-right:7px" onclick="document.location.href='/watch?v=<?= $Video["url"] ?? '' ?>'" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
			<?= $Video['title'] ?? '' ?>
		</span>
	</div>
			
	
	<div id="playnav-curvideo-info-line">
		
		<?= $LANGS['from'] ?>: <span id="playnav-curvideo-channel-name"><a href="/user/<?= $Video['uploaded_by'] ?? '' ?>"><?= displayname($Video['uploaded_by'] ?? '') ?></a></span>&nbsp;|
		<?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['longtimeformat'], time_machine(strtotime((string) ($_VIDEO->Info["uploaded_on"] ?? '')))); }
                    else {echo strftime($LANGS['longtimeformat'], strtotime((string) ($_VIDEO->Info["uploaded_on"] ?? ''))); }  ?>&nbsp;|
		<span id="playnav-curvideo-view-count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"] ?? 0) ?><?php else: ?><?= ($Video["views"] ?? 0) ?><?php endif ?> <?= $LANGS['videoviews'] ?></span>
	</div>

	<div class="cb"></div>
	
	<div id="playnav-curvideo-description-container">
		<div id="playnav-curvideo-description"><?= nl2br((string) short_title($Video['description'] ?? '', 100)) ?>
			<div id="playnav-curvideo-description-more-holder">		
				<div class="cb"></div>			
			</div>
		</div>
	</div>
	
	<a href="/watch?v=<?= $Video["url"] ?? '' ?>" id="playnav-watch-link" onclick="playnav.goToWatchPage()"><?= $LANGS['viewcomments'] ?></a>
	
	
	<div id="playnav-curvideo-controls">
	</div>
	
	<div class="cb"></div>
	<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_companion_ad.js"></script>

				</div>

					<div id="playnav-panel-comments" class="hid"></div>

				<div id="playnav-panel-favorite" class="hid"></div>
				<div id="playnav-panel-share" class="hid scrollable"></div>
				<div id="playnav-panel-playlists" class="hid"></div>
				<div id="playnav-panel-flag" class="hid"></div>
			</div>
        <?php endif ?>
			<div id="playnav-video-panel-loading" style="display: none;">
				<div class="image-holder">
		<div class="image-holder-middle">
			<div class="image-holder-inner">
				<img src="/img/icn_loading_animated.gif">
			</div>
		</div>
	</div>
			</div>
		</div>
	</div>

						</div>
					</div>
						<div id="playnav-play-panel">

        <?php if ($_PROFILE->Info['c_all'] != 0): ?>
		<div id="playnav-play-content" style="height: 595px;">	
				<div class="playnav-playlist-holder" id="playnav-play-playlist-all-holder">
										
	<div id="playnav-play-all-scrollbox" class="scrollbox-wrapper inner-box-colors">
        <?php if ($Profile_Empty == 0): ?>
		<div class="scrollbox-content playnav-playlist-all">
			
			<div class="scrollbox-body" style="height: 585px; zoom: 1;">
				<div class="outer-scrollbox">
					<div id="playnav-play-all-items" class="inner-scrollbox">
		<?php if ($_PROFILE->Info["c_videos_box"] != 0) : ?>				
		<input type="hidden" id="playnav-playlist-uploads-count" value="<?= $_PROFILE->Info["videos"] ?>">
			<div class="playnav-playlist-header">
			<a href="javascript:;" style="text-decoration:none" onclick="selectTab('uploads','<?= $_PROFILE->Username ?>');return false;" class="title title-text-color">
				<span id="playnav-playlist-uploads-all-title" class="title"><?= $LANGS['uploads'] ?></span>
					(<?= $_PROFILE->Info["videos"] ?>)
			</a>
		
		
	</div>
    <?php if ($Videos): ?>
        <?php $Count = 0 ?>
	<?php foreach ($Videos as $Video) : ?>
        <?php $Count++ ?>
        <div id="playnav-video-play-uploads-all-<?= $Count ?>-<?= $Video['url'] ?>" class="playnav-item playnav-video <?php if (isset($LatVideo) && ($LatVideo[0]['url'] ?? '') == $Video['url']): ?>playnav-item-selected<?php endif?>">
		<div style="display:none" class="encryptedVideoId"><?= $Video['url'] ?></div>

		<div id="playnav-video-play-uploads-all-<?= $Count ?>-<?= $Video['url'] ?>-selector" class="selector"></div>
		<div class="content">
			<div class="playnav-video-thumb link-as-border-color">
				<a class="video-thumb-90 no-quicklist" href="/watch?v=<?= $Video['url'] ?>" onclick="playVideo('uploads-all','<?= $Count ?>','<?= $Video['url'] ?>');return false;"><img title="<?= $Video["title"] ?>" src="<?= $Video["thumb"] ?>" class="vimg90 yt-uix-hovercard-target" alt="<?= $Video["title"] ?>"></a>
			</div>
			<div class="playnav-video-info">
				<a href="/watch?v=<?= $Video['url'] ?>" class="playnav-item-title ellipsis" onclick="playVideo('uploads-all','<?= $Count ?>','<?= $Video['url'] ?>');return false;" id="playnav-video-title-play-uploads-all-<?= $Count ?>-<?= $Video['url'] ?>"><span><?= $Video["title"] ?></span></a>
				<div class="metadata">
						<?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?>  -  <?= get_time_ago($Video["uploaded_on"]) ?>	
				</div>
				<div style="display:none" id="playnav-video-play-uploads-all-<?= $Count ?>"><?= $Video['url'] ?></div>	
			</div>
		</div>
	</div>
    <?php endforeach ?>
    <?php endif ?>
		<div class="playnav-play-column-all">
				<div class="playnav-more"><a class="channel-cmd" href="javascript:;" onclick="selectTab('uploads','<?= $_PROFILE->Username ?>');return false;"><?= $LANGS['seeall'] ?></a></div>
		</div>
		<div class="spacer">&nbsp;</div>
			<div class="scrollbox-separator">
		<div class="outer-box-bg-as-border"></div>
	</div>
<?php endif ?>
	<?php if ($_PROFILE->Info["c_favorites_box"] != 0) : ?>
		<input type="hidden" id="playnav-playlist-favorites-count" value="<?= count($FavVideos) ?>">
			<div class="playnav-playlist-header">
			<a href="javascript:;" style="text-decoration:none" onclick="selectTab('favorites','<?= $_PROFILE->Username ?>');return false;" class="title title-text-color">
				<span id="playnav-playlist-favorites-all-title" class="title"><?= $LANGS['favorites'] ?></span>
					(<?= count($FavVideos) ?>)
			</a>
	</div>
    <?php if ($FavVideos): ?>
        <?php $Count = 0 ?>
	<?php foreach ($FavVideos as $Video) : ?>
        <?php $Count++ ?>
        <div id="playnav-video-play-favorites-all-<?= $Count ?>-<?= $Video['url'] ?>" class="playnav-item playnav-video">
		<div style="display:none" class="encryptedVideoId"><?= $Video['url'] ?></div>
		<div id="playnav-video-play-favorites-all-<?= $Count ?>-<?= $Video['url'] ?>-selector" class="selector"></div>
		<div class="content">
			<div class="playnav-video-thumb link-as-border-color">
				<a class="video-thumb-90 no-quicklist" href="/watch?v=<?= $Video['url'] ?>" onclick="playVideo('favorites-all','<?= $Count ?>','<?= $Video['url'] ?>');return false;"><img title="<?= $Video['title'] ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg90 yt-uix-hovercard-target" alt="<?= $Video['title'] ?>"></a>
			</div>
			<div class="playnav-video-info">
				<a href="/watch?v=<?= $Video['url'] ?>" class="playnav-item-title ellipsis" onclick="playVideo('favorites-all','<?= $Count ?>','<?= $Video['url'] ?>');return false;" id="playnav-video-title-play-favorites-all-<?= $Count ?>-<?= $Video['url'] ?>"><span><?= $Video['title'] ?></span></a>
				<div class="metadata">
						<span class="playnav-video-username"><a title="Play video" href="/user/<?= $Video['uploaded_by'] ?>"><?= short_title(displayname($Video['uploaded_by']),12) ?></a></span>  -  <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?>
				</div>
				
				<div style="display:none" id="playnav-video-play-favorites-all-<?= $Count ?>"><?= $Video['url'] ?></div>					
			</div>
		</div>
	</div>
    <?php endforeach ?>
    <?php endif ?>
		<div class="playnav-play-column-all">
				<div class="playnav-more"><a class="channel-cmd" href="javascript:;" onclick="selectTab('favorites','<?= $_PROFILE->Username ?>'); return false;"><?= $LANGS['seeall'] ?></a></div>
		</div>
		<div class="spacer">&nbsp;</div>
			<div class="scrollbox-separator">
		<div class="outer-box-bg-as-border"></div>
	</div>
<?php endif ?>
	<?php if ($_PROFILE->Info["c_playlists_box"] != 0) : ?>
	<input type="hidden" id="playnav-playlist-playlists-count" value="<?= $Playlists_Amount ?>">
			<div class="playnav-playlist-header">
			<a href="javascript:;" style="text-decoration:none" onclick="selectTab('playlists','<?= $_PROFILE->Username ?>');return false;" class="title title-text-color">
				<span id="playnav-playlist-playlists-all-title" class="title"><?= $LANGS['playlists'] ?></span>
					(<?= $Playlists_Amount ?>)
			</a>
	</div>
    <?php if ($Playlists): ?>
        <?php $Count = 0 ?>
	<?php foreach ($Playlists as $Playlist) : ?>
        <?php $Count++ ?>
        <?php
                    $Videos = $DB->execute("SELECT url FROM playlists_videos WHERE playlist_id = :ID ORDER BY position ASC",false,array(":ID" => $Playlist["id"]));
                    if ($Videos) {
                        if (isset($Videos[0])) {
                            $Video1 = $Videos[0]["url"];
                        }
                    } else {
                        $Video1 = false;
                        $Video2 = false;
                        $Video3 = false;
                    }

                ?>
        <div id="playnav-video-play-playlists-all-<?= $Count ?>-<?= $Playlist['id'] ?>" class="playnav-item playnav-playlist">
		<div style="display:none" class="encryptedVideoId"><?= $Playlist['id'] ?></div>
		<div id="playnav-video-play-playlists-all-<?= $Count ?>-<?= $Playlist['id'] ?>-selector" class="selector"></div>
		<div class="content">
			<div class="vCluster120WideEntry"><div class="vCluster120WrapperOuter"><div class="vCluster120WrapperInner"><a id="video-url" onclick="open_playlist('playlists','<?= $Count ?>','<?= $Playlist['id'] ?>');return false;" href="/view_playlist?id=<?= $Playlist["id"] ?>" rel="nofollow"><img title="<?= $Playlist["title"] ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video1.'.jpg')): ?>src="/u/thmp/<?= $Video1 ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimgCluster120" alt="<?= $Playlist["title"] ?>"></a><div class="video-corner-text"><span><?= $DB->execute("SELECT count(url) as amount FROM playlists_videos WHERE playlist_id = :ID", true, [":ID" => $Playlist["id"]])["amount"] ?> <?= $LANGS['plvideoamount'] ?></span></div></div></div></div>
			<div class="playnav-video-info">
				<a href="/view_playlist?id=<?= $Playlist['id'] ?>" class="playnav-item-title ellipsis" onclick="open_playlist('playlists-all','<?= $Count ?>','<?= $Playlist['id'] ?>');return false;" id="playnav-video-title-play-playlists-all-<?= $Count ?>-<?= $Playlist['id'] ?>"><span><?= $Playlist['title'] ?></span></a>
				<div class="metadata">
						<span class="playnav-video-username"><?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['longtimeformat'], time_machine(strtotime((string) $Playlist["submit_date"]))); }
                    else {echo strftime($LANGS['longtimeformat'], strtotime((string) $Playlist["submit_date"])); }  ?></span>
				</div>
                    <a href="/view_playlist?id=<?= $Playlist['id'] ?>"><?= $LANGS['moreinfo'] ?></a>
				
				<div style="display:none" id="playnav-video-play-playlists-all-<?= $Count ?>"><?= $Playlist['id'] ?></div>					
			</div>
		</div>
	</div>
    <?php endforeach ?>
    <?php endif ?>

		<div class="playnav-play-column-all">
				<div class="playnav-more"><a class="channel-cmd" href="javascript:;" onclick="selectTab('playlists','<?= $_PROFILE->Username ?>'); return false;"><?= $LANGS['seeall'] ?></a></div>
		</div>
	<?php endif ?>
					</div>
				</div>
			</div>
		</div>
    <?php endif?>
	</div>



				</div>
		</div>
    <?php endif?>
    <?php if ($_PROFILE->Info['c_all'] == 0 && $_PROFILE->Info['c_videos_box'] != 0): ?>
        <?php $Videos = $DB->execute("SELECT * FROM videos WHERE uploaded_by = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL ORDER BY videos.uploaded_on DESC LIMIT 10",false,[":USERNAME" => $_PROFILE->Username]); ?>
        <div id="playnav-play-content" style="height: 595px;">  
                <div class="playnav-playlist-holder" id="playnav-play-playlist-uploads-holder">        
    <div id="playnav-play-uploads-scrollbox" class="scrollbox-wrapper inner-box-colors">
            <input type="hidden" id="playnav-playlist-uploads-count" value="90">
        <div class="scrollbox-content playnav-playlist-non-all">
                <div class="scrollbox-header">
        <div class="playnav-playlist-header">
            
    <div class="search-box">
        <input type="text" id="upload_search_query-play" class="box-outline-color" style="width:120px;border-width:1px;border-style:solid;padding: 1px" onkeypress="if (event.keyCode == 13) { searchChannel('upload_search_query-play','<?= $_PROFILE->Username ?>'); }">
        &nbsp;
            <a class="yt-button" id="" style="height: 21px;vertical-align: middle;line-height: 21px;" href="javascript:;" onclick="searchChannel('upload_search_query-play','<?= $_PROFILE->Username ?>');return false"><span><?= $LANGS['search'] ?></span></a>
    </div>

                <div style="display:none" id="uploads-sort">date</div>
    <div class="sorters">
        
    
        <a style="" href="javascript:;" onmousedown="sortVideos('date','<?= $_PROFILE->Username ?>')"><?= $LANGS['sortdateadded'] ?></a>
    

        |
        
    
        <a style="" href="javascript:;" onmousedown="sortVideos('popularity','<?= $_PROFILE->Username ?>')"><?= $LANGS['mostviewed'] ?></a>
    

        |
        
    
        <a style="" href="javascript:;" onmousedown="sortVideos('rating','<?= $_PROFILE->Username ?>')"><?= $LANGS['toprated'] ?></a>
    
 
         
    </div>

            <div class="spacer">&nbsp;</div>

        </div>
            <div class="scrollbox-separator">
        <div class="outer-box-bg-as-border"></div>
    </div>

    </div>

            <div class="scrollbox-body" style="height: 507px; zoom: 1;">
                <div class="outer-scrollbox" onscroll="loadVideos('uploads', 2, '<?= $_PROFILE->Username ?>', 'date');">
                    <div id="playnav-play-uploads-items" class="inner-scrollbox">
                                <div id="playnav-play-uploads-page-0" class="scrollbox-page loaded videos-rows-12" style="visibility: visible;">
    <?php foreach ($Videos as $Video) : ?>
        <?php $Count++ ?>
        <div id="playnav-video-play-uploads-<?= $Count ?>-<?= $Video['url'] ?>" class="playnav-item playnav-video <?php if ($LatVideo[0]['url'] == $Video['url']): ?>playnav-item-selected<?php endif?>">
        <div style="display:none" class="encryptedVideoId"><?= $Video['url'] ?></div>

        <div id="playnav-video-play-uploads-<?= $Count ?>-<?= $Video['url'] ?>-selector" class="selector"></div>
        <div class="content">
            <div class="playnav-video-thumb link-as-border-color">
                <a class="video-thumb-90 no-quicklist" href="/watch?v=<?= $Video['url'] ?>" onclick="playVideo('uploads','<?= $Count ?>','<?= $Video['url'] ?>');return false;"><img title="<?= $Video["title"] ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg90 yt-uix-hovercard-target" alt="<?= $Video["title"] ?>"></a>
            </div>
            <div class="playnav-video-info">
                <a href="/watch?v=<?= $Video['url'] ?>" class="playnav-item-title ellipsis" onclick="playVideo('uploads','<?= $Count ?>','<?= $Video['url'] ?>');return false;" id="playnav-video-title-play-uploads-<?= $Count ?>-<?= $Video['url'] ?>"><span><?= $Video["title"] ?></span></a>
                <div class="metadata">
                        <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?>  -  <?= get_time_ago($Video["uploaded_on"]) ?>   
                </div>
                <div style="display:none" id="playnav-video-play-uploads-<?= $Count ?>"><?= $Video['url'] ?></div>  
            </div>
        </div>
    </div>
    <?php endforeach ?>
    <?php if ($Videos_Page_Amount > 1): ?><div class="alignC" id="show-more-2"><b><a href="#" onclick="loadVideos('uploads', 2, '<?= $_PROFILE->Username ?>', 'date');return false;">Show More</a></b></div><?php endif ?>
                                </div>         
                    </div>
                </div>
            </div>
        </div>
    </div>
                </div>
        </div>
    <?php endif ?>
    <?php if ($_PROFILE->Info['c_all'] == 0 && $_PROFILE->Info['c_videos_box'] == 0 && $_PROFILE->Info['c_favorites_box'] != 0): ?>
    <?php $FavVideos = $DB->execute("SELECT * FROM videos RIGHT JOIN videos_favorites ON videos_favorites.url = videos.url WHERE videos_favorites.username = :USERNAME AND status = 2 AND privacy = 1 AND is_deleted IS NULL AND uploaded_by_banned = 0 ORDER BY videos_favorites.submit_on DESC LIMIT 10",false,[":USERNAME" => $_PROFILE->Username]);?>
        <div id="playnav-play-content" style="height: 595px;">  
                <div class="playnav-playlist-holder" id="playnav-play-playlist-favorites-holder">        
    <div id="playnav-play-favorites-scrollbox" class="scrollbox-wrapper inner-box-colors">
            <input type="hidden" id="playnav-playlist-favorites-count" value="90">
        <div class="scrollbox-content playnav-playlist-non-all">
            <div class="scrollbox-body" style="height: 585px; zoom: 1;">
                <div class="outer-scrollbox" onscroll="loadVideos('favorites', 2, '<?= $_PROFILE->Username ?>', 'date');">
                    <div id="playnav-play-favorites-items" class="inner-scrollbox">
                                <div id="playnav-play-favorites-page-0" class="scrollbox-page loaded videos-rows-12" style="visibility: visible;">
    <?php foreach ($FavVideos as $Video) : ?>
        <?php $Count++ ?>
        <div id="playnav-video-play-favorites-<?= $Count ?>-<?= $Video['url'] ?>" class="playnav-item playnav-video <?php if ($LatVideo[0]['url'] == $Video['url']): ?>playnav-item-selected<?php endif?>">
        <div style="display:none" class="encryptedVideoId"><?= $Video['url'] ?></div>

        <div id="playnav-video-play-favorites-<?= $Count ?>-<?= $Video['url'] ?>-selector" class="selector"></div>
        <div class="content">
            <div class="playnav-video-thumb link-as-border-color">
                <a class="video-thumb-90 no-quicklist" href="/watch?v=<?= $Video['url'] ?>" onclick="playVideo('favorites','<?= $Count ?>','<?= $Video['url'] ?>');return false;"><img title="<?= $Video["title"] ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg90 yt-uix-hovercard-target" alt="<?= $Video["title"] ?>"></a>
            </div>
            <div class="playnav-video-info">
                <a href="/watch?v=<?= $Video['url'] ?>" class="playnav-item-title ellipsis" onclick="playVideo('favorites','<?= $Count ?>','<?= $Video['url'] ?>');return false;" id="playnav-video-title-play-favorites-<?= $Count ?>-<?= $Video['url'] ?>"><span><?= $Video["title"] ?></span></a>
                <div class="metadata">
                        <span class="playnav-video-username"><a title="Play video" href="/user/<?= $Video['uploaded_by'] ?>"><?= short_title(displayname($Video['uploaded_by']),12) ?></a></span>  -  <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?>
                </div>
                <div style="display:none" id="playnav-video-play-favorites-<?= $Count ?>"><?= $Video['url'] ?></div>  
            </div>
        </div>
    </div>
    <?php endforeach ?>
    <?php if ($Favorites_Page_Amount > 1): ?><div class="alignC" id="show-more-2"><b><a href="#" onclick="loadVideos('favorites', 2, '<?= $_PROFILE->Username ?>', 'date');return false;">Show More</a></b></div><?php endif ?>
                                </div>         
                    </div>
                </div>
            </div>
        </div>
    </div>
                </div>
        </div>
    <?php endif ?>
    <?php if ($_PROFILE->Info['c_all'] == 0 && $_PROFILE->Info['c_videos_box'] == 0 && $_PROFILE->Info['c_favorites_box'] == 0 && $_PROFILE->Info['c_playlists_box'] != 0): ?>
    <?php $Playlists_2 = $DB->execute("SELECT * FROM playlists WHERE by_user = :USERNAME ORDER BY playlists.title ASC",false,[":USERNAME" => $_PROFILE->Username]); ?>
        <div id="playnav-play-content" style="height: 595px;">  
                <div class="playnav-playlist-holder" id="playnav-play-playlist-favorites-holder">        
    <div id="playnav-play-favorites-scrollbox" class="scrollbox-wrapper inner-box-colors">
            <input type="hidden" id="playnav-playlist-favorites-count" value="90">
        <div class="scrollbox-content playnav-playlist-non-all">
            <div class="scrollbox-body" style="height: 585px; zoom: 1;">
                <div class="outer-scrollbox">
                    <div id="playnav-play-favorites-items" class="inner-scrollbox">
                                <div id="playnav-play-favorites-page-0" class="scrollbox-page loaded videos-rows-12" style="visibility: visible;">
    <?php foreach ($Playlists_2 as $Playlist) : ?>
        <?php $Count++ ?>
        <?php
                    $Videos = $DB->execute("SELECT url FROM playlists_videos WHERE playlist_id = :ID ORDER BY position ASC",false,array(":ID" => $Playlist["id"]));
                    if ($Videos) {
                        if (isset($Videos[0])) {
                            $Video1 = $Videos[0]["url"];
                        }
                    } else {
                        $Video1 = false;
                        $Video2 = false;
                        $Video3 = false;
                    }
                ?>
        <div id="playnav-video-play-playlists-all-<?= $Count ?>-<?= $Playlist['id'] ?>" class="playnav-item playnav-playlist">
        <div style="display:none" class="encryptedVideoId"><?= $Playlist['id'] ?></div>
        <div id="playnav-video-play-playlists-all-<?= $Count ?>-<?= $Playlist['id'] ?>-selector" class="selector"></div>
        <div class="content">
            <div class="vCluster120WideEntry"><div class="vCluster120WrapperOuter"><div class="vCluster120WrapperInner"><a id="video-url" onclick="open_playlist('playlists','<?= $Count ?>','<?= $Playlist['id'] ?>');return false;" href="/view_playlist?id=<?= $Playlist["id"] ?>" rel="nofollow"><img title="<?= $Playlist["title"] ?>" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video1.'.jpg')): ?>src="/u/thmp/<?= $Video1 ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimgCluster120" alt="<?= $Playlist["title"] ?>"></a><div class="video-corner-text"><span><?= $DB->execute("SELECT count(url) as amount FROM playlists_videos WHERE playlist_id = :ID", true, [":ID" => $Playlist["id"]])["amount"] ?> <?= $LANGS['plvideoamount'] ?></span></div></div></div></div>
            <div class="playnav-video-info">
                <a href="/view_playlist?id=<?= $Playlist['id'] ?>" class="playnav-item-title ellipsis" onclick="open_playlist('playlists','<?= $Count ?>','<?= $Playlist['id'] ?>');return false;" id="playnav-video-title-play-playlists-all-<?= $Count ?>-<?= $Playlist['id'] ?>"><span><?= $Playlist['title'] ?></span></a>
                <div class="metadata">
                        <span class="playnav-video-username"><?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['longtimeformat'], time_machine(strtotime((string) $Playlist["submit_date"]))); }
                    else {echo strftime($LANGS['longtimeformat'], strtotime((string) $Playlist["submit_date"])); }  ?></span>
                    <br>
                    <a href="/view_playlist?id=<?= $Playlist['id'] ?>"><?= $LANGS['moreinfo'] ?></a>
                </div>
                <div style="display:none" id="playnav-video-play-playlists-all-<?= $Count ?>"><?= $Playlist['id'] ?></div>                  
            </div>
        </div>
    </div>
    <?php endforeach ?>
                                </div>         
                    </div>
                </div>
            </div>
        </div>
    </div>
                </div>
        </div>
    <?php endif ?>
	</div>
	<div id="playnav-play-loading" class="loading">
			<div class="cover outer-box-bg-color"></div>
	<div class="image-holder">
		<div class="image-holder-middle">
			<div class="image-holder-inner">
				<img src="/img/icn_loading_animated.gif">
			</div>
		</div>
	</div>

	</div>

				</div>
				<div id="playnav-gridview" class="" style="display: none;">
						<div id="playnav-grid-panel">
		<div id="playnav-grid-content" overflow="auto">
		</div>
	</div>
	<div id="playnav-grid-loading" class="loading">
			<div class="cover outer-box-bg-color"></div>
	<div class="image-holder">
		<div class="image-holder-middle">
			<div class="image-holder-inner">
				<img src="/img/icn_loading_animated.gif">
			</div>
		</div>
	</div>

	</div>

				</div>
			</div>
	</div>

			<div class="outer-box" id="main-channel-content" style="z-index: 0">
			<div class="left-column" id="main-channel-left">
						<div class="inner-box">
		<div style="float:left;padding:0 4px 4px 0" class="link-as-border-color">
			  <div class="user-thumb-xlarge link-as-border-color"><div>
<a href="/user/<?= $_PROFILE->Username ?>">
    <img id="" src="<?= avatar($_PROFILE->Username) ?>" alt="<?= displayname($_PROFILE->Username) ?>">
</a>
  </div></div>

		</div>
        <?php if ($_USER->Username != $_PROFILE->Username && !$_PROFILE->is_blocked($_USER)): ?>
		<div style="float:left;width:170px">
			<div class="box-title title-text-color" title="<?= displayname($_PROFILE->Username) ?>" style="float:none;padding-left:4px;margin-top:-2px;width:170px;overflow:hidden;font-size:150%">
				<?= displayname($_PROFILE->Username) ?>
			</div>
					<div style="whitespace:no-wrap;position:relative;width:170px;">
		<div>
					<div id="subscribe_user_profile" class="subscribe-div">
			<?php if(!$Is_Subscribed) : ?>
                            <div id="subscribeDiv">
                                <a class="yt-button yt-button-urgent" <?php if ($_USER->Logged_In && $_USER->Username != $_PROFILE->Username && !$_PROFILE->is_blocked($_USER)) : ?>href="javascript:void(0)" onclick="subscribe()"<?php elseif (!$_USER->Logged_In && !$_PROFILE->is_blocked($_USER)) : ?>href="/login"<?php elseif ($_PROFILE->is_blocked($_USER)) : ?>href="#" onclick='alert("You can&#39;t subscribe to this channel because you are blocked!");return false;'<?php else : ?>href="#" onclick='alert("<?= $LANGS['subyourself'] ?>");return false;'<?php endif ?>class="action-button" title="subscribe to <?= $_PROFILE->Username ?>'s videos">
                                    <span class="action-button-text" id="subscribe-button"><?= $LANGS['subscribe'] ?></span>
                                </a>
                            </div> 
                        <?php else : ?>
                            <div id="unsubscribeDiv">
                                <a class="yt-button yt-button-urgent unsubscribe" href="javascript:void(0)" onclick="subscribe()" class="action-button" title="unsubscribe from <?= $_PROFILE->Username ?>'s videos">
                                    <span class="action-button-text" id="unsubscribe-button"><?= $LANGS['unsubscribe'] ?></span>
                                </a>
                            </div>
                        <?php endif ?>
		</div>

			<div class="cb"></div>
		</div>
		<div style="padding:4px">
				<?php if ($_USER->Logged_In && $_USER->Username != $_PROFILE->Username) : ?>
                                    <?php if (!isset($Friend_Status) || $Friend_Status === false) : ?>
                                    <a id="aProfileAddFriend" href="/my_friends_invite?user=<?= $_PROFILE->Username ?>"><?= $LANGS['addfriend'] ?></a>
                                    <?php elseif ($Friend_Status == 0) : ?>
                                    <a id="aProfileRemoveFriend" href="/my_friends_invite?retract=<?= $Friend_ID ?>"><?= $LANGS['retractinvite'] ?></a>
                                    <?php else : ?>
                                    <a id="aProfileRemoveFriend" href="/my_friends?remove=<?= $_PROFILE->Username?>"><?= $LANGS['removefriend'] ?></a>
                                    <?php endif ?>
                                    <?php elseif (!$_USER->Logged_In) : ?>
                                    <a id="aProfileAddFriend" href="javascript:void(0)" onclick="alert('<?= $LANGS['logintofriend'] ?>')"><?= $LANGS['addfriend'] ?></a>
                                    <?php else : ?>
                                    <a id="aProfileAddFriend" href="javascript:void(0)" onclick="alert('<?= $LANGS['notfriendyourself'] ?>')"><?= $LANGS['addfriend'] ?></a>
                                    <?php endif ?>&nbsp;|&nbsp;
			<span class="nowrap">
				<?php if (!$_USER->is_blocked($_PROFILE)): ?>
                    <a id="aProfileBlockUser" onclick="confirm('Are you sure you want to block this user?')" href="/a/block_user?user=<?= $_PROFILE->Username ?>"><?= $LANGS['blockuser'] ?></a>
                    <?php else: ?>
                        <a id="aProfileBlockUser" onclick="confirm('Are you sure you want to unblock this user?')" href="/a/block_user?user=<?= $_PROFILE->Username ?>">Unblock User</a>
                <?php endif ?>
			&nbsp;|&nbsp;</span>
			<span class="nowrap">
				<a id="aProfileSendMsg" <?php if ($_USER->Logged_In && $_USER->Username != $_PROFILE->Username) : ?> href="/send_message?to=<?= $_PROFILE->Username ?>" <?php else : ?>href="javascript:void(0)" onclick="<?if($_USER->Username == $_PROFILE->Username) :?>alert('<?= $LANGS['messagetoyourself'] ?>')<?else :?>alert('<?= $LANGS['logintomessage'] ?>')<?endif?>"<?php endif ?>><img src="/img/pixel.gif" id="profileSendMsg" class="icnProperties" alt="<?= $LANGS['profilesendmessage'] ?>"><?= $LANGS['profilesendmessage'] ?></a><?php if (($_USER->Is_Admin || $_USER->Is_Moderator) && ($_PROFILE->Username != "vistafan12" && $_PROFILE->Username != "BitView") ) : ?> | <br><a href="/admin_panel/?page=users&ue=<?= $_PROFILE->Username ?>" name="" rel="nofollow">Edit User</a>
                <br>
                <?php endif ?>
			</span>
		</div>
	</div>
		</div>
        <?php elseif ($_PROFILE->is_blocked($_USER)):?>
            <div style="float:left;width:170px">
            <div class="box-title title-text-color" title="<?= displayname($_PROFILE->Username) ?>" style="float:none;padding-left:4px;margin-top:-2px;width:170px;overflow:hidden;font-size:100%">
                <?= displayname($_PROFILE->Username) ?>
            </div>
                <div class="opacity70" style="padding-left: 8px;width:170px">You can't interact with this user because you are blocked.</div>
        </div>
        <?php else: ?>
        <div style="float:left;width:170px">
            <div class="box-title title-text-color" title="<?= displayname($_PROFILE->Username) ?>" style="float:none;padding-left:4px;margin-top:-2px;width:170px;overflow:hidden;font-size:100%">
                <?= displayname($_PROFILE->Username) ?>
            </div>
                <div class="opacity70" style="padding-left: 8px;width:170px"><?= $LANGS['profilemsg'] ?></div>
        </div>
        <?php endif ?>
		<div id="position-edit-subscription-in-channel">
		</div>
		<div class="cb"></div>
	</div>
<?php require_once "_templates/_profile/profile_modules/profile_l.php" ?>
<?php if($_PROFILE->Info["is_partner"] AND $_PROFILE->Info["c_sideimage"]): ?>
    <div class="profile-banner-box" id="side_column_image">
    <?php if ($_PROFILE->Info["sideimage_map"]): ?>
	    <map id="imgmap_side">
		<?php
		require_once $_SERVER['DOCUMENT_ROOT']."/_includes/_classes/HTMLPurifier/HTMLPurifier.auto.php";
		$config_bmap = HTMLPurifier_Config::createDefault();
		$config_bmap->set('HTML.Allowed', 'area[target|alt|title|href|shape|coords]');
		$config_bmap->set('AutoFormat.RemoveEmpty', false);
		$def = $config_bmap->getHTMLDefinition(true);

		$area = $def->addElement(
		  'area',   // name
		  'Block',  // content set
		  'Empty', // don't allow children
		  'Common', // attribute collection
		  [ // attributes
			'name' => 'CDATA',
			'id' => 'ID',
			'alt' => 'Text',
			'coords' => 'CDATA',
			'accesskey' => 'Character',
			'nohref' => new HTMLPurifier_AttrDef_Enum(['nohref']),
			'href' => 'URI',
			'shape' => new HTMLPurifier_AttrDef_Enum(['rect','circle','poly','default']),
			'tabindex' => 'Number',
			'target' => new HTMLPurifier_AttrDef_Enum(['_blank','_self','_target','_top'])
		  ]
		);
		$area->excludes = ['area' => true];
		$purifier_bmap = new HTMLPurifier($config_bmap);

		$banner_map = $purifier_bmap->purify(htmlspecialchars_decode((string) $_PROFILE->Info["banner_map"]));
		?>
		<?= $banner_map ?>
		</map>
		<img usemap="#imgmap_side" src="<?= cache_bust($_PROFILE->Info["c_sideimage"]) ?>" width="300">
    <?php elseif ($_PROFILE->Info["sideimage_link"]): ?>
	<a href="<?= $_PROFILE->Info["sideimage_link"] ?>">
	<img src="<?= cache_bust($_PROFILE->Info["c_sideimage"]) ?>" width="300">
	</a>
	<?php else: ?>
	<img src="<?= cache_bust($_PROFILE->Info["c_sideimage"]) ?>" width="300">
	<?php endif ?>
	</div>
<?php endif ?>
    <?php if (!empty($_PROFILE->Info['c_modules_l'])): ?>
    <?php foreach ($Modules_L as $Module): ?>
    <?php require_once "_templates/_profile/profile_modules/". $Module ."_l.php" ?>
    <?php endforeach ?>
    <?php endif ?>
			</div>
	<div class="right-column" id="main-channel-right">
        <?php if (!empty($_PROFILE->Info['c_modules_r'])): ?>
                <?php foreach ($Modules_R as $Module): ?>
    <?php require_once "_templates/_profile/profile_modules/". $Module ."_r.php" ?>
    <?php endforeach ?>
<?php endif ?>
	</div>
			<div class="cb"></div>
			</div>



	</div>
</div>
<div id="yt-uix-tooltip-tip" class="yt-uix-tooltip-tip yt-uix-tooltip-tip-visible" style="left: 80.3594px; top: 478.969px; opacity: 0;"><div class="yt-uix-tooltip-tip-body"><div class="yt-uix-tooltip-tip-content">I dislike this</div></div><div class="yt-uix-tooltip-tip-arrow"></div></div>
<script>
function playVideo(from,num,url) {
    var already_selected = document.getElementsByClassName("playnav-item-selected");
    var menu = document.getElementsByClassName("view-button-selected")[0].id;
    menu = menu.substring(0, 4);
    if (menu === "grid") {
        $(".view-button-selected").removeClass("view-button-selected");
        document.getElementById("playview-icon").classList.add("view-button-selected");
        document.getElementById("playnav-gridview").style.display = "none";
        document.getElementById("playnav-playview").style.display = "block";
        document.getElementById("playnav-player").style.display = "block";
    }

    var loading = document.getElementById("playnav-video-panel-loading");
    for(var i = 0; i < already_selected.length; i++)
    {
        already_selected[i].classList.remove("playnav-item-selected");
    }
    loading.style.display = "block";
    if (document.getElementById("playnav-video-play-"+from+"-"+num+"-"+url)) {
        document.getElementById("playnav-video-play-"+from+"-"+num+"-"+url).classList.add("playnav-item-selected");
    }
    $.ajax({
        type: "POST",
        url: "/a/profile_new/get_video_info.php",
        data: {
            id: url
        },
        success: function(t) {
            $('.vlPlayScreen').hide();
            changeURL(url);
            window.vlp.change({
                    src: "/videos/" + t.file_url + ".mp4",
                    hdsrc: 1 == t.hd ? "/videos/" + t.file_url + ".720.mp4" : "/videos/" + t.file_url + ".mp4",
                    preview: "/u/thmp/" + url + ".jpg",
                    duration: t.length,
                    videoUrl: "https://www.bitview.net/watch?v=" + url,
                    autoplay: !0
                });
            selectPanel('info',url);
            $('#panel-icon-info').attr('onmousedown', "selectPanel('info','"+ url +"')");
            $('#info-bottom-link a').attr('onmousedown', "selectPanel('info','"+ url +"')");
            $('#panel-icon-comments').attr('onmousedown', "selectPanel('comments','"+ url +"')");
            $('#comments-bottom-link a').attr('onmousedown', "selectPanel('comments','"+ url +"')");
            $('#panel-icon-favorite').attr('onmousedown', "selectPanel('favorite','"+ url +"')");
            $('#favorite-bottom-link a').attr('onmousedown', "selectPanel('favorite','"+ url +"')");
            $('#panel-icon-share').attr('onmousedown', "selectPanel('share','"+ url +"')");
            $('#share-bottom-link a').attr('onmousedown', "selectPanel('share','"+ url +"')");
            $('#panel-icon-playlists').attr('onmousedown', "selectPanel('playlists','"+ url +"')");
            $('#playlists-bottom-link a').attr('onmousedown', "selectPanel('playlists','"+ url +"')");
            $('#panel-icon-flag').attr('onmousedown', "selectPanel('flag','"+ url +"')");
            $('#flag-bottom-link a').attr('onmousedown', "selectPanel('flag','"+ url +"')");
            $("#playnav-curvideo-title span").replaceWith('<span style="cursor: pointer; margin-right: 7px; text-decoration: none;" onclick="document.location.href=&quot;/watch?v=' + url + '&quot;" onmouseover="this.style.textDecoration=&quot;underline&quot;" onmouseout="this.style.textDecoration=&quot;none&quot;">'+ t.title +'</span>');
            $("#playnav-curvideo-info-line").replaceWith('<div id="playnav-curvideo-info-line">De: <span id="playnav-curvideo-channel-name"><a href="/user/'+ t.uploaded_by +'">'+ t.displayname +'</a></span>&nbsp;| '+ t.uploaded_on +'&nbsp;| <span id="playnav-curvideo-view-count">'+ t.views +'</span></div>');
            $("#playnav-curvideo-description").replaceWith('<div id="playnav-curvideo-description">'+ t.description +'</div>');
            $('#playnav-watch-link').attr('href', '/watch?v='+url);
            $('#like_video_id').replaceWith('<input type="hidden" id="like_video_id" value="'+ url +'">');
            loading.style.display = "none";
        }
    });
}
</script>
<?php use function PHP81_BC\strftime; ?>
<div class="inner-box" id="user_profile">
        
        <div style="float:left;" class="box-title title-text-color">
<?= $LANGS['profile'] ?>
        </div>

        <div style="float:right;;_display:inline;white-space:nowrap">
                <div style="float:right;padding:0 4px;position:relative">
                    <?php if ($_PROFILE->Username == $_USER->Username): ?>
                    <a class="channel-cmd" href="#" onclick="document.getElementById('user_profile').classList.add('edit_mode');document.getElementById('user_profile-body').style.display = 'none';return false;" id="user_profile_edit_link"><?= mb_strtolower((string) $LANGS['edit'])  ?></a>
                <?php endif ?>
                </div>
        </div>
        <div class="cb"></div>
        <?php if ($_PROFILE->Username == $_USER->Username): ?>

        <img src="/img/pixel.gif" class="edit-widget" style="right: 9px;">
<div class="edit_info">
    <form action="/user/Herotrap" method="POST">
    <div class="edit_top_box" style="padding: 5px;">
        <div class="user_profile_save_cancel" style="position:relative;line-height: 27px;">
        <button type="button" onclick="save_profile_info();" class=" yt-uix-button yt-uix-button-primary" name="save_settings_user_profile"><span class="yt-uix-button-content"><?= $LANGS['editsavechanges'] ?></span></button>
<?= $LANGS['or'] ?>
        <a href="#" onclick="document.getElementById('user_profile').classList.remove('edit_mode');document.getElementById('user_profile-body').style.display = 'block';return false;"><?= $LANGS['editcancel'] ?></a>
        <div class="save_overlay" style="padding:0.4em;padding-left:3em;width:60%">
            <img src="/img/icn_loading_animated.gif">
        </div>
    </div>
    <div class="edit_profile_separator spacer">&nbsp;</div>
    <div class="spacer">&nbsp;</div>
    <div class="edit_info">
        <div style="float:left"><input name="i_name_chk" id="first_name" type="checkbox" <?php if ($Profile_Info[0] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('first_name');"></div>
        <div id="edit_info_first_name" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[0] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['name'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_name" id="profile_edit_first_name" maxlength="30" value="<?= $_PROFILE->Info['i_name'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_channelviews_chk" id="channel_views" onclick="update_hidden_field('channel_views');" type="checkbox" <?php if ($Profile_Info[1] == 1): ?><?php if ($Profile_Info[1] == 1): ?>checked=""<?php endif ?><?php endif ?> style="vertical-align:text-bottom"></div>
        <div id="edit_info_channel_views" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[1] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['channelviews'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["profile_views"]) ?><?php else: ?><?= ($_PROFILE->Info["profile_views"]) ?><?php endif ?>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_videoviews_chk" id="video_views" type="checkbox" <?php if ($Profile_Info[2] == 1): ?>checked=""<?php endif ?> onclick="update_hidden_field('video_views');" style="vertical-align:text-bottom"></div>
        <div id="edit_info_video_views" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[2] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['totaluploadviews'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["video_views"]) ?><?php else: ?><?= ($_PROFILE->Info["video_views"]) ?><?php endif ?>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_videoswatched_chk" id="videos_watched" type="checkbox" <?php if ($Profile_Info[3] == 1): ?>checked=""<?php endif ?> onclick="update_hidden_field('videos_watched');" style="vertical-align:text-bottom"></div>
        <div id="edit_info_videos_watched" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[3] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['videoswatched'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["videos_watched"]) ?><?php else: ?><?= ($_PROFILE->Info["videos_watched"]) ?><?php endif ?>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_age_chk" id="age" onclick="update_hidden_field('age');" type="checkbox" <?php if ($Profile_Info[4] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom"></div>
        <div id="edit_info_age" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[4] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['age'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <?= ageCalculator($_PROFILE->Info["i_age"]) ?>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_last_login_chk" id="last_login" onclick="update_hidden_field('last_login');" type="checkbox" <?php if ($Profile_Info[5] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom"></div>
        <div id="edit_info_last_login" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[5] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['lastlogin'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <?= get_time_ago($_PROFILE->Info["last_login"]) ?>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_subscribers_chk" id="subscribers" onclick="update_hidden_field('subscribers');" type="checkbox" <?php if ($Profile_Info[6] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom"></div>
        <div id="edit_info_subscribers" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[6] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['channelsubscribers'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["subscribers"]) ?><?php else: ?><?= ($_PROFILE->Info["subscribers"]) ?><?php endif ?>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_website_chk" id="website" type="checkbox" <?php if ($Profile_Info[7] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('website');"></div>
        <div id="edit_info_website" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[7] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['website'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_website" id="profile_edit_website" maxlength="128" value="<?= $_PROFILE->Info['i_website'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_description_chk" id="description" type="checkbox" <?php if ($Profile_Info[8] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('description');"></div>
        <div id="edit_info_description" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[8] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['channeldesc'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <textarea maxlength="5000" type="text" name="i_desc" id="profile_edit_description" class="edit_text" style="width: 235px; height: 45px; border: 1px solid #ccc; resize: vertical;"><?= $_PROFILE->Info['i_desc'] ?></textarea>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_about_chk" id="about_me" type="checkbox" <?php if ($Profile_Info[9] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('about_me');"></div>
        <div id="edit_info_about_me" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[9] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['aboutme'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <textarea maxlength="2048" type="text" name="i_about" id="profile_edit_about_me" class="edit_text" style="width: 235px; height: 45px; border: 1px solid #ccc; resize: vertical;"><?= $_PROFILE->Info['i_about'] ?></textarea>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_hometown_chk" id="hometown" type="checkbox" <?php if ($Profile_Info[10] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('hometown');"></div>
        <div id="edit_info_hometown" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[10] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['hometown'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_hometown" id="profile_edit_hometown" maxlength="128" value="<?= $_PROFILE->Info['i_hometown'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_country_chk" id="country" type="checkbox" <?php if ($Profile_Info[11] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('country');"></div>
        <div id="edit_info_country" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[11] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['country'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <select name="i_country" id="profile_edit_country" style="width: 150px;">
                        <option value=""<?php if (!$_PROFILE->Info["i_country"]) : ?> selected<?php endif ?>>------</option>
                    <?php foreach($Channel_Country as $value => $item) : ?>
                        <option value="<?= $value ?>"<?php if ($_PROFILE->Info["i_country"] == $value) : ?> selected<?php endif ?>><?= $item ?></option>
                    <?php endforeach ?>
                </select>
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_occupation_chk" id="occupation" type="checkbox" <?php if ($Profile_Info[12] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('occupation');"></div>
        <div id="edit_info_occupation" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[12] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['occupation'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_occupation" id="profile_edit_occupation" maxlength="128" value="<?= $_PROFILE->Info['i_occupation'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_companies_chk" id="companies" type="checkbox" <?php if ($Profile_Info[13] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('companies');"></div>
        <div id="edit_info_companies" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[13] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['companies'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_companies" id="profile_edit_companies" maxlength="128" value="<?= $_PROFILE->Info['i_companies'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_schools_chk" id="schools" type="checkbox" <?php if ($Profile_Info[14] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('schools');"></div>
        <div id="edit_info_schools" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[14] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['schools'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_schools" id="profile_edit_schools" maxlength="128" value="<?= $_PROFILE->Info['i_schools'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_hobbies_chk" id="hobbies" type="checkbox" <?php if ($Profile_Info[15] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('hobbies');"></div>
        <div id="edit_info_hobbies" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[15] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['interests'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_hobbies" id="profile_edit_hobbies" maxlength="128" value="<?= $_PROFILE->Info['i_hobbies'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_movies_chk" id="movies" type="checkbox" <?php if ($Profile_Info[16] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('movies');"></div>
        <div id="edit_info_movies" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[16] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['movies'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_movies" id="profile_edit_movies" maxlength="128" value="<?= $_PROFILE->Info['i_movies'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_music_chk" id="music" type="checkbox" <?php if ($Profile_Info[17] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('music');"></div>
        <div id="edit_info_music" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[17] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['music'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_music" id="profile_edit_music" maxlength="128" value="<?= $_PROFILE->Info['i_music'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
    <div class="edit_info">
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="spacer">&nbsp;</div>
        <div style="float:left"><input name="i_books_chk" id="books" type="checkbox" <?php if ($Profile_Info[18] == 1): ?>checked=""<?php endif ?> style="vertical-align:text-bottom" onclick="update_hidden_field('books');"></div>
        <div id="edit_info_books" style="float:left;padding-left:4px;width:240px;<?php if ($Profile_Info[18] == 0): ?>opacity: 0.4;<?php endif ?>">
        <div style="float:left;font-weight:bold"><?= $LANGS['books'] ?>:</div>
        <div style="float:right;text-align:right;">
                    <input type="text" name="i_books" id="profile_edit_books" maxlength="128" value="<?= $_PROFILE->Info['i_books'] ?>" style="border: 1px solid #ccc;width: 150px;padding: 2px;float: right;" class="edit_text">
        </div>
        </div>
        <div class="spacer">&nbsp;</div>
    </div>
        <div class="edit_profile_separator spacer">&nbsp;</div>
        <div class="user_profile_save_cancel" style="position:relative;line-height: 27px;">
        <button type="button" onclick="save_profile_info();" class=" yt-uix-button yt-uix-button-primary" name="save_settings_user_profile"><span class="yt-uix-button-content"><?= $LANGS['editsavechanges'] ?></span></button>
<?= $LANGS['or'] ?>
        <a href="#" onclick="document.getElementById('user_profile').classList.remove('edit_mode');document.getElementById('user_profile-body').style.display = 'block';return false;"><?= $LANGS['editcancel'] ?></a>
        <div class="save_overlay" style="padding:0.4em;padding-left:3em;width:60%">
            <img src="/img/icn_loading_animated.gif">
        </div>
    </div>
    </div>
    </form>
        </div>
    <?php endif ?>
    <div id="user_profile-body">
            <div class="edit_info spacer">&nbsp;</div>
    <div class="profile_info">
        <?php if ($_PROFILE->Info["i_name"] && $Profile_Info[0] == 1): ?>
                <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['name'] ?>:</div>
        <div style="float:right;" id="profile_show_first_name"><?= $_PROFILE->Info["i_name"] ?></div>
        <div class="cb"></div>
    </div>
<?php endif ?>

<?php if ($Profile_Info[1] == 1): ?>
        <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['channelviews'] ?>:</div>
        <div style="float:right;" id="profile_show_viewed_count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["profile_views"]) ?><?php else: ?><?= ($_PROFILE->Info["profile_views"]) ?><?php endif ?></div>
        <div class="cb"></div>
    </div>
<?php endif ?>
<?php if ($Profile_Info[2] == 1): ?>
        <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['totaluploadviews'] ?>:</div>
        <div style="float:right;" id="profile_show_viewed_count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["video_views"]) ?><?php else: ?><?= ($_PROFILE->Info["video_views"]) ?><?php endif ?></div>
        <div class="cb"></div>
    </div>
<?php endif ?>
<?php if ($Profile_Info[3] == 1): ?>
        <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['videoswatched'] ?>:</div>
        <div style="float:right;" id="profile_show_viewed_count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["videos_watched"]) ?><?php else: ?><?= ($_PROFILE->Info["videos_watched"]) ?><?php endif ?></div>
        <div class="cb"></div>
    </div>
<?php endif ?>
<?php if ($Profile_Info[4] == 1 && $_PROFILE->Info["i_age"] != "0000-00-00") : ?>
                    <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['age'] ?>:</div>
        <div style="float:right;" id="profile_show_age"><?= ageCalculator($_PROFILE->Info["i_age"]) ?></div>
        <div class="cb"></div>
    </div>
<?php endif ?>


        <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['joined'] ?>:</div>
        <div style="float:right;" id="profile_show_member_since"><?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['longtimeformat'], time_machine(strtotime((string) $_PROFILE->Info["registration_date"]))); }
                    else {echo strftime($LANGS['longtimeformat'], strtotime((string) $_PROFILE->Info["registration_date"])); }  ?></div>
        <div class="cb"></div>
    </div>
<?php if ($Profile_Info[5] == 1) : ?>
                <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['lastlogin'] ?>:</div>
        <div style="float:right;" id="profile_show_last_login"><?= get_time_ago($_PROFILE->Info["last_login"]) ?></div>
        <div class="cb"></div>
    </div>
<?php endif ?>

<?php if ($Profile_Info[6] == 1) : ?>
                <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['channelsubscribers'] ?>:</div>
        <div style="float:right;" id="profile_show_subscriber_count"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_PROFILE->Info["subscribers"]) ?><?php else: ?><?= ($_PROFILE->Info["subscribers"]) ?><?php endif ?></div>
        <div class="cb"></div>
    </div>
<?php endif ?>

        <?php if (!empty($_PROFILE->Info["i_website"]) && $Profile_Info[7] == 1) : ?>
            <div class="show_info outer-box-bg-as-border">
            <div style="float:left;font-weight:bold"><?= $LANGS['website'] ?>:</div>
            <div style="float:right"><a href="<?= $_PROFILE->Info["i_website"] ?>" name="" rel="nofollow"><?= short_title($_PROFILE->Info["i_website"],30) ?></a></div>
            <div class="cb"></div>
        </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_desc"]) && $Profile_Info[8] == 1) : ?>
        <div class="show_info outer-box-bg-as-border" style="border-bottom-width:1px;margin-bottom:4px;line-height:140%;overflow: hidden;">

            <?= make_links_clickable(nl2br((string) $_PROFILE->Info["i_desc"])) ?>

            <div class="cb"></div>
        </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_about"]) && $Profile_Info[9] == 1) : ?>
        <div class="show_info outer-box-bg-as-border" style="border-bottom-width:1px;margin-bottom:4px;line-height:140%;overflow: hidden;">
            <div style="float:left"><b><?= $LANGS['aboutme'] ?>:</b></div>
            <div class="spacer">&nbsp;</div>

            <?= make_links_clickable(nl2br((string) $_PROFILE->Info["i_about"])) ?>

            <div class="cb"></div>
        </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_hometown"]) && $Profile_Info[10] == 1) : ?>
        <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['hometown'] ?>:</div>
        <div style="float:right;" id="profile_show_hometown"><?= $_PROFILE->Info["i_hometown"] ?></div>
        <div class="cb"></div>
    </div>
    <?php endif ?>

    <?php if ($_PROFILE->Info["i_country"] != null && $Profile_Info[11] == 1) : ?>
            <div class="show_info outer-box-bg-as-border">
            <div style="float:left;font-weight:bold"><?= $LANGS['country'] ?>:</div>
            <div style="float:right"><?= $Channel_Country[$_PROFILE->Info["i_country"]] ?></div>
            <div class="cb"></div>
        </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_occupation"]) && $Profile_Info[12] == 1) : ?>
        <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['occupation'] ?>:</div>
        <div style="float:right;" id="profile_show_occupation"><?= $_PROFILE->Info["i_occupation"] ?></div>
        <div class="cb"></div>
    </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_companies"]) && $Profile_Info[13] == 1) : ?>
        <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['companies'] ?>:</div>
        <div style="float:right;" id="profile_show_companies"><?= $_PROFILE->Info["i_companies"] ?></div>
        <div class="cb"></div>
    </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_schools"]) && $Profile_Info[14] == 1) : ?>
        <div class="show_info outer-box-bg-as-border">
        <div style="float:left;font-weight:bold;"><?= $LANGS['schools'] ?>:</div>
        <div style="float:right;" id="profile_show_schools"><?= $_PROFILE->Info["i_schools"] ?></div>
        <div class="cb"></div>
    </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_hobbies"]) && $Profile_Info[15] == 1) : ?>
            <div class="show_info outer-box-bg-as-border">
            <div style="float:left;font-weight:bold"><?= $LANGS['interests'] ?>:</div>
            <div style="float:right"><?= $_PROFILE->Info["i_hobbies"] ?></div>
            <div class="cb"></div>
        </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_movies"]) && $Profile_Info[16] == 1) : ?>
    <div class="show_info outer-box-bg-as-border">
            <div style="float:left;font-weight:bold"><?= $LANGS['movies'] ?>:</div>
            <div style="float:right"><?= $_PROFILE->Info["i_movies"] ?></div>
            <div class="cb"></div>
        </div>
    <?php endif ?>


    <?php if (!empty($_PROFILE->Info["i_music"]) && $Profile_Info[17] == 1) : ?>
    <div class="show_info outer-box-bg-as-border">
            <div style="float:left;font-weight:bold"><?= $LANGS['music'] ?>:</div>
            <div style="float:right"><?= $_PROFILE->Info["i_music"] ?></div>
            <div class="cb"></div>
        </div>
    <?php endif ?>

    <?php if (!empty($_PROFILE->Info["i_books"]) && $Profile_Info[18] == 1) : ?>
    <div class="show_info outer-box-bg-as-border">
            <div style="float:left;font-weight:bold"><?= $LANGS['books'] ?>:</div>
            <div style="float:right"><?= $_PROFILE->Info["i_books"] ?></div>
            <div class="cb"></div>
        </div>
    <?php endif ?>
    <?php if ($Honor_Count > 1): ?>
    <div class="show_info" style="padding-top: 8px;border:0">
    <span style="display:none"><?= $Honor_Count ?></span>
    <div class="padT10">
                <table cellspacing="0" cellpadding="0"><tbody><tr>
                    <td width="20" valign="top"><img src="/img/icn_award_17x24-vfl10931.gif" border="0"></td>
                    <td valign="top">
    <span id="BeginvidDeschonors" style="display:block">
                <?php $Count = 0; ?>
                <?php foreach ($Ranking as $Rank): ?>
                    <?php if ($Rank['rank'] <= 50 && $Count < 3): ?>
                        <a href="<?= $Rank['href'] ?>">#<?= $Rank['rank'] ?><?= $Rank['text'] ?></a><br><?php $Count ++; ?>
                    <?php endif ?>
                <?php endforeach ?>
    </span>
    <span id="RemainvidDeschonors" style="display:none">
        <?php foreach ($Ranking as $Rank): ?>
            <?php if ($Rank['rank'] <= 50): ?>
                <a href="<?= $Rank['href'] ?>">#<?= $Rank['rank'] ?><?= $Rank['text'] ?></a><br>
            <?php endif ?>
        <?php endforeach ?>
    </span>
    <?php if ($Honor_Count > 3): ?>
    <span id="MorevidDeschonors" style="display: block;font-size:11px;">(<a href="#" class="eLink" style="border-bottom: 1px dotted;text-decoration: none;" onclick="showhidehonors(); return false;"><?= $LANGS['dropdownmore'] ?></a>)</span>
    <span id="LessvidDeschonors" class="smallText" style="display: none;font-size: 11px;">(<a href="#" class="eLink" style="border-bottom: 1px dotted;text-decoration: none;" onclick="showhidehonors(); return false;"><?= $LANGS['honorless'] ?></a>)</span>
<?php endif ?>
</td>
                </tr></tbody></table>
            </div>
        </div>
<?php endif ?>
    </div>
    </div>
    <div class="cb"></div>
    </div>
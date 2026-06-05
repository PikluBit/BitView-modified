<?php if($_PROFILE->Info["is_partner"] AND $_PROFILE->Info["c_banner_image"]): ?>
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
<div class="profileTitleLinks">
        <div id="profileSubNav">
        <?php if ($_GET["page"] == null) : ?>
        <?php else : ?>
        <a href="/user/<?= $_PROFILE->Username ?>"><?= $LANGS['channel'] ?></a><span class="delimiter">|</span>
        <?php endif ?>
        <?php if ($_PROFILE->Info["c_videos_box"]): ?>
        <?php if ($_GET["page"] == "videos") : ?>
        <strong> <?= $LANGS['videos'] ?> </strong>
        <?php else : ?>
        <a href="/user/<?= $_PROFILE->Username ?>&page=videos"><?= $LANGS['videos'] ?></a>
        <?php endif ?>
        <span class="delimiter">|</span>
        <?php endif ?>
        <?php if ($_PROFILE->Info["c_favorites_box"]): ?>
        <?php if ($_GET["page"] == "favorites") : ?>
        <strong> <?= $LANGS['favorites'] ?> </strong>
        <?php else : ?>
        <a href="/user/<?= $_PROFILE->Username ?>&page=favorites"><?= $LANGS['favorites'] ?></a>
        <?php endif ?>
                <span class="delimiter">|</span>
        <?php endif ?>
        <?php if ($_PROFILE->Info["c_playlists_box"]): ?>
        <?php if ($_GET["page"] == "playlists") : ?>
        <strong> <?= $LANGS['playlists'] ?> </strong>
        <?php else : ?>
        <a href="/user/<?= $_PROFILE->Username ?>&page=playlists"><?= $LANGS['playlists'] ?></a>
        <?php endif ?>
                <span class="delimiter">|</span>
        <?php endif ?>
        <?php if ($_PROFILE->Info["c_friends_box"]): ?>
        <?php if ($_GET["page"] == "friends") : ?>     
        <strong> <?= $LANGS['friends'] ?> </strong>
        <?php else : ?>
        <a href="/user/<?= $_PROFILE->Username ?>&page=friends"><?= $LANGS['friends'] ?></a>
        <?php endif ?>
        <span class="delimiter">|</span>
        <?php endif ?>
        <?php if ($_PROFILE->Info["c_subscribers_box"]): ?>
        <?php if ($_GET["page"] == "subscribers") : ?>     
        <strong> <?= $LANGS['channelsubscribers'] ?> </strong>
        <?php else : ?>
        <a href="/user/<?= $_PROFILE->Username ?>&page=subscribers"><?= $LANGS['channelsubscribers'] ?></a>
        <?php endif ?>
                <span class="delimiter">|</span>
        <?php endif ?>
        <?php if ($_PROFILE->Info["c_subscriptions_box"]): ?>
        <?php if ($_GET["page"] == "subscriptions") : ?>     
        <strong> <?= $LANGS['subscriptions'] ?> </strong>
        <?php else : ?>
        <a href="/user/<?= $_PROFILE->Username ?>&page=subscriptions"><?= $LANGS['subscriptions'] ?></a>
        <?php endif ?>
                <span class="delimiter">|</span>
        <?php endif ?>
        <?php if ($_PROFILE->Info["c_comments_box"]): ?>
        <?php if ($_GET["page"] == "comments") : ?>     
        <strong> <?= $LANGS['linkcomments'] ?> </strong>
        <?php else : ?>
        <a href="/user/<?= $_PROFILE->Username ?>&page=comments"><?= $LANGS['linkcomments'] ?></a>
        <?php endif ?>
                <?php if ($_PROFILE->Info["c_bulletins_box"]): ?>
                <span class="delimiter">|</span>
                <?php endif ?>
        <?php endif ?>
        <?php if ($_PROFILE->Info["c_bulletins_box"]): ?>
        <?php if ($_GET["page"] == "bulletins") : ?>  
        <strong> <?= $LANGS['bulletins'] ?> </strong>   
        <?php else : ?>
        <a href="/user/<?= $_PROFILE->Username ?>&page=bulletins"><?= $LANGS['bulletins'] ?></a>
        <?php endif ?>
        <?php endif ?>
</div>
</div>    

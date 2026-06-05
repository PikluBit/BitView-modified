<?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/profile_style.php" ?>
<style>
</style>
<div id="baseDiv">
                <?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/header_profile.php" ?>

    
        <br>
        <!--Begin Page Container Table-->
<?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_profile/main_links.php" ?>  
<div style="width: 960px; text-align: left;">
    <div id="mainContent">  
        <div class="headerBox" style="width:948px;height:16px">
            <div class="BoxesInnerOpacity">
                <div class="headerTitle">
                    <?php if (!$_USER->Logged_In || $_USER->Username != $_PROFILE->Username) : ?>
                    <?php else : ?>
                    <div style="float: right; padding-right: 5px"><a href="/user/<?= $_USER->Username ?>&page=write_bulletin" class="edit"><?= $LANGS['writebulletin'] ?></a></div>
                    <?php endif ?>
                </div>
            <div class="headerTitleEdit" style="line-height: 14px;"><?= $LANGS['bulletins'] ?> (<?= $Bulletin_Amount ?>)</div>
            <div class="headerBoxOpacity"></div>
            </div>
        </div>
        <div id="commentsBoxFull" class="basicBoxes" style="width:958px">
            <div class="BoxesInnerOpacity">
            <table border="0" width="100%" class="commentsTableFull" style="border-spacing: 0;padding: 0 5px;">
                            
        <tbody>
        <?php if ($Bulletins) : ?>
        <?php foreach ($Bulletins_Pagination as $Bulletin) : ?>
        <tr class="commentsTableFull">
        <td valign="top" width="60" align="left" style="padding-bottom:15px">
            <a href="/user/<?= $Bulletin["by_user"] ?>"><img src="<?= avatar($Bulletin["by_user"]) ?>" width="90" class="vimg90"></a>
        </td>
        <td valign="top" align="left" style="padding-bottom:15px">
            <div class="comment-top" style="padding-bottom: 5px;"><a href="/user/<?= $Bulletin["by_user"] ?>" style="font-weight: bold;"><?= displayname($Bulletin["by_user"]) ?></a>
<span class="labels">(<?= get_time_ago($Bulletin["submit_date"]) ?>)</span>
                <span>
                    </span>
            </div>
                <a href="/profile?user=<?= $_PROFILE->Username ?>&page=bulletin&id=<?= $Bulletin["id"] ?>"><?= nl2br((string) $Bulletin["subject"]) ?></a>
        </td>
        </tr>
        <?php endforeach ?>
        <?php else : ?>
            <div style="font-size:15px;color:#<?= $_PROFILE->Info["c_normal_font"] ?>;text-align:center;padding:22px 0 29px"><?= $LANGS['nobulletins'] ?></div>
        <?php endif ?>
        <?php if ($Bulletins) : ?>
                <tr class="commentsTableNBFull">
                    <td colspan="4" align="left" class="buttonPost" style="padding-right: 5px; padding-left: 5px; padding-top: 4px;border-bottom:none!important">

                            <div class="pagingDiv">
                             <?php $_PAGINATION->new_show_pages_videos("user=$_PROFILE->Username&page=bulletins") ?>
        </div>


                    </td>
                </tr>
            <?php endif ?>
                
            </tbody></table>
            <div class="basicBoxesOpacity"></div>
            </div>
        </div>
    </div>
</div>
</div>

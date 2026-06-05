<?php
include $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/profile_style.php";
use function PHP81_BC\strftime;
?>
<style>
</style>
<div id="baseDiv">
                <?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/header_profile.php" ?>
    
        <br>
        <!--Begin Page Container Table-->
<?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_profile/main_links.php" ?>  
<div style="width: 960px; text-align: left;">
    <div id="mainContent">  
        <div class="headerBox" style="width:948px;">            
            <div class="BoxesInnerOpacity">
                <div class="headerTitle"><?= $LANGS['bulletinpost'] ?>
                    <?php if ($_USER->Logged_In && ($_USER->Is_Admin || $_USER->Is_Moderator || $_USER->Username == $Bulletin["by_user"])) : ?>
                    <div style="float: right; padding-right: 5px"><a href="/a/delete_bulletin?id=<?= $Bulletin["id"] ?>"><?= $LANGS['deletebulletin'] ?></a></div>
                    <?php endif ?>
                </div>
                <div class="headerBoxOpacity"></div>
            </div>                                 
    </div>

    <div id="bulletinBoxFull">
                <div id="bulletinBoxFull" class="basicBoxes" style="width:959px;">
                        <div class="BoxesInnerOpacity">
                        <table class="bulletinTableFull" width="959" border="0" cellspacing="0">
            <tbody><tr class="bulletinTableFull">
                <td class="bulletinTableFull" width="70px"><strong><?= $LANGS['from'] ?>:</strong></td>
                <td><a href="/user/<?= $Bulletin["by_user"] ?>"><?= displayname($Bulletin["by_user"]) ?></a></td>
            </tr>                       
            <tr class="bulletinTableFull">
                <td class="bulletinTableFull" width="70px"><strong><?= $LANGS['date'] ?>:</strong></td>
                <td class="bulletinTableFull">
                    <?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) {echo strftime($LANGS['timehourformat'], time_machine(strtotime((string) $Bulletin["submit_date"]))); }
                    else {echo strftime($LANGS['timehourformat'], strtotime((string) $Bulletin["submit_date"])); }  ?>
            </tr>
            <tr class="bulletinTableFull">
                <td width="90px"><strong><?= $LANGS['subject'] ?>:</strong></td>
                <td class="bulletinTableFull"><?= short_title($Bulletin["subject"],83) ?></td>
            </tr>
            <tr class="bulletinTableFull">
                <td width="70px" valign="middle"><strong><?= $LANGS['body'] ?>:</strong></td>
                <td class="bulletinTableFull">
                    <div style="overflow: flow; width: 850px">
                        <?= links(nl2br((string) $Bulletin["content"])) ?>
                    </div>
                </td>
            </tr>                   
        </tbody></table>
    </div>
    <div class="basicBoxesOpacity"></div>
    </div>  
</div>


    </div>

    <div id="mainContent">  
        <div class="headerBox" style="width:948px;">            
            <div class="BoxesInnerOpacity">
                <div class="headerTitle"><?= $LANGS['bulletincomments'] ?></div>
                <div class="headerBoxOpacity"></div>
            </div>                                 
    </div>

    <div id="bulletinBoxFull">
                <div id="bulletinBoxFull" class="basicBoxes" style="width: 958px;border: 1px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;">
                        <div class="BoxesInnerOpacity">
                        <table class="bulletinTableFull" width="960" border="0" cellspacing="0">
            <tbody>     
            <?php if ($Comments) : ?>               
                        <?php foreach ($Comments as $Comment) : ?>
        
        <tr class="commentsTableFull" id="bc_<?= $Comment["id"] ?>">
        <td width="60" valign="top" align="left">
            <div class="user-thumb-large" style="width: 46px;height: 46px;margin-bottom: 15px;">
            <a href="/user/<?= $Comment["by_user"] ?>"><img src="<?= avatar($Comment["by_user"]) ?>"></a>
            </div>
        </td>
        <td valign="top" align="left">
            <div class="smallText" style="font-weight: bold; padding-bottom: 12px;"><a href="/user/<?= $Comment["by_user"] ?>"><?= displayname($Comment["by_user"]) ?></a>
<span class="labels">(<?= get_time_ago($Comment["submit_date"]) ?>)</span> <?php if ($_USER->Logged_In && ($_USER->Is_Admin or $_USER->Is_Moderator or $_USER->Username == $_PROFILE->Username or $_USER->Username == $Comment["by_user"])) : ?><span class="labels"> <a style="float:right" href="/a/delete_bulletin_comment?id=<?= $Comment["id"] ?>" onclick="delete_channel_comment(<?= $Comment["id"] ?>)" target="_blank"><?= $LANGS['delete'] ?></a></span><?php endif ?>
                <span>
                    </span>
            </div>

                <span><?= $Comment["content"] ?></span>
        </td>
        </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                        <?php if ($_USER->Logged_In) : ?>
                            <script>
                                function delete_channel_comment(id) {
                                    document.getElementById("bc_"+id).outerHTML = "";
                                }
                            </script>
                        <?php endif ?>  

        </tbody></table>

       <table class="commentPostTable" cellpadding="0" cellspacing="0">
                    <tbody><tr class="profileHeaders">
                        <?php if (!$_USER->Logged_In) : ?>
                        <br><td colspan="3" align="center"><span class="bulletinPost" style="padding-left: 5px; padding-right: 5px"><a href="/login"><?= $LANGS['login'] ?></a> <?= $LANGS['tocommentbulletin'] ?><br></span><br></td>
                        <?php else : ?>
                            <td colspan="3" align="center"><br>
                                <div style="font-weight:bold;margin-bottom:4px;text-align:left;margin-left:5px"><?= $LANGS['addacomment'] ?></div>
                                <form action="/user/<?= $_PROFILE->Username ?>&page=bulletin&id=<?= $Bulletin["id"] ?>" method="POST" style="text-align:left;margin-left:5px">
                                    <textarea cols="45" rows="3" maxlength="500" name="content"></textarea><br/>
                                    <input style="margin-top:5px" class="yt-button yt-button-primary" type="submit" name="post_reply" value="<?= $LANGS['postreplychannel'] ?>">
                                </form><br>
                            </td>
                        <?php endif ?>
                    </tr>
    </div>
    <div class="basicBoxesOpacity"></div>
    </div>  
</div>



        
        
        
    </div>
    </div>

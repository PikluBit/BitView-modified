<?php use function PHP81_BC\strftime; ?>
<style type="text/css">
.videoModifiers {
    background: #cccccc;
    border: 0;
    border-radius: 8px;
    height: 19px;
    float: right;
    width: 750px;
    padding: 7px 0px 6px 0px;
    border-bottom: 1px solid #ccc;
    text-align: left;
}
.videoModifiers .first {
    border-left: 0px;
    padding: 0px 10px 0px 2px;
}

.videoModifiers .subcategory {
    font-size: 14px;
    float: left;
    height: 25px;
    margin-top: -12px;
    padding: 13px 13px 0 13px;
    font-weight: bold;
}
</style>
<div class="videoModifiers">
            <div class="subcategory first">
                    <a href="/groups" style="font-weight:bold"><?= $LANGS['groups'] ?></a>
            </div>
            <div class="subcategory-left-cap" style="display:block">
                </div>
            <div class="subcategory" id="selected">
                    <a href="/my_groups"><?= $LANGS['joinedgroups'] ?></a>
            </div>
                        <div class="subcategory-right-cap" style="display:block">
            </div>
</div>
<div id="left-column">
        <?php if (!isset($_GET["b"]) || $_GET["b"] != null) : ?>
        <div><a href="/groups"><?= $LANGS['recentgroups'] ?></a></div>
        <?php else : ?>
        <div class="category-selected"><?= $LANGS['recentgroups'] ?></div>
        <?php endif ?>

        <?php if (!isset($_GET["b"]) || $_GET["b"] != "members") : ?>
        <div><a href="?b=members"><?= $LANGS['mostmembers'] ?></a></div>
        <?php else : ?>
        <div class="category-selected"><?= $LANGS['mostmembers'] ?></div>
        <?php endif ?>

        <?php if (!isset($_GET["b"]) || $_GET["b"] != "videos") : ?>
        <div><a href="?b=videos"><?= $LANGS['mostvideos'] ?></a></div>
        <?php else : ?>
        <div class="category-selected"><?= $LANGS['mostvideos'] ?></div>
        <?php endif ?>

        <?php if (!isset($_GET["b"]) || $_GET["b"] != "topics") : ?>
        <div><a href="?b=topics"><?= $LANGS['groupmostdiscussed'] ?></a></div>
        <?php else : ?>
        <div class="category-selected"><?= $LANGS['groupmostdiscussed'] ?></div>
        <?php endif ?>

        <!-- Categories -->
               <div style="padding-top: 12px;">
                <input type="submit" class="yt-button yt-button-primary" name="creategroup" value="<?= $LANGS['createagroup'] ?>" onclick="window.location.href='/groups_create'">
            </div>
</div>

<div id="body-column" style="margin-top: 0; float: right;">
    <div id="browseMain">

    <?php if ($Groups) : ?>
    <?php foreach ($Groups as $Group) : ?>     

    <div class="vEntry">
        <table class="vTable"><tbody><tr>
        <td><div class="v120WrapperOuter"><div class="v120WrapperInner">
                <a href="/group?id=<?= $Group["id"] ?>"><img class="vimg120" src="<?= cache_bust("/u/grp/".$Group["id"].".jpg") ?>" alt="vstill"></a>
            </div></div></td>
        <td class="vinfo">  <div class="vtitle" style="font-weight: normal;height: 14px;"><a href="/group?id=<?= $Group["id"] ?>"><?= $Group["title"] ?></a></div>   
    <div class="vdesc">                 
        
    <span id="BeginvidDesc<?= $Group["id"] ?>"><?= nl2br((string) short_title($Group["description"], 200)) ?></span>

</div>
    <div class="vfacets">
        <span class="grayText"><?= $LANGS['groupcreated'] ?>:</span> 
        <?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['longtimeformat'], time_machine(strtotime((string) $Group["creation_date"]))); }
                    else {echo strftime($LANGS['longtimeformat'], strtotime((string) $Group["creation_date"])); }  ?>
        <br>
        <a href="/group?id=<?= $Group["id"] ?>&action=videos"><?= $LANGS['groupvideos'] ?>: <?= $DB->execute("SELECT count(video) as amount FROM groups_videos WHERE group_id = :ID", true, [":ID" => $Group["id"]])["amount"] ?></a> | <a href="/group?id=<?= $Group["id"] ?>&action=members"><?= $LANGS['groupmembers'] ?>: <?= $DB->execute("SELECT count(member) as amount FROM groups_members WHERE group_id = :ID", true, [":ID" => $Group["id"]])["amount"] ?></a> | <a href="/group?id=<?= $Group["id"] ?>"><?= $LANGS['discussions'] ?>: <?= $DB->execute("SELECT count(id) as amount FROM groups_topics WHERE group_id = :ID", true, [":ID" => $Group["id"]])["amount"] ?></a>
    </div>
</td>
        </tr></tbody></table>
    </div> <!-- end vEntry -->
    <?php endforeach ?>
    <?php else : ?>
        <div style="font-size:14px;text-align:center;padding:22px 0 16px"><?= $LANGS['nogroups'] ?></div>
    <?php endif ?>

    </div> <!-- end browseMain -->
<?php if ($Groups) : ?>
<div class="searchFooterBox">
            <div class="pagingDiv">
 <?php if (isset($_GET["c"]) && $_GET["c"] != 0) { $_PAGINATION->new_show_pages_videos('c='.$_GET["c"].''); } else { $_PAGINATION->new_show_pages_videos(''); } ?>

                        </div>
        </div>
<?php endif ?>
</div>

<div id="right-column">
        <!-- For doubleclick testing purposes only will take out in two weeks-->




    <!-- Begin ad tag -->

    <!-- End ad tag -->



</div>
<div class="clear"></div>

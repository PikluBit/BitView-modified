<?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/profile_style.php" ?>
<div id="baseDiv">
                <?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/header_profile.php" ?>
    
        <br>
        <!--Begin Page Container Table-->
<?php include $_SERVER['DOCUMENT_ROOT']."/_templates/_profile/main_links.php" ?>  
<div class="video-page" style="width: 958px;">
        <div class="BoxesInnerOpacity">
            <div class="headerRCBox"> <div class="content">  <div class="headerTitleEdit">
        <span><?= $LANGS['playlists'] ?></span>
    </div>
</div>
    </div>

        <div class="headerBoxOpacity"></div>
        </div>
        <div class="basicBoxes" style="width:960px;text-align:left;">
         <?php if ($Playlists) : ?>
            <div class="BoxesInnerOpacity">
                    <table width="940" border="0" class="playlists" align="center">
        <tbody>
    <?php $Count = 0; ?>
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
        <tr valign="top" class="vDetailEntry">
                    <td><div style="margin-right: 10px;"><div class="vCluster120WideEntry"><div class="vCluster120WrapperOuter"><div class="vCluster120WrapperInner"><a id="video-url" href="/view_playlist?id=<?= $Playlist["id"] ?>" rel="nofollow"><img title="<?= $Playlist["title"] ?>" src="/u/thmp/<?= $Video1 ?>.jpg" class="vimgCluster120" alt="<?= $Playlist["title"] ?>"></a><div class="video-corner-text"><span><?= $DB->execute("SELECT count(url) as amount FROM playlists_videos WHERE playlist_id = :ID", true, [":ID" => $Playlist["id"]])["amount"] ?> <?= $LANGS['plvideoamount'] ?></span></div></div></div></div></div></td>
                <td width="100%">
                    <div class="pltitle">
                        <a href="/view_playlist?id=<?= $Playlist["id"] ?>"><?= $Playlist["title"] ?></a> <span dir="ltr" class="vlfacets" style="font-weight: bold;">
                        <?= $DB->execute("SELECT count(url) as amount FROM playlists_videos WHERE playlist_id = :ID", true, [":ID" => $Playlist["id"]])["amount"] ?> <?= $LANGS['plvideos'] ?></span>
                    </div>
                    <div class="video-facets" style="margin-top: 4px;"><?php if (empty($Playlist["description"])) : ?><?php else : ?><?= $Playlist["description"] ?><?php endif ?></div>
                </td>
                <td valign="middle" nowrap="" align="right">
                    <div class="playlistLinks">
                        <a href="/watch?v=<?= $Video1 ?>&pl=<?= $Playlist["id"] ?>"><?= $LANGS['playall'] ?></a>
                    </div>
                </td>
                </tr>
    <?php if ($Count == 3) : ?>
    <?php $Count = 0 ?>
     <?php endif ?>
    <?php endforeach ?>
    </tr>
    <tr>
    </tr>
</tbody></table><div class="basicBoxesOpacity"></div></div>
                <?php else : ?>
                    <div style="font-size:15px;color:#444;text-align:center;padding:22px 0 29px"><?= $LANGS['noplchannel'] ?></div>
                <?php endif ?>


        
        
        
        <div style="visibility:hidden">
        <img src="" border="0" width="1" height="1">
        </div>
    </div>
    </div>

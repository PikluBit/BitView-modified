<style type="text/css">
.videoModifiers {
    padding: 5px 0px;
    border-bottom: 1px solid #ccc;
    text-align: center;
}
.videos_box_title {
    width:90%
}
.videoModifiers div.first {
    border-left: 0px;
    padding: 0px 10px 0px 2px;
}
.videoModifiers div.subcategory {
    border-left: 1px solid #ccc;
    padding: 0px 10px;
    font-size: 11px;
    display: inline;
}
.videoModifiers .selected {
    font-weight: bold;
}
</style><!-- left column - FOR ADS ONLY IF MY SUBS -->
<div id="nav-pane">
                <div class="header">
                    <div class="action-button" id="button-new">
                        <span class="yt-menubutton yt-menubutton-primary" id="" style="" onmouseenter="this.className += ' yt-menubutton-primary-hover';" onmouseleave="this.className = this.className.replace(' yt-menubutton-primary-hover', '');"><a class="yt-menubutton-btn yt-button yt-button-primary" href="#" onclick=""><span><?= $LANGS['new'] ?></span></a><a class="yt-menubutton-arr yt-button yt-button-primary" href="#" onclick=""><button></button><span></span></a>
                            <ul class="yt-menubutton-menu">
                                <li><a href="/create_playlist"><?= $LANGS['playlist'] ?></a></li>
                                <li><a href="/my_videos_upload" onclick=""><?= $LANGS['videoupload'] ?></a></li>
                            </ul>
                        </span>
                    </div>
                </div>
                <div id="list-pane">
                    <div class="folder"><a class="name" href="/my_videos"><?= $LANGS['uploadedvideos'] ?></a></div>
                    <div class="folder"><a class="name" href="/my_favorites"><?= $LANGS['favorites'] ?></a></div>
                    <div class="folder selected"><a class="name" href="/my_playlists"><?= $LANGS['playlists'] ?></a></div>
                    <?php if ($Playlists) : ?>
                        <?php foreach ($Playlists as $Playlist) : ?>
                        <div class="subfolder channel-subfolder"><a class="name" href="/my_playlist?id=<?= $Playlist["id"] ?>"><?= $Playlist["title"] ?></a></div>
                            <?php endforeach ?>
                     <?php endif ?>
                    <div class="folder"><a class="name" href="/my_subscriptions"><?= $LANGS['subscriptions'] ?></a></div>
                    <div class="folder"><a class="name" href="/my_quicklist"><?= $LANGS['quicklist'] ?></a></div>
                    <div class="folder"><a class="name" href="/viewing_history"><?= $LANGS['history'] ?></a></div>

                </div>
            </div>
<div id="view-pane" style="margin-bottom: 10px;">
                <div class="header yt2009-sub-header">
                    <div class="pager"></div>
                    <h2><?= $LANGS['playlists'] ?></h2>
                </div>
                <div class="splitter">
                    <div class="view">
                        <div class="settings">
                            <div class="search">
                            </div>
                        </div>
                        <div id="video_grid" class="marT10 browseListView">
<?php if ($Playlists) : ?>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tbody>
                <tr valign="top"><td>
                <?php foreach ($Playlists as $Playlist) : ?>
                <?php
                    $Videos = $DB->execute("SELECT url FROM playlists_videos WHERE playlist_id = :ID ORDER BY position DESC",false,array(":ID" => $Playlist["id"]));
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
        <div class="vlcell">
            
    <div class="vlentry">
        <div class="v120WideEntry">
            <div class="v120WrapperOuter"><div class="v120WrapperInner">
                <?php if (isset($Video1) && $Video1) : ?>
                <a href="/my_playlist?id=<?= $Playlist["id"] ?>">
                    <img src="/u/thmp/<?= $Video1 ?>.jpg" class="vimg120" title="" alt="video">
                </a>
                <?php else : ?>
                    <img src="/img/nothump.png" class="vimg120" title="<?= $Video["title"] ?>" alt="video">
                <?php endif ?> 
                
                </div></div>
        </div>

        <div class="vldescbox">
            <div class="vltitle">
                <div class="vllongTitle">
                    <a href="/my_playlist?id=<?= $Playlist["id"] ?>" title="<?= $Playlist["title"] ?>"><?= short_title($Playlist["title"],60) ?></a>
                </div>
            </div>

            <div class="vldesc">
                                    
        
    <span id="BeginvidDesc<?= $Video["url"] ?>">
    <?php if (empty($Playlist["description"])) : ?>...<?php else : ?><?= $Playlist["description"] ?><?php endif ?>
    </span>

            <span id="RemainvidDesc<?= $Video["url"] ?>" style="display: none"><?php if (empty($Playlist["description"])) : ?>...<?php else : ?><?= $Playlist["description"] ?><?php endif ?></span>



            </div>
        </div>

        <div class="vlfacets">
                     <?php if (!empty($Playlist["tags"])) : ?>
            <div class="vladded">
                
                <span class="grayText"><?= $LANGS["tags"] ?>:</span> <?php foreach (explode(",",(string) $Playlist["tags"]) as $Tag) : ?>
                                                            <a href="/results?search=<?= urlencode($Tag) ?>&t=Search+Videos" style="font-size:12px"><?= $Tag ?></a> 
                                        <?php endforeach ?>
                                        <!--dyn--><br>
            </div>
            <?php endif ?>
                <div><span class="grayText vlfromlbl"><?= $LANGS["addedpl"] ?>: </span><span class="vlfrom"><?= get_time_ago($Playlist["submit_date"]) ?>
</span></div><div>
            <span class="grayText"><?= $LANGS["frompl"] ?>:</span> <a href="/user/<?= $_USER->Username ?>"> <?= displayname($_USER->Username) ?></a><br>

        </div>
    </div>
        <div class="vlclearaltl"></div>


        
    </div> <!-- end vEntry -->
<div class="vlclear"></div>
<?php endforeach ?>
</td>
</tr>
</tbody>
</table>
<?php else : ?>
                    <div style="font-size:15px;color:#444;text-align:center;padding:22px 0 16px"><?= $LANGS['nopl'] ?></div>
            <?php endif ?>
</div>
        <div class="searchFooterBox">      
        <?php if ($Playlists) : ?>
    <?php endif ?>
                        <div class="footer" style="border-left: none;">
                            <div class="pager"><?php $_PAGINATION->new_show_pages_videos() ?></div>
                        </div>
                    </div>
                </div>
            </div>
</div>
<!-- START AD COLUMN RIGHT -->
<div id="right-column">
    
    <div id="sideAd" z-index="10" style="width: auto; height: auto;">       
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- bitviewside -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:120px;height:240px;margin:10px 0"
                 data-ad-client="ca-pub-8433080377364721"
                 data-ad-slot="9813736805"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>



<div class="clear"></div>
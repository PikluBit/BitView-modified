<div id="nav-pane" style="margin-top: 12px;">
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
                        <div class="subfolder channel-subfolder"><a class="name" href="/view_playlist?id=<?= $Playlist["id"] ?>"><?= $Playlist["title"] ?></a></div>
                            <?php endforeach ?>
                     <?php endif ?>
                    <div class="folder"><a class="name" href="/my_subscriptions"><?= $LANGS['subscriptions'] ?></a></div>
                    <div class="folder"><a class="name" href="/my_quicklist"><?= $LANGS['quicklist'] ?></a></div>
                    <div class="folder"><a class="name" href="/viewing_history"><?= $LANGS['history'] ?></a></div>

                </div>
            </div>
<div id="view-pane" style="margin-bottom: 10px;margin-top: 12px;">
    <div class="header yt2009-sub-header">
                    <div class="pager"></div>
                    <h2><?= $LANGS['playlists'] ?></h2>
                </div>
<div class="splitter">
    <div class="view">
                                <div id="grid-view" style="background: white;padding: 25px;">
<div style="overflow:hidden;width:auto;margin:0 auto">
    <h2 style="margin:0 0 2px"><?= $LANGS['pledittitle'] ?></h2>
    <div style="margin-bottom:3px"><?= $LANGS['pleditdesc'] ?></div>
    <form action="/edit_playlist" method="POST">
        <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
        <table cellpadding="4px" style="position:relative;right:4px">
            <tr>
                <td><b><?= $LANGS['title'] ?>:</b></td>
                <td><input type="text" name="title" maxlength="100" value="<?= $This_Playlist["title"] ?>"></td>
            </tr>
            <tr>
                <td valign="top"><b><?= $LANGS['desc'] ?>:</b></td>
                <td><textarea name="description" maxlength="500" cols="50" rows="4"><?= $This_Playlist["description"] ?></textarea></td>
            </tr>
            <tr>
                <td><b><?= $LANGS['tags'] ?>:</b></td>
                <td><input type="text" name="tags" maxlength="256" value="<?= $This_Playlist["tags"] ?>"></td>
            </tr>
            <tr>
                <td colspan="3"><input type="submit" class="yt-button yt-button-primary" name="edit_playlist" value="<?= $LANGS['saveinfo'] ?>"> <a href="/my_playlist?id=<?= $This_Playlist["id"] ?>"><button class="yt-button yt-button-primary" type="button"><?= $LANGS['cancel'] ?></button></a> <a href="/a/delete_playlist?id=<?= $This_Playlist["id"] ?>" class="yt-button yt-button-primary" style="height: 23px;line-height: 23px;"><?= $LANGS['delete'] ?></a></td>
            </tr>
        </table>
    </form>
</div>
</div>
</div>
</div>
</div>
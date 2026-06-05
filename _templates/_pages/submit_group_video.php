<div style="overflow:hidden;width:865px;margin:0 auto">
    <h2 style="margin:0 0 2px"><?= $LANGS['submitvideotitle'] ?></h2>
    <form action="/submit_group_video" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
        <table cellpadding="4px" style="position:relative;right:4px">
            <tr>
                <td><b><?= $LANGS['videourl'] ?>:</b></td>
                <td><input type="text" name="url" maxlength="255" size="33"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" class="yt-button yt-button-primary" name="submit_video" value="<?= $LANGS['submitvideo'] ?>"> <a href="/group?id=<?= $_GET["id"] ?>"><button class="yt-button yt-button-primary" type="button"><?= $LANGS['cancel'] ?></button></a></td>
            </tr>
        </table>
    </form>
</div>
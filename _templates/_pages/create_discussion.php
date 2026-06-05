<div style="overflow:hidden;width:865px;margin:0 auto">
    <h2 style="margin:0 0 2px"><?= $LANGS['creatediscussion'] ?></h2>
    <div style="margin-bottom:3px"><?= $LANGS['creatediscussiondesc'] ?></div>
    <form action="/create_discussion.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
        <table cellpadding="4px" style="position:relative;right:4px">
            <tr>
                <td><b><?= $LANGS['discussiontitle'] ?>:</b></td>
                <td><input type="text" name="title" maxlength="100" size="33"></td>
            </tr>
            <tr>
                <td valign="top"><b><?= $LANGS['desc'] ?>:</b></td>
                <td><textarea name="description" maxlength="5000" cols="50" rows="7"></textarea></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" class="yt-button yt-button-primary" name="create_discussion" value="<?= $LANGS['creatediscussion'] ?>"> <a href="/group?id=<?= $_GET["id"] ?>"><button class="yt-button yt-button-primary" type="button"><?= $LANGS['cancel'] ?></button></a></td>
            </tr>
        </table>
    </form>
</div>
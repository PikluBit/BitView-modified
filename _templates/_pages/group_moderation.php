<div style="overflow:hidden;width:865px;margin:0 auto">
    <h2 style="margin:0 0 2px"><?= $LANGS["groupmoderation"] ?> - <a href="/group?id=<?= $_GET["id"] ?>"><?= $Group["title"] ?></a></h2>
    <form action="/group_moderation" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
        <table cellpadding="4px" style="position:relative;right:4px">
            <tr>
                <td><b><?= $LANGS['groupname'] ?>:</b></td>
                <td><input type="text" name="name" maxlength="100" size="33" value="<?= $Group["title"] ?>"></td>
            </tr>
            <tr>
                <td valign="top"><b><?= $LANGS["desc"] ?>:</b></td>
                <td><textarea name="description" maxlength="5000" cols="50" rows="7"><?= $Group["description"] ?></textarea></td>
            </tr>
            <tr>
                <td><b><?= $LANGS['category'] ?>:</b></td>
                <td>
                    <select name="category">
                        <?php foreach ($Group_Category as $ID => $Category) : ?>
                            <option value="<?= $ID ?>" <?php if ($Group["categories"] == $ID) : ?> selected<?php endif ?>><?= $Category ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b><?= $LANGS["approvemembers"] ?>:</b></td>
                <td><label><input type="radio" name="instant" value="0" <?php if ($Group["instant_join"] == 0) : ?>checked<?php endif ?>> <span style="position:relative;bottom:2px"><?= $LANGS["yes"] ?></span></label> <label><input type="radio" name="instant" value="1" <?php if ($Group["instant_join"] == 1) : ?>checked<?php endif ?>> <span style="position:relative;bottom:2px"><?= $LANGS["no"] ?></span></label></td>
            </tr>
            <tr>
                <td><b><?= $LANGS["approvevideos"] ?>:</b></td>
                <td><label><input type="radio" name="instant_video" value="0" <?php if ($Group["instant_video"] == 0) : ?>checked<?php endif ?>> <span style="position:relative;bottom:2px"><?= $LANGS["yes"] ?></span></label> <label><input type="radio" name="instant_video" value="1" <?php if ($Group["instant_video"] == 1) : ?>checked<?php endif ?>> <span style="position:relative;bottom:2px"><?= $LANGS["no"] ?></span></label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" class="yt-button yt-button-primary" name="change_info" value="<?= $LANGS["changeinfo"] ?>"></td>
            </tr>
        </table>
    </form>
    <br /><br />
    <form action="/group_moderation" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
        <table cellpadding="4px" style="position:relative;right:4px">
            <tr>
                <td><b><?= $LANGS["image"] ?>:</b></td>
                <td><input type="file" name="image"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" class="yt-button yt-button-primary" name="change_image" value="<?= $LANGS["changeimage"] ?>"></td>
            </tr>
        </table>
    </form>
    <br /><br />
    <form action="/group_moderation" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
        <table cellpadding="4px" style="position:relative;right:4px">
            <tr>
                <td valign="top"><b><?= $LANGS["groupmessage"] ?>:</b></td>
                <td><textarea name="message" maxlength="500" cols="50" rows="7"></textarea></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" class="yt-button yt-button-primary" name="send_message" value="<?= $LANGS["sendmessagetomembers"] ?>"></td>
            </tr>
        </table>
    </form><br>
    <button class="yt-menubutton-btn yt-button yt-button-primary" onclick="if (confirm('Are you sure you want to delete this group?')) { location.href='/a/delete_group?group=<?= $Group["id"] ?>'; }"><?= $LANGS["delgroup"] ?></button> <a href="/group?id=<?= $_GET["id"] ?>"><button class="yt-menubutton-btn yt-button yt-button-primary" type="button"><?= $LANGS["cancel"] ?></button></a>
</div>

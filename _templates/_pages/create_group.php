<div style="overflow:hidden;width:865px;margin:0 auto">
    <h2 style="margin:0 0 2px"><?= $LANGS['creategroup'] ?></h2>
    <div style="margin-bottom:3px"><?= $LANGS['creategroupdesc'] ?></div>
    <form action="/groups_create.php" method="POST" enctype="multipart/form-data">
        <table cellpadding="4px" style="position:relative;right:4px">
            <tr>
                <td><b><?= $LANGS['groupname'] ?>:</b></td>
                <td><input type="text" name="name" maxlength="100" size="33" value="<?php if (isset($_POST["name"])) : ?><?= $_POST["name"] ?><?php endif ?>"></td>
            </tr>
            <tr>
                <td valign="top"><b><?= $LANGS['desc'] ?>:</b></td>
                <td><textarea name="description" maxlength="5000" cols="50" rows="7"><?php if (isset($_POST["description"])) : ?><?= $_POST["description"] ?><?php endif ?></textarea></td>
            </tr>
            <tr>
                <td><b><?= $LANGS['category'] ?>:</b></td>
                <td>
                    <select name="category">
                        <?php foreach ($Group_Category as $ID => $Category) : ?>
                            <option value="<?= $ID ?>" <?php if (isset($_POST["category"]) && $_POST["category"] == $ID) : ?> selected<?php endif ?>><?= $Category ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b><?= $LANGS['groupimage'] ?>:</b></td>
                <td><input type="file" name="image"></td>
            </tr>
            <tr>
                <td><b><?= $LANGS['approvemembers'] ?>:</b></td>
                <td><label><input type="radio" name="instant" value="0"> <span style="position:relative;bottom:2px"><?= $LANGS['yes'] ?></span></label> <label><input type="radio" name="instant" value="1" checked> <span style="position:relative;bottom:2px"><?= $LANGS['no'] ?></span></label></td>
            </tr>
            <tr>
                <td><b><?= $LANGS['approvevideos'] ?>:</b></td>
                <td><label><input type="radio" name="instant_video" value="0" checked> <span style="position:relative;bottom:2px"><?= $LANGS['yes'] ?></span></label> <label><input type="radio" name="instant_video" value="1"> <span style="position:relative;bottom:2px"><?= $LANGS['no'] ?></span></label></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" class="yt-button yt-button-primary" name="create_group" value="<?= $LANGS['creategroup'] ?>"> <a href="/groups"><button class="yt-button yt-button-primary" type="button"><?= $LANGS['cancel'] ?></button></a></td>
            </tr>
        </table>
    </form>
</div>
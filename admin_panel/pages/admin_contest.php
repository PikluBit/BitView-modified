<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
if (!$_USER->Logged_In || (!$_USER->Is_Moderator && !$_USER->Is_Admin)) {
    header("location: /");
    exit();
}
?>
<div>
    <style>
    #contestform input[type=text] {
        font-family: Arial, sans-serif;
        width: 700px;
        border: 1px solid #999;
        margin-bottom: 8px;
    }
    #contestform textarea {
        font-family: Arial, sans-serif;
        width: 700px;
        border: 1px solid #999;
        margin-bottom: 8px;
    }
    </style>
    <div class="a_box">
        <div class="a_box_title">Contest Manager</div>
        <form id="contestform" action="/admin_panel/?page=contest" method="post" style="border-bottom:1px solid #CCC;padding:10px">
            <input type="text" name="tag" placeholder="Tag" size="44" maxlength="20"><br />
            <input type="text" name="datemonth" placeholder="Month and Year" size="44" maxlength="20"><br />
            <textarea name="whatisthis" cols="44" rows="6" placeholder="What Is This" maxlength="200" style="resize: vertical"></textarea><br />
            <input type="text" name="howtoenter" placeholder="How To Enter" size="44" maxlength="200"><br />
            <textarea name="thismonth" cols="44" rows="6" placeholder="This Month" maxlength="200" style="resize: vertical"></textarea><br />
            <textarea name="lastcontestwinners" cols="44" rows="6" placeholder="Last Month Winners (if there was any)" maxlength="200" style="resize: vertical"></textarea><br />
            <input type="submit" name="contest_submit" class="yt-button" style="padding:0.3888em 0.8333em; font-size: 12px; margin: 0;" value="Submit Contest">
        </form>
        <div style="max-height:174px;overflow-y:auto">
            <table width="100%" class="atable">
                <tr>
                    <td align="center" width="50%"><b>Month</b></td>
                    <td align="center"><b>Tag</b></td>
                </tr>
                <?php foreach ($Latest_Contest as $Blog_Post) : ?>
                    <tr>
                        <td align="center"><?= $Blog_Post["datemonth"] ?></td>
                        <td align="center"><?= $Blog_Post["tag"] ?></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>
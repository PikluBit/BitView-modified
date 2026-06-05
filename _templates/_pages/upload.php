<style>
    #upload_left_side {
        float: left;
    }
    #upload_right_side {
        float: right;
        /*margin-left: 15px;*/
        width: 300px;
    }
</style>
<script>
    function moreless_options() {
        var x = document.getElementById("date_and_map_options_hidden");
        var xs = document.getElementById("date_and_map_options");
        if (x.style.display === "block") {
            x.style.display = "none";
            xs.style.display = "block";
            document.getElementById("dnm_options").innerHTML = "<?= $LANGS['lessoptions'] ?>";
        } else {
            x.style.display = "block";
            xs.style.display = "none";
            document.getElementById("dnm_options").innerHTML = "<?= $LANGS['chooseoptions'] ?>";
        }
    }
</script>
<div id="upload_left_side">
    <?php if (!isset($_POST["upload_video"]) && !isset($_POST["upload_video2"])) : ?>
    <span class="xxlargeText bold"><?= $LANGS['uploadpagetitle'] ?></span> <span class="xlargeText" style="color: #999;">(<?= $LANGS['step1of2'] ?>)</span>
    <form action="/my_videos_upload_basic" method="post">
        <div style="background-color: #dee0fd;padding: 10px;border-radius: 8px;margin-top: 10px;width: 540px;">
            <table style="margin:0 auto" width="425px" cellspacing="0" cellpadding="5" border="0">
                <tbody><tr>
                    <td width="125px" align="right"><span style="font-size: 12px;font-weight:bold;"><?= $LANGS['title'] ?>:*</span></td>
                    <td><input type="text" name="title" maxlength="100" style="width:295px"></td>
                </tr>
                <tr>
                    <td valign="top" align="right"><span style="font-size: 12px;font-weight:bold;"><?= $LANGS['desc'] ?>:*</span></td>
                    <td><textarea name="description" maxlength="2048" style="width:365px;overflow:hidden;resize:none" rows="3"></textarea></td>
                </tr>
                <tr>
                    <td width="" align="right" style="white-space: nowrap;"><span style="font-size: 12px;font-weight:bold;"><?= $LANGS['videocategory'] ?>:*</span></td>
                    <td>
                        <select id="categories" name="category" style="width: 170px">
                            <?php foreach ($Categories as $ID => $Category) : ?>
                                <option value="<?= $ID ?>" name="category" ><?= $Category ?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td valign="top" align="right"><span style="font-size: 12px;font-weight:bold;;position:relative;top:3px"><?= $LANGS['tags'] ?>:</span></td>
                    <td>
                        <input type="text" name="tags" maxlength="128" style="width:295px"><br>
                        <div style="margin:5px 0 0 0;font-size:11px"><?= $LANGS['tagsdesc'] ?></div>
                    </td>
                </tr>

                </tbody></table>
            <span style="float: right;font-style: italic;font-size: 10px;"><?= $LANGS['requiredfield'] ?></span>
            <div style="clear: both;"></div>
        </div>

        <!--<div style="background-color: #dee0fd;padding: 10px;border-radius: 8px;margin-top: 10px;width: 540px;">
        <table width="250px" cellspacing="0" cellpadding="5" border="0">
          <a onclick="return false;" style="font-size: 11px; float: right;color: #03C;text-decoration: underline;">choose options</a>
          <tbody>
            <tr>
              <td><span style="font-weight: bold;font-size: 12px;">Broadcast Options:</span></td>
              <td><span style="font-size: 12px;">Public by default</span></td>
            </tr>
          </tbody>
        </table>
        <div style="clear: both;"></div>
        </div>-->

        <div style="background-color: #dee0fd;padding: 10px;border-radius: 8px;margin-top: 10px;width: 540px;">
            <table width="250px" cellspacing="0" cellpadding="5" border="0">
                <a onclick="moreless_options()" id="dnm_options" style="font-size: 11px; float: right;color: #03C;text-decoration: underline;cursor:pointer;"><?= $LANGS['chooseoptions'] ?></a>
                <div id="date_and_map_options_hidden" style="display: block;">
                    <tbody>
                    <tr>
                        <td><span style="font-weight: bold;font-size: 12px;white-space: nowrap;"><?= $LANGS['datemapoptions'] ?>:</span></td>
                        <td><span style="font-size: 12px;white-space: nowrap;"><i><?= $LANGS['optional'] ?></i></span></td>
                    </tr>
                    </tbody>
            </table>
        </div>
        <div id="date_and_map_options" style="display: none;">
            <div style="background-color: #dee0fd;padding: 10px;border-radius: 8px;margin-top: 10px;width: 540px;">
                <table width="250px" cellspacing="0" cellpadding="5" border="0">
                    <tbody>
                    <tr>
                        <td width="" align="right" style="white-space: nowrap;"><span style="font-size: 12px;font-weight:bold;"><?= $LANGS['recordedon'] ?>:</span></td>
                        <td>
                            <select name="month">
                                <option value="0">---</option>
                                <?php foreach($Months as $item => $value) : ?>
                                    <option value="<?= $value ?>"><?= $item ?></option>
                                <?php endforeach ?>
                            </select>
                            <select name="day">
                                <option value="0">---</option>
                                <?php for ($x = 1; $x <= 31; $x++) : ?>
                                    <option value="<?= $x ?>"><?= $x ?></option>
                                <?php endfor ?>
                            </select>
                            <select name="year">
                                <option value="0">---</option>
                                <?php for($x = date("Y");$x >= 1910;$x--) : ?>
                                    <option value="<?= $x ?>"><?= $x ?></option>
                                <?php endfor ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td width="" align="right" style="white-space: nowrap;"><span style="font-size: 12px;font-weight:bold;"><?= $LANGS['addressrecorded'] ?>:</span></td>
                        <td><input type="text" name="address" maxlength="100" style="width:295px" /></td>
                    </tr>

                    <tr>
                        <td width="" align="right" style="white-space: nowrap;"><span style="font-size: 12px;font-weight:bold;"><?= $LANGS['country'] ?>:</span></td>
                        <td>
                            <select name="country">
                                <option>---</option>
                                <?php foreach ($Countries as $val => $name) : ?>
                                    <option value="<?= $val ?>"><?= $name ?></option>
                                <?php endforeach ?>
                            </select>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>


        <div style="clear: both;"></div>
        <div style="margin-left: 25%;margin-top: 10px;"><input type="submit" name="upload_video" value="<?= $LANGS['uploadcontinue'] ?>" style="margin: 15px 0 0 0" /></div>
    </form>
</div>
<div id="upload_right_side">
        <div style="margin-top: 32px;">
            <span class="xxlargeText bold" style=""><?= $LANGS['aboutuploading'] ?></span>
            <div style="word-wrap: break-word;margin-top: 15px;"><?= $LANGS['uploaddesc1'] ?></div>
            <div style="word-wrap: break-word;font-weight: bold;margin-top: 15px;"><?php if ($_USER->Info['is_partner']): ?><?= $LANGS['partnervideolimit1'] ?><?php else : ?><?= $LANGS['videolimit1'] ?><?php endif ?></div>
            <div style="word-wrap: break-word;margin-top: 15px;color: #8a8888;"><?= $LANGS['myvideosdesc'] ?></div>
            <div style="word-wrap: break-word;margin-top: 15px;color: #8a8888;"><a href="/my_videos_upload" class="yt-button" style="padding: 4px 8px;"><?= $LANGS['newuploader'] ?></a></div>
        </div>
    </div>

<?php elseif (!isset($_POST["upload_video2"])) : ?>
    <span class="xxlargeText bold"><?= $LANGS['uploadpagetitle'] ?></span> <span class="xlargeText" style="color: #999;">(<?= $LANGS['step2of2'] ?>)</span>

    <form action="/my_videos_upload_basic" method="post" enctype="multipart/form-data" onsubmit="document.getElementById('upload_video2').disabled = true;">
        <input type="hidden" name="title" value="<?= $Validation["title"] ?>" />
        <input type="hidden" name="description" value="<?= $Validation["description"] ?>" />
        <input type="hidden" name="tags" value="<?= $Validation["tags"] ?>" />
        <input type="hidden" name="category" value="<?= $Validation["category"] ?>" />
        <input type="hidden" name="day" value="<?= $Validation["day"] ?>" />
        <input type="hidden" name="month" value="<?= $Validation["month"] ?>" />
        <input type="hidden" name="year" value="<?= $Validation["year"] ?>" />
        <input type="hidden" name="address" value="<?= $Validation["address"] ?>" />
        <input type="hidden" name="country" value="<?= $Validation["country"] ?>" />
        <input type="hidden" name="upload_video2">

        <div style="background-color: #dee0fd;padding: 10px;border-radius: 8px;margin-top: 10px;width: 540px;">
            <table style="margin:0 auto" width="425px" cellspacing="0" cellpadding="5" border="0">
                <tbody>
                <tr>
                    <td width="" align="right" style="white-space: nowrap;"><span style="font-size: 12px;font-weight:bold;"><?= $LANGS['file'] ?>:</span></td>
                    <td><input type="file" id="video_file" name="video_file" accept="video/mpeg,video/x-ms-wmv,video/avi,video/quicktime,video/mp4,video/m4v" /></td>
                </tr>
                <tr>
                    <td width="" align="right" style="white-space: nowrap;"><span style="font-size: 12px;font-weight:bold;"><?= $LANGS['broadcastoptions'] ?>:</span></td>
                    <td>
                        <select name="broadcast">
                            <option value="1"><?= $LANGS['public'] ?></option>
                            <option value="2"><?= $LANGS['private'] ?></option>
                        </select>
                    </td>

                </tr>
                </tbody>
            </table>
        </div>

        <div style="clear: both;"></div>
        <div style="margin-left: 25%;margin-top: 10px;"><input type="submit" value="<?= $LANGS['uploadvideo'] ?>" id="upload_video2" onclick="if(document.getElementById('video_file').value == '') { alert('<?= $LANGS['needfilevideotoupload'] ?>'); return false; }" /></div>
    </form>
    </div>
    <div id="upload_right_side">
        <div style="margin-top: 32px;">
            <span class="xxlargeText bold" style=""><?= $LANGS['aboutuploading'] ?></span>
            <div style="word-wrap: break-word;margin-top: 15px;"><?= $LANGS['uploaddesc1'] ?></div>
            <div style="word-wrap: break-word;font-weight: bold;margin-top: 15px;"><?php if (!$_USER->Info['is_partner']): ?><?= $LANGS['videolimit1'] ?><?php else : ?><?= $LANGS['partnervideolimit1'] ?><?php endif ?></div>
            <div style="word-wrap: break-word;margin-top: 15px;color: #8a8888;"><?= $LANGS['myvideosdesc'] ?></div>
            <div style="word-wrap: break-word;margin-top: 15px;color: #8a8888;"><a href="/my_videos_upload" class="yt-button" style="padding: 4px 8px;"><?= $LANGS['newuploader'] ?></a></div>
        </div>
    </div>


<?php else : ?>
    <span class="xxlargeText bold"><?= $LANGS['thankyou'] ?></span>
    <div style="background-color: #dee0fd;padding: 10px;border-radius: 8px;margin-top: 10px;width: 540px;">
        <div style="font-size:15px;font-weight:bold;margin:0 0 12px 0"><?= $LANGS['videoadded'] ?></div>
        <?= $LANGS['videoaddeddesc'] ?>
        <div style="margin:25px 0 25px;text-align:center">
            <div style="color:green;margin:0 0 4px 0;font-weight:bold"><?= $LANGS['sharelink'] ?></div>
            <input type="text" readonly="readonly" id="link" onclick="document.getElementById(this.id).select();document.getElementById(this.id).focus()" value="http://www.bitview.net/watch?v=<?= $Main_URL ?>" size="40" />
            <br /><br /><br />
            <div style="color:green;margin:0 0 4px 0;font-weight:bold"><?= $LANGS['embedlink'] ?></div>
            <input type="text" readonly="readonly" id="embed" onclick="document.getElementById(this.id).select();document.getElementById(this.id).focus()" value='<iframe id="embedplayer" src="/embed?v=<?= $Main_URL ?>" width="427" height="343" allowfullscreen scrolling="off" frameborder="0"></iframe>' size="50" />
        </div>
    </div>
    <div id="upload_right_side">
        <!-- ad here -->
    </div>
    </div>
<?php endif ?>
<div class="clear"></div>
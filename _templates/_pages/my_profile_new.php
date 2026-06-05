<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<style type="text/css">
.videoModifiers {
    padding: 5px 0px;
    border-bottom: 1px solid #ccc;
    text-align: center;
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
#nav-pane .header {
    height: 6.5px;
}
.picture {
    width: 100px;
    float: left;
}
.overview-top {
    height: 115px;
}
.channel-info {
    float: right;
    width: 620px;
}
.username {
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 6px;
}
.info-column {
    width: 200px;
    float: left;
}
.options-box {
    padding: 8px;
    overflow: hidden;
    line-height: 18px;
    font-weight: bold;
    background: #e6effd;
    margin-top: 12px;
}
.options-box-column {
    float: left;
    width: 33%;
}
#dialog-change {
    width: 500px;
    border: 1px solid #abb1bd;
    background-color: #edf2f6;
    padding: 10px;
    position: absolute;
    text-align: left;
    z-index: 999;
    margin: auto;
    left: 25%;
    top: 25%;
}
.dialog form {
    border: 1px solid #ddd;
    background-color: white;
    padding: 10px;
}
.dialog .title {
    color: black;
    font-size: 13px;
    font-weight: bold;
    margin: 0;
    height: 15px;
}
#dropdownarrow {
    height: 16px;
    width: 12px;
    margin-right: 6px;
    background: transparent url(/img/master-vfl87445.png) no-repeat scroll 0 -321px;
    vertical-align: middle;
}
.dropdown-title.closed #dropdownarrow {
    background: transparent url(/img/master-vfl87445.png) no-repeat scroll 0 -344px;
}
.dropdown-title {
    cursor: pointer;
    margin: 6px 0 4px 0;
}
.dropdown-title:hover {
    color: #666;
}
.content {
    margin: 4px 0px;
    padding: 6px 16px;
}
.user-thumb-jumbo img.avatarvideo {
    width: 125px!important;
    margin-left: -16px!important;
}
.dropdown-block {
    border-bottom: 1px solid #ccc;
}
p.line .user-thumb-jumbo {
    cursor: pointer;
}
.user-thumb-jumbo.imgselected {
    border-color: #ffd300;
    background: #fff3c3;
}
.carousel {
    width: 330px;
    overflow: hidden;
    white-space: nowrap;
    display: inline-block;
    float: left;
}
.btn-scroll {
    width: 18px;
    height: 106px;
    cursor: pointer;
}
.btn-scroll.left {
    float: left;
    margin-left: 16px;
    background: url(img/btn_vscroll_18x106-vfl28566.gif) 0;
}
.btn-scroll.right {
    float: left;
    background: url(img/btn_vscroll_18x106-vfl28566.gif) -36px 0;
}
.btn-scroll.disabled {
    opacity: .25;
}
.carousel-in {
    position: relative;
    font-size: 0;
}
.carousel-in .user-thumb-jumbo {
    position: relative;
    cursor: pointer;
}
#account-page {
    border: 0;
    border-left: 1px solid #999;
}
</style>
<script src="/js/jscolor.js"></script>
<script>
// These options apply to all color pickers on the page
jscolor.presets.default = {
    borderColor:'#999999', borderRadius:0, padding:10, width:200, 
    height:100, mode:'HVS', controlBorderColor:'#CCCCCC', format:'hexa',
    sliderSize:20, shadow:false
};
function coloricebergblue() {
    document.getElementById("color_background").setAttribute('value','#2c405b');
    document.getElementById("color_font").setAttribute('value','#ffffff');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#6b8ab8');
    document.getElementById("color_header_font").setAttribute('value','#6b8ab8');
    document.getElementById("color_highlight_header").setAttribute('value','#6b8ab8');
    document.getElementById("color_highlight_inner").setAttribute('value','#ebeff0');
    document.getElementById("color_normal_header").setAttribute('value','#6b8ab8');
    document.getElementById("color_normal_inner").setAttribute('value','#2c405b');
}
function colorclassic() {
    document.getElementById("color_background").setAttribute('value','#ffffff');
    document.getElementById("color_font").setAttribute('value','#000000');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#0033cc');
    document.getElementById("color_header_font").setAttribute('value','#666666');
    document.getElementById("color_highlight_header").setAttribute('value','#666666');
    document.getElementById("color_highlight_inner").setAttribute('value','#E6E6E6');
    document.getElementById("color_normal_header").setAttribute('value','#666666');
    document.getElementById("color_normal_inner").setAttribute('value','#ffffff');
}
function coloracidwash() {
    document.getElementById("color_background").setAttribute('value','#006599');
    document.getElementById("color_font").setAttribute('value','#ffffff');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#56aad6');
    document.getElementById("color_header_font").setAttribute('value','#56aad6');
    document.getElementById("color_highlight_header").setAttribute('value','#56aad6');
    document.getElementById("color_highlight_inner").setAttribute('value','#006599');
    document.getElementById("color_normal_header").setAttribute('value','#56aad6');
    document.getElementById("color_normal_inner").setAttribute('value','#006599');
}
function colorstorm() {
    document.getElementById("color_background").setAttribute('value','#3a3a3a');
    document.getElementById("color_font").setAttribute('value','#ffffff');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#898588');
    document.getElementById("color_header_font").setAttribute('value','#666666');
    document.getElementById("color_highlight_header").setAttribute('value','#999999');
    document.getElementById("color_highlight_inner").setAttribute('value','#EEEEEE');
    document.getElementById("color_normal_header").setAttribute('value','#999999');
    document.getElementById("color_normal_inner").setAttribute('value','#3a3a3a');
}
function colorforestgreen() {
    document.getElementById("color_background").setAttribute('value','#006600');
    document.getElementById("color_font").setAttribute('value','#ffffff');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#4f9f00');
    document.getElementById("color_header_font").setAttribute('value','#4f9f00');
    document.getElementById("color_highlight_header").setAttribute('value','#4f9f00');
    document.getElementById("color_highlight_inner").setAttribute('value','#dcffba');
    document.getElementById("color_normal_header").setAttribute('value','#4f9f00');
    document.getElementById("color_normal_inner").setAttribute('value','#234701');
}
function colororangeapeel() {
    document.getElementById("color_background").setAttribute('value','#e25f0f');
    document.getElementById("color_font").setAttribute('value','#ffffff');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#fdbe00');
    document.getElementById("color_header_font").setAttribute('value','#daa501');
    document.getElementById("color_highlight_header").setAttribute('value','#fdbe00');
    document.getElementById("color_highlight_inner").setAttribute('value','#f7f8e6');
    document.getElementById("color_normal_header").setAttribute('value','#fdbe00');
    document.getElementById("color_normal_inner").setAttribute('value','#e25f0f');
}
function colorprettyinpink() {
    document.getElementById("color_background").setAttribute('value','#cd2651');
    document.getElementById("color_font").setAttribute('value','#ffffff');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#e9799f');
    document.getElementById("color_header_font").setAttribute('value','#e9799f');
    document.getElementById("color_highlight_header").setAttribute('value','#e9799f');
    document.getElementById("color_highlight_inner").setAttribute('value','#fae3eb');
    document.getElementById("color_normal_header").setAttribute('value','#e9799f');
    document.getElementById("color_normal_inner").setAttribute('value','#ffffff');
}
function colorpurplehaze() {
    document.getElementById("color_background").setAttribute('value','#3f1f60');
    document.getElementById("color_font").setAttribute('value','#ffffff');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#9560ca');
    document.getElementById("color_header_font").setAttribute('value','#9560ca');
    document.getElementById("color_highlight_header").setAttribute('value','#9560ca');
    document.getElementById("color_highlight_inner").setAttribute('value','#eae1f4');
    document.getElementById("color_normal_header").setAttribute('value','#9560ca');
    document.getElementById("color_normal_inner").setAttribute('value','#3f1f60');
}
function colorrubyred() {
    document.getElementById("color_background").setAttribute('value','#5f1718');
    document.getElementById("color_font").setAttribute('value','#ffffff');
    document.getElementById("color_title_font").setAttribute('value','#ffffff');
    document.getElementById("color_links").setAttribute('value','#cd311b');
    document.getElementById("color_header_font").setAttribute('value','#cd311b');
    document.getElementById("color_highlight_header").setAttribute('value','#cd311b');
    document.getElementById("color_highlight_inner").setAttribute('value','#f8e0e0');
    document.getElementById("color_normal_header").setAttribute('value','#cd311b');
    document.getElementById("color_normal_inner").setAttribute('value','#5f1718');
}
function openDropdown() {
        document.getElementById('messages-change').innerHTML = "";
        var x = document.getElementById("dialog-change");
        var y = document.getElementById("container");
        x.style.display = "block";
        y.style.opacity = "0.25";
    }
function closeDropdown() {
        var x = document.getElementById("dialog-change");
        var y = document.getElementById("container");
        x.style.display = "none";
        y.style.opacity = "1";
    }
function openTab(e) {
    var x = document.getElementById(e+"-content");
    var y = document.getElementById(e);
    if (x.style.display === "none") {
        x.style.display = "block";
        y.classList.remove('closed');
        y.classList.add('open');
    }
    else if (x.style.display === "block") {
        x.style.display = "none";
        y.classList.remove('open');
        y.classList.add('closed');
    }
}
function selectImage(e) {
    var selected = document.getElementsByClassName("imgselected");
    for (i = 0; i < selected.length; i++) {
        selected[i].classList.remove("imgselected");
    }
    e.classList.add("imgselected");
    document.getElementById('still-url').value = e.id;
}
window.onload = function() {
    var page;
    if (!window.location.hash) {
        page = "overview";
    }
    else {
        page = window.location.hash.replace("#","");
    }
    document.getElementsByName(page)[0].classList.add("selected");
    document.getElementById('page-name').innerHTML = document.getElementsByName(page)[0].innerHTML;
    $.ajax({
        url: "/a/my_profile_load.php?page="+ page,
        success: function(html){
            if(html){
                    document.getElementById('video_grid').innerHTML = html;
            } else {
                alert('Something went wrong!');
            }
        }
    });
}
window.onhashchange = function () {
    var view = window.location.hash.replace("#","");
    if (document.getElementsByName(view)[0] == undefined) {
        var view = "overview";
        history.pushState({}, '', "/my_account#overview");
    }
    forceLoadPage(view,document.getElementsByName(view)[0]);
    window.scrollTo(0,0);
}
var preloadedPage = "";
var preloadedHTML = "";
function preloadPage(e,th) {
    var ajaxPet = true;
    th.onclick = function(){ forceLoadPage(e,th); ajaxPet = false; return false; };
    th.onmouseout = function(){ ajaxPet = false; }
    var current = document.querySelector('a.selected').id;
    setTimeout(
    function() {
        if ($(th).is(":hover") && preloadedPage != e && current != e && ajaxPet) {
            $.ajax({
                url: "/a/my_profile_load.php?page="+e,
                success: function(html){
                    if(html){
                        preloadedPage = e;
                        preloadedHTML = html;
                        th.onclick = function(){ changePage(e,th); document.getElementById('video_grid').innerHTML = html; return false; };
                    } else {
                        alert('Something went wrong!');
                    }
                }
            });
        }
    }
    , 150);
}
function forceLoadPage(e,th) {
    var current = document.querySelector('a.selected').id;
    if (current != e) {
        changePage(e,th);
        $.ajax({
            url: "/a/my_profile_load.php?page="+e,
            success: function(html){
                if(html){
                    document.getElementById('video_grid').innerHTML = html;
                } else {
                    alert('Something went wrong!');
                }
            }
        });
    }
}
function changePage(e,th) {
    document.getElementById('page-name').innerHTML = th.innerHTML;
    document.querySelector('a.selected').classList.remove('selected');
    th.classList.add("selected");
    event.preventDefault();
    history.pushState({}, '', th.href);
}
function changeAvatar() {
    document.getElementById('messages-change').innerHTML = '<div id="info-box" class="yt-alert yt-alert-info yt-rounded" style="width: 468px;margin: 0 0 12px 0;"><div class="yt-alert-icon"></div><div class="yt-alert-content"><?= $LANGS['saving'] ?></div><div class="clear"></div></div>';
    var d_type = document.querySelector('input[name="avatar_type"]:checked').value;
    var d_url = document.getElementById('still-url').value;
    var formData = new FormData(document.getElementById('avatar_image_change'));
    $.ajax({
        type: "POST",
        url: "/a/change_avatar",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(output){ 
             if (output.response != "success") {
                if (output.response == "file_error") {
                    document.getElementById('messages-change').innerHTML = '<div id="error-box" class="yt-alert yt-alert-error yt-rounded" style="width: 468px;margin: 0 0 12px 0;"><div class="yt-alert-icon"></div><div class="yt-alert-content">Please, select a file to upload.</div><div class="clear"></div></div>';
                }
                else {
                    document.getElementById('messages-change').innerHTML = '<div id="error-box" class="yt-alert yt-alert-error yt-rounded" style="width: 468px;margin: 0 0 12px 0;"><div class="yt-alert-icon"></div><div class="yt-alert-content"><?= $LANGS['somethingwentwrong'] ?></div><div class="clear"></div></div>';
                }
             }
             else {
                if (document.querySelector('.picture .user-thumb-jumbo img')) { var el = document.querySelector('.picture .user-thumb-jumbo img') }
                else { var el = document.querySelector('.user-thumb-large img')}
                if (d_type == "1") {
                    el.src = "/u/av/<?= $_USER->Username ?>.jpg?"+Math.floor(Math.random() * 1000000);
                    el.classList.remove("avatarvideo");
                }
                if (d_type == "2") {
                    el.src = "/u/thmp/"+ d_url +".jpg";
                    el.classList.add("avatarvideo");
                }
                if (d_type == "3") {
                    el.src = "/img/no_videos_140.jpg";
                    el.classList.remove("avatarvideo");
                }
                document.getElementById('baseDiv').innerHTML = '<div id="success-box" class="yt-alert yt-alert-success yt-rounded"><div class="yt-alert-icon master-sprite"></div><div class="yt-alert-close" onclick="document.getElementById(&quot;success-box&quot;).outerHTML = &quot;&quot;;"><div class="yt-alert-close-icon master-sprite"></div></div><div id="" class="yt-alert-content"><?= $LANGS['changessaved'] ?></div><div class="clear"></div></div>' + document.getElementById('baseDiv').innerHTML;
                closeDropdown();
             }
        }
    });
}
function moveC(dir,e) {
    if (dir == "left") {
        var move = 330;
    }
    else {
        var move = -330;
    }
    var p_amount = Math.ceil(document.querySelectorAll(".carousel-in .user-thumb-jumbo").length / 3);
    var car = document.getElementsByClassName("carousel-in")[0];
    if (!e.classList.contains("disabled")) {
        car.style.left = parseInt(car.style.left) + move + "px";
        if (parseInt(car.style.left) >= 0) { document.querySelector(".btn-scroll.left").classList.add('disabled'); }
        else { document.querySelector(".btn-scroll.left").classList.remove('disabled'); }

        if (parseInt(car.style.left) - 332 <= (p_amount * -330)) { document.querySelector(".btn-scroll.right").classList.add('disabled'); }
        else { document.querySelector(".btn-scroll.right").classList.remove('disabled'); }
    }
}
</script>
<div class="dialog" id="dialog-change" style="display: none">
                        <form action="/my_account" method="POST" id="avatar_image_change" enctype="multipart/form-data">
                            <div id="messages-change" class="yt-message-panel"></div>
                            <p class="title line first"><?= $LANGS['changepicture'] ?></p>
                            <p class="line">
                            <label style="position:relative;bottom:4px;right:4px"><input type="radio" name="avatar_type" value="1" style="position:relative;top:2px" checked="">Upload an image</label></p>
                            <p class="line" style="padding: 0 16px;"><input type="file" name="avatar_image"></p>
                            <p class="line" style="padding: 0 16px;"><span class="smallText" style="color:#666"><?= $LANGS['changepicturedesc'] ?></span></p>
                            <p class="line"><label style="position:relative;bottom:4px;right:4px"><input type="radio" name="avatar_type" value="2" style="position:relative;top:2px">Choose a video still</label></p>
                            <p class="line video-sel" style="padding: 0 16px;">
                            <?php 
                            $Videos = new Videos($DB,$_USER);
                            $Videos->WHERE_P    = ["videos.uploaded_by" => $_USER->Username, "videos.privacy" => 1];
                            $Videos->ORDER_BY   = "videos.uploaded_on DESC";
                            $Videos->get();
                            if (isset($Videos) && $Videos::$Videos) { $Videos = $Videos->fix_values(true,true); }
                            else { $Videos = []; }

                            foreach ($Videos as $i => $val) {
                                if ($val['thumb'] == "/img/nothump.png") { unset($Videos[$i]); }
                            }
                            ?>
                            <?php if (!$Videos): ?>
                                You haven't uploaded any videos.
                            <?php else: ?>
                                <input class="hid" name="still-url" <?php if ($_USER->Info['avatar'] && $_USER->Info['is_avatar_video']): ?> value="<?= $_USER->Info['avatar'] ?>"<?php endif ?> id="still-url" type="text">
                                <div class="btn-scroll left disabled" onclick="moveC('left',this)"></div>
                                <span class="carousel">
                                <span class="carousel-in" style="left: 0">
                                <?php foreach ($Videos as $Video): ?>
                                <span style="display: inline-block; margin: 0 5px" id="<?= $Video["url"] ?>" onclick="selectImage(this);" class="user-thumb-jumbo<?php if ($_USER->Info['avatar'] == $Video['url']): ?> imgselected<?php endif ?>"><span><img src="<?= $Video["thumb"] ?>" class="avatarvideo" width="120" height="90" style="width: 94px;margin: 0;"></span></span>
                                <?php endforeach ?>
                                </span>
                                </span>
                                <div class="btn-scroll right<?php if (count($Videos) < 4): ?> disabled<?php endif?>" onclick="moveC('right',this)"></div>
                            <?php endif ?>
                                <div class="clear"></div>
                            </p>
                            <p class="line"><label style="position:relative;bottom:4px;right:4px"><input type="radio" name="avatar_type" value="3" style="position:relative;top:2px">Use default image</label></p>
                            <p class="line" style="margin-bottom: 0;">
                                <input type="submit" name="change_avatar_image" onclick="changeAvatar();return false" class="yt-button" style="padding: 4px 10px;margin: 0;" value="<?= $LANGS['editsavechanges'] ?>">
                                <?= $LANGS['or'] ?>
                                <a href="#" onclick="closeDropdown(); return false;"><?= $LANGS['editcancel'] ?></a>
                            </p>
                        </form>
                    </div>
<div id="container">
<?php require_once $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/settings_header.php" ?>
<table class="column-table account" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <div id="vm-title"><?= $LANGS['accountsettings'] ?></div>
            <td class="tabs">
                <div id="vm-layout-left">
                <ol class="vm-vertical-nav">
                    <li><a class="" name="overview" href="/my_account#overview" onmouseover="preloadPage('overview',this);"><?= $LANGS['overview'] ?></a></li>
                    <li><a class="" onmouseover="preloadPage('about',this);" name="about" href="/my_account#about"><?= $LANGS['profilesetup'] ?></a></li>
                    <li><a class="" href="/my_account#modules" onmouseover="preloadPage('modules',this);" name="modules"><?= $LANGS['customizehomepage'] ?></a></li>
                    <li><a class="" href="/my_account#playback" onmouseover="preloadPage('playback',this);" name="playback"><?= $LANGS['playbacksetup'] ?></a></li>
                    <li><a class="" href="/my_account#email" onmouseover="preloadPage('email',this);" name="email"><?= $LANGS['emailoptions'] ?></a></li>
                    <?php if ($_USER->Info['is_partner']): ?><li><a class="" href="/my_account#partner" onmouseover="preloadPage('partner',this);" name="partner"><?= $LANGS['partnersettings'] ?></a></li><?php endif ?>
                    <li><a class="" href="/my_account#manageaccount" onmouseover="preloadPage('manageaccount',this);" name="manageaccount"><?= $LANGS['manageaccount'] ?></a></li>
                </ol>
                    </div>
            </td>
            <td id="account-page" class="page">
                <div id="vm-page-subheader">
                    <h3 id="page-name"><?= $LANGS['loading'] ?></h3>
                </div>
                <div id="video_grid" class="browseGridView marT10"></div></td>
        </tr>
    </tbody></table>
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
</div>
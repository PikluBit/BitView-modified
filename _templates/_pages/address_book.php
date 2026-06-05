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
.column-splitter {
    border-right: 1px solid #999;
    background-color: #ccc;
    height: 460px;
}
.userlist {
    margin-right: 7px;
    height: 100%;
    background-color: #fff;
    border-right: 1px solid #999;
}
.column {
    background: white;
}
#table #headings td {
    padding: 2px 6px;
}
#table #headings .sort-field {
    color: #666;
    cursor: pointer;
}
.user.sel {
    background-color: #d6e1f5;
}
#username {
    padding: 2px 6px;
}
.body {
    width: 100%;
    height: 460px;
}
.body td {
    padding: 0;
}
.view-box {
    padding: 8px;
}
.selectedel {
    border-bottom: 1px solid #ccc;
    color: #666;
    font-weight: bold;
    padding-bottom: 4px;
    padding-left: 8px;
    padding-right: 8px;
    margin-bottom: 8px;
}
#nosel {
    font-size: 16px;
    font-weight: bold;
    color: #666;
    padding: 30px;
}
.menu-arr {
    white-space: nowrap;
    background: url(/img/master-vfl87445.png) no-repeat -123px -1393px;
    margin: 0 0.25em 0 0;
    padding-right: 15px;
    zoom: 1;
    height: 10px;
    width: 0;
    transform: rotate(-90deg);
}
.menu-arr.open {
    transform: rotate(0deg);
}
.user-in {
    padding: 0 24px;
}
.user-hd {
    font-weight: bold;
    color: #666;
    margin-bottom: 8px;
    cursor:pointer;
}
.groupname {
    text-decoration: none!important;
    color: #333!important;
    padding: 4px 0 4px;
    cursor: hand;
    cursor: pointer;
}
#user-check {
    padding: 2px 6px;
    width: 26px;
    float: left;
}
.user {
    cursor: pointer;
    height: 23px;
}
#username {
    padding: 2px 6px;
    height: 19px;
    line-height: 19px;
}
.user-el {
    margin-bottom: 8px;
}
.user-thumb-large {
    height: 60px;
    width: 60px;
    float: left;
}
.user-info {
    margin-left: 72px;
}
.user-info-grey {
    color: #666;
}
.user-info-item {
    border-bottom: 1px solid #ccc;
    margin-bottom: 8px;
    padding-bottom: 8px;
}
.user-el.closed .user-in {
    display: none;
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
.dialog .in {
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
</style>
<script>
function hd_open(e) {
    if (document.getElementById("ue-" + e).classList.contains("closed")) {
        document.getElementById("ue-" + e).classList.remove("closed");
        document.getElementById("info-arr-" + e).classList.add("open");
    }
    else {
        document.getElementById("ue-" + e).classList.add("closed");
        document.getElementById("info-arr-" + e).classList.remove("open");
    }
}
function change_user(e,o) {
    var username = e;
    if (document.getElementById("sel-" + e).checked || !document.getElementById("sel-" + e).checked && o == 1) { 
    if (document.getElementById("sel-" + e).checked && o == 1 && document.getElementById("ue-" + e).classList.contains("closed")) {
        hd_open(e);
    }
    if (o == 1) {
        document.getElementById(username).classList.add('sel');
        for (var i = 0; i < document.getElementsByClassName("user").length; i++) {
            if (document.getElementsByClassName("user")[i].id != username) {
                document.getElementsByClassName("user")[i].classList.remove("sel");
            }
        }
        for (var i = 0; i < document.getElementsByClassName("user-el").length; i++) {
            if (document.getElementsByClassName("user-el")[i].id != "ue-" + username) {
                var u = document.getElementsByClassName("user-el")[i].id.substring(3);
                document.getElementsByClassName("user-el")[i].classList.add("closed");
                document.getElementById("info-arr-" + u).classList.remove("open");
            }
        }
        document.getElementById("sel-"+username).checked = "checked";
    }
    if (!document.getElementById("ue-"+username)) {
    if (document.getElementById('nosel')) {
        document.getElementById('nosel').style.display = "none";
        document.getElementById('selcont').innerHTML = parseInt(document.getElementById('selcont').innerHTML) + 1;
        $.ajax({
                url: "/a/get_user_info.php?user=" + username + "&open="+o,
                success: function(html){
                    if(html){
                        $("#sel").append(html);
                    } else {
                        alert("Bad response from server.");
                    }
                }
            });
    }
    else {
        document.getElementById('selcont').innerHTML = parseInt(document.getElementById('selcont').innerHTML) + 1;
        $.ajax({
                url: "/a/get_user_info.php?user=" + username + "&open="+o,
                success: function(html){
                    if(html){
                        $("#sel").append(html);
                    } else {
                        alert("Bad response from server.");
                    }
                }
            });
    }
    }
}

else {
    document.getElementById('selcont').innerHTML = parseInt(document.getElementById('selcont').innerHTML) - 1
    document.getElementById("ue-"+e).outerHTML = "";
    if (document.getElementById(e).classList.contains('sel')) {
        document.getElementById(e).classList.remove('sel');
    }
}

if (parseInt(document.getElementById('selcont').innerHTML) != 0) {
    document.getElementById('unsel').style.display = "block";
    document.getElementById('nosel').style.display = "none";
}
else {
    document.getElementById('unsel').style.display = "none";
    document.getElementById('nosel').style.display = "block";
}

}
function unselectall() {
    document.getElementById("sel").innerHTML = "";
    document.getElementById('selcont').innerHTML = "0";
    for (var i = 0; i < document.getElementsByClassName("user").length; i++) {
        document.getElementsByClassName("user")[i].classList.remove("sel");
    }
    for (var i = 0; i < document.getElementsByClassName("user").length; i++) {
        document.getElementsByClassName("user-sel")[i].checked = false;
    }
}
function unselect(e) {
    document.getElementById("sel-" + e).checked = false;
    change_user(e,0);
}
function changesort() {
    var v = '<?php if (isset($_GET["v"])) { echo $_GET["v"]; } ?>';
    if (document.getElementsByClassName("sort-field")[0].innerHTML == "<?= $LANGS['name'] ?> ↓") {
        var e = 1;
    }
    else {
        var e = 0;
    }
    document.getElementById("user-list").style.opacity = "0.2";
    if (e == 1) {
        document.getElementsByClassName("sort-field")[0].innerHTML = "<?= $LANGS['name'] ?> ↑";
    } else {
        document.getElementsByClassName("sort-field")[0].innerHTML = "<?= $LANGS['name'] ?> ↓";
    }
    $.ajax({
        url: "/a/address_change_sort.php?o="+e+"&v="+v,
        success: function(html){
            if(html){
                $("#user-list").replaceWith(html);
            } else {
                alert("Bad response from server.");
            }
        }
    });
}
function selectall() {
    if (document.getElementById("all-items-checkbox").checked) {
        for (var i = 0; i < document.getElementsByClassName("user-sel").length; i++) {
            var u = document.getElementsByClassName("user-sel")[i].id.substring(4);
            if (!document.getElementsByClassName("user-sel")[i].checked) {
                document.getElementsByClassName("user-sel")[i].checked = true;
                change_user(u,0);
            }
        }
    }
    else {
        if (parseInt(document.getElementById('selcont').innerHTML) == document.getElementsByClassName("user-el").length) {
            for (var i = 0; i < document.getElementsByClassName("user").length; i++) {
                var u = document.getElementsByClassName("user-sel")[i].id.substring(4);
                if (document.getElementsByClassName("user-sel")[i].checked) {
                document.getElementsByClassName("user-sel")[i].checked = false;
                change_user(u,0);
                }
            }
        }
        else {
            document.getElementById("all-items-checkbox").checked = true;
        }
    }
}
function openDropdown() {
    var x = document.getElementById("dialog-change");
    var y = document.getElementById("body-container");
    x.style.display = "block";
    y.style.opacity = "0.25";
}
function closeDropdown() {
    var x = document.getElementById("dialog-change");
    var y = document.getElementById("body-container");
    x.style.display = "none";
    y.style.opacity = "1";
}
function compose() {
    if (parseInt(document.getElementById('selcont').innerHTML) < 1) {
        alert("<?= $LANGS['selectacontactmsg'] ?>");
    }
    else if (parseInt(document.getElementById('selcont').innerHTML) == 1) {
        var u = document.getElementsByClassName('user-el')[0].id.substring(3);
        location.href = "/send_message?to="+u;
    }
    else {
        for (var i=0; i<document.getElementById("c-sel").length; i++) {
            document.getElementById("c-sel").remove(i);
        }
        for (var i=0; i< parseInt(document.getElementById('selcont').innerHTML); i++) {
            var option = document.createElement('option');
            option.value = option.text = document.getElementsByClassName('user-el')[i].id.substring(3);
            document.getElementById("c-sel").add(option);
        }
        document.getElementById('dialog-change').style.display = "block";
        openDropdown();
    }
}
function composeTo() {
    var u = document.getElementById('c-sel').value;
    location.href = "/send_message?to="+u;
}
function deleteContact() {
    var nu = document.getElementsByClassName('user-el').length;
    if (nu > 0) {
    if (confirm("Are you sure that you want to delete this/these contacts?") == true) {
    var n = "";
    for (var i=0; i < nu; i++) {
        n = document.getElementsByClassName('user-el')[i].id.substring(3);
        var url = "/address_book?remove=" + n;
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status < 400) {
            } else {
                alert("Something went wrong!");
            }
        };

        xhr.onerror = function() {
            alert("Something went wrong!");
        };

        xhr.send();
    }
    for (var e = 0; e < nu; e++) {
        document.getElementById(document.getElementsByClassName('user-el')[0].id.substring(3)).outerHTML = "";
        document.getElementById("ue-" + document.getElementsByClassName('user-el')[0].id.substring(3)).outerHTML = "";
        document.getElementById('selcont').innerHTML = parseInt(document.getElementById('selcont').innerHTML) - 1;
        if (document.getElementsByClassName('groupnamecont')[1].classList.contains('selected')) {
            var connum = parseInt(document.getElementById('blo-num').innerHTML.replace(/[{()}]/g, '')) - 1;
            document.getElementById('blo-num').innerHTML = "(" + connum + ")";
        }
        else {
            var connum = parseInt(document.getElementById('con-num').innerHTML.replace(/[{()}]/g, '')) - 1;
            document.getElementById('con-num').innerHTML = "(" + connum + ")";
        }
    }
    }
    }
    else {
        alert("<?= $LANGS['selectacontact'] ?>");
    }
}
function acceptReq() {
    var nu = document.getElementsByClassName('user-el').length;
    if (nu > 0) {
    var n = "";
    var x = "";
    for (var i=0; i < nu; i++) {
        n = document.getElementsByClassName('user-hd')[i].id.substring(3);
        x = document.getElementsByClassName('user-el')[i].id.substring(3);
        var url = "/address_book?accept=" + n;
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status < 400) {
            } else {
                alert("Something went wrong!");
            }
        };

        xhr.onerror = function() {
            alert("Something went wrong!");
        };

        xhr.send();
    }
    for (var e = 0; e < nu; e++) {
        document.getElementById(document.getElementsByClassName('user-el')[0].id.substring(3)).outerHTML = "";
        document.getElementById("ue-" + document.getElementsByClassName('user-el')[0].id.substring(3)).outerHTML = "";
        document.getElementById('selcont').innerHTML = parseInt(document.getElementById('selcont').innerHTML) - 1;
        var invnum = parseInt(document.getElementById('inv-num').innerHTML.replace(/[{()}]/g, '')) - 1;
        var connum = parseInt(document.getElementById('con-num').innerHTML.replace(/[{()}]/g, '')) + 1;
        document.getElementById('inv-num').innerHTML = "(" + invnum + ")";
        document.getElementById('con-num').innerHTML = "(" + connum + ")";
    }
    }
    else {
        alert("Please select at least a contact to delete!");
    }
}
function declineReq() {
    var nu = document.getElementsByClassName('user-el').length;
    if (nu > 0) {
    var n = "";
    var x = "";
    for (var i=0; i < nu; i++) {
        n = document.getElementsByClassName('user-hd')[i].id.substring(3);
        x = document.getElementsByClassName('user-el')[i].id.substring(3);
        var url = "/address_book?retract=" + n;
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status < 400) {
            } else {
                alert("Something went wrong!");
            }
        };

        xhr.onerror = function() {
            alert("Something went wrong!");
        };

        xhr.send();
    }
    for (var e = 0; e < nu; e++) {
        document.getElementById(document.getElementsByClassName('user-el')[0].id.substring(3)).outerHTML = "";
        document.getElementById("ue-" + document.getElementsByClassName('user-el')[0].id.substring(3)).outerHTML = "";
        document.getElementById('selcont').innerHTML = parseInt(document.getElementById('selcont').innerHTML) - 1;
        var invnum = parseInt(document.getElementById('inv-num').innerHTML.replace(/[{()}]/g, '')) - 1;
        document.getElementById('inv-num').innerHTML = "(" + invnum + ")";
    }
    }
    else {
        alert("Please select at least a contact to delete!");
    }
}
function block() {
    if (confirm("Are you sure that you want to delete this/these contacts?") == true) {
    var nu = document.getElementsByClassName('user-el').length;
    if (nu > 0) {
    var n = "";
    for (var i=0; i < nu; i++) {
        n = document.getElementsByClassName('user-el')[i].id.substring(3);
        console.log(n);
        var url = "/a/block_user?user=" + n;
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status < 400) {
            } else {
                alert("Something went wrong!");
            }
        };

        xhr.onerror = function() {
            alert("Something went wrong!");
        };

        xhr.send();
    }
    for (var e = 0; e < nu; e++) {
        document.getElementById(document.getElementsByClassName('user-el')[0].id.substring(3)).outerHTML = "";
        document.getElementById("ue-" + document.getElementsByClassName('user-el')[0].id.substring(3)).outerHTML = "";
        document.getElementById('selcont').innerHTML = parseInt(document.getElementById('selcont').innerHTML) - 1;
        if (document.getElementsByClassName('groupnamecont')[2].classList.contains('selected')) {
            var connum = parseInt(document.getElementById('inv-num').innerHTML.replace(/[{()}]/g, '')) - 1;
            document.getElementById('inv-num').innerHTML = "(" + connum + ")";
        }
        else {
            var connum = parseInt(document.getElementById('con-num').innerHTML.replace(/[{()}]/g, '')) - 1;
            document.getElementById('con-num').innerHTML = "(" + connum + ")";
        }
        var invnum = parseInt(document.getElementById('blo-num').innerHTML.replace(/[{()}]/g, '')) + 1;
        var connum = parseInt(document.getElementById('con-num').innerHTML.replace(/[{()}]/g, '')) - 1;
        document.getElementById('blo-num').innerHTML = "(" + invnum + ")";
        
    }
    }
    else {
        alert("Please select at least a contact to block!");
    }
}
}
</script>
<div class="container-div">
    <table cellspacing="0" cellpadding="0" border="0">
        <tbody>
            <?php require_once "_templates/_layout/title_and_pagination.php" ?>
        <tr>
            <td id="folderlinks-cell" valign="top">
                <div class="groupnamecont<?php if (!isset($_GET['v'])): ?> selected<?php endif ?>"><a class="groupname" href="/address_book"><?= $LANGS['allcontacts'] ?>&nbsp;&nbsp;&nbsp;<span id="con-num" style="font-weight: normal;color: #999;">(<?= $_USER->Info["friends"] ?>)</span></a></div>
                <div class="groupnamecont<?php if (isset($_GET['v']) && $_GET['v'] == "bu"): ?> selected<?php endif ?>"><a class="groupname" href="/address_book?v=bu">Blocked Users&nbsp;&nbsp;&nbsp;<span id="blo-num" style="font-weight: normal;color: #999;">(<?= $Blocked_Count ?>)</span></a></div>
                <div class="groupnamecont<?php if (isset($_GET['v']) && $_GET['v'] == "fi"): ?> selected<?php endif ?>"><a class="groupname" href="/address_book?v=fi"><?= $LANGS['incominginvites'] ?>&nbsp;&nbsp;&nbsp;<span id="inv-num" style="font-weight: normal;color: #999;">(<?= $Invites ?>)</span></a></div>
                <br>
                <div style="margin: 0 10px 10px 2px;border: 1px solid #ccc;">
                <div class="groupnamecont"><a class="groupname" href="/user/<?= $_USER->Username ?>&page=subscribers"><?= $LANGS['cstatsubs'] ?></a></div>
                <div class="groupnamecont"><a class="groupname" href="/my_subscriptions"><?= $LANGS['subscriptions'] ?></a></div>
                </div>
            </td>
            <td class="vert-bar" valign="top"></td>
            <td id="compose-cell" valign="top" colspan="2" height="100%">
                    <div id="message_reading">
                    <div id="commands2" class="buttonbar">
                        
                    <img class="hook-arrow" src="/img/pixel.gif" style="float: left; vertical-align: middle; margin-right: 5px; margin-top: 5px; background: url(&quot;/img/mmimgs-vfl38740.gif&quot;) 0px -10px no-repeat scroll transparent; height: 14px; width: 14px;">
                    <div style="text-align: left;">
                        <?php if (isset($_GET['v']) && $_GET['v'] != "fi"): ?>
                        <button onclick="compose();" class=" yt-uix-button yt-uix-button-primary"><?= $LANGS['compose'] ?></button> 
                        <?php if (isset($_GET['v']) && $_GET['v'] != "bu"): ?><button onclick="block();" class=" yt-uix-button yt-uix-button-primary">Block</button><?php endif ?>
                        <button onclick="deleteContact();" class=" yt-uix-button yt-uix-button-primary"><?= $LANGS['delete'] ?></button>
                        <?php else: ?>
                        <button onclick="acceptReq();" class=" yt-uix-button yt-uix-button-primary"><?= $LANGS['accept'] ?></button>
                        <button onclick="declineReq();" class=" yt-uix-button yt-uix-button-primary"><?= $LANGS['decline'] ?></button>
                        <button onclick="block();" class=" yt-uix-button yt-uix-button-primary">Block</button>
                        <button onclick="compose();" class=" yt-uix-button yt-uix-button-primary"><?= $LANGS['compose'] ?></button> 
                        <?php endif ?>
                    </div>
                    </div>
                    <div id="message-pane">
                        <table style="border-spacing: 0;" class="body"></tbody>
    <td width="30%" class="column-splitter">
    <div class="userlist"><div class="column"><table id="table">
                <thead>
        <tr id="headings">
            <td width="20" id="heading-check" class="first heading"><div><input id="all-items-checkbox" type="checkbox" onclick="selectall();"></div></td>
            <td id="heading-filter" class="heading"><div>
                <span class="sort-field" href="#" onclick="changesort();"><?= $LANGS['name'] ?> ↓</span>         
            </div>
                
                
            </td>
        </tr>
    </thead>

            
        </table>
            <div id="user-list" style="height: 436px;overflow: scroll;display: block;">
        <?php if ($Friends) :?>
        <?php foreach ($Friends as $Friend): ?>
        <div class="user" id="<?= $Friend['username'] ?>">
            <div width="20" id="user-check" class="check"><div><input class="user-sel" id="sel-<?= $Friend['username'] ?>" onclick="change_user('<?= $Friend["username"] ?>', 0);" type="checkbox"></div></div>
            <div id="username" class="username" onclick="change_user('<?= $Friend["username"] ?>', 1);">
            <div><?= displayname($Friend['username']) ?></div>
            </div>
        </div>
        <div style="clear:both"></div>
        <?php endforeach ?>
        <?php else: ?>
        <div style="text-align: center;padding: 20px 0;"><?= $LANGS['nocontacts'] ?></div>
        <?php endif ?>
        </div>
    </div>  </div>
    <td width="60%" style="vertical-align: top;">
    <div class="view-box" id="view-box" style="height: 436px; overflow: scroll">
        <div class="selectedel"><?= $LANGS['selectedcontacts'] ?> (<span id="selcont">0</span>)<a href="#" id="unsel" onclick="unselectall();return false;" style="float: right;display: none;"><?= $LANGS['unselectall'] ?></a></div>
        <div id="nosel"><?= $LANGS['choosecontacts'] ?></div>
        <div id="sel"></div>
    </div>
    </td>
</tbody></table>
                    </div>
    </tbody></table>
                    </div>
<div class="dialog" id="dialog-change" style="display: none;">
    <div class="in">
        <div id="messages-change" class="yt-message-panel hidden"></div>
        <p class="title line first"><?= $LANGS['compose'] ?></p>
        <p class="line"><?= $LANGS['selectonecompose'] ?></p>
        <p class="line"><select id="c-sel">
        </select></p>
        <p class="line" style="margin-bottom: 0;">
            <input type="submit" onclick="composeTo();" class="yt-button" style="padding: 4px 10px;margin: 0;" value="<?= $LANGS['compose'] ?>">
            <?= $LANGS['or'] ?>                                <a href="#" onclick="closeDropdown(); return false;"><?= $LANGS['editcancel'] ?></a>
        </p>
    </div>
</div>
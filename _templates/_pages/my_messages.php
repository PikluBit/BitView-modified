<link href="/css/messages.css?20" rel="stylesheet" type="text/css" />
<script>
    window.onload = function () {
        var page = window.location.hash.replace("#","").split('/')[1];
        if (window.location.hash.replace("#","").split('/')[1] == undefined) {
            page = 1;
        }
        loadPage(page);
    }
    window.onhashchange = function () {
        var view = window.location.hash.replace("#","").split('/')[0];
        var page = window.location.hash.replace("#","").split('/')[1];
        if (document.getElementsByName(view)[0] == undefined) {
            var view = "inbox";
            history.pushState({}, '', "/inbox#inbox");
        }
        if (window.location.hash.replace("#","").split('/')[1] == undefined) {
            page = 1;
            changeView(view,document.getElementsByName(view)[0]);
        }
        else {
            document.getElementById('vm-page-subheader').innerHTML = "<h3>" + document.getElementsByName(view)[0].innerHTML.replace(/\(([^)]+)\)/,'').trim() + "</h3>";
            document.querySelector('a.selected').classList.remove('selected');
            document.getElementsByName(view)[0].classList.add("selected");
            event.preventDefault();
            loadPage(page);
        }
        window.scrollTo(0,0);
    }
    function loadPage(page) {
        if (!window.location.hash) {
            var view = "inbox";
        }
        else {
            var view = window.location.hash.replace("#","").split('/')[0];
        }
        document.getElementsByName(view)[0].classList.add("selected");
        document.getElementById('vm-page-subheader').innerHTML = "<h3>" + document.getElementsByName(view)[0].innerHTML.replace(/\(([^)]+)\)/,'').trim() + "</h3>";
        if (document.getElementById("message-pane-loading") != null) {
            document.getElementById("message-pane-loading").classList.remove("hid");
        }
        $.ajax({
            url: "/a/load_messages.php?view="+ view + "&p=" + page,
            success: function(html){
                if(html){
                        document.getElementById('message-pane').innerHTML = html;
                        document.getElementById("message-pane-loading").classList.add("hid");
                } else {
                    alert('Something went wrong!');
                }
            }
        });
    }
    function changeView(e,th) {
        if (!window.location.hash) {
            view = "inbox";
        }
        else {
            view = window.location.hash.replace("#","").split('/')[0];
        }
        document.getElementById('vm-page-subheader').innerHTML = "<h3>" + document.getElementsByName(view)[0].innerHTML.replace(/\(([^)]+)\)/,'').trim() + "</h3>";
        document.querySelector('a.selected').classList.remove('selected');
        th.classList.add("selected");
        event.preventDefault();
        if (view != e) {
            history.pushState({}, '', th.href);
            loadPage(1);
        }
    }
    function change_page(th) {
        history.pushState({}, '', th.href);
        var page = window.location.hash.replace("#","").split('/')[1];
        loadPage(page);
    }
    function readMessage(id) {
        var open = document.getElementsByClassName("in_message").length - document.getElementsByClassName("hddn").length;
        var read = document.getElementById("i_"+id);
            <?php if (!isset($_GET['by_user']) || isset($_GET['by_user']) && $_GET['by_user'] != 1): ?>
                document.getElementById("ms-"+id).classList.remove("unread");
            <?php endif ?>
        if (read.classList.contains("hddn")) {
            if (open > 0) {
            for (i = 0; i < document.getElementsByClassName("in_message").length; i++) {
                var oid = document.getElementsByClassName('in_message')[i].id.substring(2);
                if (!document.getElementsByClassName('in_message')[i].classList.contains("hddn")) {
                    openAnim(id);
                    if (oid != id) {
                        closeAnim(oid);
                    }
                }
            }
        }
        openAnim(id);
        if (read.classList.contains("noread")) { //if table contains "noread" class, make a http request
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.open("GET", "/a/read_message?id="+id, false);
            xmlHttp.send(null);
            read.classList.remove("noread");
        }
        } else {
            closeAnim(id);
        }
    }
    function openAnim(id) {
        var read = document.getElementById("i_"+id);
        document.getElementById("ms-"+id).style.display = "none";
        read.classList.remove("hddn");
        setTimeout(function() {document.getElementById("avt_"+id).style.height = "90px";}, 1);
        var h = document.getElementById("msg_in_"+id).offsetHeight;
        if (h == 0) {
            h = parseInt(document.getElementById("msg_in_"+id).style.maxHeight);
        }
        document.getElementById("msg_in_"+id).style.height = "0px";
        document.getElementById("msg_in_"+id).style.visibility = "visible";
        setTimeout(function() {document.getElementById("msg_in_"+id).style.height = h+"px";}, 1);
    }
    function closeAnim(id) {
        var read = document.getElementById("i_"+id);
        setTimeout(function() {
            document.getElementById("ms-"+id).style.display = "table-row";
            read.classList.add("hddn");
        }, 100);
        document.getElementById("avt_"+id).style.height = "0px";
        var h = document.getElementById("msg_in_"+id).offsetHeight;
        setTimeout(function() {document.getElementById("msg_in_"+id).style.height = "0px";}, 1);
        setTimeout(function() {document.getElementById("msg_in_"+id).style.maxHeight = h+"px";}, 100);
    }
    function toggle(source) {
      // Get all input elements
      var inputs = document.getElementsByTagName('input'); 
       // Loop over inputs to find the checkboxes whose name starts with `orders`
       for(var i =0; i<inputs.length; i++) {
         if (inputs[i].type == 'checkbox') { 
           inputs[i].checked = source.checked;
         }
       }
     }  
    function check(e,o) {
        document.getElementById('chk-o-'+e).checked = o.checked;
        document.getElementById('chk-i-'+e).checked = o.checked;
    }
    function deleteMsg() {
        var el = document.getElementsByClassName('ms_sct').length;
        var cr = [];
        var ir = [];
        for (i = 0; i < el; i++) {
            var mid = document.getElementsByClassName("ms_sct")[i].id.substring(3);
            if (document.getElementById('chk-o-'+mid).checked == true || document.getElementById('chk-i-'+mid).checked == true) {
                cr.push(document.getElementsByClassName('ms_sct')[i]);
                ir.push(document.getElementsByClassName('in_message')[i]);
                var url = "/a/delete_pm_message?id=" + mid;
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
        }
        for (var k = 0; k < cr.length; k++) {
            cr[k].parentNode.removeChild(cr[k]);
            ir[k].parentNode.removeChild(ir[k]);
        }
        for (var x = 0; x < document.getElementsByClassName('ms_sct').length; x++) {
            if (x % 2) {
                document.getElementsByClassName('ms_sct')[x].style.background = "#fff";
            }
            else {
                document.getElementsByClassName('ms_sct')[x].style.background = "#f0f0f0";
            }
        }
        document.getElementById('all-items-checkbox').checked = false;
    }
</script>
<div class="container-div">
    <div id="vm-title"><?= $LANGS['messagesmenu'] ?></div>
    <table cellspacing="0" cellpadding="0" border="0">
        <tbody>
        <tr>
            <td id="folderlinks-cell" valign="top">
                <?php $Messages_Amount = $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND seen = 0", true, [":USERNAME" => $_USER->Username])["amount"] ?>
        <?php $Notifications_Amount = $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND (is_notification = 1 or type = 2 or type = 4 or type = 5) AND seen = 0",true,[":USERNAME" => $_USER->Username])["amount"];
        $PM_Amount = $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND type = 0 AND seen = 0",true,[":USERNAME" => $_USER->Username])["amount"];
        $Sh_Amount = $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND type = 1 AND seen = 0",true,[":USERNAME" => $_USER->Username])["amount"];
        $Res_Amount = $DB->execute("SELECT count(id) as amount FROM users_messages WHERE for_user = :USERNAME AND type = 3 AND seen = 0",true,[":USERNAME" => $_USER->Username])["amount"];
        $Invites = (int)$DB->execute("SELECT count(id) as total FROM users_friends WHERE friend_2 = :USERNAME AND status = 0", true, [":USERNAME" => $_USER->Username])["total"]; ?>
                <div id="vm-layout-left">
                    <ol class="vm-vertical-nav">
                        <li><button type="button" id="inbox_compose_button" onclick="window.location.href='/send_message'" class=" yt-uix-button" style="margin: 10px;margin-top: 0;"><?= $LANGS['compose'] ?></button></li>
                        <li><a class="" name="inbox" href="/inbox#inbox" onclick="changeView('inbox', this);"><span <?php if ($Messages_Amount > 0): ?> style="font-weight: bold;" <?php endif ?>><?= $LANGS['inbox'] ?></span><?php if ($Messages_Amount > 0): ?> (<?= $Messages_Amount ?>)<?php endif ?></a></li>
                        <li><a class="" name="messages" onclick="changeView('messages', this);" href="/inbox#messages"><span <?php if ($PM_Amount > 0): ?> style="font-weight: bold;" <?php endif ?>><?= $LANGS['personalmessages'] ?></span><?php if ($PM_Amount > 0): ?> (<?= $PM_Amount ?>)<?php endif ?></a></li>
                        <li><a class="" name="shared" href="/inbox#shared" onclick="changeView('shared', this);"><span <?php if ($Sh_Amount > 0): ?> style="font-weight: bold;" <?php endif ?>><?= $LANGS['sharedwithyouinbox'] ?></span><?php if ($Sh_Amount > 0): ?> (<?= $Sh_Amount ?>)<?php endif ?></a></li>
                        <li><a class="" name="comments" href="/inbox#comments" onclick="changeView('comments', this);"><span <?php if ($Notifications_Amount > 0): ?> style="font-weight: bold;" <?php endif ?>><?= $LANGS['msgcom'] ?></span><?php if ($Notifications_Amount > 0): ?> (<?= $Notifications_Amount ?>)<?php endif ?></a></li>
                        <li><a class="" href="/address_book?v=fi"><span <?php if ($Invites > 0): ?> style="font-weight: bold;" <?php endif ?>><?= $LANGS['friendinvitesinbox'] ?></span><?php if ($Invites > 0): ?> (<?= $Invites ?>)<?php endif ?></a></li>
                        <li><a class="" href="/inbox#responses" name="responses" onclick="changeView('responses', this);"><span <?php if ($Res_Amount > 0): ?> style="font-weight: bold;" <?php endif ?>><?= $LANGS['videoresponsesinbox'] ?></span><?php if ($Res_Amount > 0): ?> (<?= $Res_Amount ?>)<?php endif ?></a></li>
                        <li><a class="" href="/inbox#sent" name="sent" onclick="changeView('sent', this);"><?= $LANGS['sent'] ?></a></li>
                        <li><a class="" href="/address_book" style="text-align: center; margin: 10px 0; padding: 5px 0"><?= $LANGS['addressbook'] ?> »</a></li>
                    </ol>
                </div>
            </td>
            <td id="compose-cell" valign="top" colspan="2" height="100%">
                <div id="message_reading">
                    <div id="vm-page-subheader">
                        <h3><?= $LANGS['loading'] ?></h3>
                    </div>
                    <div id="commands2" class="buttonbar">
                        <img class="hook-arrow" src="/img/pixel.gif">
                        <button type="button" id="inbox_delete_button" onclick="deleteMsg();" class=" yt-uix-button"><span class="yt-uix-button-content"><?= $LANGS['delete'] ?></span></button>
                    </div>
                    <div id="message-pane" style="min-height: 140px;"><div align="center"><img src="/img/icn_loading_animated.gif" style="padding-top:150px;padding-bottom:150px;"></div></div>
                        </tbody></table>
                    </div>
                </div>
            </td>
        </tr>
    </tbody></table>
</div>
 function _gel(id) {
    return document.getElementById(id);
}

function ref(instance_or_id) {
    return (typeof (instance_or_id) == "string") ? document.getElementById(instance_or_id) : instance_or_id;
}
function hasAncestor(element, ancestor) {
    var el = ref(element);
    var an = ref(ancestor);
    while (el !== document && el != null) {
        if (el === an) return true;
        el = el.parentNode;
    }
    return false;
}

function hasClass(element, _className) {
    if (!element) {
        return;
    }
    var upperClass = _className.toUpperCase();
    if (element.className) {
        var classes = element.className.split(' ');
        for (var i = 0; i < classes.length; i++) {
            if (classes[i].toUpperCase() == upperClass) {
                return true;
            }
        }
    }
    return false;
}

function addClass(element, _class) {
    if (!hasClass(element, _class)) {
        element.className += element.className ? (" " + _class) : _class;
    }
}

function removeClass(element, _class) {
    var upperClass = _class.toUpperCase();
    var remainingClasses = [];
    if (element.className) {
        var classes = element.className.split(' ');
        for (var i = 0; i < classes.length; i++) {
            if (classes[i].toUpperCase() != upperClass) {
                remainingClasses[remainingClasses.length] = classes[i];
            }
        }
        element.className = remainingClasses.join(' ');
    }
}

function setVisible(divName, onOrOff) {
    var tempDiv = ref(divName);
    if (!tempDiv) {
        return;
    }
    if (onOrOff) {
        // true = visible
        tempDiv.style.visibility = "visible";
    } else {
        // false = hidden
        tempDiv.style.visibility = "hidden";
    }
}

function toggleDisplay(divName) {
    var tempDiv = ref(divName);
    if (!tempDiv) {
        return false;
    }
    if ((tempDiv.style.display == "block") || (tempDiv.style.display == "" && tempDiv.className.indexOf("hid") == 0)) {
        tempDiv.style.display = "none";
        return false;
    } else if ((tempDiv.style.display == "none") || (tempDiv.className.indexOf("hid") != 0)) {
        tempDiv.style.display = "block";
        return true;
    }
}

function showDiv(divName) {
    var tempDiv = ref(divName);
    if (!tempDiv) {
        return;
    }
    if (hasClass(tempDiv, "wasinline")) {
        tempDiv.style.display = "inline";
        removeClass(tempDiv, "wasinline");
    } else if (hasClass(tempDiv, "wasblock")) {
        tempDiv.style.display = "block";
        removeClass(tempDiv, "block");
    } else {
        tempDiv.style.display = getDisplayStyleByTagName(tempDiv);
    }
}

function getDisplayStyleByTagName(o) {
    var n = o.nodeName.toLowerCase();
    return (n == "span" || n == "img" || n == "a") ? "inline" : (n == 'tr' || n == 'td' ? "" : "block");
}

function hideDiv(divName) {
    var tempDiv = ref(divName);
    if (!tempDiv) {
        return;
    }
    if (tempDiv.style.display == "inline") {
        addClass(tempDiv, "wasinline");
    } else if (tempDiv.style.display == "block") {
        addClass(tempDiv, "wasblock");
    }
    tempDiv.style.display = "none";
}

function hideDivAfter(divName, delay) {
    window.setTimeout(function () {
        hideDiv(divName)
    }, delay);
}

function showTooltip(e) {
    document.getElementsByClassName("yt-uix-tooltip-tip-content")[0].innerHTML = e.title;
    var rect = e.getBoundingClientRect();
    var width = e.offsetWidth / 2;
    if (!document.getElementsByClassName('edit-info')[0]) {
        var height = _gel("masthead-container").offsetHeight + 6 + e.offsetHeight;
    }
    else {
        var height = _gel("masthead-container").offsetHeight + 6 + e.offsetHeight + document.getElementsByClassName('edit-info')[0].offsetHeight;
    }
    if (_gel('default-language-box')) {
        var eh = _gel('default-language-box').offsetHeight + 30;
    }
    else {
        var eh = 0;
    }
    _gel("yt-uix-tooltip-tip").style.left = rect.left + width + scrollX + "px";
    _gel("yt-uix-tooltip-tip").style.top = rect.top - height - eh + scrollY + "px";
    _gel("yt-uix-tooltip-tip").style.opacity = 1;
}
function hideTooltip() {
    _gel("yt-uix-tooltip-tip").style.opacity = 0;
}
function toggleDescription() {
    document.querySelector('#watch-description .yt-uix-expander-body').style.height = (document.querySelector('#watch-description-body').offsetHeight) + "px";
    _gel('watch-description').classList.toggle('yt-uix-expander-collapsed');
    _gel('watch-views').classList.add('yt-uix-expander-collapsed');
    _gel('watch-stats-container').classList.add('hid');
    if (!_gel('watch-description').classList.contains('yt-uix-expander-collapsed')) {
        _gel('watch-info').classList.add('expanded');
    }
    else {
        _gel('watch-info').classList.remove('expanded');
    }
}
function toggleStats() {
    if (!_gel("watch-stats")) {
        $.ajax({
            url: "/a/watch/stats.php?url=" + video_url,
            success: function(html){
                if(html){
                    _gel('watch-actions-stats').innerHTML = html;
                    document.querySelector('#watch-actions-stats').style.height = (document.querySelector('#watch-stats').offsetHeight) + "px";
                } else {
                    alert('Something went wrong!')
                }
            }
        });
    }
    _gel('watch-actions-area-container').classList.add('collapsed');
    _gel('watch-actions-share').classList.add('hid');
    _gel('watch-actions-embed').classList.add('hid');
    _gel('watch-actions-flag').classList.add('hid');
    _gel('watch-actions-stats').classList.toggle('hid');
}
function like() {
    if (_gel('watch-unlike').classList.contains('active')) {
        _gel('watch-unlike').classList.remove('active');
    }
    _gel('watch-like').classList.toggle('active');
    showBar(1);
}
function dislike() {
    if (_gel('watch-like').classList.contains('active')) {
        _gel('watch-like').classList.remove('active');
    }
    _gel('watch-unlike').classList.toggle('active');
    showBar(0);
}
function showBar(e) {
    _gel('watch-actions-share').classList.add('hid');
    _gel('watch-actions-embed').classList.add('hid');
    _gel('watch-actions-flag').classList.add('hid');
    _gel('watch-actions-stats').classList.add('hid');
    if (e == 0) {
        var status = "unlike";
    }
    else {
        var status = "like";
    }
    _gel('watch-actions-area').innerHTML = langs_loading;
    if (_gel('watch-'+status).classList.contains('active')) {
        _gel("watch-actions-area-container").classList.remove('collapsed');
    }
    else {
        _gel("watch-actions-area-container").classList.add('collapsed');
    }
    $.ajax({
                url: "/a/like.php?url=" + video_url + "&status=" + e,
                success: function(html){
                    if(html){
                        if (_gel('watch-'+status).classList.contains('active')) {
                            _gel('watch-actions-area-container').outerHTML = html;
                        }
                    } else {
                        alert('Something went wrong!')
                    }
                }
            });
}
function closeDiv(e) {
    e.parentElement.parentElement.classList.toggle('collapsed');
}
function hideDiv(e) {
    e.parentElement.parentElement.classList.toggle('hid');
}
function dropdown(e) {
    if (e.querySelector('.yt-uix-button-menu-text').classList.contains("hid")) {
        e.querySelector('.yt-uix-button-menu-text').classList.remove("hid");
        e.classList.add('yt-uix-button-active');
        var rect = e.getBoundingClientRect();
        var width = (document.body.clientWidth - 960) / 2;
        var height = _gel('masthead-container').offsetHeight;
        e.querySelector('.yt-uix-button-menu-text').style.left = rect.left - width + "px";
        if (!_gel("default-language-box")) {
            e.querySelector('.yt-uix-button-menu-text').style.top = e.offsetHeight + "px";
        }
        else {
            var eh = _gel('default-language-box').offsetHeight;
            e.querySelector('.yt-uix-button-menu-text').style.top = rect.top - height - eh - 6 + "px";
        }
    }
    else {
        e.classList.remove('yt-uix-button-active');
        e.querySelector('.yt-uix-button-menu-text').classList.add("hid");
    }
}
function commentsDropdown(e) {
    if (e.querySelector('.yt-uix-button-menu-text').classList.contains("hid")) {
        e.querySelector('.yt-uix-button-menu-text').classList.remove("hid");
        e.classList.add('yt-uix-button-active');
        var rect = e.offsetLeft;
        e.querySelector('.yt-uix-button-menu-text').style.left = rect + "px";
    }
    else {
        e.classList.remove('yt-uix-button-active');
        e.querySelector('.yt-uix-button-menu-text').classList.add("hid");
    }
}
window.onclick = function(event) {
  if (!event.target.matches('.yt-uix-button-menu-text') && !event.target.matches('.yt-uix-button') && !event.target.matches('.yt-uix-button-arrow')  && !event.target.matches('.yt-uix-button-content')) {
    var dropdowns = document.getElementsByClassName("yt-uix-button-menu-text");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (!openDropdown.classList.contains('hid')) {
        openDropdown.classList.add('hid');
      }
    }
    var buttons = document.getElementsByClassName("yt-uix-button-active");
    for (i = 0; i < buttons.length; i++) {
      var button = buttons[i];
        button.classList.remove('yt-uix-button-active');
    }
  }
}
function saveTo(e) {
    _gel('watch-actions-area').innerHTML = langs_saving;
    _gel("watch-actions-area-container").classList.remove('collapsed');
    $.ajax({
            url: "/a/save_to.php?v="+ video_url +"&pl="+e,
                success: function(html){
                    if(html){
                        _gel('watch-actions-area-container').outerHTML = html;
                    } else {
                        alert('Something went wrong!')
                    }
                }
            });
}
function shareVideo() {
    _gel('watch-actions-area-container').classList.add('collapsed');
    _gel('watch-actions-embed').classList.add('hid');
    _gel('watch-actions-flag').classList.add('hid');
    _gel('watch-actions-share').classList.toggle('hid');
    _gel('watch-actions-stats').classList.add('hid');
}
function embed() {
    if (!_gel("watch-actions-embed-inside")) {
        $.ajax({
            url: "/a/watch/embed.php?url=" + video_url,
            success: function(html){
                if(html){
                    _gel('watch-actions-embed').innerHTML = html;
                } else {
                    alert('Something went wrong!')
                }
            }
        });
    }
    _gel('watch-actions-area-container').classList.add('collapsed');
    _gel('watch-actions-share').classList.add('hid');
    _gel('watch-actions-flag').classList.add('hid');
    _gel('watch-actions-embed').classList.toggle('hid');
}
function updateEmbed(e) {
    var embed = _gel("embed_code");
    if (e.id.slice(0,18) == "watch-embed-theme-") {
        var color = e.id.slice(18);
        document.getElementsByClassName("selected")[0].classList.remove("selected");
        _gel(e.id).classList.add("selected");
        if (color == "blank") {
            var colorvars = ""
        }
        else if (color == "storm") {
            var colorvars = "&bg=black&bt=teal"
        }
        else if (color == "iceberg") {
            var colorvars = "&bg=blue&bt=white"
        }
        else if (color == "acid") {
            var colorvars = "&bg=teal&bt=white"
        }
        else if (color == "green") {
            var colorvars = "&bg=green&bt=white"
        }
        else if (color == "orange") {
            var colorvars = "&bg=orange&bt=white"
        }
        else if (color == "pink") {
            var colorvars = "&bg=magenta&bt=white"
        }
        else if (color == "purple") {
            var colorvars = "&bg=violet&bt=white"
        }
        else if (color == "rubyred") {
            var colorvars = "&bg=red&bt=white"
        }
        var size = document.querySelectorAll(".watch-embed-radio-box.selected")[0].id.slice(17);
        if (size == "default-box") {
        var sizevar = 'width="320" height="265"';
        }
        else if (size == "medium-box") {
        var sizevar = 'width="425" height="344"';
        }  
        else if (size == "large-box") {
        var sizevar = 'width="480" height="385"';
        }
        else if (size == "larger-box") {
        var sizevar = 'width="640" height="505"';
        }
        embed.value = '<iframe id="embedplayer" src="http://www.bitview.net/embed?v=' + video_url + '' + colorvars +'" '+ sizevar +' allowfullscreen scrolling="off" frameborder="0"></iframe>';
    }
    else if (e.id.slice(0,18) == "watch-embed-size-r") {
        var size = e.id.slice(23);
        if (size == "default") {
        var sizevar = 'width="320" height="265"';
        }
        else if (size == "medium") {
        var sizevar = 'width="425" height="344"';
        }  
        else if (size == "large") {
        var sizevar = 'width="480" height="385"';
        }
        else if (size == "larger") {
        var sizevar = 'width="640" height="505"';
        }
        document.getElementsByClassName("watch-embed-radio-box")[0].classList.remove("selected");
        document.getElementsByClassName("watch-embed-radio-box")[1].classList.remove("selected");
        document.getElementsByClassName("watch-embed-radio-box")[2].classList.remove("selected");
        document.getElementsByClassName("watch-embed-radio-box")[3].classList.remove("selected");
        _gel("watch-embed-size-"+size+"-box").classList.add("selected");
        var currentcolor = document.getElementsByClassName("selected")[0].id.slice(18);
        if (currentcolor == "blank") {
            embed.value = '<iframe id="embedplayer" src="http://www.bitview.net/embed?v=' + video_url + '' + sizevar +' allowfullscreen scrolling="off" frameborder="0"></iframe>';
        }
        else {
            if (currentcolor == "storm") {
                var colorvars = "&bg=black&bt=teal"
            }
            else if (currentcolor == "iceberg") {
                var colorvars = "&bg=blue&bt=white"
            }
            else if (currentcolor == "acid") {
                var colorvars = "&bg=teal&bt=white"
            }
            else if (currentcolor == "green") {
                var colorvars = "&bg=green&bt=white"
            }
            else if (currentcolor == "orange") {
                var colorvars = "&bg=orange&bt=white"
            }
            else if (currentcolor == "pink") {
                var colorvars = "&bg=magenta&bt=white"
            }
            else if (currentcolor == "purple") {
                var colorvars = "&bg=violet&bt=white"
            }
            else if (currentcolor == "rubyred") {
                var colorvars = "&bg=red&bt=white"
            }
            embed.value = '<iframe id="embedplayer" src="http://www.bitview.net/embed?v=' + video_url + '' + colorvars +'" '+ sizevar +' allowfullscreen scrolling="off" frameborder="0"></iframe>';
        }
    }
}
function flag() {
    if (!_gel("watch-actions-embed-inside")) {
        $.ajax({
            url: "/a/watch/flag.php?url=" + video_url,
            success: function(html){
                if(html){
                    _gel('watch-actions-flag').innerHTML = html;
                } else {
                    alert('Something went wrong!')
                }
            }
        });
    }
    _gel('watch-actions-area-container').classList.add('collapsed');
    _gel('watch-actions-share').classList.add('hid');
    _gel('watch-actions-embed').classList.add('hid');
    _gel('watch-actions-flag').classList.toggle('hid');
    _gel('watch-actions-stats').classList.add('hid');
}
function hideActions() {
    for (i = 0; i < document.getElementsByClassName('current').length; i++) {
        document.getElementsByClassName('current')[0].classList.remove('current');
    }
    _gel('watch-comments-actions').style.top = "-1000px";
    _gel('watch-comments-actions').style.left = "-1000px";
}
function change_page(e) {
    hideActions();
    if (!isNaN(parseInt(e.innerHTML))) {
        var page = parseInt(e.innerHTML);
    }
    else {
        if (e.classList.contains('pagerNotCurrentPrev')) {
            var page = parseInt(document.getElementsByClassName('pagerCurrent')[0].innerHTML) - 1;
        }
        else {
            var page = parseInt(document.getElementsByClassName('pagerCurrent')[0].innerHTML) + 1;
        }
    }

    _gel('watch-comments-loading').classList.remove('hid');
    $.ajax({
                url: "/a/comments_page.php?url=" + video_url + "&page=" + page,
                success: function(html){
                    if(html){
                        _gel('recent-comments').outerHTML = html;
                        _gel('watch-comments-loading').classList.add('hid');
                    } else {
                        alert('Something went wrong!')
                    }
                }
            });
}
function inputFocus(e) {
    _gel('comments-post-form').classList.remove('input-collapsed');
    _gel('comments-post-form').classList.add('input-expanded');
    _gel('comments-post-form').classList.add('input-focused');
    _gel('comments-attach-video').classList.remove('hid');
    if (e.value == langs_respondvideo) {
        e.value = "";
    }
}
function inputBlur(e) {
    _gel('comments-post-form').classList.remove('input-focused');
}
function cancelPost(e) {
    _gel('comments-post-form').classList.add('input-collapsed');
    _gel('comments-post-form').classList.remove('input-expanded');
    _gel('comments-post-form').classList.remove('input-focused');
    _gel('comments-attach-video').classList.add('hid');
    document.getElementsByClassName('comments-textarea')[0].value = langs_respondvideo;
    document.getElementsByClassName('comments-post-count-textbox')[0].value = 500;
}
function chars_remaining(e) {
    let comment_content = e.value;
    let comment_length = comment_content.length;
    document.getElementsByClassName('comments-post-count-textbox')[0].value = 500 - comment_length;
}
function replyCom(e) {
    _gel('watch-comments-actions').style.top = "-1000px";
    _gel('watch-comments-actions').style.left = "-1000px";
    var username = document.getElementsByClassName('current')[0].getElementsByClassName('metadata')[0].getElementsByTagName('a')[0].href.substring(document.getElementsByClassName('current')[0].getElementsByClassName('metadata')[0].getElementsByTagName('a')[0].href.lastIndexOf('/') + 1);
    _gel('comments-post-form').classList.remove('input-collapsed');
    _gel('comments-post-form').classList.add('input-expanded');
    _gel('comments-post-form').classList.add('input-focused');
    _gel('comments-attach-video').classList.remove('hid');
    document.getElementsByClassName('comments-textarea')[0].value = "@" + username + " ";
}
function vote(e, s) {
    var id = document.getElementsByClassName('current')[0].getAttribute("data-id");
    if (s == 1) {
        _gel('watch-comment-vote-up').classList.remove('voted-down');
        _gel('watch-comment-vote-down').classList.remove('voted-down');
        _gel('watch-comment-vote-up').classList.toggle('voted-up');
        _gel('watch-comment-vote-down').classList.toggle('voted-up');
    }
    else {
        _gel('watch-comment-vote-up').classList.remove('voted-up');
        _gel('watch-comment-vote-down').classList.remove('voted-up');
        _gel('watch-comment-vote-up').classList.toggle('voted-down');
        _gel('watch-comment-vote-down').classList.toggle('voted-down');
    }
    if ((_gel('watch-comment-vote-up').classList.contains('voted-up') && _gel('watch-comment-vote-down').classList.contains('voted-up')) || (_gel('watch-comment-vote-up').classList.contains('voted-down') && _gel('watch-comment-vote-down').classList.contains('voted-down'))) {
            if (s == 1) {
                if (document.querySelector('.current[data-id="'+ id +'"]').getAttribute('user-score') != 0) {
                    document.querySelector('.current[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('.current[data-id="'+ id +'"]').getAttribute('data-score')) + 1);
                    document.querySelector('[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('[data-id="'+ id +'"]').getAttribute('data-score')) + 1);
                }
                else {
                    document.querySelector('.current[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('.current[data-id="'+ id +'"]').getAttribute('data-score')) + 2);
                    document.querySelector('[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('[data-id="'+ id +'"]').getAttribute('data-score')) + 2);
                }
            }
            else if (s == 0) {
                if (document.querySelector('.current[data-id="'+ id +'"]').getAttribute('user-score') != 1) {
                    document.querySelector('.current[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('.current[data-id="'+ id +'"]').getAttribute('data-score')) - 1);
                    document.querySelector('[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('[data-id="'+ id +'"]').getAttribute('data-score')) - 1);
                }
                else {
                    document.querySelector('.current[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('.current[data-id="'+ id +'"]').getAttribute('data-score')) - 2);
                    document.querySelector('[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('[data-id="'+ id +'"]').getAttribute('data-score')) - 2);
                }
            }
            document.querySelector('.current[data-id="'+ id +'"]').setAttribute('user-score', s);
            document.querySelector('[data-id="'+ id +'"]').setAttribute('user-score', s);
    }
    else {
            document.querySelector('.current[data-id="'+ id +'"]').setAttribute('user-score', 2);
            document.querySelector('[data-id="'+ id +'"]').setAttribute('user-score', 2);
            if (s == 1) {
                document.querySelector('.current[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('.current[data-id="'+ id +'"]').getAttribute('data-score')) - 1);
                document.querySelector('[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('[data-id="'+ id +'"]').getAttribute('data-score')) - 1);
            }
            else if (s == 0) {
                document.querySelector('.current[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('.current[data-id="'+ id +'"]').getAttribute('data-score')) + 1);
                document.querySelector('[data-id="'+ id +'"]').setAttribute('data-score', parseInt(document.querySelector('[data-id="'+ id +'"]').getAttribute('data-score')) + 1);
            }
    }
    var url = "/a/rate_comment?id="+ id +"&like="+s;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
        } else {
            alert('Something went wrong!');
        }
    };

    xhr.onerror = function() {
        alert('Something went wrong!');
    };

    xhr.send();
}
function flagCom(e) {
    var id = document.getElementsByClassName('current')[0].getAttribute("data-id");
    if (document.querySelector('.current[data-id="'+ id +'"]').getAttribute("user-flag") == 0) {
        document.querySelector('.current[data-id="'+ id +'"] .content').innerHTML = "<i>" + langs_marked + "</i> <a href='#' onclick='showSpam(this); return false;' rel='nofollow'>"+ langs_spamshow +"</a> <br class='spambr'><span class='hidden-comment'>"+ document.querySelector('.current[data-id="'+ id +'"] .content').innerHTML +"</span>";
        document.querySelector('.current[data-id="'+ id +'"]').setAttribute("user-flag", 1);
    }
    else {
        document.querySelector('.current[data-id="'+ id +'"] .content').innerHTML = document.querySelector('.current[data-id="'+ id +'"] .hidden-comment').innerHTML;
        document.querySelector('.current[data-id="'+ id +'"]').setAttribute("user-flag", 0);
    }
    var url = "/a/mark_as_spam?id="+id;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
        } else {
            alert('Something went wrong!');
        }
    };

    xhr.onerror = function() {
        alert('Something went wrong!');
    };

    xhr.send();
}
function post_comment(url) {
    var comment = document.getElementsByClassName("comments-textarea")[0].value;
    document.getElementsByClassName("watch-comments-post")[0].classList.add('yt-button-disabled');
    document.getElementsByClassName("watch-comments-post")[0].removeAttribute("onclick");
    document.getElementsByClassName("comments-textarea")[0].disabled = !0;
    if (comment.length > 0) {
        $.ajax({
            type: "POST",
            url: "/a/post_comment",
            data: {
                attach_url: url,
                comment_text: comment
            },
            success: function(output) {
                if (output.response == "success") {
                    document.getElementsByClassName("comments-post-result")[0].innerHTML = "<span style='color:green; font-weight:bold'>"+ langs_commentok +" </span>";
                }
                else if (output.response == "spam") {
                    document.getElementsByClassName("comments-post-result")[0].innerHTML = "<span style='color:red; font-weight:bold'>"+ langs_commenterror +" </span>";
                    alert(langs_commentspammsg);
                }
                else if (output.response == "spam2") {
                    document.getElementsByClassName("comments-post-result")[0].innerHTML = "<span style='color:red; font-weight:bold'>"+ langs_commenterror +" </span>";
                    alert(langs_commentspammsg2);
                }
            }
        })
    } else {
        alert(langs_emptycomment);
        _gel("comment_submit").disabled = !1;
        _gel("comment_text").disabled = !1;
        _gel("comment_submit").value = langs_postcomment;
    }
}
function showSpam(e) {
    var dis = e.parentElement.getElementsByClassName('hidden-comment')[0].style.display;
    if (dis != "inline") {
        e.parentElement.getElementsByClassName('hidden-comment')[0].style.display = "inline";
        e.parentElement.getElementsByClassName('spambr')[0].style.display = "block";
        e.innerHTML = langs_spamhide;
    }
    else {
        e.parentElement.getElementsByClassName('hidden-comment')[0].style.display = "none";
        e.parentElement.getElementsByClassName('spambr')[0].style.display = "none";
        e.innerHTML = langs_spamshow;
    }
}
function delete_comment() {
    var id = document.getElementsByClassName('current')[0].getAttribute("data-id");
    document.querySelector('.current[data-id="'+ id +'"]').outerHTML = "";
    for (i = 0; i < document.querySelectorAll('[data-id="'+ id +'"]').length; i++) {
        document.querySelectorAll('[data-id="'+ id +'"]')[i].outerHTML = "";
    }
    var url = "/a/delete_video_comment?id="+id;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            var num = _gel('comment-amount');
            num.innerHTML = num.innerHTML - 1;
        } else {
            showErrorMessage();
        }
    };

    xhr.onerror = function() {
        showErrorMessage();
    };

    xhr.send();
}
function moreFrom(e) {
    e.classList.toggle('yt-uix-expander-collapsed');
    _gel('watch-more-from-user').classList.toggle('collapsed');
    if (_gel('watch-channel-loading')) {
        $.ajax({
            url: "/a/watch_more_from_user.php?user=" + video_uploader + "&url=" + video_url,
            success: function(html){
                if(html){
                        _gel('watch-channel-discoverbox').outerHTML = html;
                } else {
                    alert('Something went wrong!');
                }
            }
        });
    }
}
function carousel(e) {
    var p = _gel('watch-channel-discoverbox').getAttribute('data-carousel-slide-selected');
    var max_p = Math.ceil(document.querySelectorAll('#watch-channel-discoverbox .video-list-item').length / 6);
    if (e == "next") {
        if (p < max_p) {
            document.getElementsByClassName('yt-uix-carousel-slides')[0].style.left = parseInt(document.getElementsByClassName('yt-uix-carousel-slides')[0].style.left,10) - 888 + "px";
            _gel('watch-channel-discoverbox').setAttribute('data-carousel-slide-selected',++p);
        }
    }
    else if (e == "prev") {
        if (p > 1) {
        document.getElementsByClassName('yt-uix-carousel-slides')[0].style.left = parseInt(document.getElementsByClassName('yt-uix-carousel-slides')[0].style.left,10) + 888 + "px";
        _gel('watch-channel-discoverbox').setAttribute('data-carousel-slide-selected',--p);
        }
    }
    else {
        document.getElementsByClassName('yt-uix-carousel-slides')[0].style.left = - ((e - 1) * 888) + "px";
        _gel('watch-channel-discoverbox').setAttribute('data-carousel-slide-selected',e);
    }
}
function subscribe() {
    changeSubscribeDiv();
    var url = "/a/subscription_center?user=" + video_uploader;

    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
        } else {
            // Błąd
            showErrorMessage();
        }
    };

    xhr.onerror = function() {
        // Błąd sieciowy
        showErrorMessage();
    };

    xhr.send();
}

function changeSubscribeDiv() {
const sub_tooltip = langs_subscribetooltip;
const unsub_tooltip = langs_unsubscribetooltip;
x = _gel('subscribeDiv');
y = _gel('unsubscribeDiv');
if (_gel('subscribeDiv')) {
    x.children[0].innerHTML = langs_unsubscribe;
    x.title = unsub_tooltip;
    x.id = "unsubscribeDiv";
} else if (_gel('unsubscribeDiv')) {
    y.children[0].innerHTML = langs_subscribe;
    y.title = sub_tooltip;
    y.id = "subscribeDiv";
}
}

function openPlaylistMenu() {
    _gel('watch-next-list').classList.toggle("yt-uix-expander-collapsed");
}

function toggleHov(e) {
    e.classList.toggle("hovered");
}

function openOptions(e) {
    if (!e.getElementsByClassName('yt-uix-button-menu')[0].classList.contains("hovered")) {
        if (e.getElementsByClassName('yt-uix-button-menu')[0].style.display == "none") {
        e.getElementsByClassName('yt-uix-button-menu')[0].style.display = "block";
        e.classList.add("yt-uix-button-active");
        e.getElementsByClassName('yt-uix-button-menu')[0].style.left = 0;
        e.getElementsByClassName('yt-uix-button-menu')[0].style.top = e.getBoundingClientRect().top + scrollY - 146 + "px";
        } 
        else { 
            e.getElementsByClassName('yt-uix-button-menu')[0].style.display = "none"; 
            e.classList.remove("yt-uix-button-active");
        }
    }
}
function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function eraseCookie(name) {   
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
function toggleAutoplay(e) {
    e.classList.toggle("autoplay-off");
    e.classList.toggle("autoplay-on");
    if (e.classList.contains("autoplay-on")) {
        e.getElementsByClassName("yt-uix-button-content")[0].innerHTML = langs_autoplayon;
        setCookie("autoplay",true,30);
    }
    else {
        e.getElementsByClassName("yt-uix-button-content")[0].innerHTML = langs_autoplayoff;
        eraseCookie("autoplay");
    }
}
function toggleQL() {
    _gel("watch-passive-QL").classList.toggle("yt-uix-expander-collapsed");
}
function editVideoDetail() {
    _gel('edit-menu').classList.add('hid');
    _gel('edit-menu-active').classList.remove('hid');
    _gel('watch-headline-container').classList.add('hid');
    _gel('edit-info-title').classList.remove('hid');
    _gel('video-status').querySelector("#info-box").classList.add('hid');
    _gel('video-status-edit').classList.remove('hid');
    _gel('watch-views').classList.add('hid');
    _gel('watch-description').classList.add('hid');
    _gel('video-info-edit').classList.remove('hid');
}
function cancelVideoDetail() {
    _gel('edit-menu').classList.remove('hid');
    _gel('edit-menu-active').classList.add('hid');
    _gel('watch-headline-container').classList.remove('hid');
    _gel('edit-info-title').classList.add('hid');
    _gel('video-status').querySelector("#info-box").classList.remove('hid');
    _gel('video-status-edit').classList.add('hid');
    _gel('watch-views').classList.remove('hid');
    _gel('watch-description').classList.remove('hid');
    _gel('video-info-edit').classList.add('hid');
    _gel('edit-menu-settings').classList.add('hid');
}
function saveVideoDetail() {
    var title = _gel('edit-video-title').value;
    var desc = _gel('video-info-description').value;
    var tags = _gel('video-info-tags').value;
    var category = _gel('video-info-category').value;
    var privacy = _gel('edit-video-privacy').value;
    var ratings = _gel('edit-ratings').checked ? 1 : 0;
    if (_gel('edit-video-comments-1').checked) {
        var comments = 1;
    }
    else if (_gel('edit-video-comments-2').checked) {
        var comments = 2;
    }
    else {
        var comments = 0;
    }
    var id = video_url;
    _gel('content').style.opacity = "0.5";
    _gel('content').style.pointerEvents = "none";
    console.log(langs_cat[category]);
    if (category > 0 && category < 22) {
        var cat_name = langs_cat[category];
    }
    else {
        var cat_name = "";
    }
    $.ajax({
        type: "POST",
        url: "/a/save_video_changes",
        data: {
            tit: title,
            des: desc,
            tag: tags,
            pri: privacy,
            cat: category,
            com: comments,
            rat: ratings,
            url: id
        },
        success: function(output) {
            if (output.response == "success") {
                _gel('watch-headline-title').innerHTML = '<span title="'+ title.trim() +'">'+ title.trim() +'</span>';
                if (privacy == 1) {
                    document.querySelector('#info-box .yt-alert-content').innerHTML = langs_thisvideoispublic;
                }
                else if (privacy == 2) {
                    document.querySelector('#info-box .yt-alert-content').innerHTML = langs_thisvideoisprivate;
                }
                else {
                    document.querySelector('#info-box .yt-alert-content').innerHTML = langs_thisvideoisunlisted;
                }
                document.querySelector('.watch-expander-head-content div:last-of-type').innerHTML = desc.trim().replace(/\n/g, "<br />");
                _gel('video-desc').innerHTML = desc.trim().replace(/\n/g, "<br />");
                _gel('watch-category').innerHTML = '<span>Categoría:</span><a href="/browse?category='+ category +'">'+ cat_name +'</a></div>';
                var tag_array = tags.split(',');
                document.querySelector('#watch-tags div').innerHTML = "";
                for (i = 0; i < tag_array.length; i++) {
                    document.querySelector('#watch-tags div').innerHTML += '<a href="/results?search=+'+ tag_array[i].trim() +'&amp;t=Search+Videos">'+ tag_array[i].trim() +'</a>&nbsp;';
                }
                _gel('edit-menu-settings').classList.add('hid');
                cancelVideoDetail();
                _gel('content').style.opacity = "1";
                _gel('content').style.pointerEvents = "all";
                _gel('edit-status').classList.remove('hid');
            }
            else {
                alert('Something went wrong!');
            }
        }
    })
}
function toggleSettings() {
    _gel('edit-menu-settings').classList.toggle('hid');
}
function openFlagDropdown(e) {
    for (i = 1; i < 8; i++) {
        if (_gel('flag-dropdown-'+ i)) {
            _gel('flag-dropdown-'+ i).classList.add('hid');
        }
    }
    var dropdown = _gel('flag-dropdown');
    var rect = e.getBoundingClientRect();
    e.classList.toggle('yt-uix-in-active');
    dropdown.classList.toggle('hid');
    dropdown.style.left = rect.left - (window.innerWidth - 960)/2 + "px";
    dropdown.style.top = 73 + _gel('flag-desc').offsetHeight + e.offsetHeight + "px";
}
function showSubcategory(n,e) {
    for (i = 1; i < 8; i++) {
        if (_gel('flag-dropdown-'+ i)) {
            _gel('flag-dropdown-'+ i).classList.add('hid');
        }
    }
    _gel('flag-dropdown-'+ n).classList.remove('hid');
    var rect = e.getBoundingClientRect();
    _gel('flag-dropdown-'+ n).style.left = rect.left + e.offsetWidth - (window.innerWidth - 960)/2 + "px";
    _gel('flag-dropdown-'+ n).style.top = 75 + (n - 1) * 22 + _gel('flag-desc').offsetHeight + e.offsetHeight + "px";
}
function hideSubcategory(n) {
    _gel('flag-dropdown-'+ n).classList.add('hid');
    _gel('flag-dropdown').getElementsByClassName('yt-uix-button-menu-item')[n-1].classList.remove('yt-uix-in-active');
}
function stayCategory(n) {
    _gel('flag-dropdown').getElementsByClassName('yt-uix-button-menu-item')[n-1].classList.add('yt-uix-in-active');
}
function hideSubcategories() {
    for (i = 1; i < 8; i++) {
        if (_gel('flag-dropdown-'+ i)) {
            if (!_gel('flag-dropdown-'+ i).querySelector(':hover')) {
                _gel('flag-dropdown-'+ i).classList.add('hid');
            }
        }
    }
}
function setFlag(n,e) {
    for (i = 1; i < 8; i++) {
        if (_gel('flag-dropdown-'+ i)) {
            _gel('flag-dropdown-'+ i).classList.add('hid');
        }
    }
    _gel('flag-dropdown').classList.add('hid');
    _gel('watch-flag-select').classList.remove('yt-uix-in-active');
    _gel('watch-flag-select').innerHTML = e.innerHTML;
    if (n == 3.1) {
        document.querySelector('.box.time').classList.add('hid');
        document.querySelector('.box.hatred').classList.remove('hid');
    }
    else if (n == 1.1 || n == 1.2 || n == 1.3 || n == 1.4) {
        document.querySelector('.box.time').classList.remove('hid');
        document.querySelector('.box.hatred').classList.add('hid');
    }
    else {
        document.querySelector('.box.time').classList.add('hid');
        document.querySelector('.box.hatred').classList.add('hid');
    }
    _gel('watch-flag-select').value = n;
}
function flagThisVideo() {
    if (!_gel('watch-flag-select').value) {
        alert("Please select a reason to report this video as inappropiate.");
    }
    else {
        var reason_num = _gel('watch-flag-select').value;
        var additional_info = "";
        if (reason_num == 1.1 || reason_num == 1.2 || reason_num == 1.3 || reason_num == 1.4) {
            if (document.getElementsByName("flag_minutes")[0].value && document.getElementsByName("flag_seconds")[0].value) {
                additional_info += "Timestamp: " + document.getElementsByName("flag_minutes")[0].value + ":" + document.getElementsByName("flag_seconds")[0].value;
            }
        }
        else if (reason_num == 3.1) {
            if (_gel("hatred-group").value) {
                additional_info += "Attacked group: " + _gel("hatred-group").value.replace("_"," ");
            }
            if (_gel("hatred-more-info").value) {
                additional_info += ". Additional Information: " + _gel("hatred-more-info").value;
            }
        }
        $.ajax({
            type: "POST",
            url: "/a/flag_video",
            data: {
                number: reason_num,
                info: additional_info,
                v: video_url,
            },
            dataType: "json",
            success: function(output) {
                if (output.response == "success") {
                    _gel("inappropriateVidDiv").innerHTML = '<img class="watch-check-grn-circle" src="/img/check-grn-circle-vfl91176.png" style="float: left;margin-right: 8px;"> <div style="height: 16px;line-height: 16px;">Thank you for sharing your concerns.</div>';
                }
                else {
                    alert('Something went wrong!');
                }
            }
        });
    }
}
function addToQueue(e) {
    var url = e.id.replace("yt-uix-button-","");
    var url = "/a/quicklist?v="+url;
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
            } else {
                showErrorMessage();
            }
        };
        xhr.onerror = function() {
            showErrorMessage();
        };
        xhr.send();
}

function loadPlaylists() {
    if (_gel('loading-playlists')) {
    $.ajax({
        url: "/a/load_playlists.php",
        success: function(html){
            if(html){
                _gel('loading-playlists').outerHTML = html;
            } else {
                alert('Something went wrong!');
            }
        }
    });
    }
}

function openTextbox(e) {
    document.querySelector("#watch-playlists-button ul").style.display = 'block';
    e.style.display = 'none';
    _gel('playlist-title').classList.remove('hid');
    _gel('playlist-title').focus();

    _gel('playlist-title').addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            document.querySelector("#watch-playlists-button ul").style.display = '';
            _gel('playlist-title').classList.add('hid');
            e.style.display = '';
            createPlaylistAndAdd(_gel('playlist-title').value);
            _gel('playlist-title').value = '';
        }
    });
}

function createPlaylistAndAdd(playlist) {
    $.ajax({
        type: "POST",
        url: "/a/new_playlist",
        data: {
            pl_title: playlist,
        },
        success: function(output) {
            if (output.response == "success") {
                saveTo(output.id);
                var pl_html = '<li><span class="yt-uix-button-menu-item" onclick="saveTo(\''+ output.id +'\');return false;">'+ playlist +' (1 video)</span></li>';
                document.querySelectorAll("#watch-playlists-button ul li")[document.querySelectorAll("#watch-playlists-button ul li").length - 2].outerHTML += pl_html;
            }
            else {
                alert("Something went wrong!");
            }
        }
    })
}
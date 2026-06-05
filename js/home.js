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

function move_up(h_module) {
    var next = $("#homepage-content-block-" + h_module).prev().attr('id');
    var url = "/a/move_module?module=" + h_module + "&direction=up&info="+next;
    var xhr = new XMLHttpRequest();

    if (next != undefined && next != "homepage-content-block-h_spotlight") {
    $("#homepage-content-block-" + h_module).swapWith("#" + next);
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
}

function move_down(h_module) {
    var prev = $("#homepage-content-block-" + h_module).next().attr('id');
    var url = "/a/move_module?module=" + h_module + "&direction=down&info="+prev;
    var xhr = new XMLHttpRequest();

    if (prev != undefined && prev != "homepage-content-block-h_spotlight") {
    $("#homepage-content-block-" + h_module).swapWith("#" + prev);
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
}

jQuery.fn.swapWith = function(to) {
    return this.each(function() {
        var copy_to = $(to).clone(!0);
        var copy_from = $(this).clone(!0);
        $(to).replaceWith(copy_from);
        $(this).replaceWith(copy_to)
    })
};

function close_module(h_module) {
    var mod = _gel('homepage-content-block-'+h_module);
    var url = "/a/close_module?module="+h_module;
    var xhr = new XMLHttpRequest();
    mod.style.display = "none";
    xhr.open('GET', url, true);

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            mod.outerHTML = "";
        } else {
            showErrorMessage();
        }
    };

    xhr.onerror = function() {
        mod.style.display = "block";
        showErrorMessage();
    };

    xhr.send();
}

function set_num_grid(h_module,num) {
    _gel(h_module+'-loading-msg').style.display = "block";
    _gel(h_module+'-loading-icn').style.display = "block";
    $.ajax({
            url: "/a/set_num_grid?module=" + h_module + "&num=" + num,
            success: function(html){
                if(html){
                    $("#homepage-sub-block-contents-" + h_module).replaceWith(html);
                    _gel(h_module+'-loading-msg').style.display = "none";
                    _gel(h_module+'-loading-icn').style.display = "none";
                }else{
                    alert("Something went wrong!");
                }
            }
        });
    }
function set_num_list(h_module,num) {
    _gel(h_module+'-loading-msg').style.display = "block";
    _gel(h_module+'-loading-icn').style.display = "block";
    $.ajax({
            url: "/a/set_num_list?module=" + h_module + "&num=" + num,
            success: function(html){
                if(html){
                    $("#homepage-sub-block-contents-" + h_module).replaceWith(html);
                    _gel(h_module+'-loading-msg').style.display = "none";
                    _gel(h_module+'-loading-icn').style.display = "none";
                }else{
                    alert("Something went wrong!");
                }
            }
        });
    }

function set_num_activity(h_module,num) {
    _gel(h_module+'-loading-msg').style.display = "block";
    _gel(h_module+'-loading-icn').style.display = "block";
    $.ajax({
            url: "/a/set_num_activity?module=" + h_module + "&num=" + num,
            success: function(html){
                if(html){
                    $("#homepage-sub-block-contents-" + h_module).replaceWith(html);
                    _gel(h_module+'-loading-msg').style.display = "none";
                    _gel(h_module+'-loading-icn').style.display = "none";
                }else{
                    alert("Something went wrong!");
                }
            }
        });
    }

function change_layout(h_module,style) {
    _gel(h_module+'-loading-msg').style.display = "block";
    _gel(h_module+'-loading-icn').style.display = "block";
    if (h_module == "h_subscriptions") {
                        var h_module_short = "SUB";
    }
    if (h_module == "h_featured") {
                        var h_module_short = "FEAT";
    }
    if (h_module == "h_recommended") {
                        var h_module_short = "REC";
    }
    if (h_module == "h_beingwatched") {
                        var h_module_short = "POP";
    }
    $.ajax({
            url: "/a/change_layout?module=" + h_module + "&style=" + style,
            success: function(html){
                if(html){
                    $("#homepage-sub-block-contents-" + h_module).replaceWith(html);
                    if (style == "list")
                    {
                        _gel(h_module_short+'-options-AGG').style.display = "none";
                        _gel(h_module_short+'-options-SIN').style.display = "block";
                        _gel(h_module_short+'-options-BTH').style.display = "none";
                        var num = $('#homepage-sub-block-contents-'+ h_module +' .feed-item').length;
                        $("#"+ h_module +"-options-num").replaceWith("<select id='"+h_module+"-options-num' name='test-options-num' onchange='set_num_list(&quot;"+h_module+"&quot;, this.value)'><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option></select>");
                        _gel(h_module +"-options-num").value = num;
                    } 
                    if (style == "grid")
                    {
                        _gel(h_module_short+'-options-AGG').style.display = "block";
                        _gel(h_module_short+'-options-SIN').style.display = "none";
                        _gel(h_module_short+'-options-BTH').style.display = "none";
                        var num = $('#homepage-sub-block-contents-'+h_module+' .homepage-sponsored-video').length;
                        if (num > 0 && num <= 4) {
                            num = 1;
                        }
                        if (num > 4 && num <= 8) {
                            num = 2;
                        }
                        if (num > 8 && num <= 12) {
                            num = 3;
                        }
                        $("#"+ h_module +"-options-num").replaceWith("<select id='"+h_module+"-options-num' name='test-options-num' onchange='set_num_grid(&quot;"+h_module+"&quot;, this.value)'><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>");
                        _gel(h_module +"-options-num").value = num;
                    } 
                    if (style == "bigthumb")
                    {
                        _gel(h_module_short+'-options-BTH').style.display = "block";
                        _gel(h_module_short+'-options-SIN').style.display = "none";
                        _gel(h_module_short+'-options-AGG').style.display = "none";
                        $("#"+ h_module +"-options-num").replaceWith("<select id='"+h_module+"-options-num' name='test-options-num' onchange='set_num_grid(&quot;"+h_module+"&quot;, this.value)'><option value='4'>4</option>");
                        _gel(h_module +"-options-num").value = 4;
                    } 
                    _gel(h_module+'-loading-msg').style.display = "none";
                    _gel(h_module+'-loading-icn').style.display = "none";
                }else{
                    alert("Something went wrong!");
                }
            }
        });
    }

    function open_option_box(h_module) {
    var box = _gel(h_module + '-options');
    if (box.style.display != "block") {
        box.style.display = "block";
    }
    else {
        box.style.display = "none";
    }
}

function loadMoreVids(e,from) {
    var page = document.getElementsByClassName('homepage-sub-block-contents').length + 1;
    e.style.opacity = "0.6";
    e.style.pointerEvents = "none";
    e.querySelector('span').innerHTML = langs_loading + ' <img src="/img/icn_loading_animated.gif">';
    $.ajax({
        url: "/a/feed_load_videos?page=" + page + "&from=" + from,
        success: function(html){
            e.outerHTML = "";
            document.getElementsByClassName('homepage-content-block')[0].innerHTML += html;
        }
    });
}

function changeFeedPage(page) {
    document.getElementsByClassName("feed-bar-loading")[0].classList.toggle('hid');
    document.getElementsByClassName("feed-bar")[0].classList.toggle('square');
    _gel(page).classList.add('current');
    if (page == "all") {
        _gel("subscriptions").classList.remove('current');
    } else {
        _gel("all").classList.remove('current');
    }
    $.ajax({
        url: "/a/feed_load_videos?page=1&from=" + page,
        success: function(html){
            var del = document.getElementsByClassName('homepage-sub-block-contents').length;
            for (i = 0; i < del; i++) {
                document.getElementsByClassName('homepage-sub-block-contents')[0].outerHTML = "";
            }
            document.getElementsByClassName('homepage-content-block')[0].innerHTML += html;
            document.getElementsByClassName("feed-bar-loading")[0].classList.toggle('hid');
            document.getElementsByClassName("feed-bar")[0].classList.toggle('square');
        }
    });
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
function forgetFeed() {
    _gel('iyt-login-suggest-box').outerHTML = "";
    setCookie("feed_forget",1,90);
}
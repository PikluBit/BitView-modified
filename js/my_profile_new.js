function _gel(id) {
    return document.getElementById(id);
}

function ref(instance_or_id) {
    return (typeof (instance_or_id) == "string") ? _gel(instance_or_id) : instance_or_id;
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

function delete_channel_comment(id) {
                                    var url = "/a/delete_channel_comment?id="+id;
                                    var xhr = new XMLHttpRequest();
                                    xhr.open('GET', url, true);

                                    xhr.onload = function() {
                                        if (xhr.status >= 200 && xhr.status < 400) {
                                            _gel("cc_"+id).outerHTML = "";
                                            changeCommentAmount();
                                        } else {
                                            showErrorMessage();
                                        }
                                    };

                                    xhr.onerror = function() {
                                        showErrorMessage();
                                    };

                                    xhr.send();
                                }
function changeCommentAmount() {
    var x = _gel('channel-box-item-count');
    x.innerHTML = x.innerHTML - 1;
}
function delete_bulletin(id) {
                                    var url = "/a/profile_new/delete_bulletin?id="+id;
                                    var xhr = new XMLHttpRequest();
                                    xhr.open('GET', url, true);

                                    xhr.onload = function() {
                                        if (xhr.status >= 200 && xhr.status < 400) {
                                            _gel("feed_item_"+id).outerHTML = "";
                                            _gel("feed_divider_"+id).outerHTML = "";
                                            changeCommentAmount();
                                        } else {
                                            showErrorMessage();
                                        }
                                    };

                                    xhr.onerror = function() {
                                        showErrorMessage();
                                    };

                                    xhr.send();
                                }
function subscribe() {
        var url = "/a/subscription_center?user="+ profile_username;

        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                changeSubscribeDiv();
            } else {
                // BÅ‚Ä…d
                alert("Bad response from server.");
            }
        };

        xhr.onerror = function() {
            // BÅ‚Ä…d sieciowy
            alert("Bad response from server.");
        };

        xhr.send();
}

function changeSubscribeDiv() {
    x = $(".subscribe-div #subscribeDiv");
    xs = $(".subscribe-div #subscribe-button");
    y = $(".subscribe-div #unsubscribeDiv");
    ys = $(".subscribe-div #unsubscribe-button");
    if (x && xs) {
        x.each(function() {
            x.attr("id","unsubscribeDiv");
        });
        xs.each(function() {
            xs.attr("class","unsubscribe");
            xs.attr("id","unsubscribe-button");
            xs.text(langs_unsubscribe);
        });
    } 
    if (y && ys) {
        y.each(function() {
            y.attr("id","subscribeDiv");
        });
        ys.each(function() {
            ys.attr("class","unsubscribe");
            ys.attr("id","subscribe-button");
            ys.text(langs_subscribe);
        });
    }
}

function addclass(div,newclass) {
    var div = _gel(div);
    div.classList.add(newclass);
}
function removeclass(div,newclass) {
    var div = _gel(div);
    div.classList.remove(newclass);
}
function reload_js(src) {
    $('script[src="' + src + '"]').remove();
    $('<script>').attr('src', src).appendTo('head');
}
function rate_video(rating,id) {
        var url = "/a/rate_video?stars=" + rating + "&v="+ id;
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                // Sukces
            } else {
                // BÅ‚Ä…d
                alert("Bad response from server.");
            }
        };

        xhr.onerror = function() {
            // BÅ‚Ä…d sieciowy
            alert("Bad response from server.");
        };

        xhr.send();
    }
function change_comments_page(channel,page) {
            $(".box-bg.box-fg.inner-box.loading-div").show();
            $.ajax({
                url: "/a/profile_new/channel_comment_pages.php?channel=" + channel + "&page=" + page,
                success: function(html){
                    if(html){
                        $(".box-bg.box-fg.inner-box.loading-div").hide();
                        $("#user_comments").replaceWith(html);
                    } else {
                        alert("Bad response from server.");
                    }
                }
            });
    }
function selectTab(tab,username) {
    var view = $(".view-button-selected").attr('id');
    if (view == "playview-icon") {
        $("#playnav-play-loading").show();
        var already_selected = document.getElementsByClassName("navbar-tab");
        for(var i = 0; i < already_selected.length; i++)
        {
            already_selected[i].classList.remove("navbar-tab-selected");
        }
        var select_tab = _gel("playnav-navbar-tab-" + tab);
        select_tab.classList.add("navbar-tab-selected");
        $.ajax({
                        url: "/a/profile_new/select_tab.php?tab=" + tab + "&username=" + username,
                        success: function(html){
                            if(html){
                                $("#playnav-play-content").replaceWith(html);
                                $("#playnav-play-loading").hide();
                            } else {
                                alert("Bad response from server.");
                            }
                        }
                    });
    }
    if (view == "gridview-icon") {
        var already_selected = document.getElementsByClassName("navbar-tab");
        for(var i = 0; i < already_selected.length; i++)
        {
            already_selected[i].classList.remove("navbar-tab-selected");
        }
        var select_tab = _gel("playnav-navbar-tab-" + tab);
        select_tab.classList.add("navbar-tab-selected");
        selectView('grid',profile_username);
    }
}
function sortVideos(order,username) {
    var view = $(".view-button-selected").attr('id');
    if (view == "playview-icon") {
        $("#playnav-play-loading").show();
        $.ajax({
                        url: "/a/profile_new/sort_videos.php?order=" + order + "&username=" + username,
                        success: function(html){
                            if(html){
                                $("#playnav-play-loading").hide();
                                $("#playnav-play-uploads-items").replaceWith(html);
                                $(".outer-scrollbox").attr("onscroll","loadVideos('uploads', 2, '"+username+"', '"+order+"');");
                            } else {
                                alert("Bad response from server.");
                            }
                        }
                    });
    }
    if (view == "gridview-icon") {
        $("#playnav-grid-loading").show();
        $.ajax({
                        url: "/a/profile_new/sort_videos_grid.php?order=" + order + "&username=" + username,
                        success: function(html){
                            if(html){
                                $("#playnav-grid-loading").hide();
                                $("#playnav-grid-content #playnav-play-uploads-items").replaceWith(html);
                                $("#playnav-grid-content .outer-scrollbox").attr("onscroll","loadVideos('uploads', 2, '"+username+"', '"+order+"');");
                            } else {
                                alert("Bad response from server.");
                            }
                        }
                    });
    }
}
function searchChannel(id,username) {
    var view = $(".view-button-selected").attr('id');
    if (view == "playview-icon") {
        $("#playnav-play-loading").show();
        var query = _gel(id).value;
        $.ajax({
                        url: "/a/profile_new/search_channel.php?query=" + query + "&username=" + username,
                        success: function(html){
                            if(html){
                                $("#playnav-play-loading").hide();
                                $("#playnav-play-uploads-items").replaceWith(html);
                            } else {
                                alert("Bad response from server.");
                            }
                        }
                    });
    }
    if (view == "gridview-icon") {
        $("#playnav-grid-loading").show();
        var query = _gel(id).value;
        $.ajax({
                        url: "/a/profile_new/search_channel_grid.php?query=" + query + "&username=" + username,
                        success: function(html){
                            if(html){
                                $("#playnav-grid-loading").hide();
                                $("#playnav-grid-content  #playnav-play-uploads-items").replaceWith(html);
                                $(".outer-scrollbox .alignC").remove();
                            } else {
                                alert("Bad response from server.");
                            }
                        }
                    });
    }
}
function loadVideos(tab,page,username,order) {
    var view = $(".view-button-selected").attr('id');
    if (view == "playview-icon") {
        $(".outer-scrollbox").attr("onscroll","");
        $("#show-more-"+page).replaceWith('<div class="alignC" id="show-more-'+ page +'"><img src="/img/icn_loading_animated.gif"></div>');
        $.ajax({
                        url: "/a/profile_new/load_more_videos.php?tab="+ tab +"&page=" + page + "&username=" + username + "&order=" + order,
                        success: function(html){
                            if(html){
                                $("#show-more-"+page).remove();
                                $("#playnav-play-"+ tab +"-items").append(html);
                                var newpage = page + 1;
                                if ($("#show-more-"+newpage).length > 0) {
                                    $(".outer-scrollbox").attr("onscroll","loadVideos('"+tab+"', "+ newpage +", '"+username+"', '"+order+"');");
                                } 
                                else {
                                    $(".outer-scrollbox").attr("onscroll","");
                                }
                            } else {
                                alert("Bad response from server.");
                            }
                        }
                    });
    }
    if (view == "gridview-icon") {
    $("#playnav-grid-content .outer-scrollbox").attr("onscroll","");
    $("#playnav-grid-content #show-more-"+page).replaceWith('<div class="alignC" id="show-more-'+ page +'"><img src="/img/icn_loading_animated.gif"></div>');
        $.ajax({
                        url: "/a/profile_new/load_more_videos_grid.php?tab="+ tab +"&page=" + page + "&username=" + username + "&order=" + order,
                        success: function(html){
                            if(html){
                                $("#playnav-grid-content #show-more-"+page).remove();
                                $("#playnav-grid-content #playnav-play-"+ tab +"-items").append(html);
                                var newpage = page + 1;
                                if ($("#playnav-grid-content #show-more-"+newpage).length > 0) {
                                    $("#playnav-grid-content .outer-scrollbox").attr("onscroll","loadVideos('"+tab+"', "+ newpage +", '"+username+"', '"+order+"');");
                                } 
                                else {
                                    $("#playnav-grid-content .outer-scrollbox").attr("onscroll","");
                                }
                            } else {
                                alert("Bad response from server.");
                            }
                        }
                    });
    }
}
function selectPanel(panel,url) {
    var already_selected = document.getElementsByClassName("panel-tab-selected");
    for(var i = 0; i < already_selected.length; i++)
    {
        already_selected[i].classList.remove("panel-tab-selected");
    }
    var select_tab = _gel("playnav-panel-tab-" + panel);
    select_tab.classList.add("panel-tab-selected");
    var loading = _gel("playnav-video-panel-loading");
    loading.style.display = "block";
    $.ajax({
                    url: "/a/profile_new/select_panel.php?panel="+ panel +"&url=" + url,
                    success: function(html){
                        if(html){
                            loading.style.display = "none";
                            $("#playnav-video-panel-inner").replaceWith(html);
                        } else {
                            alert("Bad response from server.");
                        }
                    }
                });
}
function post_comment(url) {
    var comment = _gel("comment_text").value;
    _gel("comment_submit").disabled = !0;
    _gel("comment_text").disabled = !0;
    _gel("comment_submit").value = langs_addingcomment;
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
                    _gel("comment_submit").value = langs_commentposted;
                    _gel("comment_submit").onclick = "";
                    var num = _gel("comment-amount").innerText;
                    num++;
                    $("#comment-amount").html(num);
                }
                else if (output.response == "spam") {
                    alert(langs_commentspammsg);
                    _gel("comment_submit").disabled = !1;
                    _gel("comment_text").disabled = !1;
                    _gel("comment_submit").value = langs_postcomment;
                    _gel("comment_text").value = "";
                    _gel("char-counter").innerHTML = "500";
                }
                else if (output.response == "spam2") {
                    alert(langs_commentspammsg2);
                    _gel("comment_submit").disabled = !1;
                    _gel("comment_text").disabled = !1;
                    _gel("comment_submit").value = langs_postcomment;
                    _gel("comment_text").value = "";
                    _gel("char-counter").innerHTML = "500";
                }
            }
        })
    } else {
        alert(langs_emptycomment);
        _gel("comment_submit").disabled = !1;
        _gel("comment_text").disabled = !1;
        _gel("comment_submit").value = langs_postcomment
    }
}
function chars_remaining() {
        let comment_content = _gel('comment_text').value;
        let comment_length = comment_content.length;
        _gel('char-counter').innerHTML = 500 - comment_length;
    }

function favorite_video(url) {
    _gel('favorite-remove').style.display = "none";
    _gel('favorite-saving').style.display = "block";
    var url = "/a/favorite_video?v="+ url;
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                _gel('favorite-saving').style.display = "none";
                _gel('favorite-added').style.display = "block";
            } else {
                alert("Bad response from server.");
            }
        };

        xhr.onerror = function() {
            alert("Bad response from server.");
        };

        xhr.send();
    }

    function undo_favorite(url) {
    _gel('favorite-added').style.display = "none";
    _gel('favorite-saving').style.display = "block";
    var url = "/a/favorite_video?v=" + url;

        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                _gel('favorite-remove').style.display = "block";
                _gel('favorite-saving').style.display = "none";
            } else {
                alert("Bad response from server.");
            }
        };

        xhr.onerror = function() {
            alert("Bad response from server.");
        };
        xhr.send();
    }

function addVideoToPlaylist(id) {
    var pl = _gel('select_playlist').value;
    var url = "/a/add_video_to_playlist?v="+ id +"&pl=" + pl;
    var xhr = new XMLHttpRequest();

        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                _gel('video-added-to-playlist').style.display = "block";
            } else {
                alert("Bad response from server.");
            }
        };

        xhr.onerror = function() {
            alert("Bad response from server.");
        };
        xhr.send();
    }
function flag_video(el) {
        if (el.innerHTML == langs_flagthisvid) {
            el.innerHTML = langs_removeflag;
        } else {
            el.innerHTML = langs_flagthisvid;
        }
    }
function toggleArranger(tab) {
    selectTab(tab,profile_username);
}
function open_playlist(from,count,id) {
    $("#playnav-play-loading").show();
    $.ajax({
                    url: "/a/profile_new/open_playlist.php?id="+id+"&user=" + profile_username,
                    success: function(html){
                        if(html){
                            $("#playnav-play-content").replaceWith(html);
                            nh = 595 - $("#playlist-info").outerHeight() - $(".scrollbox-separator").outerHeight() - 10;
                            $(".scrollbox-body").css("height", nh);
                            $("#playnav-play-loading").hide();
                        } else {
                            alert("Bad response from server.");
                        }
                    }
                });
}
function showhidehonors() {
  var x = _gel("BeginvidDeschonors");
  var xx = _gel("MorevidDeschonors");
  var y = _gel("RemainvidDeschonors");
  var yy = _gel("LessvidDeschonors");
  if (x.style.display === "block") {
    x.style.display = "none";
    xx.style.display = "none";
    y.style.display = "block";
    yy.style.display = "block";
  }
  else {
    x.style.display = "block";
    xx.style.display = "block";
    y.style.display = "none";
    yy.style.display = "none";
  }
}

function showHide(num) {
      var x = _gel("feed_item_j_"+ num +"_collapsed");
      var y = _gel("feed_item_j_"+ num +"_expanded");
      if (x.style.display === "block") {
        x.style.display = "none";
        y.style.display = "block";
      }
      else {
        x.style.display = "block";
        y.style.display = "none";
      }
    }

function post_channel_comment(url) {
    var comment = _gel("comment_entry_box_text").value;
    _gel("comment_entry_submit_button").disabled = !0;
    _gel("comment_entry_box_text").disabled = !0;
    _gel("comment_entry_submit_button").value = langs_addingcomment;
    if (comment.length > 0) {
        $.ajax({
            type: "POST",
            url: "/a/profile_new/post_channel_comment",
            data: {
                username: url,
                comment_text: comment
            },
            success: function(output) {
                if (output.response == "success") {
                    _gel("comment_entry_submit_button").value = langs_commentposted;
                    $("#comment_entry_submit_button").attr("onclick","");
                    var num = _gel("channel-box-item-count").innerText;
                    num++;
                    $("#channel-box-item-count").html(num);
                }
                else if (output.response == "spam") {
                    alert(langs_commentspammsg);
                    _gel("comment_entry_submit_button").disabled = !1;
                    _gel("comment_entry_box_text").disabled = !1;
                    _gel("comment_entry_submit_button").value = langs_postcomment;
                    _gel("comment_entry_box_text").value = "";
                }
                else if (output.response == "spam2") {
                    alert(langs_commentspammsg2);
                    _gel("comment_entry_submit_button").disabled = !1;
                    _gel("comment_entry_box_text").disabled = !1;
                    _gel("comment_entry_submit_button").value = langs_postcomment;
                    _gel("comment_entry_box_text").value = "";
                }
            }
        })
    } else {
        alert(langs_emptycomment);
        _gel("comment_entry_submit_button").disabled = !1;
        _gel("comment_entry_box_text").disabled = !1;
        _gel("comment_entry_submit_button").value = langs_postcomment
    }
}

function move_up(c_module) {
        var next = $("#user_" + c_module + ".inner-box").prev().attr('id');
        if (next == "user_profile" || next == "side_column_image") {
            var next = undefined;
        }
        if (next != undefined) {
        var side = $("#user_" + c_module + ".inner-box").parent().attr('id');
        var url = "/a/profile_new/move_module_updown?module="+ c_module +"&direction=up&side="+side+"&info="+next;
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
            } else {
                // BÅ‚Ä…d
                alert("Bad response from server.");
            }
        };

        xhr.onerror = function() {
            // BÅ‚Ä…d sieciowy
            alert("Bad response from server.");
        };

        xhr.send();
        $("#user_" + c_module + ".inner-box").css('opacity', '0.5');
        $("#" + next + ".inner-box").css('opacity', '0.5');
        var h1 = $("#user_" + c_module + ".inner-box").outerHeight(true);
        var h2 = $("#" + next + ".inner-box").outerHeight(true);
        $("#user_" + c_module + ".inner-box").animate({ bottom: '+='+h2 }, 1000);
        $("#" + next + ".inner-box").animate({ bottom: '-='+h1 }, 1000);
        $("#user_" + c_module + ".inner-box").promise().done(function(){
            $("#user_" + c_module + ".inner-box").animate({opacity: 1}, 100);
        });
        $("#" + next + ".inner-box").promise().done(function(){
            $("#" + next + ".inner-box").animate({opacity: 1}, 100);
            $("#user_" + c_module + ".inner-box").css('bottom', '0');
            $("#" + next + ".inner-box").css('bottom', '0');
            $("#user_" + c_module + ".inner-box").after($("#" + next + ".inner-box"));
            if ($("#user_" + c_module + ".inner-box").is(':first-child') == true || $("#user_" + c_module + ".inner-box").prev().attr('id') == "user_profile" || $("#user_" + c_module + ".inner-box").prev().attr('id') == "side_column_image") {
                $("#user_"+ c_module +"-up-arrow").addClass("disabled");
            }
            if ($("#user_" + c_module + ".inner-box").is(':last-child') == false) {
                $("#user_"+ c_module +"-down-arrow").attr('class', 'module-down-arrow');
            }
            if ($("#" + next).is(':last-child') == true) {
                $("#"+ next +"-down-arrow").attr('class', 'module-down-arrow disabled');
            }
            if ($("#" + next).is(':first-child') == false) {
                $("#"+ next +"-up-arrow").attr('class', 'module-up-arrow');
            }
        });
        }
    }

function move_down(c_module) {
        var prev = $("#user_" + c_module).next().attr('id');
        if (prev != undefined) {
        var side = $("#user_" + c_module + ".inner-box").parent().attr('id');
        var url = "/a/profile_new/move_module_updown?module="+ c_module +"&direction=down&side="+side+"&info="+prev;
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
            } else {
                // BÅ‚Ä…d
                alert("Bad response from server.");
            }
        };

        xhr.onerror = function() {
            // BÅ‚Ä…d sieciowy
            alert("Bad response from server.");
        };

        xhr.send();
        $("#user_" + c_module + ".inner-box").css('opacity', '0.5');
        $("#" + prev + ".inner-box").css('opacity', '0.5');
        var h1 = $("#user_" + c_module + ".inner-box").outerHeight(true);
        var h2 = $("#" + prev + ".inner-box").outerHeight(true);
        $("#user_" + c_module + ".inner-box").animate({ bottom: '-='+h2 }, 1000);
        $("#" + prev + ".inner-box").animate({ bottom: '+='+h1 }, 1000);
        $("#user_" + c_module + ".inner-box").promise().done(function(){
            $("#user_" + c_module + ".inner-box").animate({opacity: 1}, 100);
        });
        $("#" + prev + ".inner-box").promise().done(function(){
            $("#" + prev + ".inner-box").animate({opacity: 1}, 100);
            $("#user_" + c_module + ".inner-box").css('bottom', '0');
            $("#" + prev + ".inner-box").css('bottom', '0');
            $("#user_" + c_module + ".inner-box").before($("#" + prev + ".inner-box"));
            if ($("#user_" + c_module + ".inner-box").is(':last-child') == true) {
                $("#user_"+ c_module +"-down-arrow").attr('class', 'module-down-arrow disabled');
            }
            if ($("#user_" + c_module + ".inner-box").is(':first-child') == false) {
                $("#user_"+ c_module +"-up-arrow").attr('class', 'module-up-arrow');
            }
            if ($("#"+prev).is(':first-child') == true || $("#"+prev).prev().attr('id') == "user_profile" || $("#"+prev).prev().attr('id') == "side_column_image") {
                $("#"+prev+"-up-arrow").attr('class', 'module-up-arrow disabled');
            }
            if ($("#"+prev).is(':last-child') == false) {
                $("#"+prev+"-down-arrow").attr('class', 'module-down-arrow');
            }
        });
        }
    }

function move_left(c_module) {
        $("#main-channel-right").css('pointer-events', 'none');
        $("#user_" + c_module + ".inner-box").fadeTo( 500, 0 );
        var h1 = $("#user_" + c_module + ".inner-box").outerHeight(true);
        var h = $("#main-channel-content").height();
        $.when($("#user_" + c_module + ".inner-box").fadeTo( 0, 0 )).done(function() {
            $("#user_" + c_module + ".inner-box").nextAll().css('bottom', '-='+h1);
            $("#user_" + c_module + ".inner-box").nextAll().animate({ bottom: 0 }, 500);
            $("#user_" + c_module + ".inner-box").remove();
            $("#main-channel-right").css('pointer-events', 'all');
            $.ajax({
                    url: "/a/profile_new/move_module_leftright?module="+ c_module +"&direction=left&channel=" + profile_username,
                    success: function(html){
                        if(html){
                            if ($("#side_column_image").length > 0) {
                                $("#side_column_image").after(html);
                            }
                            else {
                                $("#user_profile").after(html);
                            }
                            var h2 = $("#user_" + c_module + ".inner-box").outerHeight(true);
                            $("#user_" + c_module + ".inner-box").nextAll().css('bottom', '+='+h2);
                            $("#user_" + c_module + ".inner-box").nextAll().animate({ bottom: 0 }, 500);
                            $("#main-channel-content").css('height', h);
                            var lh = $("#main-channel-left").outerHeight(true);
                            var rh = $("#main-channel-right").outerHeight(true);
                            if (lh > rh) {
                            $("#main-channel-content").animate({ height: lh }, 500);
                            }
                            else {
                            $("#main-channel-content").animate({ height: rh }, 500);
                            }
                            $("#user_" + c_module + ".inner-box").delay(500).animate({ opacity: 1 }, 500);
                        } else {
                            alert("Bad response from server.");
                        }
                    }
                });
        });
    }

function move_right(c_module) {
        $("#main-channel-right").css('pointer-events', 'none');
        $("#user_" + c_module + ".inner-box").fadeTo( 500, 0 );
        var h1 = $("#user_" + c_module + ".inner-box").outerHeight(true);
        var h = $("#main-channel-content").height();
        $.when($("#user_" + c_module + ".inner-box").fadeTo( 0, 0 )).done(function() {
            $("#user_" + c_module + ".inner-box").css("display", "none");
            $("#main-channel-content").css('height', h);
            var lh = $("#main-channel-left").outerHeight(true);
            var rh = $("#main-channel-right").outerHeight(true);
            $("#user_" + c_module + ".inner-box").nextAll().css('bottom', '-='+h1);
            $("#user_" + c_module + ".inner-box").nextAll().animate({ bottom: 0 }, 500);
            $("#user_" + c_module + ".inner-box").promise().done(function(){
                if (lh > rh) {
                    $("#main-channel-content").animate({ height: lh }, 500);
                }
                else {
                    $("#main-channel-content").animate({ height: rh }, 500);
                }
            });
            $("#user_" + c_module + ".inner-box").remove();
            $("#main-channel-right").css('pointer-events', 'all');
            $.ajax({
                    url: "/a/profile_new/move_module_leftright?module="+ c_module +"&direction=right&channel=" + profile_username,
                    success: function(html){
                        if(html){
                            $("#main-channel-right").prepend(html);
                            var h2 = $("#user_" + c_module + ".inner-box").outerHeight(true);
                            $("#user_" + c_module + ".inner-box").nextAll().css('bottom', '+='+h2);
                            $("#user_" + c_module + ".inner-box").nextAll().animate({ bottom: 0 }, 500);
                            $("#main-channel-content").css('height', h);
                            var lh = $("#main-channel-left").outerHeight(true);
                            var rh = $("#main-channel-right").outerHeight(true);
                            if (lh > rh) {
                            $("#main-channel-content").animate({ height: lh }, 500);
                            }
                            else {
                            $("#main-channel-content").animate({ height: rh }, 500);
                            }
                            $("#user_" + c_module + ".inner-box").delay(500).animate({ opacity: 1 }, 500);
                        } else {
                            alert("Bad response from server.");
                        }
                    }
                });
        });
    }
function selectView(element,username) {
    $(".view-button-selected").removeClass("view-button-selected");
    _gel(element + "view-icon").classList.add("view-button-selected");
    var info = document.getElementsByClassName("navbar-tab-selected")[0].id; 
    if (element === "grid") {
        _gel("playnav-player").style.display = "none";
        _gel("playnav-playview").style.display = "none";
        _gel("playnav-gridview").style.display = "block";
        _gel("playnav-grid-loading").style.display = "block";
    
    $.ajax({
                    url: "/a/profile_new/change_view?view="+ element +"&channel="+ username + "&info=" + info,
                    success: function(html){
                        if(html){
                            $("#playnav-grid-content").replaceWith(html);
                            _gel("playnav-grid-loading").style.display = "none";
                        } else {
                            alert("Bad response from server.");
                        }
                    }
                });
    }
    else if (element === "play") {
        _gel("playnav-player").style.display = "block";
        _gel("playnav-playview").style.display = "block";
        _gel("playnav-gridview").style.display = "none";
    }
}
function attach_video() {
    _gel("bulletin_video_link").style.display = "none";
    _gel("bulletin_video").style.display = "block";
}
function post_channel_bulletin() {
    var comment = _gel("bulletin_input").value;
    var url = _gel("bulletin_video_input").value;
    _gel("post_button_input").disabled = !0;
    _gel("bulletin_input").disabled = !0;
    _gel("post_button_input").value = langs_posting;
    if (comment.length > 0) {
        $.ajax({
            type: "POST",
            url: "/a/profile_new/post_bulletin",
            data: {
                video: url,
                bulletin_text: comment
            },
            success: function(output) {
                if (output.response == "success") {
                    changes_saved("recent_activity");
                }
                else if (output.response == "error") {
                    alert(langs_somethingwentwrong);
                    _gel("bulletin_input").disabled = !1;
                    _gel("post_button_input").value = langs_postbulletin;
                }
            }
        })
    } else {
        alert("Your bulletin can't be empty.");
        _gel("bulletin_input").disabled = !1;
        _gel("post_button_input").value = langs_postbulletin;
    }
}
function update_hidden_field(e) {
    if (_gel(e).checked) {
        _gel("edit_info_"+e).style.opacity = 1;
    }
    else {
        _gel("edit_info_"+e).style.opacity = 0.4;
    }
}
function add_or_remove_box(e) {
    if (e.checked) {
        _gel(e.value).style.display = "block";
    }
    else {
        _gel(e.value).style.display = "none";
    }
}
function save_featured_channels() {
    var title = _gel("fc_title").value;
    var content = _gel("fc").value;
    document.getElementsByClassName('user_hubber_links_save_cancel')[0].style.opacity = 0.4;
    document.getElementsByClassName('user_hubber_links_save_cancel')[0].style.pointerEvents = 'none';
    $.ajax({
        type: "POST",
        url: "/a/profile_new/save_featured_channels",
        data: {
            fc_title: title,
            fc: content
        },
        success: function(output) {
            if (output.response == "success") {
                changes_saved("hubber_links");
            }
            else if (output.response == "error") {
                alert(langs_somethingwentwrong);
                document.getElementsByClassName('user_hubber_links_save_cancel')[0].style.opacity = 1;
                document.getElementsByClassName('user_hubber_links_save_cancel')[0].style.pointerEvents = 'all';
            }
        }
    })
}  
function save_profile_info() {
    var e_name = _gel("first_name").checked;
    var e_channel_views = _gel("channel_views").checked;
    var e_video_views = _gel("video_views").checked;
    var e_videos_watched = _gel("videos_watched").checked;
    var e_age = _gel("age").checked;
    var e_last_login = _gel("last_login").checked;
    var e_subscribers = _gel("subscribers").checked;
    var e_website = _gel("website").checked;
    var e_description = _gel("description").checked;
    var e_about_me = _gel("about_me").checked;
    var e_hometown = _gel("hometown").checked;
    var e_country = _gel("country").checked;
    var e_occupation = _gel("occupation").checked;
    var e_companies = _gel("companies").checked;
    var e_schools = _gel("schools").checked;
    var e_hobbies = _gel("hobbies").checked;
    var e_movies = _gel("movies").checked;
    var e_music = _gel("music").checked;
    var e_books = _gel("books").checked;
    var d_name = _gel("profile_edit_first_name").value;
    var d_website = _gel("profile_edit_website").value;
    var d_description = _gel("profile_edit_description").value;
    var d_about = _gel("profile_edit_about_me").value;
    var d_hometown = _gel("profile_edit_hometown").value;
    var d_country = _gel("profile_edit_country").value;
    var d_occupation = _gel("profile_edit_occupation").value;
    var d_companies = _gel("profile_edit_companies").value;
    var d_schools = _gel("profile_edit_schools").value;
    var d_hobbies = _gel("profile_edit_hobbies").value;
    var d_movies = _gel("profile_edit_movies").value;
    var d_music = _gel("profile_edit_music").value;
    var d_books = _gel("profile_edit_books").value;  
    document.getElementsByClassName('user_profile_save_cancel')[0].style.opacity = 0.4;
    document.getElementsByClassName('user_profile_save_cancel')[0].style.pointerEvents = 'none';
    $.ajax({
        type: "POST",
        url: "/a/profile_new/save_profile_info",
        data: {
            i_name_chk: e_name,
            i_channelviews_chk: e_channel_views,
            i_videoviews_chk: e_video_views,
            i_videoswatched_chk: e_videos_watched,
            i_age_chk: e_age,
            i_last_login_chk: e_last_login,
            i_subscribers_chk: e_subscribers,
            i_website_chk: e_website,
            i_description_chk: e_description,
            i_about_chk: e_about_me,
            i_hometown_chk: e_hometown,
            i_country_chk: e_country,
            i_occupation_chk: e_occupation,
            i_companies_chk: e_companies,
            i_schools_chk: e_schools,
            i_hobbies_chk: e_hobbies,
            i_movies_chk: e_movies,
            i_music_chk: e_music,
            i_books_chk: e_books,
            i_name: d_name,
            i_website: d_website,
            i_desc: d_description,
            i_about: d_about,
            i_hometown: d_hometown,
            i_country: d_country,
            i_occupation: d_occupation,
            i_companies: d_companies,
            i_schools: d_schools,
            i_hobbies: d_hobbies,
            i_movies: d_movies,
            i_music: d_music,
            i_books: d_books
        },
        success: function(output) {
            if (output.response == "success") {
                changes_saved("profile");
            }
            else if (output.response == "error") {
                alert(langs_somethingwentwrong);
                document.getElementsByClassName('user_profile_save_cancel')[0].style.opacity = 1;
                document.getElementsByClassName('user_profile_save_cancel')[0].style.pointerEvents = 'all';
            }
        }
    })
}
function changes_saved(e) {
        if (_gel("user_"+e).parentElement.id == "main-channel-right") {
            var side = "r";
        }
        if (_gel("user_"+e).parentElement.id == "main-channel-left") {
            var side = "l";
        }   
        $.ajax({
                url: "/a/profile_new/changes_saved?module="+ e +"&side="+ side +"&channel=" + profile_username,
                success: function(html){
                    if(html){
                        $("#user_"+ e).replaceWith(html);
                        if ($("#user_"+ e +"_success").length < 1) {
                            $('#user_'+ e +'-messages').replaceWith('<div id="user_'+ e +'_success" style="display: block;width: 90%;margin: 0 auto;margin-top: 4px;height: 36px;line-height: 36px;text-align: center;background: #dfd;color: black;">' + langs_profilechangessaved + '</div>');
                        }
                        $("#user_"+ e +"_success").delay(6000).animate({ opacity: 0 }, 1000);
                        $("#user_"+ e +"_success").animate({ height: 0 }, 1000);
                    } else {
                        alert("Bad response from server.");
                    }
                }
            });
    }
function save_rows(e) {
    var select = _gel("rows_to_show_"+e).value;
    document.getElementsByClassName('user_'+ e +'_save_cancel')[0].style.opacity = 0.4;
    document.getElementsByClassName('user_'+ e +'_save_cancel')[0].style.pointerEvents = 'none';
    $.ajax({
        type: "POST",
        url: "/a/profile_new/save_rows",
        data: {
            rows: select,
            module: e
        },
        success: function(output) {
            if (output.response == "success") {
                changes_saved(e);
            }
            else if (output.response == "error") {
                alert(langs_somethingwentwrong);
                document.getElementsByClassName('user_'+ e +'_save_cancel')[0].style.opacity = 1;
                document.getElementsByClassName('user_'+ e +'_save_cancel')[0].style.pointerEvents = 'all';
            }
        }
    })
}
function showTooltip(e) {
    document.getElementsByClassName("yt-uix-tooltip-tip-content")[0].innerHTML = e.title;
    var rect = e.getBoundingClientRect();
    var width = e.offsetWidth / 2;
    var height = 6 + e.offsetHeight;
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
    if (e == 0) {
        var status = "unlike";
    }
    else {
        var status = "like";
    }
    var url = _gel('like_video_id').value;
    $.ajax({
                url: "/a/like.php?url="+ url +"&status=" + e,
                success: function(html){
                    if(html){
                    } else {
                        alert('Something went wrong!')
                    }
                }
            });
}

var theme_saved = false;
window.onload = function() {
    $("#edit_controls").css({ 'background-color': "#efefef" });
    if ($(".confirmBox").length > 0) {
        $(".confirmBox").delay(6000).animate({ opacity: 0 }, 1000);
        $(".confirmBox").animate({ height: 0, padding: 0, margin: 0 }, 1000);
    }
}
function channel_edit_tab(id) {
    if (id != "close" && $("#channel_tab_"+id).attr('class') != "channel_settings_tab channel_settings_tab_active") {
    var tabs = document.getElementsByClassName("channel_settings_tab");
    var boxes = document.getElementsByClassName("channel_tab_content");
    for(var i = 0; i < boxes.length; i++)
    {
        tabs[i].setAttribute("class", "channel_settings_tab");
        boxes[i].style.display = "none";
    }
    var tab = _gel("channel_tab_"+id);
    var box = _gel("tab_contents_"+id);
    var close = _gel("channel_edit_close");
    tab.classList.add('channel_settings_tab_active');
    box.style.display = "block";
    close.style.display = "block";
    }
    else {
        var tabs = document.getElementsByClassName("channel_settings_tab");
        var boxes = document.getElementsByClassName("channel_tab_content");
        var close = _gel("channel_edit_close");
        for(var i = 0; i < boxes.length; i++)
        {
            tabs[i].setAttribute("class", "channel_settings_tab");
            boxes[i].style.display = "none";
            close.style.display = "none";
        }
    }
}

function popup_color_grid(e) {
    if (_gel('popup_color_grid_'+e).style.display != "block") {
        for(var i=0;i<document.getElementsByClassName('popup_color_grid').length;i++){
            document.getElementsByClassName('popup_color_grid')[i].classList.remove("color-open");
            document.getElementsByClassName('popup_color_grid')[i].style.display = "none";
    }
        _gel('popup_color_grid_'+e).style.display = "block";
        _gel('popup_color_grid_'+e).classList.add('color-open');
    }
    else {
        _gel('popup_color_grid_'+e).style.display = "none";
        _gel('popup_color_grid_'+e).classList.remove('color-open');
    }
}
function addAlpha(color, opacity) {
    var _opacity = Math.round(Math.min(Math.max(opacity || 1, 0), 1) * 255);
    return color + _opacity.toString(16).toUpperCase();
}
function select_popup_color(e, a , y) {
    var sel = document.getElementsByClassName('theme_selected')[0].id;
    if (sel != "custom" && y != "no") {
        if (_gel('custom')) {
            document.getElementsByClassName('theme_selected')[0].classList.remove('theme_selected');
            _gel('custom').classList.add('theme_selected');
        }
        else {
            $(".theme_selected").clone().appendTo("#theme_container");
            document.getElementsByClassName('theme_selected')[0].classList.remove('theme_selected');
            document.getElementsByClassName('theme_selected')[0].id = "custom";
            $('.theme_selected div .theme_title').text("Custom");
        }
        _gel('theme_edit_name').value = "Custom";
        _gel('theme_display_name').innerHTML = "Custom";
    }

    if (a == undefined) {
        var element = document.getElementsByClassName("color-open")[0].id.slice(17);
        _gel(element+'-preview').style.backgroundColor = e;
        _gel(element).value = e;
    }
    else {
        var element = a;
    }

    if (element == "background_color") {
        var style = '#channel-body { background-color: '+e+' !important }';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
    }
    else if (element == "wrapper_color") {
        var opacity = _gel('wrapper_opacity').value;
        opacity = opacity / 100;
        if (opacity > 0) {
            var e = addAlpha(e.replace("#",""),opacity);
            var e = "#" + e
        }
        var style = '.outer-box {background-color: '+e+' !important;} .outer-box-bg-color {background-color: '+e+' !important;} .outer-box-bg-as-border {border-color: '+e+' !important;} .playnav-item .selector, .outer-box-bg-color, .outer-box {background-color: '+e+' !important;} #playnav-chevron {border-left-color: '+e+' !important;} #masthead-container { border-bottom: 3px solid '+e+' !important }';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
    }
    else if (element == "wrapper_text_color") {
        var style = '.outer-box {color: '+e+' !important;} .outer-box-bg-color {color: '+e+' !important;} .outer-box-color {color: '+e+' !important;} .outer-box-color-as-border-color {border-color: '+e+' !important;} .panel-tab-selected .playnav-bottom-link > a {color: '+e+' !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
    }
    else if (element == "wrapper_link_color") {
        var style = '.playnav-bottom-link > a {color: '+e+' !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
    }
    else if (element == "box_background_color") {
        var opacity = _gel('box_opacity').value;
        opacity = opacity / 100;
        if (opacity > 0) {
            var e_2 = addAlpha(e.replace("#",""),opacity);
            var e_2 = "#" + e_2;
            var style = '.inner-box {background-color: '+e_2+' !important;} .inner-box-colors {background-color: '+e_2+' !important;} .inner-box-bg-color {background-color: '+e_2+' !important;} .panel-tab-selected .panel-tab-indicator-arrow {border-bottom-color: '+e_2+' !important;} #playnav-video-panel-loading {background-color: '+e_2+' !important;} a.view-button-selected .a, .view-button:hover .a { background-color: '+e+' !important; } .view-button .tri { border-left-color: '+e+' !important; } a.view-button-selected .tri { border-top-color: '+e+' !important; border-bottom-color: '+e+' !important; } a.view-button-selected .tri, .view-button:hover .tri {border-top-color: '+e+' !important;border-bottom-color: '+e+' !important;background-color: '+e+' !important;} #playnav-navbar a.navbar-tab-selected, #playnav-navbar a.navbar-tab:hover {color: '+e+' !important;} #playnav-video-panel-loading {background-color: '+e+' !important;}';
        }
        else {
            var style = '.inner-box {background-color: '+e+' !important;} .inner-box-colors {background-color: '+e+' !important;} .inner-box-bg-color {background-color: '+e+' !important;} .panel-tab-selected .panel-tab-indicator-arrow {border-bottom-color: '+e+' !important;} #playnav-video-panel-loading {background-color: '+e+' !important;} a.view-button-selected .a, .view-button:hover .a { background-color: '+e+' !important; } .view-button .tri { border-left-color: '+e+' !important; } a.view-button-selected .tri { border-top-color: '+e+' !important; border-bottom-color: '+e+' !important; } a.view-button-selected .tri, .view-button:hover .tri {border-top-color: '+e+' !important;border-bottom-color: '+e+' !important;background-color: '+e+' !important;} #playnav-navbar a.navbar-tab-selected, #playnav-navbar a.navbar-tab:hover {color: '+e+' !important;} #playnav-video-panel-loading {background-color: '+e+' !important;}';
        }
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
    }
    else if (element == "title_text_color") {
        var style = '.title-text-color {color: '+e+' !important;} a.title-text-color, .title-text-color a {color: '+e+' !important;} a.view-button-selected, a.view-button:hover, #playnav-navbar a.navbar-tab-selected, #playnav-navbar a.navbar-tab:hover { background-color: '+e+' !important; } a.view-button-selected .tri, a.view-button:hover .tri {border-left-color: '+e+' !important; ?>!important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
    }
    else if (element == "link_color") {
        var style = '.outer-box .inner-box-bg-color a {color: '+e+';}.outer-box .inner-box-link-color {color: '+e+' !important;}.outer-box a {color: '+e+';}.view-button .a {background-color: '+e+' ;}.view-button .tri {background-color: '+e+' ;}.view-button .tri {border-top-color: '+e+';border-bottom-color: '+e+';}.view-button .a {background-color: '+e+' !important;}.link-as-border-color {border-color: '+e+' !important;}.channel-cmd {border-bottom-color: '+e+' !important;}.outer-box .inner-box a, .outer-box .inner-box-colors a {color: '+e+';}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
    }
    else if (element == "body_text_color") {
        var style = 'a.inner-box-color-as-link, .inner-box-colors .playnav-show .show-facets .show-mini-description, .inner-box-color, .inner-box {color: '+e+' !important;} .inner-box-colors {color: '+e+' !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
    }
    _gel('popup_color_grid_'+element).style.display = "none";
    _gel('popup_color_grid_'+element).classList.remove('color-open');
}
function change_channel_font(y) {
    var sel = document.getElementsByClassName('theme_selected')[0].id;
    if (sel != "custom" && y != "no") {
        if (_gel('custom')) {
            document.getElementsByClassName('theme_selected')[0].classList.remove('theme_selected');
            _gel('custom').classList.add('theme_selected');
        }
        else {
            $(".theme_selected").clone().appendTo("#theme_container");
            document.getElementsByClassName('theme_selected')[0].classList.remove('theme_selected');
            document.getElementsByClassName('theme_selected')[0].id = "custom";
            $('.theme_selected div .theme_title').text("Custom");
        }
        _gel('theme_edit_name').value = "Custom";
        _gel('theme_display_name').innerHTML = "Custom";
    }
    var font = _gel('font').value;
    var style = 'body, #channel-body {font-family: '+font+' !important;} .outer-box .inner-box a, .outer-box .inner-box-colors a {font-family: '+font+' !important;}';
    var styleSheet = document.createElement("style");
    styleSheet.innerText = style;
    document.head.appendChild(styleSheet);
}
function edit_wrapper_opacity(y) {
    var sel = document.getElementsByClassName('theme_selected')[0].id;
    if (sel != "custom" && y != "no") {
        if (_gel('custom')) {
            document.getElementsByClassName('theme_selected')[0].classList.remove('theme_selected');
            _gel('custom').classList.add('theme_selected');
        }
        else {
            $(".theme_selected").clone().appendTo("#theme_container");
            document.getElementsByClassName('theme_selected')[0].classList.remove('theme_selected');
            document.getElementsByClassName('theme_selected')[0].id = "custom";
            $('.theme_selected div .theme_title').text("Custom");
        }
        _gel('theme_edit_name').value = "Custom";
        _gel('theme_display_name').innerHTML = "Custom";
    }
    var opacity = _gel('wrapper_opacity').value;
    opacity = opacity / 100;
    var color = $('.outer-box').css('backgroundColor');
    var alpha = parseFloat(color.split(',')[3]);
    if (isNaN(alpha)) {
        var final = color.replace(')', ', '+ opacity +')');
        final = final.replace('rgb', 'rgba');
    }
    else {
    var a = color.slice(5).split(',');
    var final ='rgba('+a[0]+','+parseInt(a[1])+','+parseInt(a[2])+','+opacity+')';
    }
    var style = '.outer-box {background-color: '+final+' !important;} .outer-box-bg-color {background-color: '+final+' !important;} .outer-box-bg-as-border {border-color: '+final+' !important;} .playnav-item .selector, .outer-box-bg-color, .outer-box {background-color: '+final+' !important;} #playnav-chevron {border-left-color: '+final+' !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
    var sel = document.getElementsByClassName('theme_selected')[0].id;
    if (sel != "custom") {
        if (_gel('custom')) {
            document.getElementsByClassName('theme_selected')[0].classList.remove('theme_selected');
            _gel('custom').classList.add('theme_selected');
        }
        else {
            $(".theme_selected").clone().appendTo("#theme_container");
            document.getElementsByClassName('theme_selected')[0].classList.remove('theme_selected');
            document.getElementsByClassName('theme_selected')[0].id = "custom";
            $('.theme_selected div .theme_title').text("Custom");
        }
        _gel('theme_edit_name').value = "Custom";
        _gel('theme_display_name').innerHTML = "Custom";
    }
}
function edit_box_opacity(y) {
    var sel = document.getElementsByClassName('theme_selected')[0].id;
    if (sel != "custom" && y != "no") {
        if (_gel('custom')) {
            document.getElementsByClassName('theme_selected')[0].classList.remove('theme_selected');
            _gel('custom').classList.add('theme_selected');
        }
        else {
            $(".theme_selected").clone().appendTo("#theme_container");
            document.getElementsByClassName('theme_selected')[0].classList.remove('theme_selected');
            document.getElementsByClassName('theme_selected')[0].id = "custom";
            $('.theme_selected div .theme_title').text("Custom");
        }
        _gel('theme_edit_name').value = "Custom";
        _gel('theme_display_name').innerHTML = "Custom";
    }
    var opacity = _gel('box_opacity').value;
    opacity = opacity / 100;
    var color = $('.inner-box').css('backgroundColor');
    var alpha = parseFloat(color.split(',')[3]);
    if (isNaN(alpha)) {
        var final = color.replace(')', ', '+ opacity +')');
        final = final.replace('rgb', 'rgba');
    }
    else {
    var a = color.slice(5).split(',');
    var final ='rgba('+a[0]+','+parseInt(a[1])+','+parseInt(a[2])+','+opacity+')';
    }
    var style = '.inner-box {background-color: '+final+' !important;} .inner-box-colors {background-color: '+final+' !important;} .inner-box-bg-color {background-color: '+final+' !important;} .panel-tab-selected .panel-tab-indicator-arrow {border-bottom-color: '+final+' !important;} #playnav-video-panel-loading {background-color: '+final+' !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
    var sel = document.getElementsByClassName('theme_selected')[0].id;
    if (sel != "custom") {
        if (_gel('custom')) {
            document.getElementsByClassName('theme_selected')[0].classList.remove('theme_selected');
            _gel('custom').classList.add('theme_selected');
        }
        else {
            $(".theme_selected").clone().appendTo("#theme_container");
            document.getElementsByClassName('theme_selected')[0].classList.remove('theme_selected');
            document.getElementsByClassName('theme_selected')[0].id = "custom";
            $('.theme_selected div .theme_title').text("Custom");
        }
        _gel('theme_edit_name').value = "Custom";
        _gel('theme_display_name').innerHTML = "Custom";
    }
}
function color_picker_keypress(e) {
    if (e.value.length == 7) {
        _gel(e.id+'-preview').style.backgroundColor = e.value;
        select_popup_color(e.value,e.id);
    }
}
function repeat_background() {
    var checked = _gel("background_repeat_check").checked;
    var sel = document.getElementsByClassName('theme_selected')[0].id;
    if (sel != "custom") {
        if (_gel('custom')) {
            document.getElementsByClassName('theme_selected')[0].classList.remove('theme_selected');
            _gel('custom').classList.add('theme_selected');
        }
        else {
            $(".theme_selected").clone().appendTo("#theme_container");
            document.getElementsByClassName('theme_selected')[0].classList.remove('theme_selected');
            document.getElementsByClassName('theme_selected')[0].id = "custom";
            $('.theme_selected div .theme_title').text("Custom");
        }
        _gel('theme_edit_name').value = "Custom";
        _gel('theme_display_name').innerHTML = "Custom";
    }
    if (checked == true) {
        var style = 'body, #channel-body {background-repeat: repeat !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
    }
    else {
        var style = 'body, #channel-body {background-repeat: no-repeat !important;}';
        var styleSheet = document.createElement("style");
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
    }
}
function save_themes() {
    var theme = _gel('theme_edit_name').value;
    var font = _gel('font').value;
    var background_color = _gel('background_color').value;
    var wrapper_color = _gel('wrapper_color').value;
    var wrapper_text_color = _gel('wrapper_text_color').value;
    var wrapper_link_color = _gel('wrapper_link_color').value;
    var wrapper_opacity = _gel('wrapper_opacity').value / 100;
    var repeat_background = _gel('background_repeat_check').checked ? 1 : 0;
    var box_background_color = _gel('box_background_color').value;
    var title_text_color = _gel('title_text_color').value;
    var link_color = _gel('link_color').value;
    var body_text_color = _gel('body_text_color').value;
    var box_opacity = _gel('box_opacity').value / 100;
    _gel('save_theme_overlay').style.visibility = "visible";
    $.ajax({
            type: "POST",
            url: "/a/profile_new/save_theme",
            data: {
                theme: theme,
                font: font,
                background_color: background_color,
                wrapper_color: wrapper_color,
                wrapper_text_color: wrapper_text_color,
                wrapper_link_color: wrapper_link_color,
                wrapper_opacity: wrapper_opacity,
                repeat_background: repeat_background,
                box_background_color: box_background_color,
                title_text_color: title_text_color,
                link_color: link_color,
                body_text_color: body_text_color,
                box_opacity: box_opacity
            },
            success: function(output) {
                if (output.response == "success") {
                    _gel('save_theme_overlay').style.visibility = "hidden";
                    theme_saved = true;
                    channel_edit_tab('close');
                    theme_changes_saved();
                }
                else if (output.response == "error") {
                    alert(langs_somethingwentwrong);
                }
            }
        });
}
function theme_changes_saved() {
            $.ajax({
                    url: "/a/profile_new/reload_themes?channel=" + profile_username,
                    success: function(html){
                        if(html){
                            $("#tab_contents_colors").replaceWith(html);
                        } else {
                            alert("Bad response from server.");
                        }
                    }
                });
    }
function deleteBackgroundImage() {
    var url = "/a/profile_new/delete_background_image";
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                var style = 'body, #channel-body {background-image: none;}';
                var styleSheet = document.createElement("style");
                styleSheet.innerText = style;
                document.head.appendChild(styleSheet);
                $('#delete_background_image').replaceWith('<input name="body_background_image_path" id="body_background_image_path" type="file" onchange="uploadBackgroundImage();" style="font-size: 9px;">')
            } else {
                showErrorMessage();
            }
        };

        xhr.onerror = function() {
            showErrorMessage();
        };

        xhr.send();
}
function randomIntFromInterval(min, max) { // min and max included 
  return Math.floor(Math.random() * (max - min + 1) + min)
}
function uploadBackgroundImage() {
    var property = _gel('body_background_image_path').files[0];
    var image_name = property.name;
    var image_extension = image_name.split('.').pop().toLowerCase();
    if (jQuery.inArray(image_extension, ['jpg', 'jpeg', 'pjpeg', 'png', 'bmp']) == -1) {
        $('#msg').html('Invalid image file!');
        return false;
    }
    var formData = new FormData();
    formData.append("file", property);
    $.ajax({
            type:'POST',
            url: '/a/profile_new/upload_background_image',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                var style = 'body, #channel-body {background-image: url(/u/bck/' + profile_username + '.jpg?'+randomIntFromInterval(1000, 10000000)+');}';
                var styleSheet = document.createElement("style");
                styleSheet.innerText = style;
                document.head.appendChild(styleSheet);
                $('#body_background_image_path').replaceWith('<a href="#" id="delete_background_image" onclick="deleteBackgroundImage();return false;">Delete</a>')
                console.log("success");
                console.log(data);
            },
            error: function(data){
                alert(langs_somethingwentwrong);
            }
        });
}
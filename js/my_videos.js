
function showNewPlaylistDialog() {
    document.getElementById('vm-dialog-new-playlist').classList.remove('hid');
}
function closeNewDropdown() {
    document.getElementById('vm-new-playlist-title-field').value = "";
    document.getElementById('vm-new-playlist-desc-field').value = "";
    document.getElementById('vm-new-playlist-tags-field').value = "";
    document.getElementById('vm-dialog-new-playlist').classList.add('hid');
}
function createPlaylist() {
    var title = document.getElementById('vm-new-playlist-title-field').value;
    var desc = document.getElementById('vm-new-playlist-desc-field').value;
    var tags = document.getElementById('vm-new-playlist-tags-field').value;
    $.ajax({
        type: "POST",
        url: "/a/new_playlist",
        data: {
            pl_title: title,
            pl_desc: desc,
            pl_tags: tags
        },
        success: function(output) {
            if (output.response == "success") {
                location.reload();
            }
            else {
                alert("Something went wrong!");
            }
        }
    })
}
function checkAll(e) {
    var checkboxes = document.getElementsByClassName("video-checkbox");
    for (i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = e.checked;
    }
    if (e.checked) { 
        document.getElementById('vm-playlist-copy-to').disabled = false;
        if (document.getElementById('vm-playlist-delete-videos')) {
            document.getElementById('vm-playlist-delete-videos').disabled = false;
        }
        if (document.getElementById('vm-playlist-remove-videos')) {
            document.getElementById('vm-playlist-remove-videos').disabled = false;
        }
    }
    else { 
        document.getElementById('vm-playlist-copy-to').disabled = true;
        if (document.getElementById('vm-playlist-delete-videos')) {
            document.getElementById('vm-playlist-delete-videos').disabled = true;
        }
        if (document.getElementById('vm-playlist-remove-videos')) {
            document.getElementById('vm-playlist-remove-videos').disabled = true;
        }
    }
}
function checkVideo(e) {
    var checkboxes = document.getElementsByClassName("video-checkbox");
    var length_c = 0;
    for (i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) { length_c++; }
    }
    if (length_c > 0) {
        document.getElementById('vm-playlist-copy-to').disabled = false;
        if (document.getElementById('vm-playlist-delete-videos')) {
            document.getElementById('vm-playlist-delete-videos').disabled = false;
        }
        if (document.getElementById('vm-playlist-remove-videos')) {
            document.getElementById('vm-playlist-remove-videos').disabled = false;
        }
        if (length_c == checkboxes.length) {
            document.getElementById('vm-video-select-all').checked = true;
        }
        else {
            document.getElementById('vm-video-select-all').checked = false;
        }
    }
    else { 
        document.getElementById('vm-playlist-copy-to').disabled = true;
        if (document.getElementById('vm-playlist-delete-videos')) {
            document.getElementById('vm-playlist-delete-videos').disabled = true;
        }
        if (document.getElementById('vm-playlist-remove-videos')) {
            document.getElementById('vm-playlist-remove-videos').disabled = true;
        }
        document.getElementById('vm-video-select-all').checked = false;
    }
}
function openAddTo() {
    document.getElementById('vm-videos-copyto-dialog').classList.toggle('hid');
}
function addVideos() {
    var videos = [];
    var playlists = [];
    var checkboxes = document.getElementsByClassName("video-checkbox");
    var checkboxes_pl = document.getElementsByClassName("vm-playlist-search-template-checkbox");
    for (i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) { videos.push(checkboxes[i].value) }
    }
    for (i = 0; i < checkboxes_pl.length; i++) {
        if (checkboxes_pl[i].checked) { playlists.push(checkboxes_pl[i].value) }
    }
    if (videos.length > 0 && playlists.length > 0) {
        $.ajax({
            type: "POST",
            url: "/a/add_videos_to",
            data: {
                vid: videos.toString(),
                pl: playlists.toString()
            },
            success: function(output) {
                if (output.response == "success") {
                    document.getElementById('success-box').classList.remove('hid');
                }
                else if (output.response == "login") {
                    window.location.href = "/login";
                }
                else {
                    alert("Something went wrong!");
                }
            }
        })
    }
}
function hideMsg(e) {
    e.parentElement.classList.add('hid');
}
function dropdown2(e) {
    if (e.querySelector('.yt-uix-button-menu').classList.contains("hid") && document.activeElement == e) {
        e.querySelector('.yt-uix-button-menu').classList.remove("hid");
        e.classList.add('yt-uix-button-active');
        var rect = e.getBoundingClientRect();
        var width = (document.body.clientWidth - 960) / 2;
        var height = document.getElementById('masthead-container').offsetHeight;
        e.querySelector('.yt-uix-button-menu').style.left = rect.left - width + 5 + "px";
        if (!document.getElementById("default-language-box")) {
            e.querySelector('.yt-uix-button-menu').style.top = rect.top + scrollY - height + 7 + "px";
        }
        else {
            var eh = document.getElementById('default-language-box').offsetHeight;
            e.querySelector('.yt-uix-button-menu').style.top = rect.top + scrollY - height - eh - 7 + "px";
        }
    }
    else {
        e.classList.remove('yt-uix-button-active');
        e.querySelector('.yt-uix-button-menu').classList.add("hid");
    }
}
function deleteMyVideos() {
    var videos = [];
    var checkboxes = document.getElementsByClassName("video-checkbox");
    for (i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) { videos.push(checkboxes[i].value) }
    }
    if (videos.length > 0 && confirm(confirm_msg)) {
        $.ajax({
            type: "POST",
            url: "/a/delete_my_videos",
            data: {
                vid: videos.toString()
            },
            success: function(output) {
                if (output.response == "success") {
                    location.reload();
                }
                else {
                    alert("Something went wrong!");
                }
            }
        })
    }
}
function openPosition(url,e) {
    document.getElementById('vm-videos-reorder-dialog').style.display = "block";
    document.getElementById('vm-reorder-video-id').value = url;
    document.getElementById('vm-videos-move-new-index').value = document.getElementById('vm-pos-id-'+url).innerHTML;
    var rect = e.getBoundingClientRect();
    var width = (document.body.clientWidth - 960) / 2;
    var height = document.getElementById('masthead-container').offsetHeight;
    document.getElementById('vm-videos-reorder-dialog').style.left = rect.left - width + 5 + "px";
    document.getElementById('vm-videos-reorder-dialog').style.top = rect.top + scrollY - height - 10 + "px";
}
function savePosition() {
    var playlist = document.getElementById('vm-reorder-playlist-id').value;
    var video = document.getElementById('vm-reorder-video-id').value;
    var position = document.getElementById('vm-videos-move-new-index').value;
    $.ajax({
        type: "POST",
        url: "/a/reorder_videos",
        data: {
            vid: video,
            pl: playlist,
            pos: position
        },
        success: function(output) {
            if (output.response == "success") {
                location.reload();
            }
            else {
                alert("Something went wrong!");
            }
        }
    })
}
function removeVideos(playlist) {
    var videos = [];
    var playlist = document.getElementById('vm-reorder-playlist-id').value;
    var checkboxes = document.getElementsByClassName("video-checkbox");
    for (i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) { videos.push(checkboxes[i].value) }
    }
    if (videos.length > 0 && confirm("Are you sure you want to remove the selected videos?")) {
        $.ajax({
            type: "POST",
            url: "/a/remove_videos",
            data: {
                vid: videos.toString(),
                pl: playlist
            },
            success: function(output) {
                if (output.response == "success") {
                    for (j = 0; j < videos.length; j++) {
                        for (k = 0; k < document.getElementsByClassName('vm-video-position').length; k++) {
                            if (document.getElementsByClassName('vm-video-position')[k].innerHTML > document.getElementById('vm-pos-id-'+videos[j]).innerHTML) {
                                document.getElementsByClassName('vm-video-position')[k].innerHTML--;
                            }
                        }
                        document.getElementById('vm-video-' + videos[j]).outerHTML = "";
                    }
                }
                else {
                    alert("Something went wrong!");
                }
            }
        })
    }
}
function removeVideosFav() {
    var videos = [];
    var checkboxes = document.getElementsByClassName("video-checkbox");
    for (i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) { videos.push(checkboxes[i].value) }
    }
    if (videos.length > 0 && confirm("Are you sure you want to remove the selected videos?")) {
        $.ajax({
            type: "POST",
            url: "/a/remove_videos_favorites",
            data: {
                vid: videos.toString()
            },
            success: function(output) {
                if (output.response == "success") {
                    for (j = 0; j < videos.length; j++) {
                        for (k = 0; k < document.getElementsByClassName('vm-video-position').length; k++) {
                            if (document.getElementsByClassName('vm-video-position')[k].innerHTML > document.getElementById('vm-pos-id-'+videos[j]).innerHTML) {
                                document.getElementsByClassName('vm-video-position')[k].innerHTML--;
                            }
                        }
                        document.getElementById('vm-video-' + videos[j]).outerHTML = "";
                    }
                }
                else {
                    alert("Something went wrong!");
                }
            }
        })
    }
}
function openPanel(e) {
    var sh = document.getElementById('vm-playlist-share');
    var ed = document.getElementById('vm-playlist-edit');
    var de = document.getElementById('vm-playlist-delete');
    if (sh != e) { sh.classList.remove('tab-selected');
                    document.getElementById(sh.id + '-panel').classList.add('vm-panel-hidden');
                    document.getElementById(sh.id + '-panel').classList.remove('vm-panel-shown'); }
    if (ed != e) { ed.classList.remove('tab-selected');
                    document.getElementById(ed.id + '-panel').classList.add('vm-panel-hidden');
                    document.getElementById(ed.id + '-panel').classList.remove('vm-panel-shown'); }
    if (de != e) { de.classList.remove('tab-selected');
                    document.getElementById(de.id + '-panel').classList.add('vm-panel-hidden');
                    document.getElementById(de.id + '-panel').classList.remove('vm-panel-shown'); }
    e.classList.toggle('tab-selected');
    document.getElementById(e.id + '-panel').classList.toggle('vm-panel-hidden');
    document.getElementById(e.id + '-panel').classList.toggle('vm-panel-shown');
}
function updatePlaylist() {
    var title = document.getElementById("vm-playlist-details-name").value;
    var desc = document.getElementById("vm-playlist-details-description").value;
    var tags = document.getElementById("vm-playlist-details-tags").value;
    var url = document.getElementById('vm-reorder-playlist-id').value;
    
    if (title.length < 1) {
        alert('Playlist title is empty!');
        return false;
    }

    if (title.length > 100) {
        alert('Playlist title is too long!');
        return false;
    }

    if (desc.length > 500) {
        alert('Playlist description is too long!');
        return false;
    }

    if (tags.length > 256) {
        alert('Playlist tags are too long!');
        return false;
    }

    $.ajax({
            type: "POST",
            url: "/a/update_playlist",
            data: {
                ti: title,
                de: desc,
                ta: tags,
                id: url
            },
            success: function(output) {
                if (output.response == "success") {
                    location.reload();
                }
                else {
                    alert("Something went wrong!");
                }
            }
        })
}
function deletePlaylist() {
    var url = document.getElementById('vm-reorder-playlist-id').value;
    $.ajax({
            type: "POST",
            url: "/a/delete_playlist",
            data: {
                id: url
            },
            success: function(output) {
                if (output.response == "success") {
                    window.location.href = "/my_videos";
                }
                else {
                    alert("Something went wrong!");
                }
            }
        })
}
function openAddVideos() {
    document.getElementById('vm-playlist-addvideos-body').classList.toggle("hid");
}
function addVideos2() {
    var videos = [];
    var playlists = document.getElementById('vm-reorder-playlist-id').value;
    var checkboxes = document.getElementsByClassName("vm-playlist-add-to-checkbox");
    for (i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) { videos.push(checkboxes[i].value) }
    }
    if (videos.length > 0) {
        $.ajax({
            type: "POST",
            url: "/a/add_videos_to",
            data: {
                vid: videos.toString(),
                pl: playlists.toString()
            },
            success: function(output) {
                if (output.response == "success") {
                    document.getElementById('success-box').classList.remove('hid');
                }
                else if (output.response == "login") {
                    window.location.href = "/login";
                }
                else {
                    alert("Something went wrong!");
                }
            }
        })
    }
}
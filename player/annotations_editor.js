if (window.XMLHttpRequest) {
   xhttp = new XMLHttpRequest();
} else {    // IE 5/6
   xhttp = new ActiveXObject("Microsoft.XMLHTTP");
}

xhttp.overrideMimeType('text/xml');

xhttp.open("GET", "/u/ann/"+ video_url +".xml?" + Math.round(Math.random() * 1000000000), false);
xhttp.send(null);
xmlDoc = xhttp.responseXML;
var annotation = xmlDoc.getElementsByTagName("annotation");

var modifications = false;

function myConfirmation() {
   if (modifications == true) {
      return 'Are you sure you want to quit?';
   }
}

window.onbeforeunload = myConfirmation;

function toSeconds(e) {
   return (e.substring(0,1) * 3600) + (e.substring(2,4) * 60) + parseInt(e.substring(5,7)) + (e.substring(8) / 10);
}

function loadMenu() {
   if (annotation) {
      document.getElementById('annotationseditor-loading').style.display = "none";
      for (i = 0; i < annotation.length; i++) {

      }
      for (i = 0; i < annotation.length; i++) {
         var id = annotation[i].id;
         if (annotation[i].id == id) {
            var contents = annotation[i].getElementsByTagName('TEXT')[0].innerHTML;
         }
         if (annotation[i].getAttribute("style") != "speech" && annotation[i].getAttribute("type") != "highlight") {
            var from = annotation[i].getElementsByTagName('rectRegion')[0].getAttribute('t');
            var to = annotation[i].getElementsByTagName('rectRegion')[1].getAttribute('t');
            var from_og = from;
            var to_og = to;
            var img_id = "note";
            var fs = parseInt(annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * 360 / 100);
            var extra = "";
         }
         else if (annotation[i].getAttribute("type") == "highlight") {
            var from = annotation[i].getElementsByTagName('rectRegion')[0].getAttribute('t');
            var to = annotation[i].getElementsByTagName('rectRegion')[1].getAttribute('t');
            var from_og = from;
            var to_og = to;
            var img_id = "highlight";
            var fs = parseInt(annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * 360 / 100);
            var extra = "";
         }
         else {
            var from = annotation[i].getElementsByTagName('anchoredRegion')[0].getAttribute('t');
            var to = annotation[i].getElementsByTagName('anchoredRegion')[1].getAttribute('t');
            var from_og = from;
            var to_og = to;
            var img_id = "speech";
            var fs = parseInt(annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * 360 / 100);
            var extra = '';
         }
         if (from != "never") {
            from = (from.substring(0,1) * 3600) + (from.substring(2,4) * 60) + parseInt(from.substring(5,7)) + (from.substring(8) / 10);
            from == 0 ? from = 0 : from = from;
         }
         else {
            from = 0;
         }
         if (to != "never") {
            to = (to.substring(0,1) * 3600) + (to.substring(2,4) * 60) + parseInt(to.substring(5,7)) + (to.substring(8) / 10);
         } else {
            to = Infinity;
         }
         var a_class = "";
         if (annotation[i].getElementsByTagName('url')[0]) {
            a_class = ' link';
         }
         var div = '<div class="menu-annotation'+a_class+'" onclick="openMenuAnn(this);" id="'+ id +'-menu"><button class="ann-icon" id="' + img_id + '"></button><a style="width: 236px; float: left;" onclick="event.stopPropagation();" href="#t='+ Math.round(from) +'">'+ contents.replace(/<br\s?\/?>/g,"\n") +'</a><button class="del-icon" onclick="removeAnnotation(this)"></button><div style="clear:both"></div><div class="timestamps"><button id="link" onclick="addLink(this);"></button><img class="timestamp-icon" id="icon-1" src="/img/pixel.gif"><input type="text" onfocusin="focus_time(this)" onfocusout="unfocus_time(this)" onclick="event.stopPropagation();" id="from" value="' + from_og +'"><img class="timestamp-icon" id="icon-2" src="/img/pixel.gif"><input type="text" id="to" onclick="event.stopPropagation();" onfocusin="focus_time(this)" onfocusout="unfocus_time(this)" value = "' + to_og + '"><img class="timestamp-icon" id="icon-3" src="/img/pixel.gif"></div><div class="menu-expand" id="menu-expand-' + id + '"><div class="expand-buttons"><img class="fontSize-icon" src="/img/pixel.gif" alt=""> <button class="colorSel yt-uix-button" onclick="changeColor(this);"> <img class="colorSelIcon" src="/img/pixel.gif" alt=""><img class="yt-uix-button-arrow" src="/img/pixel.gif" alt=""></button><button class="linkSel yt-uix-button" onclick="addLink(this);"> <img class="linkSelIcon" src="/img/pixel.gif" alt=""><img class="yt-uix-button-arrow" src="/img/pixel.gif" alt=""></button>' + extra + '</div></div></div>';
         document.getElementById('annotationseditor-container-inside-items').innerHTML += div;
      }
   }
}

window.onload = function() {
   if (annotation) {
      document.getElementById('annotationseditor-loading').style.display = "block";
      loadMenu();
   }
}

function openMenuAnn(e) {
   document.getElementById("menu-expand-" + e.id.replace("-menu","")).classList.toggle("expanded");
   var selector = document.getElementsByClassName('color-selector')[0];
   selector.classList.add('hid');
}

function addLink(e) {
   event.stopPropagation();
   document.getElementById("add-link-screen").classList.remove("hid");
   if (!e.parentElement.parentElement.id.includes("menu-expand-")) {
      document.getElementsByClassName("add-link-box")[0].id = e.parentElement.parentElement.id.replace("-menu","") + "_link";
      document.getElementsByClassName("add-link-value")[0].id = e.parentElement.parentElement.id.replace("-menu","") + "_link_input";
   }
   else {
      document.getElementsByClassName("add-link-box")[0].id = e.parentElement.parentElement.id.replace("menu-expand-","") + "_link";
      document.getElementsByClassName("add-link-value")[0].id = e.parentElement.parentElement.id.replace("menu-expand-","") + "_link_input";
   }
   for (i = 0; i < annotation.length; i++) {
      if (annotation[i].id == document.getElementsByClassName("add-link-box")[0].id.replace("_link","")) {
         if (annotation[i].getElementsByTagName('url')[0]) {
            var url = annotation[i].getElementsByTagName('url')[0].getAttribute("value");
            if (url.includes("/watch?v=")) {
               url = "https://" + window.location.hostname + url;
               document.getElementsByClassName('add-link-value')[0].style.display = "block";
               document.getElementsByClassName("link-selection")[0].id = "video";
               document.getElementsByClassName("link-selection")[0].innerHTML = document.getElementById("video-sel").innerHTML;
            }
            if (url.includes("/view_playlist?id=")) {
               url = "https://" + window.location.hostname + url;
               document.getElementsByClassName('add-link-value')[0].style.display = "block";
               document.getElementsByClassName("link-selection")[0].id = "playlist";
               document.getElementsByClassName("link-selection")[0].innerHTML = document.getElementById("playlist-sel").innerHTML;
            }
            if (url.includes("/subscription_center?add_user=")) {
               url = url.replace("/subscription_center?add_user=","");
               document.getElementsByClassName('add-link-value')[0].style.display = "block";
               document.getElementsByClassName("link-selection")[0].id = "channel";
               document.getElementsByClassName("link-selection")[0].innerHTML = document.getElementById("channel-sel").innerHTML;
            }
            if (url.includes("/send_message?to=")) {
               url = "https://" + window.location.hostname + url;
               document.getElementsByClassName('add-link-value')[0].style.display = "none";
               document.getElementsByClassName("link-selection")[0].id = "compose";
               document.getElementsByClassName("link-selection")[0].innerHTML = document.getElementById("compose-sel").innerHTML;
            }
            if (url.includes("/group?id=")) {
               url = "https://" + window.location.hostname + url;
               document.getElementsByClassName('add-link-value')[0].style.display = "block";
               document.getElementsByClassName("link-selection")[0].id = "group";
               document.getElementsByClassName("link-selection")[0].innerHTML = document.getElementById("group-sel").innerHTML;
            }
            if (url.includes("/results?search=")) {
               url = decodeURI(url.replace("/results?search=","").split('&')[0]);
               document.getElementsByClassName('add-link-value')[0].style.display = "block";
               document.getElementsByClassName("link-selection")[0].id = "search";
               document.getElementsByClassName("link-selection")[0].innerHTML = document.getElementById("search-sel").innerHTML;
            }
            document.getElementsByClassName('add-link-value')[0].value = url;
         }
      }
   }
}

function cancelLink() {
   event.stopPropagation();
   document.getElementById("add-link-screen").classList.add("hid");
}

function openDropdownLink() {
   document.getElementsByClassName("link-selection-dropdown")[0].classList.toggle("hid");
}

function selectLinkType(type,e) {
   if (type == "compose" || type == "response") {
      document.getElementsByClassName('add-link-value')[0].style.display = "none";
   }
   else {
      document.getElementsByClassName('add-link-value')[0].style.display = "block";
      if (type == "video") {
         document.getElementsByClassName('add-link-value')[0].setAttribute("placeholder",video_pl);
      }
      if (type == "playlist") {
         document.getElementsByClassName('add-link-value')[0].setAttribute("placeholder",playlist_pl);
      }
      if (type == "channel") {
         document.getElementsByClassName('add-link-value')[0].setAttribute("placeholder",channel_pl);
      }
      if (type == "group") {
         document.getElementsByClassName('add-link-value')[0].setAttribute("placeholder",group_pl);
      }
      if (type == "search") {
         document.getElementsByClassName('add-link-value')[0].setAttribute("placeholder",search_pl);
      }
   }
   document.getElementsByClassName("link-selection-dropdown")[0].classList.add("hid");
   document.getElementsByClassName("link-selection")[0].innerHTML = e.innerHTML;
   document.getElementsByClassName("link-selection")[0].id = type;
   document.getElementsByClassName('add-link-value')[0].value = "";
}

function saveLink() {
   document.getElementById('validurl').style.opacity = 0;
   var link = document.getElementsByClassName('add-link-value')[0].value;
   link = link.split('&')[0];
   var type = document.getElementsByClassName("link-selection")[0].id;
   var id = document.getElementsByClassName("add-link-box")[0].id.replace("_link","");
   if (link.length > 0 || type == "compose" || type == "response") {
      if (type == "video") {
         if (link.includes(window.location.hostname + "/watch?v=")) {
            document.getElementById('validurl').style.opacity = 0;
            var url = link.split(window.location.hostname)[1];
         }
         else {
            document.getElementById('validurl').style.opacity = 1;
         }
      }
      if (type == "playlist") {
         if (link.includes(window.location.hostname + "/view_playlist?id=")) {
            document.getElementById('validurl').style.opacity = 0;
            var url = link.split(window.location.hostname)[1];
         }
         else {
            document.getElementById('validurl').style.opacity = 1;
         }
      }
      if (type == "channel") {
         if (link.match(/^[a-zA-Z0-9]+$/)) {
            document.getElementById('validurl').style.opacity = 0;
            var url = "/subscription_center?add_user=" + link;
         }
         else {
            document.getElementById('validurl').style.opacity = 1;
         }
      }
      if (type == "compose") {
         var url = "/send_message?to=" + uploader;
      }
      if (type == "group") {
         if (link.includes(window.location.hostname + "/group?id=")) {
            document.getElementById('validurl').style.opacity = 0;
            var url = link.split(window.location.hostname)[1];
         }
         else {
            document.getElementById('validurl').style.opacity = 1;
         }
      }
      if (type == "response") {
         var url = "/video_response_upload?v=" + video_url;
      }
      if (type == "search") {
         if (link.match(/^[a-zA-Z0-9 èàùìòÈÀÒÙÌéáúíóÉÁÚÍÓëäüïöËÄÜÏÖêâûîôÊÂÛÎÔç'-]*$/)) {
            document.getElementById('validurl').style.opacity = 0;
            var url = "/results?search="+ encodeURI(link) +"&t=Search+All";
         }
         else {
            document.getElementById('validurl').style.opacity = 1;
         }
      }
   }
   else {
      for (i = 0; i < annotation.length; i++) {
         if (annotation[i].id == id) {
            annotation[i].removeChild(annotation[i].getElementsByTagName("action")[0]);
         }
      }
      document.getElementById(id + "-menu").classList.remove("link");
   }

   if (url && url.length > 0) {
      for (i = 0; i < annotation.length; i++) {
         if (annotation[i].id == id) {
            if (!annotation[i].getElementsByTagName('url')[0]) {
               var action = document.createElementNS("","action");
               var xml_url = document.createElementNS("","url");
               xml_url.setAttributeNS("","value",url);
               action.appendChild(xml_url);
               annotation[i].appendChild(action);
            }
            else {
               annotation[i].getElementsByTagName('url')[0].setAttributeNS("","value",url);
            }
         }
      }
      document.getElementById(id + "-menu").classList.add("link");
      cancelLink();
      modifications = true;
   }
   else {
      for (i = 0; i < annotation.length; i++) {
         if (annotation[i].id == id) {
            annotation[i].removeChild(annotation[i].getElementsByTagName("action")[0]);
         }
      }
      document.getElementById(id + "-menu").classList.remove("link");
   }
}

function changeColor(e) {
   event.stopPropagation();
   var selector = document.getElementsByClassName('color-selector')[0];
   var rect = e.getBoundingClientRect();
   var width = e.offsetWidth / 2;
   var height = document.getElementById("masthead-container").offsetHeight;
   var margin = window.getComputedStyle(document.getElementById("masthead-container"));
   height += parseInt(margin.marginTop) + parseInt(margin.marginBottom);
   selector.id = e.parentElement.parentElement.id.replace("menu-expand-","menu-color-");
   selector.style.left = rect.left + scrollX - width - ((window.innerWidth - 960) / 2) + "px";
   selector.style.top = rect.top + scrollY - height + 25 + "px";
   selector.classList.toggle('hid');
}

function removeAnnotation(e) {
   event.stopPropagation();
   var element = e.parentElement;
   var id = e.parentElement.id.replace("-menu","");
   if (document.getElementById(id)) {
      document.getElementById(id).outerHTML = "";
      if (document.getElementById(id + "_tip")) {
         document.getElementById(id + "_tip").outerHTML = "";
         document.getElementById(id + "_tip_sk").outerHTML = "";
      }
   }
   for (i = 0; i < annotation.length; i++) {
      if (annotation[i].id == id) {
         annotation[i].parentNode.removeChild(annotation[i]);
      }
   }
   e.parentElement.outerHTML = "";
   document.getElementById('status').innerHTML = saved;
   modifications = true;
}

function encodeHTML(s) {
    return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');
}

function updateText(e) {
   if (e.value != e.innerHTML) {
      var text = encodeHTML(e.value);
      for (i = 0; i < annotation.length; i++) {
         if (annotation[i].id == e.id.replace('_textarea', '')) {
            annotation[i].getElementsByTagName('TEXT')[0].innerHTML = text;
            document.getElementById(annotation[i].id + "-menu").querySelector('a').innerHTML = text;
            document.getElementById(e.id).innerHTML = text;
         }
      }
      document.getElementById('status').innerHTML = saved;
      modifications = true;
   }
}

function updateSize(element) {
   for (i = 0; i < annotation.length; i++) {
      if (annotation[i].id == element.id) {
         if (annotation[i].getAttribute("style") != "speech") {
            annotation[i].getElementsByTagName('rectRegion')[0].setAttribute("w", parseFloat(element.style.width));
            annotation[i].getElementsByTagName('rectRegion')[0].setAttribute("h", parseFloat(element.style.height));
            annotation[i].getElementsByTagName('rectRegion')[1].setAttribute("w", parseFloat(element.style.width));
            annotation[i].getElementsByTagName('rectRegion')[1].setAttribute("h", parseFloat(element.style.height));
         }
         else {
            var w_delta = parseFloat(element.style.width) - annotation[i].getElementsByTagName('anchoredRegion')[0].getAttribute("w");
            var h_delta = parseFloat(element.style.height) - annotation[i].getElementsByTagName('anchoredRegion')[0].getAttribute("h");
            annotation[i].getElementsByTagName('anchoredRegion')[0].setAttribute("w", parseFloat(element.style.width));
            annotation[i].getElementsByTagName('anchoredRegion')[0].setAttribute("h", parseFloat(element.style.height));
            annotation[i].getElementsByTagName('anchoredRegion')[1].setAttribute("w", parseFloat(element.style.width));
            annotation[i].getElementsByTagName('anchoredRegion')[1].setAttribute("h", parseFloat(element.style.height));
         }
      }
   }
   updatePosition(element);
   document.getElementById('status').innerHTML = saved;
   modifications = true;
}

function updatePosition(element) {
   for (i = 0; i < annotation.length; i++) {
      if (annotation[i].id == element.id) {
         if (annotation[i].getAttribute("style") != "speech") {
            annotation[i].getElementsByTagName('rectRegion')[0].setAttribute("x", parseInt(element.style.left));
            annotation[i].getElementsByTagName('rectRegion')[0].setAttribute("y", parseInt(element.style.top));
            annotation[i].getElementsByTagName('rectRegion')[1].setAttribute("x", parseInt(element.style.left));
            annotation[i].getElementsByTagName('rectRegion')[1].setAttribute("y", parseInt(element.style.top));
         }
         else {
            var x_delta = parseInt(element.style.left) - annotation[i].getElementsByTagName('anchoredRegion')[0].getAttribute("x");
            var y_delta = parseInt(element.style.top) - annotation[i].getElementsByTagName('anchoredRegion')[0].getAttribute("y");
            annotation[i].getElementsByTagName('anchoredRegion')[0].setAttribute("sy", annotation[i].getElementsByTagName('anchoredRegion')[0].getAttribute("sy") * 1 + y_delta * 1);
            annotation[i].getElementsByTagName('anchoredRegion')[1].setAttribute("sy", annotation[i].getElementsByTagName('anchoredRegion')[1].getAttribute("sy") * 1 + y_delta * 1);
            annotation[i].getElementsByTagName('anchoredRegion')[0].setAttribute("sx", annotation[i].getElementsByTagName('anchoredRegion')[0].getAttribute("sx") * 1 + x_delta * 1);
            annotation[i].getElementsByTagName('anchoredRegion')[1].setAttribute("sx", annotation[i].getElementsByTagName('anchoredRegion')[1].getAttribute("sx") * 1 + x_delta * 1);
            annotation[i].getElementsByTagName('anchoredRegion')[0].setAttribute("x", parseInt(element.style.left));
            annotation[i].getElementsByTagName('anchoredRegion')[0].setAttribute("y", parseInt(element.style.top));
            annotation[i].getElementsByTagName('anchoredRegion')[1].setAttribute("x", parseInt(element.style.left));
            annotation[i].getElementsByTagName('anchoredRegion')[1].setAttribute("y", parseInt(element.style.top));
            recalculate(element.id,annotation[i]);
         }
         document.getElementById("resize-0-" + annotation[i].id).addEventListener('mousedown', initDrag, false);
         document.getElementById("resize-1-" + annotation[i].id).addEventListener('mousedown', initDrag, false);
         document.getElementById("resize-2-" + annotation[i].id).addEventListener('mousedown', initDrag, false);
         document.getElementById("resize-3-" + annotation[i].id).addEventListener('mousedown', initDrag, false);
         document.getElementById(annotation[i].id).addEventListener('mousedown', initMove, false);
      }
   }
   document.getElementById('status').innerHTML = saved;
   modifications = true;
}

var time;

function focus_time(e) {
   event.stopPropagation();
   time = e.value;
   document.getElementById("status").innerHTML = "";
}

function unfocus_time(e) {
   event.stopPropagation();
   if (validateHhMmSs(e) == true) {
      var id = e.parentElement.parentElement.id.replace("-menu","");
      if (!e.value.includes(".")) {
         e.value += ".00";
      }
      var l = (e.value.substring(0,1) * 3600) + (e.value.substring(2,4) * 60) + parseInt(e.value.substring(5,7)) + (e.value.substring(8) / 10);
      if (e.id == "from") {
         var o = document.querySelector("#"+ id +"-menu #to");
      }
      else {
         var o = document.querySelector("#"+ id +"-menu #from");
      }
      var s = (o.value.substring(0,1) * 3600) + (o.value.substring(2,4) * 60) + parseInt(o.value.substring(5,7)) + (o.value.substring(8) / 10);
      var t = document.getElementsByClassName("vlDuration")[0].innerHTML;
      t_array = t.split(":");
      if (t_array.length == 3) {
         t = (t_array[0] * 3600) + (t_array[1] * 60) + t_array[2] * 1;
      }
      else {
         t = (t_array[0] * 60) + t_array[1] * 1;
      }
      if (l > t) {
         alert(outsiderange);
         e.value = time;
         return false;
      }
      if (e.id == "from" && s < l) {
         alert(outsiderange);
         e.value = time;
         return false;
      }
      if (e.id == "to" && l < s) {
         alert(outsiderange);
         e.value = time;
         return false;
      }
      if (e.id == "from") {
         for (i = 0; i < annotation.length; i++) {
            if (annotation[i].id == id) {
               if (annotation[i].getAttribute("style") != "speech") {
                  annotation[i].getElementsByTagName('rectRegion')[0].setAttribute("t", e.value);
               }
               else {
                  annotation[i].getElementsByTagName('anchoredRegion')[0].setAttribute("t", e.value);
               }
            }
         }
         document.querySelector("#"+ id +"-menu a").setAttribute("href","#t="+l);
      }
      if (e.id == "to") {
         for (i = 0; i < annotation.length; i++) {
            if (annotation[i].id == id) {
               if (annotation[i].getAttribute("style") != "speech") {
                  annotation[i].getElementsByTagName('rectRegion')[1].setAttribute("t", e.value);
               }
               else {
                  annotation[i].getElementsByTagName('anchoredRegion')[1].setAttribute("t", e.value);
               }
            }
         }
      }
      if (e.value != time) {
         annotationsVideoEditor();
         document.getElementById('status').innerHTML = saved;
         modifications = true;
      }
   }
   else {
      alert(notvaliddate);
      e.value = time;
      return false;
   }
}

function validateHhMmSs(e) {
   var isValid = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9]):([0-5][0-9])(.[0-9]|.[0-9][0-9])?$/.test(e.value);
   return isValid;
}

function selectColor(e) {
   var element = e.parentElement;
   var id = element.id.replace("menu-color-","");
   if (e.id == "select-black") {
      var bg = "0";
      var fg = "16777215";
      var alpha = "0.5";
   }
   else if (e.id == "select-grey") {
      var bg = "10066329";
      var fg = "16777215";
      var alpha = "0.8";
   }
   else if (e.id == "select-white") {
      var bg = "16777215";
      var fg = "1710618";
      var alpha = "0.8";
   }
   else if (e.id == "select-lightblue") {
      var bg = "11847903";
      var fg = "1710618";
      var alpha = "0.8";
   }
   else if (e.id == "select-red") {
      var bg = "13319742";
      var fg = "16777215";
      var alpha = "0.8";
   }
   else if (e.id == "select-green") {
      var bg = "3052840";
      var fg = "16777215";
      var alpha = "0.8";
   }
   else if (e.id == "select-blue") {
      var bg = "407700";
      var fg = "16777215";
      var alpha = "0.8";
   }
   if (bg != 0) {
      var new_bg = "linear-gradient("+ colorToRGB2(bg) + alpha +") 0%," + colorToRGB(bg) + alpha + ") 30%)";
   }
   else {
      var new_bg = "rgba(0, 0, 0, "+ alpha +")";
   }
   var new_fg = colorToRGB(fg) + "1)";
   for (i = 0; i < annotation.length; i++) {
      if (annotation[i].id == id) {
         if (annotation[i].getAttribute("type") != "highlight") {
            if (annotation[i].getAttribute("style") != "speech") {
               annotation[i].getElementsByTagName('appearance')[0].setAttribute("bgColor", bg);
               annotation[i].getElementsByTagName('appearance')[0].setAttribute("fgColor", fg);
               annotation[i].getElementsByTagName('appearance')[0].setAttribute("bgAlpha", alpha);
            }
            else {
               annotation[i].getElementsByTagName('appearance')[0].setAttribute("bgColor", bg);
               annotation[i].getElementsByTagName('appearance')[0].setAttribute("fgColor", fg);
               annotation[i].getElementsByTagName('appearance')[0].setAttribute("bgAlpha", alpha);
               recalculate(annotation[i].id,annotation[i]);
            }
            if (document.getElementById(id)) {
               document.getElementById(id).style.background = new_bg;
               document.getElementById(id).style.color = new_fg;
            }
         }
         else {
            annotation[i].getElementsByTagName('appearance')[0].setAttribute("bgColor", bg);
            if (document.getElementById(id)) {
               document.getElementById(id).style.borderColor = colorToRGB(bg) + 0.2 + ")";
               document.getElementById(id).classList = "annotation highlightAn c_" + bg;
            }
         }
      }
   }
   document.getElementById('status').innerHTML = saved;
   modifications = true;
}

function annotationsVideoEditor() {
   if (annotation) {
      for (i = 0; i < annotation.length; i++) {
      var id = annotation[i].id;

      if (annotation[i].getAttribute("style") != "speech") {

         var from = annotation[i].getElementsByTagName('rectRegion')[0].getAttribute('t');
         if (from != "never") {
            from = (from.substring(0,1) * 3600) + (from.substring(2,4) * 60) + parseInt(from.substring(5,7)) + (from.substring(8) / 10);
            from == 0 ? from = 0 : from = from;
         }
         else {
            from = 0;
         }

         var to = annotation[i].getElementsByTagName('rectRegion')[1].getAttribute('t');
         if (to != "never") {
            to = (to.substring(0,1) * 3600) + (to.substring(2,4) * 60) + parseInt(to.substring(5,7)) + (to.substring(8) / 10);
         } else {
            to = Infinity;
         }

         var width = annotation[i].getElementsByTagName('rectRegion')[0].getAttribute('w');
         var height = annotation[i].getElementsByTagName('rectRegion')[0].getAttribute('h');
         var x = annotation[i].getElementsByTagName('rectRegion')[0].getAttribute('x');
         var y = annotation[i].getElementsByTagName('rectRegion')[0].getAttribute('y');
         if (annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgColor') != 0) {
            var bg = "linear-gradient("+ colorToRGB2(annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgColor')) + annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgAlpha') +") 0%," + colorToRGB(annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgColor')) + annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgAlpha') + ") 30%)";
         }
         else {
            var bg = colorToRGB(annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgColor')) + annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgAlpha') + ")";
         }
         var fg = colorToRGB(annotation[i].getElementsByTagName('appearance')[0].getAttribute('fgColor')) + "1)";
         if (document.getElementsByClassName("vlPlayer")[0].classList.contains("playing") || document.getElementsByClassName("vlPlayer")[0].classList.contains("full")) {
            var fs = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * document.getElementsByClassName('vlAnnotationsContainer')[0].offsetHeight / 100);
         }
         else {
            if (document.getElementsByClassName("vlPlayer")[0].classList.contains("expanded")) {
               var fs = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * 480 / 100);
            }
            else {
               var fs = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * 360 / 100);
            }
         }
         var contents = "";
         if (annotation[i].getElementsByTagName('TEXT')[0]) {
            contents = annotation[i].getElementsByTagName('TEXT')[0].innerHTML;
            contents = contents.replace(/(?:\r\n|\r|\n)/g, '<br>')
         }
         var onclick = "";
         var onmouseover = "";
         var onmouseout = "";
         var a_class = "";
         var border = "";
         if (annotation[i].getElementsByTagName('url')[0]) {
            var url = annotation[i].getElementsByTagName('url')[0].getAttribute("value");
            onclick = "window.location.href = '" + url + "'";
            onmouseover = "changeopacity(this,'"+ annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgColor') +"','"+ annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgAlpha') +"',1)";
            onmouseout = "changeopacity(this,'"+ annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgColor') +"','"+ annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgAlpha') +"',0)";
            a_class += ' link';
         }
         if (annotation[i].getAttribute("type") == "highlight") {
            a_class += ' highlightAn c_' + annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgColor');
            border = "border:" + annotation[i].getElementsByTagName('appearance')[0].getAttribute('highlightWidth') + "px solid "+ colorToRGB(annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgColor')) +" "+ annotation[i].getElementsByTagName('appearance')[0].getAttribute('borderAlpha') +")";
         }

         if (annotation[i].getAttribute("style") == "highlightText") {
            return false;
         }
         if (curTime >= from && curTime <= to) {
            if (!document.getElementById(id)) {
               document.getElementsByClassName('vlAnnotationsContainer')[0].innerHTML+='<div class="annotation'+a_class+'" onclick="event.stopPropagation();" id="'+ id +'" onclick="'+ onclick +'" onmouseover="'+ onmouseover +'" onmouseout="'+ onmouseout +'" style="background: '+ bg +'; color: '+ fg +'; font-size: '+ fs +'px; left: '+ x +'%; top: '+ y +'%; width: ' + width + '%; height: '+ height +'%;'+ border +'"><textarea id="'+ id +'_textarea" onkeyup="updateText(this)" onclick="focus_t(this)" style="font-size:'+ fs +'px">'+ contents.replace(/<br\s?\/?>/g,"\n") +'</textarea><span class="resize resize-0" id="resize-0-'+ id +'"></span><span class="resize resize-1" id="resize-1-'+ id +'"></span><span class="resize resize-2" id="resize-2-'+ id +'"></span><span class="resize resize-3" id="resize-3-'+ id +'"></span></div>';
            }
            else {
               if (document.getElementsByClassName("vlPlayer")[0].classList.contains("playing") || document.getElementsByClassName("vlPlayer")[0].classList.contains("full")) {
                  document.getElementById(id + "_textarea").style.fontSize = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * document.getElementsByClassName('vlAnnotationsContainer')[0].offsetHeight / 100) + "px";
               }
               else {
                  if (document.getElementsByClassName("vlPlayer")[0].classList.contains("expanded")) {
                     document.getElementById(id + "_textarea").style.fontSize = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * 480 / 100) + "px";
                  }
                  else {
                     document.getElementById(id + "_textarea").style.fontSize = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * 360 / 100) + "px";
                  }
               }
            }
         }
         else {
            if (document.getElementById(id)) {
               document.getElementById(id).outerHTML = "";
            }
         }
      }
      else {
         var from = annotation[i].getElementsByTagName('anchoredRegion')[0].getAttribute('t');
         if (from != "never") {
            from = (from.substring(0,1) * 3600) + (from.substring(2,4) * 60) + parseInt(from.substring(5,7)) + (from.substring(8) / 10);
            from == 0 ? from = 0 : from = from;
         }
         else {
            from = 0;
         }

         var to = annotation[i].getElementsByTagName('anchoredRegion')[1].getAttribute('t');
         if (to != "never") {
            to = (to.substring(0,1) * 3600) + (to.substring(2,4) * 60) + parseInt(to.substring(5,7)) + (to.substring(8) / 10);
         } else {
            to = Infinity;
         }

         var width = annotation[i].getElementsByTagName('anchoredRegion')[0].getAttribute('w');
         var height = annotation[i].getElementsByTagName('anchoredRegion')[0].getAttribute('h');
         var x = annotation[i].getElementsByTagName('anchoredRegion')[0].getAttribute('x');
         var y = annotation[i].getElementsByTagName('anchoredRegion')[0].getAttribute('y');
         var sx = annotation[i].getElementsByTagName('anchoredRegion')[1].getAttribute('sx');
         var sy = annotation[i].getElementsByTagName('anchoredRegion')[1].getAttribute('sy');
         var bg = "linear-gradient("+ colorToRGB2(annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgColor')) + annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgAlpha') +") 0%," + colorToRGB(annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgColor')) + annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgAlpha') + ") 30%)";
         var fg = colorToRGB(annotation[i].getElementsByTagName('appearance')[0].getAttribute('fgColor')) + "1)";
         if (document.getElementsByClassName("vlPlayer")[0].classList.contains("playing") || document.getElementsByClassName("vlPlayer")[0].classList.contains("full")) {
            var fs = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * document.getElementsByClassName('vlAnnotationsContainer')[0].offsetHeight / 100);
         }
         else {
            if (document.getElementsByClassName("vlPlayer")[0].classList.contains("expanded")) {
               var fs = annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize');
            }
            else {
               var fs = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * 360 / 100) + "px";
            }
         }
         var contents = "";
         if (annotation[i].getElementsByTagName('TEXT')[0]) {
            contents = annotation[i].getElementsByTagName('TEXT')[0].innerHTML;
            contents = contents.replace(/(?:\r\n|\r|\n)/g, '<br>')
         }

         var onclick = "";
         var onmouseover = "";
         var onmouseout = "";
         var a_class = " speech";
         if (annotation[i].getElementsByTagName('url')[0]) {
            var url = annotation[i].getElementsByTagName('url')[0].getAttribute("value");
            onclick = "window.location.href = '" + url + "'";
            onmouseover = "changeopacity(this,'"+ annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgColor') +"','"+ annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgAlpha') +"',1)";
            onmouseout = "changeopacity(this,'"+ annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgColor') +"','"+ annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgAlpha') +"',0)";
            a_class += ' link';
         }

         if (curTime >= from && curTime <= to) {
            var ac = document.querySelector(".vlAnnotationsContainer");
            var bounds = ac.getBoundingClientRect();
            if (!document.getElementById(id)) {
               document.getElementsByClassName('vlAnnotationsContainer')[0].innerHTML+='<div class="annotation'+a_class+'" onclick="event.stopPropagation();" id="'+ id +'" onclick="'+ onclick +'" onmouseover="'+ onmouseover +'" onmouseout="'+ onmouseout +'" style="background-image: '+ bg +'; color: '+ fg +'; font-size: '+ fs +'px; left: '+ x +'%; top: '+ y +'%; width: ' + width + '%;height: ' + height + '%;background-position: 0 0"><textarea id="'+ id +'_textarea" onkeyup="updateText(this)" onmousedown="focus_t(this)" style="font-size:'+ fs +'px">'+ contents.replace(/<br\s?\/?>/g,"\n") +'</textarea></div>';
               
               document.getElementById(id).innerHTML += "<span class='resize resize-0' id='resize-0-"+ id +"'></span>";
               document.getElementById(id).innerHTML += "<span class='resize resize-1' id='resize-1-"+ id +"'></span>";
               document.getElementById(id).innerHTML += "<span class='resize resize-2' id='resize-2-"+ id +"'></span>";
               document.getElementById(id).innerHTML += "<span class='resize resize-3' id='resize-3-"+ id +"'></span>";
               document.getElementById("resize-0-" + id).addEventListener('mousedown', initDrag, false);
               document.getElementById("resize-1-" + id).addEventListener('mousedown', initDrag, false);
               document.getElementById("resize-2-" + id).addEventListener('mousedown', initDrag, false);
               document.getElementById("resize-3-" + id).addEventListener('mousedown', initDrag, false);
               document.getElementById(id).addEventListener('mousedown', initMove, false);
               var annotationBounds = document.getElementById(id).getBoundingClientRect();
               var speechPoints = bubbleSpecs(
                          parseInt(x),
                          parseInt(y),
                          parseInt(document.getElementById(id).getBoundingClientRect().width
                                  / bounds.width * 100),
                          parseInt(document.getElementById(id).getBoundingClientRect().height
                                  / bounds.height * 100),
                          parseInt(sx),
                          parseInt(sy),
                          [0, 0, 0, 0],
                          width / 2
                      )

                      var start = [
                          speechPoints.startX,
                          (bounds.height / 100 * speechPoints.startY)
                      ];
                      var end = [
                          speechPoints.endX,
                          (bounds.height / 100 * speechPoints.endY)
                      ]
                      var endPoint = [
                          parseInt(sx),
                          (bounds.height / 100 * parseInt(sy))
                      ]

                      if(speechPoints.direction != "top") {
                          var relativeStart = [
                             Math.min(start[0], end[0], endPoint[0]),
                             Math.min(start[1], end[1], endPoint[1])
                         ];
                      }
                      else {
                        var relativeStart = [
                             Math.min(start[0], end[0], endPoint[0]),
                             Math.max(start[1], end[1], endPoint[1])
                         ];
                      }

                      if(speechPoints.direction == "right") {
                          relativeStart[0] = Math.max(start[0], end[0], endPoint[0])
                      }

                      var svgViewbox = [
                          bounds.width / 100 * Math.abs(end[0] - relativeStart[0]),
                          Math.abs(endPoint[1] - relativeStart[1])
                      ]

                      var relativePoints = [
                          Math.floor(bounds.width / 100
                                  * Math.floor(start[0] - relativeStart[0]))
                                  + "," + (Math.floor(start[1] - relativeStart[1])),
                          Math.floor(bounds.width / 100
                                  * Math.floor(end[0] - relativeStart[0]))
                                  + "," + (Math.floor(end[1] - relativeStart[1])),
                          Math.floor(endPoint[0] - relativeStart[0]) * 8
                                      + ","
                                      + (Math.floor(endPoint[1] - relativeStart[1]))
                      ]
                     // tip svg element
                      var tip = document.createElementNS("http://www.w3.org/2000/svg","svg")
                      tip.id = id + "_tip"
                      tip.className = "speech-point"
                      tip.style.position = "absolute"
                      tip.style.overflow = "visible"
                      tip.style.left = parseFloat(relativeStart[0]) + "%"
                      tip.style.top = relativeStart[1] + "px"
                      tip.style.width = (svgViewbox[0] / bounds.width) * 100 + "%"
                      tip.style.height = (parseFloat(relativePoints[2].split(",")[1]) / bounds.height * 100) + "%"
                      tip.setAttribute("viewBox", "0 0 "
                                                  + Math.floor(svgViewbox[0])
                                                  + " " + Math.floor(svgViewbox[1]))
                      ac.appendChild(tip)
                      
                      var path = document.createElementNS(
                          "http://www.w3.org/2000/svg",
                          "path"
                      )
                      path.setAttributeNS(null, "fill", annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgColor')
                                                      ? colorToRGB(annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgColor')) + annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgAlpha') + ")"
                                                      : "rgba(255, 255, 255, 0.7)")
                      path.setAttributeNS(null, "d", "M "
                                                  + relativePoints[0].toString()
                                                  + " L " + relativePoints[1]
                                                          .toString()
                                                  + " L " + relativePoints[2]
                                                          .toString() + " Z")
                      tip.appendChild(path)
                      tip.style.zIndex = "33";
                       if(speechPoints.direction == "bottom"
                       || speechPoints.direction == "right") {
                           switch(speechPoints.direction) {
                               case "right": {
                                   tip.style.left = (relativeStart[0] * bounds.width / 100 + 1) + "px"
                                   break;
                               }
                           }
                           switch(speechPoints.direction) {
                               case "bottom": {
                                   tip.style.top = relativeStart[1] + 1 + "px"
                                   break;
                               }
                           }
                       }
         document.querySelector(".vlAnnotationsContainer").innerHTML += '<div id="'+ id + '_tip_sk" class="tip_sk"></div>';
         var sk = document.getElementById(id + "_tip_sk");
         sk.style.left = (sx * 1) + "%";
         sk.style.top = sy + "%";
         sk.addEventListener('mousedown', initDragSk, false);
            } 
            else {
               if (document.getElementsByClassName("vlPlayer")[0].classList.contains("playing") || document.getElementsByClassName("vlPlayer")[0].classList.contains("full")) {
                  document.getElementById(id + "_textarea").style.fontSize = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * document.getElementsByClassName('vlAnnotationsContainer')[0].offsetWidth * 0.5625 / 100) + "px";
               }
               else {
                  if (document.getElementsByClassName("vlPlayer")[0].classList.contains("expanded")) {
                     document.getElementById(id + "_textarea").style.fontSize = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * 480 / 100) + "px";
                     bounds.height = 480;
                  }
                  else {
                     document.getElementById(id + "_textarea").style.fontSize = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * 360 / 100) + "px";
                  }
               }
               var sk = document.getElementById(id + "_tip_sk");
               sk.addEventListener('mousedown', initDragSk, false);
               console.log(sk);
            }
         }
         else {
            if (document.getElementById(id)) {
               document.getElementById(id).outerHTML = "";
               document.getElementById(id + "_tip").outerHTML = "";
               document.getElementById(id + "_tip_sk").outerHTML = "";
            }
         }

      }
   }
   if (document.getElementsByClassName('annotation')) {
      var anns = document.getElementsByClassName('annotation');
      for (i = 0; i < anns.length; i++) {
         document.getElementById("resize-0-" + anns[i].id).addEventListener('mousedown', initDrag, false);
         document.getElementById("resize-1-" + anns[i].id).addEventListener('mousedown', initDrag, false);
         document.getElementById("resize-2-" + anns[i].id).addEventListener('mousedown', initDrag, false);
         document.getElementById("resize-3-" + anns[i].id).addEventListener('mousedown', initDrag, false);
         document.getElementById(anns[i].id).addEventListener('mousedown', initMove, false);
      }
   }
   }
}

var startX, startY, startWidth, startHeight, startLeft, startTop, element, number, sk;

function initDrag(e) {
   event.stopPropagation();
   number = e.srcElement.classList[1];
   number = number.substring(number.length - 1);
   document.getElementById('status').innerHTML = "";
   element = e.srcElement.parentElement;
   startX = e.clientX;
   startY = e.clientY;
   startWidth = parseFloat(document.defaultView.getComputedStyle(e.srcElement.parentElement).width, 10);
   startHeight = parseFloat(document.defaultView.getComputedStyle(e.srcElement.parentElement).height, 10);
   document.documentElement.addEventListener('mousemove', doDrag, false);
   document.documentElement.addEventListener('mouseup', stopDrag, false);
   document.querySelector("*").style.userSelect = "none";
}

function doDrag(e) {
   if (document.getElementById(element.id + "_tip")) {
      document.getElementById(element.id + "_tip").style.display = "none";
      document.getElementById(element.id + "_tip_sk").style.display = "none";
   }
   if (number == 0) {
      var newWidth = parseInt((startWidth - e.clientX + startX) / 640 * 100);
      var newHeight = parseInt((startHeight - e.clientY + startY) / 360 * 100);
      var newLeft = parseInt(parseFloat(element.style.left) - (newWidth - (parseFloat(element.style.width))));
      var newTop = parseInt(parseFloat(element.style.top) - (newHeight - (parseFloat(element.style.height))));
      if (newLeft > 0 && newWidth >= 15) {
         element.style.width = newWidth + '%';
         element.style.left = newLeft + '%';
      }
      if (newHeight < (100 - 2 - parseFloat(element.style.top)) && newHeight >= 4) {
         element.style.height = newHeight + '%';
         element.style.top = newTop + '%';
      }
   }
   if (number == 1) {
      var newWidth = parseInt((startWidth - e.clientX + startX) / 640 * 100);
      var newHeight = parseInt((startHeight + e.clientY - startY) / 360 * 100);
      var newLeft = parseInt(parseFloat(element.style.left) - (newWidth - (parseFloat(element.style.width))));
      if (newLeft > 0 && newWidth >= 15) {
         element.style.width = newWidth + '%';
         element.style.left = newLeft + '%';
      }
      if (newHeight < (100 - 2 - parseFloat(element.style.top)) && newHeight >= 4) {
         element.style.height = newHeight + '%';
      }
   }
   if (number == 2) {
      var newWidth = parseInt((startWidth + e.clientX - startX) / 640 * 100);
      var newHeight = parseInt((startHeight - e.clientY + startY) / 360 * 100);
      var newTop = parseInt(parseFloat(element.style.top) - (newHeight - (parseFloat(element.style.height))));
      if (newWidth < (100 - 2 - parseFloat(element.style.left)) && newWidth >= 15) {
         element.style.width = newWidth + '%';
      }
      if (newTop > 0 && newHeight >= 4) {
         element.style.height = newHeight + '%';
         element.style.top = newTop + '%';
      }
   }
   if (number == 3) {
      var newWidth = parseInt((startWidth + e.clientX - startX) / 640 * 100);
      var newHeight = parseInt((startHeight + e.clientY - startY) / 360 * 100);
      if (newWidth < (100 - 2 - parseFloat(element.style.left)) && newWidth >= 15) {
         element.style.width = newWidth + '%';
      }
      if (newHeight < (100 - 2 - parseFloat(element.style.top)) && newHeight >= 4) {
         element.style.height = newHeight + '%';
      }
   }
}

function stopDrag(e) {
   event.stopPropagation();
    document.documentElement.removeEventListener('mousemove', doDrag, false);
    document.documentElement.removeEventListener('mouseup', stopDrag, false);
    updateSize(element);
    document.querySelector("*").style.userSelect = "auto";
}

function initDragSk(e) {
   event.stopPropagation();
   document.getElementById('status').innerHTML = "";
   element = e.srcElement;
   startX = e.clientX;
   startY = e.clientY;
   startLeft = parseFloat(document.defaultView.getComputedStyle(e.srcElement).left, 10);
   startTop = parseFloat(document.defaultView.getComputedStyle(e.srcElement).top, 10);
   document.documentElement.addEventListener('mousemove', doDragSk, false);
   document.documentElement.addEventListener('mouseup', stopDragSk, false);
   document.querySelector("*").style.userSelect = "none";
}

function doDragSk(e) {
   if (document.getElementById(element.id)) {
      var x = document.getElementById(element.id.replace("_tip_sk","")).style.left;
      var y = document.getElementById(element.id.replace("_tip_sk","")).style.top;
      var w = document.getElementById(element.id.replace("_tip_sk","")).style.width;
      var h = document.getElementById(element.id.replace("_tip_sk","")).style.height;
      var newLeft = parseFloat((startLeft + e.clientX - startX) / 640 * 100);
      var newTop = parseFloat((startTop + e.clientY - startY) / 360 * 100);
      for (i = 0; i < annotation.length; i++) {
         if (annotation[i].id == element.id.replace("_tip_sk","")) {
            if (newLeft >= 0 && newLeft < (100 - (14 / 640 * 100))) {
               element.style.left = newLeft + '%';
               annotation[i].getElementsByTagName('anchoredRegion')[0].setAttribute("sx", newLeft);
               annotation[i].getElementsByTagName('anchoredRegion')[1].setAttribute("sx", newLeft);
            }
            if (newTop < (100 - (14 / 640 * 100)) && newTop >= 0) {
               element.style.top = newTop + '%';
               annotation[i].getElementsByTagName('anchoredRegion')[0].setAttribute("sy", newTop);
               annotation[i].getElementsByTagName('anchoredRegion')[1].setAttribute("sy", newTop);
            }
            recalculate(element.id.replace("_tip_sk",""),annotation[i]);
         }
      }
   }  
}

function stopDragSk(e) {
   event.stopPropagation();
    document.documentElement.removeEventListener('mousemove', doDragSk, false);
    document.documentElement.removeEventListener('mouseup', stopDragSk, false);
    modifications = true;
    document.getElementById('status').innerHTML = saved;
    document.querySelector("*").style.userSelect = "auto";
}

function initMove(e) {
   event.stopPropagation();
   document.getElementById('status').innerHTML = "";
   element = e.srcElement;
   startX = e.clientX;
   startY = e.clientY;
   startLeft = parseInt(document.defaultView.getComputedStyle(e.srcElement).left, 10);
   startTop = parseInt(document.defaultView.getComputedStyle(e.srcElement).top, 10);
   document.documentElement.addEventListener('mousemove', doMove, false);
   document.documentElement.addEventListener('mouseup', stopMove, false);
   document.querySelector("*").style.userSelect = "none";
}

function doMove(e) {
   if (document.getElementById(element.id + "_tip")) {
      document.getElementById(element.id + "_tip").style.display = "none";
      document.getElementById(element.id + "_tip_sk").style.display = "none";
   }
   var newLeft = ((startLeft + e.clientX - startX) / 640 * 100);
   var newTop = ((startTop + e.clientY - startY) / 360 * 100);
   if (newLeft < (100 - 2 - parseInt(element.style.width)) && newLeft >= 0) {
      element.style.left = parseInt(newLeft) + '%';
   }
   if (newTop < (100 - 2 - parseInt(element.style.height)) && newTop >= 0) {
      element.style.top = parseInt(newTop) + '%';
   }
}

function stopMove(e) {
   event.stopPropagation();
    document.documentElement.removeEventListener('mousemove', doMove, false);
    document.documentElement.removeEventListener('mouseup', stopMove, false);
    updatePosition(element);
    document.querySelector("*").style.userSelect = "auto";
}

function focus_t(e) {
   event.stopPropagation();
   var focus = (document.activeElement === e);
   e.focus();
   document.getElementById('status').innerHTML = "";
}

function recalculate(id,e) {
   document.getElementById(id + "_tip").outerHTML = "";
   var width = e.getElementsByTagName('anchoredRegion')[0].getAttribute('w');
   var height = e.getElementsByTagName('anchoredRegion')[0].getAttribute('h');
   var x = e.getElementsByTagName('anchoredRegion')[0].getAttribute('x');
   var y = e.getElementsByTagName('anchoredRegion')[0].getAttribute('y');
   var sx = e.getElementsByTagName('anchoredRegion')[1].getAttribute('sx');
   var sy = e.getElementsByTagName('anchoredRegion')[1].getAttribute('sy');
   var ac = document.querySelector(".vlAnnotationsContainer");
   var bounds = ac.getBoundingClientRect();
   var annotationBounds = document.getElementById(id).getBoundingClientRect();
   var speechPoints = bubbleSpecs(
              parseInt(x),
              parseInt(y),
              parseInt(document.getElementById(id).getBoundingClientRect().width
                      / bounds.width * 100),
              parseInt(document.getElementById(id).getBoundingClientRect().height
                      / bounds.height * 100),
              parseInt(sx),
              parseInt(sy),
              [0, 0, 0, 0],
              width / 2
          )

          var start = [
              speechPoints.startX,
              (bounds.height / 100 * speechPoints.startY)
          ];
          var end = [
              speechPoints.endX,
              (bounds.height / 100 * speechPoints.endY)
          ]
          var endPoint = [
              parseInt(sx),
              (bounds.height / 100 * parseInt(sy))
          ]

          if(speechPoints.direction != "top") {
              var relativeStart = [
                 Math.min(start[0], end[0], endPoint[0]),
                 Math.min(start[1], end[1], endPoint[1])
             ];
          }
          else {
            var relativeStart = [
                 Math.min(start[0], end[0], endPoint[0]),
                 Math.max(start[1], end[1], endPoint[1])
             ];
          }

          if(speechPoints.direction == "right") {
              relativeStart[0] = Math.max(start[0], end[0], endPoint[0])
          }

          var svgViewbox = [
              bounds.width / 100 * Math.abs(end[0] - relativeStart[0]),
              Math.abs(endPoint[1] - relativeStart[1])
          ]

          var relativePoints = [
              Math.floor(bounds.width / 100
                      * Math.floor(start[0] - relativeStart[0]))
                      + "," + (Math.floor(start[1] - relativeStart[1])),
              Math.floor(bounds.width / 100
                      * Math.floor(end[0] - relativeStart[0]))
                      + "," + (Math.floor(end[1] - relativeStart[1])),
              Math.floor(endPoint[0] - relativeStart[0]) * 8
                          + ","
                          + (Math.floor(endPoint[1] - relativeStart[1]))
          ]
   // tip svg element
    var tip = document.createElementNS("http://www.w3.org/2000/svg","svg")
    tip.id = id + "_tip"
    tip.className = "speech-point"
    tip.style.position = "absolute"
    tip.style.overflow = "visible"
    tip.style.left = parseFloat(relativeStart[0]) + "%"
    tip.style.top = relativeStart[1] + "px"
    tip.style.width = (svgViewbox[0] / bounds.width) * 100 + "%"
    tip.style.height = (parseFloat(relativePoints[2].split(",")[1]) / bounds.height * 100) + "%"
    tip.setAttribute("viewBox", "0 0 "
                                + Math.floor(svgViewbox[0])
                                + " " + Math.floor(svgViewbox[1]))
    ac.appendChild(tip)
    
    var path = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "path"
    )
    path.setAttributeNS(null, "fill", e.getElementsByTagName('appearance')[0].getAttribute('bgColor')
                                    ? colorToRGB(e.getElementsByTagName('appearance')[0].getAttribute('bgColor')) + e.getElementsByTagName('appearance')[0].getAttribute('bgAlpha') + ")"
                                    : "rgba(255, 255, 255, 0.7)")
    path.setAttributeNS(null, "d", "M "
                                + relativePoints[0].toString()
                                + " L " + relativePoints[1]
                                        .toString()
                                + " L " + relativePoints[2]
                                        .toString() + " Z")
    tip.appendChild(path)
    tip.style.zIndex = "33";
     if(speechPoints.direction == "bottom"
     || speechPoints.direction == "right") {
         switch(speechPoints.direction) {
             case "right": {
                 tip.style.left = (relativeStart[0] * bounds.width / 100 + 1) + "px"
                 break;
             }
         }
         switch(speechPoints.direction) {
             case "bottom": {
                 tip.style.top = relativeStart[1] + 1 + "px"
                 break;
             }
         }
     }

   var sk = document.getElementById(id + "_tip_sk");
   sk.style.left = sx * 1 + "%";
   sk.style.top = sy * 1 + "%";
   sk.style.display = "block";
   sk.addEventListener('mousedown', initDragSk, false);
   
}
function publish() {
   if (annotation && annotation.length > 0) {
      var html = '<?xml version="1.0" encoding="UTF-8" ?><document><annotations>';
      for (i = 0; i < annotation.length; i++) {
         html += annotation[i].outerHTML;
      }
      html += "</annotations></document>";
      $.ajax({
           type: "POST",
           url: "/a/save_annotations",
           data: {
               url: video_url,
               content: html,
           },
           success: function(output) {
               if (output.response == "success") {
                  document.getElementById('status').innerHTML = published;
                  modifications = false;
               }
               else {
                   alert("Something went wrong!");
               }
           }
       });
   }
   else {
      $.ajax({
           type: "POST",
           url: "/a/save_annotations",
           data: {
               url: video_url,
               content: "delete",
           },
           success: function(output) {
               if (output.response == "success") {
                  document.getElementById('status').innerHTML = published;
               }
               else {
                   alert("Something went wrong!");
               }
           }
       });
   }
}

function getTimestamp(seconds) {
   var hoursLeft = Math.floor( seconds / 3600 );
   var minLeft = Math.floor(( seconds - hoursLeft * 3600 ) / 60 );
   var secondsLeft = seconds - hoursLeft * 3600 - minLeft * 60;
   secondsLeft = Math.floor(secondsLeft * 100) / 100;
   var mSecondsLeft = (secondsLeft - Math.floor(secondsLeft)) * 10;
   return (hoursLeft + ":" + ("0" + minLeft).slice(-2) + ":" + ("0" + Math.floor(secondsLeft)).slice(-2) + "." + Math.floor(mSecondsLeft))
}

function addElement(type) {
   var annotations = document.createElementNS("","annotations");
   if (annotation) {
      for (i = 0; i < annotation.length; i++) {
         annotations.appendChild(annotation[i].cloneNode(true));
      }
   }
   annotation = "";
   if (type == "note") {
      var n_ann = document.createElementNS("","annotation");
      n_ann.id = "annotation_" + Math.round(Math.random() * 1000000000);
      n_ann.setAttributeNS("","type","text");
      n_ann.setAttributeNS("","style","popup");
      var text = document.createElementNS("","TEXT");
      text.innerHTML = "Enter your text here";
      n_ann.appendChild(text);
      var segment = document.createElementNS("","segment");
      var movingRegion = document.createElementNS("","movingRegion");
      var rectRegion_1 = document.createElementNS("","rectRegion");
      rectRegion_1.setAttributeNS("","x","33"); // ME REPITES ESE NUMERÍN?!?!?!?
      rectRegion_1.setAttributeNS("","y","33"); // A MÍ ME ESTÁN JODIENDO, VAMOS MAGIC ALONSO
      rectRegion_1.setAttributeNS("","w","35");
      rectRegion_1.setAttributeNS("","h","25");
      rectRegion_1.setAttributeNS("","t",getTimestamp(Math.round(curTime * 10) / 10));
      var rectRegion_2 = document.createElementNS("","rectRegion");
      rectRegion_2.setAttributeNS("","x","33"); // OTRA VEZ????
      rectRegion_2.setAttributeNS("","y","33"); // EL NANO AE
      rectRegion_2.setAttributeNS("","w","35");
      rectRegion_2.setAttributeNS("","h","25");
      rectRegion_2.setAttributeNS("","t",getTimestamp(5 + Math.round(curTime * 10) / 10));
      movingRegion.appendChild(rectRegion_1);
      movingRegion.appendChild(rectRegion_2);
      segment.appendChild(movingRegion);
      n_ann.appendChild(segment);
      var appearance = document.createElementNS("","appearance");
      appearance.setAttributeNS("","bgAlpha","0.8");
      appearance.setAttributeNS("","bgColor","16777215");
      appearance.setAttributeNS("","fgColor","1710618");
      appearance.setAttributeNS("","textSize","3.6107");
      n_ann.appendChild(appearance);
      annotations.appendChild(n_ann);
      annotation = annotations.getElementsByTagName("annotation");
   }
   if (type == "speech") {
      var n_ann = document.createElementNS("","annotation");
      n_ann.id = "annotation_" + Math.round(Math.random() * 1000000000);
      n_ann.setAttributeNS("","type","text");
      n_ann.setAttributeNS("","style","speech");
      var text = document.createElementNS("","TEXT");
      text.innerHTML = "Enter your text here";
      n_ann.appendChild(text);
      var segment = document.createElementNS("","segment");
      var movingRegion = document.createElementNS("","movingRegion");
      var rectRegion_1 = document.createElementNS("","anchoredRegion");
      rectRegion_1.setAttributeNS("","x","33"); // ME REPITES ESE NUMERÍN?!?!?!?
      rectRegion_1.setAttributeNS("","y","39"); 
      rectRegion_1.setAttributeNS("","w","28");
      rectRegion_1.setAttributeNS("","h","5");
      rectRegion_1.setAttributeNS("","sx","32");
      rectRegion_1.setAttributeNS("","sy","58");
      rectRegion_1.setAttributeNS("","t",getTimestamp(Math.round(curTime * 10) / 10));
      var rectRegion_2 = document.createElementNS("","anchoredRegion");
      rectRegion_2.setAttributeNS("","x","33"); // OTRA VEZ????
      rectRegion_2.setAttributeNS("","y","39");
      rectRegion_2.setAttributeNS("","w","28");
      rectRegion_2.setAttributeNS("","h","5");
      rectRegion_2.setAttributeNS("","sx","32");
      rectRegion_2.setAttributeNS("","sy","58");
      rectRegion_2.setAttributeNS("","t",getTimestamp(5 + Math.round(curTime * 10) / 10));
      movingRegion.appendChild(rectRegion_1);
      movingRegion.appendChild(rectRegion_2);
      segment.appendChild(movingRegion);
      n_ann.appendChild(segment);
      var appearance = document.createElementNS("","appearance");
      appearance.setAttributeNS("","bgAlpha","0.8");
      appearance.setAttributeNS("","bgColor","16777215");
      appearance.setAttributeNS("","fgColor","1710618");
      appearance.setAttributeNS("","textSize","3.6107");
      n_ann.appendChild(appearance);
      annotations.appendChild(n_ann);
      annotation = annotations.getElementsByTagName("annotation");
   }
   if (type == "highlight") {
      var n_ann = document.createElementNS("","annotation");
      n_ann.id = "annotation_" + Math.round(Math.random() * 1000000000);
      n_ann.setAttributeNS("","type","highlight");
      var text = document.createElementNS("","TEXT");
      text.innerHTML = "Enter your text here";
      n_ann.appendChild(text);
      var segment = document.createElementNS("","segment");
      var movingRegion = document.createElementNS("","movingRegion");
      var rectRegion_1 = document.createElementNS("","rectRegion");
      rectRegion_1.setAttributeNS("","x","33"); // ME REPITES ESE NUMERÍN?!?!?!?
      rectRegion_1.setAttributeNS("","y","33"); // A MÍ ME ESTÁN JODIENDO, VAMOS MAGIC ALONSO
      rectRegion_1.setAttributeNS("","w","35");
      rectRegion_1.setAttributeNS("","h","25");
      rectRegion_1.setAttributeNS("","t",getTimestamp(Math.round(curTime * 10) / 10));
      var rectRegion_2 = document.createElementNS("","rectRegion");
      rectRegion_2.setAttributeNS("","x","33"); // OTRA VEZ????
      rectRegion_2.setAttributeNS("","y","33"); // EL NANO AE
      rectRegion_2.setAttributeNS("","w","35");
      rectRegion_2.setAttributeNS("","h","25");
      rectRegion_2.setAttributeNS("","t",getTimestamp(5 + Math.round(curTime * 10) / 10));
      movingRegion.appendChild(rectRegion_1);
      movingRegion.appendChild(rectRegion_2);
      segment.appendChild(movingRegion);
      n_ann.appendChild(segment);
      var appearance = document.createElementNS("","appearance");
      appearance.setAttributeNS("","borderAlpha","0.2");
      appearance.setAttributeNS("","bgColor","16777215");
      appearance.setAttributeNS("","highlightWidth","3");
      appearance.setAttributeNS("","textSize","3.6107");
      n_ann.appendChild(appearance);
      annotations.appendChild(n_ann);
      annotation = annotations.getElementsByTagName("annotation");
   }
   document.getElementById("annotationseditor-container-inside-items").innerHTML = "";
  loadMenu();
  annotationsVideoEditor();
}
let page = window.location.href.split('?')[0];
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

function changeURL(url) {
   document.getElementsByClassName("vlAnnotationsContainer")[0].innerHTML = "";
   if (window.XMLHttpRequest) {
   xhttp = new XMLHttpRequest();
   } else {    // IE 5/6
      xhttp = new ActiveXObject("Microsoft.XMLHTTP");
   }

   xhttp.overrideMimeType('text/xml');

   xhttp.open("GET", "/u/ann/"+ url +".xml?" + Math.round(Math.random() * 1000000000), false);
   xhttp.send(null);
   xmlDoc = xhttp.responseXML;
   if (xmlDoc !== null) {
      annotation = xmlDoc.getElementsByTagName("annotation");
      if (document.getElementsByClassName("vlAnnotations").length > 0) {
         document.getElementsByClassName("vlAnnotations")[0].style.display = "block";
      }
   }
   else {
      annotation = "";
      if (document.getElementsByClassName("vlAnnotations").length > 0) {
         document.getElementsByClassName("vlAnnotations")[0].style.display = "none";
      }
   }
   ex();
}
function colorToRGB(input) {
   input = parseInt(input)
   var r = Math.floor(input / (256*256));
   var g = Math.floor(input / 256) % 256;
   var b = input % 256;
   return "rgba("+ r +", "+ g +", "+ b +", ";
}
function colorToRGB2(input) {
   input = parseInt(input)
   var r = Math.floor(input / (256*256)) + 110;
   var g = Math.floor(input / 256) % 256 + 110;
   var b = input % 256 + 110;
   return "rgba("+ r +", "+ g +", "+ b +", ";
}
function bubbleSpecs(x, y, width, height, sx, sy, radii, gap) {
    var direction = bubbleDirection(x, y, width, height, sx, sy);
    var g = gap / 2;
    var startX = 0;
    var startY = 0;
    var endX = 0;
    var endY = 0;
    switch(direction) {
       case "top":
           var _loc16_ = 1 / 4 * width;
           if(sx < x + width / 2) {
               startX = x + Math.max(_loc16_ - g, radii[3]);
               endX = Math.min(startX + gap,x + width - radii[2]);
           } else {
               endX = x + width - Math.max(_loc16_ - g, radii[2]);
               startX = Math.max(endX - gap,x + radii[3]);
           }
           endY = null;
           startY = endY = y;
           break;
       case "bottom":
           var _loc17_ = 1 / 4 * width;
           if(sx < x + width / 2) {
               startX = x + Math.max(_loc17_ - g, radii[3]);
               endX = Math.min(startX + gap,x + width - radii[2]);
           } else {
               endX = x + width - Math.max(_loc17_ - g, radii[2]);
               startX = Math.max(endX - gap,x + radii[3]);
           }
           startY = endY = y + height;
           break;
       case "left":
           var _loc18_ = 1 / 4 * height;
           if(sy < y + height / 2) {
               startY = y + Math.max(_loc18_ - g, radii[0]);
               endY = Math.min(startY + gap,y + height - radii[3]);
           } else {
             endY = y + height - Math.max(_loc18_ - g, radii[3]);
               startY = Math.max(endY - gap,y + radii[0]);
           }
           startX = endX = x;
           break;
       case "right":
           var _loc19_ = 1 / 4 * height;
           if(sy < y + height / 2) {
               startY = y + Math.max(_loc19_ - g, radii[1]);
               endY = Math.min(startY + gap,y + height - radii[2]);
           } else {
               endY = y + height - Math.max(_loc19_ - g, radii[2]);
               startY = Math.max(endY - gap,y + radii[1]);
           }
           startX = endX = x + width;
           break;
    }

    if(direction == "bottom" || direction == "top") {
        var TARGET_W = 2.5;
        var av = (startX + endX) / 2;
        startX = av - (TARGET_W / 2);
        endX = av + (TARGET_W / 2);
    }

    if(direction == "left" || direction == "right") {
        var TARGET_H = 5;
        var av = (startY + endY) / 2;
        startY = av - (TARGET_H / 2);
        endY = av + (TARGET_H / 2)
    }
    
    return {direction: direction,
            startX: startX,
            startY: startY,
            endX: endX,
            endY: endY};
}
function bubbleDirection(x, y, width, height, sx, sy) {
    if(sx < x) {
        if(sy < y) {
            return x - sx <= y - sy ? "top" : "left";
        }
        if(sy > y + height) {
            return x - sx <= sy - (y + height) ? "bottom" : "left";
        }
        return "left";
    }
    if(sx > x + width) {
        if(sy < y) {
            return sx - (x + width) <= y - sy ? "top" : "right";
        }
        if(sy > y + height) {
            return sx - (x + width) <= sy - (y + height) ? "bottom" : "right";
        }
        return "right";
    }
    if(sy < y) {
        return "top";
    }
    if(sy > y + height) {
        return "bottom";
    }
}
function changeopacity(e,o,a,s) {
   if (s == 1) {
      var bg = "linear-gradient("+ colorToRGB2(o) + (a * 100 + 5) +") 0%," + colorToRGB(o) + (a * 100 + 5) + ") 30%)";
   } 
   else {
      var bg = "linear-gradient("+ colorToRGB2(o) + a +") 0%," + colorToRGB(o) + a + ") 30%)";
   }
   e.style.backgroundImage = bg;
}

function annotationsVideo() {
   for (i = 0; i < annotation.length; i++) {
      var id = annotation[i].id;

      if (annotation[i].getAttribute("style") != "speech") {

         var from = annotation[i].getElementsByTagName('rectRegion')[0].getAttribute('t');
         if (from != "never") {
            from = (from.substring(0,1) * 3600) + (from.substring(2,4) * 60) + parseInt(from.substring(5,7)) + (from.substring(8) / 10);
            from == 0 ? from = 0.0001 : from = from;
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

         if (curTime >= from && curTime <= to) {
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
               contents += '<span class="linkIcon"></span>';
            }
            if (annotation[i].getAttribute("type") == "highlight") {
               a_class += ' highlightAn c_' + annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgColor');
               border = "border:" + annotation[i].getElementsByTagName('appearance')[0].getAttribute('highlightWidth') + "px solid "+ colorToRGB(annotation[i].getElementsByTagName('appearance')[0].getAttribute('bgColor')) +" "+ annotation[i].getElementsByTagName('appearance')[0].getAttribute('borderAlpha') +")";
            }

            if (annotation[i].getAttribute("style") == "highlightText") {
               return false;
            }
            if (!document.getElementById(id)) {
               document.getElementsByClassName('vlAnnotationsContainer')[0].innerHTML+='<div class="annotation'+a_class+'" id="'+ id +'" onclick="'+ onclick +'" onmouseover="'+ onmouseover +'" onmouseout="'+ onmouseout +'" style="background: '+ bg +'; color: '+ fg +'; font-size: '+ fs +'px; left: '+ x +'%; top: '+ y +'%; width: ' + width + '%; height: '+ height +'%;'+ border +'"><span>'+ contents +'</span></div>';
            }
            else {
               if (document.getElementsByClassName("vlPlayer")[0].classList.contains("playing") || document.getElementsByClassName("vlPlayer")[0].classList.contains("full")) {
                  document.getElementById(id).style.fontSize = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * document.getElementsByClassName('vlAnnotationsContainer')[0].offsetHeight / 100) + "px";
               }
               else {
                  if (document.getElementsByClassName("vlPlayer")[0].classList.contains("expanded")) {
                     document.getElementById(id).style.fontSize = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * 480 / 100) + "px";
                  }
                  else {
                     document.getElementById(id).style.fontSize = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * 360 / 100) + "px";
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
            from == 0 ? from = 0.0001 : from = from;
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

         if (curTime >= from && curTime <= to) {
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
                  var fs = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * document.getElementsByClassName('vlAnnotationsContainer')[0].offsetHeight / 100);
               }
               else {
                  document.getElementById(id + "_textarea").style.fontSize = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * 360 / 100) + "px";
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
            var ac = document.querySelector(".vlAnnotationsContainer");
            var bounds = ac.getBoundingClientRect();
            if (!document.getElementById(id)) {
               document.getElementsByClassName('vlAnnotationsContainer')[0].innerHTML+='<div class="annotation'+a_class+'" id="'+ id +'" onclick="'+ onclick +'" onmouseover="'+ onmouseover +'" onmouseout="'+ onmouseout +'" style="background-image: '+ bg +'; color: '+ fg +'; font-size: '+ fs +'px; left: '+ x +'%; top: '+ y +'%; width: ' + width + '%;height: ' + height + '%;;background-position: 0 0"><span>'+ contents +'</span></div>';
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
            } 
            else {
               if (document.getElementsByClassName("vlPlayer")[0].classList.contains("playing") || document.getElementsByClassName("vlPlayer")[0].classList.contains("full")) {
                  document.getElementById(id).style.fontSize = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * document.getElementsByClassName('vlAnnotationsContainer')[0].offsetWidth * 0.5625 / 100) + "px";
               }
               else {
                  if (document.getElementsByClassName("vlPlayer")[0].classList.contains("expanded")) {
                     document.getElementById(id).style.fontSize = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * 480 / 100) + "px";
                     bounds.height = 480;
                  }
                  else {
                     document.getElementById(id).style.fontSize = (annotation[i].getElementsByTagName('appearance')[0].getAttribute('textSize') * 360 / 100) + "px";
                  }
               }
            }
         }
         else {
            if (document.getElementById(id)) {
               document.getElementById(id).outerHTML = "";
               document.getElementById(id + "_tip").outerHTML = "";
            }
         }

      }
   }
}

function ex() {
   if (!page.includes("my_videos_annotations")) {
      if (annotation) {
         annotationsVideo();
      }
   }
   else {
      annotationsVideoEditor();
   }
}
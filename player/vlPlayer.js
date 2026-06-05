function VLPlayer(args) {
	var obj;
	var player;
	var hiddenDiv;
	var hiddenUrl;
	var video;
	var screen;
	var screenDiv;
	var previewDiv;
	var loadDiv;
	var playDiv;
	var controlsDiv;
	var controlsLeft;
	var controlsCenter;
	var controlsRight;
	var separator;
	var playBt;
	var stopBt;
	var progressBar;
	var position;
	var seeker;
	var buffer;
	var timer;
	var elapsed;
	var total;
	var volumeBar;
	var volumeMute;
	var volumeSlider;
	var volumeContainer;
	var volumeContainerAbsolute;
	var saveHide;
	var expandScreen;
	var fullScreen;
	var closeFullS;	
	var loadDivInt;
	var expandScreenInt;
	var fullScreenInt;
	var resizeInt;
	var seekerInt;
	var volumeInt;
	var mouseInt;
	var mouseX;
	var mouseY;
	var oldWidth;
	var lastVol;
	var mp4mime;
	var menu;
	
	/* === PRE-INITIALIZE === */
	// Set default values
	player = this;
	mouseX = 0;
	mouseY = 0;
	lastVol = 0;
	oldWidth = 0;
	video = $('<video></video>');
	mp4mime = 'video/mp4; codecs="avc1.42E01E, mp4a.40.2"';
	obj = args.id ? args.id : $(".vlPlayer:last");
	obj.empty();
	
	// Check for HTML5 Support
	if (!video[0].canPlayType || !video[0].canPlayType(mp4mime)) {
		obj.addClass("error");
		obj.html('<span>Your browser does not support the BitView player.<br>\
			Please, consider upgrading or switching to Flash Player in your settings.</span>');
			
		return false;
	}

	/* === METHODS === */	
	// Toggles Play/Pause
	this.toggle = function() {
		if (obj.hasClass("playing")) player.pause();
		else player.play();
	}
	
	// Plays Video
	this.play = function() {
		if (!video[0].hasAttribute("src"))
			video.attr("src", src);
		
		obj.addClass("playing started");
		
		try {
			video[0].play()
		} catch(e) {
			// Exception Prevention
		}
		
		$(document).mousemove();
	}
	
	// Pauses Video
	this.pause = function() {
		obj.removeClass("playing");
		video[0].pause();
		
		$(document).mousemove();
	}
	
	// Stops Video
	this.stop = function() {
		player.pause();
		player.seek(0);
		obj.removeClass("started");
	}
	
	// Change Video
	this.change = function(newArgs) {
		player.stop();
		videoUrl = newArgs.videoUrl ? newArgs.videoUrl : null;
		duration = newArgs.duration ? newArgs.duration : 0;
		preview = newArgs.preview ? newArgs.preview : "";
		start = newArgs.start ? newArgs.start : 0;
		player.loadPreview();
		
		total.html(player.format(duration));
		buffer.css("width", "0%");
		video.attr("src", newArgs.src);
		
		if (newArgs.autoplay)
			player.play();
	}
	
	// Calculate Seeking Position
	this.calcSeek = function() {
		if (duration == 0) return 0;
		var ml;
		var w;
		
		ml = parseInt(seeker.css("margin-left"));
		w = progressBar.width();
		
		return (ml / w) * duration;
	}
	
	// Seeks Video
	this.seek = function(t) {
		if (t < 0) t = 0;
		if (t > duration) t = duration;
		
		try {
			video[0].currentTime = t;
		} catch(e) {
			// Exception Prevention
		}
		
		elapsed.html(player.format(t));
		t = (t / duration) * 100;		
		position.css("width", t+"%");
		seeker.css("margin-left", t+"%");
	}
	
	// Sets Volume
	this.setVolume = function(v) {
		if (v < 0) v = 0;
		if (v > 1) v = 1;
		
		video[0].volume = v;
		volumeSlider.css("margin-left", (v*100)+"%");		
		obj.removeClass("vol25 vol50 vol75 muted");
		
		if (v == 0) obj.addClass("muted");
		else if (v < 0.25) obj.addClass("vol25");
		else if (v < 0.50) obj.addClass("vol50");
		else if (v < 0.75) obj.addClass("vol75");
		
		if (Storage !== void(0))
			localStorage.lastVol = video[0].volume;
	}
	
	// Mutes Video
	this.mute = function() {
		obj.addClass("muted");
		lastVol = video[0].volume;
		player.setVolume(0);
	}

	// Unmutes Video
	this.unmute = function() {
		obj.removeClass("muted");
		if (lastVol == 0) lastVol = 1;
		player.setVolume(lastVol);
	}
	
	// Toggles Mute
	this.toggleMute = function() {
		if (obj.hasClass("muted")) player.unmute();
		else player.mute();
	}
	
	// Formats time display
	this.format = function(n) {
		var sec;
		var min;
		var hrs;
		
		this.parse = function(v) {
			v = parseInt(v);
			if (v < 10) return "0"+v;
			if (v > 99) return 99;
			return v;
		}
		
		sec = this.parse(n % 60);
		min = this.parse(n / 60);
		hrs = this.parse(n / 3600);
		
		if (hrs == "00") {
			return min+":"+sec;
		} else {
			return hrs+":"+min+":"+sec;
		}
	}
	
	// Toggles Full Screen
	this.toggleFull = function() {
		var requests;
		var playerObj;
		var isFull;
		
		if (!obj.hasClass("full")) {
			requests = [
				"requestFullscreen",
				"mozRequestFullScreen",
				"webkitRequestFullscreen",
				"msRequestFullscreen"
			];
			
			isFull = false;
		} else {
			requests = [
				"exitFullscreen",
				"mozCancelFullScreen",
				"webkitExitFullscreen",
				"msExitFullscreen"
			];
			
			isFull = true;
		}
		
		playerObj = obj[0];
		for (var i=0; i < requests.length; i++) {
			if (isFull) {
				if (requests[i] in document) {
					document[requests[i]]();
					return;
				}
			} else {
				if (requests[i] in playerObj) {
					playerObj[requests[i]]();
					return;
				}
			}
		}
		
		alert("Your browser does not support full-screen mode!");
	}
	
	// Preloads Preview Image Before Showing
	this.loadPreview = function() {
		previewDiv.css("background-image", "");
		if (preview == "") return false;
		
		$("<img />").attr("src", preview).on("load", function() {
			previewDiv.css("background-image", "url("+preview+")");
		});
	}
	
	// Caches skin beforehand to avoid display glitches
	this.preloadSkin = function(css, imgPath, done) {
		var loaded = 0;
		var linkrel;
		var bt_imgs;
		
		// Load skin CSS style and append to head
		linkrel = $('<link rel="stylesheet"></link>');
		linkrel.attr("href", css);
		linkrel.on("load", function() {
			bt_imgs = [
				"loop.png",
				"buttons_"+buttonColor+".png",
				"play"+(background == "black" ? "_black" : "")+".png",
				"full"+(background == "black" ? "_black" : "")+".png",
				"buffer.png"
			];
			
			for (var i=0; i < bt_imgs.length; i++) {
				$("<img />").attr('src', imgPath+bt_imgs[i]).on("load", function() {
					hiddenDiv.append($(this));
					if ((loaded += 1) == bt_imgs.length) {
						if (buttonColor != "red") obj.addClass(buttonColor+"Bt");
						if (background != "white") obj.addClass(background+"Bg");
						obj.addClass("initialized");
						player.loadPreview();
						done();
					}
				});
			}
		});
		
		$("head").append(linkrel);
	}
	
	// Change button color
	this.changeButtonColor = function(btc) {
		obj.removeClass("redBt orangeBt goldBt oliveBt greenBt tealBt blueBt violetBt pinkBt magentaBt whiteBt");
		obj.addClass(btc+"Bt");
	}
	
	// Change background color
	this.changeBackground = function(bg) {
		obj.removeClass("redBg orangeBg goldBg oliveBg greenBg tealBg blueBg violetBg pinkBg magentaBg whiteBg blackBg");
		obj.addClass(bg+"Bg");
	}
	
	// Checks if player size has been changed and adjust
	this.checkResize = function() {
		if (oldWidth != obj.width()) {
			oldWidth = obj.width();
			player.resize();
		}
	}
	
	/* === EVENT HANDLERS === */	
	// Show Buffering
	this.showBuffer = function() {
		if (!obj.hasClass("playing")) return;
		if (loadDivInt != null) return;
		var deg = 0;
		
		loadDiv.show();
		loadDivInt = setInterval(function() {
			if (deg == 360) deg = 0;
			loadDiv.css("transform", "rotate("+deg+"deg)");
			deg += 45;
		}, 77);
	}
	
	// Hide Buffering
	this.hideBuffer = function() {
		if (loadDivInt == null) return;
		clearInterval(loadDivInt);
		loadDiv.hide();
		loadDivInt = null;
	}
	
	// When Mouse Hovers Volume (Compact)
	this.showVolume = function() {
		saveHide = false;
		obj.removeClass("hideVol");
	}
	
	// When Mouse Leaves Volume (Compact)
	this.hideVolume = function() {
		if (volumeInt != null) {
			saveHide = true;
			return;
		}
		
		obj.addClass("hideVol");
	}
	
	// When Duration is changed
	this.changeDuration = function() {
		duration = video[0].duration;
		total.html(player.format(duration));
		if (start) player.seek(start);
	}
	
	// When Seeker is moved
	this.seekTo = function(e) {
		if (seekerInt != null) return;
		if (e.which != 1) return;
		var click = (e.type == "click");
		var mx;
		var w;
		
		seeker.addClass("active");
		seekerInt = setInterval(function() {
			mx = mouseX - progressBar.offset().left;
			wi = progressBar.width()-1;
			
			if (mx < 0) mx = 0;
			if (mx > wi) mx = wi;
			
			seeker.css("margin-left", mx);
			elapsed.html(player.format(player.calcSeek()));
			if (click) $(document).mouseup();
		}, 26);
	}
	
	// Control Seeker with Keys
	this.seekKey = function(e) {
		var vt = video[0].currentTime;
		if (e.keyCode == 37) { // Left
			player.seek(vt-1);
			return false;
		} else if (e.keyCode == 39) { // Right
			player.seek(vt+1);
			return false;
		} else if (e.keyCode == 32) { // Spacebar
			player.toggle();
			return false;
		}
	}
	
	// When Volume Slider is moved
	this.volumeTo = function(e) {
		if (volumeInt != null) return;
		if (e.which != 1) return;
		var click = (e.type == "click");
		var mx;
		var w;
		var p;
		
		volumeInt = setInterval(function() {
			mx = mouseX - volumeBar.offset().left;
			wi = volumeBar.width()-1;
			
			if (mx < 0) mx = 0;
			if (mx > wi) mx = wi;
			
			p = mx / wi;
			player.setVolume(p);
			if (click) $(document).mouseup();
		}, 26);
	}
	
	// Control Volume with Keys
	this.volumeKey = function(e) {
		var vol = video[0].volume;
		if (e.keyCode == 37) { // Left
			player.setVolume(vol-0.05);
			return false;
		} else if (e.keyCode == 39) { // Right
			player.setVolume(vol+0.05);
			return false;
		} else if (e.keyCode == 32) { // Spacebar
			player.toggleMute();
			return false;
		}
	}
	
	// When the video is buffering
	this.bufferUpdate = function() {
		var current = video[0].currentTime;
		var buffers = video[0].buffered;
		var length = buffers.length;
		var buffered;
		
		if (length == 0) return;
		if (Math.round(buffers.end(0)) != Math.round(duration)) {
			for (var i=length-1; i >= 0; i--) {
				if (current >= buffers.start(i) && current <= buffers.end(i)) {
					buffered = (buffers.end(i) / duration) * 100;
					buffer.css("width", buffered+"%");
					break;
				}
			}
		} else {
			buffer.css("width", "100%");
		}
	}
	
	// When the video is actually playing
	// Updates Seeker and Position Bar
	this.timeUpdate = function() {
		var e = video[0].currentTime;
		var d = video[0].duration;
		var p = (e / d) * 100;
		
		position.css("width", p+"%");
		if (seekerInt == null) {
			seeker.css("margin-left", p+"%");
			elapsed.html(player.format(e));
		}
		
		player.bufferUpdate();
	}
	
	// When the video ends
	this.ended = function() {
		if (endedFunc) endedFunc();
		if (obj.hasClass("loop")) {
			player.seek(0);
			player.play();
		} else {
			player.stop();
		}
	}
	
	// When Expand Screen Button is focused
	// Play animation
	this.startExpAnim = function() {
		if (expandScreenInt != null) return;
		
		var i = 1;
		expandScreenInt = setInterval(function() {
			if (i == 4) i = 0;
			if (i < 3) {
				expandScreen.css("background-position", "-"+(220+i*22)+"px 0px");
			} else {
				expandScreen.css("background-position", "");
			}
			
			i++;
		}, 100);
	}
	
	// When Expand Screen Button is not focused
	// Stop animation
	this.stopExpAnim = function() {
		if (expandScreenInt == null) return;
		
		clearInterval(expandScreenInt);
		expandScreen.css("background-position", "");
		expandScreenInt = null;
	}
	
	// When Full Screen Button is focused
	// Play animation
	this.startFullAnim = function() {
		if (fullScreenInt != null) return;
		
		var i = 1;
		var p = 1;
		fullScreenInt = setInterval(function() {
			if (i == 10) {
				i = 0;
				p = 0;
			} else if (p >= 5 && p <= 8) {
				p++;
				return;
			} 

			fullScreen.css("background-position", "-"+(i*22)+"px 0px");
			i++;
			p++;
		}, 77);
	}
	
	// When Full Screen Button is not focused
	// Stop animation
	this.stopFullAnim = function() {
		if (fullScreenInt == null) return;
		
		clearInterval(fullScreenInt);
		fullScreen.css("background-position", "");
		fullScreenInt = null;
	}
	
	// When Browser Enters/Exits Full Screen
	this.fullChange = function() {
		var requests;
		
		requests = [
			"fullscreenElement",
			"mozFullScreenElement",
			"webkitFullscreenElement",
			"msFullscreenElement"
		];
		
		for (var i=0; i < requests.length; i++) {
			if (requests[i] in document) {
				if (document[requests[i]]) obj.addClass("full");
				else obj.removeClass("full");
				break;
			}
		}
		
		if (obj.hasClass("full"))
			$(document).mousemove();
	}
	
	// Saves mouse position and hides controls on Full Screen
	this.mouseMove = function(e) {
		mouseX = e.pageX;
		mouseY = e.pageY;
		
		if (obj.hasClass("full")) {
			if (mouseInt != null)
				clearTimeout(mouseInt);
			
			obj.removeClass("hidemouse");
			mouseInt = setTimeout(function() {
				if (obj.hasClass("playing")) {
					obj.addClass("hidemouse");
				} else {
					obj.removeClass("hidemouse");
				}
				
				mouseInt = null;
			}, 2000);
		}
	}
	
	// Prevents selection glitches
	this.mouseDown = function(e) {
		if (!$(e.target).is("button"))
			return false;
	}
	
	// Cleans up other events
	this.mouseUp = function(e) {
		obj.find("button").blur();
		
		if (seekerInt != null) {
			clearInterval(seekerInt);
			seekerInt = null;
			seeker.removeClass("active");
			
			if (duration != 0) {
				player.seek(player.calcSeek());
				if (!obj.hasClass("started")) player.play();
			} else {
				seeker.css("margin-left", 0);
			}
		}
		
		if (volumeInt != null) {
			clearInterval(volumeInt);
			volumeInt = null;
			
			if (saveHide) player.hideVolume();
		}
	}
	
	// Adjusts player to Window Size
	this.resize = function() {
		obj.removeClass("compact hideTimer");
		if (controlsCenter.width() < 100) {
			obj.addClass("compact hideVol");
			if (controlsCenter.width() < 100) {
				obj.addClass("hideTimer");
			}
		}
	}
	
	// Shows Fake Context Menu
	this.context = function(e) {
		if (menu != null) menu.remove();
		
		// Create List
		var lX = e.clientX;
		var lY = e.clientY;
		var index = -1;
		var items = {
			copy: "Copy URL",
			copyT: "Copy URL at current time",
			efull: "Enter Full Screen",
			cfull: "Exit Full Screen",
			loop: "Loop",
			mute: "Mute",
			vlp: "vlPlayer for BitView"
		};
		
		menu = $('<ul class="vlPlayerMenu" tabindex="0"></ul>');
		menu.css({'left': lX, 'top': lY});
		
		// Append List
		for (var i in items) {
			items[i] = $('<li tabindex="-1">'+items[i]+'</li>');
			menu.append(items[i]);
		}
		
		// Add event handlers
		menu.blur(function() {
			if (menu != null) {
				menu.remove();
				menu = null;
			}
		});
		
		menu.contextmenu(function() {
			menu.remove();
			menu = null;
			return false;
		});
		
		menu.children().mouseenter(function() {
			menu.trigger("mouseleave");
			$(this).addClass("hover");
		});
		
		menu.mouseleave(function() {
			menu.children().removeClass("hover");
		});
		
		menu.keydown(function(e) {
			var kc = e.keyCode;
			var length = menu.children().length;
			switch(kc) {
				case 27: //Esc
					menu.blur();
					playDiv.focus();
					break;
				case 32: //Space
					menu.children().eq(index).click();
					playDiv.focus();
					break;
				case 38: //Up
					index--;
					if (index < 0 || index >= length)
						index = length-1;
					
					menu.trigger("mouseleave");
					menu.children().eq(index).addClass("hover");
					break;
				case 40: //Down
					index++;
					if (index < 0 || index >= length)
						index = 0;
					
					menu.trigger("mouseleave");
					menu.children().eq(index).addClass("hover");
			}
			
			return false;
		});

		items.copy.click(function() {
			hiddenUrl.val(videoUrl);
			hiddenUrl.focus().select();
			document.execCommand("copy");
			hiddenUrl.blur();
		});
		
		items.copyT.click(function() {
			var t = Math.round(video[0].currentTime);
			hiddenUrl.val(videoUrl+"#t="+t);
			hiddenUrl.focus().select();
			document.execCommand("copy");
			hiddenUrl.blur();
		});
		
		items.loop.click(function() {
			obj.toggleClass("loop");
			menu.blur();
		});
		
		items.mute.click(function() {
			player.toggleMute();
			menu.blur();
		});
		
		items.efull.click(function() {
			player.toggleFull();
			menu.blur();
		});
		
		items.cfull.click(function() {
			player.toggleFull();
			menu.blur();
		});
		
		// Adjust List
		if (obj.hasClass("loop"))
			items.loop.addClass("checked");
		
		if (obj.hasClass("muted"))
			items.mute.addClass("checked");
		
		if (obj.hasClass("full")) {
			items.efull.remove();
		} else {
			items.cfull.remove();
		}
		
		if (!videoUrl) {
			items.copy.remove();
			items.copyT.remove();
		}
		
		// Show Menu
		menu.mousedown(function() { return false; });
		menu.animate({"opacity":1}, 250);
		obj.append(menu);
		
		// Fix X and Y
		if (lX + menu.width() > $(window).width()) {
			if ((lX = lX - menu.width()) < 0) lX = 0;
			menu.css('left', lX);
		}
		
		if (lY + menu.height() > $(window).height()) {
			if ((lY = lY - menu.height()) < 0) lY = 0;
			menu.css('top', lY);
		}
		
		menu.focus();		
		return false;
	}
	
	// Shows Error Message
	this.error = function() {
		obj.unbind();
		obj.addClass("error");
		obj.html('<span>An error has occurred.<br>\
			Please, refresh and try again in a while.</span>');
			
		clearInterval(resizeInt);
	}
	
	/* === INITIALIZE === */
	// Parse Arguments
	var src = args.src;
	var preview = "preview" in args ? args.preview : "";
	var duration = "duration" in args ? args.duration : 0;
	var start = "start" in args ? args.start : 0;
	var autoplay = args.autoplay ? true : false;
	var videoUrl = args.videoUrl ? args.videoUrl : null;
	var skinCss = args.skin;
	var skinImg = skinCss.substr(0, skinCss.lastIndexOf("/"))+"/img/";
	var endedFunc = args.ended ? args.ended : null;
	var buttonColor = args.btcolor ? args.btcolor : "teal";
	var background = args.bgcolor ? args.bgcolor : "white";
	var complete = args.complete;
	
	// Create player objects
	screen = $('<div class="vlScreen"></div>');
	hiddenDiv = $('<div class="vlPreload"></div>');
	hiddenUrl = $('<input type="text" tabindex="-1" />');
	loadDiv = $('<div class="vlsLoad"></div>');
	playDiv = $('<button class="vlsPlay" tabindex="-1"></button>');
	previewDiv = $('<div class="vlPreview"></div>');
	screenDiv = $('<div class="vlScreenContainer"></div>');
	controlsDiv = $('<div class="vlControls"></div>');
	controlsLeft = $('<div class="vlcLeft"></div>');
	controlsCenter = $('<div class="vlcCenter"></div>');
	controlsRight = $('<div class="vlcRight"></div>');
	separator = $('<div class="vlSeparator"></div>');
	playBt = $('<button class="vlcPlay"></button>');
	stopBt = $('<button class="vlcStop"></button>');
	progressBar = $('<div class="vlProgress" tabindex="0"></div>');
	position = $('<div class="vlPosition"></div>');
	seeker = $('<button class="vlSeeker" tabindex="-1"></button>');
	buffer = $('<div class="vlBuffer"></div>');
	timer = $('<div class="vlTimer"> / </div>');
	elapsed = $('<span class="vltPos">00:00</span>');
	total = $('<span class="vltDur">'+this.format(duration)+'</span>');
	volumeBar = $('<div class="vlcSoundBar" tabindex="-1"></div>');
	volumeMute = $('<button class="vlcSound" tabindex="-1"></button>');
	volumeSlider = $('<button class="vlcSoundSlider" tabindex="-1"></button>');
	volumeContainer = $('<span class="vlcSoundContainer" tabindex="0"></span>');
	volumeContainerAbsolute = $('<span class="vlcSoundContainerAbsolute"></span>');
	expandScreen = $('<button class="vlcExpand"></button>');
	fullScreen = $('<button class="vlcFull"></button>');
	closeFullS = $('<button class="vlcCloseFull"></button>');
	
	// Append created objects
	obj.append(hiddenDiv);
	obj.append(screenDiv);
	obj.append(controlsDiv);
	hiddenDiv.append(hiddenUrl);
	screenDiv.append(screen);
	screen.append(previewDiv);
	screen.append(loadDiv);
	screen.append(playDiv);
	screen.append(video);
	controlsDiv.append(controlsLeft);
	controlsDiv.append(controlsCenter);
	controlsDiv.append(controlsRight);
	controlsLeft.append(playBt);
	controlsLeft.append(stopBt);
	controlsCenter.append(progressBar);
	controlsRight.append(timer);
	controlsRight.append(separator.clone());
	controlsRight.append(volumeContainer);
	controlsRight.append(separator.clone());
	controlsRight.append(expandScreen);
	controlsRight.append(fullScreen);
	controlsRight.append(closeFullS);
	volumeContainer.append(volumeContainerAbsolute);
	volumeContainerAbsolute.append(volumeBar);
	volumeContainer.append(volumeMute);
	volumeBar.append(volumeSlider);
	progressBar.append(position);
	progressBar.append(seeker);
	progressBar.append(buffer);
	timer.prepend(elapsed);
	timer.append(total);
	
	// Assign events
	obj.contextmenu(this.context);
	obj.mousedown(this.mouseDown);
	playBt.click(this.toggle);
	playDiv.click(this.toggle);
	playDiv.dblclick(this.toggleFull);
	stopBt.click(this.stop);
	volumeMute.click(this.toggleMute);
	fullScreen.click(this.toggleFull);
	fullScreen.on("mouseenter focus", this.startFullAnim);
	fullScreen.on("mouseleave blur", this.stopFullAnim);
	expandScreen.on("mouseenter focus", this.startExpAnim);
	expandScreen.on("mouseleave blur", this.stopExpAnim);
	closeFullS.click(this.toggleFull);
	progressBar.keydown(this.seekKey);
	progressBar.click(this.seekTo);
	progressBar.mousedown(this.seekTo);
	position.mousedown(this.seekTo);
	position.click(this.seekTo);
	seeker.mousedown(this.seekTo);
	buffer.mousedown(this.seekTo);
	volumeContainer.focus(this.showVolume);
	volumeContainer.mouseenter(this.showVolume);
	volumeContainer.mouseleave(this.hideVolume);
	volumeContainer.blur(this.hideVolume);
	volumeContainer.keydown(this.volumeKey);
	volumeSlider.mousedown(this.volumeTo);
	volumeBar.mousedown(this.volumeTo);
	volumeBar.click(this.volumeTo);
	video.on("durationchange", this.changeDuration);
	video.on("timeupdate", this.timeUpdate);
	video.on("progress", this.bufferUpdate);
	video.on("waiting", this.showBuffer);
	video.on("playing canplay canplaythrough timeupdate pause", this.hideBuffer);
	video.on("ended", this.ended);
	video.on("error", this.error);
	$(document).on("webkitfullscreenchange mozfullscreenchange MSFullscreenChange fullscreenchange", this.fullChange);
	$(document).keydown(this.mouseMove);
	$(document).mousemove(this.mouseMove);
	$(document).mouseup(this.mouseUp);
	
	if (args.expand) {
		expandScreen.click(args.expand);
	} else {
		expandScreen.hide();
	}
	
	// Set volume to last saved
	if (Storage !== void(0) && localStorage.lastVol) {
		player.setVolume(localStorage.lastVol);
	}
	
	// Show Player
	this.preloadSkin(skinCss, skinImg, function() {
		player.resize();
		resizeInt = setInterval(player.checkResize, 200);
		
		if (autoplay) player.play();
		if (complete) complete();
		if (start) player.seek(start);
	});
}
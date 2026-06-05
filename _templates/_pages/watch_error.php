<link rel="stylesheet" href="/css/watch.css">
<div id="content" class="">
    <div id="watch-container">
  <div id="watch-headline-container">
    <div id="watch-headline" class="watch-headline">
      <h1 id="watch-headline-title">
      </h1>
      <div id="watch-headline-user-info">
      </div>
    </div>
  </div>
  <div id="watch-video-container">
    <div id="watch-video">
      <div id="watch-player" class="flash-player wm-videoplayer">
        <div id="watch-player-unavailable">
          <div id="watch-player-unavailable-message">
            <div id="watch-player-unavailable-icon-container">
              <img src="/img/meh.png">
            </div>
            <div id="watch-player-unavailable-message-container">
                <div><?= $ErrorMessage ?></div>
                  <div class="watch-unavailable-submessage"><?= $LANGS['sorryaboutthat'] ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="watch-main-container">
    <div id="watch-main">
      <div id="watch-panel">
        <div id="watch-actions">
                    <div id="watch-actions-more">
                        <button type="button" id="watch-insight-button" disabled="True" class="yt-uix-tooltip reverse master-sprite yt-uix-button yt-uix-tooltip" role="button" onclick="return false;" aria-pressed="false" data-tooltip="Show video statistics" data-tooltip-timer="4337"><img class="yt-uix-button-icon-watch-insight" src="/img/pixel.gif" alt=""> </button>
                    </div>
<div id="watch-actions-left">
<span class="yt-uix-button-group">
<button id="watch-like" disabled="True" class="master-sprite-new yt-uix-button yt-uix-tooltip start reverse"  onclick="; return false;" type="button">
    <img class="yt-uix-button-icon-watch-like" src="/img/pixel.gif" alt="">
<span class="yt-uix-button-content"><?= $LANGS['like'] ?></span>
</button><button id="watch-unlike" disabled="True" class="master-sprite-new yt-uix-button yt-uix-tooltip end reverse" onclick=";return false;" type="button">
    <img class="yt-uix-button-icon-watch-unlike" src="/img/pixel.gif" alt="">
</button>
</span>
<span class="yt-uix-button-group">
<button type="button" class="master-sprite start reverse yt-uix-button yt-uix-tooltip" id="yt-uix-button-aOYAaZ1e" disabled="True" onclick=";return false;" role="button"><img class="yt-uix-button-icon-addto" src="/img/pixel.gif" alt=""> <span class="yt-uix-button-content"><span class="addto-label"><?= $LANGS['addto'] ?></span></span></button><button id="watch-playlists-button" disabled="True" class="end yt-uix-button yt-uix-tooltip" onclick="; return false;" type="button">
<img class="yt-uix-button-arrow" src="/img/pixel.gif" alt="">
</button>
</span>
<button id="watch-share" class="master-sprite-new yt-uix-button yt-uix-tooltip" onclick="return false;" disabled="True" type="button">
<span class="yt-uix-button-content"><?= $LANGS['share'] ?></span>
</button>
<button id="watch-embed" class="yt-uix-button yt-uix-tooltip" onclick="return false;" disabled="True" type="button">
    
<span class="yt-uix-button-content"><?= $LANGS['embed'] ?></span>
    
</button>
<button id="watch-flag" class="master-sprite-new yt-uix-button yt-uix-tooltip" disabled="True" onclick="return false; return false;" type="button">
    <img class="yt-uix-button-icon-watch-flag" src="/img/pixel.gif" alt="">
    
</button>
</div>

<div class="clearR"></div>
    </div>
      </div>
      <div id="watch-sidebar">
          <div id="branded-playlist-module" class="watch-module">
    <div class="watch-module-body">
      <div style="border-top:solid 1px #ccc;"></div>
    </div>
  </div>

      </div>
      <div class="clear"></div>
    </div>
  </div>
</div>

  </div>
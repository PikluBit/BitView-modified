<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
?>

<div class="watch-actions-embed" id="watch-actions-embed-inside">
    <div class="close-button" onclick="hideDiv(this);"></div>
<input id="embed_code" name="embed_code" type="text" value='<iframe id="embedplayer" src="https://www.bitview.net/embed?v=<?= $_GET["url"] ?>" width="425" height="344" allowfullscreen scrolling="off" frameborder="0"></iframe>' onclick="javascript:document.embedForm.embed_code.focus();document.embedForm.embed_code.select();" readonly=""><br>
<img src="/img/pixel.gif" class="embed-sprite" id="watch-customize-embed-theme-preview">
<p id="watch-customize-embed-desc" style="padding: 0 6px; height: 64px;">
    <?= $LANGS['customizedesc'] ?>
</p>
<div style="border-top: 1px solid #ccc;"></div>
    <div id="watch-customize-embed-theme-swatches">
        <a id="watch-embed-theme-blank" data-color1="b1b1b1" data-color2="cfcfcf" class="embed-radio-link embed-sprite selected" onclick="updateEmbed(this)">
            <img src="/img/pixel.gif">
        </a>
        <a id="watch-embed-theme-storm" data-color1="3a3a3a" data-color2="999999" class="embed-radio-link embed-sprite" onclick="updateEmbed(this)">
            <img src="/img/pixel.gif">
        </a>
        <a id="watch-embed-theme-iceberg" data-color1="2b405b" data-color2="6b8ab6" class="embed-radio-link embed-sprite" onclick="updateEmbed(this)">
            <img src="/img/pixel.gif">
        </a>
        <a id="watch-embed-theme-acid" data-color1="006699" data-color2="54abd6" class="embed-radio-link embed-sprite" onclick="updateEmbed(this)">
            <img src="/img/pixel.gif">
        </a>
        <a id="watch-embed-theme-green" data-color1="234900" data-color2="4e9e00" class="embed-radio-link embed-sprite" onclick="updateEmbed(this)">
            <img src="/img/pixel.gif">
        </a>
        <a id="watch-embed-theme-orange" data-color1="e1600f" data-color2="febd01" class="embed-radio-link embed-sprite" onclick="updateEmbed(this)">
            <img src="/img/pixel.gif">
        </a>
        <a id="watch-embed-theme-pink" data-color1="cc2550" data-color2="e87a9f" class="embed-radio-link embed-sprite" onclick="updateEmbed(this)">
            <img src="/img/pixel.gif">
        </a>
        <a id="watch-embed-theme-purple" data-color1="402061" data-color2="9461ca" class="embed-radio-link embed-sprite" onclick="updateEmbed(this)">
            <img src="/img/pixel.gif">
        </a>
        <a id="watch-embed-theme-rubyred" data-color1="5d1719" data-color2="cd311b" class="embed-radio-link embed-sprite" onclick="updateEmbed(this)">
            <img src="/img/pixel.gif">
        </a>
        <div class="clearL"></div>
    </div>

    <div style="border-top: 1px solid #ccc;"></div>

    <div id="watch-customize-embed-size">
        <a id="watch-embed-size-radio-default" class="embed-radio-link" onclick="updateEmbed(this)">
            <span id="watch-embed-size-text-default">320x265</span>
            <div id="watch-embed-size-default-box" class="watch-embed-radio-box"></div>
        </a>
        <a id="watch-embed-size-radio-medium" class="embed-radio-link" onclick="updateEmbed(this)">
            <span id="watch-embed-size-text-medium">425x344</span>
            <div id="watch-embed-size-medium-box" class="watch-embed-radio-box selected"></div>
        </a>
        <a id="watch-embed-size-radio-large" class="embed-radio-link" onclick="updateEmbed(this)">
            <span id="watch-embed-size-text-large">480x385</span>
            <div id="watch-embed-size-large-box" class="watch-embed-radio-box"></div>
        </a>
        <a id="watch-embed-size-radio-larger" class="embed-radio-link" onclick="updateEmbed(this)">
            <span id="watch-embed-size-text-larger">640x505</span>
            <div id="watch-embed-size-larger-box" class="watch-embed-radio-box"></div>
        </a>
        <div class="clearL"></div>
    </div>
</div>

<div id="footer-container">
  <script>
function show_languages() {
  var y = document.getElementById("language-picker-container");
  if (y.style.display === "block") {
    y.style.display = "none";
  } else {
    y.style.display = "block";
  }
}
</script>
<style>.easter {
    font-size: 10px;
    position: absolute;
    bottom: 35px;
    opacity: 0;
}
.easter:hover {
    opacity: 1;
}
</style>
  <div id="footer">
    <ul class="footer-links">
      <li><a href="/help"><?= $LANGS['help'] ?></a></li>
      <li><a href="/about"><?= $LANGS['about'] ?></a></li>
      <li><a href="/guidelines"><?= $LANGS['guidelines'] ?></a></li>
      <li><a href="/privacy"><?= $LANGS['privacypolicy'] ?></a></li>
      <li><a href="/terms"><?= $LANGS['terms'] ?></a></li>
      <li><a href="/partners"><?= $LANGS['partnerships'] ?></a></li>
      <li><a href="https://dev.bitview.net"><?= $LANGS['developers'] ?></a></li>
    </ul>
      <p id="copyright" style="color: #666"><?php if (isset($_COOKIE['time_machine'])): ?>© 2011 Bittoco<?php else: ?>© 2025 Bittoco<?php endif ?>
</p>
      <ul class="pickers">
      <li><?= $LANGS['languageselector'] ?>:
  <a href="#" onclick="show_languages();return false;"><?= $LANGS['language']?></a>
</li>
  </ul>
  <div class="language-picker-box">
      <div id="language-picker-container" style="display: none;"><div class="picker-top">
    <div class="box-close-link">
      <img onclick="show_languages();" src="/img/pixel.gif" alt="Close">
    </div>
    <h2>
<?= $LANGS['setlanguagepref'] ?>
    </h2>
    <div class="clearR"></div>
  </div>
  <div class="flag-bucket">
    <?php if ($LangCode == "ca") : ?>
            <div class="flag-div selected">
                Català
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=ca">
                Català
              </a>
            </div>
          <?php endif ?>
      <?php if ($LangCode == "sr") : ?>
            <div class="flag-div selected">
                Србски
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=sr">
                Србски
              </a>
            </div>
          <?php endif ?>
  <?php if ($LangCode == "de-DE") : ?>
            <div class="flag-div selected">
                Deutsch
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=de-DE">
                Deutsch
              </a>
            </div>
          <?php endif ?>     
    <?php if ($LangCode == "en-CA") : ?>
            <div class="flag-div selected">
                English (Canada)
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=en-CA">
                English (Canada)
              </a>
            </div>
          <?php endif ?>
          <?php if ($LangCode == "en-GB") : ?>
            <div class="flag-div selected">
                English (UK)
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=en-GB">
                English (UK)
              </a>
            </div>
          <?php endif ?>
      </div>
      <div class="flag-bucket">
        <?php if ($LangCode == "en-US") : ?>
            <div class="flag-div selected">
                English (US)
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=en-US">
                English (US)
              </a>
            </div>
          <?php endif ?>
                  <?php if ($LangCode == "es-ES") : ?>
            <div class="flag-div selected">
                Español (España)
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=es-ES">
                Español (España)
              </a>
            </div>
          <?php endif ?>
        <?php if ($LangCode == "es-MX") : ?>
            <div class="flag-div selected">
                Español (México)
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=es-MX">
                Español (México)
              </a>
            </div>
          <?php endif ?>
          <?php if ($LangCode == "eo") : ?>
            <div class="flag-div selected">
                Esperanto
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=eo">
                Esperanto
              </a>
            </div>
          <?php endif ?>
        <?php if ($LangCode == "fr-FR") : ?>
            <div class="flag-div selected">
                Français (France)
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=fr-FR">
                Français (France)
              </a>
            </div>
          <?php endif ?>
      </div>
      <div class="flag-bucket">
        <?php if ($LangCode == "gl") : ?>
            <div class="flag-div selected">
                Galego
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=gl">
                Galego
              </a>
            </div>
          <?php endif ?>
        <?php if ($LangCode == "hr") : ?>
            <div class="flag-div selected">
                Hrvatski
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=hr">
                Hrvatski
              </a>
            </div>
          <?php endif ?>
          <?php if ($LangCode == "it") : ?>
            <div class="flag-div selected">
                Italiano
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=it">
                Italiano
              </a>
            </div>
          <?php endif ?>
          <?php if ($LangCode == "no") : ?>
            <div class="flag-div selected">
                Norsk
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=no">
                Norsk
              </a>
            </div>
          <?php endif ?>
        <?php if ($LangCode == "pl") : ?>
            <div class="flag-div selected">
                Polski
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=pl">
                Polski
              </a>
            </div>
          <?php endif ?>
      </div>
      <div class="flag-bucket">
        <?php if ($LangCode == "pt-BR") : ?>
            <div class="flag-div selected">
                Português (Brasil)
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=pt-BR">
                Português (Brasil)
              </a>
            </div>
          <?php endif ?>
        <?php if ($LangCode == "ru") : ?>
            <div class="flag-div selected">
                Русский
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=ru">
                Русский
              </a>
            </div>
          <?php endif ?>
          <?php if ($LangCode == "ro") : ?>
            <div class="flag-div selected">
                Română
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=ro">
                Română
              </a>
            </div>
          <?php endif ?>
        <?php if ($LangCode == "tr") : ?>
          <div class="flag-div selected">
              Türkçe
          </div>
        <?php else : ?>
          <div class="flag-div">
            <a href="/?hl=tr">
              Türkçe
            </a>
          </div>
        <?php endif ?>
        <?php if ($LangCode == "uk") : ?>
            <div class="flag-div selected">
                Українська
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=uk">
                Українська
              </a>
            </div>
          <?php endif ?>
      </div>
      <div class="flag-bucket">
          <?php if ($LangCode == "zh") : ?>
            <div class="flag-div selected">
                中文
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=zh">
                中文
              </a>
            </div>
          <?php endif ?>
          <?php if ($LangCode == "ja") : ?>
            <div class="flag-div selected">
                日本語
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=ja">
                日本語
              </a>
            </div>
          <?php endif ?>
          <?php if ($LangCode == "ko") : ?>
            <div class="flag-div selected">
                한국어
            </div>
          <?php else : ?>
            <div class="flag-div">
              <a href="/?hl=ko">
                한국어
              </a>
            </div>
          <?php endif ?>
      </div>
    <div class="spacer">&nbsp;</div><span class="easter"><a href="/?hl=jk-DL">Oi lad, come over ere and ‘ave a pint of cider with the lads</a><span>
  </div>
</div>
  </div>
    </div>
		<div>
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8433080377364721"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-8433080377364721"
     data-ad-slot="8506065737"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>

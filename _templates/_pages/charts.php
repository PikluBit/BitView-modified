<link rel="stylesheet" href="/css/browse.css">
<script>
	function dropdown(e) {
		e.focus();
	    if (e.querySelector('.yt-uix-button-menu').classList.contains("hid") && document.activeElement == e) {
	        e.querySelector('.yt-uix-button-menu').classList.remove("hid");
	        e.classList.add('yt-uix-button-active');
	        var rect = e.getBoundingClientRect();
	        var width = (document.body.clientWidth - 960) / 2;
	        var height = document.getElementById('masthead-container').offsetHeight;
	        e.querySelector('.yt-uix-button-menu').style.left = rect.left - width + 5 + "px";
	        if (!document.getElementById("default-language-box")) {
	            e.querySelector('.yt-uix-button-menu').style.top = rect.top - height + 14 + "px";
	        }
	        else {
	            var eh = document.getElementById('default-language-box').offsetHeight;
	            e.querySelector('.yt-uix-button-menu').style.top = rect.top - height - eh - 6 + "px";
	        }
	    }
	    else {
	        e.classList.remove('yt-uix-button-active');
	        e.querySelector('.yt-uix-button-menu').classList.add("hid");
	    }
	}
</script>
<div id="content" class="">
      <div id="charts-main">
    <h2><?= $LANGS['bitviewcharts'] ?></h2>
    
    <div id="charts-selector">
    	<span class="yt-uix-helpcard">
      	<img class="master-sprite yt-help-icon yt-uix-helpcard-target" src="/img/pixel.gif">
			<span class="yt-uix-helpcard-content" style="display: none;"><span><button class="yt-uix-helpcard-close master-sprite" type="button" onclick="return false;"><?= $LANGS['close'] ?></button><?= $LANGS['mostviewedvideosdesc'] ?></span></span>
		</span>

		<button type="button" class=" yt-uix-button" onclick="dropdown(this);return false;" role="button" aria-activedescendant="" aria-haspopup="true" aria-pressed="false" aria-expanded="false"><span class="yt-uix-button-content"><?= $Types[$Type] ?></span> <img class="yt-uix-button-arrow" src="/img/pixel.gif" alt="">
			<ul class="yt-uix-button-menu hid" role="menu" aria-haspopup="true">
				<li><span href="?t=2<?php if (isset($_GET['d'])): ?>&d=<?= $Date ?><?php endif ?><?php if (isset($_GET['c'])): ?>&c=<?= $Cat ?><?php endif ?>" class=" yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $Types[2] ?></span></li>
				<li><span href="?t=3<?php if (isset($_GET['d'])): ?>&d=<?= $Date ?><?php endif ?><?php if (isset($_GET['c'])): ?>&c=<?= $Cat ?><?php endif ?>" class=" yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $Types[3] ?></span></li>
				<li><span href="?t=6<?php if (isset($_GET['d'])): ?>&d=<?= $Date ?><?php endif ?>" class=" yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $Types[6] ?></span></li>
				<li><span href="?t=5<?php if (isset($_GET['d'])): ?>&d=<?= $Date ?><?php endif ?><?php if (isset($_GET['c'])): ?>&c=<?= $Cat ?><?php endif ?>" class=" yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $Types[5] ?></span></li>
				<li><span href="?t=8<?php if (isset($_GET['d'])): ?>&d=<?= $Date ?><?php endif ?>" class=" yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $Types[8] ?></span></li>
				<li><span href="?t=7<?php if (isset($_GET['d'])): ?>&d=<?= $Date ?><?php endif ?>" class=" yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $Types[7] ?></span></li>
				<li><span href="?t=1<?php if (isset($_GET['d'])): ?>&d=<?= $Date ?><?php endif ?><?php if (isset($_GET['c'])): ?>&c=<?= $Cat ?><?php endif ?>" class=" yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $Types[1] ?></span></li>
				<li><span href="?t=4<?php if (isset($_GET['d'])): ?>&d=<?= $Date ?><?php endif ?><?php if (isset($_GET['c'])): ?>&c=<?= $Cat ?><?php endif ?>" class=" yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $Types[4] ?></span></li>
			</ul>
		</button>
		<button type="button" class=" yt-uix-button" onclick="dropdown(this);return false;" role="button" aria-activedescendant="" aria-haspopup="true" aria-pressed="false" aria-expanded="false"><span class="yt-uix-button-content"><?= $Dates[$Date] ?></span> <img class="yt-uix-button-arrow" src="/img/pixel.gif" alt="">
			<ul class="yt-uix-button-menu hid" role="menu" aria-haspopup="true">
				<li><span href="?t=<?= $Type ?>&d=1<?php if (isset($_GET['c'])): ?>&c=<?= $Cat ?><?php endif ?>" class=" yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $Dates[1] ?></span></li>
				<li><span href="?t=<?= $Type ?>&d=2<?php if (isset($_GET['c'])): ?>&c=<?= $Cat ?><?php endif ?>" class=" yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $Dates[2] ?></span></li>
				<li><span href="?t=<?= $Type ?>&d=3<?php if (isset($_GET['c'])): ?>&c=<?= $Cat ?><?php endif ?>" class=" yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $Dates[3] ?></span></li>
				<li><span href="?t=<?= $Type ?>&d=4<?php if (isset($_GET['c'])): ?>&c=<?= $Cat ?><?php endif ?>" class=" yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $Dates[4] ?></span></li>
			</ul>
		</button>
		<?php if ($Type < 6): ?>
		<span class="between-button-text"><?= $LANGS['allcatin'] ?></span> 
		<button type="button" class=" yt-uix-button" onclick="dropdown(this);return false;" role="button" aria-activedescendant="" aria-haspopup="true" aria-pressed="false" aria-expanded="false"><span class="yt-uix-button-content"><?php if ($_GET["c"] == 0) : ?><?= $LANGS['allcat'] ?><?php else: ?><?php foreach ($Video_Category as $ID => $Category) : ?>
        <?php if ($_GET["c"] == $ID) : ?> 
        <?= $Category ?>
        <?php endif ?>
        <?php endforeach ?>
        	<?php endif ?>
        </span> <img class="yt-uix-button-arrow" src="/img/pixel.gif" alt="">
			<ul class="yt-uix-button-menu hid" role="menu" aria-haspopup="true">
				<li><span href="?t=<?= $Type ?>&d=<?= $Date ?>" class=" yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['allcat'] ?></span></li>
				<?php foreach ($Video_Category as $ID => $Category) : ?>
				<li><span href="?t=<?= $Type ?>&d=<?= $Date ?>&c=<?= $ID ?>" class=" yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $Category ?></span></li>
				<?php endforeach ?>
				</ul>
		</button>
		<?php endif ?>
    </div>
    	<?php if ($Type < 6): ?>
        <ol id="charts-top-videos">
        	<?php foreach ($Videos as $Rank => $Video): ?>
        	<?php $Rank++ ?>
        	<?php $Rank += 20 * ($_PAGINATION->Current_Page - 1) ?>
      		<li>
      			<span style="float:left">
						<?= load_thumbnail($Video['url']) ?>
						</span>
				    <div class="video-details">
				      <h3 class="chart-rank-title">
				        <span class="rank"><?= $Rank ?></span>
				        <a href="<?= $Video['link'] ?>" class="video-title" title="<?= $Video['title'] ?>" dir="ltr"><?= short_title($Video['title'],45) ?></a>
				      </h3>
				      <p class="description">
				        <?= short_title($Video['description'],50) ?>
				      </p>
				      <ul class="facets">
				        <li>  
				        	<span class="video-username">

										<?= str_replace("{u}",'<a href="/user/'. $Video['uploaded_by'] .'">'. displayname($Video['uploaded_by']) .'</a>',$LANGS['videoby']) ?>
									</span>
								</li>
								<li><?= get_time_ago($Video['uploaded_on']) ?></li>
								<li class="last"><strong><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?></strong></li>
				      </ul>
				    </div>
  				</li>
  				<?php endforeach ?>
  			</ol>
  		<?php else: ?>
  			<ol id="charts-top-channels">
  				<?php foreach ($Users as $Rank => $User): ?>
        	<?php $Rank++ ?>
        	<?php $Rank += 20 * ($_PAGINATION->Current_Page - 1) ?>
		      <li>
			      <div class="user-thumb-large">
			      	<div>
								<a href="/user/<?= $User['username'] ?>">
			      			<img src="<?= avatar($User["username"]) ?>" alt="<?= displayname($User['username']) ?>" title="<?= displayname($User['username']) ?>">
								</a>
			 			 	</div>
			 			</div>
			    	<div class="profile-details">
				      <h3 class="chart-rank-title">
				        <span class="rank"><?= $Rank ?></span>
				        <a href="/user/<?= $User['username'] ?>" class="channel-title" title="JarmaineTV" dir="ltr"><?= displayname($User['username']) ?></a>
				      </h3>
				      <ul class="facets">
				        <li><?= $User["videos"] ?> <?= $LANGS['cstatvideos'] ?></li>
				        <li class="last"><?php if ($Type > 6): ?><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($User['video_views'.$DATE]) ?><?php else: ?><?= ($User['video_views'.$DATE]) ?><?php endif ?> <?= $LANGS['cstatviews'] ?><?php else: ?><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($User['subscribers'.$DATE]) ?><?php else: ?><?= ($User['subscribers'.$DATE]) ?><?php endif ?> <?= $LANGS['cstatsubs'] ?><?php endif ?></li>
				      </ul>
			    	</div>
		  		</li>
		  		<?php endforeach ?>
  		</ol>
  		<?php endif ?>
    <div class="yt-uix-pager">
      <?php $_PAGINATION->new_show_pages_videos("t=$Type&d=$Date&c=$Cat") ?>
    </div>
  </div>
</div>
<div class="clear"></div>
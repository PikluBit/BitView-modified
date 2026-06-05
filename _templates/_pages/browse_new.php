<link rel="stylesheet" href="/css/browse.css">
<script>
	function openCategories() {
		document.getElementById('shmoovies-category-menu-container').style.display = document.getElementById('shmoovies-category-menu-container').style.display == 'none' ? 'block' : 'none';
			document.getElementById('shmoovies-category-heading').classList.toggle('yt-uix-expander-collapsed');
	}
</script>
<div id="videos-main" class="shmoovies-list-container">
    <div class="yt-uix-expander yt-uix-expander-collapsed" id="shmoovies-category-heading">
    	<h2><?= $LANGS['allcat'] ?></h2>
      <span class="yt-uix-expander-head yt-rounded" onclick="openCategories();return false;">
        <button title="Categories" class="yt-uix-expander-arrow master-sprite"></button>
        <?= $LANGS['categories'] ?>
      </span>
      <div class="yt-uix-expander-body" id="shmoovies-category-menu-container" style="display: none;">
          <ul>
            <li><span><?= $LANGS['all'] ?></span></li>
            <?php $Count = 1; ?>
            <?php foreach ($Video_Category as $ID => $Category) : ?>
            	<?php if ($Count % 6 == 0): ?>
            	<ul>
            	<?php endif ?>
            	<?php $Count++; ?>
        		<li><a href="?category=<?= $ID ?>"><?= $Category ?></a></li>
        		<?php if ($Count % 6 == 0): ?>
        		</ul>
        		<?php endif ?>
        	<?php endforeach ?>
        	</ul>
        <div class="clear"></div>
      </div>
  	</div>
    <div id="popular-column">
        <h3>
          <span class="updated-notice"><?= $LANGS['updated2hrs'] ?></span>
          <a href="/charts"><?= $LANGS['mostviewedtoday'] ?></a>
        </h3>
        <div class="popular-videos-list">
        	<?php foreach ($MVT_Videos as $Video): ?>
		        <div class="video-cell">
		        <?= load_thumbnail($Video['url']) ?>
			    <p>
			      <a href="<?= $Video['link'] ?>" class="video-title" title="<?= $Video['title'] ?>" dir="ltr"><?= $Video['title'] ?></a>
			        <span class="video-username">
						<?= str_replace("{u}",'<a href="/user/'. $Video['uploaded_by'] .'">'. displayname($Video['uploaded_by']) .'</a>',$LANGS['videoby']) ?></a>
			  		</span>
			    </p>
		  		</div>
	  		<?php endforeach ?>
    		<div class="clear"></div>
  		</div>
        <h4><a href="?category=4" title="<?= $LANGS['cat4'] ?>"><?= $LANGS['cat4'] ?></a></h4>
    	<div class="popular-videos-list">
    		<?php foreach ($Ent_Videos as $Video): ?>
		        <div class="video-cell">
		        <?= load_thumbnail($Video['url']) ?>
			    <p>
			      <a href="<?= $Video['link'] ?>" class="video-title" title="<?= $Video['title'] ?>" dir="ltr"><?= $Video['title'] ?></a>
			        <span class="video-username">
                        <?= str_replace("{u}",'<a href="/user/'. $Video['uploaded_by'] .'">'. displayname($Video['uploaded_by']) .'</a>',$LANGS['videoby']) ?>
						</a>
			  		</span>
			    </p>
		  		</div>
  			<?php endforeach ?>
			<div class="clear"></div>
		</div>

        <h4><a href="?category=20" title="<?= $LANGS['cat20'] ?>"><?= $LANGS['cat20'] ?></a></h4>
        <div class="popular-videos-list">
        	<?php foreach ($Gam_Videos as $Video): ?>
		        <div class="video-cell">
		        <?= load_thumbnail($Video['url']) ?>
			    <p>
			      <a href="<?= $Video['link'] ?>" class="video-title" title="<?= $Video['title'] ?>" dir="ltr"><?= $Video['title'] ?></a>
			        <span class="video-username">
<?= str_replace("{u}",'<a href="/user/'. $Video['uploaded_by'] .'">'. displayname($Video['uploaded_by']) .'</a>',$LANGS['videoby']) ?>			  		</span>
			    </p>
		  		</div>
			<?php endforeach ?>
			<div class="clear"></div>
		</div>

		<h4><a href="?category=16" title="<?= $LANGS['cat16'] ?>"><?= $LANGS['cat16'] ?></a></h4>
        <div class="popular-videos-list">
        	<?php foreach ($Sci_Videos as $Video): ?>
		        <div class="video-cell">
		        <?= load_thumbnail($Video['url']) ?>
			    <p>
			      <a href="<?= $Video['link'] ?>" class="video-title" title="<?= $Video['title'] ?>" dir="ltr"><?= $Video['title'] ?></a>
			        <span class="video-username">
<?= str_replace("{u}",'<a href="/user/'. $Video['uploaded_by'] .'">'. displayname($Video['uploaded_by']) .'</a>',$LANGS['videoby']) ?>			  		</span>
			    </p>
		  		</div>
			<?php endforeach ?>
			<div class="clear"></div>
		</div>

		<h4><a href="?category=9" title="<?= $LANGS['cat9'] ?>"><?= $LANGS['cat9'] ?></a></h4>
        <div class="popular-videos-list">
        	<?php foreach ($Com_Videos as $Video): ?>
		        <div class="video-cell">
		        <?= load_thumbnail($Video['url']) ?>
			    <p>
			      <a href="<?= $Video['link'] ?>" class="video-title" title="<?= $Video['title'] ?>" dir="ltr"><?= $Video['title'] ?></a>
			        <span class="video-username">
<?= str_replace("{u}",'<a href="/user/'. $Video['uploaded_by'] .'">'. displayname($Video['uploaded_by']) .'</a>',$LANGS['videoby']) ?>			  		</span>
			    </p>
		  		</div>
			<?php endforeach ?>
			<div class="clear"></div>
		</div>

		<h4><a href="?category=11" title="<?= $LANGS['cat11'] ?>"><?= $LANGS['cat11'] ?></a></h4>
        <div class="popular-videos-list">
        	<?php foreach ($News_Videos as $Video): ?>
		        <div class="video-cell">
		        <?= load_thumbnail($Video['url']) ?>
			    <p>
			      <a href="<?= $Video['link'] ?>" class="video-title" title="<?= $Video['title'] ?>" dir="ltr"><?= $Video['title'] ?></a>
			        <span class="video-username">
<?= str_replace("{u}",'<a href="/user/'. $Video['uploaded_by'] .'">'. displayname($Video['uploaded_by']) .'</a>',$LANGS['videoby']) ?>			  		</span>
			    </p>
		  		</div>
			<?php endforeach ?>
			<div class="clear"></div>
		</div>

		<h4><a href="?category=13" title="<?= $LANGS['cat13'] ?>"><?= $LANGS['cat13'] ?></a></h4>
        <div class="popular-videos-list">
        	<?php foreach ($Peo_Videos as $Video): ?>
		        <div class="video-cell">
		        <?= load_thumbnail($Video['url']) ?>
			    <p>
			      <a href="<?= $Video['link'] ?>" class="video-title" title="<?= $Video['title'] ?>" dir="ltr"><?= $Video['title'] ?></a>
			        <span class="video-username">
<?= str_replace("{u}",'<a href="/user/'. $Video['uploaded_by'] .'">'. displayname($Video['uploaded_by']) .'</a>',$LANGS['videoby']) ?>			  		</span>
			    </p>
		  		</div>
			<?php endforeach ?>
			<div class="clear"></div>
		</div>

		<h4><a href="?category=19" title="<?= $LANGS['cat19'] ?>"><?= $LANGS['cat19'] ?></a></h4>
        <div class="popular-videos-list">
        	<?php foreach ($Tra_Videos as $Video): ?>
		        <div class="video-cell">
		        <?= load_thumbnail($Video['url']) ?>
			    <p>
			      <a href="<?= $Video['link'] ?>" class="video-title" title="<?= $Video['title'] ?>" dir="ltr"><?= $Video['title'] ?></a>
			        <span class="video-username">
<?= str_replace("{u}",'<a href="/user/'. $Video['uploaded_by'] .'">'. displayname($Video['uploaded_by']) .'</a>',$LANGS['videoby']) ?>			  		</span>
			    </p>
		  		</div>
			<?php endforeach ?>
			<div class="clear"></div>
		</div>

		<h4><a href="?category=18" title="<?= $LANGS['cat18'] ?>"><?= $LANGS['cat18'] ?></a></h4>
        <div class="popular-videos-list">
        	<?php foreach ($Spo_Videos as $Video): ?>
		        <div class="video-cell">
		        <?= load_thumbnail($Video['url']) ?>
			    <p>
			      <a href="<?= $Video['link'] ?>" class="video-title" title="<?= $Video['title'] ?>" dir="ltr"><?= $Video['title'] ?></a>
			        <span class="video-username">
<?= str_replace("{u}",'<a href="/user/'. $Video['uploaded_by'] .'">'. displayname($Video['uploaded_by']) .'</a>',$LANGS['videoby']) ?>			  		</span>
			    </p>
		  		</div>
			<?php endforeach ?>
			<div class="clear"></div>
		</div>

		<h4><a href="?category=3" title="<?= $LANGS['cat3'] ?>"><?= $LANGS['cat3'] ?></a></h4>
        <div class="popular-videos-list">
        	<?php foreach ($Edu_Videos as $Video): ?>
		        <div class="video-cell">
		        <?= load_thumbnail($Video['url']) ?>
			    <p>
			      <a href="<?= $Video['link'] ?>" class="video-title" title="<?= $Video['title'] ?>" dir="ltr"><?= $Video['title'] ?></a>
			        <span class="video-username">
<?= str_replace("{u}",'<a href="/user/'. $Video['uploaded_by'] .'">'. displayname($Video['uploaded_by']) .'</a>',$LANGS['videoby']) ?>
                    </span>
			    </p>
		  		</div>
			<?php endforeach ?>
			<div class="clear"></div>
		</div>
    </div>
    <div id="recent-column">
      <div id="browse-ad-container"></div>
	      <h3><a href="?category=10"><?= $LANGS['cat10'] ?></a></h3>
		  <div class="sidebar-spotlights-container">
	    	<?php foreach ($Mus_Videos as $Video): ?>
	    	<div class="video-cell">
	            <a class="ux-thumb-wrap contains-addto" href="<?= $Video['link'] ?>">  
	              	<span class="video-thumb video-thumb-96" id="video-thumb-<?= $Video['url'] ?>">
	                    <span class="img">
	                    <img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg96" alt="<?= $Video['title'] ?>" title="<?= $Video['title'] ?>"></span>
	                    <span class="video-time"><?= timestamp($Video["length"]) ?></span><?php if (!in_array($Video["url"], $_USER->QuickList)): ?>
	                    <span class="video-actions"><button type="button" class=" yt-uix-button yt-uix-button-short" id="yt-uix-button-short-<?= $Video['url'] ?>" onclick="addToQuickList(this);return false;"><span class="yt-uix-button-content"><strong>+</strong></span></button></span>
	                    <span class="video-in-quicklist"><?= $LANGS['addedtoqueue'] ?></span><?php endif ?>
	                </span>
	          	</a>
			    <p>
			    	<a href="/watch?v=<?= $Video['url'] ?>" class="video-title" title="<?= $Video['title'] ?>" dir="ltr"><?= $Video['title'] ?></a>
		    		<span class="video-username">
<?= str_replace("{u}",'<a href="/user/'. $Video['uploaded_by'] .'">'. displayname($Video['uploaded_by']) .'</a>',$LANGS['videoby']) ?>		  			</span>
			    </p>
	  			<div class="clear"></div>
				</div>
				<?php endforeach ?>
		   </div>
		 <h3><a href="?category=17"><?= $LANGS['cat17'] ?></a></h3>
	 	 <div class="sidebar-spotlights-container">
    	<?php foreach ($SMovies_Videos as $Video): ?>
    	<div class="video-cell">
            <a class="ux-thumb-wrap contains-addto" href="<?= $Video['link'] ?>">  
              	<span class="video-thumb video-thumb-96" id="video-thumb-<?= $Video['url'] ?>">
                    <span class="img">
                    <img <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/u/thmp/'.$Video["url"].'.jpg')): ?>src="/u/thmp/<?= $Video["url"] ?>.jpg"<?php else: ?>src="/img/nothump.png"<?php endif ?> class="vimg96" alt="<?= $Video['title'] ?>" title="<?= $Video['title'] ?>"></span>
                    <span class="video-time"><?= timestamp($Video["length"]) ?></span><?php if (!in_array($Video["url"], $_USER->QuickList)): ?>
                    <span class="video-actions"><button type="button" class=" yt-uix-button yt-uix-button-short" id="yt-uix-button-short-<?= $Video['url'] ?>" onclick="addToQuickList(this);return false;"><span class="yt-uix-button-content"><strong>+</strong></span></button></span>
                    <span class="video-in-quicklist"><?= $LANGS['addedtoqueue'] ?></span><?php endif ?>
                </span>
          	</a>
		    <p>
		    	<a href="/watch?v=<?= $Video['url'] ?>" class="video-title" title="<?= $Video['title'] ?>" dir="ltr"><?= $Video['title'] ?></a>
	    		<span class="video-username">
<?= str_replace("{u}",'<a href="/user/'. $Video['uploaded_by'] .'">'. displayname($Video['uploaded_by']) .'</a>',$LANGS['videoby']) ?>	  			</span>
		    </p>
  			<div class="clear"></div>
			</div>
			<?php endforeach ?>
	   </div>
    </div>
  </div>
<div class="clear"></div>
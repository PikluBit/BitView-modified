<style type="text/css">
.videoModifiers {
    background: #cccccc;
    border: 0;
    border-radius: 8px;
    height: 19px;
    float: right;
    width: 750px;
    padding: 7px 0px 6px 0px;
    border-bottom: 1px solid #ccc;
    text-align: left;
}
.videoModifiers .first {
    border-left: 0px;
    padding: 0px 10px 0px 2px;
}

.videoModifiers .subcategory {
    font-size: 14px;
    float: left;
    height: 25px;
    margin-top: -12px;
    padding: 13px 13px 0 13px;
    font-weight: bold;
}
.rsslink {
    color: black !important;
    text-decoration: underline !important;
    padding-left: 16px;
    height: 18px;
    display: block;
    font-size: 11px;
    line-height: 18px;
    vertical-align: middle;
    margin-left: 3px;
    margin-top: 10px;
    background: transparent url(/img/rss_icn.gif) no-repeat scroll -2px 0px;
}
.browse-categories-side li.last {
    padding-bottom: 4px;
    -moz-border-radius-topleft: 0;
    -moz-border-radius-topright: 0;
    -webkit-border-top-left-radius: 0;
    -webkit-border-top-right-radius: 0;
}
</style>
<div id="side-column">
	<div class="browse-side-column">
		<ul class="browse-categories-side yt-rounded" style="padding-bottom: 0;">
			<?php if ((isset($_GET["category"]) && $_GET["category"] != 0) || (isset($_GET["r"]) && $_GET["r"] == 1)) : ?>
            <li class="category browse-category-top-level first yt-rounded"><a class="hLink" href="/browse"><?= $LANGS['categories'] ?></a></li>
            <?php else : ?>
            <li class="category-selected browse-category-top-level first yt-rounded"><a class="hLink" href="/browse"><?= $LANGS['categories'] ?></a></li>
            <?php endif ?>
            <?php foreach ($Video_Category as $ID => $Category) : ?>
                <?php if ($_GET["category"] != $ID || $_GET["category"] == 0) : ?> 
                <li class="main-tabs-subcategory "><a href="/browse?category=<?= $ID ?><?php if (isset($_GET["t"])) : ?>&t=<?=$_GET["t"]?><?php endif ?><?php if (isset($_GET["d"])) : ?>&d=<?=$_GET["d"]?><?php endif ?>"><?= $Category ?></a></li>
                <?php else : ?>
                <li class="category-selected"><a class="hLink" href="/browse?category=<?= $ID ?><?php if (isset($_GET["t"])) : ?>&t=<?=$_GET["t"]?><?php endif ?><?php if (isset($_GET["d"])) : ?>&d=<?=$_GET["d"]?><?php endif ?>"><?= $Category ?></a></li>
                <?php endif ?>
            <?php endforeach ?>
            <li style="margin-top: 10px" class="category<?php if (isset($_GET["r"]) && $_GET["r"] == 1) : ?>-selected<?php endif ?> browse-category-top-level last yt-rounded"><a class="hLink" href="/browse?r=1"><?= $LANGS['recommendedforyou'] ?></a></li>
		</ul>
		<a class="rsslink" href="/rss/rss_feed?order=<?= $Type ?>&date=<?= $Date ?>"><?= $LANGS['rssthispage'] ?></a>
	</div>
</div>

<div id="body-column">
<div class="main-tab-layout-top-browse-tabs">
		<div id="browse-video-channels-modifiers" class="browse-tab-modifiers yt-rounded">
			<div class="subcategory selected first yt-rounded"><?= $LANGS['videos'] ?></div>
			<div class="subcategory"><a href="/channels"><?= $LANGS['channels'] ?></a></div>
			<div class="clear"></div>
		</div>
	</div>

<table class="browse-modifiers-extended" width="100%"><tbody><tr>
		<td class="browse-modifiers-extended-category" width="30%">
			<span class="browse-modifiers-extended-category-lbl" style="text-transform: capitalize;"><?= $LANGS['allcatin'] ?>:</span> 		<?php if ($_GET["category"] == 0) : ?>
		<?php if (isset($_GET["r"]) && $_GET["r"] == 1) : ?><?= $LANGS['recommendedforyou'] ?><?php else: ?><?= $LANGS['allcat'] ?><?php endif ?>
		<?php endif ?>
			        <?php foreach ($Video_Category as $ID => $Category) : ?>
        <?php if ($_GET["category"] == $ID) : ?> 
        <?= $Category ?>
        <?php endif ?>
        <?php endforeach ?>
		</td>
		<td class="browse-basic-modifiers" width="40%">
			<?php if (!isset($_GET["r"]) || $_GET['r'] != 1): ?>
			<?php if ($Type != 1): ?>
			<div class="subcategory first"><a href="/browse?t=1<?php if ($_GET["category"] != 0) : ?>&category=<?=$_GET["category"]?><?php endif ?><?php if (isset($_GET["d"])) : ?>&d=<?=$_GET["d"]?><?php endif ?>"><?= $LANGS['mostviewed'] ?></a></div>
			<?php else: ?>
			<div class="subcategory first selected"><span><?= $LANGS['mostviewed'] ?></span></div>
			<?php endif ?>

			<?php if ($Type != 8): ?>
			<div class="subcategory"><a href="/browse?t=8<?php if ($_GET["category"] != 0) : ?>&category=<?=$_GET["category"]?><?php endif ?><?php if (isset($_GET["d"])) : ?>&d=<?=$_GET["d"]?><?php endif ?>">HD</a></div>
			<?php else: ?>
			<div class="subcategory selected"><span>HD</span></div>
			<?php endif ?>

			<div class="subcategory <?php if ($Type > 1 & $Type < 8): ?>selected<?php endif ?>">
				<button type="button" id="more-sub-modifiers-menulink" onclick="dropdown(this);return false;" onfocusout="dropdown(this);" class="yt-uix-button yt-uix-button-text"><span class="yt-uix-button-content"><?php if ($Type == 2): ?><?= $LANGS['featured'] ?><?php elseif ($Type == 3): ?><?= $LANGS['mostdiscussed'] ?><?php elseif ($Type == 4): ?><?= $LANGS['topfavorited'] ?><?php elseif ($Type == 5): ?><?= $LANGS['toprated'] ?><?php elseif ($Type == 6): ?><?= $LANGS['recentvideos'] ?><?php else: ?><?= $LANGS['dropdownmore'] ?><?php endif ?></span> <img class="yt-uix-button-arrow" src="/img/pixel.gif" alt="">
					<ul style="min-width: 53px;" class="yt-uix-button-menu yt-uix-button-menu-text hid">
						<li><span href="/browse?t=2<?php if ($_GET["category"] != 0) : ?>&category=<?=$_GET["category"]?><?php endif ?><?php if (isset($_GET["d"])) : ?>&d=<?=$_GET["d"]?><?php endif ?>" class="yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['featured'] ?></span></li>
						<li><span href="/browse?t=3<?php if ($_GET["category"] != 0) : ?>&category=<?=$_GET["category"]?><?php endif ?><?php if (isset($_GET["d"])) : ?>&d=<?=$_GET["d"]?><?php endif ?>" class="yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['mostdiscussed'] ?></span></li>
						<li><span href="/browse?t=6<?php if ($_GET["category"] != 0) : ?>&category=<?=$_GET["category"]?><?php endif ?><?php if (isset($_GET["d"])) : ?>&d=<?=$_GET["d"]?><?php endif ?>" class="yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['recentvideos'] ?></span></li>
						<li><span href="/browse?t=4<?php if ($_GET["category"] != 0) : ?>&category=<?=$_GET["category"]?><?php endif ?><?php if (isset($_GET["d"])) : ?>&d=<?=$_GET["d"]?><?php endif ?>" class="yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['topfavorited'] ?></span></li>
						<li><span href="/browse?t=5<?php if ($_GET["category"] != 0) : ?>&category=<?=$_GET["category"]?><?php endif ?><?php if (isset($_GET["d"])) : ?>&d=<?=$_GET["d"]?><?php endif ?>" class="yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['toprated'] ?></span></li>
				</button>
			</div> 

			<div class="clear"></div>
		</td>
		
		<td class="time-slice-modifiers" width="30%">
<?php if ($Type != 2 && $Type != 6 && $Type != 8): ?>
					<span class="browse-modifiers-extended-category-lbl"><span class="browse-modifiers-extended-category-lbl"><?= $LANGS['when'] ?>:</span></span>
					<button type="button" id="more-sub-modifiers-menulink" onclick="dropdown(this);return false;" onfocusout="dropdown(this);" class="yt-uix-button yt-uix-button-text"><span class="yt-uix-button-content"><?php if ($Date == 1): ?><?= $LANGS['timetoday'] ?><?php elseif ($Date == 2): ?><?= $LANGS['timeweek'] ?><?php elseif ($Date == 3): ?><?= $LANGS['timemonth'] ?><?php else: ?><?= $LANGS['alltime'] ?><?php endif ?></span> <img class="yt-uix-button-arrow" src="/img/pixel.gif" alt="">
					<ul style="min-width: 53px;" class="yt-uix-button-menu yt-uix-button-menu-text hid">
						<li><span href="/browse?d=1<?php if ($_GET["category"] != 0): ?>&category=<?=$_GET["category"]?><?php endif ?><?php if (isset($_GET["t"])): ?>&t=<?=$_GET["t"]?><?php endif ?>" class="yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['timetoday'] ?></span></li>
						<li><span href="/browse?d=2<?php if ($_GET["category"] != 0): ?>&category=<?=$_GET["category"]?><?php endif ?><?php if (isset($_GET["t"])): ?>&t=<?=$_GET["t"]?><?php endif ?>" class="yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['timeweek'] ?></span></li>
						<li><span href="/browse?d=3<?php if ($_GET["category"] != 0): ?>&category=<?=$_GET["category"]?><?php endif ?><?php if (isset($_GET["t"])): ?>&t=<?=$_GET["t"]?><?php endif ?>" class="yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['timemonth'] ?></span></li>
						<li><span href="/browse?d=4<?php if ($_GET["category"] != 0): ?>&category=<?=$_GET["category"]?><?php endif ?><?php if (isset($_GET["t"])): ?>&t=<?=$_GET["t"]?><?php endif ?>" class="yt-uix-button-menu-item" onclick=";window.location.href=this.getAttribute('href');return false;"><?= $LANGS['alltime'] ?></span></li>
				</button>
			<div class="clear"></div>
					<?php endif ?>
					<?php endif ?>
		</td> 


	</tr></tbody></table>
<div id="browseMain">
		<div class="clear"></div>
		<?php if (!isset($_GET["style"])) : ?>
		<div id="video_grid" class="browseGridView marT10">
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tbody>
		<?php $Count = 0; ?>
			<tr valign="top"><td>
		<?php if ($Videos) : ?>
		<?php foreach ($Videos as $Video) : ?>
		<?php $Count++ ?>
		<div class="vlcell">
		
		<!--miniaturka -->
		<?= load_thumbnail($Video['url']) ?>
		<div class="vldescbox">
			<div class="vltitle">
				<div class="vlshortTitle">
					<a href="<?= $Video["link"] ?>" title="<?= $Video["title"] ?>"><?= short_title($Video["title"],40) ?></a> 
				</div>
			</div>

			<div class="vldesc"> 
			</div>
		</div>

		<div class="vlfacets">
				<span id="video-num-views"><?php if ($Type !== 4 and $Type !== 3): ?><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <?= $LANGS['videoviews'] ?><?php elseif ($Type == 4): ?><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["favorites"]) ?><?php else: ?><?= ($Video["favorites"]) ?><?php endif ?> <?= $LANGS['videofavorites'] ?><?php elseif ($Type == 3): ?><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["comments"]) ?><?php else: ?><?= ($Video["comments"]) ?><?php endif ?> <?= $LANGS['videocomments'] ?><?php endif ?><br></span>
				<div><span class="vlfrom">			<a href="<?= $Video["uploader_link"] ?>"><?= displayname($Video["uploaded_by"]) ?></a>
</span></div>
				<div class="clearL"></div>
		</div>
		<div class="vlclearaltl"></div>
	</div> 


		</div>
		<div class="vlclear"></div>
		
 <?php if ($Count == 5) : ?>
 </td>
	</tr>
<tr valign="top"><td>
	<?php $Count = 0 ?>
                    <?php endif ?>
                    <?php endforeach ?>
                        <?php else : ?>
        <p style="font-size:15px;color:#444;text-align:center;padding:22px 0 16px"><?= $LANGS['nomorevideos'] ?></p>
    <?php endif ?>
</tbody>
</table>
</div>
	 <?php else : // po 20 ?> 
	 <div id="video_grid" class="marT10 browseListView">
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tbody>
				<?php $Count = 0; ?>
				<tr valign="top"><td>
					<?php if ($Videos) : ?>
		<?php foreach ($Videos as $Video) : ?>
		<?php $Count++ ?>
		<div class="vlcell">
			
	<div class="vlentry">
		<div class="v120WideEntry">
			<div class="v120WrapperOuter"><div class="v120WrapperInner">
				<div class="runtime"><?php if ($Video["length"] >= 60): ?><?=ltrim(date('i:s', $Video["length"]), 0)?> <?php else: ?><?= gmdate('0:s', $Video["length"]) ?><?php endif ?></div>
				<a href="<?= $Video["link"] ?>">
					<img src="<?= $Video["thumb"] ?>" class="vimg120" title="<?= $Video["title"] ?>" alt="video">
				</a>
				
				</div></div>
		</div>

		<div class="vldescbox">
			<div class="vltitle">
				<div class="vllongTitle">
					<a href="<?= $Video["link"] ?>" title="<?= $Video["title"] ?>"><?= short_title($Video["title"],60) ?></a>
				</div>
			</div>

			<div class="vldesc">
									
		
	<span id="BeginvidDesc<?= $Video["url"] ?>">
	<?php if($Video["description"]) : ?>
    <?= short_title($Video["description"], 100) ?>
    <?php else : ?>
    <i> <?= $LANGS['nodesc'] ?> </i>
    <?php endif ?>
	</span>

			<span id="RemainvidDesc<?= $Video["url"] ?>" style="display: none">	
	<?php if($Video["description"]) : ?>
    <?= short_title($Video["description"], 100) ?>
    <?php else : ?>
    <i> <?= $LANGS['nodesc'] ?> </i>
    <?php endif ?></span>



			</div>
		</div>

		<div class="vlfacets">
			<div class="vladded">
				<span class="grayText">Added:</span> <?= date("M d, Y",strtotime((string) $Video["uploaded_on"])) ?><!--dyn--><br>
			</div>
				<div><span class="vlfrom">			<a href="<?= $Video["uploader_link"] ?>"><?= displayname($Video["uploaded_by"]) ?></a>
</span></div>
				<div class="clearL"></div>
			 <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Video["views"]) ?><?php else: ?><?= ($Video["views"]) ?><?php endif ?> <span class="grayText"><?= $LANGS['videoviews'] ?></span><br>

			<div class="video-thumb-duration-rating">
								
	<div>
		
	<?= show_ratings($Video,"13px","13px") ?>



	</div>



				<div class="runtime"><?php if ($Video["length"] >= 60): ?><?=ltrim(date('i:s', $Video["length"]), 0)?> <?php else: ?><?= gmdate('0:s', $Video["length"]) ?><?php endif ?></div>
			</div>

		</div>
		<div class="vlclearaltl"></div>


		
	</div> <!-- end vEntry -->

		</div>
		<div class="vlclear"></div>
 <?php if ($Count == 4) : ?>
 </td>
	</tr>
<tr valign="top"><td>
	<?php $Count = 0 ?>
                    <?php endif ?>
                    <?php endforeach ?>
                                            <?php else : ?>
        <p style="font-size:15px;color:#444;text-align:center;padding:22px 0 16px"><?= $LANGS['nomorevideos'] ?></p>
    <?php endif ?>

</tbody>
</table>
</div>

                    <?php endif ?>

		<div class="searchFooterBox">		<div class="pagingDiv" style="text-align: right;">
			<?php if (isset($_GET["style"]) && $_GET["category"] == 0 and (!isset($_GET["r"]) || $_GET["r"] != 1)) : ?><?php $_PAGINATION->new_show_pages_videos("t=$Type&style=d&d=$Date") ?><?php elseif(!isset($_GET["style"]) && $_GET["category"] == 0 and (!isset($_GET["r"]) || $_GET["r"] != 1)) : ?><?php $_PAGINATION->new_show_pages_videos("t=$Type&d=$Date") ?> <?php endif ?>

			<?php if (isset($_GET["style"]) && $_GET["category"] != 0 && (isset($_GET["r"]) && $_GET["r"] != 1)) : ?><?php $_PAGINATION->new_show_pages_videos("t=$Type&style=d&category=".$_GET["category"]) ?><?php elseif(!isset($_GET["style"]) && $_GET["category"] != 0 && (isset($_GET["r"]) && $_GET["r"] != 1)) : ?><?php $_PAGINATION->new_show_pages_videos("t=$Type&category=".$_GET["category"]) ?> <?php endif ?>
		
			<?php if(isset($_GET["r"]) && $_GET["r"] == 1) : ?><?php $_PAGINATION->new_show_pages_videos("r=".$_GET['r']."") ?> <?php endif ?>
		</div>
</div>
<?php if ($Type == 1 && (!isset($_GET["r"]) || $_GET["r"] != 1)): ?>
<div class="hot-trends-bottom"><div class="hot-trends-cloud-area yt-rounded">
	<div class="hot-trends-title"><?= $LANGS['trendingtopics'] ?></div>
	<div class="hot-trends-cloud-inner-area yt-rounded">
		<?php foreach ($Popular_All_Tags as $Tag => $Amount) : ?>
                <span class="hot-trends-cloud-rank<?= random_int(0,5) ?>"><a class="hLink" href="results?search=<?= $Tag ?>&t=Search+Videos"><?= $Tag ?></a></span>
            <?php endforeach ?>
	</div>
	<div class="clear"></div>
</div>
</div>
<?php endif ?>

		</div>

	</div>
</div>

<div id="right-column">
	<div id="sideAd" z-index="10" style="width: auto; height: auto;">       
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- bitviewside -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:120px;height:240px;margin:10px 0"
                 data-ad-client="ca-pub-8433080377364721"
                 data-ad-slot="9813736805"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
</div>
<div class="clear"></div>
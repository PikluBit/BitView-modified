<div id="sectionHeader" class="communityColor">
	<div class="name" align="left" style="width:500px;"><?= $LANGS['aboutus'] ?></div>
</div><br>

<span class="highlight"><?= $LANGS['abouttitle'] ?></span>
<br><br>
    <?= $LANGS['aboutdesc'] ?>
<ul>
    <li> <?= $LANGS['about1'] ?>
    </li><li> <?= $LANGS['about2'] ?>
    </li><li> <?= $LANGS['about3'] ?>
    </li><li> <?= $LANGS['about4'] ?>
    </li><li> <?= $LANGS['about5'] ?>
    </li></ul>
<?php if (!$_USER->Logged_In) : ?>
    <br><span class="highlight"><?= $LANGS['aboutsignup'] ?></span><br><br>
<?php endif ?>
<?= $LANGS['abouthelp'] ?>
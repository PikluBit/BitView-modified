<div id="sectionHeader" class="communityColor">
	<div class="name" align="left" style="width:500px;"><?= $LANGS['help'] ?></div>
</div><br>
<?php if ($_USER->Logged_In) : ?>
<span class="highlight"><?= $LANGS['q1'] ?></span>
<br><br><?= $LANGS['a1'] ?>
<br/>
<br/>
<?php endif ?>
<span class="highlight"><?= $LANGS['q2'] ?></span>

<br><br><?= $LANGS['a2'] ?>

<br><br><span class="highlight"><?= $LANGS['q3'] ?></span>

<br><br><?= $LANGS['a3'] ?>

<br><br><span class="highlight"><?= $LANGS['q4'] ?></span>

<br><br><?= $LANGS['a4'] ?>

<br><br><span class="highlight"><?= $LANGS['q5'] ?></span>

<br><br><?= $LANGS['a5'] ?>

<br><br><span class="highlight"><?= $LANGS['q6'] ?></span>

<br><br><?= $LANGS['a6'] ?>

<br><br><span class="highlight"><?= $LANGS['q7'] ?></span>

<br><br><?= $LANGS['a7'] ?>

<br><br><span class="highlight"><?= $LANGS['q8'] ?></span>

<br><br><?= $LANGS['a8'] ?>

<br><br><span class="highlight"><?= $LANGS['q9'] ?></span>

<br><br><?= $LANGS['a9'] ?><br>

<br><span class="highlight"><?= $LANGS['q10'] ?></span>

<br><br><?= $LANGS['a10'] ?><br>
<br><span class="highlight"><?= $LANGS['q12'] ?></span>

<br><br>A: <a href="/help?html5=<?php if (!isset($_COOKIE["html5_player"])) : ?>1<?php else : ?>0<?php endif ?>" style="font-weight:bold"><?php if (!isset($_COOKIE["html5_player"])) : ?><?= $LANGS['activate'] ?><?php else : ?><?= $LANGS['deactivate'] ?><?php endif ?> Flash Player</a>
<?php if(!isset($_COOKIE["html5_player"])) : ?><br><br><?= $LANGS['flashdisclaimer'] ?> <?php endif ?>
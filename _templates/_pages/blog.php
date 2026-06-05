<?php use function PHP81_BC\strftime; ?>
<style>
    h2.blog-date {
    margin: 0 28px 0 0;
    font-size: 85%;
    line-height: 2em;
    text-transform: uppercase;
    letter-spacing: .2em;
    color: #000000;
}
.post h3 {
    margin: 0;
    line-height: 1.5em;
    display: block;
    border: 1px dotted #ffffff;
    border-width: 0 1px 1px;
    padding: 2px 14px 2px 0;
    color: #000000;
    font: normal bold 135% Arial, sans-serif;
}
.post {
    margin-bottom: 24px;
    padding: 10px;
    width: 680px;
}
#blog-head-left {
    border:0;
    padding-bottom: 0px;
    color: #000;
}
</style>
<h3 class="blog-title" style="padding-bottom: 16px;"><img src="/img/blog.png"></h3>
<?php if ($Blog_Amount > 0) : ?>
    <?php foreach ($Blog_Posts as $Blog_Post) : ?>
    <div class="post" id="<?= $Blog_Post['id'] ?>">
    <div id="blog-head">
    <div id="blog-head-left" style="width: auto !important;">
    <h2 class="blog-date">
        <?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['blogpostformat'], time_machine(strtotime((string) $Blog_Post["submit_on"]))); }
                    else {echo strftime($LANGS['blogpostformat'], strtotime((string) $Blog_Post["submit_on"])); }  ?>
        </h2><br>
    <h3><?= $Blog_Post["title"] ?></h3>
    </div>
    <div class="clearL"></div>
</div>
    
        <div style="padding:10px 14px 1px 0">
            <?= nl2br(htmlspecialchars_decode((string) $Blog_Post["content"])) ?>
        </div>
    </div>
    <?php endforeach ?>
<?php endif ?>

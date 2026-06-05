<?php use function PHP81_BC\strftime; ?>
<style>
.header-element {
    border-bottom: 1px solid #999;
    border-right: 1px solid #999;
    padding: 2px 4px;
    font-size: 11px;
    background: transparent url(/img/mmgrads-vfl38740.gif) repeat-x scroll 0 0;
}
.archivetable {
    border: 1px solid #999;
}
.element {
    padding: 4px;
}
.pagingDiv {
    background: white;
    border: 1px solid #999;
    border-top: 0;
}
</style>
<?php if (!isset($_GET['b'])): ?>
<h1>Bulletin Archive</h1>
<div>Here you can read all the bulletins posted by you and your friends.</div>
<br>
<table width="960" style="border-spacing: 0;" class="archivetable">
    <tbody>
        <tr class="header">
            <td class="header-element">Author</td><td width="75%" class="header-element">Subject</td><td class="header-element" width="10%" style="border-right:0">Posted on</td>
        </tr>
        <?php $Count = 0 ?>
        <?php if ($Bulletins_Pagination): ?>
        <?php foreach ($Bulletins_Pagination as $Bulletin): ?>
        <?php $Count++ ?>
        <tr class="elements" <?php if ($Count % 2) : ?><?php else : ?>style="background:#f0f0f0;"<?php endif ?>>
            <td class="element"><a href="/user/<?=($Bulletin['by_user']) ?>"><?= displayname($Bulletin['by_user']) ?></a></td>
            <td class="element"><a href="/bulletin_archive?b=<?=($Bulletin['id']) ?>"><?= $Bulletin['subject'] ?></a></td>
            <td class="element"><?php if (isset($_COOKIE['time_machine'])): ?>
                                    <?= date($LANGS['timenumberformat'], time_machine(strtotime((string) $Bulletin["submit_date"]))) ?>
                                <?php else: ?>
                                    <?= date($LANGS['timenumberformat'], strtotime((string) $Bulletin["submit_date"])) ?>
                                <?php endif ?></td>
        </tr>
        <?php endforeach?>
        <?php endif?>
    </tbody>
</table>
<div class="pagingDiv">
    <?php $_PAGINATION->new_show_pages_videos("") ?>
</div>
<?php else:?>
<div><a href="/bulletin_archive"><----- Go Back</a></div>
<h1><?= $Bulletin_Content['subject'] ?></h1> 
<p><a href="/user/<?=($Bulletin_Content['by_user']) ?>"><?= displayname($Bulletin_Content['by_user']) ?></a> | <?php setlocale(LC_TIME, $LANGS['languagecode']);
                    if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['myvideostimeformat'], time_machine(strtotime((string) $Blog_Post["submit_on"]))); }
                    else {echo strftime($LANGS['myvideostimeformat'], strtotime((string) $Blog_Post["submit_on"])); }  ?></p> 
<p><?= links(nl2br((string) $Bulletin_Content['content'])) ?></p> 
<?php if ($Bulletin_Comments): ?>
<h2>Comments</h2>
<?php foreach ($Bulletin_Comments as $Comment): ?>
<div id="cid_<?= $Comment["id"] ?>" class="watch-comment-entry">
<div class="watch-comment-head">
    <div class="watch-comment-info">
        <a class="watch-comment-auth" href="/user/<?= $Comment["by_user"] ?>" rel="nofollow"><?= displayname($Comment["by_user"]) ?></a>
        <span class="watch-comment-time"> (<?= get_time_ago($Comment["submit_date"]) ?>) </span>
    </div>             
    <div class="clearL"></div>
</div>
<div id="comment_body_commentid">
    <div class="watch-comment-body">
        <?= $Comment["content"] ?></div>
    <div id="div_comment_form_id_commentid"></div>
</div>
</div>
<?php endforeach ?>
<?php endif ?>
<?php endif ?>
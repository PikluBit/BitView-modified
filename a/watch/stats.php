<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
use function PHP81_BC\strftime;

$_VIDEO = new Video($_GET["url"],$DB);

if ($_VIDEO->exists()) {
    $_VIDEO->get_info();
    $_VIDEO->check_info();
}

$Total_Ratings = $_VIDEO->Info["1stars"] + $_VIDEO->Info["2stars"] + $_VIDEO->Info["3stars"] + $_VIDEO->Info["4stars"] + $_VIDEO->Info["5stars"];

$Responses_Amount = $DB->execute("SELECT count(*) as num FROM videos_responses WHERE basevid_id = :URL",true,[":URL" => $_VIDEO->URL])['num'];

$Video_Views_Ranking     = $DB->execute("SELECT 1 + (SELECT count( * ) FROM videos a WHERE a.views > b.views AND privacy = 1 AND is_deleted IS NULL AND uploaded_by_banned = 0) AS rank FROM videos b WHERE url = :URL AND privacy = 1 AND is_deleted IS NULL AND uploaded_by_banned = 0 ORDER BY rank LIMIT 1 ;",true,[":URL" => $_VIDEO->URL])["rank"];
$Video_Favorites_Ranking = $DB->execute("SELECT 1 + (SELECT count( * ) FROM videos a WHERE a.favorites > b.favorites AND privacy = 1 AND is_deleted IS NULL AND uploaded_by_banned = 0) AS rank FROM videos b WHERE url = :URL AND privacy = 1 AND is_deleted IS NULL AND uploaded_by_banned = 0 ORDER BY rank LIMIT 1 ;",true,[":URL" => $_VIDEO->URL])["rank"];
$Video_Comments_Ranking  = $DB->execute("SELECT 1 + (SELECT count( * ) FROM videos a WHERE a.comments > b.comments AND privacy = 1 AND is_deleted IS NULL AND uploaded_by_banned = 0) AS rank FROM videos b WHERE url = :URL AND privacy = 1 AND is_deleted IS NULL AND uploaded_by_banned = 0 ORDER BY rank LIMIT 1 ;",true,[":URL" => $_VIDEO->URL])["rank"];
$Video_Ratings_Ranking  = $DB->execute("SELECT 1 + (SELECT count( * ) FROM videos a WHERE a.5stars > b.5stars AND privacy = 1 AND is_deleted IS NULL AND uploaded_by_banned = 0) AS rank FROM videos b WHERE url = :URL AND privacy = 1 AND is_deleted IS NULL AND uploaded_by_banned = 0 ORDER BY rank LIMIT 1 ;",true,[":URL" => $_VIDEO->URL])["rank"];

$Links = $DB->execute("SELECT * FROM videos_links WHERE url = :URL ORDER BY clicks DESC LIMIT 5",false,[":URL" => $_VIDEO->URL]);
if ($DB->Row_Num == 0) {
    $Links = false;
}
?>

<div id="watch-stats" class="yt-rounded">
    <table id="watch-some-stats" cellspacing="0" cellpadding="0">

        <tbody><tr>
            <td><?= $LANGS['statadded'] ?>: <span class="watch-stat">
                <?php setlocale(LC_TIME, $LANGS['languagecode']);
            if (isset($_COOKIE['time_machine'])) { echo strftime($LANGS['timehourformat'], time_machine(strtotime((string) $_VIDEO->Info["uploaded_on"]))); }
            else {echo strftime($LANGS['timehourformat'], strtotime((string) $_VIDEO->Info["uploaded_on"])); }  ?></span></td>
            <td><?= $LANGS['statviews'] ?>: <span class="watch-stat"><?php if($_VIDEO->Info["url"] == "0MRdwLZ7fiM") : ?>
                        301
                    <?php else : ?>
                        <?php if ($LANGS['numberformat'] == 1): ?><?= number_format($_VIDEO->Info["views"]) ?><?php else: ?><?= ($_VIDEO->Info["views"]) ?><?php endif ?>
                    <?php endif ?></span></td>
            <td><?= $LANGS['statratings'] ?>: <span class="watch-stat"><?php if ($LANGS['numberformat'] == 1): ?><?= number_format($Total_Ratings) ?><?php else: ?><?= ($Total_Ratings) ?><?php endif ?></span></td>
        </tr>
        <tr>
            <td><?= $LANGS['statresponses'] ?>: <a class="hLink bold" href="/video_response_view_all?v=<?= $_VIDEO->Info['url'] ?>" onmousedown=""><?= number_format($Responses_Amount) ?></a></td>
            <td><?= $LANGS['statcomments'] ?>: <a href="/comment_servlet?all_comments&v=<?= $_VIDEO->Info['url'] ?>" class="hLink bold"><?= number_format($_VIDEO->Info["comments"]) ?></a></td>
            <td><?= $LANGS['statfavorited'] ?>: <span class="watch-stat"><?= number_format($_VIDEO->Info["favorites"]) ?> <?= $LANGS['times'] ?></span></td>
        </tr>
        </tbody></table>
    <h4 style="border-top: 1px solid #ccc;padding: 6px 0px;"><?= $LANGS['honors'] ?></h4>
    <table id="watch-some-stats" cellspacing="0" cellpadding="0">

        <tbody><tr>
            <td><a href="/browse?t=1">#<?= $Video_Views_Ranking ?> - <?= $LANGS['mostviewed'] ?></a></td>
            <td><a href="/browse?t=4">#<?= $Video_Favorites_Ranking ?> - <?= $LANGS['topfavorited'] ?></a></td>
        </tr>
        <tr>
            <td><a href="/browse?t=3">#<?= $Video_Comments_Ranking ?> - <?= $LANGS['mostdiscussed'] ?></a></td>
            <td><a href="/browse?t=5">#<?= $Video_Ratings_Ranking ?> - <?= $LANGS['toprated'] ?></a></td>
        </tr>
        </tbody></table>
    <?php if ($Links): ?>
    <h4 style="border-top: 1px solid #ccc;padding: 6px 0px;"><?= $LANGS['videolinks'] ?></h4>
    <table id="watch-some-stats" cellspacing="0" cellpadding="0">

        <tbody><tr>
            <div id="watch-refer-list">
                        <div class="header">
        <div class="watch-ref-item">Clicks</div>
        <div class="floatL">URL</div>
        <div class="clearL"></div>
    </div>



            <?php foreach ($Links as $Link) : ?>
                <div class="watch-ref-item"><?= $Link["clicks"] ?></div>
            <div>
                <a class="hLink" rel="nofollow" href="<?= $Link["link"] ?>" target="_top"><?= short_title($Link["link"],60) ?></a>
            
            </div>
        <div class="clearL"></div>
            <?php endforeach ?>
            </div>
        </tr>
        </tbody></table>
    <?php endif ?>
</div>
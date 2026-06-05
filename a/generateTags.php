<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!$_USER->Logged_In)         exit();

$Title = pathinfo((string) $_GET['title'], PATHINFO_FILENAME);
$Tags_V = array_map('trim', array_filter(explode(",",(string) $_GET['tags'])));

if (mb_strlen($Title) > 2) {
    $Video_Tags = $DB->execute("SELECT tags FROM videos WHERE tags REGEXP '^[A-Za-z0-9, ]+$' AND tags LIKE ? AND privacy = 1 AND status = 2 AND is_deleted IS NULL AND uploaded_by_banned = 0 ORDER BY views DESC LIMIT 1000",false,["%".$Title."%"]);
    $Popular_All_Tags = "";
    foreach ($Video_Tags as $Tags) {
        $Popular_All_Tags .= $Tags["tags"].",";
    }
    $Popular_All_Tags = array_filter(explode(",",$Popular_All_Tags));
    unset($Popular_All_Tags["bitview"]);
    unset($Popular_All_Tags["bv:stretch=16:9"]);
    unset($Popular_All_Tags["bv:crop=16:9"]);
    unset($Popular_All_Tags["bv:stretch=4:3"]);
    asort($Popular_All_Tags);
    $Popular_All_Tags = array_reverse(array_splice($Popular_All_Tags,-64));
    $Popular_All_Tags = array_slice($Popular_All_Tags, 0, 10);
    $Popular_All_Tags = array_map('trim', $Popular_All_Tags);
    $Popular_All_Tags = array_unique(array_diff($Popular_All_Tags, $Tags_V));
}
?>
<div class="tag-suggest-title" style="display: block;"><?php if (count($Popular_All_Tags) > 0): ?><span class="tag-suggest-title"><?= $LANGS['suggestions'] ?>:</span><?php foreach ($Popular_All_Tags as $Tag): ?>
<span class="tag" onclick="addTag('<?= $Tag ?>',this);"><span class="tag-add">+</span><?= mb_trim((string) $Tag) ?></span>
<?php endforeach ?>
<?php endif ?>
</div>
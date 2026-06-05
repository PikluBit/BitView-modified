<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

//PERMISSIONS AND REQUIREMENTS
////USER MUST BE LOGGED IN
////REQUIRE $_GET["query"]

if (!isset($_GET["query"])) {
    header("location: /");
    exit();
}

function boldify($text,$query) {
    $text_f = explode(mb_strtolower((string) $query), (string) $text, 2);
    return mb_strtolower((string) $query).'<b>'.$text_f[1].'</b>';
}

$Query = $_GET["query"];
$Suggestions = $DB->execute("SELECT * FROM search WHERE query LIKE :SEARCH and query NOT LIKE '%,%'ORDER BY clicks DESC LIMIT 10", false, [":SEARCH" => $Query."%"],false);

?>
<?php if ($Suggestions):?>
<div class="autoComplete" style="line-height: 13px;position: absolute;background: white;border: 1px solid #999;margin-top: -2px;z-index: 333333;overflow:hidden;left: 0;top: 42px;">
    <?php foreach ($Suggestions as $Suggestion): ?>
    <div class="completeQuery" onmouseover="$(this).addClass('hover')" onmouseout="$(this).removeClass('hover')" onclick="clickSearch('<?= mb_strtolower((string) $Suggestion['query']) ?>');"><?= boldify(mb_strtolower((string) $Suggestion['query']),$Query) ?></div>
    <?php endforeach ?>
    <a href="#" style="padding: 2px 3px;font-size: 10px;text-decoration: underline;float: right; outline: 0;background:white" onclick="$('.autoComplete').remove();return false;"><?= $LANGS['close'] ?></a>
</div>
<?php endif ?>

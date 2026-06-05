<!DOCTYPE HTML>
<html lang="en">
    <head>
        <?php
            if (!isset($_PAGE["head"])) {
                require $_SERVER['DOCUMENT_ROOT']."/_templates/_heads/main.php";
            } else {
                require $_SERVER['DOCUMENT_ROOT']."/_templates/_heads/".$_PAGE["head"].".php";
            }
        ?>
		<style>body { word-break:break-word; }</style>
    </head>
    <body class="date-20100127"> 
        <?php require $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/header_feather.php" ?>
        <div id="baseDiv" class="date-20100127">
        <?php if (!isset($_PAGE["new"])) : ?><div class="wrapper"><?php endif ?>
            <?php require $_SERVER['DOCUMENT_ROOT']."/_templates/_pages/".$_PAGE["Page"].".php" ?>
            <?php if (!isset($_PAGE["new"])) : ?></div><?php endif ?>
        <?php require $_SERVER['DOCUMENT_ROOT']."/_templates/_layout/footer_feather.php" ?>
     </body>
</html>
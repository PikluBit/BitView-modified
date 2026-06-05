<div style="padding:0 5px;margin:0 0 20px">
    <div style="font-size:14px;font-weight:bold;color:#666666;margin-bottom:10px">
        Latest Tags //
    </div>
    <div style="margin-bottom:20px">
        <div>
        <?php foreach ($All_Tags as $Tag => $Amount) : ?>
            <a style="font-size: <?php if ($Amount == 1) : ?>12px<?php else : ?>17px<?php endif ?>" href="results?search=<?= $Tag ?>&t=Search+Videos"><?= $Tag ?></a> :
        <?php endforeach ?>
        </div>
    </div>
    <div style="font-size:14px;font-weight:bold;color:#666666;margin-bottom:10px">
        Most Popular Tags //
    </div>
    <div style="margin-bottom:20px">
        <div>
            <?php foreach ($Popular_All_Tags as $Tag => $Amount) : ?>
                <a style="font-size: <?php if (random_int(0,1) == 1) : ?>22px<?php else : ?>15px<?php endif ?>" href="results?search=<?= $Tag ?>&t=Search+Videos"><?= $Tag ?></a> :
            <?php endforeach ?>
        </div>
    </div>
</div>
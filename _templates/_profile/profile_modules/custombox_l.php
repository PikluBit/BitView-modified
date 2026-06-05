<?php if ($_PROFILE->Info["c_custom_box"] != 0 AND $_PROFILE->Info["is_partner"]) : ?>
    <?php
    $config = HTMLPurifier_Config::createDefault();
    $config->set('HTML.Allowed', 'p,a[href|rel|target|title],b,strong,em,ul,ol,li,br');
    $config->set('AutoFormat.RemoveEmpty', true);
    $config->set('AutoFormat.AutoParagraph', true);
    $purifier = new HTMLPurifier($config);

    $info = $purifier->purify(htmlspecialchars_decode((string) $_PROFILE->Info["custom_box"]));
    ?>
<div class="inner-box" id="user_branding">
<div style="zoom:1">
<div class="box-title title-text-color">
<?= $_PROFILE->Info["custom_box_title"] ?>
</div>
<?php if ($_PROFILE->Username == $_USER->Username): ?><div class="updown_arrows "><img id="user_branding-left-arrow" src="/img/pixel.gif" class="module-left-arrow disabled"><img id="user_branding-up-arrow" src="/img/pixel.gif" class="module-up-arrow <?php if ($Modules_L[0] == "custombox"): ?> disabled<?php endif ?>" onclick="move_up('branding');return false"><img id="user_branding-down-arrow" src="/img/pixel.gif" class="module-down-arrow <?php if (end($Modules_L) == "custombox"): ?>disabled<?php endif ?>" onclick="move_down('branding');return false"><img id="user_branding-right-arrow" src="/img/pixel.gif" class="module-right-arrow" onclick="move_right('branding')"></div><?php endif ?>
<div style="float:right;zoom:1;_display:inline;white-space:nowrap">
<div style="float:right">
</div>
</div>
<div class="cb"></div>
</div>


<div id="user_branding-messages" style="color:#333;margin:1em;padding:1em;display:none"></div>

<div id="user_branding-body">
<?= $info ?>
</div>
<div class="clear"></div>
</div>
<?php endif ?>

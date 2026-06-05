<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

$_VIDEO = new Video($_GET["url"],$DB);

if ($_VIDEO->exists()) {
    $_VIDEO->get_info();
    $_VIDEO->check_info();
}

?>

<div id="watch-actions-flag-inside">
<div class="watch-actions-flag">
        <div class="close-button" onclick="hideDiv(this);"></div>
    <?php if (!$_USER->Logged_In) : ?>
                <div id="addToPlaylistLogin" class="watch-login-action">
                    <div class="close">(<a href="#" title="close this layer" class="eLink" onclick="watchSelectTab('watch-tab-share');"><?= $LANGS['close'] ?></a>)</div>
                    <div class="spacer">&nbsp;</div>
                    <?= $LANGS['logintopl'] ?>
                </div>
            <?php endif ?>
        </div>
        <div id="watch-tab-flag-body" class="watch-tab-body">
            <div id="inappropriateVidDiv" class="watch-more-action">
            <?php if (!$_USER->has_flagged($_VIDEO)): ?>
                <div style="font-weight:bold;margin-bottom: 4px;"><?= $LANGS['reportvideotitle'] ?></div><div id="flag-desc"><?= $LANGS['reportvideodesc'] ?></div><br>
            <div>
                <button id="watch-flag-select" class="yt-uix-in" onclick="openFlagDropdown(this);" type="button">
                <?= $LANGS['selectareason'] ?>
                </button>
                <ul id="flag-dropdown" onmouseout="hideSubcategories();" class="yt-uix-in-drop hid" style="min-width: 220px;">
                    <li><span href="#" class="yt-uix-button-menu-item" onclick="return false;" onmouseover="showSubcategory(1,this);"><?= $LANGS['flagcat1'] ?></span></li>
                    <li><span href="#" class="yt-uix-button-menu-item" onclick="return false;" onmouseover="showSubcategory(2,this);"><?= $LANGS['flagcat2'] ?></span></span></li>
                    <li><span href="#" class="yt-uix-button-menu-item" onclick="return false;" onmouseover="showSubcategory(3,this);"><?= $LANGS['flagcat3'] ?></span></span></li>
                    <li><span href="#" class="yt-uix-button-menu-item" onclick="return false;" onmouseover="showSubcategory(4,this);"><?= $LANGS['flagcat4'] ?></span></span></li>
                    <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(5,this);return false;"><?= $LANGS['flagcat5'] ?></span></li>
                    <li><span href="#" class="yt-uix-button-menu-item" onclick="return false;" onmouseover="showSubcategory(6,this);"><?= $LANGS['flagcat6'] ?></span></span></li>
                    <li><span href="#" class="yt-uix-button-menu-item" onclick="return false;" onmouseover="showSubcategory(7,this);"><?= $LANGS['flagcat7'] ?></span></span></li>
                </ul>
            <ul id="flag-dropdown-1" onmouseenter="stayCategory(1)" onmouseleave="hideSubcategory(1)" class="yt-uix-in-drop yt-uix-in-drop-sub yt-uix-button-menu-text hid" style="min-width: 150px">
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(1.1,this);return false;"><?= $LANGS['flagcat1_1'] ?></span></li>
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(1.2,this);return false;"><?= $LANGS['flagcat1_2'] ?></span></li>
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(1.3,this);return false;"><?= $LANGS['flagcat1_3'] ?></span></li>
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(1.4,this);return false;"><?= $LANGS['flagcat1_4'] ?></span></li>
            </ul>
            <ul id="flag-dropdown-2" onmouseenter="stayCategory(2)" onmouseleave="hideSubcategory(2)" class="yt-uix-in-drop yt-uix-in-drop-sub yt-uix-button-menu-text hid" style="min-width: 150px">
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(2.1,this);return false;"><?= $LANGS['flagcat2_1'] ?></span></li>
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(2.2,this);return false;"><?= $LANGS['flagcat2_2'] ?></span></li>
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(2.3,this);return false;"><?= $LANGS['flagcat2_3'] ?></span></li>
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(2.4,this);return false;"><?= $LANGS['flagcat2_4'] ?></span></li>
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(2.5,this);return false;"><?= $LANGS['flagcat2_5'] ?></span></li>
            </ul>
            <ul id="flag-dropdown-3" onmouseenter="stayCategory(3)" onmouseleave="hideSubcategory(3)" class="yt-uix-in-drop yt-uix-in-drop-sub yt-uix-button-menu-text hid" style="min-width: 150px">
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(3.1,this);return false;"><?= $LANGS['flagcat3_1'] ?></span></li>
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(3.2,this);return false;"><?= $LANGS['flagcat3_2'] ?></span></li>
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(3.3,this);return false;"><?= $LANGS['flagcat3_3'] ?></span></li>
            </ul>
            <ul id="flag-dropdown-4" onmouseenter="stayCategory(4)" onmouseleave="hideSubcategory(4)" class="yt-uix-in-drop yt-uix-in-drop-sub yt-uix-button-menu-text hid" style="min-width: 150px">
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(4.1,this);return false;"><?= $LANGS['flagcat4_1'] ?></span></li>
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(4.2,this);return false;"><?= $LANGS['flagcat4_2'] ?></span></li>
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(4.3,this);return false;"><?= $LANGS['flagcat4_3'] ?></span></li>
            </ul>
            <ul id="flag-dropdown-6" onmouseenter="stayCategory(6)" onmouseleave="hideSubcategory(6)" class="yt-uix-in-drop yt-uix-in-drop-sub yt-uix-button-menu-text hid" style="min-width: 150px">
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(6.1,this);return false;"><?= $LANGS['flagcat6_1'] ?></span></li>
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(6.2,this);return false;"><?= $LANGS['flagcat6_2'] ?></span></li>
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(6.3,this);return false;"><?= $LANGS['flagcat6_3'] ?></span></li>
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(6.4,this);return false;"><?= $LANGS['flagcat6_4'] ?></span></li>
            </ul>
            <ul id="flag-dropdown-7" onmouseenter="stayCategory(7)" onmouseleave="hideSubcategory(7)" class="yt-uix-in-drop yt-uix-in-drop-sub yt-uix-button-menu-text hid" style="min-width: 150px">
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(7.1,this);return false;"><?= $LANGS['flagcat7_1'] ?></span></li>
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(7.2,this);return false;"><?= $LANGS['flagcat7_2'] ?></span></li>
                <li><span href="#" class="yt-uix-button-menu-item" onclick="setFlag(7.3,this);return false;"><?= $LANGS['flagcat7_3'] ?></span></li>
            </ul>
            <div class="box hatred hid">
                <span><?= $LANGS['flaghatred1'] ?></span>
                <select id="hatred-group">
                    <option>-</option>
                    <option value="age"><?= $LANGS['flaggroup1'] ?></option>
                    <option value="color"><?= $LANGS['flaggroup2'] ?></option>
                    <option value="disability"><?= $LANGS['flaggroup3'] ?></option>
                    <option value="ethnic_origin"><?= $LANGS['flaggroup4'] ?></option>
                    <option value="gender_identity"><?= $LANGS['flaggroup5'] ?></option>
                    <option value="national_origin"><?= $LANGS['flaggroup6'] ?></option>
                    <option value="race"><?= $LANGS['flaggroup7'] ?></option>
                    <option value="religion"><?= $LANGS['flaggroup8'] ?></option>
                    <option value="sex"><?= $LANGS['flaggroup9'] ?></option>
                    <option value="sexual_orientation"><?= $LANGS['flaggroup10'] ?></option>
                    <option value="veteran_status"><?= $LANGS['flaggroup11'] ?></option>
                </select>
                <span style="margin-top: 30px"><br><br><br><?= $LANGS['flaghatred2'] ?></span><br>
                <textarea id="hatred-more-info"></textarea>
            </div>
            <div class="box time hid">
                <span><?= $LANGS['flagtimestamp'] ?></span>
                <input type="text" name="flag_minutes">:<input type="text" name="flag_seconds">
            </div>
            &nbsp;<button id="flag-this-video" class="master-sprite-new yt-uix-button" style="vertical-align: top;height: 24px;" onclick="flagThisVideo();" type="button"><span class="yt-uix-button-content"><?= $LANGS['flagthisvid'] ?></span>
            </button>
        </div>
        <?php else: ?>
            <img class="watch-check-grn-circle" src="/img/check-grn-circle-vfl91176.png" style="float: left;margin-right: 8px;"> <div style="height: 16px;line-height: 16px;"><?= $LANGS['thankyouflag'] ?></div>
        <?php endif?>
        </div>
            <?php if (!$_USER->Logged_In) : ?>
                <div id="inappropriateMsgsLogin" class="watch-login-action">
                    <div class="close">(<a href="#" title="close this layer" class="eLink" onclick="watchSelectTab('watch-tab-share');"><?= $LANGS['close'] ?></a>)</div>
                    <div class="spacer">&nbsp;</div>
                    <?= $LANGS['logintoflag'] ?>
                </div>
            <?php endif ?>
    </div>
</div>
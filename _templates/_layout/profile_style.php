<style>
body
.headerBox {
    border: 1px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
    border-bottom:0!important;
    height: 14px;
    line-height: 14px;
}
#highlight.headerBox {
    border: 1px solid #<?= $_PROFILE->Info["c_highlight_header"] ?> !important;
    min-height: 25px;
    max-height: 50px;
    height: unset;
    border-top: 0!important;
}
a{text-decoration:none;}a:hover{text-decoration:underline;}
h1, h2, h3, h4, h5, h6 {
  color: #<?= $_PROFILE->Info["c_normal_font"] ?> !important;
}
tr.commentsTableNBFull td {
  border-bottom: 1px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
}
tr.bulletinTableFull td { 
  border-bottom: 1px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
  border-right: 1px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
}
.headerTitleLeft, .headerTitle {
  color: #<?= $_PROFILE->Info["c_title_font"] ?> !important;
}
.headerTitle>div a {
    color: #<?= $_PROFILE->Info["c_title_font"] ?>!important;
}
tr.bulletinTableFull th {
  border-bottom: 1px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
  border-right: 1px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
}
tr.bulletinTableNBFull td {
  background-color: #<?= $_PROFILE->Info["c_highlight_header"] ?>;
  border-bottom: 1px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
  border-right: 1px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
}
#masthead-container {
    border-bottom: 3px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
}
.bulletinTableFull {
  background-color: #<?= $_PROFILE->Info["c_normal_inner"] ?> !important;
}
.video-thumb-micro, .video-thumb-small, .video-thumb-medium, .video-thumb-large, .video-thumb-jumbo {
  border: 3px double #<?= $_PROFILE->Info["c_highlight_header"] ?> !important;
  background-color: #<?= $_PROFILE->Info["c_highlight_inner"] ?> !important;
}
.vimg90 {
  border: 1px solid #<?= $_PROFILE->Info["c_highlight_header"] ?> !important;
}
.imgBrdr {
  border: 1px solid #<?= $_PROFILE->Info["c_highlight_header"] ?> !important;
}
.headerBoxOpacity[class] {
    background-color: #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
}
#highlight.headerBoxOpacity[class] {
    background-color: #<?= $_PROFILE->Info["c_highlight_header"] ?> !important;
}
.basicBoxesOpacity[class] {
    background-color: #<?= $_PROFILE->Info["c_normal_inner"] ?> !important;
}
.headerRCBox .content  {
  background: #<?= $_PROFILE->Info["c_normal_header"] ?>  !important;
}
.headerRCBox .rch * {
  background: #<?= $_PROFILE->Info["c_normal_header"] ?>  !important;
}
.headerTitleEdit {
  color:#<?= $_PROFILE->Info["c_title_font"] ?>  !important;
}
.headerRCBox .rch1 {
  border-right: 1px solid #<?= $_PROFILE->Info["c_highlight_header"] ?> !important;
  border-left: 1px solid #<?= $_PROFILE->Info["c_highlight_header"] ?> !important;
}
.footerBox {
  background-color: #<?= $_PROFILE->Info["c_normal_inner"] ?> !important;
  border: 1px solid #<?= $_PROFILE->Info["c_normal_inner"] ?> !important;
}
.pagingDiv {
  background: #<?= $_PROFILE->Info["c_normal_inner"] ?>!important;
  color: #<?= $_PROFILE->Info["c_normal_font"] ?> !important;
}
#profileSubNav .delimiter, #profileSubNav strong {
  color: #<?= $_PROFILE->Info["c_link_color"] ?>!important;
}
.pagerCurrent {
  color: #<?= $_PROFILE->Info["c_normal_font"] ?>  !important;
}
.headerRCBox .rch2 {
  border-right: 1px solid #<?= $_PROFILE->Info["c_highlight_header"] ?> !important;
  border-left: 1px solid #<?= $_PROFILE->Info["c_highlight_header"] ?> !important;
}
.headerRCBox .rch3 {
  border-right: 1px solid #<?= $_PROFILE->Info["c_highlight_header"] ?> !important;
  border-left: 1px solid #<?= $_PROFILE->Info["c_highlight_header"] ?> !important;
}
.headerRCBox .rch4 {
  border-right: 1px solid #<?= $_PROFILE->Info["c_highlight_header"] ?> !important;
  border-left: 1px solid #<?= $_PROFILE->Info["c_highlight_header"] ?> !important;
}
.headerRCBox .rch5 {
  border-right: 1px solid #<?= $_PROFILE->Info["c_highlight_header"] ?> !important;
  border-left: 1px solid #<?= $_PROFILE->Info["c_highlight_header"] ?> !important;
}
a.masthead:visited {
  color: #03C !important;
}
a.masthead:link {
  color: #03C !important;
}
a.masthead:active {
  color: #03C !important;
}
a.headerLink:visited {
  color: #03C !important;
}
a.headerLink:link {
  color: #03C !important;
}
a.headerLink:active {
  color: #03C !important;
}
#profileSubNav {
    color: #<?= $_PROFILE->Info["c_normal_font"] ?> !important;
}
a:link, a:visited, a:active {
    color: #<?= $_PROFILE->Info["c_link_color"] ?> !important;
}
body { 
background-color: #<?= $_PROFILE->Info["c_background"] ?> !important; 
<?php if($_PROFILE->Info["c_background_image"]) : ?>
background-image: url(<?= cache_bust($_PROFILE->Info["c_background_image"]) ?>);
<?php if($_PROFILE->Info["c_background_image_fixed"] == 1) : ?>background-attachment: fixed;<?php endif ?>
<?php if($_PROFILE->Info["c_background_image_repeat"] == 1) : ?>background-repeat: repeat;<?php elseif($_PROFILE->Info["c_background_image_repeat"] == 2) : ?>background-repeat: repeat-x;<?php elseif ($_PROFILE->Info["c_background_image_repeat"] == 3) : ?>background-repeat: repeat-y;<?php elseif($_PROFILE->Info["c_background_image_repeat"] == 0) : ?>background-repeat: no-repeat;<?php endif ?> 
<?php if($_PROFILE->Info["c_background_image_position"] == 0) : ?>background-position: top;<?php elseif ($_PROFILE->Info["c_background_image_position"] == 1) : ?>background-position: center;<?php elseif ($_PROFILE->Info["c_background_image_position"] == 2) : ?>background-position: bottom;<?php endif ?>
background-size: auto;
<?php endif ?>
}
#pBox {
    margin-bottom: 15px;
    font-family: <?= $_PROFILE->Info["c_font"] ?>,<?php if($_PROFILE->Info["c_font"] == "Arial" or $_PROFILE->Info["c_font"] == "Verdana") : ?>sans-serif<?php elseif($_PROFILE->Info["c_font"] == "Georgia" or $_PROFILE->Info["c_font"] == "Times New Roman") : ?>serif<?php elseif($_PROFILE->Info["c_font"] == "Courier New") : ?>monospace<?php endif ?>!important;
    color:#<?= $_PROFILE->Info["c_header_font"] ?>;
    width:298px;
}
.headerTitleRight a {
    color: #<?= $_PROFILE->Info["c_header_font"] ?>!important;
}
.marB5 a {
    font-family: <?= $_PROFILE->Info["c_font"] ?>,<?php if($_PROFILE->Info["c_font"] == "Arial" or $_PROFILE->Info["c_font"] == "Verdana") : ?>sans-serif<?php elseif($_PROFILE->Info["c_font"] == "Georgia" or $_PROFILE->Info["c_font"] == "Times New Roman") : ?>serif<?php elseif($_PROFILE->Info["c_font"] == "Courier New") : ?>monospace<?php endif ?>!important;
    font-size: 10px;
}
.headerTitleEdit, .padT5.profileAssets a, .profileTitleLinks, .profileTitleLinks a, .flaggingText, .flaggingText a, .vfacets, .action-button .action-button-text, .vfacets a, .BoxesInnerOpacity, .vtitle a, .video-title a, .video-username a, #profileVideos a, .headerTitleLeft, .headerTitle, a.headersSmall, .comment-top a, .comments-bottom a, .bulletinTable a, .BoxesInnerOpacity a, .pagerCurrent, .pagerNotCurrent, #mainContent, .edit, h1, h2, h3, h4, h5, h6, .headerTitle>div a, .box-head, .profile-box .box-foot, .share-box .box-title, .share-box {
    font-family: <?= $_PROFILE->Info["c_font"] ?>,<?php if($_PROFILE->Info["c_font"] == "Arial" or $_PROFILE->Info["c_font"] == "Verdana") : ?>sans-serif<?php elseif($_PROFILE->Info["c_font"] == "Georgia" or $_PROFILE->Info["c_font"] == "Times New Roman") : ?>serif<?php elseif($_PROFILE->Info["c_font"] == "Courier New") : ?>monospace<?php endif ?>!important;
}
#embed_code {
    color: #<?= $_PROFILE->Info["c_normal_font"] ?>;
    border-color:#<?= $_PROFILE->Info["c_normal_header"] ?>;
font-family: <?= $_PROFILE->Info["c_font"] ?>,<?php if($_PROFILE->Info["c_font"] == "Arial" or $_PROFILE->Info["c_font"] == "Verdana") : ?>sans-serif<?php elseif($_PROFILE->Info["c_font"] == "Georgia" or $_PROFILE->Info["c_font"] == "Times New Roman") : ?>serif<?php elseif($_PROFILE->Info["c_font"] == "Courier New") : ?>monospace<?php endif ?>!important;
}
.highlightBoxesOpacity[class] {
    background: #<?= $_PROFILE->Info["c_highlight_inner"] ?> !important;
}
.basicBoxes.profileEmbedVideoInfo {
    border-top: 1px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
}
.video-page {
    border: 1px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
    margin-bottom: 15px;
}
.basicBoxes {
    border: 1px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
    border-top:0!important;
    color: #<?= $_PROFILE->Info["c_normal_font"] ?>;
}
.channelLeftColumn .basicBoxes {
    width: 298px;
}
.highlightBoxes {
    border: 1px solid #<?= $_PROFILE->Info["c_highlight_header"] ?> !important;
    color: #<?= $_PROFILE->Info["c_normal_font"] ?>;
}
.vfacets, .runtime {
    color: #<?= $_PROFILE->Info["c_normal_font"] ?> !important;
}
a.headersSmall {
    color: #<?= $_PROFILE->Info["c_title_font"] ?> !important;
    font-size: 14px!important;
}
.vfacets a:link, a:visited {
    font-size: 11px;
}
.sub_box .basicBoxes {
    border:0!important;
}
.sub_box {
    border:1px solid #<?= $_PROFILE->Info["c_normal_header"] ?>!important;
}
#mainContent .headerBox {
    background-color:#<?= $_PROFILE->Info["c_normal_header"] ?>!important;
}
tr.commentsTableFull td, tr.bulletinTable td {
    border-bottom: 1px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
}
tr.bulletinTable td.firstCol {
    border-right: 1px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
}
.user-thumb-micro, .user-thumb-small, .user-thumb-medium, .user-thumb-large, .user-thumb-jumbo, .user-thumb-xlarge {
    border: 3px double #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
    background-color: #<?= $_PROFILE->Info["c_background"] ?> !important;
}
.vimg, .vimg70 {
    border: 1px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
}
.v120WrapperOuter {
    border: 1px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
}
.v120WrapperInner {
    border: 1px solid #<?= $_PROFILE->Info["c_normal_header"] ?> !important;
}
.labels {
    color: #<?= $_PROFILE->Info["c_normal_font"] ?> !important;
}
tr.commentsTableFull td {
    color: #<?= $_PROFILE->Info["c_normal_font"] ?> !important;
}
.flaggingText {
    color: #<?= $_PROFILE->Info["c_normal_font"] ?> !important;
}
.video-page .basicBoxes {
  border:none!important;
}
.vDetailEntry {
    border-top-color: #<?= $_PROFILE->Info["c_normal_header"] ?>;
}
.share-box {
    border-color: #<?= $_PROFILE->Info["c_normal_header"] ?>;
}
.box-head, .profile-box .box-foot, .share-box .box-title {
    background: #<?= $_PROFILE->Info["c_normal_header"] ?>;
    color: #<?= $_PROFILE->Info["c_title_font"] ?>;
}
.share-box .box-title .close-link {
    border-bottom: 1px dotted #<?= $_PROFILE->Info["c_title_font"] ?>;
}
.loading-div {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0.9;
    background: #<?= $_PROFILE->Info["c_normal_inner"] ?>;
    z-index: 2000;
    display: none;
}
</style>

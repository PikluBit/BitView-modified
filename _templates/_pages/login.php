<script src="https://js.hcaptcha.com/1/api.js"
        async defer></script>
<style>
    .hr {
        height: 1px;
        border-bottom: 1px dotted #999;
        margin: 20px 0px;
    }
    .signup-main {
        width: 90%;
        margin:0 auto;
    }
    .signup-title {
        font-weight: bold;
    }
    #verificationImage {
        float: left;
        width: 200px;
    }
    .action-button .end-cap {
        float:left;
    }
    #signup-text {
        margin-left:10px;
        margin-right:30px;
    }
    .img-action-button-cap-left {
        background:transparent url(/img/master-vfl47921.gif) no-repeat scroll -162px -37px;
        height:25px;
        width:5px;
    }
    .img-action-button-cap-right {
        background:transparent url(/img/master-vfl47921.gif) no-repeat scroll -167px -37px;
        height:25px;
        width:5px;
    }
    img {
        border:medium none;
    }
    .action-button .content .title {
        font-size:13px;
        font-weight:bold;
    }
    .signup-link a {
        text-decoration: none;
    }
    .signup-link a:hover {
        text-decoration: underline;
    }
    .signup-outer-frame {
        border-color: #c3d9ff;
        border-style: solid;
        border-width: 1px;
        padding: 4px;
        margin: 0 auto 35px auto;
        font-size: 13px;
    }
    .signup-inner-frame {
        background-color: #e8eefa;
    }
    #signup-bitview-logo {
    padding-bottom: 4px;
    padding-top: 4px;
    width: auto;
    height: 43px;
    vertical-align: middle;
    }
    #signup-gaia-logo {
        height: 31px;
        width: 80px;
    }
    .signup-table {
        width: 100%;
    }
    #suInOrderToDiv {
        background-color: #FFFFCC;
        border: 1px solid #CCCC66;
        margin: 6px 25%;
        padding: 6px;
        font-weight: bold;
    }
    .loginFormLabel {
        text-align: right;
        vertical-align: top;
    }
    .loginFormField {
        width: 160px;
    }
    .alertBoxSm {
        border: 2px solid #C00;
        padding: 6px;
        margin-top: 6px;
        margin-bottom: 6px;
        text-align: left;
        font-weight: bold;
        font-size: 12px;
        color: #000;
    }
    .loginField {
        width: 130px;
    }
    /* password strength */
    .password_empty {
        background-color: #e0e0e0;
        width:100%;
    }
    .password_weak {
        background-color: red;
        width:25%;
    }
    .password_fair {
        background-color: yellow;
        width:50%
    }
    .password_good {
        background-color: #6699CC;
        width:75%;
    }
    .password_strong {
        background-color: green;
        width:100%;
    }
    .invitation {
        width: 500px;
        margin-bottom: 15px;
        text-align: center;
    }
    #pagination-top {
        padding: 25px 0pt 5px;
        text-align: right;
    }
    #main-table {
        width: 875px;
    }
    .blue-button {
        margin: 0;
    }
</style>
<div id="sectionHeader" class="communityColor">
    <div class="name" align="left" style="width:500px;"><?= $LANGS['signintobv'] ?></div>
</div><br>
<div class="signup-main">
    <table cellpadding="0" cellspacing="0" id="main-table">
        <tbody><tr>
            <td width="526" valign="top" style="font-size:13px">
                <div id="suSigninDiv">
                    <div class="signup-title"><?= $LANGS['signindesc1'] ?></div>
                    <p><?= $LANGS['signindesc2'] ?></p>
                    <ul>

                        <li><?= $LANGS['signindesc3'] ?></li>
                        <li><?= $LANGS['signindesc4'] ?></li>
                        <li><?= $LANGS['signindesc5'] ?></li>

                    </ul>
                </div>
            </td>
            <td valign="top" width="335">

                <div id="siSignupDiv" class="signup-outer-frame">
                    <div class="signup-inner-frame">
                        <form name="loginForm" id="loginForm" action="/login<?php if (isset($_GET['next'])): ?>?next=<?= urlencode((string) $_GET['next']) ?><?php endif ?>" method="post">

                            <div style="margin-left:10px;margin-right:10px;">
                                <table class="signup-table" cellspacing="0" cellpadding="4">
                                    <tbody><tr>
                                        <td colspan="2" align="center">
                                            <img id="signup-bitview-logo" src="/img/bitview.png">
                                            <div style="width: 250px; padding-top: 10px;">
  <?= $LANGS['logindesc'] ?>
  </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="loginFormLabel">	<span class="nowrap"><?= $LANGS['username'] ?>:</span>
                                        </td>
                                        <td><input type="text" size="20" maxlength="128" name="username" autocomplete="username"/></td>
                                    </tr>
                                    <tr>
                                        <td class="loginFormLabel">	<span class="nowrap"><?= $LANGS['password'] ?>:</span>
                                        </td>
                                        <td><input type="password" size="20" maxlength="20" name="password" id="password" autocomplete="current-password"/></td>
                                    </tr>
                                    <tr>
                                      <td align="right" valign="top">
                                      <input type="checkbox" name="remember_me" id="remember_me" value="on" checked="checked">
                                      </td>
                                      <td>
                                      <label for="remember_me">
                                      <?= $LANGS['staysigned'] ?>
                                      </label>
                                      </td>
                                    </tr>
                                    <tr>
                                        <td class="loginFormLabel">&nbsp;</td>
                                        <td>
                                                <input type="submit" name="signIn" value="<?= $LANGS['login'] ?>" onclick="document.getElementById('loginForm').submit();">
                                            <?php if ($Failed_Attempts >= 3) : ?>
                                    <tr>
                                        <td></td>
                                        <td><div class="h-captcha" data-sitekey="6ac0d643-6eca-444d-a6d9-274f2de3918d"></div></td>
                                    </tr>
                                    <?php endif ?>
                                            <input type="hidden" name="log_in" value="Log In">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="signup-link smallText" align="center"> <a href="javascript:alert('Password resets are not currently implemented, please try again later.');"><?= $LANGS['forgot'] ?></a></div></td>
                                    </tr>
                                    </tbody></table>
                            </div>
                            <input type="submit" style="display: none;" /> <!-- for enter input -->
                            </form>
                    </div>
                </div>
                <div class="signup-outer-frame">
                    <div class="signup-inner-frame">
                        <table class="signup-table" cellpadding="4" cellspacing="0">
                            <tbody><tr>
                                <td colspan="2" align="center">
                                    <div align="center"><strong><?= $LANGS['noaccount'] ?></strong><br></div>
                                    <div class="signup-link" align="center"> <a href="/signup"><strong><?= $LANGS['signuptobv'] ?></strong></a></div></td>
                            </tr>
                            </tbody></table>
                    </div>
                </div>
            </td>
        </tr>
        </tbody></table>
</div>
<div class="clear"></div>

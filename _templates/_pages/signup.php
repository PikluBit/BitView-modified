<script src="https://js.hcaptcha.com/1/api.js"
        async defer></script>
<script>
    function checkTerms() {
        if (document.getElementById('terms').checked == true) {
            document.getElementById('termsWarning').style.display = 'none';
            document.getElementById('button-signin').style.display = 'block';
            return true;
        }
        else {
            document.getElementById('termsWarning').style.display = 'block';
            document.getElementById('button-signin').style.display = 'none';
            return false;
        }
    }
    function updatePasswordStrength() {
        var password = document.register.password.value;
        var strength = 0;

        // easy_guesses: strings that should not be used in password
        var easy_guesses = new Array();
        easy_guesses.push('password');
        easy_guesses.push('bitview');
        easy_guesses.push('vidlii');

        var email_words = document.register.email.value.match(/\w+/g); // contiguous words contained in email
        if (email_words)
            easy_guesses = easy_guesses.concat(email_words);
        if (document.register.username.value)
            easy_guesses.push(document.register.username.value);

        locase_matches = password.match(/[a-z_]/g); // lowercase and '_' matches
        digit_matches = password.match(/[0-9]/g);   // numeric matches
        upcase_matches = password.match(/[A-Z]/g);  // uppercase matches
        special_matches = password.match(/\W/g);    // special matches (not in a-z, A-Z, 0-9, _)

        if (password.length>5) {
            // for less than 5, leave strength at 0 since password too short

            // 1 point for each character more than 5
            strength += password.length - 5;

            // 1 point for each upcase character mixed with lowercase
            if (locase_matches && upcase_matches)
                strength += upcase_matches.length;

            // 1 point for each numeric character mixed with lowercase
            if (locase_matches && digit_matches)
                strength += digit_matches.length;

            // 1 point for each special characters
            if (special_matches)
                strength += special_matches.length;

            // 2 bonus points if mix of letters, numbers and special
            if ((locase_matches || upcase_matches) && special_matches && digit_matches)
                strength += 2;
        }

        // Reset strength to 0 if any easy guess in password (easy guess should be more than 3 chars)
        for (var i=0; i < easy_guesses.length; ++i) {
            if (easy_guesses[i].length>3 && (password.indexOf(easy_guesses[i])!=-1)) {
                strength=0;
                break;
            }
        }

        var pstrength_elem = document.getElementById('password_strength');
        var pstrength_text = document.getElementById('password_strength_text');
        if (password.length==0) {
            pstrength_elem.className = 'password_empty';
            pstrength_text.innerHTML = "<?= $LANGS['psnone'] ?>";
        }
        else if (strength<3) {
            pstrength_elem.className = 'password_weak';
            pstrength_text.innerHTML = "<?= $LANGS['psweak'] ?>";
        }
        else if (strength<7) {
            pstrength_elem.className = 'password_fair';
            pstrength_text.innerHTML = "<?= $LANGS['psfair'] ?>";
        }
        else if (strength<10) {
            pstrength_elem.className = 'password_good';
            pstrength_text.innerHTML = "<?= $LANGS['psgood'] ?>";
        }
        else {
            pstrength_elem.className = 'password_strong';
            pstrength_text.innerHTML = "<?= $LANGS['psstrong'] ?>";
        }
    }
    function updateUsernameStatus() {
        var username = document.getElementById("username").value;
        $.ajax({
            type: "POST",
            url: "/a/checkUsername",
            data: {
                name: username,
            },
            success: function(output) {
                if (output.response == "success") {
                    document.getElementById("check_username").innerHTML = "<span style='color:green; font-weight:bold'>Username available!</span>";
                }
                else {
                    document.getElementById("check_username").innerHTML = "<span style='color:red; font-weight:bold'>This username is taken!</span>";
                }
            }
        })
    }
</script>
<style type="text/css">

    img {
        border:medium none;
    }
    .hr {
        height: 1px;
        border-bottom: 1px dotted #999;
        margin: 20px 0px;
    }
    .signup-main {
        width: 875px;
    }
    .signup-title {
        font-weight: bold;
    }
    #verificationImage { float: left; width: 200px; }

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
    .action-button .content {
        background: transparent url(/img/master-vfl47921.gif) repeat-x scroll -310px -377px;
        color: #0033CC;
        float: left;
        height: 20px;
        padding: 5px 5px 0pt;
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
        border-color:#c3d9ff;
        border-style:solid;
        border-width:1px;
        margin-bottom:5%;
        margin-left:15%;
        margin-right:15%;
        margin-top:0%;
        padding:5px;
    }
    .signup-inner-frame {
        border-color:#CCCCCC;
        border-style:solid;
        border-width:1px;
        background-color: #e8eefa;
    }
    #signup-youtube-logo {
        padding-bottom:4px;
        padding-top:4px;
        width: 73px;
        height: 29px;
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
    .password_empty {background-color: #e0e0e0; width:100%;}
    .password_weak {background-color: red; width:25%;}
    .password_fair {background-color: yellow; width:50%}
    .password_good {background-color: #6699CC; width:75%;}
    .password_strong {background-color: green; width:100%;}
</style>


<div id="sectionHeader" class="communityColor">
    <div class="name" align="left" style="width:500px;"><?= $LANGS['signuphead'] ?></div>
</div><br>
<div class="signup-main">
    <div id="pagination-top" style="padding: 10px 0pt 5px; text-align: right;"></div>
    <table cellpadding="0" cellspacing="0" style="width:875px;">
        <tbody><tr>
            <td width="40%" valign="top">
                <div id="suSigninDiv">
                    <div id="signup-text">
                        <?php if (isset($Sign_Up_Errors)) : ?>
                            <b><?= $LANGS['signuperror'] ?></b>
                            <div style="color:red">
                                <?php foreach($Sign_Up_Errors as $Error) : ?>
                                    <div>- <?= $Error ?></div>
                                <?php endforeach ?>
                            </div>
                        <br>
                        <?php endif ?>
                        <div class="signup-title"><?= $LANGS['signindesc1'] ?></div>

                        <p><?= $LANGS['signindesc2'] ?></p>
                        <ul>

                            <li><?= $LANGS['signindesc3'] ?></li>
                            <li><?= $LANGS['signindesc4'] ?></li>
                            <li><?= $LANGS['signindesc5'] ?></li>

                        </ul>
                    </div>
                    <br>
                </div>
            </td>

            <td valign="top">
                <div id="suSignupDiv">
                    <div class="signup-outer-frame" style="margin-left:0%; margin-right:0%;">
                        <div class="signup-inner-frame">
                            <form onsubmit="return checkTerms();" action="/signup" name="register" id="register" method="post">
                                <table class="signup-table" cellpadding="4" cellspacing="0">
                                    <tbody><tr>
                                        <td width="25%">&nbsp;</td>
                                        <td width="72%">&nbsp;</td>
                                    </tr>
                                    <tr valign="top">
                                        <td class="loginFormLabel"><label for="username">   <span class="nowrap"><?= $LANGS['username'] ?>:</span>
                                            </label></td>
                                        <td class="formFieldSmall">
                                            <table border="0" cellpadding="2" cellspacing="0">
                                                <tbody><tr>
                                                    <td valign="top">
                                                        <input type="text" size="40" maxlength="20" id="username" name="username" value="">
                                                        <div id="check_username"></div>
                                                        <div class="formFieldInfo">
                                                            <?= $LANGS['usernamedesc'] ?>
                                                        </div>
                                                    </td>
                                                </tr>

                                                </tbody></table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="loginFormLabel"></td>
                                        <td class="formFieldSmall">
                                            <div class="signup-link"><a href="#" class="smallText" onclick="updateUsernameStatus();return false;">Check Availability</a></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25%">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="loginFormLabel">
                                            <label for="signUpEmail">	<span class="nowrap"><?= $LANGS['email'] ?>:</span>
                                            </label></td>
                                        <td class="formFieldSmall" width="100">
                                            <input id="signUpEmail" type="text" size="40" maxlength="60" name="email" value="" onkeyup="updatePasswordStrength()">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="loginFormLabel"><label for="signUpPassword1">	<span class="nowrap"><?= $LANGS['password'] ?>:</span>
                                            </label></td>
                                        <td class="formFieldSmall"><input id="signUpPassword1" type="password" size="40" maxlength="20" name="password" value="" onkeyup="updatePasswordStrength()"></td>
                                    </tr>
                                    <tr>
                                        <td class="loginFormLabel">&nbsp;</td>
                                        <td class="formFieldSmall"><div class="formFieldInfo" style="color:#0033CC;"><?= $LANGS['passwordstrength'] ?>: <span id="password_strength_text"></span></div><table id="password_strength" class="password_empty" border="0" style="height:2px;width:180px;"><tbody><tr><td></td></tr></tbody></table></td>
                                    </tr>
                                    <tr>
                                        <td class="loginFormLabel"><label for="signUpPassword2">	<span class="nowrap"><?= $LANGS['repassword'] ?>:</span>
                                            </label></td>
                                        <td class="formFieldSmall"><input id="signUpPassword2" type="password" size="40" maxlength="20" name="password_again" value=""></td>
                                    </tr>
                                    <tr>
                                        <td class="loginFormLabel"><label for="countrySelect"><span class="nowrap"><?= $LANGS['country'] ?>:</span>
                                        </label></td>
                                        <td class="formFieldSmall">
                                            <select name="country" id="countrySelect">
                                                <option value="" selected>---</option>
                                                <?php foreach($Countries as $value => $item) : ?>
                                                    <option value="<?= $value ?>"><?= $item ?></option>
                                                <?php endforeach ?>
                                        </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="loginFormLabel"><span class="nowrap"><?= $LANGS['birthday'] ?>:</span></td>
                                        <td class="formFieldSmall">
                                            <select name="birthday_mon">
                                                <option value="0">---</option>
                                                <?php foreach($Months as $item => $value) : ?>
                                                    <option value="<?= $value ?>"><?= $item ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <select name="birthday_day">
                                                <option value="0">---</option>
                                                <?php for ($x = 1; $x <= 31; $x++) : ?>
                                                    <option value="<?= $x ?>"><?= $x ?></option>
                                                <?php endfor ?>
                                            </select>
                                            <select name="birthday_yr">
                                                <option value="0">---</option>
                                                <?php for($x = date("Y");$x >= 1910;$x--) : ?>
                                                    <option value="<?= $x ?>"><?= $x ?></option>
                                                <?php endfor ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="loginFormLabel">
                                            <div id="verificationLabel" name="verificationLabel">
                                                <label for="verificationResponse"><?= $LANGS['captcha'] ?>:</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="h-captcha" data-sitekey="6ac0d643-6eca-444d-a6d9-274f2de3918d"></div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="loginFormLabel" valign="top"><div id="termsOfUseLabel" name="termsOfUseLabel">
                                                <label for="termsOfUseResponse">
                                                    <?= $LANGS['terms'] ?>,<br><?= $LANGS['privacypolicy'] ?>:
                                                </label>
                                            </div></td>
                                        <td class="formFieldSmall">
                                            <table cellpadding="0" cellspacing="0">
                                                <tbody><tr>
                                                    <td style="vertical-align: top; margin-right: 5px">
                                                        <input type="checkbox" name="terms_agreed" id="terms" onclick="checkTerms();" style="margin-left: 0px; padding-left: 0px">
                                                    </td>
                                                    <td style="vertical-align: top; padding-top: 3px;">
                                                        <?= $LANGS['acceptterms'] ?>
                                                    </td>
                                                </tr>
                                                </tbody></table>
                                            <p><?= $LANGS['copyrighttext'] ?></p>

                                            <div id="termsWarning" style="display: none;" class="errorBox">
                                                <?= $LANGS['mustaccept'] ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                            <div class="action-button" style="margin: 0 0 0 px;" id="button-signin">
                                                    <input type="submit" name="signIn" value="<?= $LANGS['createaccount'] ?>" onclick="checkTerms(); document.getElementById('register').submit();">
                                                </a>
                                            </div>

                                        </td>

                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    </tbody></table>
                        </div>
                        <input type="submit" style="display: none;" /> <!-- for enter input -->
                        </form>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div class="clear"></div>

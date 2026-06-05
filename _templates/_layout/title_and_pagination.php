<?php if (basename((string) $_SERVER["SCRIPT_FILENAME"]) == "my_messages.php"): ?>
<tr class="title_and_pagination">
<td colspan="2">
    <button type="button" id="inbox_compose_button" onclick="window.location.href='/send_message'" class=" yt-uix-button yt-uix-button-primary"><?= $LANGS['compose'] ?></button>
</td>
<td valign="bottom" colspan="2" style="padding-bottom:4px"><h2 id="folder_title"><?= $LANGS['inbox'] ?></h2></td>
</tr>
<?php elseif (basename((string) $_SERVER["SCRIPT_FILENAME"]) == "send_message.php"): ?>
<tr class="title_and_pagination">
<td colspan="2">
    <button type="button" id="inbox_compose_button" onclick="window.location.href='/send_message'" class=" yt-uix-button yt-uix-button-primary"><?= $LANGS['compose'] ?></button>
</td>
<td valign="bottom" colspan="2" style="padding-bottom:4px"><h2 id="folder_title"><?= $LANGS['compose'] ?></h2></td>
</tr>
<?php elseif (basename((string) $_SERVER["SCRIPT_FILENAME"]) == "my_profile.php"): ?>
<tr class="title">
    <td colspan="2"></td>
    <td><h2 id="page-name"><?= $LANGS['loading'] ?></h2></td>
</tr>
<?php elseif (basename((string) $_SERVER["SCRIPT_FILENAME"]) == "address_book.php"): ?>
<tr class="title_and_pagination">
<td colspan="2" style="height: 25px;">
</td>
<td valign="bottom" colspan="2" style="padding-bottom:4px"><h2 id="folder_title"><?php if (isset($_GET['v']) && $_GET['v'] != "fi"): ?><?= $LANGS['allcontacts'] ?><?php else: ?><?= $LANGS['incominginvites'] ?><?php endif ?></h2></td>
</tr>
<?php elseif (basename((string) $_SERVER["SCRIPT_FILENAME"]) == "my_profile_modules.php"): ?>
<tr class="title">
    <td colspan="2"></td>
    <td><h2 id="page-name"><?= $LANGS['customizehomepage'] ?></h2></td>
</tr>
<?php endif ?>

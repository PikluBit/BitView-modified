<?php if($_PROFILE->Info["c_blips_box"] == 1) : ?>
    <?php
    $blips_username = $_PROFILE->Info['s_blips_username'];
    $url = "https://blips.club/api/v1/statuses/user_timeline.json?username=$blips_username&count=3&exclude_replies=true";
    $json_data = file_get_contents($url);

    // Decode JSON
    $data = json_decode($json_data, true);

    // Check if data is not empty
    if (!empty($data)) :
    ?>
        <div class="inner-box" id="user_blips" style="opacity: 1;">
            <div style="zoom:1">
                <div class="box-title title-text-color">
                    Latest Blips
                </div>
                <div><img id="user_comments-left-arrow" src="/img/pixel.gif" class="module-left-arrow disabled"><img id="user_comments-up-arrow" src="/img/pixel.gif" class="module-up-arrow " onclick="move_up('comments');return false"><img id="user_comments-down-arrow" src="/img/pixel.gif" class="module-down-arrow " onclick="move_down('comments');return false"><img id="user_comments-right-arrow" src="/img/pixel.gif" class="module-right-arrow" onclick="move_right('comments')"></div>
                <div class="cb"></div>
            </div>

            <div id="user_comments-messages" style="color:#333;margin:1em;padding:1em;display:none"></div>

            <div id="user_comments-body">
                <div class="commentsTableFull text-field outer-box-bg-as-border">
                    <table border="0" cellspacing="0" cellpadding="0" id="profile_comments_table">
                        <tbody>
                        <?php foreach ($data as $comment): ?>
                            <tr class="commentsTableFull" id="cc_<?= $comment['id'] ?>">
                                <td valign="top" width="60" style="padding-bottom: 15px;">
                                    <div class="user-thumb-medium">
                                        <div>
                                            <a href="https://blips.club/<?= $comment['user']['username'] ?>">
                                                <img id="" src="<?= $comment['user']['profile_image_url'] ?>" alt="<?= $comment['user']['name'] ?>">
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td valign="top" style="padding-bottom: 15px;">
                                    <div style="float:left; margin-bottom: 5px;">
                                        <a name="profile-comment-username" href="https://blips.club/<?= $comment['user']['username'] ?>" style="font-size: 12px;"><b><?= $comment['user']['name'] ?></b></a>
                                        <span class="profile-comment-time-created">(<?= date('d M Y', strtotime((string) $comment['created_at'])) ?>)</span>
                                    </div>
                                    <div class="profile-comment-body" style="clear:both;">
                                        <?= make_links_clickable(htmlspecialchars((string) $comment['text'])) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    <?php endif; // End check for non-empty data ?>
<?php endif; ?>

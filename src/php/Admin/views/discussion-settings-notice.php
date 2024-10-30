<div class="hubchat-discussion-settings-notice">
    <div class="hubchat-discussion-settings-notice__wrapper">
        <p class="hubchat-discussion-settings-notice__message">
            <?php
            echo sprintf(
                wp_kses(
                    __(
                        'WordPress built-in discussion settings are disabled, ' .
                        'because you are using the Hubchat commenting plugin. ' .
                        'Please go to <a href="%s">the Hubchat plugin settings.</a>',
                        'hubchat'
                    ),
                    array('a' => array('href' => array()))
                ),
                get_admin_url(null, 'admin.php?page=hubchat')
            );
            ?>
        </p>
    </div>
</div>

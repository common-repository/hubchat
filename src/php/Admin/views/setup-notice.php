<div class="notice notice-success notice-hubchat-setup-prompt">
    <p>
        <?php
        echo sprintf(
            wp_kses(
                __(
                    'The Hubchat plugin is now activated, but it needs a few ' .
                    'settings. Please go to <a href="%s">the plugin settings.</a>',
                    'hubchat'
                ),
                array('a' => array('href' => array()))
            ),
            get_admin_url(null, 'admin.php?page=hubchat')
        );
        ?>
    </p>
</div>

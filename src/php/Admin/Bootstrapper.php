<?php namespace Hubchat\WordPressPlugin\Admin;

class Bootstrapper
{
    protected $adminPageId;
    protected $scriptUrl;
    protected $styleUrl;
    protected $hubchatHost;
    protected $nonceName;
    protected $controller;
    protected $menuSlug = 'hubchat';

    public function __construct(
        $pluginBasename,
        $scriptUrl,
        $styleUrl,
        $iconUrl,
        $hubchatHost,
        $nonceName,
        $hubchatOptions
    ) {
        $this->controller = new Controller(
            new IframeUrl($hubchatHost, site_url(), 'rgb(241,241,241)'),
            new \Hubchat\WordPressPlugin\View(__DIR__ . "/views/admin-page.php"),
            $hubchatOptions
        );
        $this->noticeController = new NoticeController(
            $hubchatOptions,
            new \Hubchat\WordPressPlugin\View(__DIR__ . "/views/setup-notice.php"),
            new \Hubchat\WordPressPlugin\View(__DIR__ . "/views/discussion-settings-notice.php")
        );

        $this->pluginBasename = $pluginBasename;
        $this->scriptUrl = $scriptUrl;
        $this->styleUrl = $styleUrl;
        $this->iconUrl = $iconUrl;
        $this->hubchatHost = $hubchatHost;
        $this->nonceName = $nonceName;
    }

    public function bootstrap()
    {
        add_action('admin_menu', array($this, 'addAdminMenuItem'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueStyleAndScriptIfRequired'));
        add_action('admin_notices', array($this, 'outputAdminNotices'));
        add_filter("plugin_action_links_{$this->pluginBasename}", array($this, 'modifyPluginActionLinks'));

        // Set default commenting status to 'open', because we've
        // disabled the WP discussion settings panel where the user
        // can change that. 'open' is a sensible default for most
        // site owners who install the Hubchat plugin.
        add_filter('option_default_comment_status', array($this, 'setDefaultCommentStatusToOpen'));
    }

    public function outputAdminNotices()
    {
        echo $this->noticeController->showNotices();
    }

    public function addAdminMenuItem()
    {
        $this->adminPageId = add_menu_page(
            'Hubchat',
            'Hubchat',
            'manage_options',
            $this->menuSlug,
            array($this, 'outputAdminPage'),
            $this->iconUrl
        );
    }

    public function outputAdminPage()
    {
        echo $this->controller->showAdminPage();
    }

    public function enqueueStyleAndScriptIfRequired($currentPageId)
    {
        $this->enqueueStyle();

        if ($this->isAdminPage($currentPageId)) {
            $this->enqueueScript();
            $this->passConfigurationToFrontend();
        }
    }

    public function modifyPluginActionLinks($links)
    {
        $settingsLink = "<a href=\"admin.php?page={$this->menuSlug}\">" . __('Settings', 'hubchat') . '</a>';
        array_push($links, $settingsLink);
        return $links;
    }

    public function setDefaultCommentStatusToOpen()
    {
        return 'open';
    }

    protected function passConfigurationToFrontend()
    {
        wp_localize_script('hubchat-admin', 'hubchatConfig', array(
            'serviceHost' => $this->hubchatHost,
            'nonce' => wp_create_nonce($this->nonceName)
        ));
    }

    protected function enqueueScript()
    {
        // TODO: Add cache busting
        wp_enqueue_script(
            'hubchat-admin',
            $this->scriptUrl,
            array(),
            null
        );
    }

    protected function enqueueStyle()
    {
        // TODO: Add cache busting
        wp_enqueue_style(
            'hubchat-admin',
            $this->styleUrl,
            array(),
            null
        );
    }

    protected function isAdminPage($pageId)
    {
        return $pageId == $this->adminPageId;
    }
}

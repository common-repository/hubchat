<?php namespace Hubchat\WordPressPlugin;

/**
 * Add a plugin activation tracking script to page
 * on the next request following plugin activation.
 *
 * Both cannot happen in the same request, because
 * a plugin activation request redirects immediatelly.
 */
class ActivationTracker
{
    protected static $optionKey = 'hubchat_should_track_plugin_activation';

    protected $pluginEntryPointPath;
    protected $pluginRootUrl;
    protected $mixpanelToken;

    public function __construct($pluginEntryPointPath, $pluginRootUrl, $mixpanelToken)
    {
        $this->pluginEntryPointPath = $pluginEntryPointPath;
        $this->pluginRootUrl = $pluginRootUrl;
        $this->mixpanelToken = $mixpanelToken;
    }

    public function bootstrap()
    {
        if ($this->activationIsPendingToBeTracked()) {
            add_action('admin_enqueue_scripts', array($this, 'enqueueTrackingScript'));
            $this->markActivationAsTracked();
            return;
        }

        register_activation_hook(
            $this->pluginEntryPointPath,
            array($this, 'markActivationAsPendingToBeTracked')
        );
    }

    public function enqueueTrackingScript()
    {
        wp_enqueue_script(
            'hubchat-activation-tracker',
            "{$this->pluginRootUrl}dist/activationTracker.js",
            array(),
            null
        );

        // Pass Mixpanel token to the front-end
        wp_localize_script(
            'hubchat-activation-tracker',
            'hubchatActivationTrackerConfig', array('mixpanelToken' => $this->mixpanelToken)
        );
    }

    public function markActivationAsPendingToBeTracked()
    {
        update_option(self::$optionKey, 1);
    }

    protected function markActivationAsTracked()
    {
        delete_option(self::$optionKey);
    }

    protected function activationIsPendingToBeTracked() {
        return get_option(self::$optionKey) == 1;
    }
}

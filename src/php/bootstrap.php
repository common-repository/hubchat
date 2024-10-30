<?php namespace Hubchat\WordPressPlugin;

function bootstrap()
{
    require 'config.php';

    $pluginRootPath = dirname(dirname(__DIR__)) . '/';
    $pluginEntryPointPath = "{$pluginRootPath}hubchat.php";
    $pluginRootUrl = plugin_dir_url("{$pluginRootPath}hubchat.php");

    // Create a nonce (CSRF token) with this name and require
    // all community slug update requests to include that.
    $nonceName = 'hubchat-community-slug-update';

    $hubchatOptions = new HubchatOptions();

    $commentCountView = new View(__DIR__ . '/Commenting/views/comment-count.php');
    $commentingBootstrapper = new Commenting\Bootstrapper(
        $commentCountView,
        $hubchatOptions,
        $config['hubchatHost'] . '/embedded/public/js/incl/plugins.js'
    );

    $adminBootstrapper = new Admin\Bootstrapper(
        plugin_basename("{$pluginRootPath}hubchat.php"),
        "{$pluginRootUrl}dist/admin.js",
        "{$pluginRootUrl}src/styles/admin-style.css",
        "{$pluginRootUrl}src/images/menu-icon.png",
        $config['hubchatHost'],
        $nonceName,
        $hubchatOptions
    );

    $router = new WPAjaxRouter();
    $communitySlugUpdateApi = new CommunitySlugUpdateApi(
        $hubchatOptions,
        $router,
        $nonceName
    );

    $communitySlugUpdateApi->bootstrap();
    $communitySlug = $hubchatOptions->getCommunitySlug();

    if (is_admin()) {
        $adminBootstrapper->bootstrap();
    } elseif (!empty($communitySlug)) {
        $commentingBootstrapper->bootstrap();
    }

    $activationTracker = new ActivationTracker(
        $pluginEntryPointPath,
        $pluginRootUrl,
        $config['mixpanelToken']
    );
    $activationTracker->bootstrap();
}

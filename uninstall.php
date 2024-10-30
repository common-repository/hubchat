<?php namespace Hubchat\WordPressPlugin;

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

require 'vendor/autoload.php';

$hubchatOptions = new HubchatOptions();
$hubchatOptions->clear();

<?php

/*
Plugin Name: Hubchat
Description: Hubchat Comments replaces your WordPress commenting system with comments hosted and powered by Hubchat. To get started: 1) Click the "Activate" link to the left of this description, 2) Go to the Hubchat plugin admin page, 3) Follow the simple setup steps.
Version:     1.0.1
Author:      Hubchat
Author URI:  http://www.hubchat.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

require 'vendor/autoload.php';
require 'src/php/bootstrap.php';

Hubchat\WordPressPlugin\bootstrap();

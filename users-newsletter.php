<?php

/*
Plugin Name: Users Newsletter Addon
Description: Premium addon for Users plugin
Version: 1.0
Author: David Jiménez
Author URI: https://djvdev.com
License: GPL3
*/


defined( 'ABSPATH' ) or die("You cannot pass");

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

use UsersNewsletter\UsersNewsletter;

$usersNewsletter = new UsersNewsletter();

$usersNewsletter->users_newsletter_init();
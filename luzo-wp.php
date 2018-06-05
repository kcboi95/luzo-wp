<?php
/*
  Plugin Name: LuzoWP
  Plugin URI:
  Description: Luzo Technologies plugin for WordPress
  Author: Luzo Team
  Version: 1.0
  Author URI: http://luzotech.com
 */

global $wpdb;

define('LUZO_CLASS_PREFIX', 'Luzo_');
define('LUZO_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('LUZO_PLUGIN_URL', plugin_dir_url(__FILE__));
define('LUZO_PLUGIN_REGISTRATION_FILE', __FILE__);
define('LUZO_PLUGIN_BASENAME', dirname(plugin_basename(__FILE__)));
define('LUZO_PLUGIN_SETTINGS_GROUP', 'luzo_settings');

include LUZO_PLUGIN_PATH . 'inc/Object.php';
include LUZO_PLUGIN_PATH . 'inc/Core.php';
include LUZO_PLUGIN_PATH . 'inc/Assets.php';
include LUZO_PLUGIN_PATH . 'inc/Template.php';
include LUZO_PLUGIN_PATH . 'inc/Exception.php';
include LUZO_PLUGIN_PATH . 'functions.php';

Luzo::run();

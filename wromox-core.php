<?php
/*
* Plugin Name: WromoX Core
* Plugin URI:  https://github.com/ghepes/wromox-core
* Description: Here is a short description of the plugin. WromoX Core is WordPressneeded plugins to work properly. WromoX Core needed for WromoX theme to work properly. Wromox Core is a parts of WromoX theme WooCommerce.
* Version: 1.1.0
* Author: Studio Wromo by Ghepes
* Author URI: https://github.com/ghepes
* Text Domain: wromox-core
* Domain Path: /languages
* License: MIT
* License URI: http://opensource.org/licenses/MIT
* Copyright: (c) 2019 - 2020 Studio Wromo
* Copyright URI: https://github.com/ghepes
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

define( 'WROMOX_CORE_PLUGIN_VERSION', '1.1.0' );

require_once 'vendor/opauth/twitteroauth/twitteroauth.php';
require_once 'inc/auth.php';
require_once 'post-types.php';
require_once 'inc/shortcodes.php';

<?php
/*
* Plugin Name: Wromox Core
* Plugin URI:  https://github.com/Ghepes/wromox-core/wiki
* Description: Wromox Core needed for Wromox theme to work properly
* Version: 1.0.02
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

define( 'WROMOX_CORE_PLUGIN_VERSION', '1.0.02' );

require_once 'vendor/opauth/twitteroauth/twitteroauth.php';
require_once 'inc/auth.php';
require_once 'post-types.php';
require_once 'inc/shortcodes.php';

<?php
/*
 Plugin Name: WromoX Core
 Plugin URI:  https://github.com/ghepes/wromox-core
 Description: Here is a short description of the plugin. WromoX Core is WordPressneeded plugins to work properly. WromoX Core needed for WromoX theme to work properly. Wromox Core is a parts of WromoX theme WooCommerce.
 Version: 1.1.0
 Author: Studio Wromo by Ghepes
 Author URI: https://github.com/ghepes
 Text Domain: wromox-core
 Domain Path: /languages
 License: MIT
 License URI: http://opensource.org/licenses/MIT
 Copyright: (c) 2019 - 2020 Studio Wromo
 Copyright URI: https://github.com/ghepes
 UpdateURI: https://wordpress.org/plugins/wromox-core/readme.txt

  WromoX Core is an official plugin for WordPress
 Copyright (C) 2018-2024, Ghepes, support@wromo.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

define( 'WROMOX_CORE_PLUGIN_VERSION', '1.1.0' );


require_once 'vendor/opauth/twitteroauth/twitteroauth.php';
require_once 'inc/auth.php';
require_once 'post-types.php';
require_once 'inc/shortcodes.php';

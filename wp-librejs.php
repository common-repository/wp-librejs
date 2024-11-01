<?php
/*
 WP LibreJS is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 any later version.

 WP LibreJS is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with WP LibreJS. If not, see https://www.gnu.org/licenses/gpl.html.
 */

/**
 * Plugin Name: WP LibreJS
 * Plugin URI: https://wordpress.org/plugins/wp-librejs/
 * Description: Indicate that the JavaScript code used by the site is free software.
 * Version: 1.0.0
 * Author: Minsc
 * Author URI: https://profiles.wordpress.org/minsc78/
 * License: GPL v3 or later
 * License URI: https://www.gnu.org/licenses/gpl.html
 * Text Domain: librejs
 * Domain Path: /languages/
 * Requires at least: 6.4
 * Requires PHP: 7.4
 *
 * @package WP LibreJS
 */

// If this file is called directly, abort.
defined( 'ABSPATH' ) || exit;

if ( ! defined( 'LIBREJS_PLUGIN_FILE' ) ) {
    define( 'LIBREJS_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'LIBREJS_SRC' ) ) {
    define( 'LIBREJS_SRC', __DIR__ . '/src' );
}

if ( ! defined( 'LIBREJS_TEMPLATES' ) ) {
    define( 'LIBREJS_TEMPLATES', __DIR__ . '/templates' );
}

// Include the main LibreJS class.
if ( ! class_exists( '\LibreJS\Loader', false ) ) {
    include_once LIBREJS_SRC . '/Loader.php';
}

\LibreJS\Loader::init();

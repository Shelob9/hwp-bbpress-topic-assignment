<?php
/**
 * Plugin Name: HWP bbPress Topic Assignment
 * Plugin URI:  http://wordpress.org/plugins
 * Description: Allows you to easily assign bbPress topics to users, as well as the ability to mark topics resolved. Also provides an admin page for listing topics by assigned user.
 * Version:     0.1.0
 * Author:      Josh Pollock
 * Author URI:  
 * License:     GPLv2+
 * Text Domain: hwp_bpa
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2014 Josh Pollock (email : Josh@JoshPress.net)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Built using grunt-wp-plugin
 * Copyright (c) 2013 10up, LLC
 * https://github.com/10up/grunt-wp-plugin
 */

// Useful global constants
define( 'HWP_BPA_VERSION', '0.1.0' );
define( 'HWP_BPA_URL',     plugin_dir_url( __FILE__ ) );
define( 'HWP_BPA_PATH',    dirname( __FILE__ ) . '/' );
define( 'HWP_BPA_ASSETS_URL', HWP_BPA_URL.'/assets/' );
define( 'HWP_BPA_CLASS_PATH', HWP_BPA_PATH.'includes/classes/' );

/**
 * Default initialization for the plugin:
 * - Registers the default textdomain.
 */
function hwp_bpa_init() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'hwp_bpa' );
	load_textdomain( 'hwp_bpa', WP_LANG_DIR . '/hwp_bpa/hwp_bpa-' . $locale . '.mo' );
	load_plugin_textdomain( 'hwp_bpa', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

/**
 * Activate the plugin
 */
function hwp_bpa_activate() {
	// First load the init scripts in case any rewrite functionality is being loaded
	hwp_bpa_init();

	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'hwp_bpa_activate' );

/**
 * Deactivate the plugin
 * Uninstall routines should be in uninstall.php
 */
function hwp_bpa_deactivate() {

}
register_deactivation_hook( __FILE__, 'hwp_bpa_deactivate' );

// Wireup actions
add_action( 'init', 'hwp_bpa_init' );


function hwp_bpa_setup_pods() {

	if ( defined( 'HWP_BPP_VERSION' ) && defined( 'PODS_VERSION' ) ) {
		include( HWP_BPA_CLASS_PATH . 'hwp_bpa_pods_setup.php' );

		new hwp_bpa_pods_setup();
	}
}

include( HWP_BPA_PATH.'includes/functions.php' );

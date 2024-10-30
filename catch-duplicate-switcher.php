<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.catchplugins.com
 * @since             1.0.0
 * @package           Catch_Duplicate_Switcher
 *
 * @wordpress-plugin
 * Plugin Name:       Catch Duplicate Switcher
 * Plugin URI:        catchplugins.com/plugins/catch-duplicate-switcher
 * Description:       Create duplicate posts/pages and switch between them easily.
 * Version:           2.0
 * Author:            Catch Plugins
 * Author URI:        catchplugins.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       catch-duplicate-switcher
 * Domain Path:       /languages
 */
if ( ! defined( 'CATCH_DUPLICATE_VERSION' ) ) {
	define( 'CATCH_DUPLICATE_VERSION', '2.0' );
}

// The URL of the directory that contains the plugin
if ( ! defined( 'CATCH_DUPLICATE_URL' ) ) {
	define( 'CATCH_DUPLICATE_URL', plugin_dir_url( __FILE__ ) );
}


// The absolute path of the directory that contains the file
if ( ! defined( 'CATCH_DUPLICATE_PATH' ) ) {
	define( 'CATCH_DUPLICATE_PATH', plugin_dir_path( __FILE__ ) );
}


// Gets the path to a plugin file or directory, relative to the plugins directory, without the leading and trailing slashes.
if ( ! defined( 'CATCH_DUPLICATE_BASENAME' ) ) {
	define( 'CATCH_DUPLICATE_BASENAME', plugin_basename( __FILE__ ) );
}
function activate_catch_duplicate_switcher() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-catch-duplicate-switcher-activator.php';
	Catch_Duplicate_Switcher_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-catch-duplicate-switcher-deactivator.php
 */
function deactivate_catch_duplicate_switcher() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-catch-duplicate-switcher-deactivator.php';
	Catch_Duplicate_Switcher_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_catch_duplicate_switcher' );
register_deactivation_hook( __FILE__, 'deactivate_catch_duplicate_switcher' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-catch-duplicate-switcher.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
if ( ! function_exists( 'catch_duplicate_switcher_get_options' ) ) :
	function catch_duplicate_switcher_get_options() {
		$defaults = catch_duplicate_switcher_default_options();
		$options  = get_option( 'catch_duplicate_switcher_options', $defaults );
		return wp_parse_args( $options, $defaults );
	}
endif;


if ( ! function_exists( 'catch_duplicate_switcher_default_options' ) ) :
	/**
	 * Return array of default options
	 *
	 * @since     1.0
	 * @return    array    default options.
	 */
	function catch_duplicate_switcher_default_options( $option = null ) {
		$default_options = array(
			'duplicate_suffix_name'   => 'catch',
			'duplicate_status'        => 'Draft',
			'duplicate_page_redirect' => 'to_list',
			'switcher_status'         => 1,
		);

		if ( null == $option ) {
			return apply_filters( 'catch_duplicate_switcher_deafault_options', $default_options );
		} else {
			return $default_options[ $option ];
		}
	}
endif; // catch_duplicate_switcher_default_options

function run_catch_duplicate_switcher() {

	$plugin = new Catch_Duplicate_Switcher();
	$plugin->run();

}
run_catch_duplicate_switcher();
/* CTP tabs removal options */
require plugin_dir_path( __FILE__ ) . '/includes/ctp-tabs-removal.php';

 $ctp_options = ctp_get_options();
if ( 1 == $ctp_options['theme_plugin_tabs'] ) {
	/* Adds Catch Themes tab in Add theme page and Themes by Catch Themes in Customizer's change theme option. */
	if ( ! class_exists( 'CatchThemesThemePlugin' ) && ! function_exists( 'add_our_plugins_tab' ) ) {
		require plugin_dir_path( __FILE__ ) . '/includes/CatchThemesThemePlugin.php';
	}
}

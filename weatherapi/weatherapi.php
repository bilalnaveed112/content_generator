<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://weatherapi
 * @since             1.0.0
 * @package           Weatherapi
 *
 * @wordpress-plugin
 * Plugin Name:       Weather Api
 * Plugin URI:        https://weatherapi
 * Description:       just add shortcode [lahore_weather] in your page or post. Plugin will display Lahore weather status.
 * Version:           1.0.0
 * Author:            Bilal Naveed
 * Author URI:        https://weatherapi
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       weatherapi
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WEATHERAPI_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-weatherapi-activator.php
 */
function activate_weatherapi() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-weatherapi-activator.php';
	Weatherapi_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-weatherapi-deactivator.php
 */
function deactivate_weatherapi() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-weatherapi-deactivator.php';
	Weatherapi_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_weatherapi' );
register_deactivation_hook( __FILE__, 'deactivate_weatherapi' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-weatherapi.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_weatherapi() {

	$plugin = new Weatherapi();
	$plugin->run();

}
run_weatherapi();

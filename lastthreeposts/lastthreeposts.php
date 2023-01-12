<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://lastthreeposts
 * @since             1.0.0
 * @package           Lastthreeposts
 *
 * @wordpress-plugin
 * Plugin Name:       Last Three Posts
 * Plugin URI:        https://lastthreeposts
 * Description:       just add shortcode [last_three_posts] in your page or post.Plugin will display last three posts and refreshing it after every three minutes.
 * Add posts and check your posts will display. 
 * Version:           1.0.0
 * Author:            Bilal Naveed
 * Author URI:        https://lastthreeposts
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       lastthreeposts
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
define( 'LASTTHREEPOSTS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-lastthreeposts-activator.php
 */
function activate_lastthreeposts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lastthreeposts-activator.php';
	Lastthreeposts_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-lastthreeposts-deactivator.php
 */
function deactivate_lastthreeposts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lastthreeposts-deactivator.php';
	Lastthreeposts_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_lastthreeposts' );
register_deactivation_hook( __FILE__, 'deactivate_lastthreeposts' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-lastthreeposts.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_lastthreeposts() {

	$plugin = new Lastthreeposts();
	$plugin->run();

}
run_lastthreeposts();

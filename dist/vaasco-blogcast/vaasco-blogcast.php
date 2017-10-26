<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.vaasco.com/
 * @since             1.0.0
 * @package           Vaasco
 *
 * @wordpress-plugin
 * Plugin Name:       Vaasco Blogcast
 * Plugin URI:        https://www.vaasco.com
 * Description:       Vaasco Blogcast is a WordPress plugin which automatically converts categories and blog posts to playlists of audio tracks.
 * Version:           1.0.0
 * Author:            Vaasco
 * Author URI:        http://www.vaasco.com/
 * Text Domain:       vaasco
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-vaasco-activator.php
 */
function activate_vaasco() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vaasco-activator.php';
	Vaasco_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-vaasco-deactivator.php
 */
function deactivate_vaasco() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vaasco-deactivator.php';
	Vaasco_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_vaasco' );
register_deactivation_hook( __FILE__, 'deactivate_vaasco' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-vaasco.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_vaasco() {

	$plugin = new Vaasco();
	$plugin->run();

}
run_vaasco();

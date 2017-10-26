<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Vaasco
 * @subpackage Vaasco/includes
 * @author     Vaasco <mail@vaasco.com>
 * @link       http://www.vaasco.com/
 */
class Vaasco_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if ( get_bloginfo('version') < 4.7 ) {
			wp_die( 'Vaasco Blogcast requires Wordpress 4.7 or greater. Your current version is ' . get_bloginfo('version') );
		}

		if ( !get_option('permalink_structure') ) { 
			wp_die( 'Vaasco Blogcast requires permalinks to be enabled. Please enable them in Settings > Permalinks' ); 
		}
	}

}

<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.vaasco.com/
 * @since      1.0.0
 *
 * @package    Vaasco
 * @subpackage Vaasco/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Vaasco
 * @subpackage Vaasco/public
 * @author     Vaasco <mail@vaasco.com>
 */
class Vaasco_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vaasco.css', array(), $this->version, 'screen' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		$options = get_option('vaasco_options');

		if ( isset($options) && isset($options['vaasco_aws_identity_pool_id']) ) {

			wp_enqueue_script( 'vaasco-script', plugin_dir_url( __FILE__ ) . 'js/vaasco.js', array(), $this->version, false );
			wp_add_inline_script( 'vaasco-script', '//vaasco;' );
			
			add_filter( 'script_loader_tag', function ( $tag, $handle ) {
				if ( 'vaasco-script' !== $handle ) {
					return $tag;
				}

				$options = get_option('vaasco_options');

				$awsIdentityPoolId = $options['vaasco_aws_identity_pool_id'];
				unset($options['vaasco_aws_identity_pool_id']);
				
				$awsRegion = explode(":", $awsIdentityPoolId)[0];
				$options['vaasco_aws_region'] = $awsRegion;
				$options['vaasco_aws_cognito_id_url'] = plugins_url().'/vaasco-blogcast/public/aws.php';
				$options['vaasco_synthesis_provider'] = ($awsIdentityPoolId !== '' && $awsRegion !== '' ? 'polly' : '');

				$options['vaasco_versions'] = json_encode(array(
					'wordpress' => get_bloginfo('version'),
					'plugin' => $this->version
				));
				
				return str_replace('<script', '<script id=\'vaasco\' data-options=\''.json_encode($options).'\'', $tag);
			}, 10, 2 );
			
		}			

	}

}

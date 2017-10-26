<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.vaasco.com/
 * @since      1.0.0
 *
 * @package    Vaasco
 * @subpackage Vaasco/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Vaasco Blogcast
 * @subpackage Vaasco/admin
 * @author     Vaasco <mail@vaasco.com>
 */
class Vaasco_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'vaasco';

	/**
	 * The colors to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	array 		$colors 	Colors used in this plugin
	 */
	private $colors;

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->colors = array("amber", "blue", "blue-grey", "brown", "cyan", "deep-orange", "deep-purple", "green", "grey", "indigo", "light-blue", "light-green", "lime", "orange", "pink", "purple", "red", "teal", "yellow");
		$this->regions = array("us-east-1", "us-east-2", "us-west-2", "eu-west-1");
		$this->categories = get_terms( 'category' );

		if(!get_option('vaasco_options')) {
			$category_options = array();

			foreach($this->categories as $cat) {
				array_push($category_options, json_encode(array('name' => $cat->name, 'id' => $cat->term_id), JSON_FORCE_OBJECT));
			}

			$options = array(
				'key' => 'value',
				'vaasco_title' => 'Vaasco Blogcast Demo',
				'vaasco_thumbnails' => 'true',
				'vaasco_color' => 'indigo',
				'vaasco_categories' => $category_options
			);

			add_option('vaasco_options', $options);
		}

	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Vaasco Blogcast', 'vaasco' ),
			__( 'Vaasco Blogcast', 'vaasco' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);
	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/vaasco-admin-display.php';
	}

	/**
	 * Register all related settings of this plugin
	 *
	 * @since  1.0.0
	 */
	public function register_setting() {
		register_setting( $this->plugin_name, 'vaasco_options', array( $this, $this->option_name . '_validate_options' ) );
		add_settings_section($this->option_name . '_general', __( 'Settings', 'vaasco' ), null, $this->plugin_name);
		add_settings_field($this->option_name . '_title', __( 'Title', 'vaasco' ), array( $this, $this->option_name . '_title_cb' ), $this->plugin_name, $this->option_name . '_general', array( 'label_for' => $this->option_name . '_title' ));
		add_settings_field($this->option_name . '_thumbnails', __( 'Show thumbnails', 'vaasco' ), array( $this, $this->option_name . '_thumbnails_cb' ), $this->plugin_name, $this->option_name . '_general', array( 'label_for' => $this->option_name . '_thumbnails' ));
		add_settings_field($this->option_name . '_color', __( 'Colors', 'vaasco' ), array( $this, $this->option_name . '_color_cb' ), $this->plugin_name, $this->option_name . '_general', array( 'label_for' => $this->option_name . '_color' ));
		add_settings_field($this->option_name . '_categories', __( 'Categories / Playlists', 'vaasco' ), array( $this, $this->option_name . '_categories_cb' ), $this->plugin_name, $this->option_name . '_general', array( 'label_for' => $this->option_name . '_categories' ));
		add_settings_field($this->option_name . '_aws_identity_pool_id', __( 'AWS Identity Pool ID', 'vaasco' ), array( $this, $this->option_name . '_aws_identity_pool_id_cb' ), $this->plugin_name, $this->option_name . '_general', array( 'label_for' => $this->option_name . '_aws_identity_pool_id' ));
	}

	/**
	 * Register the stylesheets for the admin side of the site.
	 *
	 * @since    1.0.0
	 */
	public function load_custom_wp_admin_style() {
		wp_enqueue_style( 'vaasco-admin', plugin_dir_url( __FILE__ ) . 'css/vaasco.css', array(), $this->version, 'screen' );
	}

	/**
	 * Render the title input
	 *
	 * @since  1.0.0
	 */
	public function vaasco_title_cb() {
		$title = isset(get_option('vaasco_options')[$this->option_name . '_title']) 
			? get_option('vaasco_options')[$this->option_name . '_title'] : '';

		if (isset(get_option('vaasco_options')[$this->option_name . '_title'])) {
			$title = get_option('vaasco_options')[$this->option_name . '_title'];
		}
		?>
    		<input type="text" class="widthMedium" name="vaasco_options[<?php echo $this->option_name . '_title' ?>]" id="<?php echo $this->option_name . '_title' ?>" value="<?php echo $title ?>">
		<?php
	}

	/**
	 * Render the thumbnails input for this plugin
	 *
	 * @since  1.0.0
	 */
	public function vaasco_thumbnails_cb() {
		$thumbnails = isset(get_option('vaasco_options')[$this->option_name . '_thumbnails']) 
			? get_option('vaasco_options')[$this->option_name . '_thumbnails'] : '';
		?>
			<fieldset>
				<label>
					<input type="radio" name="vaasco_options[<?php echo $this->option_name . '_thumbnails' ?>]" id="<?php echo $this->option_name . '_thumbnails_true' ?>" value="true" <?php checked( $thumbnails, 'true' ); ?>>
					<?php _e( 'Yes', 'vaasco' ); ?>
				</label> 
				&nbsp;
				<label>
					<input type="radio" name="vaasco_options[<?php echo $this->option_name . "_thumbnails" ?>]" id="<?php echo $this->option_name . '_thumbnails_false' ?>" value="false" <?php checked( $thumbnails, 'false' ); ?>>
					<?php _e( 'No', 'vaasco' ); ?>
				</label>
				<p class="description">
        			<?= esc_html('Select yes to show the \'featured image\' thumbnail for each post. Select no to hide all thumbnails.', 'vaasco'); ?>
    			</p>
			</fieldset>
		<?php
	}

	/**
	 * Render the color input for this plugin
	 *
	 * @since  1.0.0
	 */
	public function vaasco_color_cb() {
		$color = isset(get_option('vaasco_options')[$this->option_name . '_color']) 
			? get_option('vaasco_options')[$this->option_name . '_color'] : '';
		?>
		<select name="vaasco_options[<?php echo $this->option_name . '_color' ?>]" id="<?php echo $this->option_name . '_color' ?>" >
			<?php
				foreach ($this->colors as $col) {
					$formattedCol = str_replace("-", " ", ucfirst($col));
			?>        
					<option value="<?= $col; ?>" <?php echo selected($color, $col, 1); ?>>
						<?= esc_html($formattedCol, 'vaasco'); ?>
					</option>
			<?php        
				}
			?>
		</select>
		<p class="description">
			<?= esc_html('Choose a color scheme to apply to the Vaasco widget', 'vaasco'); ?>
		</p>
    	<?php
	}

	/**
	 * Render the categories inputs for this plugin
	 *
	 * @since  1.0.0
	 */
	public function vaasco_categories_cb() {
		$cats = isset(get_option('vaasco_options')[$this->option_name . '_categories']) 
			? get_option('vaasco_options')[$this->option_name . '_categories'] : '';
		?>
		<ul>
			<?php    
				foreach($this->categories as $cat) {
					$categoryJSON = json_encode(array('name' => $cat->name, 'id' => $cat->term_id), JSON_FORCE_OBJECT);
					$checked = false;
					if( in_array( $categoryJSON, $cats ) ) {
						$checked = true;
					}
					?>
						<li>
							<input type="checkbox" name="vaasco_options[<?php echo $this->option_name . '_categories' ?>][]" id="<?php echo $this->option_name . '_categories' ?>"  value="<?= htmlspecialchars($categoryJSON) ?>" <?= checked( $checked, true, false ); ?> /> 
							<?= $cat->name; ?>
						</li>        
					<?php
				}   
			?>
		</ul>       
		<p class="description">
			<?= esc_html('Select the categories you want the widget to use as playlists', 'vaasco'); ?>
		</p>
    	<?php
	}

	/**
	 * Render the AWS identity pool id inputs for this plugin
	 *
	 * @since  1.0.0
	 */
	public function vaasco_aws_identity_pool_id_cb() {
		$id = isset(get_option('vaasco_options')[$this->option_name . '_aws_identity_pool_id']) 
			? get_option('vaasco_options')[$this->option_name . '_aws_identity_pool_id'] : '';
		?>
			<input type="text" class="widthLarge" name="vaasco_options[<?php echo $this->option_name . '_aws_identity_pool_id' ?>]" id="<?php echo $this->option_name . '_aws_identity_pool_id' ?>" value="<?php echo $id ?>">
			<p class="description">
				<?= esc_html('Enter your Amazon identity pool id. For detailed instructions on how to setup Amazon Polly, go to https://www.vaasco.com/installation/setup-amazon-polly/', 'vaasco'); ?>
			</p>
		<?php
	}
	
	/**
	 * Validate options before being saved to database
	 *
	 * @param  array $options $_POST value
	 * @since  1.0.0
	 * @return array           Validated value
	 */
	public function vaasco_validate_options( $options ) {
		// clean title
		$options['vaasco_title'] = sanitize_text_field($options['vaasco_title']);

		// check if vaasco_categories set
		if ( count($options['vaasco_categories']) === 0){
			add_settings_error( 'vaasco_error', 'error-categories-missing', 'You must select at least one category', 'error' );
			return $options;
		}

		// check if vaasco_aws_identity_pool_id set
		if ( ( strlen(trim(sanitize_text_field($options['vaasco_aws_identity_pool_id']))) === 0 ) ) {
			add_settings_error( 'vaasco_error', 'error-aws-identity-pool-id-missing', 'You must enter your AWS Identity Pool ID', 'error' );
			return $options;
		}
		
		// check if region valid
		$region = explode(":", $options['vaasco_aws_identity_pool_id'])[0];
		if (!in_array($region, $this->regions, true)) {
			add_settings_error( 'vaasco_error', 'error-aws-region-invalid', 'Amazon Web Services region not valid. Please use one of the following regions: US East (N. Virginia), US East (Ohio), US West (Oregon), and EU (Ireland)', 'error' );
			return $options;
		}

		return $options;
		
	}

}

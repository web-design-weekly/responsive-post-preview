<?php
/*
 * Plugin Name: Simple Login Logo
 * Description: Adds the ability to quickly change your login logo
 * Author: Jake Bresnehan
 * Author URI:  http://web-design-weekly.com
 * Plugin URI:  http://web-design-weekly.com
 * Version: 0.1
 */

class Simple_Login_Logo {

	public function __construct() {

		// Load plugin settings
		add_action( 'admin_init', array( $this, 'plugin_admin_init' ) );

		// Add menu item
		add_action( 'admin_menu', array( $this, 'my_plugin_menu' ) );

		// Register styles
		//add_action( 'admin_enqueue_scripts', array( $this, 'styles' ) );

		// Register JavaScript
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		add_action( 'login_enqueue_scripts', array( $this, 'my_login_logo' ) );

		// Adds settings link to plugins page
		$plugin_file = 'simple-login-logo/simple-login-logo.php';
		add_filter( 'plugin_action_links_' . $plugin_file, array( $this, 'my_plugin_action_links' ) );

	}


	function my_plugin_menu() {
		add_options_page( 'My Plugin Options', 'Simple Login Logo', 'manage_options', 'simple-login-logo', array( $this, 'my_plugin_options' ) );
	}

	/**
	 * Registers the settings for this plugin.
	 *
	 * @since    0.1
	 */
	function plugin_admin_init(){
		register_setting( 'plugin_options', 'plugin_options' );

		add_settings_section('plugin_main', 'Simple Login Logo', array ( $this, 'plugin_section_text') , 'plugin');

		add_settings_field('plugin_text_string', 'Enter a URL or upload an image', array ( $this, 'plugin_setting_string') , 'plugin', 'plugin_main');

		add_settings_field('plugin_image_height', '', array ( $this, 'plugin_setting_image_height') , 'plugin', 'plugin_main');

		add_settings_field('plugin_image_width', '', array ( $this, 'plugin_setting_image_width') , 'plugin', 'plugin_main');

	}


	function plugin_section_text() {
		$options = get_option('plugin_options');
		echo "<div>
				<img src='{$options['text_string']}' class='upload_image_logo' alt='your logo' />
			</div>";
	}

	function plugin_setting_string() {

		$options = get_option('plugin_options');

		//var_dump( $options );

		echo "<label for='upload_image'>
				<input id='plugin_text_string' name='plugin_options[text_string]' size='40' type='text' value='{$options['text_string']}' />

				<input class='upload_image_button button' type='button' value='Upload Image' />
			</label>";

	}

	function plugin_setting_image_height() {

		$options = get_option('plugin_options');

		echo "<input id='plugin_image_height' name='plugin_options[image_height]' type='hidden' value='{$options['image_height']}' />";

	}

	function plugin_setting_image_width() {

		$options = get_option('plugin_options');

		echo "<input id='plugin_image_width' name='plugin_options[image_width]' type='hidden' value='{$options['image_width']}' />";

	}

	// validate our options
	function plugin_options_validate($input) {
		$newinput['text_string'] = trim($input['text_string']);

		// do some valadation when this are working...
		// if(!preg_match('/^[a-z0-9]{32}$/i', $newinput['text_string'])) {
		// 	$newinput['text_string'] = '';
		// }

		return $newinput;
	}

	//https://codex.wordpress.org/Customizing_the_Login_Form
	function my_login_logo() {

		$options = get_option('plugin_options');

		echo "<style type='text/css'>
			body.login div#login h1 a {
				background-image: url({$options['text_string']});
				background-size: {$options['image_width']}px {$options['image_height']}px;
				height: {$options['image_height']}px;
				width: {$options['image_width']}px;
			}
		</style>";

	}



	function my_plugin_options() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		include_once( 'views/admin.php' );
	}


	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     0.1
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		wp_enqueue_script( 'admin_script', plugin_dir_url( __FILE__ ) . '/js/admin.js' );

		// $script_params = array(
		// 	'imgHeight' => get_option('img_height'),
		// );
		// wp_localize_script( 'admin_script', 'scriptParams', $script_params );

	}


	/**
	 * Add settings link on plugins.php
	 *
	 * @since    0.1
	 */

	public function my_plugin_action_links( $links ) {
		$links[] = '<a href="http://web-design-weekly.com/support/" target="_blank">Support</a>';

		return $links;
	}


}
new Simple_Login_Logo;
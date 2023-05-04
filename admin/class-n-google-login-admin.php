<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ntalam.com
 * @since      1.0.0
 *
 * @package    N_Google_Login
 * @subpackage N_Google_Login/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    N_Google_Login
 * @subpackage N_Google_Login/admin
 * @author     Nallib Tala <me@ntalam.com>
 */
class N_Google_Login_Admin
{

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		include_once(WP_PLUGIN_DIR . '/n-google-login/constants.php');
		add_action(
			'admin_menu',
			array(
				$this,
				'register_admin_menu'
			)
		);
		
	}

	public function register_admin_menu()
	{
		$parent_slug = 'n-google-login';

		add_menu_page(
			__('N-Google-Login', 'N-Google-Login'), // Page title
			__('N-Google-Login', 'N-Google-Login'), // Menu title
			'manage_options', // Capability required to access the menu
			$parent_slug, // Slug for the menu page
			array($this, 'admin_page'), // Callback function that renders the menu page
			// 'dashicons-admin-plugins',// Icon URL
			'dashicons-google',
			99
		);

		
	}

	public function admin_page()
	{

		include(N_GOOGLE_LOGIN_FOLDER_PATH . '/includes/admin-page.php');
	}
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in N_Google_Login_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The N_Google_Login_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/n-google-login-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in N_Google_Login_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The N_Google_Login_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url(__FILE__) . 'js/n-google-login-admin.js',
			array('jquery'),
			$this->version,
			false
		);
		// wp_enqueue_script(
		// 	'primeui-js',
		// 	'https://cdnjs.cloudflare.com/ajax/libs/primeui/4.1.15/primeui-all.js',
		// 	array('jquery'),
		// 	PRIMEUI_VERSION,
		// 	false
		// );
	}
}

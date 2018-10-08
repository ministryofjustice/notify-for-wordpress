<?php

namespace Notify_For_Wordpress\Inc\Admin;

/**
 * This manages the core functionality related to the admin section that the plugin controls.
 *
 * @package NFWP
 * @since 0.2.0
 */

 // Exit if file is accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * A reference to the version of the plugin
	 *
	 * @var string $version The current version of the plugin.
	 */
	private $version;

	/**
	 * The text domain of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_text_domain    The text domain of this plugin.
	 */
	private $plugin_text_domain;

	/**
	 * WP_List_Table object
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      dashboard_table     $user_list_table
	 */
	private $dashboard_table;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string $plugin_name    The name of this plugin.
	 * @param    string $version    The version of this plugin.
	 * @param    string $plugin_text_domain The text domain of this plugin
	 */
	public function __construct( $plugin_name, $version, $plugin_text_domain ) {

		$this->plugin_name        = $plugin_name;
		$this->version            = $version;
		$this->plugin_text_domain = $plugin_text_domain;

	}

	/**
	 * Enqueues the stylesheet responsible for styling the contents of the plugin on the site.
	 */
	public function enqueue_styles() {
		wp_enqueue_style(
			'notify-for-wordpress-admin',
			plugin_dir_url( __FILE__ ) . '../../assets/css/notify-for-wordpress-admin.css',
			array(),
			$this->version,
			false
		);

		wp_enqueue_script(
			'notify-for-wordpress-js-admin',
			plugin_dir_url( __FILE__ ) . '../../assets/js/notify-for-wordpress-admin.js',
			array(),
			$this->version,
			true
		);
	}

	/**
	 * Registers the menus that will appear throughout the WP admin section.
	 */
	public function notify_for_wordpress_menu() {
		/**
		  * Add submenu page takes 7 variables, $parent_slug, $page_title,
		  * $menu_title, $capability, $menu_slug, $function and $position
		  * https://developer.wordpress.org/reference/functions/add_submenu_page/
		  */
		$page_hook = add_submenu_page(
			'index.php',
			'Notify For WordPress',
			'Notify Dashboard',
			'administrator',
			'notify-dashboard',
			[ $this, 'render_notify_for_wp_dashboard' ],
			'10'
		);

		/*
		* The $page_hook_suffix can be combined with the load-($page_hook) action hook
		* https://codex.wordpress.org/Plugin_API/Action_Reference/load-(page)
		*
		* The callback below will be called when the respective page is loaded
		*/
		add_action( 'load-' . $page_hook, array( $this, 'render_notify_for_wp_dashboard_screen_options' ) );

	}

	/**
	 * Screen options for the List Table
	 *
	 * Callback for the load-($page_hook_suffix)
	 * Called when the plugin page is loaded
	 *
	 * @since    1.0.0
	 */
	public function render_notify_for_wp_dashboard_screen_options() {

		// $arguments = array(
		// 	'label'   => __( 'Users Per Page', $this->plugin_text_domain ),
		// 	'default' => 5,
		// 	'option'  => 'users_per_page',
		// );
		//
		// add_screen_option( 'per_page', $arguments );
		/*
		 * Instantiate the User List Table. Creating an instance here will allow the core WP_List_Table class to automatically
		 * load the table columns in the screen options panel
		 */
		$this->dashboard_table = new Dashboard_Table( $this->plugin_text_domain );

	}

	/**
	 * Requires the file that is used to display the admin interface page.
	 */
	public function render_notify_for_wp_dashboard() {

		$this->dashboard_table->prepare_items();

		include_once 'view/view-dashboard.php';

	}
}

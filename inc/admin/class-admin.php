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
	 * A reference to the version of the plugin
	 *
	 * @var string $version The current version of the plugin.
	 */
	private $version;

	/**
	 * Initializes this class and stores the current version of this plugin.
	 *
	 * @param string $version The current version of this plugin.
	 */
	public function __construct( $version ) {
		$this->version = $version;

	}

	/**
	 * Enqueues the stylesheet responsible for styling the contents of the plugin on the site.
	 */
	public function enqueue_styles() {
		wp_enqueue_style(
			'notify-for-wordpress-admin',
			plugin_dir_url( __FILE__ ) . '../assets/css/notify-for-wordpress-admin.css',
			array(),
			$this->version,
			false
		);

		wp_enqueue_script(
			'notify-for-wordpress-js-admin',
			plugin_dir_url( __FILE__ ) . '../assets/js/notify-for-wordpress-admin.js',
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
		add_submenu_page(
			'index.php',
			'Notify For WordPress',
			'Notify Dashboard',
			'administrator',
			'notify-dashboard',
			[ $this, 'render_notify_for_wp_admin_page' ],
			'10'
		);
	}

	/**
	 * Requires the file that is used to display the admin interface page.
	 */
	public function render_notify_for_wp_admin_page() {
		 require_once plugin_dir_path( __FILE__ ) . 'example-view.php';
	}
}

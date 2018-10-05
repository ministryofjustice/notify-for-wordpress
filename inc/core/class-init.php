<?php

namespace Notify_For_Wordpress\Inc\Core;

use Notify_For_Wordpress as NF;
use Notify_For_Wordpress\Inc\Admin as Admin;

/**
* class-init.php is the core file responsible for including and
* instantiating much of the code that composes the plugin
*
* @package NFWP
*
* @since 0.2.0
*/

// Exit if file is accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Init {

	/**
	 * A reference to the loader class that coordinates the hooks and callbacks
	 * throughout the plugin.
	 *
	 * @var    class $loader Manages hooks between the WordPress hooks and the callback functions.
	 */
	protected $loader;

	/**
	 * Represents the slug of the plugin that can be used throughout the plugin
	 * for internationalization and other purposes.
	 *
	 * @var    string $plugin_slug The single, hyphenated string used to identify this plugin.
	 */
	protected $plugin_slug;

	/**
	 * Maintains the current version of the plugin so that we can use it throughout
	 * the plugin.
	 *
	 * @var    string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Instantiates the plugin by setting up the core properties and loading
	 * all necessary dependencies and defining the hooks.
	 */
	public function __construct() {

		$this->plugin_slug        = NF\PLUGIN_NAME;
		$this->version            = NF\PLUGIN_VERSION;
		$this->plugin_basename    = NF\PLUGIN_BASENAME;
		$this->plugin_text_domain = NF\PLUGIN_TEXT_DOMAIN;

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_email_hooks();
		$this->define_metabox_hooks();
	}

	/**
	 * Loads all the plugin's main action hooks calling various functions.
	 */
	private function load_dependencies() {
		$this->loader = new Loader();
	}

	/**
	 * Defines the hooks and callback functions that are used for setting up the plugin stylesheets
	 * and the plugin's meta box.
	 *
	 * This function relies on the Notify For WordPress Admin class and the Notify For WordPress
	 * Loader class property.
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Admin\Admin( $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'notify_for_wordpress_menu' );
		// $this->loader->add_action('admin_menu', $admin, 'query_db_unchanged_posts');
	}

	/*
	*
	* This function relies on the Notify For WordPress Email class and the Notify For WordPress
	* Loader class property.
	*
	*/
	private function define_email_hooks() {

		$plugin_admin = new Admin\Email( $this->get_version() );

		$this->loader->add_action('wp', $plugin_admin, 'send_email');

	}

	/*
	*
	* This function relies on the Notify For WordPress Metabox class and the Notify For WordPress
	* Loader class property.
	*
	*/
	private function define_metabox_hooks() {

		$plugin_admin = new Admin\Metabox( $this->get_version() );

		$this->loader->add_action('init', $plugin_admin, 'init_metabox');

	}

	/**
	 * Sets this class into motion.
	 *
	 * Executes the plugin by calling the run method of the loader class which will
	 * register all of the hooks and callback functions used throughout the plugin
	 * with WordPress.
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * Returns the current version of the plugin to the caller.
	 *
	 * @return string $this->version The current version of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}

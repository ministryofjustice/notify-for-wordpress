<?php

namespace Notify_For_Wordpress\Inc\Core;

use Notify_For_Wordpress as NF;
use Notify_For_Wordpress\Inc\Admin as Admin;

/**
* The Notify For WordPress manager is the core plugin responsible for including and
* instantiating all of the code that composes the plugin
*
* @package NFWP
*/

/**
*
* The Notify For WordPress includes an instance to the Notify For WordPress
* Loader which is responsible for coordinating the hooks that exist within the
* plugin.
*
* It also maintains a reference to the plugin slug which can be used in
* internationalization, and a reference to the current version of the plugin
* so that we can easily update the version in a single place to provide
* cache busting functionality when including scripts and styles.
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
	 * @access protected
	 * @var    Loader $loader Manages hooks between the WordPress hooks and the callback functions.
	 */
	protected $loader;

	/**
	 * Represents the slug of hte plugin that can be used throughout the plugin
	 * for internationalization and other purposes.
	 *
	 * @access protected
	 * @var    string $plugin_slug The single, hyphenated string used to identify this plugin.
	 */
	protected $plugin_slug;

	/**
	 * Maintains the current version of the plugin so that we can use it throughout
	 * the plugin.
	 *
	 * @access protected
	 * @var    string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Instantiates the plugin by setting up the core properties and loading
	 * all necessary dependencies and defining the hooks.
	 *
	 * The constructor will define both the plugin slug and the verison
	 * attributes, but will also use internal functions to import all the
	 * plugin dependencies, and will leverage the Notify For WordPress loader for
	 * registering the hooks and the callback functions used throughout the
	 * plugin.
	 */
	public function __construct() {
		$this->plugin_name        = NF\PLUGIN_NAME;
		$this->version            = NF\PLUGIN_VERSION;
		$this->plugin_basename    = NF\PLUGIN_BASENAME;
		$this->plugin_text_domain = NF\PLUGIN_TEXT_DOMAIN;

		$this->load_dependencies();
		$this->define_admin_hooks();
	}

	/**
	 * Imports the Notify For WordPress administration classes, and the Notify For WordPress Loader.
	 *
	 * The Notify For WordPress Manager administration class defines all unique functionality for
	 * introducing custom functionality into the WordPress dashboard.
	 *
	 * The Notify For WordPress Manager Loader is the class that will coordinate the hooks and callbacks
	 * from WordPress and the plugin. This function instantiates and sets the reference to the
	 * $loader class property.
	 *
	 * @access private
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
	 *
	 * @access private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Admin\Admin( $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'notify_for_wordpress_menu' );
		// $this->loader->add_action('admin_menu', $admin, 'query_db_unchanged_posts');
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

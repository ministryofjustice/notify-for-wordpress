<?php

/**
* The Notify For Wordpress manager is the core plugin responsible for including and
* instantiating all of the code that composes the plugin
*
* @package NFWP
*/

/**
*
* The Notify For Wordpress includes an instance to the Notify For Wordpress
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
if (! defined('ABSPATH')) {
    die();
}

class Notify_For_Wordpress_Manager
{
    /**
    * A reference to the loader class that coordinates the hooks and callbacks
    * throughout the plugin.
    *
    * @access protected
    * @var    Notify_For_Wordpress_Loader $loader Manages hooks between the WordPress hooks and the callback functions.
    */
    protected $loader;

    /**
    * A reference to the loader class that coordinates the hooks and callbacks
    * throughout the plugin.
    *
    * @access protected
    * @var    Notify_For_Wordpress_Model $model
    */

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
     * plugin dependencies, and will leverage the Notify For Wordpress loader for
     * registering the hooks and the callback functions used throughout the
     * plugin.
     */
    public function __construct()
    {
        $this->plugin_slug = 'notify-for-wordpress';
        $this->version = '0.1.0';

        $this->load_dependencies();
        $this->define_admin_hooks();
    }

    /**
     * Imports the Notify For Wordpress administration classes, and the Notify For Wordpress Loader.
     *
     * The Notify For Wordpress Manager administration class defines all unique functionality for
     * introducing custom functionality into the WordPress dashboard.
     *
     * The Notify For Wordpress Manager Loader is the class that will coordinate the hooks and callbacks
     * from WordPress and the plugin. This function instantiates and sets the reference to the
     * $loader class property.
     *
     * @access private
     */
    private function load_dependencies()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'inc/class-admin-manager.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'inc/class-model.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'inc/class-loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'inc/class-notify-post-list-table.php';

        $this->loader = new Notify_For_Wordpress_Loader();
    }

    /**
     * Defines the hooks and callback functions that are used for setting up the plugin stylesheets
     * and the plugin's meta box.
     *
     * This function relies on the Notify For Wordpress Admin class and the Notify For Wordpress
     * Loader class property.
     *
     * @access private
     */
    private function define_admin_hooks()
    {
        $admin = new Notify_For_Wordpress_Admin($this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $admin, 'enqueue_styles');
        $this->loader->add_action('admin_menu', $admin, 'notify_for_wordpress_menu');
        $this->loader->add_action('admin_menu', $admin, 'query_db_unchanged_posts');
    }

    /**
     * Sets this class into motion.
     *
     * Executes the plugin by calling the run method of the loader class which will
     * register all of the hooks and callback functions used throughout the plugin
     * with WordPress.
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * Returns the current version of the plugin to the caller.
     *
     * @return string $this->version The current version of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}
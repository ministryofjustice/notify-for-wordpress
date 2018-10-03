<?php
/**
 * The file responsible for starting the Notify for WordPress plugin
 *
 * The Notify for WordPress is a plugin that displays the post meta data
 * associated with a given post. This particular file is responsible for
 * including the necessary dependencies and starting the plugin.
 *
 * @package NFWP
 *
 * @wordpress-plugin
 * Plugin Name:       Notify for WordPress
 * Plugin URI:        http://wordpress.org/extend/plugins/
 * Description:       A notification plugin to help editors keep their content up-to-date
 * Version:           0.1.0
 * Text Domain:       notify-for-wordpress
 * Domain Path:       /languages
 * Author:            Ministry of Justice
 * License:           The MIT License (MIT)
 * License URI:       https://opensource.org/licenses/MIT
 * Copyright:         Crown Copyright (c) 2018 Ministry of Justice
 */

 /*
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
  SOFTWARE.

*/
namespace Notify_For_Wordpress;

// Exit if file is accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Define Constants
 */

define( __NAMESPACE__ . '\NF', __NAMESPACE__ . '\\' );

define( NF . 'PLUGIN_NAME', 'nfwp-notify-for-wp' );

define( NF . 'PLUGIN_VERSION', '0.2.0' );

define( NF . 'PLUGIN_NAME_DIR', plugin_dir_path( __FILE__ ) );

define( NF . 'PLUGIN_NAME_URL', plugin_dir_url( __FILE__ ) );

define( NF . 'PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

define( NF . 'PLUGIN_TEXT_DOMAIN', 'notify-for-wordpress' );

/**
 * Autoload Classes
 */
require_once PLUGIN_NAME_DIR . 'inc/libraries/autoloader.php';

/**
 * Register Activation and Deactivation Hooks
 * This action is documented in inc/core/class-activator.php
 */
register_activation_hook( __FILE__, array( NF . 'Inc\Core\Activator', 'activate' ) );

/**
 * The code that runs during plugin deactivation.
 * This action is documented inc/core/class-deactivator.php
 */
register_deactivation_hook( __FILE__, array( NF . 'Inc\Core\Deactivator', 'deactivate' ) );

/**
 * Plugin Singleton Container
 *
 * Maintains a single copy of the plugin app object
 *
 * @since    0.2.0
 */
class Notify_For_Wordpress {

	static $init;
	/**
	 * Loads the plugin
	 *
	 * @access    public
	 */
	public static function init() {

		if ( null == self::$init ) {

			self::$init = new Inc\Core\Init();
			self::$init->run();
		}

		return self::$init;
	}

}

/*
 * Begin plugin execution
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * Also returns copy of the app object so 3rd party developers
 * can interact with the plugin's hooks contained within.
 *
 */
function notify_for_wordpress_init() {
		return Notify_For_Wordpress::init();
}

$min_php = '5.6.0';

// Check the minimum required PHP version and run the plugin.
if ( version_compare( PHP_VERSION, $min_php, '>=' ) ) {
		notify_for_wordpress_init();
}

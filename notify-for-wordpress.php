<?php
/**
 * The file responsible for starting the Notify for WordPress plugin
 *
 * Notify for WordPress is a plugin that allows users to setup notifications
 * on out of date content.
 *
 * @package NFWP
 *
 * @wordpress-plugin
 * Plugin Name:       Notify for WordPress
 * Plugin URI:        https://github.com/ministryofjustice/notify-for-wordpress
 * Description:       A notification plugin to help editors keep their content up-to-date
 * Version:           0.2.2
 * Text Domain:       notify-for-wordpress
 * Domain Path:       /languages
 * Author:            Ministry of Justice
 * License:           The MIT License (MIT)
 * License URI:       https://opensource.org/licenses/MIT
 * Copyright:         Crown Copyright (c) 2018 Ministry of Justice
 */

namespace Notify_For_Wordpress;

// Exit if file is accessed directly.
if (!defined('ABSPATH')) {
    die();
}

/**
 * Define Constants
 */
const NF = __NAMESPACE__ . '\\';

define(NF . 'PLUGIN_NAME', 'notify-for-wordpress');

define(NF . 'PLUGIN_VERSION', '0.2.1');

define(NF . 'PLUGIN_NAME_DIR', plugin_dir_path(__FILE__));

define(NF . 'PLUGIN_NAME_URL', plugin_dir_url(__FILE__));

define(NF . 'PLUGIN_BASENAME', plugin_basename(__FILE__));

define(NF . 'PLUGIN_TEXT_DOMAIN', 'notify-for-wordpress');

/**
 * Autoload Classes
 */
require_once PLUGIN_NAME_DIR . 'inc/libraries/autoloader.php';

/**
 * Register Activation and Deactivation Hooks
 * This action is documented in inc/core/class-activator.php
 */
register_activation_hook(__FILE__, array(NF . 'Inc\Core\Activator', 'activate'));

/**
 * The code that runs during plugin deactivation.
 * This action is documented inc/core/class-deactivator.php
 */
register_deactivation_hook(__FILE__, array(NF . 'Inc\Core\Deactivator', 'deactivate'));

/**
 * Plugin Singleton Container
 *
 * Maintains a single copy of the plugin app object
 *
 * @since    0.2.0
 */
class Notify_For_Wordpress
{

    static $init;

    /**
     * Loads the plugin
     *
     * @access    public
     */
    public static function init()
    {

        if (null == self::$init) {

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
function notify_for_wordpress_init()
{
    return Notify_For_Wordpress::init();
}

$min_php = '7.4';

// Check the minimum required PHP version and run the plugin.
if (version_compare(PHP_VERSION, $min_php, '>=')) {
    notify_for_wordpress_init();
}

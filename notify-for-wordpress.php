<?php
/**
 * The file responsible for starting the Notify for Wordpress plugin
 *
 * The Notify for Wordpress is a plugin that displays the post meta data
 * associated with a given post. This particular file is responsible for
 * including the necessary dependencies and starting the plugin.
 *
 * @package nfwp
 *
 * @wordpress-plugin
 * Plugin Name:       Notify for Wordpress
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

// Exit if file is accessed directly.
if (! defined('ABSPATH')) {
    die();
}

/**
 * Uninstall plugin
 */
register_uninstall_hook(__FILE__, 'nfwp_on_uninstall');

function nfwp_on_uninstall()
{
    if (!current_user_can('activate_plugins')) {
        return;
    }
    // Drop post and comment like database meta keys
    // delete_post_meta_by_key('');
    // delete_metadata('', null, '', '', true);
}

/**
 * Include the core class responsible for loading all necessary components of the plugin.
 */
require_once plugin_dir_path(__FILE__) . 'inc/class-manager.php';

/**
 * Instantiates the run Notify for Wordpress class and then
 * calls its run method officially starting up the plugin.
 */
  function run_notify_for_wordpress()
  {
      $nfwp = new Notify_For_Wordpress_Manager();
      $nfwp->run();
  }

// Call the above function to begin execution of the plugin.
run_notify_for_wordpress();

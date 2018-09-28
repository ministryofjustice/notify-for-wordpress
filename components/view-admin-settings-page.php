<?php
/**
 * Displays the admin interface for Notify For Wordpress.
 *
 * This is a partial template that is included by the Notify For Wordpress
 *
 *
 * @package NFWP
 */

 // Exit if file is accessed directly.
 if (! defined('ABSPATH')) {
     die();
 }

$plugin_version = $this->version;

echo "<h1>Content management and notification dashboard</h1>";
echo "<h4>Set notifications and keep your content up-to-date</h4>";
echo "<br>";
echo "<p>Notify for Wordpress plugin</p>";
echo "Version: " . $plugin_version;

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

echo $plugin_version;

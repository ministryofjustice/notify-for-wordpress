<?php
/**
 * Displays the admin interface for Notify For WordPress.
 *
 * This is a partial template that is included by the Notify For WordPress
 *
 * @package NFWP
 */
use Notify_For_Wordpress\Inc\Admin;

$hello = new Admin\Hello();

$plugin_version   = $this->version;
$change_over_year = $this->query_db_unchanged_posts();

echo '<h1>Notify dashboard</h1>';
echo '<h4>Set notifications to keep track of page updates and keep your content up-to-date</h4>';
echo '<br>';

echo '<pre>';
var_dump( $hello->hello_world() );
echo '</pre>';

echo '<br>';
echo '<p>Notify for WordPress plugin</p>';
echo 'Version: ' . $plugin_version;

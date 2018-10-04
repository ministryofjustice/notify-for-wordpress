<?php
/**
 * Displays the admin dashboard interface for Notify For WordPress.
 *
 * This is a partial template that is included by the Notify For WordPress
 *
 * @package NFWP
 */
use Notify_For_Wordpress\Inc\Admin;

$outdated_pages = new Admin\Model();

//$plugin_version   = $this->version;

echo '<h1>Notify dashboard</h1>';
echo '<h4>Set notifications to keep track of page updates and keep your content up-to-date</h4>';
echo '<br>';

echo '<pre>';
var_dump( $outdated_pages->nfwp_outdated() );
echo '</pre>';

echo '<br>';
echo '<p>Notify for WordPress plugin</p>';
//echo 'Version: ' . $plugin_version;

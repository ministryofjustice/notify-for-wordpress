<?php
/**
 * Displays the admin dashboard for the plugin.
 *
 * @package NFWP
 */
use Notify_For_Wordpress\Inc\Admin;

$outdated_pages = new Admin\Model();



echo '<div class="wrap">';
echo '<h2>' . _e( 'WP List Table Demo', $this->plugin_text_domain ) . '</h2>';
echo '<div id="nds-wp-list-table-demo">';
echo '<div id="nds-post-body">';
echo '<form id="nds-user-list-form" method="get">';
echo $this->dashboard_table->display();
echo '</form>';
echo '</div>';
echo '</div>';
echo '</div>';


// $plugin_version   = $this->version;
// echo '<h1>Notify dashboard</h1>';
// echo '<h4>Set notifications to keep track of page updates and keep your content up-to-date</h4>';
// echo '<br>';
//
// echo '<pre>';
// var_dump( $outdated_pages->content_outdated_all() );
// echo '</pre>';
//
// echo '<br>';
// echo '<p>Notify for WordPress plugin</p>';
// echo 'Version: ' . $plugin_version;

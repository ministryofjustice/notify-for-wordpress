<?php
/**
 * Displays the admin dashboard for the plugin.
 *
 * @package NFWP
 */
use Notify_For_Wordpress\Inc\Admin;

$outdated_pages = new Admin\Model();

echo '<div class="wrap">';
echo '<h2>' . _e( '<h1>Notify dashboard</h1>', $this->plugin_text_domain ) . '</h2>';
echo '<p>Displays all pages older than one year from today and when they were last modified.</p>';
echo '<div id="nfwp-table">';
echo '<div id="nfwp-table-post-body">';
echo '<form id="nfwp-table-form" method="get">';

echo $this->dashboard_table->display();

echo '</form>';
echo '</div>';
echo '</div>';
echo '</div>';

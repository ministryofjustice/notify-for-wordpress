<?php
/**
 * Displays the admin dashboard for the plugin.
 *
 * @package NFWP
 */
use Notify_For_Wordpress\Inc\Admin;
use Notify_For_Wordpress\Inc\Libraries\Agency_Context;

$outdated_pages = new Admin\Model();
$context        = Agency_Context::get_agency_context();

echo '<div class="wrap">';
echo '<h2>' . _e( '<h1>Notify dashboard</h1>', $this->plugin_text_domain ) . '</h2>';
echo '<p>Track all <strong>' . strtoupper( $context ) . '</strong> pages that have not been updated for over a year. Only includes pages, not events, news or blogs. If you want to track another agency\'s content use the admin agency switcher in the top right corner of this screen.<br /><br />Once you have updated the page, it will disappear from this list. Hover over the table titles to sort them by column.</p>';
echo '<h3>Pages</h3>';
echo '<div id="nfwp-table">';
echo '<div id="nfwp-table-post-body">';
echo '<form id="nfwp-table-form" method="get">';

echo $this->dashboard_table->display();

echo '</form>';
echo '</div>';
echo '</div>';
echo '</div>';

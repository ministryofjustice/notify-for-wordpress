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

echo '<h2>' . _e( '<h1>Pages to review</h1>', $this->plugin_text_domain ) . '</h2>';

echo '<p>Track all <strong>' . strtoupper( $context ) . '</strong> pages that have not been reviewed for over a year. This includes pages but not events, news or blogs. If you want to track another agency\'s content, use the admin agency switcher in the top right corner of this screen.<br /><br />Once the page listed below has been updated (by saving the page), it will disappear from this list. You can sort by column by hovering over the table titles.</p>';

echo '<h3>Pages not reviewed for over a year</h3>';
echo '<div id="nfwp-table">';
echo '<div id="nfwp-table-post-body">';
echo '<form id="nfwp-table-form" method="get">';

echo $this->dashboard_table->display();

echo '</form>';
echo '</div>';
echo '</div>';
echo '</div>';

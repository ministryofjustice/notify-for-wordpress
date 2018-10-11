<?php
/**
 * Displays the metabox interface for Notify For WordPress.
 *
 * This is a partial template that is included by the Notify For WordPress
 *
 * @package NFWP
 */

// Exit if file is accessed directly.
if (! defined('ABSPATH')) {
 die();
}

// Add nonce for security and authentication.
wp_nonce_field('cs_nonce_check', 'cs_nonce_check_value');

$date = get_post_meta($post -> ID, '_notify_date', true);
$pageemail = get_post_meta($post -> ID, '_notify_pageowner', true);
$contentemail = get_post_meta($post -> ID, '_notify_contentowner', true);

echo '<label> Date </label>';
echo '<input type="date" name="notify_date" value="' . esc_attr( $date ).'"><br/>';
echo '<label> Page Owner Email </label>';
echo '<input type="text" name="notify_pageowner" value="' . esc_attr( $pageemail ).'"><br/>';
echo '<label> Content Owner Email </label>';
echo '<input type="text" name="notify_contentowner" value="' . esc_attr( $contentemail ).'"><br/>';
echo '</div>';

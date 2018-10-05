<?php

namespace Notify_For_Wordpress\Inc\Admin;

/**
 * This manages the core functionality related to the email section that the plugin controls.
 *
 * @package NFWP
 * @since 0.2.0
 */

 // Exit if file is accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Email {
  /**
   * A reference to the version of the plugin
   *
   * @var string $version The current version of the plugin.
   */
  private $version;

  /**
   * Initializes this class and stores the current version of this plugin.
   *
   * @param string $version The current version of this plugin.
   */
  public function __construct( $version ) {
    $this->version = $version;
  }

  /**
   * This function collects the email address from the metabox the user has entered.
   */
  public function send_email()
	{
    global $post;
		//$email_address = get_post_meta($post -> ID, '_notify_email');
    $email_address = 'faaaaakerrr@pola.com';
		$to = $email_address;
    $title = get_the_title( $post -> ID );
		$subject = 'Email now from page ' . $title;
		$message = '1. This is a test of the wp_mail function: wp_mail is working';
		$headers = '';
		require_once $_SERVER['DOCUMENT_ROOT'] . '/wp/wp-load.php';
		// send test message using wp_mail function.
		$sent_message = wp_mail( $to, $subject, $message, $headers );

	}

}

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

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// If this is just a revision, don't send the email.
		if ( wp_is_post_revision( $post -> ID ) || wp_is_post_autosave( $post -> ID) ) {
			return;
		}

    $get_email = get_post_meta($post -> ID, '_notify_email');
		$title = get_the_title( $post -> ID );
		$post_url = get_permalink( $post -> ID );

		$to = $get_email[0];
		//$to = 'anotheruser@example.com';
		$subject = $title;
		$message = '1. This is a test of the wp_mail function: wp_mail is working';
		$headers = '';
		require_once $_SERVER['DOCUMENT_ROOT'] . '/wp/wp-load.php';

		// send test message using wp_mail function.
		wp_mail( $to, $subject, $message, $headers );

		wp_schedule_single_event( time(), 'send_email' );
	}

	public function schedule_email()
	{

	}




}

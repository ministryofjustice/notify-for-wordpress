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
	 * Meta box initialization.
	 */
	public function init_email() {
		add_action( 'wp', array( $this, 'send_email' ) );
		add_action( 'event_callback', array( $this, 'send_email' ) );
		add_action( 'save_post',      array( $this, 'schedule_cron_jobs' ), 10, 2 );
	}

  /**
   * This function collects the email address from the metabox the user has entered.
   */

	private function set_meta_data()
	{

		global $post;
		$pageowner_email = get_post_meta( $post->ID, '_notify_pageowner' );
		$contentowner_email = get_post_meta( $post->ID, '_notify_contentowner' );
		$title = get_the_title( $post->ID );
		$post_url = get_permalink( $post->ID );

		$array = array(
			'page_owner_email' => $pageowner_email[0],
			'content_owner_email' => $contentowner_email[0],
			'title' => $title,
			'page_url' => $post_url,
		);

		return $array;

	}

	/**
   * This function sends two emails, one to the page owner and another to content owner.
   */
  public function send_email()
	{

		global $post;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// If this is just a revision, don't send the email.
		if ( wp_is_post_revision( $post->ID ) || wp_is_post_autosave( $post->ID) ) {
			return;
		}

		require_once $_SERVER['DOCUMENT_ROOT'] . '/wp/wp-load.php';

		$get_meta_data = $this->set_meta_data();

		//print_r($get_meta_data);
		$to = $get_meta_data['page_owner_email'];
		$to_content = $get_meta_data['content_owner_email'];

		$subject = $get_meta_data['title'];
		$message = '1. This is a test of the wp_mail function: wp_mail is working';
		$headers = array( 'Content-Type: text/html; charset=UTF-8' );

		$content_subject = 'Please review '.$get_meta_data['title'].' page and update your intranet page';
		$content_message =
			'Hello <br/>
			<br/>
			It’s been [insert exact time] since you updated <strong> [page title] </strong> and your content might be out of date. <br/>
			<br/>
			Please review the page and confirm that your content is still relevant and accurate. <br/>
			<br/>
			<strong>My content is out of date</strong> <br/>
			Send [admin’s email address] the new content changes so they can update the page. <br/>
			<br/>
			<strong>My content is up to date</strong> <br/>
			Notify [admin’s email address] so they can mark your content as up to date. <br/>
			<br/>
			<a href="">Review your content</a>
			';

		// send test message using wp_mail function.
		wp_mail( $to, $subject, $message, $headers );
		wp_mail( $to_content, $content_subject, $content_message, $headers );

	}

	public function schedule_cron_jobs()
	{
		//check if a event with "event_callback" action hook registered or not
    if(!wp_next_scheduled("event_callback"))
    {
			wp_schedule_single_event( time(), 'event_callback' );
    }
	}

}

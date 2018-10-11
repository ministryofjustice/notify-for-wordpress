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

class Metabox {
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
	public function init_metabox() {
		add_action( 'add_meta_boxes', array( $this, 'add' ) );
		add_action( 'save_post', array( $this, 'save' ), 10, 2 );
	}

	// Adds the metabox
	public function add() {
		$post_types = [ 'page' ];
		add_meta_box(
			'notify-for-wordpress-metabox',
			'Notification Remainder',
			array( $this, 'display' ),
			$post_types,
			'normal',
			'core'
		);
	}

	// Renders the metabox
	public function display( $post ) {
		require_once plugin_dir_path( __FILE__ ) . 'view-metabox.php';
	}

	/**
	 * Handles saving the meta box.
	 */
	public function save( $post_id ) {

		/*
		 * We need to verify this came from the our screen and with
		 * proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['cs_nonce_check_value'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['cs_nonce_check_value'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'cs_nonce_check' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted,
		// so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		}

		/* OK, its safe for us to save the data now. */

		// Sanitize the user input.
		$data_date         = sanitize_text_field( $_POST['notify_date'] );
		$data_pageemail    = sanitize_text_field( $_POST['notify_pageowner'] );
		$data_contentemail = sanitize_text_field( $_POST['notify_contentowner'] );

		// Update the meta field.
		update_post_meta( $post_id, '_notify_date', $data_date );
		update_post_meta( $post_id, '_notify_pageowner', $data_pageemail );
		update_post_meta( $post_id, '_notify_contentowner', $data_contentemail );

	}


}

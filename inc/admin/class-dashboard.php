<?php

namespace Notify_For_Wordpress\Inc\Admin;

class Dashboard {


	if ( ! class_exists( 'WP_List_Table' ) ) {
		require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
	}

	/**
	 * Class to overwrite and extend the WP List Table.
	 *
	 * @package NFWP
	 *
	 * @since 0.1.0
	 */

	// Exit if file is accessed directly.
	if ( ! defined( 'ABSPATH' ) ) {
		die();
	}


	public function query_db_unchanged_posts() {

		global $wpdb;

		$context                    = 'hq';// Agency_Context::get_agency_context();
		$user_id                    = get_current_user_id();
		$current_time               = current_time( 'mysql' );
		$one_year_from_current_time = date( 'Y-m-d H:i:s', strtotime( $current_time ) - 31536000 ); // minus one year

		$query = "SELECT ID, post_title, post_modified, post_status
				FROM $wpdb->posts
				LEFT JOIN $wpdb->term_relationships ON ( $wpdb->posts.ID = $wpdb->term_relationships.object_id )
				LEFT JOIN $wpdb->term_taxonomy ON ( $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id )
				LEFT JOIN $wpdb->terms ON ( $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id )
				WHERE post_status IN ('publish','draft')
				AND post_type = 'page'
				AND post_modified < '{$one_year_from_current_time}'
				AND $wpdb->term_taxonomy.taxonomy = 'agency'
				AND $wpdb->terms.slug IN ( 'hq', '%s' )
				AND post_author = '%s'";

		$query .= "GROUP BY $wpdb->posts.ID
								 ORDER BY post_modified LIMIT 0,50";

		$prepared_query  = $wpdb->prepare( $query, $context, $user_id );
		$published_posts = $wpdb->get_results( $prepared_query );

		return $published_posts;

	}



	class Notify_Post_List_Table extends WP_List_Table {

		/**
		 * Constructor, we override the parent to pass our own arguments
		 * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
		 */
		function __construct() {
			parent::__construct(
				array(
					'singular' => 'wp_list_text_link', // Singular label
					'plural'   => 'wp_list_test_links', // plural label, also this well be one of the table css class
					'ajax'     => false, // We won't support Ajax for this table
				)
			);
		}

	}
}

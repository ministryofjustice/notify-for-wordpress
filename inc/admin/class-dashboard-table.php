<?php

namespace Notify_For_Wordpress\Inc\Admin;

use Notify_For_Wordpress\Inc\Libraries;

// Exit if file is accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * The Model class is mainly for queries to the db and other data related processes
 *
 * @package NFWP
 *
 * @since 0.1.0
 */
class Dashboard_Table extends Libraries\WP_List_Table {


	public function get_columns() {

			$table_columns = array(
				'cb'            => '<input type="checkbox" />', // to display the checkbox.
				'post_modified' => __( 'Last modified', $this->plugin_text_domain ),
				'post_title'    => __( 'Page title', $this->plugin_text_domain ),
				'post_status'   => _x( 'Page status', 'column name', $this->plugin_text_domain ),
				'ID'            => __( 'Page ID', $this->plugin_text_domain ),
			);

		return $table_columns;
	}

	public function no_items() {
		_e( 'No users avaliable.', $this->plugin_text_domain );
	}

	public function prepare_items() {

		// code to handle bulk actions
		// used by WordPress to build and fetch the _column_headers property
		$this->_column_headers = $this->get_column_info();
		$table_data            = $this->fetch_table_data();

		// code to handle data operations like sorting and filtering
		// start by assigning your data to the items variable
		$this->items = $table_data;

		// code for pagination
		$users_per_page = $this->get_items_per_page( 'post_title' );

		$table_page = $this->get_pagenum();

		// provide the ordered data to the List Table
		// we need to manually slice the data based on the current pagination
		$this->items = array_slice( $table_data, ( ( $table_page - 1 ) * $users_per_page ), $users_per_page );

		// set the pagination arguments
		$total_users = count( $table_data );

		$this->set_pagination_args(
			array(
				'total_items' => $total_users,
				'per_page'    => $users_per_page,
				'total_pages' => ceil( $total_users / $users_per_page ),
			)
		);

	}

	public function fetch_table_data() {

		global $wpdb;

		$current_time               = current_time( 'mysql' );
		$one_year_from_current_time = date( 'Y-m-d H:i:s', strtotime( $current_time ) - 31536000 ); // minus one year

		$wpdb_table = $wpdb->prefix . 'posts';

		$orderby = ( isset( $_GET['orderby'] ) ) ? esc_sql( $_GET['orderby'] ) : 'post_modified';
		$order   = ( isset( $_GET['order'] ) ) ? esc_sql( $_GET['order'] ) : 'ASC';

		$user_query = "SELECT post_title, post_modified, post_status, ID
									 FROM $wpdb_table
									 WHERE post_status IN ('publish','draft')
									 AND post_type = 'page'
									 AND post_modified < '{$one_year_from_current_time}'
									 ORDER BY $orderby $order";

		// query output_type will be an associative array with ARRAY_A.
		$query_results = $wpdb->get_results( $user_query, ARRAY_A );

		// return result array to prepare_items.
		return $query_results;
	}

	public function column_default( $item, $column_name ) {

		switch ( $column_name ) {
			case 'post_title':
			case 'post_modified':
			case 'post_status':
			case 'ID':
				return $item[ $column_name ];
			default:
				return $item[ $column_name ];
		}
	}

	protected function get_sortable_columns() {
		/*
		 * actual sorting still needs to be done by prepare_items.
		 * specify which columns should have the sort icon.
		 */
		$sortable_columns = array(
			'post_modified' => 'post_modified',
			'post_title'    => 'post_title',
			'post_status'   => 'post_status',
		);

		return $sortable_columns;
	}

}

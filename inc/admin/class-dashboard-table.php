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
				'cb'              => '<input type="checkbox" />', // to display the checkbox.
				'user_login'      => __( 'User Login', $this->plugin_text_domain ),
				'display_name'    => __( 'Display Name', $this->plugin_text_domain ),
				'user_registered' => _x( 'Registered On', 'column name', $this->plugin_text_domain ),
				'ID'              => __( 'User Id', $this->plugin_text_domain ),
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

	}

	public function fetch_table_data() {

		global $wpdb;

		$wpdb_table = $wpdb->prefix . 'users';
		$orderby    = ( isset( $_GET['orderby'] ) ) ? esc_sql( $_GET['orderby'] ) : 'user_registered';
		$order      = ( isset( $_GET['order'] ) ) ? esc_sql( $_GET['order'] ) : 'ASC';
		$user_query = "SELECT
                        user_login, display_name, user_registered, ID
                      FROM
                        $wpdb_table
                      ORDER BY $orderby $order";

		// query output_type will be an associative array with ARRAY_A.
		$query_results = $wpdb->get_results( $user_query, ARRAY_A );

		// return result array to prepare_items.
		return $query_results;
	}

	public function column_default( $item, $column_name ) {

		switch ( $column_name ) {
			case 'display_name':
			case 'user_registered':
			case 'ID':
				return $item[ $column_name ];
			default:
				return $item[ $column_name ];
		}
	}

}

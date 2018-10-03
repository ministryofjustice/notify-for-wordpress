<?php


if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

print_r(get_declared_classes());
/**
 * Class to overwrite and extend the WP List Table.
 *
 * @package NFWP
 */

/**
 *
 *
 * @since 0.1.0
 */

 // Exit if file is accessed directly.
 if (! defined('ABSPATH')) {
     die();
 }

 class Notify_Post_List_Table extends WP_List_Table {

    /**
     * Constructor, we override the parent to pass our own arguments
     * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
     */
     function __construct() {
        parent::__construct( array(
       'singular'=> 'wp_list_text_link', //Singular label
       'plural' => 'wp_list_test_links', //plural label, also this well be one of the table css class
       'ajax'   => false //We won't support Ajax for this table
       ) );
     }

 }

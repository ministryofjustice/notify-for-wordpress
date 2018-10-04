<?php

namespace Notify_For_Wordpress\Inc\Admin;
use Notify_For_Wordpress\Libraries;

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
class Dashboard_Table extends Libraries\WP_List_Table
{

  public function get_columns() {}
  public function prepare_items() {}

}

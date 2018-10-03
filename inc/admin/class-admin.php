<?php

namespace Notify_For_Wordpress\Inc\Admin;

/**
 * The Notify For WordPress Admin defines all functionality for the backend dashboard
 * of the plugin
 *
 * @package NFWP
 */

/**
 * This class defines the meta box used to display the post meta data and registers
 * the style sheet responsible for styling the content of the meta box.
 *
 * @since 0.2.0
 */

 // Exit if file is accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Admin {


	/**
	 * A reference to the version of the plugin that is passed to this class from the caller.
	 *
	 * @access private
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
	 * Enqueues the stylesheet responsible for styling the contents of the plugin on the site.
	 * The plugin uses minimal styling to allow developers and designers maximum control over design.
	 */
	public function enqueue_styles() {
		wp_enqueue_style(
			'notify-for-wordpress-admin',
			plugin_dir_url( __FILE__ ) . '../assets/css/notify-for-wordpress-admin.css',
			array(),
			$this->version,
			false
		);

		wp_enqueue_script(
			'notify-for-wordpress-js-admin',
			plugin_dir_url( __FILE__ ) . '../assets/js/notify-for-wordpress-admin.js',
			array(),
			$this->version,
			true
		);
	}

	/**
	 * Registers the meta box that will be used to display all of the post meta data
	 * associated with the current post.
	 */
	public function notify_for_wordpress_menu() {
		/**
		 * Add submenu page takes 7 variables, $parent_slug, $page_title,
		 * $menu_title, $capability, $menu_slug, $function and $position
		 * https://developer.wordpress.org/reference/functions/add_submenu_page/
		 */
		add_submenu_page(
			'index.php',
			'Notify For WordPress',
			'Notify Dashboard',
			'administrator',
			'notify-dashboard',
			[ $this, 'render_notify_for_wp_admin_page' ],
			'10'
		);
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

	/**
	 * Requires the file that is used to display the admin interface page.
	 */
	public function render_notify_for_wp_admin_page() {
		require_once plugin_dir_path( __FILE__ ) . 'example-view.php';
	}
}

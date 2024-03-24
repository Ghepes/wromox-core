<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

class WROMOX_Post_Types {
	public $domain = 'wromox_starter';

	protected static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'wromox' ), '2.1' );
	}

	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'wromox' ), '2.1' );
	}

	public function __construct() {

		// Hook into the 'init' action
		add_action( 'init', array( $this, 'register_blocks' ), 1 );
		add_action( 'init', array( $this, 'size_guide' ), 1 );
		add_action( 'init', array( $this, 'slider' ), 1 );


		// Duplicate post action for slides
		add_filter( 'post_row_actions', array( $this, 'duplicate_slide_action' ), 10, 2 );
		add_filter( 'admin_action_wromox_duplicate_post_as_draft', array( $this, 'duplicate_post_as_draft' ), 10, 2 );

		// Manage slides list columns
		add_filter( 'manage_edit-wromox_slide_columns', array( $this, 'edit_wromox_slide_columns' ) );
		add_action( 'manage_wromox_slide_posts_custom_column', array( $this, 'manage_wromox_slide_columns' ), 10, 2 );

		// Add shortcode column to block list
		add_filter( 'manage_edit-cms_block_columns', array( $this, 'edit_html_blocks_columns' ) );
		add_action( 'manage_cms_block_posts_custom_column', array( $this, 'manage_html_blocks_columns' ), 10, 2 );

		add_filter( 'manage_edit-portfolio_columns', array( $this, 'edit_portfolio_columns' ) );
		add_action( 'manage_portfolio_posts_custom_column', array( $this, 'manage_portfolio_columns' ), 10, 2 );

		add_action( 'init', array( $this, 'register_sidebars' ), 1 );
		add_action( 'init', array( $this, 'register_portfolio' ), 1 );

		add_action( 'init', array( $this, 'slider' ), 1 );

	}

	// **********************************************************************//
	// ! Register Custom Post Type for WroMox slider
	// **********************************************************************//
	public function slider() {

		if ( function_exists( 'wromox_get_opt' ) && ! wromox_get_opt( 'wromox_slider', '1' ) ) {
			return;
		}

		$labels = array(
			'name'               => esc_html__( 'Slider', 'wromox' ),
			'singular_name'      => esc_html__( 'Slide', 'wromox' ),
			'menu_name'          => esc_html__( 'Slides', 'wromox' ),
			'add_new_item'       => esc_html__( 'Add New Slide', 'wromox' ),
			'parent_item_colon'  => esc_html__( 'Parent Item:', 'wromox' ),
			'all_items'          => esc_html__( 'All Items', 'wromox' ),
			'view_item'          => esc_html__( 'View Item', 'wromox' ),
			'add_new_item'       => esc_html__( 'Add New Item', 'wromox' ),
			'add_new'            => esc_html__( 'Add New', 'wromox' ),
			'edit_item'          => esc_html__( 'Edit Item', 'wromox' ),
			'update_item'        => esc_html__( 'Update Item', 'wromox' ),
			'search_items'       => esc_html__( 'Search Item', 'wromox' ),
			'not_found'          => esc_html__( 'Not found', 'wromox' ),
			'not_found_in_trash' => esc_html__( 'Not found in Trash', 'wromox' ),
		);

		$args = array(
			'label'               => 'wromox_slide',
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'custom-fields' ),
			'hierarchical'        => false,
			'public'              => true,
			'publicly_queryable'  => is_user_logged_in(),
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 29,
			'menu_icon'           => 'dashicons-images-alt2',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'capability_type'     => 'page',
		);

		register_post_type( 'wromox_slide', $args );

		$labels = array(
			'name'                  => esc_html__( 'Sliders', 'wromox' ),
			'singular_name'         => esc_html__( 'Slider', 'wromox' ),
			'search_items'          => esc_html__( 'Search Sliders', 'wromox' ),
			'popular_items'         => esc_html__( 'Popular Sliders', 'wromox' ),
			'all_items'             => esc_html__( 'All Sliders', 'wromox' ),
			'parent_item'           => esc_html__( 'Parent Slider', 'wromox' ),
			'parent_item_colon'     => esc_html__( 'Parent Slider', 'wromox' ),
			'edit_item'             => esc_html__( 'Edit Slider', 'wromox' ),
			'update_item'           => esc_html__( 'Update Slider', 'wromox' ),
			'add_new_item'          => esc_html__( 'Add New Slider', 'wromox' ),
			'new_item_name'         => esc_html__( 'New Slide', 'wromox' ),
			'add_or_remove_items'   => esc_html__( 'Add or remove Sliders', 'wromox' ),
			'choose_from_most_used' => esc_html__( 'Choose from most used sliders', 'wromox' ),
			'menu_name'             => esc_html__( 'Slider', 'wromox' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_admin_column' => false,
			'hierarchical'      => true,
			'show_tagcloud'     => false,
			'show_ui'           => true,
			'query_var'         => false,
			'rewrite'           => array( 'slug' => 'wromox_slider' ),
			'capabilities'      => array(),
		);

		register_taxonomy( 'wromox_slider', array( 'wromox_slide' ), $args );
	}

	public function duplicate_slide_action( $actions, $post ) {
		if ( $post->post_type != 'wromox_slide' ) {
			return $actions;
		}

		if ( current_user_can( 'edit_posts' ) ) {
			$actions['duplicate'] = '<a href="' . wp_nonce_url( 'admin.php?action=wromox_duplicate_post_as_draft&post=' . $post->ID, basename( __FILE__ ), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
		}
		return $actions;
	}

	public function duplicate_post_as_draft() {
		global $wpdb;
		if ( ! ( isset( $_GET['post'] ) || isset( $_POST['post'] ) || ( isset( $_REQUEST['action'] ) && 'wromox_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
			wp_die( 'No post to duplicate has been supplied!' );
		}

		/*
		 * Nonce verification
		 */
		if ( ! isset( $_GET['duplicate_nonce'] ) || ! wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) ) {
			return;
		}

		/*
		 * get the original post id
		 */
		$post_id = ( isset( $_GET['post'] ) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
		/*
		 * and all the original post data then
		 */
		$post = get_post( $post_id );

		/*
		 * if you don't want current user to be the new post author,
		 * then change next couple of lines to this: $new_post_author = $post->post_author;
		 */
		$current_user    = wp_get_current_user();
		$new_post_author = $current_user->ID;

		/*
		 * if post data exists, create the post duplicate
		 */
		if ( isset( $post ) && $post != null ) {

			/*
			 * new post data array
			 */
			$args = array(
				'comment_status' => $post->comment_status,
				'ping_status'    => $post->ping_status,
				'post_author'    => $new_post_author,
				'post_content'   => $post->post_content,
				'post_excerpt'   => $post->post_excerpt,
				'post_name'      => $post->post_name,
				'post_parent'    => $post->post_parent,
				'post_password'  => $post->post_password,
				'post_status'    => 'draft',
				'post_title'     => $post->post_title . ' (duplicate)',
				'post_type'      => $post->post_type,
				'to_ping'        => $post->to_ping,
				'menu_order'     => $post->menu_order,
			);

			/*
			 * insert the post by wp_insert_post() function
			 */
			$new_post_id = wp_insert_post( $args );

			/*
			 * get all current post terms ad set them to the new post draft
			 */
			$taxonomies = get_object_taxonomies( $post->post_type ); // returns array of taxonomy names for post type, ex array("category", "post_tag");
			foreach ( $taxonomies as $taxonomy ) {
				$post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
				wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
			}

			/*
			 * duplicate all post meta just in two SQL queries
			 */
			$post_meta_infos = $wpdb->get_results( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id" );
			if ( count( $post_meta_infos ) != 0 ) {
				$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
				foreach ( $post_meta_infos as $meta_info ) {
					$meta_key = $meta_info->meta_key;
					if ( $meta_key == '_wp_old_slug' ) {
						continue;
					}
					$meta_value      = addslashes( $meta_info->meta_value );
					$sql_query_sel[] = "SELECT $new_post_id, '$meta_key', '$meta_value'";
				}
				$sql_query .= implode( ' UNION ALL ', $sql_query_sel );
				$wpdb->query( $sql_query );
			}

			/*
			 * finally, redirect to the edit post screen for the new draft
			 */
			wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
			exit;
		} else {
			wp_die( 'Post creation failed, could not find original post: ' . $post_id );
		}
	}

	// **********************************************************************//
	// ! Register Custom Post Type for Size Guide
	// **********************************************************************//
	public function size_guide() {

		if ( function_exists( 'wromox_get_opt' ) && ! wromox_get_opt( 'size_guides', '1' ) ) {
			return;
		}

		$labels = array(
			'name'               => esc_html__( 'Size Guides', 'wromox' ),
			'singular_name'      => esc_html__( 'Size Guide', 'wromox' ),
			'menu_name'          => esc_html__( 'Size Guides', 'wromox' ),
			'add_new'            => esc_html__( 'Add new', 'wromox' ),
			'add_new_item'       => esc_html__( 'Add new size guide', 'wromox' ),
			'new_item'           => esc_html__( 'New size guide', 'wromox' ),
			'edit_item'          => esc_html__( 'Edit size guide', 'wromox' ),
			'view_item'          => esc_html__( 'View size guide', 'wromox' ),
			'all_items'          => esc_html__( 'All size guides', 'wromox' ),
			'search_items'       => esc_html__( 'Search size guides', 'wromox' ),
			'not_found'          => esc_html__( 'No size guides found.', 'wromox' ),
			'not_found_in_trash' => esc_html__( 'No size guides found in trash.', 'wromox' ),
		);

		$args = array(
			'label'               => esc_html__( 'wromox_size_guide', 'wromox' ),
			'description'         => esc_html__( 'Size guide to place in your products', 'wromox' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 29,
			'menu_icon'           => 'dashicons-editor-kitchensink',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => false,
			'capability_type'     => 'page',
		);

		register_post_type( 'wromox_size_guide', $args );
	}

	// **********************************************************************//
	// ! Register Custom Post Type for HTML Blocks
	// **********************************************************************//

	public function register_blocks() {

		$labels = array(
			'name'               => esc_html__( 'HTML Blocks', 'wromox' ),
			'singular_name'      => esc_html__( 'HTML Block', 'wromox' ),
			'menu_name'          => esc_html__( 'HTML Blocks', 'wromox' ),
			'parent_item_colon'  => esc_html__( 'Parent Item:', 'wromox' ),
			'all_items'          => esc_html__( 'All Items', 'wromox' ),
			'view_item'          => esc_html__( 'View Item', 'wromox' ),
			'add_new_item'       => esc_html__( 'Add New Item', 'wromox' ),
			'add_new'            => esc_html__( 'Add New', 'wromox' ),
			'edit_item'          => esc_html__( 'Edit Item', 'wromox' ),
			'update_item'        => esc_html__( 'Update Item', 'wromox' ),
			'search_items'       => esc_html__( 'Search Item', 'wromox' ),
			'not_found'          => esc_html__( 'Not found', 'wromox' ),
			'not_found_in_trash' => esc_html__( 'Not found in Trash', 'wromox' ),
		);

		$args = array(
			'label'               => esc_html__( 'cms_block', 'wromox' ),
			'description'         => esc_html__( 'CMS Blocks for custom HTML to place in your pages', 'wromox' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor' ),
			'hierarchical'        => false,
			'public'              => true,
			'publicly_queryable'  => is_user_logged_in(),
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 29,
			'menu_icon'           => 'dashicons-schedule',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'rewrite'             => false,
			'capability_type'     => 'page',
		);

		register_post_type( 'cms_block', $args );

		$labels = array(
			'name'                  => esc_html__( 'HTML Block categories', 'wromox' ),
			'singular_name'         => esc_html__( 'HTML Block category', 'wromox' ),
			'search_items'          => esc_html__( 'Search categories', 'wromox' ),
			'popular_items'         => esc_html__( 'Popular categories', 'wromox' ),
			'all_items'             => esc_html__( 'All categories', 'wromox' ),
			'parent_item'           => esc_html__( 'Parent category', 'wromox' ),
			'parent_item_colon'     => esc_html__( 'Parent category', 'wromox' ),
			'edit_item'             => esc_html__( 'Edit category', 'wromox' ),
			'update_item'           => esc_html__( 'Update category', 'wromox' ),
			'add_new_item'          => esc_html__( 'Add New category', 'wromox' ),
			'new_item_name'         => esc_html__( 'New category', 'wromox' ),
			'add_or_remove_items'   => esc_html__( 'Add or remove categories', 'wromox' ),
			'choose_from_most_used' => esc_html__( 'Choose from most used', 'wromox' ),
			'menu_name'             => esc_html__( 'Category', 'wromox' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_admin_column' => false,
			'hierarchical'      => true,
			'show_tagcloud'     => true,
			'show_ui'           => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'cms_block_cat' ),
			'capabilities'      => array(),
			'show_in_rest'      => true,
		);

		register_taxonomy( 'cms_block_cat', array( 'cms_block' ), $args );
	}


	public function edit_html_blocks_columns( $columns ) {
		unset( $columns['date'] );

		$new_columns = array(
			'shortcode'     => esc_html__( 'Shortcode', 'wromox' ),
			'wd_categories' => esc_html__( 'Categories', 'wromox' ),
			'date'          => esc_html__( 'Date', 'wromox' ),
		);

		$columns = $columns + $new_columns;
		return $columns;
	}


	public function manage_html_blocks_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'shortcode':
				echo '<strong>[html_block id="' . $post_id . '"]</strong>';
				break;
			case 'wd_categories':
				$terms     = wp_get_post_terms( $post_id, 'cms_block_cat' );
				$post_type = get_post_type( $post_id );
				$keys      = array_keys( $terms );
				$last_key  = end( $keys );

				if ( ! $terms ) {
					echo '—';
				}

				?>
				<?php foreach ( $terms as $key => $term ) : ?>
				<?php
				$name = $term->name;

				if ( $key !== $last_key ) {
					$name .= ',';
				}

				?>

				<a href="<?php echo esc_url( 'edit.php?post_type=' . $post_type . '&cms_block_cat=' . $term->slug ); ?>">
					<?php echo esc_html( $name ); ?>
				</a>
			<?php endforeach; ?>
				<?php
				break;
		}
	}

	// **********************************************************************//
	// ! Register Custom Post Type for additional sidebars
	// **********************************************************************//
	public function register_sidebars() {

		$labels = array(
			'name'               => esc_html__( 'Sidebars', 'wromox' ),
			'singular_name'      => esc_html__( 'Sidebar', 'wromox' ),
			'menu_name'          => esc_html__( 'Sidebars', 'wromox' ),
			'parent_item_colon'  => esc_html__( 'Parent Item:', 'wromox' ),
			'all_items'          => esc_html__( 'All Items', 'wromox' ),
			'view_item'          => esc_html__( 'View Item', 'wromox' ),
			'add_new_item'       => esc_html__( 'Add New Item', 'wromox' ),
			'add_new'            => esc_html__( 'Add New', 'wromox' ),
			'edit_item'          => esc_html__( 'Edit Item', 'wromox' ),
			'update_item'        => esc_html__( 'Update Item', 'wromox' ),
			'search_items'       => esc_html__( 'Search Item', 'wromox' ),
			'not_found'          => esc_html__( 'Not found', 'wromox' ),
			'not_found_in_trash' => esc_html__( 'Not found in Trash', 'wromox' ),
		);

		$args = array(
			'label'               => esc_html__( 'wromox_sidebar', 'wromox' ),
			'description'         => esc_html__( 'You can create additional custom sidebar and use them in Visual Composer', 'wromox' ),
			'labels'              => $labels,
			'supports'            => array( 'title' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 67,
			'menu_icon'           => 'dashicons-welcome-widgets-menus',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => false,
			'capability_type'     => 'page',
		);

		register_post_type( 'wromox_sidebar', $args );

	}



	// **********************************************************************//
	// ! Register Custom Post Type for portfolio
	// **********************************************************************//
	public function register_portfolio() {
		if ( function_exists( 'wromox_get_opt' ) && ! wromox_get_opt( 'portfolio', '1' ) ) {
			return;
		}

		$portfolio_slug     = function_exists( 'wromox_get_opt' ) ? wromox_get_opt( 'portfolio_item_slug', 'portfolio' ) : 'portfolio';
		$portfolio_cat_slug = function_exists( 'wromox_get_opt' ) ? wromox_get_opt( 'portfolio_cat_slug', 'project-cat' ) : 'project-cat';
		$portfolio_page_id  = function_exists( 'wromox_tpl2id' ) ? wromox_tpl2id( 'portfolio.php' ) : '';
		$has_archive        = $portfolio_page_id && get_post( $portfolio_page_id ) ? urldecode( get_page_uri( $portfolio_page_id ) ) : true;

		$labels = array(
			'name'               => esc_html__( 'Portfolio', 'wromox' ),
			'singular_name'      => esc_html__( 'Project', 'wromox' ),
			'menu_name'          => esc_html__( 'Projects', 'wromox' ),
			'parent_item_colon'  => esc_html__( 'Parent Item:', 'wromox' ),
			'all_items'          => esc_html__( 'All Items', 'wromox' ),
			'view_item'          => esc_html__( 'View Item', 'wromox' ),
			'add_new_item'       => esc_html__( 'Add New Item', 'wromox' ),
			'add_new'            => esc_html__( 'Add New', 'wromox' ),
			'edit_item'          => esc_html__( 'Edit Item', 'wromox' ),
			'update_item'        => esc_html__( 'Update Item', 'wromox' ),
			'search_items'       => esc_html__( 'Search Item', 'wromox' ),
			'not_found'          => esc_html__( 'Not found', 'wromox' ),
			'not_found_in_trash' => esc_html__( 'Not found in Trash', 'wromox' ),
		);

		$args = array(
			'label'               => esc_html__( 'portfolio', 'wromox' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'page-attributes' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 28,
			'menu_icon'           => 'dashicons-format-gallery',
			'can_export'          => true,
			'has_archive'         => $has_archive,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => array(
				'slug'       => $portfolio_slug,
				'with_front' => false,
				'feeds'      => true,
			),
			'capability_type'     => 'page',
			'show_in_rest'        => true,
		);

		register_post_type( 'portfolio', $args );

		/**
		 * Create a taxonomy category for portfolio
		 *
		 * @uses  Inserts new taxonomy object into the list
		 * @uses  Adds query vars
		 *
		 * @param string  Name of taxonomy object
		 * @param array|string  Name of the object type for the taxonomy object.
		 * @param array|string  Taxonomy arguments
		 * @return null|WP_Error WP_Error if errors, otherwise null.
		 */

		$labels = array(
			'name'                  => esc_html__( 'Project Categories', 'wromox' ),
			'singular_name'         => esc_html__( 'Project Category', 'wromox' ),
			'search_items'          => esc_html__( 'Search Categories', 'wromox' ),
			'popular_items'         => esc_html__( 'Popular Project Categories', 'wromox' ),
			'all_items'             => esc_html__( 'All Project Categories', 'wromox' ),
			'parent_item'           => esc_html__( 'Parent Category', 'wromox' ),
			'parent_item_colon'     => esc_html__( 'Parent Category', 'wromox' ),
			'edit_item'             => esc_html__( 'Edit Category', 'wromox' ),
			'update_item'           => esc_html__( 'Update Category', 'wromox' ),
			'add_new_item'          => esc_html__( 'Add New Category', 'wromox' ),
			'new_item_name'         => esc_html__( 'New Category', 'wromox' ),
			'add_or_remove_items'   => esc_html__( 'Add or remove Categories', 'wromox' ),
			'choose_from_most_used' => esc_html__( 'Choose from most used text-domain', 'wromox' ),
			'menu_name'             => esc_html__( 'Category', 'wromox' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_admin_column' => false,
			'hierarchical'      => true,
			'show_tagcloud'     => true,
			'show_ui'           => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug'         => $portfolio_cat_slug,
				'with_front'   => false,
				'hierarchical' => true,
			),
			'capabilities'      => array(),
			'show_in_rest'      => true,
		);

		register_taxonomy( 'project-cat', array( 'portfolio' ), $args );

	}


	public function edit_wromox_slide_columns( $columns ) {

		$columns = array(
			'cb'           => '<input type="checkbox" />',
			'thumb'        => '',
			'title'        => esc_html__( 'Title', 'wromox' ),
			'slide-slider' => esc_html__( 'Slider', 'wromox' ),
			'date'         => esc_html__( 'Date', 'wromox' ),
		);

		return $columns;
	}


	public function manage_wromox_slide_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'thumb':
				if ( has_post_thumbnail( $post_id ) ) {
					the_post_thumbnail( array( 60, 60 ) );
				}
				break;
			case 'slide-slider':
				$terms     = wp_get_post_terms( $post_id, 'wromox_slider' );
				$keys      = array_keys( $terms );
				$last_key  = end( $keys );

				if ( ! $terms ) {
					echo '—';
				}

				?>
				<?php foreach ( $terms as $key => $term ) : ?>
					<?php
					$name = $term->name;

					if ( $key !== $last_key ) {
						$name .= ',';
					}

					?>
					<a href="<?php echo esc_url( 'edit.php?taxonomy=wromox_slider&post_type=wromox_slide&term=' . $term->slug ); ?>">
						<?php echo esc_html( $name ); ?>
					</a>
				<?php endforeach; ?>
				<?php

				break;
		}
	}



	public function edit_portfolio_columns( $columns ) {

		$columns = array(
			'cb'          => '<input type="checkbox" />',
			'thumb'       => '',
			'title'       => esc_html__( 'Title', 'wromox' ),
			'project-cat' => esc_html__( 'Categories', 'wromox' ),
			'date'        => esc_html__( 'Date', 'wromox' ),
		);

		return $columns;
	}


	public function manage_portfolio_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'thumb':
				if ( has_post_thumbnail( $post_id ) ) {
					the_post_thumbnail( array( 60, 60 ) );
				}
				break;
			case 'project-cat':
				$terms = get_the_terms( $post_id, 'project-cat' );

				if ( $terms && ! is_wp_error( $terms ) ) :

					$cats_links = array();

					foreach ( $terms as $term ) {
						$cats_links[] = $term->name;
					}

					$cats = join( ', ', $cats_links );
					?>
					
					<span><?php echo $cats; ?></span>
				
				<?php endif;
				break;
		}
	}

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}


}

function WROMOX_Theme_Plugin() {
	return WROMOX_Post_Types::instance();
}

$GLOBALS['wromox_theme_plugin'] = WROMOX_Theme_Plugin();

if ( ! function_exists( 'wromox_compress' ) ) {
	function wromox_compress( $variable ) {
		return base64_encode( $variable );
	}
}

if ( ! function_exists( 'wromox_get_file' ) ) {
	function wromox_get_file( $variable ) {
		return file_get_contents( $variable );
	}
}

if ( ! function_exists( 'wromox_decompress' ) ) {
	function wromox_decompress( $variable ) {
		return base64_decode( $variable );
	}
}

if ( ! function_exists( 'wromox_get_svg' ) ) {
	function wromox_get_svg( $file ) {
		if ( ! apply_filters( 'wromox_svg_cache', true ) ) {
			return file_get_contents( $file );
		}

		$file_path = array_reverse( explode( '/', $file ) );
		$slug      = 'wdm-svg-' . $file_path[2] . '-' . $file_path[1] . '-' . $file_path[0];
		$content   = get_transient( $slug );

		if ( ! $content ) {
			$file_get_contents = file_get_contents( $file );

			if ( strstr( $file_get_contents, '<svg' ) ) {
				$content = wromox_compress( $file_get_contents );
				set_transient( $slug, $content, apply_filters( 'wromox_svg_cache_time', 60 * 60 * 24 * 7 ) );
			}
		}

		return wromox_decompress( $content );
	}
}

// **********************************************************************//
// ! It could be useful if you using nginx instead of apache
// **********************************************************************//

if ( ! function_exists( 'getallheaders' ) ) {
	function getallheaders() {
		$headers = array();
		foreach ( $_SERVER as $name => $value ) {
			if ( substr( $name, 0, 5 ) == 'HTTP_' ) {
				$headers[ str_replace( ' ', '-', ucwords( strtolower( str_replace( '_', ' ', substr( $name, 5 ) ) ) ) ) ] = $value;
			}
		}
		return $headers;
	}
}

// **********************************************************************//
// ! Support shortcodes in text widget
// **********************************************************************//

add_filter( 'widget_text', 'do_shortcode' );
?>

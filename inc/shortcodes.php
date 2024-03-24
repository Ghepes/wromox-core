<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * ------------------------------------------------------------------------------------------------
 * Products widget shortcode
 * ------------------------------------------------------------------------------------------------
 */
class WROMOX_ShortcodeProductsWidget {

	function __construct() {
		add_shortcode( 'wromox_shortcode_products_widget', array( $this, 'wromox_shortcode_products_widget' ) );
	}

	public function add_category_order( $query_args ) {
		$ids = explode( ',', $this->ids );
		if ( ! empty( $ids[0] ) ) {
			$query_args['tax_query'][] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'id',
				'terms'    => $ids,
			);
		}
		return $query_args;
	}

	public function add_product_order( $query_args ) {
		$ids = explode( ',', $this->include_products );

		if ( ! empty( $ids[0] ) ) {
			$query_args['post__in']       = $ids;
			$query_args['orderby']        = 'post__in';
			$query_args['posts_per_page'] = -1;
		}

		return $query_args;
	}

	public function wromox_shortcode_products_widget( $atts ) {
		global $wromox_widget_product_img_size;
		$output = $title = $el_class = '';
		$atts   = shortcode_atts(
			array(
				'title'            => '',
				'show'             => '',
				'number'           => 3,
				'include_products' => '',
				'orderby'          => 'date',
				'order'            => 'asc',
				'ids'              => '',
				'hide_free'        => 0,
				'show_hidden'      => 0,
				'images_size'      => 'woocommerce_thumbnail',
				'el_class'         => '',
			),
			$atts
		);
		extract( $atts );

		$wromox_widget_product_img_size = $images_size;
		$this->ids                        = $ids;
		$this->include_products           = $include_products;
		$output                           = '<div class="widget_products' . $el_class . '">';
		$type                             = 'WC_Widget_Products';

		$args = array( 'widget_id' => uniqid() );

		ob_start();

		add_filter( 'woocommerce_products_widget_query_args', array( $this, 'add_category_order' ), 10 );
		add_filter( 'woocommerce_products_widget_query_args', array( $this, 'add_product_order' ), 20 );

		if ( function_exists( 'wromox_woocommerce_installed' ) && wromox_woocommerce_installed() ) {
			the_widget( $type, $atts, $args );
		}

		remove_filter( 'woocommerce_products_widget_query_args', array( $this, 'add_category_order' ), 10 );
		remove_filter( 'woocommerce_products_widget_query_args', array( $this, 'add_product_order' ), 20 );

		$output .= ob_get_clean();

		$output .= '</div>';

		unset( $wromox_widget_product_img_size );

		return $output;

	}
}
$wromox_shortcode_products_widget = new WROMOX_ShortcodeProductsWidget();

function wromox_add_shortcodes() {
//	add_shortcode( 'wromox_single_product_title', 'wromox_shortcode_single_product_title' );
//	add_shortcode( 'wromox_single_product_content', 'wromox_shortcode_single_product_content' );
//	add_shortcode( 'wromox_single_product_short_description', 'wromox_shortcode_single_product_short_description' );
//	add_shortcode( 'wromox_single_product_price', 'wromox_shortcode_single_product_price' );
//	add_shortcode( 'wromox_single_product_tabs', 'wromox_shortcode_single_product_tabs' );
//	add_shortcode( 'wromox_single_product_stock_progress_bar', 'wromox_shortcode_single_product_stock_progress_bar' );
//	add_shortcode( 'wromox_single_product_reviews', 'wromox_shortcode_single_product_reviews' );
//	add_shortcode( 'wromox_single_product_rating', 'wromox_shortcode_single_product_rating' );
//	add_shortcode( 'wromox_single_product_notices', 'wromox_shortcode_single_product_notices' );
//	add_shortcode( 'wromox_single_product_nav', 'wromox_shortcode_single_product_nav' );
//	add_shortcode( 'wromox_single_product_meta', 'wromox_shortcode_single_product_meta' );
//	add_shortcode( 'wromox_single_product_hook', 'wromox_shortcode_single_product_hook' );

	add_shortcode( 'html_block', 'wromox_html_block_shortcode' );
	add_shortcode( 'social_buttons', 'wromox_shortcode_social' );
	add_shortcode( 'wromox_info_box', 'wromox_shortcode_info_box' );
	add_shortcode( 'wromox_info_box_carousel', 'wromox_shortcode_info_box_carousel' );
	add_shortcode( 'wromox_button', 'wromox_shortcode_button' );
	add_shortcode( 'author_area', 'wromox_shortcode_author_area' );
	add_shortcode( 'promo_banner', 'wromox_shortcode_promo_banner' );
	add_shortcode( 'banners_carousel', 'wromox_shortcode_banners_carousel' );
	add_shortcode( 'wromox_instagram', 'wromox_shortcode_instagram' );
	add_shortcode( 'user_panel', 'wromox_shortcode_user_panel' );
	add_shortcode( 'wromox_compare', 'wromox_compare_shortcode' );
	add_shortcode( 'wromox_size_guide', 'wromox_size_guide_shortcode' );
	add_shortcode( 'wromox_gallery', 'wromox_images_gallery_shortcode' );
	add_shortcode( 'wromox_blog', 'wromox_shortcode_blog' );

	if ( function_exists( 'wromox_get_current_page_builder' ) && 'wpb' === wromox_get_current_page_builder() ) {
		add_shortcode( 'wromox_3d_view', 'wromox_shortcode_3d_view' );
		add_shortcode( 'wromox_ajax_search', 'wromox_ajax_search' );
		add_shortcode( 'wromox_countdown_timer', 'wromox_shortcode_countdown_timer' );
		add_shortcode( 'wromox_counter', 'wromox_shortcode_animated_counter' );
		add_shortcode( 'extra_menu', 'wromox_shortcode_extra_menu' );
		add_shortcode( 'extra_menu_list', 'wromox_shortcode_extra_menu_list' );
		add_shortcode( 'wromox_google_map', 'wromox_shortcode_google_map' );
		add_shortcode( 'wromox_image_hotspot', 'wromox_image_hotspot_shortcode' );
		add_shortcode( 'wromox_hotspot', 'wromox_hotspot_shortcode' );
		add_shortcode( 'wromox_list', 'wromox_list_shortcode' );
		add_shortcode( 'wromox_mega_menu', 'wromox_shortcode_mega_menu' );
		add_shortcode( 'wromox_menu_price', 'wromox_shortcode_menu_price' );
		add_shortcode( 'wromox_popup', 'wromox_shortcode_popup' );
		add_shortcode( 'wromox_portfolio', 'wromox_shortcode_portfolio' );
		add_shortcode( 'pricing_tables', 'wromox_shortcode_pricing_tables' );
		add_shortcode( 'pricing_plan', 'wromox_shortcode_pricing_plan' );
		add_shortcode( 'wromox_responsive_text_block', 'wromox_shortcode_responsive_text_block' );
		add_shortcode( 'wromox_text_block', 'wromox_shortcode_text_block' );
		add_shortcode( 'wromox_image', 'wromox_shortcode_image' );
		add_shortcode( 'wromox_mailchimp', 'wromox_shortcode_mailchimp' );
		add_shortcode( 'wromox_row_divider', 'wromox_row_divider' );
		add_shortcode( 'wromox_slider', 'wromox_shortcode_slider' );
		add_shortcode( 'team_member', 'wromox_shortcode_team_member' );
		add_shortcode( 'testimonials', 'wromox_shortcode_testimonials' );
		add_shortcode( 'testimonial', 'wromox_shortcode_testimonial' );
		add_shortcode( 'wromox_timeline', 'wromox_timeline_shortcode' );
		add_shortcode( 'wromox_timeline_item', 'wromox_timeline_item_shortcode' );
		add_shortcode( 'wromox_timeline_breakpoint', 'wromox_timeline_breakpoint_shortcode' );
		add_shortcode( 'wromox_title', 'wromox_shortcode_title' );
		add_shortcode( 'wromox_twitter', 'wromox_twitter' );
		add_shortcode( 'wromox_tabs', 'wromox_shortcode_tabs' );
		add_shortcode( 'wromox_tab', 'wromox_shortcode_tab' );
		add_shortcode( 'wromox_accordion', 'wromox_shortcode_accordion' );
		add_shortcode( 'wromox_accordion_item', 'wromox_shortcode_accordion_item' );

		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			add_shortcode( 'products_tabs', 'wromox_shortcode_products_tabs' );
			add_shortcode( 'products_tab', 'wromox_shortcode_products_tab' );
			add_shortcode( 'wromox_brands', 'wromox_shortcode_brands' );
			add_shortcode( 'wromox_categories', 'wromox_shortcode_categories' );
			add_shortcode( 'wromox_product_filters', 'wromox_product_filters_shortcode' );
			add_shortcode( 'wromox_filter_categories', 'wromox_filters_categories_shortcode' );
			add_shortcode( 'wromox_filters_attribute', 'wromox_filters_attribute_shortcode' );
			add_shortcode( 'wromox_filters_orderby', 'wromox_orderby_filter_template' );
			add_shortcode( 'wromox_filters_price_slider', 'wromox_filters_price_slider_shortcode' );
			add_shortcode( 'wromox_stock_status', 'wromox_stock_status_shortcode' );    
			add_shortcode( 'wromox_products', 'wromox_shortcode_products' );
		}

		if ( function_exists( 'vc_add_shortcode_param' ) ) {
			vc_add_shortcode_param( 'wromox_datepicker', 'wromox_get_datepicker_param' );
			vc_add_shortcode_param( 'wromox_button_set', 'wromox_get_button_set_param' );
			vc_add_shortcode_param( 'wromox_colorpicker', 'wromox_get_colorpicker_param' );
			vc_add_shortcode_param( 'wromox_box_shadow', 'wromox_get_box_shadow_param' );
			vc_add_shortcode_param( 'wromox_css_id', 'wromox_get_css_id_param' );
			vc_add_shortcode_param( 'wromox_dropdown', 'wromox_get_dropdown_param' );
			vc_add_shortcode_param( 'wromox_empty_space', 'wromox_get_empty_space_param' );
			vc_add_shortcode_param( 'wromox_gradient', 'wromox_add_gradient_type' );
			vc_add_shortcode_param( 'wromox_image_hotspot', 'wromox_image_hotspot' );
			vc_add_shortcode_param( 'wromox_image_select', 'wromox_add_image_select_type' );
			vc_add_shortcode_param( 'wromox_responsive_size', 'wromox_get_responsive_size_param' );
			vc_add_shortcode_param( 'wromox_responsive_spacing', 'wromox_get_responsive_spacing_param' );
			vc_add_shortcode_param( 'wromox_slider', 'wromox_get_slider_param' );
			vc_add_shortcode_param( 'wromox_switch', 'wromox_get_switch_param' );
			vc_add_shortcode_param( 'wromox_title_divider', 'wromox_get_title_divider_param' );

			vc_add_shortcode_param( 'wd_slider', 'wromox_get_slider_responsive_param' );
			vc_add_shortcode_param( 'wd_number', 'wromox_get_number_param' );
		}
	}

	if ( function_exists( 'wromox_get_opt' ) && wromox_get_opt( 'single_post_justified_gallery' ) ) {
		remove_shortcode( 'gallery' );
		add_shortcode( 'gallery', 'wromox_gallery_shortcode' );
	}
}
add_action( 'init', 'wromox_add_shortcodes' );

/**
 * ------------------------------------------------------------------------------------------------
 * Add metaboxes to the product
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'wromox_product_360_view_meta' ) ) {
	function wromox_product_360_view_meta() {
		add_meta_box( 'woocommerce-product-360-images', esc_html__( 'Product 360 View Gallery (optional)', 'wromox' ), 'wromox_360_metabox_output', 'product', 'side', 'low' );
	}
	add_action( 'add_meta_boxes', 'wromox_product_360_view_meta', 50 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Add metaboxes
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'wromox_sguide_add_metaboxes' ) ) {
	function wromox_sguide_add_metaboxes() {
		if ( function_exists( 'wromox_get_opt' ) && ! wromox_get_opt( 'size_guides' ) ) {
			return;
		}

		// Add table metaboxes to size guide
		add_meta_box( 'wromox_sguide_metaboxes', esc_html__( 'Create/modify size guide table', 'wromox' ), 'wromox_sguide_metaboxes', 'wromox_size_guide', 'normal', 'default' );
		// Add metaboxes to product
		add_meta_box( 'wromox_sguide_dropdown_template', esc_html__( 'Choose size guide', 'wromox' ), 'wromox_sguide_dropdown_template', 'product', 'side' );
		// Add category metaboxes to size guide
		add_meta_box( 'wromox_sguide_category_template', esc_html__( 'Choose product categories', 'wromox' ), 'wromox_sguide_category_template', 'wromox_size_guide', 'side' );
		// Add hide table checkbox to size guide
		add_meta_box( 'wromox_sguide_hide_table_template', esc_html__( 'Hide size guide table', 'wromox' ), 'wromox_sguide_hide_table_template', 'wromox_size_guide', 'side' );
	}
	add_action( 'add_meta_boxes', 'wromox_sguide_add_metaboxes' );
}

if ( ! function_exists( 'wromox_widgets_init' ) ) {
	function wromox_widgets_init() {
		if ( ! is_blog_installed() || ! class_exists( 'WROMOX_WP_Nav_Menu_Widget' ) ) {
			return;
		}

		register_widget( 'WROMOX_WP_Nav_Menu_Widget' );
		register_widget( 'WROMOX_Banner_Widget' );
		register_widget( 'WROMOX_Author_Area_Widget' );
		register_widget( 'WROMOX_Instagram_Widget' );
		register_widget( 'WROMOX_Static_Block_Widget' );
		register_widget( 'WROMOX_Recent_Posts' );
		register_widget( 'WROMOX_Twitter' );
		register_widget( 'WROMOX_Widget_Mailchimp' );

		if ( wromox_woocommerce_installed() ) {
			register_widget( 'WROMOX_User_Panel_Widget' );
			register_widget( 'WROMOX_Widget_Layered_Nav' );
			register_widget( 'WROMOX_Widget_Sorting' );
			register_widget( 'WROMOX_Widget_Price_Filter' );
			register_widget( 'WROMOX_Widget_Search' );
			register_widget( 'WROMOX_Stock_Status' );
		}

	}

	add_action( 'widgets_init', 'wromox_widgets_init' );
}

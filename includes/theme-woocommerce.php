<?php
if ( ! defined( 'ABSPATH' ) ) exit;
global $woo_options;

/*-----------------------------------------------------------------------------------*/
/* Hooks & Filters */
/*-----------------------------------------------------------------------------------*/

if ( ! is_admin() ) {
	add_action( 'wp_enqueue_scripts', 'woo_wc_css', 20 );
}

add_action( 'after_setup_theme', 'woocommerce_support' );

// Upsells
remove_action( 'woocommerce_after_single_product_summary', 	'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 	'woo_wc_upsell_display', 15 );

// Related Products
add_filter( 'woocommerce_output_related_products_args', 	'woo_wc_related_products' );

// Custom place holder
add_filter( 'woocommerce_placeholder_img_src', 				'woo_wc_placeholder_img_src' );

// Product columns
add_filter( 'loop_shop_columns', 							'woo_wc_loop_columns', 98 );

// Layout
remove_action( 'woocommerce_before_main_content', 			'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 			'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 				'woo_wc_before_content', 10 );
add_action( 'woocommerce_after_main_content', 				'woo_wc_after_content', 20 );
add_filter( 'body_class',									'woo_wc_layout_body_class', 10 );

// Breadcrumb
remove_action( 'woocommerce_before_main_content', 			'woocommerce_breadcrumb', 20, 0 );

// Sidebar
remove_action( 'woocommerce_sidebar', 						'woocommerce_get_sidebar', 10 );
add_action( 'woocommerce_sidebar', 							'woo_wc_get_sidebar', 10 );

// Pagination / Search
remove_action( 'woocommerce_after_shop_loop', 				'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 					'woo_wc_pagination', 10 );

// Cart Fragments
add_filter( 'add_to_cart_fragments', 						'woo_wc_header_add_to_cart_fragment' );

// Move Product Tabs
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 50 );

// Move Excerpt Text
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 35 );

// Link Product Thumbnail
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_custom_template_loop_product_thumbnail', 8 );

// Move Sale badge (Single Products)
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_sale_flash', 10 );

/*-----------------------------------------------------------------------------------*/
/* Compatibility */
/*-----------------------------------------------------------------------------------*/

// Declare WooCommerce Support
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

/*-----------------------------------------------------------------------------------*/
/* Styles */
/*-----------------------------------------------------------------------------------*/

// Disable WooCommerce styles
if ( version_compare( WOOCOMMERCE_VERSION, '2.1' ) >= 0 ) {
    // WooCommerce 2.1 or above is active
    add_filter( 'woocommerce_enqueue_styles', '__return_false' );
} else {
    // WooCommerce less than 2.1 is active
    define( 'WOOCOMMERCE_USE_CSS', false );
}

if ( ! function_exists( 'woo_wc_css' ) ) {
	function woo_wc_css () {
		wp_register_style( 'woocommerce', esc_url( get_template_directory_uri() . '/css/woocommerce.css' ) );
		wp_enqueue_style( 'woocommerce' );
	} // End woo_wc_css()
}


/*-----------------------------------------------------------------------------------*/
/* Products */
/*-----------------------------------------------------------------------------------*/

// Replace the default upsell function with our own which displays the correct number product columns
if ( ! function_exists( 'woo_wc_upsell_display' ) ) {
	function woo_wc_upsell_display() {
	    woocommerce_upsell_display( -1, 3 );
	}
}

// Replace the default related products function with our own which displays the correct number of product columns
function woo_wc_related_products() {
	$args = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);
	return $args;
}

// Custom Placeholder
if ( ! function_exists( 'woo_wc_placeholder_img_src' ) ) {
	function woo_wc_placeholder_img_src( $src ) {
		global $woo_options;
		if ( isset( $woo_options['woo_placeholder_url'] ) && '' != $woo_options['woo_placeholder_url'] ) {
			$src = $woo_options['woo_placeholder_url'];
		}
		else {
			$src = get_template_directory_uri() . '/images/wc-placeholder.gif';
		}
		return esc_url( $src );
	} // End woo_wc_placeholder_img_src()
}

// Set product columns to 3
if ( ! function_exists( 'woo_wc_loop_columns' ) ) {
	function woo_wc_loop_columns() {
		return 3;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Add product wrapper */
/*-----------------------------------------------------------------------------------*/

add_action( 'woocommerce_before_shop_loop_item', 'woo_loop_item_wrapper_before', 9 );
if ( ! function_exists( 'woo_loop_item_wrapper_before' ) ) {
	function woo_loop_item_wrapper_before() {
	?>
		<div class="item-wrapper">
	<?php
	}
}

add_action( 'woocommerce_after_shop_loop_item', 'woo_loop_item_wrapper_after', 11 );
if ( ! function_exists( 'woo_loop_item_wrapper_after' ) ) {
	function woo_loop_item_wrapper_after() {
	?>
		</div><!-- /.item-wrapper -->
	<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/* Layout */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_wc_before_content' ) ) {
	function woo_wc_before_content() {
		global $woo_options;
		?>
		<!-- #content Starts -->
	    <div id="content" class="col-full">

	       	<div class="section-wrapper">

		        <!-- #main Starts -->
		        <?php woo_main_before(); ?>
		        <div id="main" class="col-left">

	    <?php
	} // End woo_wc_before_content()
}


if ( ! function_exists( 'woo_wc_after_content' ) ) {
	function woo_wc_after_content() {
		?>

				</div><!-- /#main -->
		        <?php woo_main_after(); ?>

		        <?php do_action( 'woocommerce_sidebar' ); ?>

			</div><!-- /.section-wrapper -->		

	    </div><!-- /#content -->
		<?php woo_content_after(); ?>
	    <?php
	} // End woo_wc_after_content()
}

// Add a class to the body if full width shop archives are specified
if ( ! function_exists( 'woo_wc_layout_body_class' ) ) {
	function woo_wc_layout_body_class( $wc_classes ) {
		global $woo_options, $post;
		$single_layout = get_post_meta( $post->ID, '_layout', true );

		$layout = '';

		// Add layout-full class to product archives if necessary
		if ( isset( $woo_options['woocommerce_archives_fullwidth'] ) && 'true' == $woo_options['woocommerce_archives_fullwidth'] && ( is_shop() || is_product_category() ) ) {
			$layout = 'layout-full';
		}
		// Add layout-full class to single product pages if necessary
		if ( ( $woo_options[ 'woocommerce_products_fullwidth' ] == "true" && is_product() ) && ( $single_layout != 'layout-left-content' && $single_layout != 'layout-right-content' ) ) {
			$layout = 'layout-full';
		}

		// Add classes to body_class() output
		$wc_classes[] = $layout;
		return $wc_classes;
	} // End woocommerce_layout_body_class()
}

/*-----------------------------------------------------------------------------------*/
/* Sidebar */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_wc_get_sidebar' ) ) {
	function woo_wc_get_sidebar() {
		global $woo_options, $post;

		// Display the sidebar if full width option is disabled on archives
		if ( ! is_product() ) {
			if ( isset( $woo_options['woocommerce_archives_fullwidth'] ) && 'false' == $woo_options['woocommerce_archives_fullwidth'] ) {
				get_sidebar('shop');
			}
		} else {
			$single_layout = get_post_meta( $post->ID, '_layout', true );
			if ( $woo_options[ 'woocommerce_products_fullwidth' ] == 'false' || ( $woo_options[ 'woocommerce_products_fullwidth' ] == 'true' && $single_layout != "layout-full" && $single_layout != "layout-default" ) ) {
				get_sidebar('shop');
			}
		}

	} // End woo_wc_get_sidebar()
}

/*-----------------------------------------------------------------------------------*/
/* Pagination / Search */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_wc_pagination' ) ) {
function woo_wc_pagination() {
	if ( is_search() && is_post_type_archive() ) {
		add_filter( 'woo_pagination_args', 'woo_wc_add_search_fragment', 10 );
		add_filter( 'woo_pagination_args_defaults', 'woo_wc_pagination_defaults', 10 );
	}
	$args = array( 'prev_text' => __( '&larr;', 'woothemes' ), 'next_text' => __( '&rarr;', 'woothemes' ) );			
	woo_pagination( $args, '');
} // End woo_wc_pagination()
}

if ( ! function_exists( 'woo_wc_add_search_fragment' ) ) {
function woo_wc_add_search_fragment ( $settings ) {
	$settings['add_fragment'] = '&post_type=product';
	return $settings;
} // End woo_wc_add_search_fragment()
}

if ( ! function_exists( 'woo_wc_pagination_defaults' ) ) {
function woo_wc_pagination_defaults ( $settings ) {
	$settings['use_search_permastruct'] = false;
	return $settings;
} // End woo_wc_pagination_defaults()
}

/*-----------------------------------------------------------------------------------*/
/* Cart Fragments */
/*-----------------------------------------------------------------------------------*/

// Ensure cart contents update when products are added to the cart via AJAX
if ( ! function_exists( 'woo_wc_header_add_to_cart_fragment' ) ) {
	function woo_wc_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;

		ob_start();

		woo_wc_cart_link();

		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	} // End woo_wc_header_add_to_cart_fragment()
}

if ( ! function_exists( 'woo_wc_cart_link' ) ) {
	function woo_wc_cart_link() {
		global $woocommerce;
		?>
		<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><span class="count"><?php echo sprintf( _n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes' ), $woocommerce->cart->cart_contents_count );?></span></a>
		<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/* Custom Image Sizes */
/*-----------------------------------------------------------------------------------*/

add_action( 'init', 'woo_woocommerce_image_dimensions', 1 );
if ( ! function_exists( 'woo_woocommerce_image_dimensions' ) ) {
	function woo_woocommerce_image_dimensions() {
	  	$catalog = array(
			'width' 	=> '400',	// px
			'height'	=> '400',	// px
			'crop'		=> 1 		// true
		);
	 
		$single = array(
			'width' 	=> '600',	// px
			'height'	=> '600',	// px
			'crop'		=> 1 		// true
		);
	 
		$thumbnail = array(
			'width' 	=> '120',	// px
			'height'	=> '120',	// px
			'crop'		=> 0 		// false
		);
	 
		// Image sizes
		update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
		update_option( 'shop_single_image_size', $single ); 		// Single product image
		update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
	}
}

/*-----------------------------------------------------------------------------------*/
/* Remove title from WooCommerce Pages */
/*-----------------------------------------------------------------------------------*/

add_filter('woocommerce_show_page_title', 'woo_remove_archive_title');
if ( ! function_exists( 'woo_remove_archive_title' ) ) {
	function woo_remove_archive_title() {
		return false;
	}
}

if ( ! function_exists( 'woocommerce_custom_template_loop_product_thumbnail' ) ) {
	function woocommerce_custom_template_loop_product_thumbnail() {
		echo '<a href="' . get_permalink() . '">';
		echo woocommerce_get_product_thumbnail();
		echo '</a>';
	}
}
<?php
// File Security Check
if ( ! function_exists( 'wp' ) && ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?><?php
/**
 * Index Template
 *
 * Here we setup all logic and XHTML that is required for the index template, used as both the homepage
 * and as a fallback template, if a more appropriate template file doesn't exist for a specific context.
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;

	$settings = array(

				'homepage_enable_featured_products' => 'true',
				'homepage_enable_features' => 'true',
				'homepage_enable_categories' => 'true',
				'homepage_enable_testimonials' => 'true',
				'homepage_enable_content' => 'true',
				'homepage_enable_promotion' => 'true',
				'homepage_enable_columns' => 'true',
				'homepage_number_of_features' => 4,
				'homepage_number_of_testimonials' => 4,				
				'homepage_features_area_title' => '',
				'homepage_testimonials_area_title' => '',
				'homepage_features_area_description' => '',				
				'homepage_testimonials_area_description' => '',
				'homepage_content_type' => 'posts'
				);

	$settings = woo_get_dynamic_values( $settings );	

?>

    <div id="content">

    		<section class="homepage-area fullwidth">

    			<?php if ( is_home() && ! dynamic_sidebar( 'homepage' ) ) : ?>

					<?php
						if ( 'true' == $settings['homepage_enable_featured_products'] ) {
							get_template_part( 'includes/homepage/featured-products' );
						}
					?>

					<?php
						if ( 'true' == $settings['homepage_enable_features'] ) {
							$args = array( 'title' => stripslashes( $settings['homepage_features_area_title'] ), 'size' => 250, 'per_row' => 4, 'limit' => 4 );
							$args['before'] = '<section id="features" class="widget widget_woothemes_features home-section"><div class="col-full"><div class="section-wrapper">';
							$args['after'] = '</div></div></section>';
							$args['before_title'] = '<header class="block"><h1>';
							$args['after_title'] = '</h1>' . ( '' != $settings['homepage_features_area_description'] ? '<p>' . stripslashes( $settings['homepage_features_area_description'] . '</p>' ) : '' ) . '</header>';

							do_action( 'woothemes_features', $args );
						}
					?>

					<?php
						if ( 'true' == $settings['homepage_enable_categories'] ) {
							get_template_part( 'includes/homepage/category-blog-posts' );
						}
					?>

					<?php
						if ( 'true' == $settings['homepage_enable_testimonials'] ) {
							$args = array( 'title' => stripslashes( $settings['homepage_testimonials_area_title'] ), 'size' => 45, 'per_row' => 4, 'limit' => 4 );
							$args['before'] = '<section id="testimonials" class="widget widget_woothemes_testimonials home-section columns-4"><div class="col-full"><div class="section-wrapper">';
							$args['after'] = '</div></div></section>';
							$args['before_title'] = '<header class="block"><h1>';
							$args['after_title'] = '</h1>' . ( '' != $settings['homepage_testimonials_area_description'] ? '<p>' . stripslashes( $settings['homepage_testimonials_area_description'] . '</p>' ) : '' ) . '</header>';

							do_action( 'woothemes_testimonials', $args );
						}
					?>

					<?php

						if ( 'true' == $settings['homepage_enable_content'] ) {
							switch ( $settings['homepage_content_type'] ) {
								case 'page':
								get_template_part( 'includes/homepage/specific-page-content' );
								break;

								case 'posts':
								default:
								get_template_part( 'includes/homepage/blog-posts' );
								break;
							}
						}

					?>

					<?php
						if ( 'true' == $settings['homepage_enable_columns'] ) {
							get_template_part( 'includes/homepage/homepage-columns' );
						}				
					?>

					<?php
						if ( 'true' == $settings['homepage_enable_promotion'] ) {
							get_template_part( 'includes/homepage/promotion' );
						}
					?>															

    			<?php endif; ?>

    		</section>

    </div><!-- /#content -->

<?php get_footer(); ?>
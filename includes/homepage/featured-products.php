<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Featured Products Component
 *
 * Display X recent featured products.
 *
 * @author Matty
 * @since 1.0.0
 * @package WooFramework
 * @subpackage Component
 */
global $woocommerce;

$settings = array(
				'homepage_featured_products_limit' => 4,
				'homepage_featured_products_area_title' => '',
				'homepage_featured_products_area_description' => ''
			);

$settings = woo_get_dynamic_values( $settings );

?>

<div id="featured-products" class="widget home-section">

	<div class="col-full">

		<div class="section-wrapper">

    		<?php if ( '' != $settings['homepage_featured_products_area_title'] || '' != $settings['homepage_featured_products_area_title'] ): ?>
			<header>
				<?php if ( '' != $settings['homepage_featured_products_area_title'] ): ?><h1><?php echo esc_attr( stripslashes( $settings['homepage_featured_products_area_title'] ) ); ?></h1><?php endif; ?>
				<?php if ( '' != $settings['homepage_featured_products_area_description'] ): ?><p><?php echo esc_attr( stripslashes( $settings['homepage_featured_products_area_description'] ) ); ?></p><?php endif; ?>
			</header>
			<?php endif; ?>		

			<ul class="products">

				<?php
				$i = 0;

				$args = array( 'post_type' => 'product', 'posts_per_page' => intval( $settings['homepage_featured_products_limit'] ) );

				$args['meta_query'] = array();
				$args['meta_query']['relation'] = 'AND';
				$args['meta_query'][] = array( 'key' => '_featured', 'value' => 'yes', 'compare' => '=' );
				$args['meta_query'][] = array( 'key' => '_visibility', 'value' => array( 'visible', 'catalog' ), 'compare' => 'IN' );
				$args['meta_query'][] = array( 'key' => '_stock_status', 'value' => array( 'outofstock' ), 'compare' => 'NOT IN' );

				$count = 0;
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); $_product; $count++;
				if ( function_exists( 'get_product' ) ) {
					$_product = get_product( $loop->post->ID );
				} else {
					$_product = new WC_Product( $loop->post->ID );
				}
				?>

				<li class="product col col4<?php if( ($count % 4) == 0 ) { echo ' last'; } ?>">

					<?php woocommerce_show_product_sale_flash( $post, $_product ); ?>
					<a href="<?php echo get_permalink( $loop->post->ID ); ?>" title="<?php // echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
					
						<?php
						if ( has_post_thumbnail( $loop->post->ID ) ) {
							echo get_the_post_thumbnail( $loop->post->ID, 'shop_single' );
						} else {
							echo '<img src="' . $woocommerce->plugin_url() . '/assets/images/placeholder.png" alt="Placeholder" width="' . $woocommerce->get_image_size( 'shop_single_image_width' ) . 'px" height="' . $woocommerce->get_image_size( 'shop_single_image_height' ) . 'px" />';
						}
						?>

						<div class="product-details">
							<h3><?php the_title(); ?></h3>
							<span class="price"><?php echo $_product->get_price_html(); ?></span>
						</div><!--/.product-details-->

					</a>

				</li>

			<?php endwhile; ?>

			</ul><!--/.featured-1-->

		</div><!--/.section-wrapper-->

	</div><!--/.col-full-->

</div>
<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Category Blog Posts Component
 *
 * Display X recent blog posts.
 *
 * @author Tiago
 * @since 1.0.0
 * @package WooFramework
 * @subpackage Component
 */
$settings = array(
				'homepage_category_categories_number' => 3, 
				'homepage_category_categories_exclude' => '',
				'homepage_category_categories_specific' => '',
				'homepage_category_area_title' => '',
				'homepage_category_area_description' => ''
				);
					
$settings = woo_get_dynamic_values( $settings );

?>

<section id="category-posts" class="home-section">

	<div class="col-full">

    	<div class="section-wrapper">

    		<?php if ( '' != $settings['homepage_category_area_title'] || '' != $settings['homepage_category_area_title'] ): ?>
			<header>
				<?php if ( '' != $settings['homepage_category_area_title'] ): ?><h1><?php echo esc_attr( stripslashes( $settings['homepage_category_area_title'] ) ); ?></h1><?php endif; ?>
				<?php if ( '' != $settings['homepage_category_area_description'] ): ?><p><?php echo esc_attr( stripslashes( $settings['homepage_category_area_description'] ) ); ?></p><?php endif; ?>
			</header>
			<?php endif; ?>

    		<?php

    			$args = array(
    					'number' => esc_attr($settings['homepage_category_categories_number'])
    				);

    			if ( '' != $settings['homepage_category_categories_exclude'] && 
    				 '' == $settings['homepage_category_categories_specific'] ) {
    				$args['exclude'] = esc_attr( $settings['homepage_category_categories_exclude'] );
    			}

    			if ( '' != $settings['homepage_category_categories_specific'] ) {
    				$args['include'] = esc_attr ( $settings['homepage_category_categories_specific'] ) ;
    			}

    			$cats = get_categories( $args );
				$count = 0;					
    			foreach ( $cats as $cat ) {

    				$count++;
    				$class = 'category col col3';
    				if ( $count == 1 ) $class .= ' first'; 
					if ( $count == 3 ) { $class .= ' last'; $count = 0; }

					echo '<div class="'. $class .'">';	// category container
					echo '<h3>' . $cat->cat_name . '<a class="button view-all" href="' . get_category_link( $cat->cat_ID ) . '" title="' . $cat->cat_name . '">' . __('View All', 'woothemes') . '</a>' . '</h3>';
					echo '<ul>';
					$args = array( 'posts_per_page' => 5, 'cat' => $cat->cat_ID );
					$posts = get_posts( $args );
					foreach ( $posts as $post ) { setup_postdata( $post );
					?>
					
						<li>
							<?php woo_image( 'width=60&height=60&class=thumbnail' ); ?>
							<div class="post-details">
								<a class="title" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
								<p><span class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></span> <span class="by"><?php _e('by', 'woothemes'); ?></span> <?php the_author_posts_link(); ?></p>
							</div>
						</li>

					<?php
					}

					echo '</ul></div>'; // /category container
					wp_reset_postdata();
    			}
    		?>

		</div><!-- /.section-wrapper-->

	</div><!-- /.col-full-->

</section><!-- /#main -->
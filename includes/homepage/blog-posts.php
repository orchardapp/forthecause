<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Blog Posts Component
 *
 * Display X recent blog posts.
 *
 * @author Tiago
 * @since 1.0.0
 * @package WooFramework
 * @subpackage Component
 */
$settings = array(
				'homepage_number_of_posts' => 4, 
				'homepage_posts_category' => '',
				'homepage_content_area_title' => '',
				'homepage_content_area_description' => ''
				);
					
$settings = woo_get_dynamic_values( $settings );

if ( get_query_var( 'paged') ) { $paged = get_query_var( 'paged' ); } elseif ( get_query_var( 'page') ) { $paged = get_query_var( 'page' ); } else { $paged = 1; }

$query_args = array(
						'post_type' => 'post', 
						'posts_per_page' => intval( $settings['homepage_number_of_posts'] ), 
						'paged' => $paged,
						'tax_query' => array(
							array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => 'post-format-gallery',
								'operator' => 'NOT IN'
							)
						)
					);

if ( 0 < intval( $settings['homepage_posts_category'] ) ) {
	$query_args['cat'] = intval( $settings['homepage_posts_category'] );
}
?>

<section id="blog-posts" class="home-section columns-4">

	<div class="col-full">

    	<div class="section-wrapper">

    		<?php if ( '' != $settings['homepage_content_area_title'] || '' != $settings['homepage_content_area_title'] ): ?>
			<header>
				<?php if ( '' != $settings['homepage_content_area_title'] ): ?><h1><?php echo esc_attr( stripslashes( $settings['homepage_content_area_title'] ) ); ?></h1><?php endif; ?>
				<?php if ( '' != $settings['homepage_content_area_description'] ): ?><p><?php echo esc_attr( stripslashes( $settings['homepage_content_area_description'] ) ); ?></p><?php endif; ?>
			</header>
			<?php endif; ?>		

	<?php
		query_posts( $query_args );
		
		if ( have_posts() ) {
			$count = 0;
			?>
			<ul>
			<?php

			while ( have_posts() ) { the_post(); $count++;

?>
				<?php $grid = array('col', 'col4'); ?>
				<?php
					if ( $count == 1 ) $grid[] = 'first'; 
					if ( $count == 4 ) { $grid[] = 'last'; $count = 0; }
				?>
				<li <?php post_class( $grid ); ?>>
					
					<div class="media">
				    	<?php woo_image( 'width=252&height=161&class=thumbnail' ); ?>
						<?php if ( '' == $settings['homepage_posts_category'] ): ?><span class="post-category"><?php $category = get_the_category(); echo $category[0]->cat_name; ?></span><?php endif; ?>			    	
				    </div>

				    <div class="post-details">
						<h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
						<span class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
					</div>

				</li><!-- /.post -->

<?php

			} // End WHILE Loop

			?>
			</ul>
			<?php 			
		
		} else {
	?>
	    <article <?php post_class(); ?>>
	        <p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
	    </article><!-- /.post -->
	<?php } // End IF Statement ?> 

	<?php wp_reset_query(); ?>

		</div><!-- /.section-wrapper-->

	</div><!-- /.col-full-->

</section><!-- /#main -->
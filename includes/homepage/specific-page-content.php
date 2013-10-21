<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Page Content Component
 *
 * Display content from a specified page.
 *
 * @author Tiago
 * @since 1.0.0
 * @package WooFramework
 * @subpackage Component
 */
$settings = array(
				'homepage_page_id' => ''
				);
					
$settings = woo_get_dynamic_values( $settings );

if ( 0 < intval( $settings['homepage_page_id'] ) ) {
$query = new WP_Query( 'page_id=' . intval( $settings['homepage_page_id'] ) );
?>

<section id="page-content" class="home-section">

	<div class="col-full">

    	<div class="section-wrapper">

			<div id="page-content">

			<?php woo_loop_before(); ?>

			<?php
				if ( $query->have_posts() ) {
					
					while ( $query->have_posts() ) { $query->the_post();
			?>

				<article <?php post_class(); ?>>

					<header>
						<h1><?php the_title(); ?></h1>
					</header>

					<section class="entry">
						<?php the_content( __( 'Continue Reading &rarr;', 'woothemes' ) ); ?>
					</section>

				</article>

			<?php
					} // End WHILE Loop
				
				} else {
			?>
			    <article <?php post_class(); ?>>
			    	<p><?php _e( 'Selected home page content not found.', 'woothemes' ); ?></p>
			    </article><!-- /.post -->
			<?php } ?> 

			<?php woo_loop_after(); ?>

			</div>

		</div><!-- /.section-wrapper-->

	</div><!-- /.col-full-->

</section><!-- /#page-content -->

<div class="fix"></div>

<?php } // End the main check ?>
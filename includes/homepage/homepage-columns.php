<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Homepage Columns
 *
 * Homepage Widgets
 *
 * @author Tiago
 * @since 1.0.0
 * @package WooFramework
 * @subpackage Component
 */

	if ( woo_active_sidebar( 'homepage-columns-left' ) ||
		 woo_active_sidebar( 'homepage-columns-right' ) ) {

	?>

		<section id="homepage-columns" class="home-section">

			<div class="col-full">

				<div class="section-wrapper">

					<?php if ( woo_active_sidebar( 'homepage-columns-left' ) ) { ?>
					<div class="col col2">
						<?php woo_sidebar( 'homepage-columns-left' ); ?>
					</div><!-- /.block -->			
					<?php } ?>

					<?php if ( woo_active_sidebar( 'homepage-columns-right' ) ) { ?>
					<div class="col col2 last">
						<?php woo_sidebar( 'homepage-columns-right' ); ?>
					</div><!-- /.block -->			
					<?php } ?>

				</div><!-- /.section-wrapper-->

			</div><!-- /.col-full-->	

		</section><!-- /#homepage-columns -->

	<?php

	}

?>
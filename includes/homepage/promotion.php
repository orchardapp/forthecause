<?php
/**
 * Homepage Features Panel
 */
 
	/**
 	* The Variables
 	*
 	* Setup default variables, overriding them if the "Theme Options" have been saved.
 	*/
	
	global $woo_options;
	
	$settings = array(
					'homepage_promotion_title' => '',
					'homepage_promotion_subtext' => '',
					'homepage_promotion_button_text' => '',
					'homepage_promotion_button_url' => '',
					'homepage_promotion_image' => ''
					);
					
	$settings = woo_get_dynamic_values( $settings );

?>
	
	<?php if ( $settings['homepage_promotion_title'] != '' || $settings['homepage_promotion_subtext'] != '' ): ?>
	<section id="promotion" class="home-section">

		<div class="col-full">

	    	<div class="section-wrapper">
			
				<div class="left-section">

					<?php if ( '' != $settings['homepage_promotion_image'] ): ?>
						<img class="promo-img" src="<?php echo esc_url( $settings['homepage_promotion_image'] ); ?>" alt="<?php echo stripslashes( $settings['homepage_promotion_title'] ); ?>" />
					<?php endif; ?>

					<?php if ( '' != $settings['homepage_promotion_title'] ): ?>
						<h2><?php echo stripslashes( $settings['homepage_promotion_title'] ); ?></h2>
					<?php endif; ?>

					<?php if ( '' != $settings['homepage_promotion_subtext'] ): ?>
						<p><?php echo stripslashes( $settings['homepage_promotion_subtext'] ); ?></p>
					<?php endif; ?>

				</div>

				<div class="right-section">
					<?php if ( $settings['homepage_promotion_button_text'] != '' && $settings['homepage_promotion_button_url'] != '' ): ?>
						<a class="button" href="<?php echo esc_url($settings['homepage_promotion_button_url']); ?>"><?php echo stripslashes( $settings['homepage_promotion_button_text'] ); ?></a>
					<?php endif; ?>
				</div>

			</div><!-- /.section-wrapper-->

		</div><!-- /.col-full-->		

	</section>
	<?php endif; ?>
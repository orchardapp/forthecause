<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The default template for displaying content
 */

	global $woo_options;
?>

	<li <?php post_class(); ?>>
		
		<div class="image">
	    	<?php
	    		if ( isset( $woo_options['woo_post_content'] ) && $woo_options['woo_post_content'] != 'content' ) {
	    			woo_image( 'width=252&height=161&class=thumbnail' );
	    		}
	    	?>
	    </div>

	    <div class="post-details">
			<h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
			<span class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
			<span class="post-category"><?php $category = get_the_category(); echo $category[0]->cat_name; ?></span>
		</div>

	</li><!-- /.post -->
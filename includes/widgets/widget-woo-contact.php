<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/*---------------------------------------------------------------------------------*/
/* Contact Form */
/*---------------------------------------------------------------------------------*/
class Woo_ContactForm extends WP_Widget {
	var $settings = array( 'title' );

	function Woo_ContactForm() {
		$widget_ops = array( 'description' => 'This is a WooThemes Contact Form widget.' );
		parent::WP_Widget( false, __( 'Woo - Contact Form', 'woothemes' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		$settings = $this->woo_get_settings();
		extract( $args, EXTR_SKIP );
		$instance = wp_parse_args( $instance, $settings );
		extract( $instance, EXTR_SKIP );
?>

	<?php echo $before_widget; ?>
	<?php if ( $title ) { echo $before_title . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $after_title; } ?>

	<?php

        if ( isset( $_GET['message'] ) && 'success' == $_GET['message'] ) {
            echo do_shortcode( '[box type="tick"]' . __( 'Your message has been sent successfully.', 'woothemes' ) . '[/box]' );
        }
        if ( isset( $_GET['message'] ) && 'fields-missing' == $_GET['message'] ) {
            echo do_shortcode( '[box type="alert"]' . __( 'There are fields missing or incorrect. Please try again.', 'woothemes' ) . '[/box]' );
        }
        if ( isset( $_GET['message'] ) && 'invalid-verify' == $_GET['message'] ) {
            echo do_shortcode( '[box type="alert"]' . __( 'The verification code entered is incorrect. Please try again.', 'woothemes' ) . '[/box]' );
        }
        if ( isset( $_GET['message'] ) && 'error' == $_GET['message'] ) {
            echo do_shortcode( '[box type="alert"]' . __( 'There was an error sending your message. Please try again.', 'woothemes' ) . '[/box]' );
        }

        // If the form has errors, get the form data back.
        $data = woo_get_posted_contact_form_data();

    ?>
	<form action="<?php echo esc_url( $_SERVER['PHP_SELF'] . '#' . $this->id ); ?>" method="post">
			<p class="contact-name">
				<label for="contact-name"><?php _e( 'Name', 'woothemes' ); ?></label>
				<input type="text" name="contact-name" value="<?php if ( isset( $_GET['contact-name'] ) ) { esc_attr_e( $_GET['contact-name'] ); } ?>" />
			</p>
			<p class="contact-email">
				<label for="contact-email"><?php _e( 'Email Address', 'woothemes' ); ?></label>
				<input type="text" name="contact-email" value="<?php if ( isset( $_GET['contact-email'] ) ) { esc_attr_e( $_GET['contact-email'] ); } ?>" />                  				
			</p>
			<p class="contact-verify">
				<label for="contact-verify"><?php _e( '7 + 12 = ?', 'woothemes' ); ?></label>
				<input type="text" name="contact-verify" value="" />
			</p>
			<p class="contact-message">
				<label for="contact-message"><?php _e( 'Message', 'woothemes' ); ?></label>
				<textarea name="contact-message"><?php if ( isset( $_GET['contact-message'] ) ) { esc_attr_e( $_GET['contact-message'] ); } ?></textarea>
			</p>
			<p class="contact-submit">
                <input type="hidden" name="contact-form-submit" value="yes" />
    			<input type="submit" value="<?php esc_attr_e( 'Submit Message', 'woothemes' ); ?>" />
    		</p>
	</form>

	<?php echo $after_widget; ?>

<?php

	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	/**
	 * Provides an array of the settings with the setting name as the key and the default value as the value
	 * This cannot be called get_settings() or it will override WP_Widget::get_settings()
	 */
	function woo_get_settings() {
		// Set the default to a blank string
		$settings = array_fill_keys( $this->settings, '' );
	}

	function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->woo_get_settings() );
		extract( $instance, EXTR_SKIP );
		?>
		<p>
		   <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','woothemes'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr( $title ); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
		</p>
		<?php
	}
}

register_widget( 'Woo_ContactForm' );

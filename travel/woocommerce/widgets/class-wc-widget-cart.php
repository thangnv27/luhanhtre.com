<?php
/**
 * Shopping Cart Widget
 *
 * Displays shopping cart widget
 *
 * @author        WooThemes
 * @category      Widgets
 * @package       WooCommerce/Widgets
 * @version       2.0.0
 * @extends       WP_Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Travelwp_Custom_WC_Widget_Cart extends WC_Widget_Cart {

	var $woo_widget_cssclass;
	var $woo_widget_description;
	var $woo_widget_idbase;
	var $woo_widget_name;

	public function widget( $args, $instance ) {
		extract( $args );

//		if ( is_cart() || is_checkout() ) {
//			return;
//		}
		global $woocommerce;
		echo ent2ncr( $before_widget );
		$hide_if_empty = empty( $instance['hide_if_empty'] ) ? 0 : 1;
		$title         = $instance['title'];

		echo '<div class="minicart_hover" id="header-mini-cart">';
		$cat_total = $woocommerce->cart->get_cart_subtotal();

		list( $cart_items ) = travelwp_get_current_cart_info();

		if ( $title ) {
			echo '<span class="cart-title">' . $title . '</span>';
		}
		echo '<span class="cart-items-number"><i class="fa fa-fw fa-shopping-bag"></i>';
		echo '<span class="wrapper-items-number">' . $cart_items . '</span>';
 		echo '</span>';
 		echo '<div class="clear"></div>';
		echo '</div>';

		if ( $hide_if_empty ) {
			echo '<div class="hide_cart_widget_if_empty">';
		}
		// Insert cart widget placeholder - code in woocommerce.js will update this on page load
		echo '<div class="widget_shopping_cart_content" style="display: none;"></div>';
		if ( $hide_if_empty ) {
			echo '</div>';
		}
		echo ent2ncr( $after_widget );
	}

	/**
	 * update function.
	 *
	 * @see    WP_Widget->update
	 * @access public
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance['title']         = strip_tags( stripslashes( $new_instance['title'] ) );
		$instance['hide_if_empty'] = empty( $new_instance['hide_if_empty'] ) ? 0 : 1;

		return $instance;
	}


	/**
	 * form function.
	 *
	 * @see    WP_Widget->form
	 * @access public
	 *
	 * @param array $instance
	 *
	 * @return void
	 */
	public function form( $instance ) {
		$hide_if_empty = empty( $instance['hide_if_empty'] ) ? 0 : 1;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'woocommerce' ) ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php if ( isset ( $instance['title'] ) ) {
				echo esc_attr( $instance['title'] );
			} ?>" /></p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'hide_if_empty' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_if_empty' ) ); ?>"<?php checked( $hide_if_empty ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_if_empty' ) ); ?>"><?php esc_html_e( 'Hide if cart is empty', 'woocommerce' ); ?></label>
		</p>

		<?php
	}

}
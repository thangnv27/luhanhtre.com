<?php
/**
 * Content Single Tour
 *
 * @author : Physcode
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php

do_action( 'tour_booking_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form();

	return;
}
?>

	<div id="tour-<?php the_ID(); ?>" <?php post_class( 'tb_single_tour' ); ?>>
		<?php
		do_action( 'tour_booking_before_single_tour' );
		?>
		<div class="top_content_single row">
			<div class="images images_single_left">
				<?php
				echo '<div class="title-single">';
				do_action( 'tour_booking_single_title' );
				do_action( 'tour_booking_single_code' );
				echo '</div>';
				echo '<div class="tour_after_title">';
				$duration = get_post_meta( get_the_ID(), '_tour_duration', true );
				if ( $duration ) {
					echo '<div class="meta_date">
						 <span>' . $duration . '</span>
					</div>';
				}

				if ( travelwp_get_option( 'phys_hide_category_tour' ) != '1' ) {
					echo '<div class="meta_values">
								<span>' . esc_html__( 'Danh mục:', 'travelwp' ) . '</span>
								<div class="value">' . get_the_term_list( get_the_ID(), 'tour_phys', '', ', ', '' ) . '</div>
							</div>';
				}
				do_action( 'tour_booking_single_share' );
				echo '</div>';
				do_action( 'tour_booking_single_gallery' );
				?>
				<div class="clear"></div>
				<?php
				do_action( 'tour_booking_single_information' );
				if ( travelwp_get_option( 'phys_hide_related_tour' ) != '1' ) {
					do_action( 'tour_booking_single_related' );
				}
				?>
			</div>
			<div class="summary entry-summary description_single">
				<div class="affix-sidebar"<?php if ( travelwp_get_option( 'phys_tour_sticky_sidebar' ) == '1' ) {
					echo 'id="sticky-sidebar"';
				} ?>>
					<?php
					global $product;
					$date_finish_tour = get_post_meta( get_the_ID(), '_date_finish_tour', true ) ? get_post_meta( get_the_ID(), '_date_finish_tour', true ) : 0;
					$date_now         = date( 'Y-m-d' );
					$show_booking     = false;
					if ( $date_finish_tour != 0 ) {
						$date_finish_tour_arr  = explode( '-', $date_finish_tour );
						$date_finish_tour_str  = $date_finish_tour_arr[0] . '-' . $date_finish_tour_arr[1] . '-' . $date_finish_tour_arr[2];
						$date_finish_tour_time = strtotime( $date_finish_tour_str );
						if ( strtotime( $date_now ) <= $date_finish_tour_time ) {
							$show_booking = true;
						}
					}

					if ( $product->get_price_html() || $show_booking ) {
						echo '<div class="entry-content-tour">';
						do_action( 'tour_booking_single_price' );
						if ( $show_booking ) :
							echo '<div class="clear"></div>';
							if ( travelwp_get_option( 'from_booking' ) == 'show' || travelwp_get_option( 'from_booking' ) == '' ) {
								do_action( 'tour_booking_single_booking' );
							} elseif ( travelwp_get_option( 'from_booking' ) == 'both' ) {
								do_action( 'tour_booking_single_booking' );
								echo '<div class="form-block__title custom-form-title"><h4>' . esc_html__( 'Hoặc', 'travelwp' ) . '</h4></div>';
								echo '<div class="custom_from">' . do_shortcode( travelwp_get_option( 'another_from_shortcode' ) ) . '</div>';
							} elseif ( travelwp_get_option( 'from_booking' ) == 'another_from' ) {
								echo '<div class="another_from">' . do_shortcode( travelwp_get_option( 'another_from_shortcode' ) ) . '</div>';
							}
						endif;
						echo '</div>';
					}

					if ( is_active_sidebar( 'single_tour' ) ) {
						echo '<div class="widget-area align-left col-sm-3">';
						dynamic_sidebar( 'single_tour' );
						echo '</div>';
					}
					?>
				</div>
			</div>
		</div>
		<?php
		do_action( 'tour_booking_after_single_tour' );
		?>

	</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'tour_booking_after_single_product' ); ?>
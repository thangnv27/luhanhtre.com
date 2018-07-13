<?php
/**
 * Related Tours
 * @author: Physcode
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( empty( $product ) || !$product->exists() ) {
	return;
}

$posts_per_page = 3;
$option_related = array(
	'post_type'           => 'product',
	'post_status'         => 'publish',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => 'rand',
	'post__not_in'        => array( $product->get_id() ),
	'tax_query'           => array(
		array(
			'taxonomy' => 'product_type',
			'field'    => 'slug',
			'terms'    => array( 'tour_phys' ),
			'operator' => 'IN',
		)
	),
);

if ( get_option( 'tour_expire_on_list' ) && get_option( 'tour_expire_on_list' ) == 'no' ) {
	$option_related['meta_query'] = array(
		array(
			'key'     => '_date_finish_tour',
			'compare' => '>=',
			'value'   => date( 'Y-m-d' ),
			'type'    => 'DATE',
		)
	);
}
$args = apply_filters( 'tb_related_tour_args', $option_related );

$products  = new WP_Query( $args );
$classes   = array();
$classes[] = 'item-tour col-md-4 col-sm-6';

if ( $products->have_posts() ) : ?>

	<div class="related tours">

		<h2><?php esc_html_e( 'Tour Liên Quan', 'travelwp' ); ?></h2>
		<ul class="tours products wrapper-tours-slider">

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<li <?php post_class( $classes ) ?>>

					<?php tb_get_file_template( 'content-tour.php', false ); ?>

				</li>

			<?php endwhile; // end of the loop. ?>
		</ul>
	</div>

<?php endif;

wp_reset_postdata();
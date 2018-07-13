<?php

vc_map(
	array(
		"name"     => esc_html__( "Tours Reviews", 'travelwp' ),
		"icon"     => "icon-ui-splitter-horizontal",
		"base"     => "tours_review",
		"category" => esc_html__( "Travelwp", 'travelwp' ),
		"params"   => array(
			array(
				"type"        => "textfield",
				"heading"     => esc_html__( "Title", 'travelwp' ),
				"param_name"  => "title",
				'admin_label' => true,
			),
			array(
				"type"        => "textfield",
				"heading"     => esc_html__( "Item on row", 'travelwp' ),
				"param_name"  => "item_on_row",
				"value"       => "3",
				'admin_label' => true,
			),
			array(
				"type"        => "textfield",
				"heading"     => esc_html__( "Extra class name", "travelwp" ),
				"param_name"  => "el_class",
				"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "travelwp" ),
			),
			travelwp_vc_map_add_css_animation( true )
		)
	)
);

function travelwp_shortcode_tours_review( $atts, $content = null ) {
	$el_class = $css_animation = $item_on_row = $title = $data = '';
	extract(
		shortcode_atts(
			array(
				'title'         => '',
				'item_on_row'   => '3',
				'el_class'      => '',
				'css_animation' => '',
			), $atts
		)
	);
	ob_start();
	$physcode_animation = $el_class ? ' ' . $el_class : '';
	$physcode_animation .= travelwp_getCSSAnimation( $css_animation );
	echo '<div class="tours-reviews' . $physcode_animation . '">';
	$reviews = get_comments(
		array(
			'number'      => $item_on_row,
			'status'      => 'approve',
			'post_status' => 'publish',
			'post_type'   => array( 'product' ),
			'orderby'     => 'comment_date_gmt',
			'order'       => 'DESC',
			'meta_key'    => 'tour_rating',
			'meta_value'  => '1',
		)
	);
	$class   = 'pain';

	if ( count( $reviews ) > 1 ) {
		$class = 'slider';
		$data .= ' data-dots="true"';
		$data .= ' data-nav="false"';
		$data .= ' data-responsive=\'{"0":{"items":1}, "480":{"items":1}, "768":{"items":1}, "992":{"items":1}, "1200":{"items":1}}\'';
	};
	if ( $title ) {
		echo '<div class="shortcode_title shortcode-title-style_1">
						<h2 class="title_primary">' . $title . '</h2>
						<span class="line_after_title"></span>
					</div>';
	}
	
	echo '<div class="shortcode-tour-reviews wrapper-tours-' . $class . ' woocommerce"><div class="tours-type-' . $class . '"' . $data . '>';
	foreach ( $reviews as $review ) {
		echo '<div class="tour-reviews-item">
                	<div class="reviews-item-info">' . get_avatar( $review->user_id > 0 ? $review->user_id : $review->comment_author_email, 90 ) . '
                    <div class="reviews-item-info-name">' . esc_html( $review->comment_author ) . '</div>';
		travel_tours_renders_stars_rating( $review->comment_ID, 'rating', true );
		echo '</div>';
		echo '<div class="reviews-item-content">
					<h3 class="reviews-item-title">
						<a href="' . esc_url( get_permalink( $review->comment_post_ID ) ) . '">' . esc_html( $review->post_title ) . '</a>
					</h3>
					<div class="reviews-item-description">' . esc_html( $review->comment_content ) . '</div>
          		  	</div>
            </div> ';
	}
	echo '</div></div>';


	echo '</div>';
	$content = ob_get_clean();

	return $content;
}
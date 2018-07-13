<?php
$args  = array(
	'pad_counts'         => 1,
	'show_counts'        => 1,
	'hierarchical'       => 1,
	'hide_empty'         => 1,
	'show_uncategorized' => 1,
	'orderby'            => 'name',
	'menu_order'         => false
);
$terms = get_terms( 'tour_phys', $args );

$tour_cat                         = array();
$tour_cat['Select Tour Category'] = '';
if ( is_wp_error( $terms ) ) {
} else {
	if ( empty( $terms ) ) {
	} else {
		foreach ( $terms as $term ) {
			$tour_cat[$term->name] = $term->term_id;
		}
	}
}

vc_map(
	array(
		"name"        => esc_html__( "List Tours", 'travelwp' ),
		"icon"        => "icon-ui-splitter-horizontal",
		"base"        => "list_tours",
		"description" => "Show tour",
		"category"    => esc_html__( "Travelwp", 'travelwp' ),
		"params"      => array(
			array(
				"type"        => "dropdown",
				"heading"     => esc_html__( "Show", "travelwp" ),
				"param_name"  => "show",
				"admin_label" => true,
				"value"       => array(
					esc_html__( "All Tour", "travelwp" )      => "",
					esc_html__( "Tour Category", "travelwp" ) => "tour_cat",
				),
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Tour Type', 'travelwp' ),
				'param_name'  => 'tour_cat',
				'value'       => $tour_cat,
				"dependency"  => Array( "element" => "show", "value" => array( "tour_cat" ) ),
			),
			array(
				"type"        => "dropdown",
				"heading"     => esc_html__( "Order by", "travelwp" ),
				"param_name"  => "orderby",
				"admin_label" => true,
				"value"       => array(
					esc_html__( "Date", "travelwp" )    => "date",
					esc_html__( "Price", "travelwp" )   => "price",
					esc_html__( "Random", "travelwp" )  => "rand",
					esc_html__( "On-sale", "travelwp" ) => "sales"
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Order', 'travelwp' ),
				'param_name' => 'order',
				'std'        => 'desc',
				'value'      => array(
					esc_html__( 'DESC', 'travelwp' ) => 'desc',
					esc_html__( 'ASC', 'travelwp' )  => 'asc'
				)
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Content Style', 'travelwp' ),
				'param_name' => 'content_style',
				'std'        => 'style_1',
				'value'      => array(
					esc_html__( 'Style 1', 'travelwp' ) => 'style_1',
					esc_html__( 'Style 2', 'travelwp' ) => 'style_2'
				)
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Layout', 'travelwp' ),
				'param_name' => 'style',
				'std'        => 'pain',
				'value'      => array(
					esc_html__( 'Pain', 'travelwp' )   => 'pain',
					esc_html__( 'Slider', 'travelwp' ) => 'slider'
				)
			),

			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show navigation', 'travelwp' ),
				'param_name' => 'navigation',
				"dependency" => Array( "element" => "style", "value" => array( 'slider' ) ),
			),
			array(
				"type"        => "textfield",
				"heading"     => esc_html__( "Limit", 'travelwp' ),
				"param_name"  => "limit",
				"value"       => "6",
				'description' => esc_html__( 'Tour number will be shown.', 'travelwp' ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Tour on row', 'travelwp' ),
				'param_name' => 'tour_on_row',
				'value'      => '3',
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

function travelwp_shortcode_list_tours( $atts, $content = null ) {
	$tour_cat = $tour_location = $show = $style = $orderby = $order = $limit = $tour_on_row =
	$el_class = $css_animation = $navigation = $content_style = '';
	extract(
		shortcode_atts(
			array(
				'tour_cat'      => '',
				'tour_location' => '',
				'show'          => '',
				'content_style' => 'style_1',
				'style'         => 'pain',
				'limit'         => 6,
				'tour_on_row'   => 3,
				'orderby'       => 'date',
				'order'         => 'desc',
				'el_class'      => '',
				'navigation'    => '',
				'css_animation' => '',
			), $atts
		)
	);
	ob_start();
	$travelwp_animation = $el_class ? ' ' . $el_class : '';
	$travelwp_animation .= travelwp_getCSSAnimation( $css_animation );


 	$query_args = array(
		'posts_per_page' => $limit,
		'post_status'    => 'publish',
		'no_found_rows'  => 1,
		'order'          => $order == 'asc' ? 'asc' : 'desc',
		'post_type'      => array( 'product' ),
		'wc_query'       => 'tours'
	);

	$query_args['meta_query'] = array();

	if ( $show == 'tour_cat' && $tour_cat <> '' ) {
		$tour_cat_id             = explode( ',', $tour_cat );
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'tour_phys',
				'field'    => 'term_id',
				'terms'    => $tour_cat_id,
				'operator' => 'IN',
			)
		);
	} else {
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'product_type',
				'field'    => 'slug',
				'terms'    => array( 'tour_phys' ),
				'operator' => 'IN',
			)
		);
	}
	switch ( $orderby ) {
		case 'price' :
			$query_args['meta_key'] = '_price';
			$query_args['orderby']  = 'meta_value_num';
			break;
		case 'rand' :
			$query_args['orderby'] = 'rand';
			break;
		case 'sales' :
			$product_ids_on_sale    = wc_get_product_ids_on_sale();
			$product_ids_on_sale[]  = 0;
			$query_args['post__in'] = $product_ids_on_sale;
			$query_args['meta_key'] = '_price';
			$query_args['orderby']  = 'meta_value_num';
			break;
		default :
			$query_args['orderby'] = 'date';
	}

	// tour expire
	if ( get_option( 'tour_expire_on_list' ) && get_option( 'tour_expire_on_list' ) == 'no' ) {
		$query_args['meta_query'] = array(
			array(
				'key'     => '_date_finish_tour',
				'compare' => '>=',
				'value'   => date( 'Y-m-d' ),
				'type'    => 'DATE',
			)
		);
	}
	echo '<div class="row wrapper-tours-slider' . $travelwp_animation . '">';
	$the_query = new WP_Query( $query_args );

	if ( $the_query->have_posts() ) :
		$data = '';
		if ( $style == 'slider' ) {
			$data .= 'data-dots="true"';
			if ( $navigation  ) {
				$data .= ' data-nav="' . $navigation . '"';
			}else{
				$data .= ' data-nav="false"';
			}
 			$data .= ' data-responsive=\'{"0":{"items":1}, "480":{"items":2}, "768":{"items":2}, "992":{"items":3}, "1200":{"items":' . $tour_on_row . '}}\'';
		}

		echo '<div class="list_content content_tour_' . $content_style . ' tours-type-' . $style . '"' . $data . '>';
		$class_item = $style == 'pain' ? ' col-sm-' . intval( 12 / $tour_on_row ) : "";
		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			echo '<div class="item-tour' . $class_item . '">';
			if ( $content_style == 'style_1' ) {
				tb_get_file_template( 'content-tour.php', false );
			} elseif ( $content_style == 'style_2' ) {
				tb_get_file_template( 'content-tour-2.php', false );
			}
			echo '</div>';
		endwhile;
		echo '</div>';
		// Reset Post Data
		wp_reset_postdata();
	endif;
	echo '</div>';
	$content = ob_get_clean();

	return $content;
}

?>
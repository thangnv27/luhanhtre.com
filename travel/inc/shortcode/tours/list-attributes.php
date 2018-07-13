<?php
$taxonomies                        = get_object_taxonomies( 'product', 'objects' );
$attribute_arr                     = array();
$attribute_arr['Select Attribute'] = '';
if ( empty( $taxonomies ) ) {
	return '';
}

foreach ( $taxonomies as $tax ) {
	$tax_name = $tax->name;
	if ( 0 !== strpos( $tax_name, 'pa_' ) ) {
		continue;
	}
	if ( !in_array( $tax_name, $attribute_arr ) ) {
		$attribute_arr[$tax_name] = $tax_name;
	}
}

vc_map( array(
	"name"     => __( "Show tours of attribute", "travelwp" ),
	"base"     => "show_tours_of_attribute_woo",
	"class"    => "",
	"category" => __( "Travelwp", "travelwp" ),
	"params"   => array(
		array(
			'type'        => 'multi_dropdown',
			'heading'     => esc_html__( 'Select Attribute', 'travelwp' ),
			'param_name'  => 'attributes_woo',
			'value'       => $attribute_arr,
			"admin_label" => true,
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Limit', 'travelwp' ),
			'param_name' => 'limit',
			'value'      => '8',
		),

		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Style', 'travelwp' ),
			'param_name' => 'style',
			'std'        => 'style_1',
			'value'      => array(
				esc_html__( 'Style 1', 'travelwp' ) => 'style_1',
				esc_html__( 'Style 2', 'travelwp' ) => 'style_2'
			)
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Item on row', 'travelwp' ),
			'param_name' => 'item_on_row',
			'value'      => '5',
			"dependency" => Array( "element" => "style", "value" => array( 'style_1' ) ),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show navigation', 'travelwp' ),
			'param_name' => 'navigation',
			"dependency" => Array( "element" => "style", "value" => array( 'style_1' ) ),
		),
		array(
			"type"        => "textfield",
			"heading"     => esc_html__( "Extra class name", "travelwp" ),
			"param_name"  => "el_class",
			"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "travelwp" ),
		),
	)
) );

function travelwp_shortcode_show_tours_of_attribute_woo( $atts, $content = null ) {
	$el_class = $attributes_woo = $physcode_animation = $link = $css_animation = $item_tour_type =
	$item_on_row = $tour_type = $navigation = $style = $limit = '';
	extract(
		shortcode_atts(
			array(
				'attributes_woo' => '',
				'style'          => 'style_1',
				'navigation'     => '',
				'item_on_row'    => '5',
				'limit'          => '8',
				'el_class'       => '',
				'css_animation'  => '',
			), $atts
		)
	);
	if ( $el_class ) {
		$physcode_animation .= ' ' . $el_class;
	}

	$attr_arr = array();
	if ( $attributes_woo ) {
		$attr_arr = explode( ',', $attributes_woo );
	}
	$data        = $html = '';
	$class_style = 'pain';
	if ( $style == 'style_1' ) {
		$data = ' data-dots="true"';
		if ( $navigation ) {
			$data .= ' data-nav="' . $navigation . '"';
		} else {
			$data .= ' data-nav="false"';
		}
		$data .= ' data-responsive=\'{"0":{"items":1}, "480":{"items":2}, "768":{"items":' . ( $item_on_row - 2 ) . '}, "992":{"items":' . ( $item_on_row - 1 ) . '}, "1200":{"items":' . $item_on_row . '}}\'';
		$class_style = 'slider';
	}

	// check attributes remove
	$taxonomies = get_object_taxonomies( 'product', 'objects' );
	if ( empty( $taxonomies ) ) {
		return '';
	}
	$flag = false;
	foreach ( $taxonomies as $tax ) {
		$tax_name = $tax->name;
		if ( 0 !== strpos( $tax_name, 'pa_' ) ) {
			continue;
		}
		if ( in_array( $tax_name, $attr_arr ) ) {
			$flag = true;
		}
	}
	//end check attributes remove

	if ( count( $attr_arr ) > 0 && $flag == true ) {
		$html .= '<div class="row wrapper-tours-slider wrapper-tours-type-slider' . $physcode_animation . '">
					<div class="tours-type-' . $class_style . '"' . $data . '>';
		foreach ( $attr_arr as $attr ) {
			$terms_off_attr = get_terms( $attr, 'number=' . $limit );
			$i              = 1;
			foreach ( $terms_off_attr as $term ) {
				if ( $term ) {
					$class      = $count = $link_image_size = '';
					$link_image = get_tax_meta( $term->term_id, 'phys_tour_type_thumb', true ) ? get_tax_meta( $term->term_id, 'phys_tour_type_thumb', true ) : '';
					$text_color = get_tax_meta( $term->term_id, 'phys_text_color', true ) ? get_tax_meta( $term->term_id, 'phys_text_color', true ) : '';
					$css        = $text_color ? ' style="color:' . $text_color . '"' : '';
					if ( $link_image ) {
						$link_image_size = travelwp_custom_image_size( 370, 370, $link_image['url'] );
					}

					if ( $style == 'style_2' ) {
						$image_demo = '';
						if ( $i == 1 ) {
							$class = " width2x3";
							if ( $link_image ) {
								$link_image_size = travelwp_custom_image_size( 760, 370, $link_image['url'] );
							}
							$image_demo = '-1';
						}
						$count = '<div class="count-attr">' . $term->count . ' ' . esc_html__( 'Tours', 'travelwp' ) . '</div>';
						$img   = $link_image_size ? '<img src="' . $link_image_size . '" alt="' . $term->name . '">' : '<img src="' . get_template_directory_uri() . '/images/image-demo' . $image_demo . '.jpg' . '" alt="' . $term->name . '">';
					} else {
						$img = $link_image_size ? '<img src="' . $link_image_size . '" alt="' . $term->name . '">' : '<img src="' . get_template_directory_uri() . '/images/image-demo.jpg' . '" alt="' . $term->name . '">';
					}
					$html .= '<div class="tours_type_item' . $class . '">
						<a href="' . esc_url( get_term_link( $term->slug, $attr ) ) . '" title="' . $term->name . '" class="tours-type__item__image">
							' . $img . '
						</a>
						<div class="content-item"' . $css . '>
						<div class="item__title">' . $term->name . '</div>
						' . $count . '
						</div>
					</div> ';
				}
				$i ++;
			}
		}
		$html .= '</div></div>';
	}

	return $html;
}
?>
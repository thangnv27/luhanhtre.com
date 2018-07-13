<?php
vc_map(
	array(
		"name"     => esc_html__( "Gallery", 'travelwp' ),
		"icon"     => "icon-ui-splitter-horizontal",
		"base"     => "phys_gallery",
		"category" => esc_html__( "Travelwp", 'travelwp' ),
		"params"   => array(
			array(
				'type'        => 'attach_images',
				'heading'     => esc_html__( 'Input ID image', 'travelwp' ),
				'param_name'  => 'id_image',
				'admin_label' => true,
			),
			array(
				"type"        => "checkbox",
				"heading"     => esc_html__( "Show Filter", 'travelwp' ),
				"param_name"  => "filter",
				'admin_label' => true,
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Column', 'travelwp' ),
				'param_name'  => 'column',
				'value'       => array(
					esc_html__( 'Two', 'travelwp' )   => '2',
					esc_html__( 'Three', 'travelwp' ) => '4',
					esc_html__( 'Four', 'travelwp' )  => '3',
				),
				'std'         => '4'
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
/**
 * Filter used to customize galleries output.
 *
 * @param  string $empty
 * @param  assoc  $atts gallery shortcode attributes
 *
 * @return string
 */
function travelwp_shortcode_phys_gallery( $atts, $content = null ) {
	$filter = $id_image = $el_class = $html = $column = $physcode_animation = $css_animation = '';
	extract(
		shortcode_atts(
			array(
				'id_image'      => '',
				'filter'        => '',
				'column'        => '4',
				'el_class'      => '',
				'css_animation' => '',
			), $atts
		)
	);
	if ( $el_class ) {
		$physcode_animation .= ' ' . $el_class;
	}
	$physcode_animation .= travelwp_getCSSAnimation( $css_animation );
	$ids = explode( ',', $id_image );
	// get attachments set
	$queryArgs   = array(
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'posts_per_page' => - 1,
		'post_mime_type' => 'image',
		'order'          => 'DESC',
		'orderby'        => 'menu_order ID',
		'post__in'       => $ids,
	);
	$attachments = get_posts( $queryArgs );

	$gallery_images = array();
	$category_media = array();
	if ( $attachments ) {
		foreach ( $attachments as $attachment ) {
			$id_att            = $attachment->ID;
			$image_att_full    = wp_get_attachment_image_src( $id_att, 'full' );
			$image_custom_size = wp_get_attachment_image_src( $id_att, 'medium' );
			$link_full         = !empty( $image_att_full[0] ) ? $image_att_full[0] : '';
			$image_medium_size = !empty( $image_custom_size[0] ) ? $image_custom_size[0] : '';
			// categories
			$image_categories = array();
			$taxonomies       = get_the_terms( $id_att, 'media_category' );
			if ( $taxonomies ) {
				foreach ( $taxonomies as $taxonomy ) {
					$category_media[$taxonomy->slug]   = $taxonomy->name;
					$image_categories[$taxonomy->slug] = $taxonomy->name;
				}
			}

			$alt = get_post_meta( $id_att, '_wp_attachment_image_alt', true );

			$gallery_images[] = array(
				'link_full'         => $link_full,
				'image_medium_size' => $image_medium_size,
				'title'             => $attachment->post_title,
				'categories'        => $image_categories,
				'alt'               => $alt ? $alt : $attachment->post_title,
			);
		}
		wp_reset_postdata();
	}

	if ( !$gallery_images ) {
		return '';
	}
	wp_enqueue_style( 'travelwp-swipebox' );
	wp_enqueue_script( 'travelwp-swipebox' );
	wp_enqueue_script( 'travelwp-isotope' );
	$html .= '<div class="sc-gallery wrapper_gallery' . $physcode_animation . '">';
	// begin filter
	if ( $filter == true ) {
		$html .= '<div class="gallery-tabs-wrapper filters"><ul class="gallery-tabs">';
		$html .= '<li><a href="#" data-filter="*" class="filter active">' . esc_html__( 'all', 'travelwp' ) . '</a></li>';
		foreach ( $category_media as $cat_slug => $cat_name ) {
			$html .= '<li><a href="#" data-filter=".' . esc_attr( $cat_slug ) . '" class="filter">' . esc_html( $cat_name ) . '</a></li>';
		}
		$html .= '</ul></div>';
	}
	//end filter
	// begin content
	$html .= '<div class="row content_gallery">';
	foreach ( $gallery_images as $image ) {
		$data_filters = '';
		if ( !empty( $image['categories'] ) ) {
			foreach ( $image['categories'] as $slug => $name ) {
				$data_filters .= ' ' . $slug;
			}
		}
		$html .= '<div class="col-sm-' . $column . ' gallery_item-wrap' . esc_attr( $data_filters ) . '">';
		$html .= '<a href="' . esc_url( $image['link_full'] ) . '" class="swipebox" title="' . esc_attr( $image['title'] ) . '">
					<img src="' . esc_url( $image['image_medium_size'] ) . '" alt="' . esc_attr( $image['alt'] ) . '">
					<span class="gallery-item"><h4 class="title">' . esc_html( $image['title'] ) . '</h4></span>
				</a>';
		$html .= '</div>';
	}
	wp_reset_postdata();
	$html .= '</div>';
	// end content
	$html .= '</div>';

	return $html;
}
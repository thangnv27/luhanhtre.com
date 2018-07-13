<?php
if ( class_exists( 'WooCommerce' ) ) {
	WC_Post_types::register_taxonomies();
}

if ( class_exists( 'TravelBookingPhyscode' ) ) {
	TravelBookingPhyscode::register_taxonomies();

}


if ( !function_exists( 'travelwp_vc_map_add_css_animation' ) ) {
	function travelwp_vc_map_add_css_animation( $label = true ) {
		$data = array(
			'type'        => 'animation_style',
			'heading'     => __( 'CSS Animation', 'travelwp' ),
			'param_name'  => 'css_animation',
			'admin_label' => $label,
			'value'       => '',
			'settings'    => array(
				'type'   => 'in',
				'custom' => array(
					array(
						'label'  => __( 'Default', 'travelwp' ),
						'values' => array(
							__( 'Top to bottom', 'travelwp' )      => 'top-to-bottom',
							__( 'Bottom to top', 'travelwp' )      => 'bottom-to-top',
							__( 'Left to right', 'travelwp' )      => 'left-to-right',
							__( 'Right to left', 'travelwp' )      => 'right-to-left',
							__( 'Appear from center', 'travelwp' ) => 'appear',
						),
					),
				),
			),
			'description' => __( 'Select type of animation for element to be animated when it "enters" the browsers viewport (Note: works only in modern browsers).', 'travelwp' ),
		);


		return apply_filters( 'travelwp_vc_map_add_css_animation', $data, $label );
	}
}

if ( !function_exists( 'travelwp_getCSSAnimation' ) ) {
	function travelwp_getCSSAnimation( $css_animation ) {
		$output = '';
		if ( $css_animation != '' ) {
			wp_enqueue_script( 'waypoints' );
			$output = ' wpb_animate_when_almost_visible wpb_' . $css_animation;
		}

		return $output;
	}
}

//////////////////////////////////////////////////////////////////
// Remove extra P tags
//////////////////////////////////////////////////////////////////
function travelwp_shortcodes_formatter( $content ) {
	$block = join( "|", array( "banner_html" ) );
	// opening tag
	$rep = preg_replace( "/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content );
	// closing tag
	$rep = preg_replace( "/(<p>)?\[\/($block)](<\/p>|<br \/>)/", "[/$2]", $rep );

	return $rep;
}

add_filter( 'the_content', 'travelwp_shortcodes_formatter' );
add_filter( 'widget_text', 'travelwp_shortcodes_formatter' );

// Link to shortcodes
require_once get_template_directory() . '/inc/shortcode/heading/heading.php';
require_once get_template_directory() . '/inc/shortcode/icon_box/icon_box.php';
require_once get_template_directory() . '/inc/shortcode/social-links/social-links.php';
require_once get_template_directory() . '/inc/shortcode/list-posts/list-posts.php';
require_once get_template_directory() . '/inc/shortcode/deals-discounts/deals-discounts.php';
require_once get_template_directory() . '/inc/shortcode/counter/counter.php';
require_once get_template_directory() . '/inc/shortcode/list-info/list-info.php';
require_once get_template_directory() . '/inc/shortcode/gallery/gallery.php';
require_once get_template_directory() . '/inc/shortcode/banner-typed.php';

if ( class_exists( 'TravelBookingPhyscode' ) && class_exists( 'WooCommerce' ) ) {
	require_once get_template_directory() . '/inc/shortcode/tours/list-tours.php';
	require_once get_template_directory() . '/inc/shortcode/tours/tours_review.php';
	require_once get_template_directory() . '/inc/shortcode/tours/booking_tour.php';
	require_once get_template_directory() . '/inc/shortcode/tours/list-attributes.php';
}

// register short code
if ( function_exists( 'Register_Physcode_Vc_Addon' ) ) {
	Register_Physcode_Vc_Addon(
		'travelwp',
		array(
			'heading',
			'icon_box',
			'social_link',
			'list_posts',
			'deals_discounts',
			'counter',
			'list_info',
			'list_tours',
			'tours_review',
			'booking_tour',
 			'phys_gallery',
			'show_tours_of_attribute_woo',
			'banner_typed'
		)
	);
}

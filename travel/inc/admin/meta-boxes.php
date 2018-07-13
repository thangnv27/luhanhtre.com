<?php

add_filter( 'rwmb_meta_boxes', 'phys_register_meta_boxes' );
function phys_register_meta_boxes( $meta_boxes ) {

	// Display Settings
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Display Settings', 'travelwp' ),
		'pages'  => get_post_types(), // All custom post types
		'fields' => array(
			array(
				'name' => esc_html__( 'Featured Title Area?', 'travelwp' ),
				'id'   => 'heading_title',
				'type' => 'heading',
			),
			array(
				'name'  => esc_html__( 'User Featured Title?', 'travelwp' ),
				'id'    => 'phys_user_featured_title',
				'type'  => 'checkbox',
				'class' => 'checkbox-toggle',

			),
			array(
				'name'   => esc_html__( 'Custom Title', 'travelwp' ),
				'id'     => 'custom_title_subtitle',
				'type'   => 'heading',
				'before' => '<div style="margin-left: 25px; padding-left: 25px; border-width: 0 0 0 3px; border-style: solid; border-color: #ddd">',
			),
			array(
				'name'  => esc_html__( 'Hide Title', 'travelwp' ),
				'id'    => 'phys_hide_title',
				'type'  => 'checkbox',
				'class' => 'checkbox-toggle reverse',
			),
			array(
				'name'   => esc_html__( 'Custom Title', 'travelwp' ),
				'id'     => 'phys_custom_title',
				'type'   => 'text',
				'desc'   => esc_html__( 'Leave empty to use post title', 'travelwp' ),
				'before' => '<div>',
				'after'  => '</div>',
			),
			array(
				'name' => esc_html__( 'Custom Heading Background', 'travelwp' ),
				'id'   => 'custom_headding_bg',
				'type' => 'heading',
			),
			array(
				'name' => esc_html__( 'Update images', 'travelwp' ),
				'id'   => 'phys_top_image',
				//'type' => 'file_input',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'desc' => esc_html__( 'This will overwrite page layout settings in Theme Options', 'travelwp' ),
			),
			array(
				'name' => esc_html__( 'Background Color Featured', 'travelwp' ),
				'id'   => 'phys_bg_color',
				'type' => 'color',
			),
			array(
				'name' => esc_html__( 'Text Color Featured', 'travelwp' ),
				'id'   => 'phys_text_color',
				'type' => 'color',

			),
			array(
				'name'  => esc_html__( 'Hide Breadcrumbs?', 'travelwp' ),
				'id'    => 'phys_hide_breadcrumbs',
				'type'  => 'checkbox',
				'after' => '</div>',
			),
			array(
				'name' => esc_html__( 'Custom Layout', 'travelwp' ),
				'id'   => 'heading_layout',
				'type' => 'heading',
			),
			array(
				'name'  => esc_html__( 'Use Custom Layout?', 'travelwp' ),
				'id'    => 'phys_custom_layout',
				'type'  => 'checkbox',
				'class' => 'checkbox-toggle',
				'desc'  => esc_html__( 'This will overwrite page layout settings in Theme Options', 'travelwp' ),
			),
			array(
				'name'    => esc_html__( 'Select Layout', 'travelwp' ),
				'id'      => 'layout',
				'type'    => 'image_select',
				'std'     => 'sidebar-left',
 				'options' => array(
					'full-content'  => TRAVELWP_THEME_URI . '/images/layout/body-full.png',
					'sidebar-left'  => TRAVELWP_THEME_URI . '/images/layout/sidebar-left.png',
					'sidebar-right' => TRAVELWP_THEME_URI . '/images/layout/sidebar-right.png',
				),
 			),
		)
	);

	return $meta_boxes;
}

add_action( 'admin_enqueue_scripts', 'phys_admin_script_meta_box' );

/**
 * Enqueue script for handling actions with meta boxes
 *
 * @return void
 * @since 1.0
 */
function phys_admin_script_meta_box() {
	wp_enqueue_script( 'travelwp-meta-box', TRAVELWP_THEME_URI . '/assets/js/admin/meta-boxes.js', array( 'jquery' ), '3022016', true );
}

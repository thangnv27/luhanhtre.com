<?php
Redux::setSection( $opt_name, array(
	'title'  => esc_html__( 'Woo Settings', 'travelwp' ),
	'id'     => 'woo_setting',
	'icon'   => 'el el-shopping-cart',
	'fields' => array(
		array(
			'id'      => 'column_product',
			'type'    => 'select',
			'title'   => esc_html__( 'Column', 'travelwp' ),
			'options' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4'
			),
			'default' => '3',
			'select2' => array( 'allowClear' => false )
		),
	)
) );
Redux::setSection( $opt_name, array(
	'title'      => esc_html__( 'Archive Product', 'travelwp' ),
	'id'         => 'archive_woo_setting',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'      => 'woo_cate_layout',
			'type'    => 'image_select',
			'title'   => esc_html__( 'Select Layout Default', 'travelwp' ),
			'options' => array(
				'full-content'  => array(
					'alt' => 'body-full',
					'img' => get_template_directory_uri() . '/images/layout/body-full.png'
				),
				'sidebar-left'  => array(
					'alt' => 'sidebar-left',
					'img' => get_template_directory_uri() . '/images/layout/sidebar-left.png'
				),
				'sidebar-right' => array(
					'alt' => 'sidebar-right',
					'img' => get_template_directory_uri() . '/images/layout/sidebar-right.png'
				),
			),
			'default' => 'sidebar-left'
		),
		array(
			'title'    => esc_html__( 'Hide Title', 'travelwp' ),
			'id'       => 'phys_woo_cate_hide_title',
			'type'     => 'checkbox',
			'subtitle' => esc_html__( 'Check this box to hide/unhide title' . 'travelwp' ),
			'default'  => false,
		),
		array(
			'title'    => esc_html__( 'Hide Breadcrumbs?', 'travelwp' ),
			'id'       => 'phys_woo_cate_hide_breadcrumbs',
			'default'  => 0,
			'type'     => 'checkbox',
			'subtitle' => esc_html__( 'Check this box to hide/unhide breadcrumbs', 'travelwp' ),
		),
		array(
			'title' => esc_html__( 'Background Heading', 'travelwp' ),
			'id'    => 'phys_woo_cate_top_image',
			'type'  => 'media',
			'desc'  => esc_html__( 'Enter URL or Upload an background heading file for header', 'travelwp' ),
		),
		array(
			'title'   => esc_html__( 'Background Heading Color', 'travelwp' ),
			'id'      => 'phys_woo_cate_heading_bg_color',
			'type'    => 'color_rgba',
			'default' => array(
				'color' => '#000',
				'alpha' => '1'
			),
		),
		array(
			'title'       => esc_html__( 'Text Color Heading', 'travelwp' ),
			'id'          => 'phys_woo_cate_heading_text_color',
			'type'        => 'color',
			'transparent' => false,
			'default'     => '#fff',
		),
	)
) );

Redux::setSection( $opt_name, array(
	'title'      => esc_html__( 'Single Product', 'travelwp' ),
	'id'         => 'single_woo_setting',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'      => 'woo_single_layout',
			'type'    => 'image_select',
			'title'   => esc_html__( 'Select Layout Default', 'travelwp' ),
			'options' => array(
				'full-content'  => array(
					'alt' => 'body-full',
					'img' => get_template_directory_uri() . '/images/layout/body-full.png'
				),
				'sidebar-left'  => array(
					'alt' => 'sidebar-left',
					'img' => get_template_directory_uri() . '/images/layout/sidebar-left.png'
				),
				'sidebar-right' => array(
					'alt' => 'sidebar-right',
					'img' => get_template_directory_uri() . '/images/layout/sidebar-right.png'
				),
			),
			'default' => 'sidebar-left'
		),
 		array(
			'title'    => esc_html__( 'Hide Related Product', 'travelwp' ),
			'id'       => 'phys_woo_single_related_product',
			'type'     => 'checkbox',
			'subtitle' => esc_html__( 'Check this box to hide/show related Product', 'travelwp' ),
			'default'  => false,
		),
		array(
			'title'    => esc_html__( 'Hide Title', 'travelwp' ),
			'id'       => 'phys_woo_single_hide_title',
			'type'     => 'checkbox',
			'subtitle' => esc_html__( 'Check this box to hide/unhide title', 'travelwp' ),
			'default'  => 0,
		),
		array(
			'title'    => esc_html__( 'Hide Breadcrumbs?', 'travelwp' ),
			'id'       => 'phys_woo_single_hide_breadcrumbs',
			'default'  => 0,
			'type'     => 'checkbox',
			'subtitle' => esc_html__( 'Check this box to hide/unhide breadcrumbs', 'travelwp' ),
		),
		array(
			'title' => esc_html__( 'Background Heading', 'travelwp' ),
			'id'    => 'phys_woo_single_top_image',
			'type'  => 'media',
			'desc'  => esc_html__( 'Enter URL or Upload an background heading file for header', 'travelwp' ),
		),
		array(
			'title'   => esc_html__( 'Background Heading Color', 'travelwp' ),
			'id'      => 'phys_woo_single_heading_bg_color',
			'type'    => 'color_rgba',
			'default' => array(
				'color' => '#000',
				'alpha' => '1'
			),
		),
		array(
			'title'       => esc_html__( 'Text Color Heading', 'travelwp' ),
			'id'          => 'phys_woo_single_heading_text_color',
			'type'        => 'color',
			'transparent' => false,
			'default'     => '#fff',
		),
	)
) );
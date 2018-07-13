<?php
Redux::setSection( $opt_name, array(
	'title' => esc_html__( 'Display Settings', 'travelwp' ),
	'icon'  => 'el el-eye-open',
	'id'    => 'display_settings',
) );
Redux::setSection( $opt_name, array(
	'title'      => esc_html__( 'Front Page Settings', 'travelwp' ),
	'id'         => 'front_page_display_settings',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'      => 'archive_frontpage_layout',
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
			'id'    => 'phys_front_page_top_image',
			'type'  => 'media',
			'title' => esc_html__( 'Background Heading', 'travelwp' ),
			'desc'  => esc_html__( 'Enter URL or Upload an background image file for header', 'travelwp' ),
		),
		array(
			'title'   => esc_html__( 'Background Heading Color', 'travelwp' ),
			'id'      => 'phys_front_page_heading_bg_color',
			'type'    => 'color_rgba',
			'default' => array(
				'color' => '#000',
				'alpha' => '1'
			),
		),
		array(
			'id'       => 'phys_front_page_hide_breadcrumbs',
			'type'     => 'checkbox',
			'title'    => esc_html__( 'Hide Breadcrumbs?', 'travelwp' ),
			'subtitle' => esc_html__( 'Check this box to hide/unhide breadcrumbs', 'travelwp' ),
			'default'  => '0'// 1 = on | 0 = off
		),

		array(
			'title'       => esc_html__( 'Text Color Heading', 'travelwp' ),
			'id'          => 'phys_front_page_heading_text_color',
			'type'        => 'color',
			'transparent' => false,
			'default'     => '#fff',
		),
	)
) );
Redux::setSection( $opt_name, array(
	'title'      => esc_html__( 'Archive Settings', 'travelwp' ),
	'id'         => 'archive_display_settings',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'      => 'archive_cate_layout',
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
			'id'      => 'excerpt_length_blog',
			'type'    => 'spinner',
			'title'   => esc_html__( 'Excerpt Length', 'travelwp' ),
			'desc'    => esc_html__( 'Enter the number of words you want to cut from the content to be the excerpt of search and archive', 'travelwp' ),
			'default' => '30',
			'min'     => '20',
			'step'    => '1',
			'max'     => '100',
		),
		array(
			'id'       => 'phys_archive_cate_hide_title',
			'type'     => 'checkbox',
			'title'    => esc_html__( 'Hide Title', 'travelwp' ),
			'subtitle' => esc_html__( 'Check this box to hide/unhide title', 'travelwp' ),
			'default'  => '0'// 1 = on | 0 = off
		),

		array(
			'id'       => 'phys_archive_cate_hide_breadcrumbs',
			'type'     => 'checkbox',
			'title'    => esc_html__( 'Hide Breadcrumbs?', 'travelwp' ),
			'subtitle' => esc_html__( 'Check this box to hide/unhide breadcrumbs', 'travelwp' ),
			'default'  => '0'// 1 = on | 0 = off
		),

		array(
			'id'    => 'phys_archive_cate_top_image',
			'type'  => 'media',
			'title' => esc_html__( 'Background Heading', 'travelwp' ),
			'desc'  => esc_html__( 'Enter URL or Upload an background image file for header', 'travelwp' ),
		),

		array(
			'title'   => esc_html__( 'Background Heading Color', 'travelwp' ),
			'id'      => 'phys_archive_cate_heading_bg_color',
			'type'    => 'color_rgba',
			'default' => array(
				'color' => '#000',
				'alpha' => '1'
			),
		),

		array(
			'title'       => esc_html__( 'Text Color Heading', 'travelwp' ),
			'id'          => 'phys_archive_cate_heading_text_color',
			'type'        => 'color',
			'transparent' => false,
			'default'     => '#fff',
		),
	)
) );
Redux::setSection( $opt_name, array(
	'title'      => esc_html__( 'Post & Page Settings', 'travelwp' ),
	'id'         => 'single_display_settings',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'      => 'archive_single_layout',
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
			'id'       => 'phys_archive_single_hide_title',
			'type'     => 'checkbox',
			'subtitle' => esc_html__( 'Check this box to hide/unhide title', 'travelwp' ),
			'default'  => 0,
		),

		array(
			'title'    => esc_html__( 'Hide Breadcrumbs?', 'travelwp' ),
			'id'       => 'phys_archive_single_hide_breadcrumbs',
			'default'  => 0,
			'type'     => 'checkbox',
			'subtitle' => esc_html__( 'Check this box to hide/unhide breadcrumbs', 'travelwp' ),
		),

		array(
			'title' => esc_html__( 'Background Heading', 'travelwp' ),
			'id'    => 'phys_archive_single_top_image',
			'type'  => 'media',
			'desc'  => esc_html__( 'Enter URL or Upload an background heading file for header', 'travelwp' ),
		),

		array(
			'title'   => esc_html__( 'Background Heading Color', 'travelwp' ),
			'id'      => 'phys_archive_single_heading_bg_color',
			'type'    => 'color_rgba',
			'default' => array(
				'color' => '#000',
				'alpha' => '1'
			),
		),

		array(
			'title'       => esc_html__( 'Text Color Heading', 'travelwp' ),
			'id'          => 'phys_archive_single_heading_text_color',
			'type'        => 'color',
			'transparent' => false,
			'default'     => '#fff',
		),
	)
) );
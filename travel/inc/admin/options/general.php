<?php
$logo = get_template_directory_uri( 'template_directory' ) . '/images/';
// -> START Media Uploads

Redux::setSection( $opt_name, array(
	'title'  => esc_html__( 'General Settings', 'travelwp' ),
	'id'     => 'general_settings',
	'icon'   => 'el el-cogs',
	'fields' => array(

		array(
			'id'      => 'travelwp_logo',
			'type'    => 'media',
			'title'   => esc_html__( 'Header Logo', 'travelwp' ),
			'desc'    => esc_html__( 'Enter URL or Upload an image file as your logo.', 'travelwp' ),
			'default' => array( 'url' => $logo . 'logo.png' ),
		),
		array(
			'id'      => 'travelwp_sticky_logo',
			'type'    => 'media',
			'title'   => esc_html__( 'Sticky Header Logo', 'travelwp' ),
			'desc'    => esc_html__( 'Enter URL or Upload an image file as your sticky logo.', 'travelwp' ),
			'default' => array( 'url' => $logo . 'logo_sticky.png' ),
		),
		array(
			'id'      => 'transparent_menu_home',
			'type'    => 'switch',
			'title'   => esc_html__( 'Transparent menu home page', 'travelwp' ),
			'default' => 0,
			'on'      => 'Yes',
			'off'     => 'No'
		),
		array(
			'id'       => 'logo_home_page',
			'type'     => 'media',
			'title'    => esc_html__( 'Logo Menu transparent', 'travelwp' ),
			'required' => array( 'transparent_menu_home', '=', '1' )
		),
		array(
			'id'          => 'text_home_page',
			'type'        => 'color',
			'title'       => esc_html__( 'Text Color Menu transparent', 'travelwp' ),
			'default'     => '#fff',
			'transparent' => false,
			'required'    => array( 'transparent_menu_home', '=', '1' )
		),
		array(
			'id'      => 'width_logo',
			'type'    => 'spinner',
			'title'   => esc_html__( 'Width logo', 'travelwp' ),
			'default' => '100',
			'min'     => '1',
			'step'    => '1',
			'max'     => '500',
		),
		array(
			'id'      => 'width_logo_mobile',
			'type'    => 'spinner',
			'title'   => esc_html__( 'Width logo mobile', 'travelwp' ),
			'default' => '100',
			'min'     => '1',
			'step'    => '1',
			'max'     => '500',
		),
	)
) );




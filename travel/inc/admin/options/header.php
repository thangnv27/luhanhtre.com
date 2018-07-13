<?php
// top header
Redux::setSection( $opt_name, array(
	'title'  => esc_html__( 'Header', 'travelwp' ),
	'id'     => 'header',
	'icon'   => 'el el-tasks',
	'fields' => array(
		array(
			'id'      => 'top_bar',
			'type'    => 'switch',
			'title'   => esc_html__( 'Top Bar', 'travelwp' ),
			'default' => 0,
			'on'      => 'Show',
			'off'     => 'Hide'
		),
		array(
			'id'       => 'bg_top_bar',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Background Color', 'travelwp' ),
			'required' => array( 'top_bar', '=', '1' ),
			'default'  => '#333'
		),
		array(
			'id'          => 'text_color_top_bar',
			'type'        => 'color',
			'title'       => esc_html__( 'Text Color', 'travelwp' ),
			'required'    => array( 'top_bar', '=', '1' ),
			'transparent' => false,
			'default'     => '#aaa'
		),

		array(
			'id'          => 'link_color_top_bar',
			'type'        => 'color',
			'title'       => esc_html__( 'Link Color', 'travelwp' ),
			'required'    => array( 'top_bar', '=', '1' ),
			'transparent' => false,
			'default'     => '#fff'
		),

		array(
			'id'   => 'main_menu_info_styling',
			'type' => 'info',
			'raw'  => esc_html__( 'Main Menu', 'travelwp' )
		),

		array(
			'id'    => 'bg_header_color',
			'type'  => 'color_rgba',
			'title' => esc_html__( 'Background header', 'travelwp' ),
		),
		array(
			'id'          => 'text_menu_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Text Menu Color', 'travelwp' ),
			'transparent' => false,
		),
		array(
			'id'      => 'font_size_main_menu',
			'type'    => 'spinner',
			'title'   => esc_html__( 'Font Size (px)', 'travelwp' ),
			'default' => '13',
			'min'     => '1',
			'step'    => '1',
			'max'     => '50',
		),
		array(
			'id'      => 'font_weight_main_menu',
			'type'    => 'select',
			'title'   => esc_html__( 'Font Weight', 'travelwp' ),
			'options' => array(
				'normal'  => 'Normal',
				'bold'    => 'Bold',
				'lighter' => 'Lighter',
				'100'     => '100',
				'200'     => '200',
				'300'     => '300',
				'400'     => '400',
				'500'     => '500',
				'600'     => '600',
				'700'     => '700',
				'800'     => '800',
				'900'     => '900',
			),
			'default' => 'normal',
			'select2' => array( 'allowClear' => false )
		),

		array(
			'id'      => 'sticky_menu',
			'type'    => 'switch',
			'title'   => esc_html__( 'Sticky Menu', 'travelwp' ),
			'default' => 0,
			'on'      => 'Show',
			'off'     => 'Hide'
		),
		array(
			'id'       => 'sticky_custom_menu',
			'type'     => 'switch',
			'title'    => esc_html__( 'Sticky Menu Option', 'travelwp' ),
			'default'  => 0,
			'on'       => 'Custom',
			'off'      => 'Default',
			'required' => array( 'sticky_menu', '=', '1' )
		),
		array(
			'id'       => 'bg_sticky_menu',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Sticky Menu Background Color', 'travelwp' ),
			'required' => array( 'sticky_custom_menu', '=', '1' )
		),
		array(
			'id'          => 'text_color_sticky_menu',
			'type'        => 'color',
			'title'       => esc_html__( 'Sticky Menu Text Color', 'travelwp' ),
			'required'    => array( 'sticky_custom_menu', '=', '1' ),
			'transparent' => false,
		),

		array(
			'id'   => 'sub_menu',
			'type' => 'info',
			'raw'  => esc_html__( 'Sub Menu', 'travelwp' )
		),
		array(
			'id'          => 'sub_menu_bg_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Background Color', 'travelwp' ),
			'transparent' => false,
		),
		array(
			'id'          => 'sub_menu_text_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Text Color', 'travelwp' ),
			'transparent' => false,
		),
		array(
			'id'          => 'sub_menu_text_hover_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Text Hover Color', 'travelwp' ),
			'transparent' => false,
		),
		array(
			'id'   => 'mobile_menu',
			'type' => 'info',
			'raw'  => esc_html__( 'Mobile Menu', 'travelwp' )
		),
		array(
			'id'          => 'mobile_menu_bg_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Background Color', 'travelwp' ),
			'transparent' => false,
		),
		array(
			'id'          => 'mobile_menu_text_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Text Color', 'travelwp' ),
			'transparent' => false,
		),
		array(
			'id'          => 'mobile_menu_text_hover_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Text Hover Color', 'travelwp' ),
			'transparent' => false,
		),
	)
) );
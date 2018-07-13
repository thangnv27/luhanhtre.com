<?php
// footer
Redux::setSection( $opt_name, array(
	'title'  => esc_html__( 'Footer', 'travelwp' ),
	'id'     => 'footer',
	'icon'   => 'el el-graph',
	'fields' => array(
		array(
			'id'          => 'bg_footer',
			'type'        => 'color',
			'title'       => esc_html__( 'Background Color', 'travelwp' ),
			'default'     => '#414b4f',
			'transparent' => false,
		),
		array(
			'id'          => 'text_color_footer',
			'type'        => 'color',
			'title'       => esc_html__( 'Text Color', 'travelwp' ),
			'default'     => '#ccc',
			'transparent' => false,
		),

		array(
			'id'      => 'text_font_size_footer',
			'type'    => 'spinner',
			'title'   => esc_html__( 'Font Size (px)', 'travelwp' ),
			'default' => '13',
			'min'     => '1',
			'step'    => '1',
			'max'     => '50',
		),

		array(
			'id'          => 'border_color_footer',
			'type'        => 'color',
			'title'       => esc_html__( 'Border Color', 'travelwp' ),
			'default'     => '#5b6366',
			'transparent' => false,
		),

		array(
			'id'          => 'title_color_footer',
			'type'        => 'color',
			'title'       => esc_html__( 'Title Color', 'travelwp' ),
			'default'     => '#fff',
			'transparent' => false,
		),
		array(
			'id'      => 'title_font_size_footer',
			'type'    => 'spinner',
			'title'   => esc_html__( 'Font Size Title (px)', 'travelwp' ),
			'default' => '18',
			'min'     => '1',
			'step'    => '1',
			'max'     => '50',
		),
		array(
			'id'      => 'copyright_text',
			'type'    => 'editor',
			'title'   => esc_html__( 'Copyright Text', 'travelwp' ),
			'args'    => array(
				'wpautop' => false,
				'teeny'   => true
			),
			'default' => 'Copyright &copy; 2017 Travel WP. All Rights Reserved.'
		),
	)
) );
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
get_template_part( 'inc/admin/sassphp/scss.inc' );

if ( is_multisite() ) {
	if ( !file_exists( trailingslashit( WP_CONTENT_DIR ) . 'uploads/sites/' . travelwp_current_blog()->blog_id . '/physcode' ) ) {
		wp_mkdir_p( trailingslashit( WP_CONTENT_DIR ) . 'uploads/sites/' . travelwp_current_blog()->blog_id . '/physcode', 0777, true );
	};
	define( 'TRAVELWP_UPLOADS_FOLDER', trailingslashit( WP_CONTENT_DIR ) . 'uploads/sites/' . travelwp_current_blog()->blog_id . '/physcode/' );
	define( 'TRAVELWP_UPLOADS_URL', trailingslashit( WP_CONTENT_URL ) . 'uploads/sites/' . travelwp_current_blog()->blog_id . '/physcode/' );
} else {
	if ( !file_exists( trailingslashit( WP_CONTENT_DIR ) . 'uploads/physcode' ) ) {
		wp_mkdir_p( trailingslashit( WP_CONTENT_DIR ) . 'uploads/physcode', 0777, true );
	}
	if(!defined('TRAVELWP_UPLOADS_FOLDER')) {
		define( 'TRAVELWP_UPLOADS_FOLDER', trailingslashit( WP_CONTENT_DIR ) . 'uploads/physcode/' );
	}

	if(!defined('TRAVELWP_UPLOADS_URL')) {
		define( 'TRAVELWP_UPLOADS_URL', trailingslashit( WP_CONTENT_URL ) . 'uploads/physcode/' );
	}
}

if (!defined('TRAVELWP_FILE_NAME')) {
	define( 'TRAVELWP_FILE_NAME', 'physcode_travelwp.css' );
}

class sass2css {
	function __construct() {
		add_action( 'redux/options/travelwp_theme_options/saved', array( $this, 'sass_to_css' ) );
	}

	function sass_to_css() {
		WP_Filesystem();
		global $wp_filesystem, $travelwp_theme_options; /* already initialised the Filesystem API previously */
		$scss = new scssc();
		$scss->setFormatter( "scss_formatter_compressed" );
		$fileout = get_template_directory() . "/scss/getoption.scss";

		// put content
		$theme_options      = array(
			// hearder
			'width_logo'                => '0',
			'width_logo_mobile'         => '0',
			'bg_header_color'           => 'rgba',
			'bg_top_bar'                => 'rgba',
			'text_color_top_bar'        => '0',
			'link_color_top_bar'        => '0',
			'text_menu_color'           => '0',
			'text_home_page'            => '0',
			'font_size_main_menu'       => '0',
			'font_weight_main_menu'     => '0',
			'bg_sticky_menu'            => 'rgba',
			'text_color_sticky_menu'    => '0',
			'sub_menu_bg_color'         => '0',
			'sub_menu_text_color'       => '0',
			'sub_menu_text_hover_color' => '0',
			'mobile_menu_bg_color'      => '0',
			'mobile_menu_text_color'    => '0',
			'mobile_text_hover_color'    => '0',
			//styling
			'body_color_primary'        => '0',
			'body_color_second'         => '0',
			//			//typography
			'font_size_h1'              => '0',
			'font_weight_h1'            => '0',
			'font_size_h2'              => '0',
			'font_weight_h2'            => '0',
			'font_size_h3'              => '0',
			'font_weight_h3'            => '0',
			'font_size_h4'              => '0',
			'font_weight_h4'            => '0',
			'font_size_h5'              => '0',
			'font_weight_h5'            => '0',
			'font_size_h6'              => '0',
			'font_weight_h6'            => '0',
			//footer
			'bg_footer'                 => '0',
			'text_color_footer'         => '0',
			'text_font_size_footer'     => '0',
			'border_color_footer'       => '0',
			'title_color_footer'        => '0',
			'title_font_size_footer'    => '0',
			'bg_newsletter_color'       => 'rgba'
		);
		$theme_options_data = '';
		foreach ( $theme_options AS $key => $val ) {
			if ( $val == '0' ) {
				$data = $travelwp_theme_options[$key];
			} else {
				$data = $travelwp_theme_options[$key][$val];
			}
			$theme_options_data .= "\${$key}: {$data}!default;\n";
		}
		// font body
		$theme_options_data .= $travelwp_theme_options['font_body']['color'] ? '$body_color:' . $travelwp_theme_options['font_body']['color'] . ';' : '$body_color:#3333;';
		$theme_options_data .= $travelwp_theme_options['font_body']['font-family'] ? '$body-font-family: ' . $travelwp_theme_options['font_body']['font-family'] . ',Helvetica,Arial,sans-serif;' : '$body-font-family:Helvetica,Arial,sans-serif;';
		$theme_options_data .= $travelwp_theme_options['font_body']['font-weight'] ? '$font_weight_body: ' . $travelwp_theme_options['font_body']['font-weight'] . ';' : '$font_weight_body:Normal;';
		$theme_options_data .= $travelwp_theme_options['font_body']['font-size'] ? '$body_font_size: ' . $travelwp_theme_options['font_body']['font-size'] . ';' : '$body_font_size:13px;';
		$theme_options_data .= $travelwp_theme_options['font_body']['line-height'] ? '$body_line_height: ' . $travelwp_theme_options['font_body']['line-height'] . ';' : '$body_line_height:24px';

		// font heading
		$theme_options_data .= $travelwp_theme_options['font_title']['font-family'] ? '$heading-font-family: ' . $travelwp_theme_options['font_title']['font-family'] . ',Helvetica,Arial,sans-serif;' : '$heading-font-family:Helvetica,Arial,sans-serif;';
		$theme_options_data .= $travelwp_theme_options['font_title']['color'] ? '$heading-color: ' . $travelwp_theme_options['font_title']['color'] . ';' : '$heading-color:#333;';
		$theme_options_data .= $travelwp_theme_options['font_title']['font-weight'] ? '$heading-font-weight: ' . $travelwp_theme_options['font_title']['font-weight'] . ';' : '$heading-font-weight:Normal;';

		$theme_options_data .= $wp_filesystem->get_contents( $fileout );
 		$css              = '';
		$background_color = $travelwp_theme_options['body_background']['background-color'] ? ' background-color: ' . $travelwp_theme_options['body_background']['background-color'] : '';

		if ( $background_color ) {
			$css .= '.wrapper-content,.single-woo-tour .description_single .affix-sidebar,.wrapper-price-nights .price-nights-details{' . $background_color . '}
				.post_list_content_unit .post-list-content .post_list_meta_unit .sticky_post:after{border-color: transparent transparent ' . $travelwp_theme_options['body_background']['background-color'] . ' transparent;}
			';
		}
		if ( isset( $travelwp_theme_options['box_layout'] ) && $travelwp_theme_options['box_layout'] == 'boxed' ) {
			$background_image = '';
			if ( $travelwp_theme_options['body_background']['background-image'] ) {
				$background_image .= $travelwp_theme_options['body_background']['background-image'] ? 'background-image: url( ' . $travelwp_theme_options['body_background']['background-image'] . ');' : '';
			} elseif ( isset( $travelwp_theme_options['background_pattern'] ) ) {
				$background_image .= $travelwp_theme_options['background_pattern'] ? 'background-image: url( ' . $travelwp_theme_options['background_pattern'] . ');' : '';
			}
			$background_image .= $travelwp_theme_options['body_background']['background-repeat'] ? 'background-repeat: ' . $travelwp_theme_options['body_background']['background-repeat'] . ';' : '';
			$background_image .= $travelwp_theme_options['body_background']['background-size'] ? 'background-size: ' . $travelwp_theme_options['body_background']['background-size'] . ';' : '';
			$background_image .= $travelwp_theme_options['body_background']['background-attachment'] ? 'background-attachment: ' . $travelwp_theme_options['body_background']['background-attachment'] . ';' : '';
			$background_image .= $travelwp_theme_options['body_background']['background-position'] ? 'background-position: ' . $travelwp_theme_options['body_background']['background-position'] . ';' : '';
			if ( $background_image ) {
				$css .= 'body{' . $background_image . '}';
			}
		}
		$css .= $scss->compile( $theme_options_data );
		// custom css
		$css .= $travelwp_theme_options['opt-ace-editor-css'];
		if ( !$wp_filesystem->put_contents( TRAVELWP_UPLOADS_FOLDER . TRAVELWP_FILE_NAME, $css, FS_CHMOD_FILE ) ) {
			$wp_filesystem->put_contents( TRAVELWP_UPLOADS_FOLDER . TRAVELWP_FILE_NAME, $css, FS_CHMOD_FILE );
		}
	}
}

new sass2css();
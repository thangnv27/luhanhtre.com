<?php

function travelwp_base_url() {
	return trailingslashit( get_template_directory_uri() . '/inc/admin/post-format-ui/' );
}

function travelwp_admin_init() {
	$post_formats = get_theme_support( 'post-formats' );
	if ( ! empty( $post_formats[0] ) && is_array( $post_formats[0] ) ) {
		if ( in_array( 'link', $post_formats[0] ) ) {
			add_action( 'save_post', 'travelwp_format_link_save_post' );
		}
		if ( in_array( 'status', $post_formats[0] ) ) {
			add_action( 'save_post', 'travelwp_format_status_save_post', 10, 2 );
		}
		if ( in_array( 'quote', $post_formats[0] ) ) {
			add_action( 'save_post', 'travelwp_format_quote_save_post', 10, 2 );
		}
		if ( in_array( 'video', $post_formats[0] ) ) {
			add_action( 'save_post', 'travelwp_format_video_save_post' );
		}
		if ( in_array( 'audio', $post_formats[0] ) ) {
			add_action( 'save_post', 'travelwp_format_audio_save_post' );
		}
		if ( in_array( 'video', $post_formats[0] ) ) {
			add_action( 'save_post', 'travelwp_format_gallery_save_post' );
		}
	}
}

add_action( 'admin_init', 'travelwp_admin_init' );

// we aren't really adding meta boxes here,
// but this gives us the info we need to get our stuff in.
function travelwp_add_meta_boxes( $post_type ) {
	if ( post_type_supports( $post_type, 'post-formats' ) && current_theme_supports( 'post-formats' ) ) {
		// assets
		wp_enqueue_script( 'bws-post-formats-ui', travelwp_base_url() . 'js/admin.js', array( 'jquery' ), '' );
		wp_enqueue_style( 'bws-post-formats-ui', travelwp_base_url() . 'css/admin.css', array(), '', 'screen' );

		wp_localize_script(
			'bws-post-formats-ui',
			'travelwp_post_format',
			array(
				'loading'      => esc_html__( 'Loading...', 'travelwp' ),
				'media_title'  => esc_html__( 'Pick Gallery Images', 'travelwp' ),
				'media_button' => esc_html__( 'Add Image(s)', 'travelwp' )
			)
		);

		add_action( 'edit_form_after_title', 'travelwp_post_admin_setup' );
	}
}

add_action( 'add_meta_boxes', 'travelwp_add_meta_boxes' );

/**
 * Show the post format navigation tabs
 * A lot of cues are taken from the `post_format_meta_box`
 *
 * @return void
 */
function travelwp_post_admin_setup() {
	$post_formats = get_theme_support( 'post-formats' );
	if ( ! empty( $post_formats[0] ) && is_array( $post_formats[0] ) ) {
		global $post;
		$current_post_format = get_post_format( $post->ID );
		$hacked_format       = null;

		// support the possibility of people having hacked in custom
		// post-formats or that this theme doesn't natively support
		// the post-format in the current post - a tab will be added
		// for this format but the default WP post UI will be shown ~sp
		if ( ! empty( $current_post_format ) && ! in_array( $current_post_format, $post_formats[0] ) ) {
			$hacked_format = $current_post_format;
			array_push( $post_formats[0], $current_post_format );
		}
		array_unshift( $post_formats[0], 'standard' );
		$post_formats = $post_formats[0];

		include get_template_directory() . "/inc/admin/post-format-ui/views/tabs.php";

		// prevent added un-supported custom post format from view output
		if ( ! is_null( $hacked_format ) and ( $key = array_search( $current_post_format, $post_formats ) ) !== false ) {
			unset( $post_formats[ $key ] );
		}

		$format_views = array(
			'link',
			'quote',
			'video',
			'gallery',
			'audio',
		);
		foreach ( $format_views as $format ) {
			if ( in_array( $format, $post_formats ) ) {
				include get_template_directory() . ( '/inc/admin/post-format-ui/views/format-' . $format . '.php' );
			}
		}
	}
}

function travelwp_format_link_save_post( $post_id ) {
	if ( ! defined( 'XMLRPC_REQUEST' ) && isset( $_POST['_format_link_url'] ) ) {
		update_post_meta( $post_id, '_format_link_url', $_POST['_format_link_url'] );
	}
}

// action added in travelwp_admin_init()

function travelwp_format_auto_title_post( $post_id, $post ) {
	// get out early if a title is already set
	if ( ! empty( $post->post_title ) ) {
		return;
	}

	remove_action( 'save_post', 'travelwp_format_status_save_post', 10, 2 );
	remove_action( 'save_post', 'travelwp_format_quote_save_post', 10, 2 );

	$content = trim( strip_tags( $post->post_content ) );
	$title   = substr( $content, 0, 50 );
	if ( strlen( $content ) > 50 ) {
		$title .= '...';
	}
	$title = apply_filters( 'travelwp_format_auto_title', $title, $post );
	wp_update_post( array(
		'ID'         => $post_id,
		'post_title' => $title
	) );

	add_action( 'save_post', 'travelwp_format_status_save_post', 10, 2 );
	add_action( 'save_post', 'travelwp_format_quote_save_post', 10, 2 );
}

function travelwp_format_status_save_post( $post_id, $post ) {
	if ( has_post_format( 'status', $post ) ) {
		travelwp_format_auto_title_post( $post_id, $post );
	}
}

// action added in travelwp_admin_init()

function travelwp_format_quote_save_post( $post_id, $post ) {
	if ( ! defined( 'XMLRPC_REQUEST' ) ) {
		$keys = array(
			'_format_quote_source_name',
			'_format_quote_source_url',
		);
		foreach ( $keys as $key ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, $key, $_POST[ $key ] );
			}
		}
	}
	if ( has_post_format( 'quote', $post ) ) {
		travelwp_format_auto_title_post( $post_id, $post );
	}
}

// action added in travelwp_admin_init()

function travelwp_format_video_save_post( $post_id ) {
	if ( ! defined( 'XMLRPC_REQUEST' ) && isset( $_POST['_format_video_embed'] ) ) {
		update_post_meta( $post_id, '_format_video_embed', $_POST['_format_video_embed'] );
	}
}

// action added in travelwp_admin_init()

function travelwp_format_audio_save_post( $post_id ) {
	if ( ! defined( 'XMLRPC_REQUEST' ) && isset( $_POST['_format_audio_embed'] ) ) {
		update_post_meta( $post_id, '_format_audio_embed', $_POST['_format_audio_embed'] );
	}
}

// action added in travelwp_admin_init()

function travelwp_format_gallery_save_post( $post_id ) {
	if ( ! defined( 'XMLRPC_REQUEST' ) && isset( $_POST['_format_gallery_images'] ) ) {
		global $post;
		if ( $_POST['_format_gallery_images'] !== '' ) {
			$images = explode( ',', $_POST['_format_gallery_images'] );
		} else {
			$images = array();
		}
		update_post_meta( $post_id, '_format_gallery_images', $images );
	}
}

// action added in travelwp_admin_init()

function travelwp_gallery_preview() {
	if ( empty( $_POST['id'] ) || ! ( $post_id = intval( $_POST['id'] ) ) ) {
		exit;
	}
	global $post;
	$post->ID = $post_id;
	ob_start();
	include get_template_directory() . "/inc/admin/post-format-ui/views/format-gallery.php";
	$html = ob_get_clean();
	header( 'Content-type: text/javascript' );
	echo json_encode( compact( 'html' ) );
	exit;
}

add_action( 'wp_ajax_travelwp_gallery_preview', 'travelwp_gallery_preview' );

function travelwp_post_has_gallery( $post_id = null ) {
	if ( empty( $post_id ) ) {
		$post_id = get_the_ID();
	}
	$images = new WP_Query( array(
		'post_parent'    => $post_id,
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'posts_per_page' => 1, // -1 to show all
		'post_mime_type' => 'image%',
		'orderby'        => 'menu_order',
		'order'          => 'ASC'
	) );

	return (bool) $images->post_count;
}

function travelwp_pre_ping_post_links( $post_links, $pung, $post_id = null ) {
	// return if we don't get a post ID (pre WP 3.4)
	if ( empty( $post_id ) ) {
		return;
	}
	$url = get_post_meta( $post_id, '_format_link_url', true );
	if ( ! empty( $url ) && ! in_array( $url, $pung ) && ! in_array( $url, $post_links ) ) {
		$post_links[] = $url;
	}
}

add_filter( 'pre_ping', 'travelwp_pre_ping_post_links', 10, 3 );
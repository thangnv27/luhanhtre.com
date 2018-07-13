<?php
/**
 * travelWP functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package travelWP
 */

// Constants: Folder directories/uri's
define( 'TRAVELWP_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'TRAVELWP_THEME_URI', trailingslashit( get_template_directory_uri() ) );

/**
 * Theme Includes
 */

require_once TRAVELWP_THEME_DIR . '/inc/init.php';

//remove_action( "redux/extensions/travelwp_theme_options/before", 'physcode_custom_extension_loader', 0 );

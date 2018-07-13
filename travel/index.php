<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package travelWP
 */

get_header();

do_action( 'travelwp_wrapper_banner_heading' );

do_action( 'travelwp_wrapper_loop_start' );

if ( have_posts() ) : ?>
	<?php
	echo '<div class="wrapper-blog-content">';
	/* Start the Loop */
	while ( have_posts() ) : the_post();
		/*
		* Include the Post-Format-specific template for the content.
		* If you want to override this in a child theme, then include a file
		* called content-___.php (where ___ is the Post Format name) and that will be used instead.
		*/
		get_template_part( 'template-parts/content', get_post_format() );
	endwhile;
	echo '</div>';
	travel_the_posts_navigation();

else :

	get_template_part( 'template-parts/content', 'none' );

endif;

do_action( 'travelwp_wrapper_loop_end' );
get_footer();
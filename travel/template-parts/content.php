<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package travelWP
 */
$class = '';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	do_action('travelwp_entry_top')
	?>
	<div class="entry-content<?php echo esc_attr( $class ) ?>">
		<header class="entry-header">
			<?php
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php travelwp_posted_on_index(); ?>
				</div><!-- .entry-meta -->
				<?php
			endif; ?>
		</header><!-- .entry-header -->
		<div class="entry-desc">
			<?php
			the_excerpt();
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'travelwp' ),
				'after'  => '</div>',
			) );
			?>
		</div>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
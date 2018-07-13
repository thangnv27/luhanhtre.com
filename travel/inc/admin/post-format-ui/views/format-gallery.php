<div id="bws-ui-format-gallery-preview" class="bws-ui-elm-block bws-ui-elm-block-image" style="display: none;">
	<label><span><?php esc_html_e('Gallery Images', 'travelwp'); ?></span></label>
	<div class="bws-ui-elm-container">

		<?php do_action( 'travelwp_before_gallery_meta' ); ?>

		<div class="bws-ui-gallery-picker">
			<?php
				// query the gallery images meta
				global $post;
				$images = get_post_meta($post->ID, '_format_gallery_images', true);

				echo '<div class="gallery clearfix">';
				if ($images) {
					foreach ($images as $image) {
						$thumbnail = wp_get_attachment_image_src($image, 'thumbnail');
						echo '<span data-id="' . $image . '" title="' . 'title' . '"><img src="' . $thumbnail[0] . '" alt="" /><span class="close">x</span></span>';
					}
				}
				echo '</div>';
			?>
			<input type="hidden" name="_format_gallery_images" value="<?php echo (empty($images) ? "" : implode(',', $images)); ?>" />
			<p class="none"><a href="#" class="button bws-ui-gallery-button"><?php esc_html_e('Pick Images', 'travelwp'); ?></a></p>
		</div>

		<?php do_action( 'travelwp_after_gallery_meta' ); ?>

	</div>
</div>
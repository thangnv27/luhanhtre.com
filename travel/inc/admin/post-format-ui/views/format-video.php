<div class="bws-ui-elm-block" id="bws-ui-format-video-fields" style="display: none;">
	<?php do_action( 'travelwp_before_video_meta' ); ?>
	<label for="bws-ui-format-video-embed"><?php esc_html_e('Video URL (oEmbed) or Embed Code', 'travelwp'); ?></label>
	<div class="ui-inner"><textarea name="_format_video_embed" id="bws-ui-format-video-embed" tabindex="1"><?php echo esc_textarea(get_post_meta($post->ID, '_format_video_embed', true)); ?></textarea></div>
	<?php do_action( 'travelwp_after_video_meta' ); ?>
</div>	

<div class="bws-ui-elm-block" id="bws-ui-format-audio-fields" style="display: none;">
	<?php do_action( 'travelwp_before_audio_meta' ); ?>
	<label for="bws-ui-format-audio-embed"><?php esc_html_e('Audio URL (oEmbed) or Embed Code', 'travelwp'); ?></label>
	<div class="ui-inner"><textarea name="_format_audio_embed" id="bws-ui-format-audio-embed" tabindex="1"><?php echo esc_textarea(get_post_meta($post->ID, '_format_audio_embed', true)); ?></textarea></div>
	<?php do_action( 'travelwp_after_audio_meta' ); ?>
</div>	

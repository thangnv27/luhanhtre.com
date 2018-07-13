<div class="bws-ui-elm-block" id="bws-ui-format-link-url" style="display: none;">
	<?php do_action( 'travelwp_before_link_meta' ); ?>
	<label for="bws-ui-format-link-url-field"><?php esc_html_e('URL', 'travelwp'); ?></label>
	<div class="ui-inner"><input type="text" name="_format_link_url" value="<?php echo esc_attr(get_post_meta($post->ID, '_format_link_url', true)); ?>" id="bws-ui-format-link-url-field" tabindex="1" /></div>
	<?php do_action( 'travelwp_after_link_meta' ); ?>
</div>	

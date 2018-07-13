<div id="bws-ui-format-quote-fields" style="display: none;">
	<?php do_action( 'travelwp_before_quote_meta' ); ?>
	<div class="bws-ui-elm-block">
		<label for="bws-ui-format-quote-source-name"><?php esc_html_e('Source Name', 'travelwp'); ?></label>
		<div class="ui-inner"><input type="text" name="_format_quote_source_name" value="<?php echo esc_attr(get_post_meta($post->ID, '_format_quote_source_name', true)); ?>" id="bws-ui-format-quote-source-name" tabindex="1" /></div>
	</div>
	<div class="bws-ui-elm-block">
		<label for="bws-ui-format-quote-source-url"><?php esc_html_e('Source URL', 'travelwp'); ?></label>
		<div class="ui-inner"><input type="text" name="_format_quote_source_url" value="<?php echo esc_attr(get_post_meta($post->ID, '_format_quote_source_url', true)); ?>" id="bws-ui-format-quote-source-url" tabindex="1" /></div>
	</div>
	<?php do_action( 'travelwp_after_quote_meta' ); ?>
</div>

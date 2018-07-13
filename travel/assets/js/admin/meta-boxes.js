jQuery(function ($) {
	checkboxToggle();
	toggleDisplaysetting();
	/**
	 * Show, hide a <div> based on a checkbox
	 *
	 * @return void
	 * @since 1.0
	 */
	function checkboxToggle() {
		$('body').on('change', '.checkbox-toggle input', function () {
			var $this = $(this),
				$toggle = $this.closest('.checkbox-toggle'),
				action;
			if (!$toggle.hasClass('reverse'))
				action = $this.is(':checked') ? 'slideDown' : 'slideUp';
			else
				action = $this.is(':checked') ? 'slideUp' : 'slideDown';

			$toggle.next()[action]();
		});
		$('.checkbox-toggle input').trigger('change');
	}

	function toggleDisplaysetting() {
		jQuery('#page_template').change(function () {
			jQuery('#display-settings')[jQuery(this).val() == 'default' ? 'show' : 'hide']();
		}).trigger('change');
		jQuery('.post-type-attachment #display-settings').hide();
	}
});
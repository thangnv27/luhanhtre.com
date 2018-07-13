jQuery(function($) {
	var bws = bws || {};
	
	bws.postFormats = function($) {
		return {
			switchTab: function(clicked) {
				var $this = $(clicked),
					$tab = $this.closest('li');

				if (!$this.hasClass('current')) {
					$this.addClass('current');
					$tab.siblings().find('a').removeClass('current');
					this.switchWPFormat($this.attr('href'));
				}
			},
			
			switchWPFormat: function(formatHash) {
				$(formatHash).trigger('click');
				switch (formatHash) {
					case '#post-format-0':
					case '#post-format-aside':
					case '#post-format-chat':
						bws.postFormats.standard();
						break;
					case '#post-format-status':
					case '#post-format-link':
					case '#post-format-image':
					case '#post-format-gallery':
					case '#post-format-video':
					case '#post-format-quote':
					case '#post-format-audio':
						bws.postFormats[formatHash.replace('#post-format-', '')]();
				}
				$(document).trigger('bws-post-formats-ui-switch', formatHash);
			},

			standard: function() {
				$('#bws-ui-format-link-url, #bws-ui-format-quote-fields, #bws-ui-format-video-fields, #bws-ui-format-audio-fields, #bws-ui-format-gallery-preview').hide();
				$('#titlewrap').show();
				$('#postimagediv-placeholder').replaceWith($('#postimagediv'));
			},
			
			status: function() {
				$('#titlewrap, #bws-ui-format-link-url, #bws-ui-format-quote-fields, #bws-ui-format-video-fields, #bws-ui-format-audio-fields, #bws-ui-format-gallery-preview').hide();
				$('#postimagediv-placeholder').replaceWith($('#postimagediv'));
				$('#content:visible').focus();
			},

			link: function() {
				$('#bws-ui-format-quote-fields, #bws-ui-format-video-fields, #bws-ui-format-audio-fields, #bws-ui-format-gallery-preview').hide();
				$('#titlewrap, #bws-ui-format-link-url').show();
				$('#postimagediv-placeholder').replaceWith($('#postimagediv'));
			},
			
			image: function() {
				$('#bws-ui-format-link-url, #bws-ui-format-quote-fields, #bws-ui-format-video-fields, #bws-ui-format-audio-fields, #bws-ui-format-gallery-preview').hide();
				$('#titlewrap').show();
				$('#postimagediv').after('<div id="postimagediv-placeholder"></div>').insertAfter('#titlediv');
			},

			gallery: function() {
				$('#bws-ui-format-link-url, #bws-ui-format-quote-fields, #bws-ui-format-video-fields, #bws-ui-format-audio-fields').hide();
				$('#titlewrap, #bws-ui-format-gallery-preview').show();
				$('#postimagediv-placeholder').replaceWith($('#postimagediv'));
			},

			video: function() {
				$('#bws-ui-format-link-url, #bws-ui-format-quote-fields, #bws-ui-format-gallery-preview, #bws-ui-format-audio-fields').hide();
				$('#titlewrap, #bws-ui-format-video-fields').show();
				$('#postimagediv-placeholder').replaceWith($('#postimagediv'));
			},

			quote: function() {
				$('#titlewrap, #bws-ui-format-link-url, #bws-ui-format-video-fields, #bws-ui-format-audio-fields, #bws-ui-format-gallery-preview').hide();
				$('#bws-ui-format-quote-fields').show().find(':input:first').focus();
				$('#postimagediv-placeholder').replaceWith($('#postimagediv'));
			},

			audio: function() {
				$('#bws-ui-format-link-url, #bws-ui-format-quote-fields, #bws-ui-format-video-fields, #bws-ui-format-gallery-preview').hide();
				$('#titlewrap, #bws-ui-format-audio-fields').show();
				$('#postimagediv-placeholder').replaceWith($('#postimagediv'));
			}

		};
	}(jQuery);
	
	// move tabs in to place
	$('#bws-post-formats-ui-tabs').insertBefore($('#titlediv'));
	$('#bws-ui-format-link-url, #bws-ui-format-video-fields, #bws-ui-format-audio-fields').insertAfter($('#titlediv'));
	$('#bws-ui-format-gallery-preview').find('dt a').each(function() {
		$(this).replaceWith($(this.childNodes)); // remove links
	}).end().insertAfter($('#titlediv'));
	$('#bws-ui-format-quote-fields').insertAfter($('#titlediv'));
	
	$(document).trigger('bws-post-formats-ui-init');
	
	// tab switch
	$('#bws-post-formats-ui-tabs a').live('click', function(e) {
		bws.postFormats.switchTab(this);
		e.stopPropagation();
		e.preventDefault();
	}).filter('.current').each(function() {
		bws.postFormats.switchWPFormat($(this).attr('href'));
	});

	// Gallery Management
	var postId   = $('#post_ID').val(),
	    $gallery = $('.bws-ui-gallery-picker .gallery');

	VPPFUIMediaControl = {

		// Init a new media manager or returns existing frame
		frame: function() {
			if( this._frame )
				return this._frame;

			this._frame = wp.media({
				title: travelwp_post_format.media_title,
				library: {
					type: 'image'
				},
				button: {
					text: travelwp_post_format.media_button
				},
				multiple: true
			});

			this._frame.on('open', this.updateFrame).state('library').on('select', this.select);

			return this._frame;
		},

		select: function() {
			var selection = this.get('selection');

			selection.each(function(model) {
				var thumbnail = model.attributes.url;
				if( model.attributes.sizes !== undefined && model.attributes.sizes.thumbnail !== undefined )
					thumbnail = model.attributes.sizes.thumbnail.url;
				$gallery.append('<span data-id="' + model.id + '" title="' + model.attributes.title + '"><img src="' + thumbnail + '" alt="" /><span class="close">x</span></span>');
				$gallery.trigger('update');
			});
		},

		updateFrame: function() {
		},

		init: function() {
			$('#wpbody').on('click', '.bws-ui-gallery-button', function(e){
				e.preventDefault();
				VPPFUIMediaControl.frame().open();
			});
		}
	}
	VPPFUIMediaControl.init();

	$gallery.on('update', function(){
		var ids = [];
		$(this).find('> span').each(function(){
			ids.push($(this).data('id'));
		});
		$('[name="_format_gallery_images"]').val(ids.join(','));
	});

	$gallery.sortable({
		placeholder: "bws-ui-ui-state-highlight",
		revert: 200,
		tolerance: 'pointer',
		stop: function () {
			$gallery.trigger('update');
		}
	});

	$gallery.on('click', 'span.close', function(e){
		$(this).parent().fadeOut(200, function(){
			$(this).remove();
			$gallery.trigger('update');
		});
	});

});

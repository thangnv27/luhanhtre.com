(function ($) {
	"use strict";
	$.avia_utilities = $.avia_utilities || {};
	$.avia_utilities.supported = {};
	$.avia_utilities.supports = (function () {
		var div = document.createElement('div'),
			vendors = ['Khtml', 'Ms', 'Moz', 'Webkit', 'O'];
		return function (prop, vendor_overwrite) {
			if (div.style.prop !== undefined) {
				return "";
			}
			if (vendor_overwrite !== undefined) {
				vendors = vendor_overwrite;
			}
			prop = prop.replace(/^[a-z]/, function (val) {
				return val.toUpperCase();
			});

			var len = vendors.length;
			while (len--) {
				if (div.style[vendors[len] + prop] !== undefined) {
					return "-" + vendors[len].toLowerCase() + "-";
				}
			}
			return false;
		};
	}());
	/* Smartresize */
	(function ($, sr) {
		var debounce = function (func, threshold, execAsap) {
			var timeout;
			return function debounced() {
				var obj = this, args = arguments;

				function delayed() {
					if (!execAsap)
						func.apply(obj, args);
					timeout = null;
				}

				if (timeout)
					clearTimeout(timeout);
				else if (execAsap)
					func.apply(obj, args);
				timeout = setTimeout(delayed, threshold || 100);
			}
		}
		// smartresize
		jQuery.fn[sr] = function (fn) {
			return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr);
		};
	})(jQuery, 'smartresize');
})(jQuery);

var custom_js = {
	init                    : function () {
		// image top header
		jQuery('#masthead').imagesLoaded(function () {
			var navigation_menu = jQuery('#masthead').outerHeight(true);
			var header_top_bar = jQuery('.affix .header_top_bar').outerHeight(true);
			var header_top_bar_hiden = 0;
			if (jQuery(window).width() > 768) {
				if (header_top_bar == 0) {
					header_top_bar_hiden = 38
				}
			}
			var height_header = navigation_menu + header_top_bar_hiden;
			if (height_header > 0) {
				jQuery('.wrapper-content .top_site_main').css({"padding-top": height_header + 'px'});
			}
		});
		if (jQuery('html').attr('dir') == 'rtl') {
			jQuery('[data-vc-full-width="true"]').each(function (i, v) {
				jQuery(this).css('right', jQuery(this).css('left')).css('left', 'auto');
			});
		}
		// button mobile menu
		jQuery(".button-collapse").sideNav();
		// tour_tab
		jQuery('.tours-tabs a').click(function (e) {
			e.preventDefault()
		});
		if (jQuery().mbComingsoon) {
			jQuery('.deals-discounts').each(function () {
				var data = jQuery(this).data();
				var date_text = data.text;
				date_text = date_text.split(',');
				jQuery(this).mbComingsoon({
					expiryDate  : new Date(data.year, (data.month - 1), data.date, data.hour, data.min, data.sec),
					speed       : 500,
					gmt         : data.gmt,
					showText    : 1,
					localization: {
						days   : date_text[0],
						hours  : date_text[1],
						minutes: date_text[2],
						seconds: date_text[3]
					}
				});
			});
		}
		if (jQuery().counterUp) {
			jQuery(document).ready(function ($) {
				jQuery('.stats_counter_number').counterUp({
					delay: 10,
					time : 1000
				});
			});
		}
		jQuery('.wrapper-footer-newsletter').imagesLoaded(function () {
			jQuery('.wrapper-footer-newsletter').css({'margin-bottom': jQuery('.wrapper-subscribe').outerHeight() + 'px'});
		});
		jQuery('[data-toggle="tooltip"]').tooltip();
		if (jQuery(window).width() < 768) {
			jQuery('.woocommerce-tabs .wc-tabs').tabCollapse();
		}
		jQuery(document).on('click', '.gallery-tabs li a', function (e) {
			e.preventDefault();
			var $this = jQuery(this), myClass = $this.attr("data-filter");
			$this.closest(".gallery-tabs").find("li a").removeClass("active");
			$this.addClass("active");
			if (jQuery().isotope) {
				$this.closest('.wrapper_gallery').find('.content_gallery').isotope({filter: myClass});
			}
		});
		if (jQuery().typed) {
			jQuery('.phys-typingTextEffect').each(function () {
				var options = {}, strings = [];
				for (var key in this.dataset) {
					if (key.substr(0, 6) == "string") {
						strings.push(this.dataset[key]);
					} else {
						options[key] = parseInt(this.dataset[key]);
					}
				}
				options['strings'] = strings;
				options['contentType'] = 'html';
				options['loop'] = true;
				jQuery(this).typed(options);
			});
		}
	},
	search                  : function () {
		jQuery('.search-toggler').on('click', function (e) {
			jQuery('.search-overlay').addClass("search-show");
		});
		jQuery('.closeicon,.background-overlay').on('click', function (e) {
			jQuery('.search-overlay').removeClass("search-show");
		});
		jQuery(document).keyup(function (e) {
			if (e.keyCode == 27) {
				jQuery('.search-overlay').removeClass("search-show");
			}
		});

		jQuery('.show_from').on('click', function (e) {
			jQuery('body').addClass("show_form_popup_login");
		});
		jQuery('.register_btn').on('click', function (e) {
			jQuery('body').addClass("show_form_popup_register");
		});
		jQuery('.closeicon').on('click', function (e) {
			jQuery('body').removeClass("show_form_popup_login");
			jQuery('body').removeClass("show_form_popup_register");
		});
	},
	generateCarousel        : function () {
		if (jQuery().owlCarousel) {
			jQuery(".wrapper-tours-slider").each(function () {
				var $this = jQuery(this),
					owl = $this.find('.tours-type-slider');

				var config = owl.data();
 				if (typeof(config) != 'undefined') {
 					config.smartSpeed = 1000;
					config.margin = 0;
					config.loop = true;
					config.navText = ['<i class="lnr lnr-chevron-left"></i>', '<i class="lnr lnr-chevron-right"></i>'];
				}
				if (owl.children().length > 1) {
					owl.owlCarousel(config);
				} else {
				}
			})
		}
	},
	singleSlider            : function () {
		if (jQuery().flexslider) {
			jQuery('#carousel').flexslider({
				animation    : "slide",
				controlNav   : false,
				animationLoop: false,
				slideshow    : false,
				itemWidth    : 134,
				itemMargin   : 20,
				asNavFor     : '#slider',
				directionNav : true,  //Boolean: Create navigation for previous/next navigation? (true/false)
				prevText     : "",    //String: Set the text for the "previous" directionNav item
				nextText     : ""     //String: Set the text for the "next" directionNav item
			});
			jQuery('#slider').flexslider({
				animation    : "slide",
				controlNav   : false,
				animationLoop: false,
				slideshow    : false,
				sync         : "#carousel",
				directionNav : false,             //Boolean: Create navigation for previous/next navigation? (true/false)
				start        : function (slider) {
					jQuery('body').removeClass('loading');
				}
			});
		}
		if (jQuery().swipebox) {
			jQuery('.swipebox').swipebox({
				hideBarsDelay: false, // delay before hiding bars on desktop
				loopAtEnd    : true // true will return to the first image after the last image is reached
			});
		}
	},
	scrollToTop             : function () {
		jQuery('.footer__arrow-top').click(function () {
			jQuery('html, body').animate({scrollTop: '0px'}, 800);
			return false;
		});
	},
	stickyHeaderInit        : function () {
		//Add class for masthead
		if (jQuery('.no-header-sticky').length) {
			jQuery('.site-header').removeClass('sticky_header');
		}
		var $header = jQuery('.sticky_header'),
			menuH = $header.outerHeight(),
			$top_header = jQuery('.header_top_bar').outerHeight() + 2,
			latestScroll = 0;
		if (jQuery(window).scrollTop() > $top_header) {
			$header.removeClass('affix-top').addClass('affix');
		}
		jQuery(window).scroll(function () {
			var current = jQuery(this).scrollTop();
			if (current > $top_header) {
				$header.removeClass('affix-top').addClass('affix');
			} else {
				$header.removeClass('affix').addClass('affix-top');
			}
			if (current > latestScroll && current > menuH) {
				if (!$header.hasClass('menu-hidden')) {
					$header.addClass('menu-hidden');
				}
			} else {
				if ($header.hasClass('menu-hidden')) {
					$header.removeClass('menu-hidden');
				}
			}
			latestScroll = current;
		});
	},
	fixWidthSidebar         : function () {
		var window_width = jQuery(window).width();
		if (window_width > 992) {
			if (jQuery('#sticky-sidebar').length) {
				var el = jQuery('#sticky-sidebar'),
					price = jQuery('#sticky-sidebar p.price'),
					sidebarWidth = jQuery('.single-woo-tour .description_single').width();
				el.css({width: sidebarWidth});
				price.css({width: sidebarWidth});
			}
		}
	},
	stickySidebar           : function () {
		var window_width = jQuery(window).width();
		if (window_width > 992) {
			if (jQuery('#sticky-sidebar').length) {
				var el = jQuery('#sticky-sidebar'),
					price = jQuery('#sticky-sidebar p.price'),
					stickyTop = el.offset().top - jQuery('#wpadminbar').outerHeight(),
					stickyHeight = el.outerHeight(true),
					priceHeight = price.outerHeight(true),
					latestScroll = 0,
					top = 0;
				jQuery(window).scroll(function () {
					var limit = jQuery('.wrapper-footer').offset().top - stickyHeight - 60,
						Pricelimit = jQuery('.wrapper-footer').offset().top - priceHeight - 60;
					var windowTop = jQuery(window).scrollTop();
					if (windowTop > latestScroll) {
						if (jQuery('#wpadminbar').length) {
							top = jQuery('#wpadminbar').outerHeight();
						}
					} else {
						top = jQuery('#wpadminbar').outerHeight() + jQuery('.sticky_header').outerHeight()
					}
					if (stickyTop < windowTop) {
						el.css({position: 'fixed', top: top});
						price.css({position: 'relative', top: 0});
						el.addClass('show-fix');
					}
					else {
						var fix = stickyTop - jQuery('.sticky_header').outerHeight();
						if (fix > windowTop) {
							el.removeClass('show-fix');
							price.css({position: 'relative', top: 0});
							el.css({position: 'relative', top: -116});
						}
					}
					if (limit < windowTop) {
						var diff = limit - windowTop;
						price.css({position: 'fixed', top: (top + 21)});
						el.css({top: diff});
						el.removeClass('show-fix');
						if (Pricelimit < windowTop) {
							price.css({top: (Pricelimit - windowTop)});
						}
					}
					latestScroll = windowTop;
				});
			}
		}
	},
	stickyTab               : function () {
		setTimeout(function () {
			var window_width = jQuery(window).width();
			if (window_width > 992) {
				if (jQuery('.tabs-fixed-scroll').length) {
					jQuery('.flexslider').imagesLoaded(function () {
						var el = jQuery('.tabs-fixed-scroll'),
							stickyTop = el.offset().top - jQuery('#wpadminbar').outerHeight(),
							stickyHeight = el.outerHeight(true),
							latestScroll = 0,
							top = 0;
						jQuery(window).scroll(function () {
							var limit = jQuery('.wrapper-footer').offset().top - stickyHeight - 60;
							var current = jQuery(window).scrollTop();
							if (current > latestScroll) {
								top = jQuery('#wpadminbar').outerHeight()
							} else {
								top = jQuery('#wpadminbar').outerHeight() + jQuery('.sticky_header').outerHeight()
							}
							if (stickyTop < current) {
								el.css({position: 'fixed', top: top});
								el.addClass('show-fix');
								el.removeClass('no-fix-scroll');
							} else {
								el.removeClass('show-fix');
								el.addClass('no-fix-scroll');
								el.css({position: 'relative', top: 0});
							}
							if (limit < current) {
								var diff = limit - current;
								el.css({top: diff});
							}
							latestScroll = current;
						});
					});

					jQuery('.wc-tabs-scroll li [href^="#"]').click(function (e) {
						var menu_anchor = jQuery(this).attr('href'),
							tab_height = jQuery('.tabs-fixed-scroll').outerHeight(true),
							admin_bar = jQuery('#wpadminbar').outerHeight();
						if (menu_anchor && menu_anchor.indexOf("#") == 0 && menu_anchor.length > 1) {
							e.preventDefault();
							jQuery('html,body').animate({
								scrollTop: jQuery(menu_anchor).offset().top - tab_height - admin_bar
							}, 850);
						}
					});
				}
			}
		}, 1000);
	},
	stickyTab_active        : function () {
		var scrollTimer = false, scrollHandler = function () {
			var scrollPosition = parseInt(jQuery(window).scrollTop(), 10);
			jQuery('.wc-tabs-scroll li a[href^="#"]').each(function () {
				var thisHref = jQuery(this).attr('href');
				if (jQuery(thisHref).length) {
					var thisTruePosition = parseInt(jQuery(thisHref).offset().top, 10);
					if (jQuery("#wpadminbar").length) {
						var admin_height = jQuery("#wpadminbar").height();
					} else admin_height = 0;
					var thisPosition = thisTruePosition - (jQuery(".tabs-fixed-scroll").outerHeight() + admin_height);
					if (scrollPosition <= parseInt(jQuery(jQuery('.wc-tabs-scroll li a[href^="#"]').first().attr('href')).height(), 10)) {
						if (scrollPosition >= thisPosition) {
							jQuery('.wc-tabs-scroll li a[href^="#"]').removeClass('active');
							jQuery('.wc-tabs-scroll li a[href="' + thisHref + '"]').addClass('active');
						}
					} else {
						if (scrollPosition >= thisPosition || scrollPosition >= thisPosition) {
							jQuery('.wc-tabs-scroll li a[href^="#"]').removeClass('active');
							jQuery('.wc-tabs-scroll li a[href="' + thisHref + '"]').addClass('active');
						}
					}
				}
			});
		}
		window.clearTimeout(scrollTimer);
		scrollHandler();
		jQuery(window).scroll(function () {
			window.clearTimeout(scrollTimer);
			scrollTimer = window.setTimeout(function () {
				scrollHandler();
			}, 20);
		});
	},
	post_gallery            : function () {
		jQuery('.feature-image .flexslider').imagesLoaded(function () {
			jQuery('.feature-image .flexslider').flexslider({
				slideshow     : true,
				animation     : 'fade',
				pauseOnHover  : true,
				animationSpeed: 400,
				smoothHeight  : true,
				directionNav  : true,
				controlNav    : false
			});
		});
	},
	click_tab_on_tour_detail: function () {

		jQuery('body').on('click', '.js-tabcollapse-panel-heading', function (e) {
			e.preventDefault();
			var id_tab = jQuery(this).attr('href');
			var id_tab_current = '#' + jQuery('.panel-collapse.collapse.in').attr('id');

			jQuery('.js-tabcollapse-panel-heading').addClass('collapsed');
			if (id_tab != id_tab_current) {
				jQuery('.panel-collapse.collapse').removeClass('in');
			}
			var offset_top_this = jQuery(this).offset().top;
			var nav_menu_height = jQuery('#masthead').outerHeight();
			jQuery('body').stop().animate({scrollTop: (offset_top_this - nav_menu_height)}, '500', 'swing', function () {

			});
		});
	}
}

jQuery(window).load(function () {
	jQuery('#preload').delay(100).fadeOut(500, function () {
		jQuery(this).remove();
	});
	custom_js.init();
	custom_js.search();
	custom_js.generateCarousel();
	custom_js.singleSlider();
	custom_js.scrollToTop();
	custom_js.stickyHeaderInit();
	custom_js.post_gallery();
	custom_js.stickySidebar();
	custom_js.fixWidthSidebar();
	custom_js.stickyTab();
	custom_js.stickyTab_active();
	if (jQuery(window).width() < 668) {
		custom_js.click_tab_on_tour_detail();
	}

});
jQuery(window).resize(function () {
	custom_js.fixWidthSidebar();
});
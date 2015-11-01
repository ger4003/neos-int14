(function($, window, document, undefined) {

	var pluginName = "stageSlider",
		dataKey = "plugin_" + pluginName;

	// private methods


	// The actual plugin constuctor
	var StageSlider = function(element, options) {
		this.$el = $(element);
		// default options
		this.options = {
			dottedOverlay: "none",
			delay: 5000,
			startwidth: 1600,
			startheight: 685,
			hideThumbs: 200,
			thumbWidth: 100,
			thumbHeight: 50,
			thumbAmount: 1,
			simplifyAll: "off",
			navigationType: "none",
			navigationArrows: "solo",
			navigationStyle: "none",
			touchenabled: "on",
			onHoverStop: "on",
			nextSlideOnWindowFocus: "off",
			swipe_threshold: 0.7,
			swipe_min_touches: 1,
			drag_block_vertical: false,
			keyboardNavigation: "off",
			navigationHAlign: "center",
			navigationVAlign: "bottom",
			navigationHOffset: 0,
			navigationVOffset: 20,
			soloArrowLeftHalign: "left",
			soloArrowLeftValign: "center",
			soloArrowLeftHOffset: 20,
			soloArrowLeftVOffset: 0,
			soloArrowRightHalign: "right",
			soloArrowRightValign: "center",
			soloArrowRightHOffset: 20,
			soloArrowRightVOffset: 0,
			shadow: 0,
			fullWidth: "on",
			fullScreen: "off",
			spinner: "spinner4",
			stopAfterLoops: -1,
			stopAtSlide: -1,
			shuffle: "off",
			autoHeight: "off",
			forceFullWidth: "off",
			hideTimerBar: "off",
			hideThumbsOnMobile: "off",
			hideNavDelayOnMobile: 1500,
			hideBulletsOnMobile: "off",
			hideArrowsOnMobile: "on",
			hideThumbsUnderResolution: 0,
			hideSliderAtLimit: 0,
			hideCaptionAtLimit: 0,
			hideAllCaptionAtLilmit: 0
		};

		this.init(options);
	};

	StageSlider.prototype = {
		// initialize method for registering listeners or creating DOM elements, etc.
		init: function (options) {
			// use special options when beeing in neos backend
			if (window.site.neosWorkspaceName != 'live') {
				options.shuffel = "off";
				options.hideTimerBar = "on";
				options.onHoverStop = "on";
				options.stopAfterLoops = 0;
				options.stopAtSlide = 1;
				options.startWithSlide = 0;
			}

			$.extend(true, this.options, options);

			this.setRevolutionSliderStartSize();
			this.initRevolutionSlider();

			// only fix height in live workspace
			if (window.site.neosWorkspaceName == 'live') {
				this.fixRevolutionSliderLoadingHeight();
			}
		},

		destroy: function () {
			this.$el.removeData();
		},

		initRevolutionSlider: function() {
			if($('#rev_slider_4_1').revolution == undefined) {
				revslider_showDoubleJqueryError('#rev_slider_4_1');
			} else {
				$('#rev_slider_4_1').show().revolution(this.options);
			}
		},

		setRevolutionSliderStartSize: function () {
			var tpopt = {};
			tpopt.startwidth = 1600;
			tpopt.startheight = 685;
			tpopt.container = jQuery('#rev_slider_4_1');
			tpopt.fullScreen = "off";
			tpopt.forceFullWidth = "off";
			tpopt.container.closest(".rev_slider_wrapper").css({height: tpopt.container.height()});
			tpopt.width = parseInt(tpopt.container.width(), 0);
			tpopt.height = parseInt(tpopt.container.height(), 0);
			tpopt.bw = tpopt.width / tpopt.startwidth;
			tpopt.bh = tpopt.height / tpopt.startheight;
			if (tpopt.bh > tpopt.bw)tpopt.bh = tpopt.bw;
			if (tpopt.bh < tpopt.bw)tpopt.bw = tpopt.bh;
			if (tpopt.bw < tpopt.bh)tpopt.bh = tpopt.bw;
			if (tpopt.bh > 1) {
				tpopt.bw = 1;
				tpopt.bh = 1
			}
			if (tpopt.bw > 1) {
				tpopt.bw = 1;
				tpopt.bh = 1
			}
			tpopt.height = Math.round(tpopt.startheight * (tpopt.width / tpopt.startwidth));
			if (tpopt.height > tpopt.startheight && tpopt.autoHeight != "on")tpopt.height = tpopt.startheight;
			if (tpopt.fullScreen == "on") {
				tpopt.height = tpopt.bw * tpopt.startheight;
				var cow = tpopt.container.parent().width();
				var coh = jQuery(window).height();
				if (tpopt.fullScreenOffsetContainer != undefined) {
					try {
						var offcontainers = tpopt.fullScreenOffsetContainer.split(",");
						jQuery.each(offcontainers, function (e, t) {
							coh = coh - jQuery(t).outerHeight(true);
							if (coh < tpopt.minFullScreenHeight)coh = tpopt.minFullScreenHeight
						})
					} catch (e) {
					}
				}
				tpopt.container.parent().height(coh);
				tpopt.container.height(coh);
				tpopt.container.closest(".rev_slider_wrapper").height(coh);
				tpopt.container.closest(".forcefullwidth_wrapper_tp_banner").find(".tp-fullwidth-forcer").height(coh);
				tpopt.container.css({height: "100%"});
				tpopt.height = coh;
			} else {
				tpopt.container.height(tpopt.height);
				tpopt.container.closest(".rev_slider_wrapper").height(tpopt.height);
				tpopt.container.closest(".forcefullwidth_wrapper_tp_banner").find(".tp-fullwidth-forcer").height(tpopt.height);
			}
		},

		fixRevolutionSliderLoadingHeight: function() {
			/* Fix The Revolution Slider Loading Height issue */
			jQuery('.rev_slider_wrapper').each(function(){
				$(this).css('height','');
				var revStartHeight = parseInt($('>.rev_slider', this).css('height'));
				$(this).height(revStartHeight);
				$(this).parents('#slider').height(revStartHeight);

				$(window).load(function(){
					$('#slider').css('height','');
				});
			});
		}
	};

	// plugin definition
	$.fn[pluginName] = function ( option ) {
		return this.each(function () {
			var $this = $(this),
				plugin = $this.data(dataKey);

			if (plugin instanceof StageSlider) {
				if (typeof option == 'object') {
					// if option arguments available, call plugin.init() again
					plugin.init(option);
				}
			} else {
				plugin = new StageSlider(this, option);
				$this.data(dataKey, plugin);
			}

			// call public method of Plugin object
			if (typeof option == 'string') {
				plugin[option]();
			}
		});
	};

})(jQuery, window, document);

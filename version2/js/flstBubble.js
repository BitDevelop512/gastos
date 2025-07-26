/*
@copyright Flester Iulian
@website: www.flester.ro
@https://www.patreon.com/Flesteriulian
 */

(function($) {
	$.fn.flstBubble = function(options) {
		// set the defaults options
		// define the variable where all the text will be stored for futher
		// reference
		var titles = new Array();
		var settings = $.extend({
			// if you are using more the a instance of this plugin then add a
			// custom id for each
			id : "flstBubble-strct",
			// duration can be a string or a string such as slow, fast(it is a
			// jQuery duration attribute)
			duration : 200,
			// you can pass an array of class or ids to use the wizard.
			wizard : false,
			// enable autoscroll - if the bubble is on the bottom of the page
			// and you are using wizard is very usefull
			autoscroll : false,
			// you can set the wizard to start from what nr from array you
			// choose. The count is starting from 0
			startWizardFrom : 0,
			// disable other bubbles except those from wizard
			showOnlyOnWizard : false,
			// use wizard ?
			useWizard : true,
			// add a function that will be called when the wizard reach end
			onFinishWizard : false,

			// by default the theme is disabled
			// you can add a plainObject with background and color properties:
			// ex: {background:'#color',color:'#color'}
			theme : false

		}, options);

		// create unique arrays for the small bubbles
		var bbl1Id = settings.id + 'b1';
		var bbl2Id = settings.id + 'b2';

		// only if you set a custom theme
		if (jQuery.isPlainObject(settings.theme)) {
			// update the theme else use the theme css file
			$(document).ready(
					function() {
						$(
								'#' + settings.id + ' .flst-msg, #' + bbl1Id
										+ ', #' + bbl2Id).css({
							background : settings.theme.background,
							color : settings.theme.color
						});
					});
		}
		// check if settings.id exists
		if ($('body #' + settings.id).length == 0) {
			// create the base html structure if it isn't already created
			var bbl = '<div id="' + settings.id + '" class="flstBubble-strct">';
			bbl += '<div class="flst-msg">no text</div>';
			bbl += '<div class="bbl1" id="' + bbl1Id + '">&nbsp;</div>';
			bbl += '<div class="bbl2" id="' + bbl2Id + '">&nbsp;</div>';
			bbl += '</div>';
			$('body').append(bbl);
		}

		// display the bubble
		function showBubble() {
			// first hide the bubble if is visible
			hideBubble();
			$('#' + settings.id).show();
			$('#' + bbl1Id).fadeIn(
					{
						duration : settings.duration,
						complete : function() {
							$('#' + bbl2Id).fadeIn(
									{
										duration : settings.duration,
										complete : function() {
											$('#' + settings.id + ' .flst-msg')
													.fadeIn(settings.duration);
										}
									});
						}
					});
		}
		// the plugin starts with bubble hidden
		hideBubble();
		// hide the bubble function
		function hideBubble() {

			$('#' + settings.id + ' #' + bbl1Id).hide();
			$('#' + settings.id + ' #' + bbl2Id).hide();
			$('#' + settings.id + ' .flst-msg').hide();
			$('#' + settings.id + '').hide();

		}
		// get the next item from wizard array
		function nextonWizard() {

			if (settings.wizard.length > 0) {
				// get the title attribute and remove it from tag to prevent
				// disaplying the default title tag
				var cname = settings.wizard[settings.startWizardFrom];
				popupBubble($(cname).attr('title'), cname);
				$(cname).removeAttr('title')
				settings.startWizardFrom++;
				if (settings.startWizardFrom == settings.wizard.length) {
					settings.startWizardFrom = -1;// has reached end;
				}
			}

		}
		// if the wizard is in use
		if (settings.useWizard) {
			nextonWizard();
			$('#' + settings.id + ' .flst-msg').bind('click', function(event) {
				if (settings.startWizardFrom == -1) {
					if (settings.onFinishWizard)
						settings.onFinishWizard();
					hideBubble();
				} else {
					nextonWizard();
				}
			});
		}
		if (!settings.showOnlyOnWizard) {
			// iterate through every tag
			this.each(function(index) {

				$(this).bind('mouseover', {
					title : $(this).attr('title')
				}, function(event) {

					popupBubble(event.data.title, this);

				});
				$(this).bind('mouseout', {
					title : $(this).attr('title')
				}, function(event) {

					hideBubble();

				});
				$(this).removeAttr('title');

			});
		}
		function popupBubble(title, thisObj) {

			var dw = $(document).width()
			var dh = $(document).outerHeight();
			$('#' + settings.id + ' .flst-msg').html(title);

			var p = $(thisObj).offset();
			showBubble();
			$('#' + settings.id + '').css({
				left : p.left,
				top : p.top - getRealHeight($(thisObj).outerHeight())
			});

			if (p.top - getRealHeight($(thisObj).outerHeight()) < 0
					&& (p.left + getRealWidth($(thisObj).outerWidth()) < dw)) {

				$('#' + settings.id + '').css('top',
						p.top + $(thisObj).outerHeight());
				$('#' + settings.id + ' .flst-msg').css({
					top : 45,
					left : 20
				})
				$('#' + bbl1Id).css({
					top : 0,
					left : 0
				})
				$('#' + bbl2Id).css({
					top : 15,
					left : 10
				})
			} else if ((p.top + getRealHeight($(thisObj).outerHeight()) > dh)
					&& (p.left + getRealWidth($(thisObj).outerWidth()) > dw)) {

				var offset = getRealWidth(0);

				$('#' + settings.id).css({
					left : p.left - offset,
					top : p.top - getRealHeight(0)
				});
				$('#' + settings.id + ' .flst-msg').css({
					top : 0,
					left : -15
				})
				$('#' + bbl1Id).css(
						{
							top : 25 + $('#' + settings.id + ' .flst-msg')
									.outerHeight(),
							left : offset
						})
				$('#' + bbl2Id).css(
						{
							top : 0 + $('#' + settings.id + ' .flst-msg')
									.outerHeight(),
							left : offset - 25
						})

			} else if (p.left + getRealWidth($(thisObj).outerWidth()) >= dw) {

				$('#' + settings.id + '').css({
					top : p.top + $(thisObj).outerHeight(),
					left : p.left - getRealWidth(0)
				});
				$('#' + settings.id + ' .flst-msg').css({
					top : 50,
					left : 10
				})
				$('#' + bbl1Id).css({
					top : 0,
					left : getRealWidth(0)
				})
				$('#' + bbl2Id).css({
					top : 20,
					left : getRealWidth(0) - 10
				})
			} else {
				$('#' + settings.id).css({
					left : p.left,
					top : p.top - getRealHeight(0)
				});
				$('#' + settings.id + ' .flst-msg').css({
					top : 0,
					left : 20
				})
				$('#' + bbl1Id).css(
						{
							top : 25 + $('#' + settings.id + ' .flst-msg')
									.outerHeight(),
							left : 0
						})
				$('#' + bbl2Id).css(
						{
							top : 0 + $('#' + settings.id + ' .flst-msg')
									.outerHeight(),
							left : 10
						})

			}

			if (settings.wizard && settings.autoscroll) {
				var ofTo = $(thisObj).offset().top;
				if ($(thisObj).offset().top > $('#' + settings.id).offset().top) {
					ofTo = $('#' + settings.id).offset().top
				}
				$('html, body').animate({
					scrollTop : ofTo
				}, 1000);

			}

		}
		function getRealHeight(offset) {
			return $('#' + settings.id + ' .flst-msg').outerHeight()
					+ $('#' + settings.id + ' #' + bbl1Id).outerHeight()
					+ $('#' + settings.id + ' #' + bbl2Id).outerHeight()
					+ offset;
		}
		function getRealWidth(offset) {
			return $('#' + settings.id + ' .flst-msg').outerWidth();
		}
		return this
	}
}(jQuery));

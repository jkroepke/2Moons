/**
 *  2Moons
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */

$(document).ready(function () {
	$(".tooltip").live({
		mouseenter : function (e) {
			var tip = $('#tooltip');
			tip.html($(this).attr('data-tooltip-content'));
			tip.show();
		},
		mouseleave : function () {
			var tip = $('#tooltip');
			tip.hide();
		},
		mousemove : function (e) {
			var tip = $('#tooltip');
			var mousex = e.pageX + 20;
			var mousey = e.pageY + 20;
			var tipWidth = tip.width();
			var tipHeight = tip.height();
			var tipVisX = $(window).width() - (mousex + tipWidth);
			var tipVisY = $(window).height() - (mousey + tipHeight);
			if (tipVisX < 20) {
				mousex = e.pageX - tipWidth - 20;
			};
			if (tipVisY < 20) {
				mousey = e.pageY - tipHeight - 20;
			};
			tip.css({
				top : mousey,
				left : mousex
			});
		}
	});
	$(".tooltip_sticky").live('mouseenter', function (e) {
		var tip = $('#tooltip');
		tip.html($(this).attr('data-tooltip-content'));
		tip.addClass('tooltip_sticky_div');
		tip.css({
			top : e.pageY - tip.outerHeight() / 2,
			left : e.pageX - tip.outerWidth() / 2
		});
		tip.show();
	});
	$(".tooltip_sticky_div").live('mouseleave', function () {
		var tip = $('#tooltip');
		tip.removeClass('tooltip_sticky_div');
		tip.hide();
	});
});
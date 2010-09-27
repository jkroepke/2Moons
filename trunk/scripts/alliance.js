$(function(){
	$('.bbcode').bbcodeeditor({
		bold:$('.bold'),italic:$('.italic'),underline:$('.underline'),link:$('.link'),quote:$('.quote'),code:$('.code'),image:$('.image'),
		usize:$('.usize'),dsize:$('.dsize'),blist:$('.blist'),litem:$('.litem'),
		back:$('.back'),forward:$('.forward'),back_disable:'btn back_disable',forward_disable:'btn forward_disable',
		exit_warning:true,preview:$('.preview')
	});
});
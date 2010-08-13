function add(){
	$("#battlesim").attr('action', '?page=battlesim&action=moreslots');
	$("#battlesim").attr('method', 'POST');
	$("#battlesim").submit();
	return true;
}

function check(){
	var kb = window.open("about:blank", "kb", "scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width="+(xsize-100)+",height="+(ysize-100)+",screenX="+((xsize-(xsize-100))/2)+",screenY="+((ysize-(ysize-100))/2)+",top="+((ysize-(ysize-100))/2)+",left="+((xsize-(xsize-100))/2));
	$("#submit:visible").removeAttr('style').hide().fadeOut();
	$("#wait:hidden").removeAttr('style').hide().fadeIn();
	$.post('?page=battlesim&action=send', $('#battlesim').serialize(), function(data){
		data	= $.trim(data);
		if(data.length == 32) {
			kb.focus();
			kb.location.href = 'CombatReport.php?raport='+data;
		} else {
			kb.window.close();
			alert(data);
		}
	});
	
	setTimeout(function(){$("#submit:hidden").removeAttr('style').hide().fadeIn();}, 10000);
	setTimeout(function(){$("#wait:visible").removeAttr('style').hide().fadeOut();}, 10000);
	return true;
}

$(function() {
	$("#tabs").tabs();

	var $tabs = $('#tabs').tabs({
		tabTemplate: '<li><a href="#{href}">#{label}</a></li>',
	});
});
function add(){
	$("#form").attr('action', 'game.php?page=battleSimulator&action=moreslots');
	$("#form").attr('method', 'POST');
	$("#form").submit();
	return true;
}

function check(){
	var kb = window.open('about:blank', 'kb', 'scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width='+screen.width+',height='+screen.height+', screenX=0, screenY=0, top=0, left=0');
	$("#submit:visible").removeAttr('style').hide().fadeOut();
	$("#wait:hidden").removeAttr('style').hide().fadeIn();
	$.post('game.php?page=battleSimulator&mode=send', $('#form').serialize(), function(data){
		try{ 
			data	= $.parseJSON(data);
			kb.focus();
			kb.location.href = 'CombatReport.php?raport='+data;
		} catch(e) {
			kb.window.close();
			Dialog.alert(data);
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
	
	$('.reset').live('click', function(e) {
		e.preventDefault();
	
		var index = $(this).parent().index();
		
		
		$(this).parent().parent().nextAll().each(function() {
			$(this).children('td:eq('+index+')').children().val(0);
		});
		return false;
	});
});
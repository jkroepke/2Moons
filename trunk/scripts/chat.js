var LastGet	= 0;
function addBBcode(bbcode){
	if(bbcode=='*URL*'){
		var link = window.prompt("Bitte geben sie einen Link ein:", "http://");
		var beschreibung = window.prompt("Bitte geben sie eine Beschreiben f&uuml;r den Link ein (optional):", "");
		if(beschreibung != ''){
		bbcode = '[url='+link+']'+beschreibung+'[/url]';
		} else {
		bbcode = '[url='+link+']'+link+'[/url]';	  
		}
    }
    $('#msg').val($('#msg').val() + bbcode);
    $('#msg').focus();
}

function check(){
	if($('#msg').val() == '') {
		alert('Gebe einen Text ein!');
	} else {
		$('#msg').val("[c="+$('#chat_color').val()+"]"+$('#msg').val()+"[/c]");
		$.get('game.php?page=chat&mode=send&ajax=1&'+$('#chatform').serialize());
		$('#msg').val("");
	}
	setTimeout("showMessage()", 500);
}

function showMessage(){
	$.getJSON('game.php?page=chat&mode=call&ajax=1&timestamp='+LastGet+'&'+$('#chatform').serialize(), function(data){
		var HTML	= '';
		$.each(data, function(id, mess) {
			HTML	+= '<div id="mess_'+id+'"; style="color:white;"><span style="font:menu;">';
			if(auth > 1)
				HTML	+= '<a href="javascript:del(\''+id+'\')\">[X]</a>';
			HTML	+= '['+mess.date+']</span> <span style="font:menu;font-weight:700">'+mess.name+'</span> : '+mess.mess+'</div>';
		});
		$('#shoutbox').html(HTML+$('#shoutbox').html());
		LastGet = serverTime.getTime() / 1000;
	});	
}

function del(id){
	$.get('game.php?page=chat&mode=delete&id='+id+'&ajax=1&'+$('#chatform').serialize());
	$('#mess_'+id).remove();
}

function addSmiley(smiley){  
	$('#msg').val($('#msg').val() + smiley);
	$('#msg').focus();
}

// Add Nick by Click
function addNick(obj){
	$('#msg').val($('#msg').val() + '[' + obj.innerText + ']');
	$('#msg').focus();
}
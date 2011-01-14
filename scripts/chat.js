var LastGet		= 0;
var GetMessages	= [];
function addBBcode(bbcode){
	if(bbcode=='*URL*'){
		var link = window.prompt(LNG_URL, "http://");
		var beschreibung = window.prompt(LNG_URLDesc, "");
		if(beschreibung != ''){
			bbcode = '[url='+link+']'+beschreibung+'[/url]';
		} else {
			bbcode = '[url='+link+']'+link+'[/url]';	  
		}
    }
    $('#msg').val($('#msg').val() + bbcode);
    $('#msg').focus();
}

function check(Message){
	if($('#msg').val() == '') {
		alert(LNG_NoText);
	} else {
		$('#msg').val("[c="+$('#chat_color').val()+"]"+$('#msg').val()+"[/c]");
		$.get('game.php?page=chat&mode=send&ajax=1&'+$('#chatform').serialize(), window.setTimeout(showMessage, 500));
		$('#msg').val("");
	}
}

function showMessage(){
	$.getJSON('game.php?page=chat&mode=call&ajax=1&timestamp='+LastGet+'&'+$('#chatform').serialize(), function(data){
		var HTML	= '';
		$.each(data, function(id, mess) {
			if($.inArray(id, GetMessages) != -1)
				return;
				
			GetMessages.push(id);
			var TEMP = '';
			TEMP	+= '<div id="mess_'+id+'"; style="color:white;"><span style="font:menu;">';
			if(auth > 1)
				TEMP	+= '<a href="javascript:del(\''+id+'\')\">[X]</a>';
			TEMP	+= '['+mess.date+']</span> <span style="font:menu;font-weight:700">'+mess.name+'</span> : '+mess.mess+'</div>';
			if($.browser.webkit || $.browser.opera)
				HTML = TEMP + HTML;
			else
				HTML += TEMP;
		});
		$('#shoutbox').html(HTML+$('#shoutbox').html());
		LastGet = serverTime.getTime() / 1000 - 1;
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
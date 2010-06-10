// * chat.js
// *
// * @version 2.0
// * @copyright 2008 by e-Zobar for XNova
// * @copyright 2010 by ShadoX for 2Moons


function addBBcode(bbcode){
	if( bbcode=='*URL*'){
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
		$.post('game.php?page=chat&mode=send&ajax=1', $('#chatform').serialize());
		$('#msg').val("");
	}
	setTimeout("showMessage()", 500);
}

function showMessage(){
	$.post("game.php?page=chat&mode=call&ajax=1", $('#chatform').serialize(), function(data){$('#shoutbox').html(data);});
}

function del(id){
	$.post("game.php?page=chat&mode=delete&id="+id+"&ajax=1", $('#chatform').serialize());
	setTimeout("showMessage()", 500);
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
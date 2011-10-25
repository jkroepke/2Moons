var resttime	= 0;
var time		= 0;
var endtime		= 0;
var interval	= 0;
var IsOldLink	= $('#buildlist').length;

function Buildlist() {
	var rest	= (endtime - (serverTime.getTime() / 1000));
	if (rest <= 0) {
		window.clearInterval(interval);
		$('#time').text(Ready);
		$('#command').remove();
		document.title	= Ready + ' - ' + Gamename;
		window.setTimeout(function() {window.location.href = 'game.php?page=buildings&mode=research'}, 1000);
		return true;
	}
	
	$('#time').text(GetRestTimeFormat(rest));
}

function CreateProcessbar() {
	if(time != 0) {
		$('#progressbar').progressbar({
			value: Math.max(100 - (resttime / time) * 100, 0.01)
		});
		$('.ui-progressbar-value').addClass('ui-corner-right').animate({width: "100%"}, resttime * 1000, "linear");
	}
}

$(document).ready(function() {
	time		= $('#time').attr('time');
	endtime		= $('.timer:first').attr('time');
	if(!IsOldLink) {
		resttime	= $('#progressbar').attr('time');
		window.setTimeout(CreateProcessbar, 5);
	}
	interval	= window.setInterval(Buildlist, 1000);
	Buildlist();
	return true;
});
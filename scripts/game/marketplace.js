var start = new Date().getTime() / 1000;

function Refrash() {
	var now = new Date().getTime() / 1000;
	$("[data-time]").each( function () {
		var d = $(this).attr('data-time');
		$(this).text(GetRestTimeFormat(d-(now-start)));
	});
}

$(document).ready(function() {
	interval	= window.setInterval(Refrash, 1000);
	Refrash();
});

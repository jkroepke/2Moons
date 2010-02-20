<script type="text/javascript">
function pretty_time_update(div) {

	var bocs 	= document.getElementById(div).innerHTML;
	var boc		= bocs.split(" ");
	var Stunde	= boc[0].replace(/h/g, "");
	var Minute	= boc[1].replace(/m/g, "");
	var Sekunde	= boc[2].replace(/s/g, "");
	
	if (Minute == 00 && Stunde != 00) {
		Stunde 	= Stunde - 1;
		Minute 	= 59;
		Sekunde = 59;
	}
	else {
		if (Sekunde == 00 && Minute != 00) {
			Minute 	= Minute - 1;
			Sekunde = 59;
		}
		else {
			Sekunde	= Sekunde - 1;
		}
	}
	if (Sekunde.toString().length < 2) {
		Sekunde = "0" + Sekunde;
	}	
	if (Minute.toString().length < 2) {
		Minute = "0" + Minute;
	}	
	if(Sekunde == 0 && Minute == 0 && Stunde == 0){
		document.getElementById(div).innerHTML = "Fertig";
		window.clearInterval('si_'+div);
	}
	else {
		document.getElementById(div).innerHTML = Stunde + "h "+Minute+"m "+Sekunde+"s";
	}
}
</script>
<div id='menu2'>
{planetmenulist}
</div>
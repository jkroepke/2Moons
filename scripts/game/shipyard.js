var v  			= new Date();

function ShipyardInit() {
	Shipyard		= data.Queue;
	Amount			= new DecimalNumber(Shipyard[0][1],0);
	hanger_id		= data.b_hangar_id_plus;
	$('#timeleft').text(data.pretty_time_b_hangar);
	ShipyardList();
	BuildlistShipyard();
	ShipyardInterval	= window.setInterval(BuildlistShipyard, 1000);
}

function BuildlistShipyard() {
	var n = new Date();
	var s = Shipyard[0][2] - hanger_id - Math.round((n.getTime() - v.getTime()) / 1000);
	var s = Math.round(s);
	var m = 0;
	var h = 0;
	if (s <= 0) {
		Amount.sub('1');
		$('#val_'+Shipyard[0][3]).text(function(i, old){
			return ' ('+bd_available+NumberGetHumanReadable(parseInt(old.replace(/.* (.*)\)/, '$1').replace(/\./, ''))+1)+')';
		})
		if (Amount.toString() == '0') {
			Shipyard.shift();
			if (Shipyard.length == 0) {
				$("#bx").html(Ready);
				document.getElementById('auftr').options[0] = new Option(Ready);
				document.location.href	= document.location.href;
				window.clearInterval(ShipyardInterval);
				return;
			}
			Amount = Amount.reset(Shipyard[0][1]);
			ShipyardList();
		} else {
			document.getElementById('auftr').options[0].innerHTML	= Amount.toString() + " " + Shipyard[0][0] + " " + bd_operating;
		}
		hanger_id = 0;
		v = new Date();
		s = 0;
	}
	$("#bx").html(Shipyard[0][0]+" "+GetRestTimeFormat(s));
}

function ShipyardList() {
	while (document.getElementById('auftr').length > 0)
		document.getElementById('auftr').options[document.getElementById('auftr').length - 1] = null;

	for (iv = 0; iv <= Shipyard.length - 1; iv++ ) {
		if(iv == 0)
			document.getElementById('auftr').options[iv] = new Option(Amount.toString()+ " " + Shipyard[iv][0] + " " + bd_operating, iv);
		else
			document.getElementById('auftr').options[iv] = new Option(Shipyard[iv][1]+ " " + Shipyard[iv][0] + " " + bd_operating, iv);
	}
}
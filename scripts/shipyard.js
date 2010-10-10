var v  			= new Date();
var z			= new DecimalNumber(data.a[0],0);
var p			= 0;
var element		= $("#bx");

function ShipyardInit() {
	hanger_id		= data.b_hangar_id_plus;
	$('#timeleft').text(data.pretty_time_b_hangar);
	ShipyardList();
	BuildlistShipyard();
}

function BuildlistShipyard() {
	var n = new Date();
	var s = data.c[p] - hanger_id - Math.round((n.getTime() - v.getTime()) / 1000);
	var s = Math.round(s);
	var m = 0;
	var h = 0;
	if (s <= 0) {
		z.sub('1');
		if (z.toString() == '0') {
			p++;
			z = z.reset(data.a[p]);
			ShipyardList();
		} else {
			document.getElementById('auftr').options[0].innerHTML	= z.toString() + " \"" + data.b[p] + "\" " + bd_operating;
		}
		hanger_id = 0;
		v = new Date();
		s = 0;
	}
	
	if ( p > data.b.length - 2 ) {
		element.html(ready);
		return;
    } else {
		element.html(data.b[p]+" "+GetRestTimeFormat(s));
		window.setTimeout("BuildlistShipyard();", 1000);
    }
}

function ShipyardList() {
	while (document.getElementById('auftr').length > 0) {
		document.getElementById('auftr').options[document.getElementById('auftr').length-1] = null;
	}
	if ( p > data.b.length - 2 ) {
		document.getElementById('auftr').options[document.getElementById('auftr').length] = new Option(ready);
	}
	for ( iv = p; iv <= data.b.length - 2; iv++ ) {
		if ( iv == p ) {
			document.getElementById('auftr').options[document.getElementById('auftr').length] = new Option(z.toString() + " \"" + data.b[iv] + "\" " + bd_operating, iv);
		} else {
			document.getElementById('auftr').options[document.getElementById('auftr').length] = new Option(data.a[iv] + " \"" + data.b[iv] + "\"", iv); 
		}
	}
}
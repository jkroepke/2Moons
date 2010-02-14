var v  = new Date();
var p  = 0;
var s  = 0;
var hs = 0;
var of = 1;
function t() {
	if ( hs == 0 ) {
		xd();
		hs = 1;
	}
	var n = new Date();
	var s = c[p] - hanger_id - Math.round((n.getTime() - v.getTime()) / 1000.);
	var s = Math.round(s);
	var m = 0;
	var h = 0;
	if ( s < 0 ) {
		a[p]--;
		xd();
		if ( a[p] <= 0 ) {
			p++;
			xd();
		}
		hanger_id = 0;
		v = new Date();
		s = 0;
	}
	if ( s > 59 ) {
		m = Math.floor(s / 60);
		s = s - m * 60;
	}
	if ( m > 59 ) {
		h = Math.floor(m / 60);
		m = m - h * 60;
	}
	if ( s < 10 ) {
		s = "0" + s;
    }
    if (m < 10) {
		m = "0" + m;
	}
	if ( p > b.length - 2 ) {
		$("#bx").html(ready);
    } else {
		$("#bx").html(b[p]+" "+h+":"+m+":"+s);
    }
	window.setTimeout("t();", 1000);
}

function xd() {
	while (document.getElementById('auftr').length > 0) {
		document.getElementById('auftr').options[document.getElementById('auftr').length-1] = null;
	}
	if ( p > b.length - 2 ) {
		document.getElementById('auftr').options[document.getElementById('auftr').length] = new Option(ready);
	}
	for ( iv = p; iv <= b.length - 2; iv++ ) {
		if ( a[iv] < 2 ) {
			ae = " ";
		} else {
			ae = " ";
		}
		if ( iv == p ) {
			act = " " + bd_operating;
		} else {
			act = "";
		}
		document.getElementById('auftr').options[document.getElementById('auftr').length] = new Option( a[iv] + ae + " \"" + b[iv] + "\"" + act, iv + of );
	}
}
//topnav.js
//RealTimeRessisanzeige for RN Framework
// @version 1.0
// @copyright 2010 by ShadoX

event	= new Date();

function update() {
	var now 	= new Date();
	var seconds = (Date.parse(now) - Date.parse(event)) / 1000;

	var metdone = (met_max <= met || isNaN(met)) ? Math.max(met_max, met) : ((met_hr / 3600) * res_factor * seconds + met);
	var crydone = (cry_max <= cry || isNaN(cry)) ? Math.max(cry_max, cry) : ((cry_hr / 3600) * res_factor * seconds + cry);
	var deudone = (deu_max <= deu || isNaN(deu)) ? Math.max(deu_max, deu) : ((deu_hr / 3600) * res_factor * seconds + deu);
	
	$("#current_metal").html(number_format(Math.round(metdone)));
	$("#current_crystal").html(number_format(Math.round(crydone)));
	$("#current_deuterium").html(number_format(Math.round(deudone)));

	window.setTimeout("update();",1000);
}
function number_format(n) {
    ns = String(n).replace('.', ',');
    var w = [];
    while (ns.length > 0) {
        var a = ns.length;
        if (a >= 3) {
            s = ns.substr(a - 3);
            ns = ns.substr(0, a - 3);
        } else {
            s = ns;
            ns = "";
        }
        w.push(s);
    }
    for (i = w.length - 1; i >= 0; i--) {
        ns += w[i] + ".";
    }
    ns = ns.substr(0, ns.length - 1);
    return ns.replace(/\.,/, ',');
}
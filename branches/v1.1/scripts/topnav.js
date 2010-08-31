//topnav.js
//RealTimeRessisanzeige for 2Moons
// @version 1.0
// @copyright 2010 by ShadoX

var event	= new Date();

function update()
{
	var now = new Date();
	var seconds	= (Date.parse(now) - Date.parse(event)) / 1000;
	if(met_max<=met||isNaN(met)) {
		$('#current_metal').addClass('res_current_max');
		$("#current_metal").html(number_format(removeE(Math.round(Math.max(met_max,met)))));
	} else {
		$("#current_metal").html(number_format(Math.max(Math.round((met_hr/3600)*seconds+met),0)));
	}
	
	if(cry_max<=cry||isNaN(cry)) {
		$('#current_crystal').addClass('res_current_max');
		$("#current_crystal").html(number_format(removeE(Math.round(Math.max(cry_max,cry)))));
	} else {
		$("#current_crystal").html(number_format(Math.max(Math.round((cry_hr/3600)*seconds+cry),0)));
	}
	
	if(deu_max<=deu||isNaN(deu)) {
		$('#current_deuterium').addClass('res_current_max');
		$("#current_deuterium").html(number_format(removeE(Math.round(Math.max(deu_max,deu)))));
	} else {
		$("#current_deuterium").html(number_format(Math.max(Math.round((deu_hr/3600)*seconds+deu),0)));
	}

	window.setTimeout("update();",1000);
}

function number_format(n){
	ns=String(n).replace('.',',');
	var w=[];
	while(ns.length>0){
		var a=ns.length;
		if(a>=3){
			s=ns.substr(a-3);ns=ns.substr(0,a-3);
		}else{
			s=ns;ns="";
		}
		w.push(s);
	}
	for(i=w.length-1;i>=0;i--)
	{
		ns+=w[i]+'.';
	}
	ns=ns.substr(0,ns.length-1);
	return ns.replace(/\.,/,',');
}
//topnav.js
//RealTimeRessisanzeige for 2Moons
// @version 1.0
// @copyright 2010 by ShadoX

var event=new Date();
function update()
{
	var now=new Date();
	var seconds=(Date.parse(now)-Date.parse(event))/1000;
	var metdone=(met_max<=met||isNaN(met))?ColorRed(number_format(Math.round(Math.max(met_max,met)).toPrecision(0))):number_format(Math.max(Math.round((met_hr/3600)*seconds+met),0));
	var crydone=(cry_max<=cry||isNaN(cry))?ColorRed(number_format(Math.round(Math.max(cry_max,cry)).toPrecision(0))):number_format(Math.max(Math.round((cry_hr/3600)*seconds+cry),0));
	var deudone=(deu_max<=deu||isNaN(deu))?ColorRed(number_format(Math.round(Math.max(deu_max,deu)).toPrecision(0))):number_format(Math.max(Math.round((deu_hr/3600)*seconds+deu),0));
	$("#current_metal").html(metdone);
	$("#current_crystal").html(crydone);
	$("#current_deuterium").html(deudone);
	window.setTimeout("update();",1000);
}
function number_format(n){
	n = n;
	ns=String(n).replace(thousands_sep,',');
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
		ns+=w[i]+thousands_sep;
	}
	ns=ns.substr(0,ns.length-1);
	return ns.replace(/\.,/,',');
}
function ColorRed(text){
	return'<font style="color:red";>'+text+'</font>';
}
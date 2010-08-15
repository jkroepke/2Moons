var xsize 	= screen.width;
var ysize 	= screen.height;
var breite	= 720;
var hoehe	= 300;
var xpos	= (xsize-breite) / 2;
var ypos	= (ysize-hoehe) / 2;

$(document).ready(function () {
	if($('#infobox').height() != null)
		$('#content').css("top", $('#infobox').height()+95+'px');
});

function var_dump(obj) {
   if(typeof obj == "object") {
      return "Type: "+typeof(obj)+((obj.constructor) ? "\nConstructor: "+obj.constructor : "")+"\nValue: " + obj;
   } else {
      return "Type: "+typeof(obj)+"\nValue: "+obj;
   }
}

function f(target_url, win_name) {
	var new_win = window.open(target_url+"&ajax=1", win_name, "scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width=720,height=300,screenX="+xpos+",screenY="+ypos+",top="+ypos+",left="+xpos);
	new_win.focus();
}

function playercard(target_url) {
	var playercard = window.open(target_url+"&ajax=1", "playercard", "scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width=640,height=510,screenX="+((xsize-640)/2)+",screenY="+((ysize-510)/2)+",top="+((ysize-510)/2)+",left="+((xsize-640)/2));
	playercard.focus();
}

function info(target_url) {
	var info = window.open("game.php?page=infos&gid="+ target_url+"&ajax=1", "info", "scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width=640,height=510,screenX="+((xsize-640)/2)+",screenY="+((ysize-510)/2)+",top="+((ysize-510)/2)+",left="+((xsize-640)/2));
	info.focus();
}

function kb(rid) {
    var combat = window.open("CombatReport.php?raport="+rid+"&ajax=1", "kb", "scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width="+(xsize-100)+",height="+(ysize-100)+",screenX="+((xsize-(xsize-100))/2)+",screenY="+((ysize-(ysize-100))/2)+",top="+((ysize-(ysize-100))/2)+",left="+((xsize-(xsize-100))/2));
	combat.focus();
}

function topkb(rid) {
    var combat = window.open("game.php?page=topkb&mode=showkb&rid="+rid+"&ajax=1", "kb", "scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width="+(xsize-100)+",height="+(ysize-100)+",screenX="+((xsize-(xsize-100))/2)+",screenY="+((ysize-(ysize-100))/2)+",top="+((ysize-(ysize-100))/2)+",left="+((xsize-(xsize-100))/2));
	combat.focus();
}

function allydiplo(action, id, level) {
	if(id != '0')
		var vid = "&id="+id;
	else
		var vid = "";
				
	if(level != '0')
		var vlevel = "&level="+level;
	else
		var vlevel = "";
		
    var allydiplo = window.open("game.php?page=alliance&mode=admin&edit=diplo&action="+action+vid+vlevel+"&ajax=1", "diplo", "scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width=720,height=300,screenX="+xpos+",screenY="+ypos+",top="+ypos+",left="+xpos);
	allydiplo.focus();
}

function pretty_time_update(div) {

	var bocs 	= $('#'+div).html();
	var boc		= bocs.split(' ');
	if(boc.length > 3)
	{
		var Tage	= boc[0].replace(/d/g, "");
		var Stunde	= boc[1].replace(/h/g, "");
		var Minute	= boc[2].replace(/m/g, "");
		var Sekunde	= boc[3].replace(/s/g, "");
		
		if (Stunde == 00 && Minute == 00 && Sekunde == 00 && Tage != 0) {
			Tage 	= Tage - 1;
			Stunde	= 23;
			Minute	= 59;
			Sekunde	= 59;
		}
		else 
		{
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
		}
		if (Sekunde.toString().length < 2) {
			Sekunde = "0" + Sekunde;
		}	
		if (Minute.toString().length < 2) {
			Minute = "0" + Minute;
		}	
		if(Sekunde == 0 && Minute == 0 && Stunde == 0 && Tage == 0){
			$('#'+div).html("Fertig");
			window.clearInterval('si_'+div);
		}
		else {
			$('#'+div).html(Tage + "d " + Stunde + "h "+Minute+"m "+Sekunde+"s");
		}
	} else {
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
			$('#'+div).html('Fertig');
			window.clearInterval('si_'+div);
		}
		else {
			$('#'+div).html(Stunde + 'h '+Minute+'m '+Sekunde+'s');
		}
	}
}

function ajax(datei, id) {
	$('#'+id).load(datei+'&ajax=1');
}

function Servertime(timestamp)
{
	stime = new Date(timestamp * 1000);
	hora = stime.getHours();
	min = stime.getMinutes();
	seg = stime.getSeconds();
	data = stime.getDate();
	weeks = stime.getDay();
	mez = stime.getMonth();
	ano = stime.getFullYear();
	if (seg < 10) { seg0 = "0"; }
	else { seg0 = ""; }
	if (min < 10) { min0 = "0"; }
	else { min0 = ""; }
	if (hora < 10) { hora0 = "0"; }
	else { hora0 = ""; }
	var Week = new Array("Son", "Mon", "Tue", "Wen", "Thr", "Fri", "Sat");
	var Month = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Mar", "Sep", "Oct", "Nov", "Dec");
	$("#servertime").text(Week[weeks] + " " + Month[mez] + " " + data + " " + hora0 + hora + ":" + min0 + min + ":" + seg0 + seg);
	timestamp++;
	window.setTimeout("Servertime("+timestamp+");",1000);	
}

function maxcount(id){
	var metmax = met / parseInt($('#metal_'+id).text().replace(/\./g,""));
	var crymax = cry / parseInt($('#crystal_'+id).text().replace(/\./g,""));
	var deumax = deu / parseInt($('#deuterium_'+id).text().replace(/\./g,""));
	if(isNaN(metmax) && isNaN(crymax) && isNaN(deumax))
		return 0;
	else if(isNaN(metmax) && isNaN(crymax))
		return removeE(Math.floor(deumax));
	else if(isNaN(metmax) && isNaN(deumax))
		return removeE(Math.floor(crymax));
	else if(isNaN(crymax) && isNaN(deumax))
		return removeE(Math.floor(metmax));
	else if(isNaN(metmax))
		return removeE(Math.floor(Math.min(crymax, deumax)));
	else if(isNaN(crymax))
		return removeE(Math.floor(Math.min(metmax, deumax)));
	else if(isNaN(deumax))
		return removeE(Math.floor(Math.min(metmax, crymax)));
	else
		return removeE(Math.floor(Math.min(metmax, Math.min(crymax, deumax))));
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

function removeE(Number) {
	Number	= String(Number);
	if(Number.search(/e\+/) == -1)
		return Number;
	
	var e = parseInt(Number.replace(/\S+.?e\+/g, ''));
	if(isNaN(e) || e == 0)
		return Number;
	else
		return parseFloat(Number).toPrecision(e+1);
}

function messages(ID)
{
	if(ID == 100) {
		$('#unread_0').text('0');
		$('#unread_1').text('0');
		$('#unread_2').text('0');
		$('#unread_3').text('0');
		$('#unread_4').text('0');
		$('#unread_5').text('0');
		$('#unread_15').text('0');
		$('#unread_99').text('0');
		$('#unread_100').text('0');
		$('#newmes').text('');
	} else {
		var count = parseInt($('#unread_'+ID).text());
		var lmnew = parseInt($('#newmesnum').text());
	
		$('#unread_'+ID).text('0');
		if(ID != 999) {
			$('#unread_100').text($('#unread_100').text() - count);
		}
		if(lmnew - count <= 0)
			$('#newmes').text('');
		else
			$('#newmesnum').text(lmnew - count);
	}
}
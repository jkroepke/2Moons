LocalizationStrings = new Array();
LocalizationStrings.timeunits = new Array();
LocalizationStrings.timeunits.short = new Array();
LocalizationStrings.timeunits.short.day = 't';
LocalizationStrings.timeunits.short.hour = 'h';
LocalizationStrings.timeunits.short.minute = 'm';
LocalizationStrings.timeunits.short.second = 's';
LocalizationStrings.status = new Array();

LocalizationStrings.decimalPoint = ",";
LocalizationStrings.thousandSeperator = ".";
LocalizationStrings.unitMega = 'M';
LocalizationStrings.unitKilo = 'K';
LocalizationStrings.unitMilliard = 'Mrd';

function OpenPopup(target_url, win_name, width, height) {
	var new_win = window.open(target_url+'&ajax=1', win_name, 'scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width='+width+',height='+height+',screenX='+((screen.width-width) / 2)+",screenY="+((screen.height-height) / 2)+",top="+((screen.height-height) / 2)+",left="+((screen.width-width) / 2));
	new_win.focus();
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
		
    OpenPopup("game.php?page=alliance&mode=admin&edit=diplo&action="+action+vid+vlevel+"&ajax=1", "diplo", 720, 300);
}


function ajax(datei, id) {
	$('#'+id).load(datei+'&ajax=1');
}

function maxcount(id){
	var metmax = parseInt($('#current_metal').text().replace(/\./g, '')) / parseInt($('#metal_'+id).text().replace(/\./g,""));
	var crymax = parseInt($('#current_crystal').text().replace(/\./g, '')) / parseInt($('#crystal_'+id).text().replace(/\./g,""));
	var deumax = parseInt($('#current_deuterium').text().replace(/\./g, '')) / parseInt($('#deuterium_'+id).text().replace(/\./g,""));
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
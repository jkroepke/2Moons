var acstime = 0;
	
function updateVars()
{
	document.getElementsByName("fleet_group")[0].value = 0;
	dataFlyDistance = GetDistance();
	dataFlyTime = GetDuration();
	dataFlyConsumption = GetConsumption();
	dataFlyCargoSpace = storage();
	refreshFormData();
}

function GetDistance() {
	var thisGalaxy = data.planet.galaxy;
	var thisSystem = data.planet.system;
	var thisPlanet = data.planet.planet;
	var targetGalaxy = document.getElementsByName("galaxy")[0].value;
	var targetSystem = document.getElementsByName("system")[0].value;
	var targetPlanet = document.getElementsByName("planet")[0].value;

	if (targetGalaxy - thisGalaxy != 0) {
		return Math.abs(targetGalaxy - thisGalaxy) * 20000;
	} else if (targetSystem - thisSystem != 0) {
		return Math.abs(targetSystem - thisSystem) * 5 * 19 + 2700;
	} else if (targetPlanet - thisPlanet != 0) {
		return Math.abs(targetPlanet - thisPlanet) * 5 + 1000;
	} else {
		return 5;
	}
}

function GetDuration() {
	var sp = document.getElementsByName("speed")[0].value;
	return Math.max(Math.round((3500 / (sp * 0.1) * Math.pow(dataFlyDistance * 10 / data.maxspeed, 0.5) + 10) / data.gamespeed) * data.fleetspeedfactor, data.fleetMinDuration);
}

function GetConsumption() {
	var dataFlyConsumption = 0;
	var dataFlyConsumption2 = 0;
	var basicConsumption = 0;
	var i;
	$.each(data.ships, function(shipid, ship){
		spd = 35000 / (dataFlyTime * data.gamespeed - 10) * Math.sqrt(dataFlyDistance * 10 / ship.speed);
		basicConsumption = ship.consumption * ship.amount;
		dataFlyConsumption2 += basicConsumption * dataFlyDistance / 35000 * (spd / 10 + 1) * (spd / 10 + 1);
	});
	return Math.round(dataFlyConsumption + dataFlyConsumption2) + 1;
}

function storage() {
	return data.fleetroom - dataFlyConsumption;
}

function refreshFormData() {
	var seconds = dataFlyTime;
	var hours = Math.floor(seconds / 3600);
	seconds -= hours * 3600;
	var minutes = Math.floor(seconds / 60);
	seconds -= minutes * 60;
	$("#duration").text(hours + (":" + dezInt(minutes, 2) + ":" + dezInt(seconds,2) + " h"));
	$("#distance").text(NumberGetHumanReadable(dataFlyDistance));
	$("#maxspeed").text(NumberGetHumanReadable(data.maxspeed));
	if (dataFlyCargoSpace >= 0) {
		$("#consumption").html("<font color=\"lime\">" + NumberGetHumanReadable(dataFlyConsumption) + "</font>");
		$("#storage").html("<font color=\"lime\">" + NumberGetHumanReadable(dataFlyCargoSpace) + "</font>");
	} else {
		$("#consumption").html("<font color=\"red\">" + NumberGetHumanReadable(dataFlyConsumption) + "</font>");
		$("#storage").html("<font color=\"red\">" + NumberGetHumanReadable(dataFlyCargoSpace) + "</font>");
	}
}

function setACSTarget(galaxy, solarsystem, planet, type, tacs) {
	setTarget(galaxy, solarsystem, planet, type);
	updateVars();
	document.getElementsByName("fleet_group")[0].value = tacs;
}

function setTarget(galaxy, solarsystem, planet, type) {
	document.getElementsByName("galaxy")[0].value = galaxy;
	document.getElementsByName("system")[0].value = solarsystem;
	document.getElementsByName("planet")[0].value = planet;
	document.getElementsByName("type")[0].value = type;
}

function FleetTime(){ 
	var sekunden = serverTime.getSeconds();
	var starttime = dataFlyTime;
	var endtime	= starttime + dataFlyTime;
	$("#arrival").html(getFormatedDate(serverTime.getTime()+1000*starttime, tdformat));
	$("#return").html(getFormatedDate(serverTime.getTime()+1000*endtime, tdformat));
}

function setResource(id, val) {
	if (document.getElementsByName(id)[0]) {
		document.getElementsByName("resource" + id)[0].value = val;
	}
}

function maxResource(id) {
	var thisresource = getRessource(id);
	var thisresourcechosen = parseInt(document.getElementsByName(id)[0].value);
	if (isNaN(thisresourcechosen)) {
		thisresourcechosen = 0;
	}
	if (isNaN(thisresource)) {
		thisresource = 0;
	}
	
	var storCap = data.fleetroom - data.consumption;

	if (id == 'deuterium') {
		thisresource -= data.consumption;
	}
	var metalToTransport = parseInt(document.getElementsByName("metal")[0].value);
	var crystalToTransport = parseInt(document.getElementsByName("crystal")[0].value);
	var deuteriumToTransport = parseInt(document.getElementsByName("deuterium")[0].value);
	if (isNaN(metalToTransport)) {
		metalToTransport = 0;
	}
	if (isNaN(crystalToTransport)) {
		crystalToTransport = 0;
	}
	if (isNaN(deuteriumToTransport)) {
		deuteriumToTransport = 0;
	}
	var freeCapacity = Math.max(storCap - metalToTransport - crystalToTransport - deuteriumToTransport, 0);
	document.getElementsByName(id)[0].value = Math.min(freeCapacity + thisresourcechosen, thisresource);
	calculateTransportCapacity();
}


function maxResources() {
	maxResource('metal');
	maxResource('crystal');
	maxResource('deuterium');
}

function calculateTransportCapacity() {
	var metal = Math.abs(document.getElementsByName("metal")[0].value);
	var crystal = Math.abs(document.getElementsByName("crystal")[0].value);
	var deuterium = Math.abs(document.getElementsByName("deuterium")[0].value);
	transportCapacity = data.fleetroom - data.consumption - metal - crystal - deuterium;
	if (transportCapacity < 0) {
		document.getElementById("remainingresources").innerHTML = "<font color=red>" + NumberGetHumanReadable(transportCapacity) + "</font>";
	} else {
		document.getElementById("remainingresources").innerHTML = "<font color=lime>" + NumberGetHumanReadable(transportCapacity) + "</font>";
	}
	return transportCapacity;
}

function maxShip(id) {
	if (document.getElementsByName(id)[0]) {
		var amount = document.getElementById(id + "_value").innerHTML;
		document.getElementsByName(id)[0].value = amount.replace(/\./g, "");
	}
}

function maxShips() {
	var id;
	$('input[name^="ship"]').each(function() {
		maxShip($(this).attr('name'));
	})
}


function noShip(id) {
	if (document.getElementsByName(id)[0]) {
		document.getElementsByName(id)[0].value = 0;
	}
}


function noShips() {
	var id;
	$('input[name^="ship"]').each(function() {
		noShip($(this).attr('name'));
	});
}

function setNumber(name, number) {
	if (typeof document.getElementsByName("ship" + name)[0] != "undefined") {
		document.getElementsByName("ship" + name)[0].value = number;
	}
}

function CheckTarget()
{
	kolo	= (typeof data.ships[208] == "object") ? 1 : 0;
		
	$.getJSON('game.php?page=fleetStep1&mode=checkTarget&galaxy='+document.getElementsByName("galaxy")[0].value+'&system='+document.getElementsByName("system")[0].value+'&planet='+document.getElementsByName("planet")[0].value+'&planet_type='+document.getElementsByName("type")[0].value+'&lang='+Lang+'&kolo='+kolo, function(data) {
		if(data == "OK") {
			document.getElementById('form').submit();
		} else {
			NotifyBox(data);
		}
	});
	return false;
}

function EditShortcuts(autoadd) {
	$(".shortcut-link").hide();
	$(".shortcut-edit:not(.shortcut-new)").show();
	if($('.shortcut-isset').length === 0)
		AddShortcuts();
}

function AddShortcuts() {
	var HTML	= $('.shortcut-new td:first').clone().children();
	HTML.find('input, select').attr('name', function(i, old) {
		return old.replace("shortcut[]", "shortcut["+($('.shortcut-link').length)+"-new]");
	});
	
	var nextFreeColum	= $('.shortcut-row:last td:not(.shortcut-isset):first');
	
	if(nextFreeColum.length == 0) {
		if($('.shortcut-row:last').length)
		{
			var newRow			= $('<tr />').addClass('shortcut-row').insertAfter('.shortcut-row:last');
			for (var i = 1; i <= shortCutRows; i++) {
				newRow.append('<td class="shortcut-colum" style="width:'+(100 / shortCutRows)+'%">&nbsp</td>');
			}
			
			var nextFreeColum	= $('.shortcut-row:last td:first');
		} else {
			var newRow			= $('<tr />').addClass('shortcut-row').insertAfter('.shortcut-none');
			for (var i = 1; i <= shortCutRows; i++) {
				newRow.append('<td class="shortcut-colum" style="width:'+(100 / shortCutRows)+'%">&nbsp;</td>');
			}
			
			var nextFreeColum	= $('.shortcut-row:last td:first');
			$('.shortcut-none').remove();
		}
	}
	
	nextFreeColum.html(HTML).addClass("shortcut-isset");
}

function SaveShortcuts(reedit) {		
	$.getJSON('game.php?page=fleetStep1&mode=saveShortcuts&ajax=1&'+$('.shortcut-row').find("input, select").serialize(), function(res) {
		$(".shortcut-link").show();
		$(".shortcut-edit").hide();		
		
		var deadElements	= $(".shortcut-isset").filter(function() {
			return $('input[name*=name]', this).val() == "" ||
			$('input[name*=galaxy]', this).val() == "" || $('input[name*=galaxy]', this).val() == 0 ||
			$('input[name*=system]', this).val() == "" || $('input[name*=system]', this).val() == 0 ||
			$('input[name*=planet]', this).val() == "" || $('input[name*=planet]', this).val() == 0;
		});
		
		if(deadElements.length % 2 === 1) {
			deadElements.remove();
			$(".shortcut-colum:last").after('<td class="shortcut-colum" style="width:'+(100 / shortCutRows)+'%">&nbsp;</td>');
		}
		
		$(".shortcut-isset").unwrap();
		
		var activeElements	= Math.ceil($(".shortcut-isset").length / shortCutRows);
		
		if(activeElements === 0) {
			$('<tr style="height:20px;" class="shortcut-none"><td colspan="'+shortCutRows+'">'+fl_no_shortcuts+'</td></tr>').insertAfter('.shortcut tr:first');
		} else {
			for (var i = 1; i <= activeElements; i++) {
				$('<tr />').addClass('shortcut-row').insertAfter('.shortcut tr:first');
			}
			
			$(".shortcut-colum").each(function(i, val) {
				$(this).appendTo('tr.shortcut-row:eq('+Math.floor(i / 3)+')');
			});
			
			$('.shortcut-colum').filter(function() {
				return $(this).parent().is(':not(tr)')
			}).remove();
			
			$('.shortcut-row').filter(function() {
				return !$(this).children('.shortcut-isset').length;
			}).remove();
			
			$(".shortcut-isset > .shortcut-link").html(function() {
				if($(this).nextAll().find('input[name*=name]').val() === "") {
					$(this).parent().html("&nbsp;");
					return false;
				}
				var Data	= $(this).nextAll();
				return '<a href="javascript:setTarget('+Data.find('input[name*=galaxy]').val()+','+Data.find('input[name*=system]').val()+','+Data.find('input[name*=planet]').val()+','+Data.find('select[name*=type]').val()+');updateVars();">'+Data.find('input[name*=name]').val()+'('+Data.nextAll().find('select[name*=type] option:selected').text()[0]+') ['+Data.find('input[name*=galaxy]').val()+':'+Data.find('input[name*=system]').val()+':'+Data.find('input[name*=planet]').val()+']</a>';
			});
		}
		
		$('.shortcut-row:has(td:not(.shortcut-isset) + td)').remove();
			
		if(typeof reedit === "undefinded" || reedit !== true) {
			NotifyBox(res);
		} else {
			if($(".shortcut-isset").length) {
				EditShortcuts();
			}
		}
	});
}

$(function() {
	$('.shortcut-delete').live('click', function() {
		$(this).prev().val('');
		$(this).parent().find('input');
		SaveShortcuts(true);
	});
});
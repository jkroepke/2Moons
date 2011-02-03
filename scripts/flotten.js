function updateVars()
{
	distance = GetDistance();
	duration = GetDuration();
	consumption = GetConsumption();
	cargoSpace = storage();

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
	return Math.max(Math.round((3500 / (sp * 0.1) * Math.pow(distance * 10 / data.maxspeed, 0.5) + 10) * data.fleetspeedfactor / data.gamespeed), 5);
}

function GetConsumption() {
	var consumption = 0;
	var basicConsumption = 0;
	var i;
	$.each(data.ships, function(shipid, ship){
		spd = 35000 / (duration * data.gamespeed - 10) * Math.sqrt(distance * 10 / ship.speed);
		basicConsumption = ship.consumption * ship.amount;
		consumption += basicConsumption * distance / 35000 * (spd / 10 + 1) * (spd / 10 + 1);
	});
	return Math.round(consumption) + 1;
}

function storage() {
	return data.fleetroom - consumption;
}

function refreshFormData() {
	var seconds = duration;
	var hours = Math.floor(seconds / 3600);
	seconds -= hours * 3600;
	var minutes = Math.floor(seconds / 60);
	seconds -= minutes * 60;
	$("#duration").text(hours + (":" + dezInt(minutes, 2) + ":" + dezInt(seconds,2) + " h"));
	$("#distance").text(NumberGetHumanReadable(distance));
	$("#maxspeed").text(NumberGetHumanReadable(data.maxspeed));
	if (cargoSpace >= 0) {
		$("#consumption").html("<font color=\"lime\">" + NumberGetHumanReadable(consumption) + "</font>");
		$("#storage").html("<font color=\"lime\">" + NumberGetHumanReadable(cargoSpace) + "</font>");
	} else {
		$("#consumption").html("<font color=\"red\">" + NumberGetHumanReadable(consumption) + "</font>");
		$("#storage").html("<font color=\"red\">" + NumberGetHumanReadable(cargoSpace) + "</font>");
	}
}

function setACSTarget(galaxy, solarsystem, planet, planettype, tacs) {
	document.getElementsByName("fleet_group")[0].value = tacs;
	setTarget(galaxy, solarsystem, planet, planettype);
}


function setTarget(galaxy, solarsystem, planet, planettype) {
	document.getElementsByName("galaxy")[0].value = galaxy;
	document.getElementsByName("system")[0].value = solarsystem;
	document.getElementsByName("planet")[0].value = planet;
	document.getElementsByName("planettype")[0].value = planettype;
}

function FleetTime(){ 
	var Sekunden = serverTime.getSeconds();
    var add = duration;
    serverTime.setSeconds(Sekunden+0.5);
	$("#arrival").html(getFormatedDate(serverTime.getTime()+1000*add, '[d].[m].[y] [G]:[i]:[s]'));
	$("#return").html(getFormatedDate(serverTime.getTime()+1000*2*add, '[d].[m].[y] [G]:[i]:[s]'));
}

function setResource(id, val) {
	if (document.getElementsByName(id)[0]) {
		document.getElementsByName("resource" + id)[0].value = val;
	}
}

function maxResource(id) {
	var thisresource = parseInt($('#current_'+id).text().replace(/\./g, ''));
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
	for (i = 200; i < 250; i++) {
		id = "ship" + i;
		maxShip(id);
	}
}


function noShip(id) {
	if (document.getElementsByName(id)[0]) {
		document.getElementsByName(id)[0].value = 0;
	}
}


function noShips() {
	var id;
	for (i = 200; i < 250; i++) {
		id = "ship" + i;
		noShip(id);
	}
}

function setNumber(name, number) {
	if (typeof document.getElementsByName("ship" + name)[0] != "undefined") {
		document.getElementsByName("ship" + name)[0].value = number;
	}
}

function CheckTarget()
{
	kolo	= (typeof data.ships[208] == "object") ? 1 : 0;
		
	$.get('ajax.php?action=fleet1&galaxy='+document.getElementsByName("galaxy")[0].value+'&system='+document.getElementsByName("system")[0].value+'&planet='+document.getElementsByName("planet")[0].value+'&planet_type='+document.getElementsByName("planettype")[0].value+'&lang='+Lang+'&kolo='+kolo, function(data) {
		if($.trim(data) == "OK") {
			document.getElementById('form').submit();
		} else {
			fadeBox(data, true);
		}
	});
	return false;
}
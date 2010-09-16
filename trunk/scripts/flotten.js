function updateVars()
{
	distance = GetDistance();
	duration = GetDuration();
	consumption = GetConsumption();
	cargoSpace = storage();

	refreshFormData();
}

function GetDistance() {
	var thisGalaxy = document.getElementsByName("thisgalaxy")[0].value;
	var thisSystem = document.getElementsByName("thissystem")[0].value;
	var thisPlanet = document.getElementsByName("thisplanet")[0].value;
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
	var speedfactor = document.getElementsByName("speedfactor")[0].value;
	var fleetspeedfactor = document.getElementsByName("fleetspeedfactor")[0].value;
	var msp = document.getElementsByName("speedallsmin")[0].value;
	var sp = document.getElementsByName("speed")[0].value;
	return Math.max(Math.round((3500 / (sp * 0.1) * Math.pow(distance * 10 / msp, 0.5) + 10) * fleetspeedfactor / speedfactor), 5);
}

function GetConsumption() {
	var consumption = 0;
	var basicConsumption = 0;
	var i;
	var msp = document.getElementsByName("speedallsmin")[0].value;
	var speedfactor = document.getElementsByName("speedfactor")[0].value;
	for (i = 200; i < 250; i++) {
		if (document.getElementsByName("ship" + i)[0]) {
			shipspeed = document.getElementsByName("speed" + i)[0].value;
			spd = 35000 / (duration * speedfactor - 10) * Math.sqrt(distance * 10 / shipspeed);
			basicConsumption = document.getElementsByName("consumption" + i)[0].value * document.getElementsByName("ship" + i)[0].value;
			consumption += basicConsumption * distance / 35000 * (spd / 10 + 1) * (spd / 10 + 1);
		}
	}
	return Math.round(consumption) + 1;
}

function storage() {
	return document.getElementsByName("fleetroom")[0].value - consumption;
}

function refreshFormData() {
	$("#distance").html(number_format(distance));
	var seconds = duration;
	var hours = Math.floor(seconds / 3600);
	seconds -= hours * 3600;
	var minutes = Math.floor(seconds / 60);
	seconds -= minutes * 60;
	if (minutes < 10) {
		minutes = "0" + minutes;
	}
	if (seconds < 10) {
		seconds = "0" + seconds;
	}
	$("#duration").html(hours + (":" + minutes + ":" + seconds + " h"));
	$("#maxspeed").html(number_format(document.getElementsByName("speedallsmin")[0].value));
	if (cargoSpace >= 0) {
		$("#consumption").html("<font color=\"lime\">" + number_format(consumption) + "</font>");
		$("#storage").html("<font color=\"lime\">" + number_format(cargoSpace) + "</font>");
	} else {
		$("#consumption").html("<font color=\"red\">" + number_format(consumption) + "</font>");
		$("#storage").html("<font color=\"red\">" + number_format(cargoSpace) + "</font>");
	}
}

function setACS_target(tacs) {
	document.getElementsByName("acs_target_mr")[0].value = tacs;
}


function setTarget(galaxy, solarsystem, planet, planettype) {
	document.getElementsByName("galaxy")[0].value = galaxy;
	document.getElementsByName("system")[0].value = solarsystem;
	document.getElementsByName("planet")[0].value = planet;
	document.getElementsByName("planettype")[0].value = planettype;
}

function FleetTime()
{ 
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
	var thisresource = parseInt(document.getElementsByName("thisresource" + id)[0].value);
	var thisresourcechosen = parseInt(document.getElementsByName("resource" + id)[0].value);
	if (isNaN(thisresourcechosen)) {
		thisresourcechosen = 0;
	}
	if (isNaN(thisresource)) {
		thisresource = 0;
	}
	var storCap = document.getElementsByName("fleetroom")[0].value - document.getElementsByName("consumption")[0].value;
	if (id == 3) {
		thisresource -= document.getElementsByName("consumption")[0].value;
	}
	var metalToTransport = parseInt(document.getElementsByName("resource1")[0].value);
	var crystalToTransport = parseInt(document.getElementsByName("resource2")[0].value);
	var deuteriumToTransport = parseInt(document.getElementsByName("resource3")[0].value);
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
	var cargo = Math.min(freeCapacity + thisresourcechosen, thisresource);
	if (document.getElementsByName("resource" + id)[0]) {
		document.getElementsByName("resource" + id)[0].value = cargo;
	}
	calculateTransportCapacity();
}


function maxResources() {
	var id;
	var storCap = document.getElementsByName("fleetroom")[0].value - document.getElementsByName("consumption")[0].value;
	var metalToTransport = document.getElementsByName("thisresource1")[0].value;
	var crystalToTransport = document.getElementsByName("thisresource2")[0].value;
	var deuteriumToTransport = document.getElementsByName("thisresource3")[0].value - document.getElementsByName("consumption")[0].value;
	var freeCapacity = storCap - metalToTransport - crystalToTransport - deuteriumToTransport;
	if (freeCapacity < 0) {
		metalToTransport = Math.min(metalToTransport, storCap);
		crystalToTransport = Math.min(crystalToTransport, storCap - metalToTransport);
		deuteriumToTransport = Math.min(deuteriumToTransport, storCap - metalToTransport - crystalToTransport);
	}
	document.getElementsByName("resource1")[0].value = Math.max(metalToTransport, 0);
	document.getElementsByName("resource2")[0].value = Math.max(crystalToTransport, 0);
	document.getElementsByName("resource3")[0].value = Math.max(deuteriumToTransport, 0);
	calculateTransportCapacity();
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

function calculateTransportCapacity() {
	var metal = Math.abs(document.getElementsByName("resource1")[0].value);
	var crystal = Math.abs(document.getElementsByName("resource2")[0].value);
	var deuterium = Math.abs(document.getElementsByName("resource3")[0].value);
	transportCapacity = document.getElementsByName("fleetroom")[0].value - document.getElementsByName("consumption")[0].value - metal - crystal - deuterium;
	if (transportCapacity < 0) {
		document.getElementById("remainingresources").innerHTML = "<font color=red>" + transportCapacity + "</font>";
	} else {
		document.getElementById("remainingresources").innerHTML = "<font color=lime>" + transportCapacity + "</font>";
	}
	return transportCapacity;
}

function setNumber(name, number) {
	if (typeof document.getElementsByName("ship" + name)[0] != "undefined") {
		document.getElementsByName("ship" + name)[0].value = number;
	}
}

function CheckTarget()
{
	$.get('game.php?page=fleet1&mode=valid&galaxy'+document.getElementsByName("galaxy")[0].value+'&system='+document.getElementsByName("system")[0].value+'&planet='+document.getElementsByName("planet")[0].value+'&planet_type='+document.getElementsByName("planettype")[0].value, function(data)
	{
		if(data == "OK") {
			document.getElementById('form').submit();
		} else {
			fadeBox(data, true);
		}
	})
	return false;
}
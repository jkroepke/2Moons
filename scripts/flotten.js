function speed() {
	return document.getElementsByName("speed")[0].value;
}


function target() {
	var galaxy = document.getElementsByName("galaxy")[0].value;
	var system = document.getElementsByName("system")[0].value;
	var planet = document.getElementsByName("planet")[0].value;
	return "[" + galaxy + ":" + system + ":" + planet + "]";
}


function setACS(id) {
	document.getElementsByName("fleet_group")[0].value = id;
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


function setMission(mission) {
	document.getElementsByName("order")[0].selectedIndex = mission;
}


function setUnion(unionid) {
	document.getElementsByName("union2")[0].selectedIndex = unionid;
}


function setTargetLong(galaxy, solarsystem, planet, planettype, mission, cnt) {
	setTarget(galaxy, solarsystem, planet, planettype);
	setMission(mission);
	setUnions(cnt);
}

function maxspeed() {
	var msp = document.getElementsByName("speedallsmin")[0].value;
	var speeds = 
	return msp / 10 * speed();
}


function distance() {
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


function duration() {
	var speedfactor = document.getElementsByName("speedfactor")[0].value;
	var fleetspeedfactor = document.getElementsByName("fleetspeedfactor")[0].value;
	var msp = maxspeed();
	var sp = speed();
	var dist = distance();
	return Math.max(Math.round((3500 / (sp * 0.1) * Math.pow(dist * 10 / msp, 0.5) + 10) * fleetspeedfactor / speedfactor), 5);
}


function consumption() {
	var consumption = 0;
	var basicConsumption = 0;
	var i;
	var msp = maxspeed();
	var dist = distance();
	var dur = duration();
	speedfactor = document.getElementsByName("speedfactor")[0].value;
	for (i = 200; i < 250; i++) {
		if (document.getElementsByName("ship" + i)[0]) {
			shipspeed = document.getElementsByName("speed" + i)[0].value;
			spd = 35000 / (dur * speedfactor - 10) * Math.sqrt(dist * 10 / shipspeed);
			basicConsumption = document.getElementsByName("consumption" + i)[0].value * document.getElementsByName("ship" + i)[0].value;
			consumption += basicConsumption * dist / 35000 * (spd / 10 + 1) * (spd / 10 + 1);
		}
	}
	return Math.round(consumption) + 1;
}

function storage() {
	return document.getElementsByName("fleetroom")[0].value - consumption();
}

function fleetInfo() {
	document.getElementById("speed").innerHTML = speed() * 10 + "%";
	document.getElementById("target").innerHTML = target();
	document.getElementById("distance").innerHTML = distance();
	var seconds = duration();
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
	document.getElementById("duration").innerHTML = hours + (":" + minutes + ":" + seconds + " h");
	var stor = storage();
	var cons = consumption();
	document.getElementById("maxspeed").innerHTML = number_format(maxspeed());
	if (stor >= 0) {
		document.getElementById("consumption").innerHTML = "<font color=\"lime\">" + cons + "</font>";
		document.getElementById("storage").innerHTML = "<font color=\"lime\">" + stor + "</font>";
	} else {
		document.getElementById("consumption").innerHTML = "<font color=\"red\">" + cons + "</font>";
		document.getElementById("storage").innerHTML = "<font color=\"red\">" + stor + "</font>";
	}
	calculateTransportCapacity();
}


function shortInfo() {
	document.getElementById("distance").innerHTML = number_format(distance());
	var seconds = duration();
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
	document.getElementById("duration").innerHTML = hours + (":" + minutes + ":" + seconds + " h");
	var stor = storage();
	var cons = consumption();
	document.getElementById("maxspeed").innerHTML = number_format(maxspeed());
	if (stor >= 0) {
		document.getElementById("consumption").innerHTML = "<font color=\"lime\">" + number_format(cons) + "</font>";
		document.getElementById("storage").innerHTML = "<font color=\"lime\">" + number_format(stor) + "</font>";
	} else {
		document.getElementById("consumption").innerHTML = "<font color=\"red\">" + number_format(cons) + "</font>";
		document.getElementById("storage").innerHTML = "<font color=\"red\">" + number_format(stor) + "</font>";
	}
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
		document.getElementsByName(id)[0].value = amount.replace(/\./g, "").replace(/\ /g, "").replace(/\,/g, "");
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


function getLayerRef(id, document) {
	if (!document) {
		document = window.document;
	}
	if (document.layers) {
		for (var l = 0; l < document.layers.length; l++) {
			if (document.layers[l].id == id) {
				return document.layers[l];
			}
		}
		for (var l = 0; l < document.layers.length; l++) {
			var result = getLayerRef(id, document.layers[l].document);
			if (result) {
				return result;
			}
		}
		return null;
	} else if (document.all) {
		return document.all[id];
	} else if (document.getElementById) {
		return document.getElementById(id);
	}
}


function setVisibility(objLayer, visible) {
	if (document.layers) {
		objLayer.visibility = visible == true ? "show" : "hide";
	} else {
		objLayer.style.visibility = visible == true ? "visible" : "hidden";
	}
}


function setVisibilityForDivByPrefix(prefix, visible, d) {
	if (!d) {
		d = window.document;
	}
	if (document.layers) {
		for (var i = 0; i < d.layers.length; i++) {
			if (d.layers[i].id.substr(0, prefix.length) == prefix) {
				setVisibility(d.layers[l], visible);
			}
			setVisibilityForDivByPrefix(prefix, visible, d.layers[i].document);
		}
	} else if (document.all) {
		var layers = document.all.tags("div");
		for (i = 0; i < layers.length; i++) {
			if (layers[i].id.substr(0, prefix.length) == prefix) {
				setVisibility(document.all.tags("div")[i].visible);
			}
		}
	} else if (document.getElementsByTagName) {
		var layers = document.getElementsByTagName("div");
		for (i = 0; i < layers.length; i++) {
			if (layers[i].id.substr(0, prefix.length) == prefix) {
				setVisibility(layers[i].visible);
			}
		}
	}
}


function setPlanet(string) {
	var splitstring = string.split(":");
	document.getElementsByName("galaxy")[0].value = splitstring[0];
	document.getElementsByName("system")[0].value = splitstring[1];
	document.getElementsByName("planet")[0].value = splitstring[2];
	document.getElementsByName("planettype")[0].value = splitstring[3];
	setMission(splitstring[4]);
}


function setUnions(cnt) {
	galaxy = document.getElementsByName("galaxy")[0].value;
	system = document.getElementsByName("system")[0].value;
	planet = document.getElementsByName("planet")[0].value;
	planettype = document.getElementsByName("planettype")[0].value;
	thisgalaxy = document.getElementsByName("thisgalaxy")[0].value;
	thissystem = document.getElementsByName("thissystem")[0].value;
	thisplanet = document.getElementsByName("thisplanet")[0].value;
	thisplanettype = document.getElementsByName("thisplanettype")[0].value;
	spd = document.getElementsByName("speed")[0].value;
	speedfactor = document.getElementsByName("speedfactor")[0].value;
	for (i = 0; i < cnt; i++) {
		var string = document.getElementById("union" + i).innerHTML;
		time = document.getElementsByName("union" + i + "time")[0].value;
		targetgalaxy = document.getElementsByName("union" + i + "galaxy")[0].value;
		targetsystem = document.getElementsByName("union" + i + "system")[0].value;
		targetplanet = document.getElementsByName("union" + i + "planet")[0].value;
		targetplanettype = document.getElementsByName("union" + i + "planettype")[0].value;
		if (targetgalaxy == galaxy &&
			targetsystem == system &&
			targetplanet == planet && targetplanettype == planettype) {
			inSpeedLimit = isInSpeedLimit(flightTime(thisgalaxy, thissystem, thisplanet, targetgalaxy, targetsystem, targetplanet, spd, speedfactor), time);
			if (inSpeedLimit == 2) {
				document.getElementById("union" + i).innerHTML = "<font color=\"lime\">" + string + "</font>";
			} else if (inSpeedLimit == 1) {
				document.getElementById("union" + i).innerHTML = "<font color=\"orange\">" + string + "</font>";
			} else {
				document.getElementById("union" + i).innerHTML = "<font color=\"red\">" + string + "</font>";
			}
		} else {
			document.getElementById("union" + i).innerHTML = "<font color=\"#00a0ff\">" + string + "</font>";
		}
	}
}


function isInSpeedLimit(flightlength, eventtime) {
	var time = new Date;
	time = Math.round(time / 1000);
	if (flightlength < (eventtime - time) * 1.5) {
		return 2;
	} else if (flightlength < (eventtime - time) * 1) {
		return 1;
	} else {
		return 0;
	}
}


function flightTime(galaxy, system, planet, targetgalaxy, targetsystem, targetplanet, spd, maxspeed, speedfactor) {
	if (galaxy - targetgalaxy != 0) {
		dist = Math.abs(galaxy - targetgalaxy) * 20000;
	} else if (system - targetsystem != 0) {
		dist = Math.abs(system - targetsystem) * 5 * 19 + 2700;
	} else if (planet - targetplanet != 0) {
		dist = Math.abs(planet - targetplanet) * 5 + 1000;
	} else {
		dist = 5;
	}
	return Math.round((35000 / spd * Math.sqrt(dist * 10 / maxspeed) + 10) / speedfactor);
}


function showCoords() {
	document.getElementsByName("speed")[0].disabled = false;
	document.getElementsByName("galaxy")[0].disabled = false;
	document.getElementsByName("system")[0].disabled = false;
	document.getElementsByName("planet")[0].disabled = false;
	document.getElementsByName("planettype")[0].disabled = false;
	document.getElementsByName("shortlinks")[0].disabled = false;
}


function hideCoords() {
	document.getElementsByName("speed")[0].disabled = true;
	document.getElementsByName("galaxy")[0].disabled = true;
	document.getElementsByName("system")[0].disabled = true;
	document.getElementsByName("planet")[0].disabled = true;
	document.getElementsByName("planettype")[0].disabled = true;
	document.getElementsByName("shortlinks")[0].disabled = true;
}


function showOrders() {
	document.getElementsByName("order")[0].disabled = false;
	return;
}


function hideOrders() {
	document.getElementsByName("order")[0].disabled = true;
}


function showResources() {
	document.getElementsByName("resource1")[0].disabled = false;
	document.getElementsByName("resource2")[0].disabled = false;
	document.getElementsByName("resource3")[0].disabled = false;
	document.getElementsByName("holdingtime")[0].disabled = false;
}


function hideResources() {
	document.getElementsByName("resource1")[0].disabled = true;
	document.getElementsByName("resource2")[0].disabled = true;
	document.getElementsByName("resource3")[0].disabled = true;
	document.getElementsByName("holdingtime")[0].disabled = true;
}


function setShips(s16, s17, s18, s19, s20, s21, s22, s23, s24, s25, s27, s28, s29, s30, s31, s32, s33) {
	setNumber("202", s16);
	setNumber("203", s17);
	setNumber("204", s18);
	setNumber("205", s19);
	setNumber("206", s20);
	setNumber("207", s21);
	setNumber("208", s22);
	setNumber("209", s23);
	setNumber("210", s24);
	setNumber("211", s25);
	setNumber("213", s27);
	setNumber("214", s28);
	setNumber("215", s29);
	setNumber("216", s30);
	setNumber("217", s31);
	setNumber("218", s32);
	setNumber("219", s33);
}


function setNumber(name, number) {
	if (typeof document.getElementsByName("ship" + name)[0] != "undefined") {
		document.getElementsByName("ship" + name)[0].value = number;
	}
}


function abs(a) {
	if (a < 0) {
		return - a;
	}
	return a;
}
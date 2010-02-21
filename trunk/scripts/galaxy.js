var ajax = new sack();
var strInfo = "";

function whenResponse () {
	retVals   = this.response.split("|");
	Message   = retVals[0];
	Infos     = retVals[1];
	retVals   = Infos.split(" ");
	UsedSlots = retVals[0];
	SpyProbes = retVals[1];
	Recyclers = retVals[2];
	Missiles  = retVals[3];
	retVals   = Message.split(";");
	CmdCode   = retVals[0];
	strInfo   = retVals[1];
	addToTable("done", "success");
	changeSlots( UsedSlots );
	setShips("probes", SpyProbes );
	setShips("recyclers", Recyclers );
	setShips("missiles", Missiles );
}
function doit (order, galaxy, system, planet, planettype, shipcount) {
	ajax.requestFile = "game.php?page=fleetajax";
	ajax.runResponse = whenResponse;
	ajax.execute = true;
	ajax.setVar("mission", order);
	ajax.setVar("galaxy", galaxy);
	ajax.setVar("system", system);
	ajax.setVar("planet", planet);
	ajax.setVar("planettype", planettype);
	if (order == 6)
		ajax.setVar("ship210", shipcount);
	if (order == 7) {
		ajax.setVar("ship208", 1);
		ajax.setVar("ship203", 2);
	}
	if (order == 8)
		ajax.setVar("ship209", shipcount);
	ajax.runAJAX();
}
function addToTable(strDataResult, strClass) {
	var e = document.getElementById('fleetstatusrow');
	var e2 = document.getElementById('fleetstatustable');
	e.style.display = '';
	if(e2.rows.length > 2) {
		e2.deleteRow(2);
	}
	var row = e2.insertRow(0);
	var td1 = document.createElement("td");
	var td1text = document.createTextNode(strInfo);
	td1.appendChild(td1text);
	var td2 = document.createElement("td");
	var span = document.createElement("span");
	var spantext = document.createTextNode(strDataResult);
	var spanclass = document.createAttribute("class");
	spanclass.nodeValue = strClass;
	span.setAttributeNode(spanclass);
	span.appendChild(spantext);
	td2.appendChild(span);
	row.appendChild(td1);
	row.appendChild(td2);
}
function changeSlots(slotsInUse) {
	$('#slots').text(slotsInUse);
}
function setShips(ship, count) {
	$('#'+ship).text(tsdpkt(count));
}

function galaxy_submit(value) {
	document.getElementById('auto').name = value;
	document.getElementById('galaxy_form').submit();
}
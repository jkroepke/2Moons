var ajax = new sack();
var strInfo = "";

function whenResponse () {
	retVals   	= this.response.split("|");
	Message   	= retVals[0];
	Infos     	= retVals[1];
	retVals   	= Infos.split(" ");
	UsedSlots 	= retVals[0];
	SpyProbes 	= retVals[1];
	Recyclers 	= retVals[2];
	GRecyclers	= retVals[3];
	Missiles  	= retVals[4];
	retVals  	= Message.split(";");
	CmdCode  	= retVals[0];
	strInfo  	= retVals[1];
	if(CmdCode == 600)
		addToTable(status_ok, "success");
	else
		addToTable(status_fail, "error");
	
	changeSlots(UsedSlots);
	setShips("probes", SpyProbes );
	setShips("recyclers", Recyclers );
	setShips("grecyclers", GRecyclers );
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
	ajax.setVar("ships", shipcount);
	ajax.setVar("ships", shipcount);
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
function changeSlots(add) {
	$('#slots').text(add);
}
function setShips(ship, count) {
	$('#'+ship).text(number_format(count));
}

function galaxy_submit(value) {
	document.getElementById('auto').name = value;
	document.getElementById('galaxy_form').submit();
}
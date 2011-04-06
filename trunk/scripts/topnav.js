//topnav.js
//RealTimeRessisanzeige for 2Moons
// @version 1.0
// @copyright 2010 by ShadoX

function resourceTicker(config) {
	var element	= document.getElementById(config.valueElem);
	var localTime = new Date().getTime();
	var nrResource = Math.round(config.available + config.production / 3600 * (localTime - startTime) / 1000);
	if (nrResource < config.limit[1]) 
	{
		if (nrResource >= config.limit[1])
			element.className = element.className+" res_current_max";
		else if (nrResource >= config.limit[1] * 0.9)
			element.className = element.className+" res_current_warn";
			
		element.innerHTML	= NumberGetHumanReadable(nrResource);
		window.setTimeout(function(){resourceTicker(config)}, 1000);
	} else {
		element.className = element.className+" res_current_max";
	}
}
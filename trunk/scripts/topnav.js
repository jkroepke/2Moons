//topnav.js
//RealTimeRessisanzeige for 2Moons
// @version 1.0
// @copyright 2010 by ShadoX

function resourceTicker(config, init) {
	if(typeof init !== "undefined" && init === true)
		window.setInterval(function(){resourceTicker(config)}, 1000);
		
	var element	= document.getElementById(config.valueElem);
	var nrResource = Math.round(config.available + config.production / 3600 * (serverTime.getTime() - startTime) / 1000);
	if (nrResource < config.limit[1]) 
	{
		if (nrResource >= config.limit[1])
			element.className = element.className+" res_current_max";
		else if (nrResource >= config.limit[1] * 0.9)
			element.className = element.className+" res_current_warn";
			
		element.innerHTML	= shortly_number(nrResource);
		element.name		= NumberGetHumanReadable(nrResource);
	} else {
		element.className = element.className+" res_current_max";
	}
}
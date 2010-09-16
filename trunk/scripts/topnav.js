//topnav.js
//RealTimeRessisanzeige for 2Moons
// @version 1.0
// @copyright 2010 by ShadoX

function resourceTicker(config) {
    
    var thisObj = this;
    thisObj.config = config; 
    thisObj.htmlObj = document.getElementById(thisObj.config.valueElem);
    
    var localTime = new Date();
    thisObj.startTime = localTime.getTime();
    
    thisObj.updateResource = function() {
        var localTime = new Date().getTime(); 
        nrResource = thisObj.config.available + thisObj.config.production / 3600 * (localTime-thisObj.startTime)/1000 ;
        nrResource = Math.max(0, Math.round(nrResource));

        if (nrResource < thisObj.config.available || nrResource >= thisObj.config.available && nrResource < thisObj.config.limit[1]) 
        {
            nrResource = NumberGetHumanReadable(nrResource);
            thisObj.htmlObj.innerHTML = nrResource;
            
	        if (nrResource >= thisObj.config.limit[1]) {
	            thisObj.htmlObj.className = "res_current_max";
	        } else if (nrResource >= thisObj.config.limit[1] * 0.9 && nrResource < thisObj.config.limit[1]) {
	            thisObj.htmlObj.className = "res_current";
	        } 
        }
    }
    
    if(config.intervalObj) {
    	timerHandler.removeCallback(config.intervalObj);
    }

	config.intervalObj = timerHandler.appendCallback(thisObj.updateResource);
}

function initRessource() {
	document.getElementById('current_metal').innerHTML = NumberGetHumanReadable(resourceTickerMetal.available);
	document.getElementById('current_crystal').innerHTML = NumberGetHumanReadable(resourceTickerCrystal.available);
	document.getElementById('current_deuterium').innerHTML = NumberGetHumanReadable(resourceTickerDeuterium.available);
	if(resourceTickerMetal.limit[1] < resourceTickerMetal.available)
		document.getElementById('current_metal').className = 'header res_current res_current_max';
	if(resourceTickerCrystal.limit[1] < resourceTickerCrystal.available)
		document.getElementById('current_crystal').className = 'header res_current res_current_max';
	if(resourceTickerDeuterium.limit[1] < resourceTickerDeuterium.available)
		document.getElementById('current_deuterium').className = 'header res_current res_current_max';
	
}
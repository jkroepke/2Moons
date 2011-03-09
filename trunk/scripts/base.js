function number_format(number, decimals, dec_point, thousands_sep) {
	dec_point = LocalizationStrings['decimalPoint'];
	thousands_sep = LocalizationStrings['thousandSeperator'];
	var exponent = "";
	var numberstr = number.toString();
	var eindex = numberstr.indexOf("e");
	if (eindex > -1) {
		exponent = numberstr.substring(eindex);
		number = parseFloat(numberstr.substring(0, eindex));
	}
	var sign = number < 0 ? "-" : "";
	var integer = number;
	var fractional = number.toString().substring(integer.length + sign.length);
	dec_point = dec_point != null ? dec_point : ".";
	fractional = decimals != null && decimals > 0 || fractional.length > 1 ? (dec_point + fractional.substring(1)) : "";
	if (decimals != null && decimals > 0) {
		for (i = fractional.length - 1, z = decimals; i < z; ++i) 
			fractional += "0";
	}
	thousands_sep = (thousands_sep != dec_point || fractional.length == 0) ? thousands_sep : null;
	if (thousands_sep != null && thousands_sep != "") {
		for (i = integer.length - 3; i > 0; i -= 3) 
			integer = integer.substring(0, i) + thousands_sep + integer.substring(i);
	}
	return sign + integer + fractional + exponent;
}
function NumberGetHumanReadable(value) {
	return number_format(removeE(Math.floor(value)), 0, LocalizationStrings['decimalPoint'], LocalizationStrings['thousandSeperator']);
}
function removeE(Number) {
	Number = String(Number);
	if (Number.search(/e\+/) == -1) 
		return Number;
	var e = parseInt(Number.replace(/\S+.?e\+/g, ''));
	if (isNaN(e) || e == 0) 
		return Number;
	else if ($.browser.webkit) 
		return parseFloat(Number).toPrecision(Math.min(e + 1, 21));
	else 
		return parseFloat(Number).toPrecision(e + 1);
}
var days = new Array('Sun', 'Mon', 'Tus', 'Wed', 'Thu', 'Fri', 'Sat');
var months = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
function getFormatedDate(timestamp, format) {
	var currTime = new Date();
	currTime.setTime(timestamp);
	str = format;
	str = str.replace('[d]', dezInt(currTime.getDate(), 2));
	str = str.replace('[D]', days[currTime.getDay()]);
	str = str.replace('[m]', dezInt(currTime.getMonth() + 1, 2));
	str = str.replace('[M]', months[currTime.getMonth()]);
	str = str.replace('[j]', parseInt(currTime.getDate()));
	str = str.replace('[Y]', currTime.getFullYear());
	str = str.replace('[y]', currTime.getFullYear().toString().substr(2, 4));
	str = str.replace('[G]', currTime.getHours());
	str = str.replace('[H]', dezInt(currTime.getHours(), 2));
	str = str.replace('[i]', dezInt(currTime.getMinutes(), 2));
	str = str.replace('[s]', dezInt(currTime.getSeconds(), 2));
	return str;
}
function dezInt(num, size, prefix) {
	prefix = (prefix) ? prefix : "0";
	var minus = (num < 0) ? "-" : "", 
	result = (prefix == "0") ? minus : "";
	num = Math.abs(parseInt(num, 10));
	size -= ("" + num).length;
	for (var i = 1; i <= size; i++) {
		result += "" + prefix;
	}
	result += ((prefix != "0") ? minus : "") + num;
	return result;
}
function getFormatedTime(time) {
	hours = Math.floor(time / 3600);
	timeleft = time % 3600;
	minutes = Math.floor(timeleft / 60);
	timeleft = timeleft % 60;
	seconds = timeleft;
	return dezInt(hours, 2) + ":" + dezInt(minutes, 2) + ":" + dezInt(seconds, 2);
}
var TimerHandler = function (interval, autostart) {
	if (typeof(interval) == 'undefined') {
		interval = 1000;
	}
	this._interval = interval;
	this._callbacks = new Array();
	this._intervalId = null;
	if (autostart != false) {
		this.startTimer();
	}
}
TimerHandler.prototype.appendCallback = function (method) {
	var index = this._callbacks.length;
	this._callbacks[this._callbacks.length] = method;
	return index;
}
TimerHandler.prototype.removeCallback = function (index) {
	this._callbacks[index] = null;
}
TimerHandler.prototype.startTimer = function () {
	var instance = this;
	this._intervalId = window.setInterval(function () {
			instance._timer();
		}, this._interval);
}
TimerHandler.prototype.stopTimer = function () {
	window.clearInterval(this._intervalId);
}
TimerHandler.prototype._timer = function () {
	for (var i = 0; i < this._callbacks.length; i++) {
		if (this._callbacks[i] != null) {
			this._callbacks[i]();
		}
	}
}
function GetRestTimeFormat(Secs) {
	var s = Secs;
	var m = 0;
	var h = 0;
	if (s > 59) {
		m = Math.floor(s / 60);
		s = s - m * 60;
	}
	if (m > 59) {
		h = Math.floor(m / 60);
		m = m - h * 60;
	}
	return dezInt(h, 2) + ':' + dezInt(m, 2) + ":" + dezInt(s, 2);
}

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

function tooltip(dom, content) {
     $(dom).aToolTip({  
         clickIt: true,  
         tipContent: content  
     }); 
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
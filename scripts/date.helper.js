var days = new Array('Sun', 'Mon', 'Tus', 'Wed', 'Thu', 'Fri', 'Sat');
var months = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

function getFormatedDate(timestamp, format) {
    var currTime = new Date();
    currTime.setTime(timestamp);
    str = format;
    str = str.replace('[d]', dezInt(currTime.getDate(),2));
    str = str.replace('[D]', days[currTime.getDay()]);  
    str = str.replace('[m]', dezInt(currTime.getMonth()+1,2));
    str = str.replace('[M]', months[currTime.getMonth()]);
    str = str.replace('[j]', parseInt(currTime.getDate()));
    str = str.replace('[Y]', currTime.getFullYear());
    str = str.replace('[y]', currTime.getFullYear().toString().substr(2,4));
    str = str.replace('[G]', currTime.getHours());
    str = str.replace('[H]', dezInt(currTime.getHours(), 2));
    str = str.replace('[i]', dezInt(currTime.getMinutes(), 2));
    str = str.replace('[s]', dezInt(currTime.getSeconds(), 2));
    return str;
}

function dezInt(num,size,prefix) {
	prefix=(prefix)?prefix:"0";
	var minus=(num<0)?"-":"",
	    result=(prefix=="0")?minus:"";
	num=Math.abs(parseInt(num,10));
	size-=(""+num).length;
	for(var i=1;i<=size;i++) {
		result+=""+prefix;
	}
	result+=((prefix!="0")?minus:"")+num;
	return result;
}	

function getFormatedTime(time)
{
	hours =	Math.floor(time / 3600);
	timeleft = time % 3600;
		
	minutes = Math.floor(timeleft / 60);
	timeleft = timeleft % 60;
	
	seconds = timeleft;

	return dezInt(hours,2)+":"+dezInt(minutes,2)+":"+dezInt(seconds,2);
}
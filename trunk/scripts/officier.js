function GetOfficerTime(Element, Time)
{
	if(Time == 0)
		return;
	
	$('#time_'+Element).text(GetRestTimeFormat(Time));
	Time--;
	window.setTimeout("GetOfficerTime("+Element+", "+Time+")", 1000)
}
function updateVars()
{	
	var ID 	= $('#id').val();
	$('#img').attr('src', $('#img').attr('name')+ID+'.gif');
	$('#metal').text(NumberGetHumanReadable(CostInfo[ID][1] * (1 - Charge / 100)));
	$('#crystal').text(NumberGetHumanReadable(CostInfo[ID][2] * (1 - Charge / 100)));
	$('#deuterium').text(NumberGetHumanReadable(CostInfo[ID][3] * (1 - Charge / 100)));
	$('#darkmatter').text(NumberGetHumanReadable(CostInfo[ID][4] * (1 - Charge / 100)));
	Reset();
}

function MaxShips()
{
	$('#count').val(CostInfo[$('#id').val()][0]);
	Total();
}

function Total()
{
	var Count	= $('#count').val();
	if(isNaN(Count) || Count < 0) {
		$('#count').val(0);
		Count = 0;
	}
	var ID 	= $('#id').val();
	$('#total_metal').text(NumberGetHumanReadable(CostInfo[ID][1] * Count * (1 - Charge / 100)));
	$('#total_crystal').text(NumberGetHumanReadable(CostInfo[ID][2] * Count * (1 - Charge / 100)));
	$('#total_deuterium').text(NumberGetHumanReadable(CostInfo[ID][3] * Count * (1 - Charge / 100)));
	$('#total_darkmatter').text(NumberGetHumanReadable(CostInfo[ID][4] * Count * (1 - Charge / 100)));
}

function Reset()
{
	$('#count').val(0);
	$('#total_metal').text(0);
	$('#total_crystal').text(0);
	$('#total_deuterium').text(0);
	$('#total_darkmatter').text(0);
}
$(document).ready(function() {
	$('#charge').text(Charge + "%");
});
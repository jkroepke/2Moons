function updateVars()
{	
	var shipID 	= $('#shipID').val();
	$('#img').attr('src', $('#img').data('src')+shipID+'.gif');
	$('#metal').text(NumberGetHumanReadable(CostInfo[shipID][2][901] * (1 - Charge / 100)));
	$('#crystal').text(NumberGetHumanReadable(CostInfo[shipID][2][902] * (1 - Charge / 100)));
	$('#deuterium').text(NumberGetHumanReadable(CostInfo[shipID][2][903] * (1 - Charge / 100)));
	$('#darkmatter').text(NumberGetHumanReadable(CostInfo[shipID][2][921] * (1 - Charge / 100)));
	$('#traderHead').text(CostInfo[shipID][1]);
	Reset();
}

function MaxShips()
{
	var shipID 	= $('#shipID').val();
	$('#count').val(CostInfo[shipID][0]);
	Total();
}

function Total()
{
	var Count	= $('#count').val();
	
	if(isNaN(Count) || Count < 0) {
		$('#count').val(0);
		Count = 0;
	}
	
	var shipID 	= $('#shipID').val();
	$('#total_metal').text(NumberGetHumanReadable(CostInfo[shipID][2][901] * Count * (1 - Charge / 100)));
	$('#total_crystal').text(NumberGetHumanReadable(CostInfo[shipID][2][902] * Count * (1 - Charge / 100)));
	$('#total_deuterium').text(NumberGetHumanReadable(CostInfo[shipID][2][903] * Count * (1 - Charge / 100)));
	$('#total_darkmatter').text(NumberGetHumanReadable(CostInfo[shipID][2][921] * Count * (1 - Charge / 100)));
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
	updateVars();
});
function changeDetail()
{	
	var shipId 	= $('#shipId').val();
	$('#img').attr('src', function() {
        return $(this).data('src')+shipId+'.gif'
    });
	$('.fleetDetail').hide();
    $('#element'+shipID).show();
}

function MaxShips()
{
	var shipId 	= $('#shipId').val();
	$('#count').val(elementData[shipId]['available']);
    calcTotalResource()
}

function calcTotalResource()
{
	var Count	= $('#count').val();
	
	if(isNaN(Count) || Count < 0) {
		$('#count').val(0);
		Count = 0;
	}
	
	var shipId 	= $('#shipId').val();
    $('.resourceTotal').each(function() {
        var text = elementData[shipId]['price'][$(this).data('id')] * Count * (1 - Charge / 100);

        $(this).text(text);
    });
}

function Reset()
{
	$('#count').val(0);
    $('.resourceTotal').each(function() {
        $(this).text(0);
    });
}
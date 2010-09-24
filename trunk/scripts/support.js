function ShowTicket(i) {
	if(i == 0){ $('#newbutton:visible').slideUp(500);$('#new:hidden').slideDown(500); }
	if(i != 0){ $('#newbutton:hidden').slideDown(500);$('#new:visible').slideUp(500); }

	$('.tickets:visible').slideUp(500);
	$('#'+i).slideDown(500);
	return false;
}
function calcul(ress) 
{
	switch(ress)
	{
		case 'metal':
			var Crystal   = $("#crystal").val();
			var Deuterium = $("#deuterium").val();

			var Metal = Crystal * res_a + Deuterium * res_b;

			if (isNaN(Metal))
				$("#metal").text(0);
			else 
				$("#metal").text(NumberGetHumanReadable(Metal));
		break;
		case 'crystal':
			var Metal   = $("#metal").val();
			var Deuterium = $("#deuterium").val();

			var Crystal = Metal * res_a + Deuterium * res_b;

			if (isNaN(Crystal))
				$("#crystal").text(0);
			else 
				$("#crystal").text(NumberGetHumanReadable(Crystal));
		break;
		case 'deuterium':
			var Metal   = $("#metal").val();
			var Crystal = $("#crystal").val();

			var Deuterium = Metal * res_a + Crystal * res_b;

			if (isNaN(Deuterium))
				$("#deuterium").text(0);
			else 
				$("#deuterium").text(NumberGetHumanReadable(Deuterium));
		break;
	}
}
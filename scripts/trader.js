function calcul(ress) 
{
	switch(ress)
	{
		case 'metal':
			var Crystal   = $("#crystal").val();
			var Deuterium = $("#deuterium").val();

			var Metal = Crystal * res_a + Deuterium * res_b;

			if (isNaN(Metal)) {
				$("#metal").text("Nur Nummern");
			}
			else 
				$("#metal").text(Metal);
		break;
		case 'crystal':
			var Metal   = $("#metal").val();
			var Deuterium = $("#deuterium").val();

			var Crystal = Metal * res_a + Deuterium * res_b;

			if (isNaN(Crystal))
				$("#crystal").text("Nur Nummern");
			else 
				$("#crystal").text(Crystal);
		break;
		case 'deuterium':
			var Metal   = $("#metal").val();
			var Cristal = $("#crystal").val();

			var Deuterium = Metal * res_a + Cristal * res_b;

			if (isNaN(Deuterium))
				$("#deuterium").text("Nur Nummern");
			else 
				$("#deuterium").text(Deuterium);
		break;
	}
}
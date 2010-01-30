function calcul(ress) 
{
	switch(ress)
	{
		case 'metal':
			var Cristal = document.forms['trader'].elements['cristal'].value;
			var Deuterium = document.forms['trader'].elements['deut'].value;

			Cristal   = Cristal * {$mod_ma_res_a};
			Deuterium = Deuterium * {$mod_ma_res_b};

			var Metal = Cristal + Deuterium;
			document.getElementById("met").innerHTML = Metal;

			if (isNaN(document.forms['trader'].elements['cristal'].value)) {
				document.getElementById("met").innerHTML = "Sólo números";
			}
			if (isNaN(document.forms['trader'].elements['deut'].value)) {
				document.getElementById("met").innerHTML = "Sólo números";
			}
		break;
		case 'crystal':
			var Metal = document.forms['trader'].elements['metal'].value;
			var Deuterium = document.forms['trader'].elements['deut'].value;

			Metal = Metal * {mod_ma_res_a};
			Deuterium = Deuterium * {mod_ma_res_b};

			var Cristal = Metal + Deuterium;
			document.getElementById("cristal").innerHTML=Cristal;

			if (isNaN(document.forms['trader'].elements['metal'].value)) {
				document.getElementById("cristal").innerHTML="Sólo números";
			}
			if (isNaN(document.forms['trader'].elements['deut'].value)) {
				document.getElementById("cristal").innerHTML="Sólo números";
			}
		break;
		case 'deu':
			var Metal   = document.forms['trader'].elements['metal'].value;
			var Cristal = document.forms['trader'].elements['cristal'].value;

			Metal   = Metal * {mod_ma_res_a};
			Cristal = Cristal * {mod_ma_res_b};

			var Deuterium = Metal + Cristal;
			document.getElementById("deuterio").innerHTML=Deuterium;

			if (isNaN(document.forms['trader'].elements['metal'].value)) {
				document.getElementById("deuterio").innerHTML="Sólo números";
			}
			if (isNaN(document.forms['trader'].elements['cristal'].value)) {
				document.getElementById("deuterio").innerHTML="Sólo números";
			}
		break;
	}
}
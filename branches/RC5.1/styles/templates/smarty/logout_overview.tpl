{include file="overall_header.tpl"}
<script type="text/javascript">
    var second = 5;

    function Init() {
        document.getElementById("CompteARebours").innerHTML = second;
        setInterval(AffichageCompteARebours,1000);
    }
    function AffichageCompteARebours() {
		if (document.getElementById("CompteARebours").innerHTML == 2){
			window.location.href='./index.php';
		}
		document.getElementById("CompteARebours").innerHTML = --second;
    }
    window.onload = function () { Init(); }
 </script>
			<table width="519" align="center">
				<tr>
					<td class="c">Logout erfolgreich! Bis bald!</td>
					</tr>
				<tr>
					<th class="errormessage">Session wurde beendet.</th>
				</tr>
			</table>
			<br><br>
			<table width="519" align="center">
			<tr>
				<td class="c">Weiterleitung</td>
			</tr>
			<tr>
			<th class="errormessage">Sie werden in <span id="CompteARebours"></span> s weitergeleitet.<br /><a href="./index.php">Klicken Sie hier, um nicht zu warten</a></th>
				</tr>
			</table>
{include file="overall_footer.tpl"}
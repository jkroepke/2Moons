{include file="overall_header.tpl"}
<table class="table519">
	<tr>
		<th>Logout erfolgreich! Bis bald!</th>
		</tr>
	<tr>
		<td>Session wurde beendet.</td>
	</tr>
</table>
<br><br>
<table class="table519">
<tr>
	<th>Weiterleitung</th>
</tr>
<tr>
	<td>Sie werden in <span id="seconds">5</span> s weitergeleitet.<br /><a href="./index.php">Klicken Sie hier, um nicht zu warten</a></td>
</tr>
</table>
<script type="text/javascript">
    var second = 5;
	function Countdown(){
		if(second == 0)
			return;
			
		second--;
		$('#seconds').text(second);
	}
	window.setTimeout("window.location.href='./index.php';", 5000);
	window.setInterval("Countdown()", 1000);
</script>
{include file="overall_footer.tpl"}
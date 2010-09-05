{include file="overall_header.tpl"}
<table class="table519">
	<tr>
		<th>{$lo_title}</th>
		</tr>
	<tr>
		<td>{$lo_logout}</td>
	</tr>
</table>
<br><br>
<table class="table519">
<tr>
	<th>{$lo_redirect}</th>
</tr>
<tr>
	<td>{$lo_notify}<br><a href="./index.php">{$lo_continue}</a></td>
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
	window.setTimeout("window.location.href='./index.php'", 5000);
	window.setInterval("Countdown()", 1000);
</script>
{include file="overall_footer.tpl"}
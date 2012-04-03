{block name="title" prepend}{$LNG.lm_logout}{/block}
{block name="content"}<table class="table519">
	<tr>
		<th>{$LNG.lo_title}</th>
		</tr>
	<tr>
		<td>{$LNG.lo_logout}</td>
	</tr>
</table>
<br><br>
<table class="table519">
<tr>
	<th>{$LNG.lo_redirect}</th>
</tr>
<tr>
	<td>{$LNG.lo_notify}<br><a href="./index.php">{$LNG.lo_continue}</a></td>
</tr>
</table>
{/block}
{block name="script" append}
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
{/block}
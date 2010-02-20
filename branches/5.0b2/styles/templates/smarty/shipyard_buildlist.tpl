{$bd_actual_production} <div id="bx" class="z"></div>
<script type="text/javascript">
	hanger_id		= {$b_hangar_id_plus};
	ready			= '{$bd_completed}';
	bd_operating	= '{$bd_operating}';
	c  				= new Array({$c}'');
	b  				= new Array({$b}'');
	a  				= new Array({$a}'');
	window.onload 	= t;
</script>
<br>
<form name="Atr" method="POST" action="">
<input type="hidden" name="mode" value="fleet">
<input type="hidden" name="action" value="delete">
<table width="40%" align="center">
<tr>
	<td class="c">{$work_todo}</td>
</tr>
<tr>
	<th><select name="auftr[]" id="auftr" size="10"><option>&nbsp;</option></select><br><br>{$bd_cancel_warning}<br><input type="Submit" value="{$bd_cancel_send}"></th>
</tr>
<tr>
	<td class="c"></td>
</tr>
</table>
</form>
<br>
{$total_left_time} {$pretty_time_b_hangar}
<br>
<br>
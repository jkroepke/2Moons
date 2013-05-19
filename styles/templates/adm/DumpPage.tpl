{include file="overall_header.tpl"}
<form action="admin.php?page=dump" method="post">
<input type="hidden" name="action" value="dump">
<table class="table569">
	<tr>
		<th colspan="2">{$LNG.du_header}</th>
	</tr>
	<tr>
		<td>{$LNG.du_choose_tables}</td>
		<td><input type="checkbox" id="selectAll">{$LNG.du_select_all_tables}<br>{html_options multiple="multiple" style="width:250px" size="10" name="dbtables[]" id="dbtables" values=$dumpData.sqlTables output=$dumpData.sqlTables}</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="{$LNG.du_submit}"></td>
	</tr>
</table>
</form>
<script>
$(function() {
	$('#selectAll').on('click', function() {
		if($('#selectAll').prop('checked') === true)
		{
			$('#dbtables').val(function() {
				return $(this).children().map(function() { 
					return $(this).attr('value');
				}).toArray();
			});
		}
		else
		{
			$('#dbtables').val(null);
		}
	});
});
</script>
{include file="overall_footer.tpl"}
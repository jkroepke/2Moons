{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
    <form id="trader" action="" method="post">
		<input type="hidden" name="ress" value="{$smarty.post.ress|htmlspecialchars}">
		<input type="hidden" name="action" value="trade">
		<table class="table569">
		<tr>
			<th colspan="3">{lang}tr_sell{/lang} {$ress}</th>
		</tr><tr>
			<td>{lang}tr_resource{/lang}</td>
			<td>{lang}tr_amount{/lang}</td>
			<td>{lang}tr_quota_exchange{/lang}</td>
		</tr><tr>
			<td>{$ress}</td>
			<td><span id="ress">0</span></td>
			<td>1</td>
		</tr><tr>
			<td>{$ress1}</td>
			<td><input name="ress1" id="ress1" type="text" value="0" size="30"></td>
			<td>{$ress1_charge}</td>
		</tr><tr>
			<td>{$ress2}</td>
			<td><input name="ress2" id="ress2" type="text" value="0" size="30"></td>
			<td>{$ress2_charge}</td>
		</tr><tr>
			<td colspan="3"><input type="submit" value="{lang}tr_exchange{/lang}"></td>
		</tr>
		</table>
    </form>
	<script type="text/javascript">
	var ress1charge = {$ress1_charge};
	var ress2charge = {$ress2_charge};
	</script>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}
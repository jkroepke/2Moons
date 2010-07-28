{include file="adm/overall_header.tpl"}
<center>
<table width="500">
<tr>
    <td class="c" colspan="3">{$mod_module}</td>
</tr>
<tr>
    <th colspan="3"><strong>{$mod_info}</strong></th>
</tr>
{foreach key=ID item=Info from=$Modules}
<tr>
	<th>{$Info.name}</th>
	{if $Info.state == 1}
		<th style="color:green"><b>{$mod_active}</b></th>
		<th><a href="?page=module&amp;mode=deaktiv&amp;id={$ID}">{$mod_change_deactive}</a></th>
	{else}
		<th style="color:red"><b>{$mod_deactive}</b></th>
		<th><a href="?page=module&amp;mode=aktiv&amp;id={$ID}">{$mod_change_active}</a></th>
	{/if}
	</tr>
{/foreach}
</table>
</center>
{include file="adm/overall_footer.tpl"}
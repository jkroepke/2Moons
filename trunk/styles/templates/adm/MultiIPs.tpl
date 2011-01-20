{include file="adm/overall_header.tpl"}
<table style="width:569px">
<tr><th>{$mip_ip}</th><th>{$mip_user}</th>
{foreach $IPs as $IP => $Users}
<tr>
<td>{$IP}</td>
<td>{foreach $Users as $User}
{$User[0]} (ID: {$User[1]})<br>
{/foreach}
</td>
</tr>
{/foreach}
</table>
{include file="adm/overall_footer.tpl"}
{include file="overall_header.tpl"}
{foreach item=Mod from=$MVC}
<table width="60%">
    <tr>
		<th colspan="2">{$Mod.title}</th>
    </tr>
    <tr>
		<td>{$mvc_title}:</td><td>{$Mod.title}</td>
    </tr>
    <tr>
		<td>{$mvc_author}:</td><td>{$Mod.author}</td>
    </tr>
    <tr>
		<td>{$mvc_version}:</td><td>{$Mod.version}</td>
    </tr>
    <tr>
		<td>{$mvc_link}:</td><td><a href="{$Mod.link}" target="_blank">{$Mod.link}</a></td>
    </tr>
    <tr>
		<td>{$mvc_desc}:</td><td>{$Mod.description}</td>
    </tr>
    <tr>
		<td colspan="2">{$Mod.update}</td>
    </tr>
	{if $Mod.udetails}
	<tr>
		<td>{$mvc_update_version}:</td><td>{$Mod.udetails.version}</td>
    </tr>
	<tr>
		<td>{$mvc_update_date}:</td><td>{$Mod.udetails.date}</td>
    </tr>
    <tr>
		<td>{$mvc_download}:</td><td><a href="{$Mod.udetails.download}" target="_blank">{$Mod.udetails.download}</a></td>
	</tr>
    <tr>
		<td>{$mvc_announcement}:</td><td><a href="{$Mod.udetails.announcement}" target="_blank">{$Mod.udetails.announcement}</a></td>
    </tr>
	{/if}
</table>
<br><br>
{/foreach}
{include file="overall_footer.tpl"}
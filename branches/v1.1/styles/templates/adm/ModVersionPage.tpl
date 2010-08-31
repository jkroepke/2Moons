{include file="adm/overall_header.tpl"}
{foreach item=Mod from=$MVC}
<table width="60%">
    <tr>
		<td class="c" colspan="2">{$Mod.title}</td>
    </tr>
    <tr>
		<th>{$mvc_title}:</th><th>{$Mod.title}</th>
    </tr>
    <tr>
		<th>{$mvc_author}:</th><th>{$Mod.author}</th>
    </tr>
    <tr>
		<th>{$mvc_version}:</th><th>{$Mod.version}</th>
    </tr>
    <tr>
		<th>{$mvc_link}:</th><th><a href="{$Mod.link}" target="_blank">{$Mod.link}</a></th>
    </tr>
    <tr>
		<th>{$mvc_desc}:</th><th>{$Mod.description}</th>
    </tr>
    <tr>
		<th colspan="2">{$Mod.update}</th>
    </tr>
	{if $Mod.udetails}
	<tr>
		<th>{$mvc_update_version}:</th><th>{$Mod.udetails.version}</th>
    </tr>
	<tr>
		<th>{$mvc_update_date}:</th><th>{$Mod.udetails.date}</th>
    </tr>
    <tr>
		<th>{$mvc_download}:</th><th><a href="{$Mod.udetails.download}" target="_blank">{$Mod.udetails.download}</a></th>
	</tr>
    <tr>
		<th>{$mvc_announcement}:</th><th><a href="{$Mod.udetails.announcement}" target="_blank">{$Mod.udetails.announcement}</a></th>
    </tr>
	{/if}
</table>
<br><br>
{/foreach}
{include file="adm/overall_footer.tpl"}
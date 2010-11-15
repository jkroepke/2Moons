{include file="adm/overall_header.tpl"}
<center>
<form action="" method="post">
<table width="70%">
	<tr>
    	<td class="c">{$backup_system}</td>
    </tr>
    {if $erstellt != ""}
    <tr>
    	<th style="color:#093;">{$erstellt}</th>
    </tr>
    {/if}
    <tr>
    	<th><input type="submit" name="erstellen" value="{$neu_erstellen}"></th>
    </tr>
    <tr>
    	<td class="c">{$backup_datei}</td>
    </tr>
    <tr>
    	<th>{$files}</th>
    </tr>
</table>
</form>
</center>
{include file="adm/overall_footer.tpl"}